<?php get_header(); ?>

<div class="inner">		
	<article class="eightcol">
		<div id="breadcrumbs"><?php if (function_exists('tp_breadcrumbs')) tp_breadcrumbs(); ?></div>  		
		<?php if (have_posts()) : ?>
			<h1><?php printf(__( 'Search Results for: %1$s','tp'),'<span class="search-highlight">'.get_search_query().'</span>'); ?></h1>
			<p>
				<?php 
					$allsearch = &new WP_Query('s=$s&showposts=-1');
					$count = $allsearch->post_count;
					wp_reset_query();
					
					printf(__('Found %1$s articles containing the keyword: <span class="search-highlight">%2$s</span>','tp'),$count,get_search_query());
				?>
			</p>
			<?php while (have_posts()) : the_post(); ?>
  				<section class="blog-item">
					<h2 class="blog-item-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
					<p class="meta"><?php _e('Posted on','tp')?> <?php echo get_the_date(); ?> <?php _e('in the category:','tp') ?> <?php the_category(', ') ?></p>
					<?php the_excerpt(); ?>
					<p class="readmore"><a href="<?php echo the_permalink(); ?>"><?php _e('Read more &raquo;','tp'); ?></a></p>
				</section>
			<?php endwhile; ?>
			
			<nav id="pagination"><?php tp_pagination('&laquo;','&raquo;'); ?></nav>
		<?php else : ?>
			<h1><?php printf(__( 'Search Results for: %1$s','tp'),'<strong class="search-highlight">'.get_search_query().'</strong>'); ?></h1>
			<p><?php _e('Sorry, no posts matched your criteria. Try refining your search','tp');?></p>
			<p><?php get_search_form();?></p>
		<?php endif; ?>	    
	</article>	
	<aside class="sidebar vertical fourcol last">
		<?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('Blog'); ?>
	</aside>		
</div>

<?php get_footer(); ?>