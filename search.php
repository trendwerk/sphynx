<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">

		<aside class="sidebar fourcol">
			<?php dynamic_sidebar( 'page' ); ?>
		</aside>
	
		<section id="content" class="content-right eightcol">

			<h1>
				<?php printf( __( 'Search Results for: %1$s', 'tp' ), '<strong>' . get_search_query() . '</strong>' ); ?>
			</h1>
		
			<?php if ( have_posts() ) : ?>
				
				<?php while ( have_posts() ) : the_post(); ?>
				
					<article <?php post_class(); ?>>
					
						<h2 class="article-title">

							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>

						</h2>
						
						<p class="article-content">

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
					<?php printf( __('Your search for <em>&quot;%1$s&quot;</em> did not match any documents. Please make sure all your words are spelled correctly or try different keywords.', 'tp' ), get_search_query() ); ?>
				</p>
				
				<?php get_search_form(); ?>
				
			<?php endif; ?>	   
			 
		</section>
				
	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>