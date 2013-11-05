<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js ie ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js ie ie8> <![endif]-->
<!--[if IE 8]><html class="no-js ie ie9"> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
	<head>
		<title><?php wp_title('-'); ?></title>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php bloginfo('name'); ?> RSS feed" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="shortcut icon" type="image/png" href="<?php bloginfo('template_url')?>/assets/img/favicon/favicon.ico" />
		<link rel="stylesheet" type="text/css" media="print" href="<?php echo get_template_directory_uri() ?>/assets/css/print.css" />
		<?php wp_head();?>
	</head>
	
	<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">
	
		<header id="header" class="container">
		
			<div class="container-inner">
			
				<div id="logo" class="sixcol">
					<p id="sitename"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></p>
					<p id="description"><?php bloginfo('description'); ?></p>
				</div>
				
				<nav id="topnav" class="navigation sixcol">				
					<?php
						wp_nav_menu( array(
							'theme_location' => 'topnav',
							'fallback_cb' => 'false',
							'container' => '',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth' => '0' 
						)); 
					?>
				</nav>
				
				<div id="search" class="sixcol">
					<?php get_search_form(); ?>
				</div>
				
				<nav id="main-navigation" class=" twelvecol">				
					<?php 
						wp_nav_menu( array(
							'theme_location' => 'mainnav',
							'container' => '',
							'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
							'depth' => '0',
							'mobile' => true 
						)); 
					?>						
				</nav>
				
				<?php if ( is_front_page() ) { ?>
					<!-- Enter code here for custom homepage header -->
				<?php } else { ?>

					<nav id="breadcrumbs" itemprop="breadcrumb" class="twelvecol">
						<?php _e('You are here:','tp') ?>
						<?php tp_breadcrumbs('»'); ?>
					</nav>

				<?php } ?>

			</div><!-- .container-inner -->

		</header><!-- #header -->