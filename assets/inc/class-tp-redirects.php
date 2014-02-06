<?php
/**
 * Perform redirects and create the redirect table
 *
 * @package TrendPress
 * @subpackage Redirects
 */

class TP_Redirects {
	var $table = 'redirects';

	function __construct() {
		//Perform redirects
		add_action( '404_template', array( $this, 'maybe_redirect' ) );
		add_action( 'template_redirect', array( $this, 'maybe_redirect' ), 9 );

		//Create table
		add_action( 'after_switch_theme', array( $this, 'maybe_create_table' ) );
	}

	/**
	 * Maybe redirect someone to the right URL
	 */
	function get_maybe_redirect_url( $source ) {
		global $wpdb;

		/**
		 * Find the destination
		 */
		$source = str_replace( site_url(), '', $source );

		if( $source == end( explode( '.', $source ) ) ) //No extension (e.g. .html)
			$source = trailingslashit( $source );

		$destination = $wpdb->get_results( "SELECT * FROM wp_redirects WHERE source='" . $source . "'" );

		if( 0 < count( $destination ) && isset( $destination[0]->destination ) && 0 < strlen( $destination[0]->destination ) ) {
			$destination = $destination[0]->destination;

			if( $destination == end( explode( '.', $destination ) ) ) //No extension (e.g. .html)
				$destination = trailingslashit( $destination );
				
			if( filter_var( $destination, FILTER_VALIDATE_URL ) === false )
				return site_url() . $destination;
			else
				return $destination; //External
		}

		return false;
	}

	/**
	 * Maybe redirect
	 */
	function maybe_redirect( $template ) {
		global $wp;

		if( is_404() ) {
			$url = $this->get_maybe_redirect_url( home_url( $wp->request ) );

			if( $url ) {
				wp_redirect( $url, 301 );
				die();
			}
		}

		return $template;
	}

	/**
	 * Maybe create the redirects table if it doesn't yet exists
	 */
	function maybe_create_table() {
		global $wpdb;

		$table_name = $wpdb->prefix . $this->table;

		if( ! empty( $wpdb->charset ) )
			$charset_collate = "DEFAULT CHARACTER SET " . $wpdb->charset;

	    if( ! empty( $wpdb->collate ) )
	        $charset_collate .= " COLLATE " . $wpdb->collate;
		             
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
	        `source` varchar(255) NOT NULL DEFAULT '',
	        `destination` varchar(255) NOT NULL DEFAULT '',

	        PRIMARY KEY (`source`)
	    ) " . $charset_collate . ";";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
} new TP_Redirects;

/**
 * Manage redirects
 *
 * @package TrendPress
 * @subpackage Redirects
 */

class TP_Manage_Redirects {
	function __construct() {
		add_action( 'wp_ajax_tp_redirects_get', array( $this, '_get' ) );
		add_action( 'wp_ajax_tp_redirects_create', array( $this, '_create' ) );
		add_action( 'wp_ajax_tp_redirects_remove', array( $this, '_remove' ) );
		add_action( 'wp_ajax_tp_redirects_save', array( $this, '_save' ) );

		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * AJAX: Get redirects
	 *
	 * @return json Object data, containing HTML output
	 */
	function _get() {
		global $wpdb;

		$replace = false;

		if( 'search' == $_POST['type'] ) {
			$term = esc_attr( $_POST['term'] );
			$replace = true;

			if( $term ) {
				$redirects = $wpdb->get_results( "
					SELECT * FROM " . $wpdb->prefix . "redirects 
					WHERE source LIKE '%" . $term . "%' OR destination LIKE '%" . $term . "%'
					ORDER BY CASE
						WHEN (source LIKE '%" . $term . "%' AND destination LIKE '%" . $term . "%') THEN 1
						WHEN source LIKE '%" . $term . "%' THEN 2
						WHEN destination LIKE '%" . $term . "%' THEN 3
					END
				" );
			} else {
				$redirects = $this->get_redirects( 1 );
				$page = 1;
			}

		} elseif( 'paged' == $_POST['type'] ) {
			$page = intval( $_POST['page'] );
			$redirects = $this->get_redirects( $page );
		}

		if( $redirects ) {
			//Redirects > HTML
			ob_start();
			$this->display_redirects( $redirects );
			$output = ob_get_clean();
		}

		wp_send_json( array(
			'replace' => $replace,
			'html'    => $output,
			'page'    => $page,
		) );
	}

	/**
	 * AJAX: Create redirect
	 *
	 * @return json Object data, containing HTML output
	 */
	function _create() {
		global $wpdb;

		$source = $this->correct( $_POST['source'] );

		if( $source )
			$redirect = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "redirects WHERE source = '" . $source . "'" );
		else
			die();

		if( 0 == count( $redirect ) )
			$redirect = $wpdb->query( "INSERT INTO " . $wpdb->prefix . "redirects VALUES( '" . $source . "', '' );");

		$_POST['type'] = 'search';
		$_POST['term'] = $source;

		$this->_get();
	}

	/**
	 * AJAX: Save
	 *
	 * @return json Object data, containing HTML output
	 */
	function _save() {
		global $wpdb;

		$reference = esc_attr( $_POST['refSource'] );
		$source = $this->correct( $_POST['source'] );
		$destination = $this->correct( $_POST['destination'] );

		if( $reference )
			$wpdb->query( "UPDATE " . $wpdb->prefix . "redirects SET source = '" . $source . "', destination = '" . $destination . "' WHERE source = '" . $reference . "'" );

		//Retrieve new HTML
		$redirect = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix. "redirects WHERE source = '" . $source . "'" );
		
		ob_start();
		$this->display_redirects( $redirect );
		$output = ob_get_clean();

		wp_send_json( array(
			'html' => $output,
		) );
	}

