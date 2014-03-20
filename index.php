<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">	
	
		<section id="content" class="content-left eightcol">
		
			<?php if( is_category() ) { ?>
			
				<h1 id="page-title">
					<?php _e( 'Category', 'tp' ); ?>: <?php echo single_cat_title( '', false ); ?>
				</h1>
				
			<?php } elseif( is_tag() || is_tax() ) { ?>
			
				<h1 id="page-title">
					<?php _e( 'Tag', 'tp' ); ?>: <?php echo single_tag_title( '', false ); ?>
				</h1>
				
			<?php } elseif( is_author() ) { ?>
			
				<h1 id="page-title">
					<?php _e( 'Posts by', 'tp' ); ?>: <?php echo get_the_author_meta( 'display_name', $author ); ?>
				</h1>
				
				<?php get_template_part( 'part', 'author' ); ?>

			<?php } else { ?>
			
				<h1 id="page-title">
					<?php _e( 'News', 'tp' ); ?>
				</h1>
				
			<?php } ?>
			
			<?php if( have_posts() ) : ?>

				<?php while( have_posts() ) : the_post(); ?>
			
					<article <?php post_class(); ?> itemscope itemtype="http://schema.org/Article">
					
						<h2 class="article-title" itemprop="headline">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						
						<p class="article-meta">
							<?php _e( 'Posted on', 'tp' ); ?> <span class="date updated" itemprop="dateCreated"><time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php echo get_the_date(); ?></time></span> <?php _e( 'by', 'tp' ); ?> <span class="vcard author" itemprop="author"><span class="fn"><?php the_author_posts_link(); ?></span></span> <?php _e( 'in the category', 'tp' ); ?> <span itemprop="genre"><?php the_category( ', ' ); ?></span>
						</p>
						
						<a class="article-thumbnail" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'thumbnail', array( 'itemprop' => 'thumbnailUrl' ) ); ?>
						</a>
						
						<p class="article-content" itemprop="description">

							<?php tp_the_excerpt( 80 ); ?>

							<a class="more-link" href="<?php the_permalink(); ?>">
								<?php _e( 'Read more', 'tp' ); ?>
							</a>
							
						</p>
						
					</article>
				
				<?php endwhile; ?>
			
				<?php tp_pagination(); ?>
			
			<?php else : ?>

				<p>
					<?php _e( 'No results found.', 'tp' ); ?>
				</p>
				
			<?php endif; ?>
			
		</section><!-- #content -->	
				
		<aside class="sidebar fourcol">
			<?php dynamic_sidebar( 'blog' ); ?>
		</aside>
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>