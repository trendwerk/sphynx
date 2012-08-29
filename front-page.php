<?php get_header(); ?>
<div class="inner">
	<article class="eightcol">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>			
	</article>
	<aside class="sidebar fourcol last">
		<?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('Home'); ?>
	</aside>
</div>
<?php get_footer(); ?>