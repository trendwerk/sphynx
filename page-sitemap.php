<?php get_header(); ?>

<section id="main" class="container">

	<div class="container-inner">
	
		<aside class="sidebar fourcol">
			<?php dynamic_sidebar('page'); ?>
		</aside>
		
		<article id="content" class="eightcol">	
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			
				<h1>
					<?php the_title(); ?>
				</h1>
				
				<?php the_content(); ?>
				
				<div class="post-type-page">
					<h2>
						<?php _e('Pages','tp'); ?>
					</h2>
					
					<ul>
						<?php wp_list_pages("title_li="); ?>
					</ul>
				</div>
				
				<?php if($post_types = get_post_types(array('public' => true,'_builtin' => false),'objects')) : ?>
				
					<div class="custom-post-types">
					
						<?php foreach($post_types as $post_type) :  ?>
						
							<div class="post-type-<?php echo $post_type->query_var; ?>">
							
								<h2>
									<?php echo $post_type->labels->name; ?>
								</h2>
								
								<?php $entries = new WP_Query(array('post_type' => $post_type->query_var,'posts_per_page' => -1)); ?>
								
								<?php if($entries->have_posts()) : ?>
								
									<ul>
										<?php while($entries->have_posts()) : $entries->the_post(); ?>
											<li>
												<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</li>
										<?php endwhile; ?>
									</ul>
									
								<?php endif; wp_reset_postdata(); ?>
								
							</div>
							
						<?php endforeach; ?>
						
					</div>
					
				<?php endif; ?>
				
				<?php $nieuws = new WP_Query(array('posts_per_page' => -1)); ?>
				
				<?php if($nieuws->have_posts()) : ?>
				
					<div class="post-type-post">
					
						<h2>
							<?php _e('Blog','tp'); ?>
						</h2>
						
						<ul>
							<?php while($nieuws->have_posts()) : $nieuws->the_post(); ?>
								<li>
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</li>
							<?php endwhile; ?>
						</ul>
						
					</div>
					
				<?php endif; ?>
				
			<?php endwhile; endif; ?>
			
		</article>

	</div><!-- .container-inner -->
	
</section><!-- #main -->

<?php get_footer(); ?>