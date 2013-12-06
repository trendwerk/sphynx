<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">

		<aside class="sidebar fourcol">
			<?php dynamic_sidebar( 'page' ); ?>
		</aside>
	
		<article id="content" class="content-right eightcol">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<h1 id="page-title">
					<?php the_title(); ?>
				</h1>
				
				<div itemprop="text">
					<?php the_content(); ?>
				</div>
								
				<div class="back">
					<a class="back" href="<?php echo get_post_type_archive_link( 'posttype' ); ?>">
						<?php _e( 'Back to the overview', 'tp' ); ?>
					</a>
				</div>
				
			<?php endwhile; endif; ?>	
			
		</article>
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>