<!DOCTYPE html>

<!--[if lte IE 8]>
	<html class="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if gt IE 8]>
	<html <?php language_attributes(); ?>>
<![endif]-->

	<head>

		<title><?php wp_title( '-' ); ?></title>

		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php bloginfo( 'name' ); ?> RSS feed" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="shortcut icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon.ico" />

		<?php wp_head();?>

	</head>
	
	<body <?php body_class(); ?>>
	
		<header id="header" class="container">
		
			<div class="container-inner">
				
				<div id="logo">

					<p id="sitename">
						<a itemprop="url" href="<?php echo site_url(); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>
					</p>

					<p id="description">
						<?php bloginfo( 'description' ); ?>
					</p>

				</div>	
				
				<div id="mobile">

					<div id="mobile-search" data-toggle="#search">
						<i class="fa fa-search"></i>
					</div>

					<div id="mobile-navigation" data-toggle="#main-navigation">
						<i class="fa fa-reorder"></i>
					</div>

				</div>

				<nav id="topnav">				
					<?php
						wp_nav_menu( array(
							'depth'          => 1,
							'fallback_cb'    => null,
							'theme_location' => 'topnav',
						) ); 
					?>
				</nav>

				<div id="search">
					<?php get_search_form(); ?>
				</div>

			</div><!-- .container-inner -->

		</header><!-- #header -->

		<nav id="main-navigation" class="container">

			<div class="container-inner">

				<?php 
					wp_nav_menu( array(
						'theme_location' => 'mainnav',
					) );
				?>

			</div> <!-- .container-inner -->

		</nav> <!-- #main-navigation -->

		<?php if ( ! is_front_page() ) { ?>

			<nav id="breadcrumbs" class="container">
			
				<div class="container-inner">

					<div id="breadcrumbs-inner">

						<?php
							_e( 'You are here: ', 'tp' );
							tp_breadcrumbs('»'); 
						?>

					</div>

				</div> <!-- .container-inner -->
			
			</nav> <!-- #breadcrumbs -->

		<?php } ?>