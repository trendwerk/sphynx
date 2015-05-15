<!DOCTYPE html>

<!--[if lte IE 8]>
	<html class="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if gt IE 8]>
	<html <?php language_attributes(); ?>>
<![endif]-->

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php bloginfo( 'name' ); ?> RSS feed" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="shortcut icon" type="image/png" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/favicon.ico" />

		<?php wp_head(); ?>

	</head>
	
	<body <?php body_class(); ?>>
	
		<header id="header" class="container">
		
			<div class="container-inner">

				<div id="mobile-search" data-toggle="#search">
					<div class="glass"></div>
				</div>

				<div id="mobile-navigation" data-toggle="#main-navigation">
					<div class="burger">
						<div class="line"></div>
						<div class="line"></div>
						<div class="line"></div>
					</div>
				</div>
				
				<div id="logo">

					<p id="sitename">
						<a href="<?php echo home_url(); ?>">
							<?php bloginfo( 'name' ); ?>
						</a>
					</p>

					<p id="description">
						<?php bloginfo( 'description' ); ?>
					</p>

				</div>

				<div id="search">
					<?php get_search_form(); ?>
				</div>

			</div>

		</header>

		<nav id="main-navigation" class="container">

			<div class="container-inner">

				<?php 
					wp_nav_menu( array(
						'theme_location' => 'main',
						'depth'          => 2,
					) );
				?>

			</div>

		</nav>
