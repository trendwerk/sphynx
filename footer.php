		<footer id="footer" class="container">
		
			<div class="container-inner">
			
				<aside class="sidebar">
					<?php dynamic_sidebar( 'footerid' ); ?>
				</aside>
				
				<div id="credits">
				
					<div id="copyright">
						<p>
							&copy; <?php _e( 'Copyright', 'tp' ); ?> <?php echo date( 'Y' ); ?> - <?php echo ( $name = get_option( 'tp-company-name' ) ) ? $name : get_bloginfo( 'name' ); ?>
						</p>
					</div>
					
					<nav id="footernav" class="navigation">
						<?php 
							wp_nav_menu( array(
								'depth'          => 1,
								'fallback_cb'    => null,
								'theme_location' => 'footernav',
							) );
						?>
					</nav>
					
				</div>
				
			</div><!-- .container-inner -->
			
		</footer><!-- #footer -->
		
		<?php wp_footer(); ?>
		
	</body>
	
</html>