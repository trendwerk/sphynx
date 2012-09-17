<?php get_header(); ?>
<div class="inner">
	<aside class="sidebar fourcol">
		<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('Page'); ?>
	</aside>
	<article class="eightcol">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1 id="page-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>
	</article>
</div>
<?php get_footer(); ?>