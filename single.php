<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">
	
		<article id="content" class="eightcol" itemscope itemtype="NewsArticle">
		
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
				<h1 id="page-title" itemprop="headline">
					<?php the_title(); ?>
				</h1>
				
				<p class="meta">
					<?php _e( 'Posted on', 'tp' ); ?> <time datetime="<?php the_time( 'Y-m-d' ); ?>" itemprop="dateCreated"><?php echo get_the_date(); ?></time>
					<span itemprop="author"><?php _e( 'by', 'tp' ) ?> <?php the_author_posts_link(); ?></span> <?php _e( 'in the category', 'tp' ) ?> <span itemprop="genre"><?php the_category( ', ' ) ?></span>
				</p>
				
				<div itemprop="text">
					<?php the_content(); ?>
				</div>
				
				<p class="meta">
					<?php the_tags( 'Tags: ', ', ' ); ?>
				</p>
				
				<?php get_template_part( 'part', 'share' ); ?>
				
				<?php get_template_part( 'part', 'author' ); ?>
				
				<p>
					<a class="back" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>">
						<?php _e( 'Back to the overview', 'tp' ); ?>
					</a>
				</p>
				
			<?php endwhile; endif; ?>
			
			<?php comments_template(); ?>
			
			<nav id="pagination" itemprop="breadcrumb">
				<div class="prev"><?php previous_post_link( '&laquo; %link' ); ?></div>
				<div class="next"><?php next_post_link( '%link &raquo;' ); ?></div>
			</nav>
			
		</article>
		
		<aside class="sidebar fourcol">
			<?php dynamic_sidebar( 'blog' ); ?>
		</aside>
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>