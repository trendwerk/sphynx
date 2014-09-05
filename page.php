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
				
				<?php 
					the_content();

					wp_link_pages( array(
						'before'         => '<nav class="pages">',
						'after'          => '</nav>',
						'next_or_number' => 'next'
					) );
				?>
				
			<?php endwhile; endif; ?>
			
		</article>

	</div>
	
</section>

<?php
get_footer();
