		<footer id="footer" class="container">
		
			<div class="container-inner">
			
				<aside class="sidebar">
					<?php dynamic_sidebar( 'footerid' ); ?>
				</aside>
				
				<div id="credits" class="twelvecol">
				
					<div id="copyright">
						<p>
							&copy; <?php _e( 'Copyright', 'tp' ); ?> <?php echo date( 'Y' ); ?> - <?php echo ( $name = get_option( 'tp-company-name' ) ) ? $name : get_bloginfo( 'name' ); ?>
						</p>
					</div>
					
					<nav id="footernav" class="navigation">
						<?php 
							wp_nav_menu( array(
								'container'      => '',
								'fallback_cb'    => 'false',
								'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'theme_location' => 'footernav', 
								'depth'          => '1',
							) );
						?>
					</nav>
					
				</div>
				
			</div><!-- .container-inner -->
			
		</footer><!-- #footer -->
		
		<?php wp_footer(); ?>
		
	</body>
	
</html>