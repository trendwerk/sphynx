<?php get_header(); ?>
	<div class="container-inner">
		<article id="content" class="eightcol">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<h1 class="article-title">
					<?php the_title(); ?>
				</h1>
				<p class="meta">
					<?php _e('Posted on','tp')?>: <time datetime="<?php the_time('Y-m-d') ?>"><?php echo get_the_date(); ?></time> <?php _e('in the category','tp') ?>: <?php the_category(', ') ?></p>
				<?php the_content(); ?>
				<p class="postmeta"><?php the_tags('Tags: ',', '); ?></p>
				<div class="share">
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style ">
					<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
					<a class="addthis_button_tweet"></a>
					<a class="addthis_button_pinterest_pinit"></a>
					<a class="addthis_counter addthis_pill_style"></a>
					</div>
					<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50562810252f56ce"></script>
					<!-- AddThis Button END -->
				</div>
			<?php endwhile; endif; ?>
			<?php comments_template(); ?>
			<nav id="pagination">
				<div class="prev-post"><?php previous_post_link('%link'); ?></div>
				<div class="next-post"><?php next_post_link('%link'); ?></div>
			</nav>
		</article>
		<aside class="sidebar fourcol">
			<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('Blog'); ?>
		</aside>
	</div>
<?php get_footer(); ?>