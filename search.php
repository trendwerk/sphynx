<?php
get_header();
?>

<section id="main" class="container">

	<div class="container-inner">
	
		<section id="content">

			<h1>
				<?php printf( __( 'Search Results for: %1$s', 'tp' ), get_search_query() ); ?>
			</h1>
		
			<?php
				if( have_posts() ) {
				
					while( have_posts() ) {
						the_post();
						get_template_part( 'partials/loop', 'search' );
					}

					tp_pagination();
				} else {
					?>

					<p>
						<?php printf( __( 'Your search for <em>&quot;%1$s&quot;</em> did not match any documents. Please make sure all your words are spelled correctly or try different keywords.', 'tp' ), get_search_query() ); ?>
					</p>

					<?php
					get_search_form();
				}
			?> 
			 
		</section>
				
	</div>
	
</section>

<?php
get_footer();
