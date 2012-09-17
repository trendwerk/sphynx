<?php get_header(); ?>

<div class="inner">		
	<article class="eightcol">
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
			<article>
				<h2 class="article-title">
					<a href="<?php the_permalink() ?>">
						<?php the_title(); ?>
					</a>
				</h2>
				<?php tp_the_excerpt(50); ?>
				<p>
					<a  class="more" href="<?php echo the_permalink(); ?>">
						<?php _e('Read more','tp'); ?>
					</a>
				</p>
			</article>
		<?php endwhile; ?>
			<nav id="pagination">
				<?php tp_pagination('&laquo;','&raquo;'); ?>
			</nav>
		<?php else : ?>
			<h1><?php printf(__( 'Search Results for: %1$s','tp'),'<strong class="search-highlight">'.get_search_query().'</strong>'); ?></h1>
			<p><?php printf(__('Your search for <em>&quot;%1$s&quot;</em> did not match any documents. Please make sure all your words are spelled correctly or try different keywords.','tp'),get_search_query() );?></p>
			<p><?php get_search_form();?></p>
		<?php endif; ?>	    
	</article>	
	<aside class="sidebar fourcol">
		<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('Blog'); ?>
	</aside>		
</div>

<?php get_footer(); ?>