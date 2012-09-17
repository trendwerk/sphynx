<?php get_header(); ?>
<div class="inner">
	<article class="eightcol">
		<h1><?php _e('The page you are looking for doesn\'t exist.',"tp"); ?></h1>
		<p><strong><?php _e('Seems like the page you were looking for might have been moved or just didn\'t excist in the first place.','tp'); ?></strong></p>
		<p><?php echo sprintf(__('You might want to check out our <a href="%1$s">sitemap</a> or use the searchform below to find the page you are looking for.','tp'),get_option('siteurl').'/sitemap/'); ?></p>
		<?php get_search_form(); ?>	 
	</article>
	<aside class="sidebar vertical fourcol last">
		<?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('Page'); ?>
	</aside>
</div>
<?php get_footer(); ?>