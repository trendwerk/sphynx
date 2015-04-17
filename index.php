<?php
get_header();
?>

<section id="main" class="container">

	<div class="container-inner">	
	
		<section id="content">
		
			<h1>
				<?php 
					if( is_category() || is_tag() || is_tax() )
						single_term_title( __( 'Posts about', 'tp' ) . ' ' );
					elseif( is_author() )
						echo __( 'Posts by', 'tp' ) . ' ' . get_the_author_meta( 'display_name' );
					else
						_e( 'News', 'tp' );
				?>
			</h1>

			<?php				
				if( have_posts() ) {

					while( have_posts() ) {
						the_post();
						get_template_part( 'partials/loop', 'post' );
			
					}

					tp_pagination();
					
				} else {
					?>

					<p>
						<?php _e( 'No results found.', 'tp' ); ?>
					</p>

					<?php
				}
			?>
			
		</section>
		
	</div>
	
</section>

<?php
get_footer();
