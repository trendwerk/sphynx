		<footer id="footer" class="container">
		
			<div class="container-inner">
				
				<div id="credits">
				
					<div id="copyright">
						<p>
							&copy; <?php _e( 'Copyright', 'tp' ); ?> <?php echo date( 'Y' ); ?> - <?php bloginfo( 'name' ); ?>
						</p>
					</div>
					
					<nav>
						<?php 
							wp_nav_menu( array(
								'depth'          => 1,
								'fallback_cb'    => null,
								'theme_location' => 'footer',
							) );
						?>
					</nav>
					
				</div>
				
			</div>
			
		</footer>
		
		<?php wp_footer(); ?>
		
	</body>
	
</html>
