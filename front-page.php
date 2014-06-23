<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">
	
		<article id="content">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<h1>
					<?php the_title(); ?>
				</h1>
				
				<?php the_content(); ?>
				
			<?php endwhile; endif; ?>	
					
		</article>
		
		<aside class="sidebar">
			<?php dynamic_sidebar( 'home' ); ?>
		</aside>
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>