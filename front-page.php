<?php get_header(); ?>

<header id="sub-header" class="container">

	<div class="container-inner">

		<h1>
			<?php bloginfo( 'name' ); ?>
		</h1>
		
		<h2>
			<?php bloginfo( 'description' ); ?>
		</h2>

	</div> <!-- .container-inner -->

</header> <!-- #sub-header -->

<section id="main" class="container">

	<div class="container-inner">
	
		<article id="content">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<h2 id="page-title">
					<?php the_title(); ?>
				</h2>
				
				<?php the_content(); ?>
				
			<?php endwhile; endif; ?>	
					
		</article>
		
		<aside class="sidebar">
			<?php dynamic_sidebar( 'home' ); ?>
		</aside>
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>