	/**
	 * Correct url
	 * 
	 * @param  string $url 
	 * @return string
	 */
	function correct( $url ) {
		return str_replace( get_site_url(), '', esc_attr( $url ) );
	}

	/**
	 * AJAX: Remove redirect
	 */
	function _remove() {
		global $wpdb;

		$source = esc_attr( $_POST['source'] );
		$redirect = $wpdb->query( "DELETE FROM " . $wpdb->prefix . "redirects WHERE source = '" . $source . "'" );

		wp_send_json( array(
			'removed' => true,
		) );
	}

	/**
	 * Add admin menu
	 */
	function add_menu() {
		add_submenu_page( 'tools.php', __( 'Redirects', 'tp' ), __( 'Redirects', 'tp' ), apply_filters( 'tp_redirects_cap', 'publish_pages' ), 'tp-redirects', array( $this, 'manage' ) );
	}

	/**
	 * Manage redirects
	 */
	function manage() {
		?>
		
		<div class="wrap tp-redirects">

			<h2>
				<?php _e( 'Redirects', 'tp' ); ?>
			</h2>

			<p>
				<input type="text" id="tp-redirects-search" placeholder="<?php _e( 'Find or create redirect..', 'tp' ); ?>" />
				<input type="button" id="tp-redirects-add" class="button-primary" value="<?php _e( 'Add' ); ?>" />
			</p>
			
			<?php $this->display_redirect_table(); ?>

		</div>

		<?php
	}

	/**
	 * Show redirects table
	 */
	function display_redirect_table() {
		$redirects = $this->get_redirects( 1 );
		
		if( $redirects ) {
			?>
			
			<table class="tp-redirects-table widefat">

				<thead>

					<tr>

						<th>
							<?php _e( 'Source', 'tp' ); ?>
						</th>

						<th colspan="2">
							<?php _e( 'Destination', 'tp' ); ?>
						</th>

					</tr>

				</thead>

				<tbody>
					
					<?php $this->display_redirects( $redirects ); ?>

				</tbody>

				<tfoot>
					
					<tr class="tp-redirects-more">
					
						<td colspan="3">
							<span class="spinner"></span>
						</td>

					</tr>

				</tfoot>

			</table>

			<?php
		}
	}

	/**
	 * Show redirects
	 */
	function display_redirects( $redirects ) {
		foreach( $redirects as $i => $redirect ) { 
			?>

			<tr data-source="<?php echo $redirect->source; ?>" data-destination="<?php echo $redirect->destination; ?>" <?php if( $i % 2 ) echo 'class="alternate"'; ?>>

				<td class="source">
					<?php echo $redirect->source; ?>
				</td>

				<td class="destination">
					<?php echo $redirect->destination; ?>
				</td>

				<td class="actions">
					<a class="dashicons dashicons-edit tp-redirects-edit" title="<?php _e( 'Edit' ); ?>"></a>
					<a class="dashicons dashicons-post-trash tp-redirects-remove" title="<?php _e( 'Remove' ); ?>"></a>
				</td>

			</tr>

			<?php 
		}
	}

	/**
	 * Retrieve redirects
	 * 
	 * @param int $page
	 * @param int $to_page Maybe we want to return data for multiple pages
	 * @return array
	 */
	function get_redirects( $page, $to_page = null ) {
		global $wpdb;

		$limit = '0,100';

		if( 1 < $page )
			$limit = ( ( $page - 1 ) * 100 ) . ',100';

		return $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "redirects LIMIT " . $limit );
	}

	/**
	 * Enqueue scripts
	 */
	function enqueue_scripts() {
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );

		wp_enqueue_script( 'tp-redirects', get_template_directory_uri() . '/assets/js/tp-redirects/tp-redirects.js' );

		wp_localize_script( 'tp-redirects', 'TP_Redirects_Labels', array(
			'not_found'      => __( 'This redirect doesn\'t exist yet. Press &ldquo;Enter&rdquo; to create it.', 'tp' ),
			'delete_confirm' => __( 'Are you sure you want to delete this redirect?', 'tp' ),
			'edit_finish'    => __( 'Save', 'tp' ),
			'edit_dismiss'   => __( 'Dismiss', 'tp' ),
			'site_url'       => get_site_url(),
		) );

		/**
		 * Add pointers
		 */
		$dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

		$pointers = array(
			'tp-redirects-search' => array(
				'element'         => '#tp-redirects-search',
				'header'          => __( '“Enter” to create', 'tp' ),
				'text'            => __( 'Press “Enter” to create or edit the redirect you\'re searching for.', 'tp' ),
			),
		);

		foreach( $pointers as $pointer => $settings ) {
			if( in_array( $pointer, $dismissed ) )
				unset( $pointers[ $pointer ] );
		}

		wp_localize_script( 'tp-redirects', 'TP_Redirects_Pointers', $pointers );
	}
} new TP_Manage_Redirects;
