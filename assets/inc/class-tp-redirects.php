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

		if( 0 < count( $destination ) && isset( $destination[0]->destination ) && 0 < strlen( $destination[0]->destination ) )
			return trailingslashit( site_url() . $destination[0]->destination );

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

		add_action( 'admin_menu', array( $this, 'add_menu' ) );	
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * AJAX: Get redirects
	 *
	 * @return json Object data, containing HTML output
	 */
	function _get( $edit ) {
		global $wpdb;

		$replace = false;

		if( 'search' == $_POST['type'] ) {
			$term = esc_attr( $_POST['term'] );
			$replace = true;

			if( $term )
				$redirects = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "redirects WHERE source LIKE '%" . $term . "%' OR destination LIKE '%" . $term . "%'" );
			else
				$redirects = $this->get_redirects();

		} elseif( 'paged' == $_POST['type'] ) {

		}

		//Redirects > HTML
		ob_start();
		$this->display_redirects( $redirects );
		$output = ob_get_clean();

		wp_send_json( array(
			'replace' => $replace,
			'html'    => $output,
			'edit'    => $edit,
		) );
	}

	/**
	 * AJAX: Create redirect
	 *
	 * @return json Object data, containing HTML output
	 */
	function _create() {
		global $wpdb;

		$source = esc_attr( $_POST['source'] );

		if( $source )
			$redirect = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "redirects WHERE source = '" . $source . "'" );
		else
			die();

		if( 0 == count( $redirect ) )
			$redirect = $wpdb->query( "INSERT INTO " . $wpdb->prefix . "redirects VALUES( '" . $source . "', '' );");

		$_POST['type'] = 'search';
		$_POST['term'] = $source;

		$this->_get( $redirect['source'] );
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
			</p>
			
			<?php $this->display_redirect_table(); ?>

		</div>

		<?php
	}

	/**
	 * Show redirects table
	 */
	function display_redirect_table() {
		$redirects = $this->get_redirects();
		
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
					<a class="dashicons dashicons-no-alt tp-redirects-remove" title="<?php _e( 'Remove' ); ?>"></a>
				</td>

			</tr>

			<?php 
		}
	}

	/**
	 * Retrieve redirects
	 * 
	 * @return array
	 */
	function get_redirects() {
		global $wpdb;

		return $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "redirects LIMIT 0,50" );
	}

	/**
	 * Enqueue scripts
	 */
	function enqueue_scripts() {
		wp_enqueue_script( 'tp-redirects', get_template_directory_uri() . '/assets/js/tp-redirects/tp-redirects.js' );

		wp_localize_script( 'tp-redirects', 'TP_Redirects_Labels', array(
			'not_found'      => __( 'This redirect doesn\'t exist yet. Press &ldquo;Enter&rdquo; to create it.', 'tp' ),
			'create_confirm' => __( 'Are you sure you want to create this redirect?', 'tp' ),
			'edit_finish'    => __( 'Save', 'tp' ),
			'edit_dismiss'   => __( 'Dismiss', 'tp' ),
			'site_url'       => get_site_url(),
		) );
	}
} new TP_Manage_Redirects;
