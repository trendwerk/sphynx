<?php get_header(); ?>
<div class="container-inner">		
	<section id="content" class="eightcol">
		<?php if(is_category()) : ?>
			<h1 id="page-title"><?php echo __('Category %s','tp').': '.single_cat_title('',false); ?></h1>
		<?php elseif(is_tag()) : ?>
			<h1 id="page-title"><?php echo __('Tag %s','tp').': '.single_tag_title('',false); ?></h1>
		<?php elseif(is_tax()) : ?>
			<h1 id="page-title"><?php echo __('Tag %s','tp').': '.single_tag_title('',false); ?></h1>
		<?php elseif(is_author()) : ?>
			<h1 id="page-title"><?php echo __('Posts by','tp').' '.get_the_author_meta('display_name',$author); ?></h1>
			<?php get_template_part('part-author'); ?>
		<?php else : ?>
			<h1 id="page-title"><?php _e('News','tp'); ?></h1>
		<?php endif; ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<article <?php post_class(); ?>>
				<h2 class="article-title">
					<a href="<?php the_permalink() ?>">
						<?php the_title(); ?>
					</a>
				</h2>
				<p class="meta">
					<?php _e('Posted on','tp')?> <time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time> <?php _e('by','tp') ?> <?php the_author_posts_link() ?> <?php _e('in the category','tp') ?> <?php the_category(', ') ?>
				</p>
				<?php get_the_post_thumbnail(); ?>
				<p>
					<?php tp_the_excerpt(40); ?>
				
					<a class="more" href="<?php echo the_permalink(); ?>">
						<?php _e('Read more','tp'); ?>
					</a>
				</p>
			</article>
		<?php endwhile; ?>
			<?php tp_pagination(); ?>
		<?php else : ?>
			<p><?php _e('No results found.','tp'); ?></p>
		<?php endif; ?>
	</section>	
	<aside class="sidebar fourcol">
		<?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('blog'); ?>
	</aside>		
</div>
<?php get_footer(); ?>