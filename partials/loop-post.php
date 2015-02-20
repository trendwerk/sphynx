<?php
/**
 * Loop: Post
 */
?>

<article <?php post_class(); ?>>

	<h2>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>
	
	<p class="meta">
		<?php _e( 'Posted on', 'tp' ); ?> <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php echo get_the_date(); ?></time>
		<?php _e( 'by', 'tp' ) ?> <?php the_author_posts_link(); ?> 
		<?php _e( 'in the category', 'tp' ) ?> <?php the_category( ', ' ) ?>
	</p>

	<?php if( has_post_thumbnail() ) { ?>
	
		<figure>

			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'thumbnail' ); ?>
			</a>
			
		</figure>

	<?php } ?>
	
	<?php the_content( __( 'Read more', 'tp' ) ); ?>

</article>
