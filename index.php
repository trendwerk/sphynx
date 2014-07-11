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
					
						<h2>
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						
						<p class="meta">
							<?php _e( 'Posted on', 'tp' ); ?> <time datetime="<?php the_time( 'Y-m-d' ); ?>"><?php echo get_the_date(); ?></time>
							<?php _e( 'by', 'tp' ) ?> <?php the_author_posts_link(); ?> 
							<?php _e( 'in the category', 'tp' ) ?> <?php the_category( ', ' ) ?>
						</p>
						
						<figure>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'thumbnail' ); ?>
							</a>
						</figure>
						
						<?php the_content( __( 'Read more', 'tp' ) ); ?>

					</article>
				
				<?php endwhile; ?>
			
				<?php tp_pagination(); ?>
			
			<?php else : ?>

				<p>
					<?php _e( 'No results found.', 'tp' ); ?>
				</p>
				
			<?php endif; ?>
			
		</section>
				
		<aside class="sidebar">
			<?php dynamic_sidebar( 'blog' ); ?>
		</aside>
		
	</div>
	
</section>

<?php get_footer(); ?>