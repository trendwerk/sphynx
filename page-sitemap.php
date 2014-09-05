<?php
get_header();
?>

<section id="main" class="container">

	<div class="container-inner">
	
		<aside>
			<?php dynamic_sidebar( 'page' ); ?>
		</aside>
		
		<article id="content">	
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<h1>
					<?php the_title(); ?>
				</h1>
				
				<?php the_content(); ?>
				
				<div id="sitemap-pages">

					<h2><?php _e( 'Pages', 'tp' ); ?></h2>
							
					<?php 
						wp_nav_menu( array(
							'theme_location' => 'sitemap',
						) ); 
					?>

				</div>
				
				<?php 
					$post_types = get_post_types( array( 
						'public'   => true, 
						'_builtin' => false
					), 'objects' );

					if( 0 < count( $post_types ) ) { 
						
						foreach( $post_types as $post_type ) { 
							?>

							<div class="post_type-<?php echo $post_type->name; ?>">
							
								<h2>
									<?php echo $post_type->labels->name; ?>
								</h2>
								
								<?php 
									$entries = new WP_Query( array( 
										'post_type'      => $post_type->name,
										'posts_per_page' => -1,
									) );
									
									if( $entries->have_posts() ) { 
										?>
								
										<ul>

											<?php while( $entries->have_posts() ) : $entries->the_post(); ?>

												<li>
													<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</li>

											<?php endwhile; ?>

										</ul>
									
										<?php 
									}
									wp_reset_postdata(); 
								?>
								
							</div>
						
							<?php 
						}
					} 

					$news = new WP_Query( array( 
						'posts_per_page' => -1,
					) );

					if( $news->have_posts() ) { 
						?>
				
						<div class="news">
						
							<h2><?php _e( 'News', 'tp' ); ?></h2>
							
							<ul>
								<?php while( $news->have_posts() ) : $news->the_post(); ?>

									<li>
										<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
											<?php the_title(); ?>
										</a>
									</li>

								<?php endwhile; ?>
							</ul>
							
						</div>
					
						<?php 
					}

				endwhile; endif;
			?>

		</article>

	</div>
	
</section>

<?php
get_footer();
