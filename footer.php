</section>
		<footer id="main-footer" class="container">
			<div class="inner">
				<aside class="sidebar">
					<?php if ( function_exists('dynamic_sidebar') ) dynamic_sidebar('Footer'); ?>
				</aside>
			</div>
		</footer>
		<footer id="credits" class="container">
			<div class="inner">
				<div class="twelvecol">
					<div id="copyright">
						<p>&copy; Copyright <?php the_time('Y'); ?> - <?php bloginfo('name'); ?> <?php ?></p>
					</div>
					<nav id="footernav" class="navigation">
						<?php wp_nav_menu( array(
							'theme_location' => 'footernav', 
							'depth' => '1'
						));?>
					</nav>
				</div>
			</div>
		</footer>
		<div id="ajaxurl"><?php echo admin_url('admin-ajax.php'); ?></div>
		<div id="templateurl"><?php echo get_template_directory_uri() ?></div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  		<script>window.jQuery || document.write('<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/script/functions.js"><\/script>')</script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/script/functions.js"></script>
		<?php wp_footer(); ?>
		<!--[if IE 6]>
			<div class="ie6">
				<p><?php _e('You are using a very old version of Internet Explorer. For the best experience please upgrade (for free) to a modern browser:' ,'tp'); ?>
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