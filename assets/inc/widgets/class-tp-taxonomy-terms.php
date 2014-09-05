<?php
/**
 * Taxonomy terms
 *
 * @package TrendPress
 * @subpackage Widgets
 */
class TP_Taxonomy_Terms extends WP_Widget {
	function TP_Taxonomy_Terms() {
		$this->WP_Widget( 'TP_Taxonomy_Terms', __( 'Term list', 'tp' ), array( 'description' => __( 'List of terms from a given taxonomy', 'tp' ) ) );
	}
	
	function form( $instance ) {
		$taxonomies = get_taxonomies( array(
			'public'   => true,
			'_builtin' => false,
		), 'objects' );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php _e( 'Title' ); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		
		<?php if( $taxonomies ) { ?>
			<p>
				<label>
					<strong><?php _e( 'Taxonomy' ); ?></strong><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>">
						<?php foreach( $taxonomies as $taxonomy ) { ?>
							<option <?php selected( $taxonomy->name, $instance['taxonomy'] ); ?> value="<?php echo $taxonomy->name; ?>"><?php echo $taxonomy->label; ?> (<?php echo $taxonomy->name; ?>)</option>
						<?php } ?>
					</select>
				</label>
			</p>
		<?php
		}
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		if( $terms = get_terms( $instance['taxonomy'] ) ) {
			echo $before_widget;
				echo $before_title . $instance['title'] . $after_title;
				?>

			    <div class="widget-inner">
					<ul class="term-list">
						<?php foreach( $terms as $term ) { ?>
							<li>
								<a href="<?php echo get_term_link( $term ); ?>">
									<?php echo $term->name; ?>
								</a>
							</li>
						<?php } ?>
					</ul>
			    </div>

				<?php
			echo $after_widget;
		}
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Taxonomy_Terms" );' ) );