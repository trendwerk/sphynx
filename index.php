<?php get_header(); ?>
<div class="container-inner">		
	<section id="content" class="eightcol">
		<h1 id="page-title">
			<?php if(is_day()) : ?>
				<?php printf(__( 'Daily archives: %s','tp'),'<span>'.get_the_date().'</span>'); ?>
			<?php elseif(is_month()) : ?>
				<?php printf(__('Monthly archives: %s','tp'),'<span>'.get_the_date('F Y').'</span>'); ?>
			<?php elseif(is_year()) : ?>
				<?php printf(__( 'Yearly archives: %s','tp'),'<span>'.get_the_date('Y').'</span>'); ?>
			<?php elseif(is_category()) : ?>
				<?php printf(__('Category archives: %s','tp'),'<span>'.single_cat_title('',false).'</span>'); ?>
			<?php elseif(is_tag()) : ?>
				<?php printf( __('Tag Archives: %s','tp'),'<span>'.single_tag_title('',false).'</span>'); ?>
			<?php elseif(is_tax()) : ?>
				<?php printf( __('%s','tp'),'<span>'.single_tag_title('',false).'</span>'); ?>
			<?php else : ?>
				<?php _e('News','tp'); ?>
			<?php endif; ?>
		</h1>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<article <?php post_class(); ?>>
				<h2 class="article-title">
					<a href="<?php the_permalink() ?>">
						<?php the_title(); ?>
					</a>
				</h2>
				<p class="meta">
					<?php _e('Posted on:','tp')?> <time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time> 
					<?php _e('in the category:','tp') ?> <?php the_category(', ') ?>
				</p>
				<?php tp_the_excerpt(40); ?>
				<p>
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
		<?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('Blog'); ?>
	</aside>		
</div>
<?php get_footer(); ?>