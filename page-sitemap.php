<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">
	
		<aside class="sidebar fourcol">
			<?php dynamic_sidebar('page'); ?>
		</aside>
		
		<article id="content" class="content-right eightcol">	
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<h1><?php the_title(); ?></h1>
				
				<?php the_content(); ?>
				
				<div id="pages">

					<h2><?php _e( 'Pages', 'tp' ); ?></h2>
							
					<?php 
						wp_nav_menu( array(
							'theme_location' => 'sitemap',
							'container' => '',
							'depth' => '0'
						) ); 
					?>

				</div>
				
				<?php 
					$args = array( 
						'public'   => true, 
						'_builtin' => false
					); 
					if( $cpts = get_post_types( $args, 'objects' ) ) { 
				?>
				
					<?php foreach( $cpts as $cpt ) { ?>

						<div class="cpt-<?php echo $cpt->name; ?>">
						
							<h2><?php echo $cpt->labels->name; ?></h2>
							
							<?php $entries = new WP_Query( array( 'cpt' => $cpt->name, 'posts_per_page' => -1 ) ); ?>
							
							<?php if( $entries->have_posts() ) : ?>
							
								<ul>
									<?php while( $entries->have_posts() ) : $entries->the_post(); ?>
										<li>
											<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</li>
									<?php endwhile; ?>
								</ul>
								
							<?php endif; wp_reset_postdata(); ?>
							
						</div>
						
					<?php } ?>
						
				<?php } ?>
				
				<?php
					$blog = new WP_Query( array( 'posts_per_page' => -1 ) );
					if( $blog->have_posts() ) { 
				?>
				
					<div class="blog">
					
						<h2><?php _e( 'Blog', 'tp' ); ?></h2>
						
						<ul>
							<?php while( $blog->have_posts() ) : $blog->the_post(); ?>
								<li>
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</li>
							<?php endwhile; ?>
						</ul>
						
					</div>
					
				<?php } ?>
				
			<?php endwhile; endif; ?>
			
		</article>

	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>