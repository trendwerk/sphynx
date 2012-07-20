<?php get_header(); ?>
<div class="inner">
	<article class="eightcol">
		<div id="breadcrumbs"><?php tp_breadcrumbs(); ?></div>
		 <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			  <h1 id="page-title"><?php the_title(); ?></h1>
			  <?php the_content(); ?>
		  <?php endwhile; else: ?>
		  <?php endif; ?>
	</article>
	<aside class="sidebar vertical fourcol last">
		<?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('Page'); ?>
	</aside>
</div>
<?php get_footer(); ?>