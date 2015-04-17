<?php
get_header();
?>

<section id="main" class="container">

	<div class="container-inner">	
	
		<section id="content">
			
			<h1>
				<?php
					if( is_archive() )
						the_archive_title();
					else
						echo get_the_title( get_option( 'page_for_posts' ) );
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
