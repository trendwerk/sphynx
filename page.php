<?php get_header(); ?>

<section id="main" class="container">
	<div class="container-inner">
	
		<aside class="sidebar fourcol">
			<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('page'); ?>
		</aside>
		
		<article id="content" class="eightcol">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1 id="page-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php endwhile; endif; ?>
		</article>
		
	</div><!-- .conainer-inner -->
</section><!-- #main -->

<?php get_footer(); ?>