<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">	
	
		<section id="content">
		
			<?php if( is_category() ) { ?>
			
				<h1 id="page-title">
					<?php _e( 'Category', 'tp' ); ?>: <?php single_cat_title(); ?>
				</h1>
				
			<?php } elseif( is_tag() || is_tax() ) { ?>
			
				<h1 id="page-title">
					<?php _e( 'Tag', 'tp' ); ?>: <?php single_tag_title(); ?>
				</h1>
				
			<?php } elseif( is_author() ) { ?>
			
				<h1 id="page-title">
					<?php _e( 'Posts by', 'tp' ); ?> <?php echo get_the_author_meta( 'display_name', $author ); ?>
				</h1>
				
				<?php get_template_part( 'part', 'author' ); ?>

			<?php } else { ?>
			
				<h1 id="page-title">
					<?php _e( 'News', 'tp' ); ?>
				</h1>
				
			<?php } ?>
			
			<?php if( have_posts() ) : ?>

				<?php while( have_posts() ) : the_post(); ?>
			
					<article <?php post_class(); ?>>
					
						<h2 class="article-title">
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						
						<p class="article-meta">
							<?php _e( 'Posted on', 'tp' ); ?> <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php echo get_the_date(); ?></time>
							<?php _e( 'by', 'tp' ) ?> <?php the_author_posts_link(); ?> <?php _e( 'in the category', 'tp' ) ?> <?php the_category( ', ' ) ?>
						</p>
						
						<a class="article-thumbnail" href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						</a>
						
						<p class="article-content">
							<?php tp_the_excerpt( 70 ); ?>
						</p>
						
						<p>
							<a class="more-link" href="<?php the_permalink(); ?>">
								<?php _e( 'Read&nbsp;more', 'tp' ); ?>
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
				
		<aside class="sidebar">
			<?php dynamic_sidebar( 'blog' ); ?>
		</aside>
		
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>