<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">

		<aside class="sidebar fourcol">
			<?php dynamic_sidebar( 'page' ); ?>
		</aside>
	
		<section id="content" class="content-right eightcol">
		
			<h1 id="page-title">
				<?php _e( 'Posttype name', 'tp' ); ?>
			</h1>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
			
					<article <?php post_class(); ?>>
					
						<h2 class="article-title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						
						<a class="article-thumbnail" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'thumbnail', array( 'itemprop' => 'thumbnailUrl' ) ); ?>
						</a>
						
						<p class="article-content">
							<?php tp_the_excerpt( 80 ); ?>
							<a class="more" href="<?php echo the_permalink(); ?>">
								<?php _e( 'Read more', 'tp' ); ?>
							</a>
						</p>
						
					</article>
					
				<?php endwhile; ?>
			
				<?php tp_pagination(); ?>
			
			<?php else : ?>

				<p>
					<?php _e( 'No results found.', 'tp' ); ?>
				</p>
				
			<?php endif; ?>
			
		</section><!-- #content -->	
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>
