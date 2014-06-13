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
		$post_types = array_diff( get_post_types( array(
			'public'   => true,
		) ), array( 'page', 'attachment' ) );

		if( 0 < count( $post_types ) ) {
			?>

			<p>
				<label>
					<strong><?php _e( 'Title', 'tp' ); ?></strong><br />
					<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
				</label>
			</p>

			<p>
				<label>
					<strong><?php _e( 'Post type', 'tp' ); ?></strong><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
							<?php 
								foreach( $post_types as $post_type ) { 
									$post_type = get_post_type_object( $post_type ); 
									?>

									<option <?php selected( $post_type->name, $instance['post_type'] ); ?> value="<?php echo $post_type->name; ?>">
										<?php echo $post_type->labels->name; ?>
									</option>

									<?php 
								} 
							?>
						</select>
				</label>
			</p>

			<p>
				<label>
					<?php _e( 'Number of posts to show:', 'tp' ); ?>
					<input name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $instance['number']; ?>" size="3" />
				</label>
			</p>

			<p>
				<label>
					<input type="checkbox" name="<?php echo $this->get_field_name( 'archive_link' ); ?>" value="true" <?php checked( $instance['archive_link'], true ); ?>>
					<?php _e( 'Show link to post type archive', 'tp' ); ?>
				</label>
			</p>

			<?php 
		}
	}

	function update( $new_instance, $old_instance ) {
		$new_instance['number'] = absint( $new_instance['number'] );
		$new_instance['archive_link'] = isset( $new_instance['archive_link'] );
		
		return $new_instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		$post_type = get_post_type_object( $instance['post_type'] );

		$post_type_posts = new WP_Query( array(
			'post_type'           => $post_type->name, 
			'posts_per_page'      => $instance['number'],
			'ignore_sticky_posts' => true
		) );
	
		if( $post_type_posts->have_posts() ) {
			echo $before_widget;

				if( $instance['title'] )
				echo $before_title . $instance['title'] . $after_title;

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
				
				<?php if( $instance['archive_link'] ) { 
					?>
			    	
		    		<a class="more-link" href="<?php echo get_post_type_archive_link( $post_type->name ); ?>">
		    			<?php echo __( 'View all', 'tp') . ' ' . strtolower( $post_type->labels->name ); ?>
		    		</a>

		    		<?php 
		    	} 
			echo $after_widget;
		}

		wp_reset_postdata();
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Post_Type_Posts" );' ) );