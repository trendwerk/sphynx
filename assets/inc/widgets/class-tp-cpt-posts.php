<?php
/**
 * Custom post type posts
 *
 * @package TrendPress
 */
class TP_CPT_Posts extends WP_Widget {
	function TP_CPT_Posts() {
		$this->WP_Widget( 'TP_CPT_Posts', __( 'Custom post type posts', 'tp' ), array( 'description' => __( 'List of posts from a given custom post type', 'tp' ) ) );
	}
	
	function form( $instance ) {
		if( $posttypes = get_post_types( '', 'objects' ) ) { 
			?>
			<p>
				<label>
					<strong><?php _e( 'Post type' ); ?></strong><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'posttype' ); ?>">
						<?php 
							foreach( $posttypes as $posttype ) { 
								$exclude = array( 'attachment', 'nav_menu_item', 'page', 'post', 'revision' );
								if ( in_array( $posttype->name, $exclude ) ) { continue; }
						?>
							<option <?php selected( $posttype->name, $instance['posttype'] ); ?> value="<?php echo $posttype->name; ?>"><?php echo $posttype->labels->name; ?></option>
						<?php } ?>
					</select>
				</label>
			</p>
			<?php 
		}
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['posttype'] = $new_instance['posttype'];

		return $instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$posttype = $instance['posttype'];
		$posttypeobject = get_post_type_object( $posttype );
		$posttypename = $posttypeobject->labels->name;
		$posttypearchive = get_post_type_archive_link( $posttype );

		/**
		 * Show posts from selected posttype
		 */
		$posts = new WP_Query( array(
			'post_type' => $posttype, 
			'posts_per_page' => -1,
		) );
	
		if($posts->have_posts()) {
			echo $before_widget;
			echo $before_title . '<a href="' . $posttypearchive . '">' . $posttypename . '</a>' . $after_title;

			?>
	
				<ul class="posts">
		
					<?php while($posts->have_posts()) : $posts->the_post(); ?>
		
						<li class="post">
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
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_CPT_Posts" );' ) );