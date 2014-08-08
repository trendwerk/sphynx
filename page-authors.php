<?php 
//Template name: Authors overview
__( 'Authors overview', 'tp' );

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
				
				<?php 
					$users = get_users( array( 
						'orderby' => 'display_name', 
					) );

					if( $users ) {
						?>
				
						<section id="authors">				
							<?php 
								foreach( $users as $user ) {
									$GLOBALS['author'] = $user->ID;
									get_template_part( 'part', 'author' );
								}
							?>
						</section>
					
						<?php 
					} 
				?>
				
			<?php endwhile; endif; ?>
			
		</article>
	
	</div>
	
</section>

<?php
	get_footer();