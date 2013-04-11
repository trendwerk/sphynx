<?php get_header(); ?>
<div class="container-inner">
	<article id="content" class="eightcol">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1 id="page-title">
				<?php the_title(); ?>
			</h1>
			<p class="meta">
				<?php _e('Posted on','tp')?>: <time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time> <?php _e('in the category','tp') ?>: <?php the_category(', ') ?></p>
			<?php the_content(); ?>
			<p class="meta"><?php the_tags('Tags: ',', '); ?></p>
			<?php get_template_part('share'); ?>
		<?php endwhile; endif; ?>
		<?php comments_template(); ?>
		<nav id="pagination">
			<div class="prev-post"><?php previous_post_link('&laquo; %link'); ?></div>
			<div class="next-post"><?php next_post_link('%link &raquo;'); ?></div>
		</nav>
	</article>
	<aside class="sidebar fourcol">
		<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('blog'); ?>
	</aside>
</div>
<?php get_footer(); ?>