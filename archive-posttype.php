<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">	
	
		<section id="content" class="eightcol">
		
			<h1 id="page-title">
				<?php _e( 'Posttype name', 'tp' ); ?>
			</h1>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>
			
					<article <?php post_class(); ?>>
					
						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						
						<div class="article-thumbnail">
							<a href="<?php echo the_permalink(); ?>">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</a>
						</div>
						
						<p>
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
				
		<aside class="sidebar fourcol">
			<?php dynamic_sidebar( 'page' ); ?>
		</aside>
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>
