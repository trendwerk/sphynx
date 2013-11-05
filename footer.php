		<footer id="footer" class="container">
		
			<div class="container-inner">
			
				<aside class="sidebar">
					<?php dynamic_sidebar('footerid'); ?>
				</aside>
				
				<div id="credits" class="twelvecol">
				
					<div id="copyright">
						<p>
							&copy; <?php _e('Copyright','tp'); ?> <?php echo date('Y'); ?> - <?php echo ($name = get_option('tp-company-name')) ? $name : get_bloginfo('name'); ?>
						</p>
					</div>
					
					<nav id="footernav" class="navigation">
						<?php wp_nav_menu( array(
							'container' => '',
							'fallback_cb' => 'false',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'theme_location' => 'footernav', 
							'depth' => '1'
						));?>
					</nav>
					
				</div>
				
			</div><!-- .container-inner -->
			
		</footer><!-- #footer -->
		
		<?php wp_footer(); ?>
		
		<!--[if IE 6]>
			<div class="ie6">
				<p><?php _e('You are using a very old version of Internet Explorer. For the best experience please upgrade (for free) to a modern browser:','tp'); ?>
				<ul>
					<li><a href="http://www.mozilla.com/" rel="nofollow external">Firefox</a></li>
					<li><a href="http://www.google.com/chrome/" rel="nofollow external">Google Chrome</a></li>
					<li><a href="http://www.apple.com/safari/" rel="nofollow external">Safari</a></li>
					<li><a href="http://www.microsoft.com/windows/internet-explorer/" rel="nofollow external">Internet Explorer</a></li>
				</ul>
			</div>
		<![endif]-->
		
	</body>
	
</html>