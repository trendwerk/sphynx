<?php
/**
 * Post type posts
 *
 * @package TrendPress
 * @subpackage Widgets
 */
class TP_Post_Type_Posts extends WP_Widget {
	function TP_Post_Type_Posts() {
		$this->WP_Widget( 'TP_Post_Type_Posts', __( 'Post type posts', 'tp' ), array( 'description' => __( 'List of posts from a given post type', 'tp' ) ) );
	}
	
	function form( $instance ) {
		$post_types = get_post_types( array(
			'public'   => true,
			'_builtin' => false,
		), 'objects' );

		if( 0 < count( $post_types ) ) { 
			?>

			<p>
				<label>

					<strong><?php _e( 'Post type' ); ?></strong>

					<select class="widefat" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
						<?php foreach( $post_types as $post_type ) { ?>
							<option <?php selected( $post_type->name, $instance['post_type'] ); ?> value="<?php echo $post_type->name; ?>">
								<?php echo $post_type->labels->name; ?>
							</option>
						<?php } ?>
					</select>

				</label>
			</p>

			<?php 
		}
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$post_type = get_post_type_object( $instance['post_type'] );

		$post_type_posts = new WP_Query( array(
			'post_type'      => $post_type->name, 
			'posts_per_page' => -1,
		) );
	
		if( $post_type_posts->have_posts() ) {
			echo $before_widget;
				echo $before_title . '<a href="' . get_post_type_archive_link( $post_type->name ) . '">' . $post_type->labels->name . '</a>' . $after_title;
				?>
		
				<ul class="post-type-posts">
		
					<?php while( $post_type_posts->have_posts() ) : $post_type_posts->the_post(); ?>
		
						<li class="post-type-post">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</li>
		
					<?php endwhile; ?>
		
				</ul>
				
				<?php
			echo $after_widget;
		}

		wp_reset_postdata();
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Post_Type_Posts" );' ) );
