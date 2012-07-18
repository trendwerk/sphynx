		</section>
		<footer id="main-footer" class="container">
			<div class="inner sidebar horizontal">
				<?php if(function_exists('dynamic_sidebar')) dynamic_sidebar('footer'); ?>
			</div>
		</footer>
		<footer id="credits" class="container">
			<div class="inner">
				<div id="copyright" class="sixcol">
					<p>&copy; Copyright <?php the_time('Y'); ?> - <?php bloginfo('name'); ?> <?php ?></p>
				</div>
				<div id="sitemap" class="sixcol last">
					<?php wp_nav_menu( array('menu' => 'Footernavigatie', 'container' => '', 'container_class' => 'false', 'menu_class' => 'navigation', 'menu_id' => 'footernavigatie' )); ?>
				</div>
			</div>
		</footer>
		<div id="ajaxurl"><?php echo admin_url('admin-ajax.php'); ?></div>
		<div id="templateurl"><?php echo get_template_directory_uri() ?></div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  		<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>
  		
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/script/functions.js"></script>	
		
		<?php wp_footer(); ?>
		<!--[if IE 6]>
			<div class="ie6">
				<p><?php _e('You are using a very old version of Internet Explorer. For the best experience please upgrade (for free) to a modern browser:' ,'tp'); ?>
				<ul>
					<li><a href="http://www.mozilla.com">Firefox</a>,</li>
					<li><a href="http://www.apple.com/safari/">Safari</a>,</li>
					<li><a href="http://www.opera.com/">Opera</a>,</li>
					<li><a href="http://www.google.com/chrome/">Google Chrome</a>, or</li>
					<li><a href="http://www.microsoft.com/windows/internet-explorer/">Internet Explorer</a>.</li>
				</ul>
			</div>
		<![endif]-->
	</body>
</html>