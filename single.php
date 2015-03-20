<?php
get_header();
?>

<section id="main" class="container">

	<div class="container-inner">
	
		<article id="content">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<h1>
					<?php the_title(); ?>
				</h1>
				
				<p class="meta">
					<?php _e( 'Posted on', 'tp' ); ?> <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php echo get_the_date(); ?></time>
					<?php _e( 'by', 'tp' ) ?> <?php the_author_posts_link(); ?> 
					<?php _e( 'in the category', 'tp' ) ?> <?php the_category( ', ' ) ?>
				</p>

				<div>

					<figure>
						<?php the_post_thumbnail( 'medium' ); ?>
					</figure>

					<?php 
						the_content();

						wp_link_pages( array(
							'before'         => '<nav class="pages">',
							'after'          => '</nav>',
							'next_or_number' => 'next'
						) );
					?>

				</div>

				<?php get_template_part( 'partials/share' ); ?>

				<p class="tags">
					<?php the_tags( '<span class="label">Tags</span> ', '' ); ?>
				</p>

				<p>
					<a class="back" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">
						<?php _e( 'Back to the overview', 'tp' ); ?>
					</a>
				</p>

			<?php endwhile; endif; ?>

			<?php comments_template(); ?>

		</article>

		<aside>
			<?php dynamic_sidebar( 'blog' ); ?>
		</aside>

	</div>

</section>

<?php
get_footer();
