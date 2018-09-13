<?php

$fist = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 330.26 320"><defs><style>.a{fill:#efd01b;}.b{fill:#fff;}</style></defs><title>Pantheon_Fist_color_rev</title><rect width="330.26" height="320"/><polygon class="a" points="118.24 19.41 144.08 80 111.19 80 122.07 106.67 188.72 106.67 118.24 19.41"/><polygon class="a" points="205.87 240 194.87 213.33 179.62 213.33 157.83 162.05 144.16 162.05 165.93 213.33 127.18 213.33 198.83 300.6 172.99 240 205.87 240"/><path class="b" d="M214.75,133.1c0.81,0,2.69-1,2.69-10.27s-1.88-10.26-2.69-10.26H168.84l8.71,20.53h37.2Z" transform="translate(0 0.25)"/><path class="b" d="M188,157.71h30.84c0.82,0,2.69-1,2.69-10.27s-1.88-10.26-2.69-10.26H179.29Z" transform="translate(0 0.25)"/><path class="b" d="M214.75,186.42H173.27L182,206.94h32.77c0.81,0,2.69-1,2.69-10.26S215.55,186.42,214.75,186.42Z" transform="translate(0 0.25)"/><path class="b" d="M218.84,161.8h-56l8.71,20.53h47.31c0.82,0,2.69-1,2.69-10.26S219.66,161.8,218.84,161.8Z" transform="translate(0 0.25)"/><path class="b" d="M214.75,186.42H173.27L182,206.94h32.77c0.81,0,2.69-1,2.69-10.26S215.55,186.42,214.75,186.42Z" transform="translate(0 0.25)"/><path class="b" d="M218.84,161.8h-56l8.71,20.53h47.31c0.82,0,2.69-1,2.69-10.26S219.66,161.8,218.84,161.8Z" transform="translate(0 0.25)"/><path class="b" d="M156.09,157.71l-10.45-24.62h5l10.45,24.62h22.19L164.1,112.57H116.26c-3.69,0-5.71,0-7.37,5.34-2,6.38-2.22,18.41-2.22,41.84s0.23,35.46,2.22,41.84c1.66,5.34,3.68,5.34,7.37,5.34h42l-20.8-49.24h18.66Z" transform="translate(0 0.25)"/><path class="b" d="M223.87,200.92a8.19,8.19,0,0,1,.68-3.32,8.68,8.68,0,0,1,4.54-4.54,8.46,8.46,0,0,1,6.63,0,8.68,8.68,0,0,1,4.54,4.54,8.46,8.46,0,0,1,0,6.63,8.68,8.68,0,0,1-4.54,4.54,8.46,8.46,0,0,1-6.63,0,8.68,8.68,0,0,1-4.54-4.54A8.19,8.19,0,0,1,223.87,200.92Zm1.51,0a6.86,6.86,0,0,0,.55,2.73,7,7,0,0,0,3.74,3.74,7,7,0,0,0,5.46,0,7,7,0,0,0,3.74-3.74,7,7,0,0,0,0-5.46,7,7,0,0,0-3.74-3.74,7,7,0,0,0-5.46,0,7,7,0,0,0-3.74,3.74A6.86,6.86,0,0,0,225.39,200.92Zm3.74-4.93h3.76a3.8,3.8,0,0,1,2.6.76,2.79,2.79,0,0,1,.84,2.18,2.58,2.58,0,0,1-.66,1.93,2.75,2.75,0,0,1-1.66.76l2.52,4.13h-1.88l-2.43-4h-1.31v4h-1.79V196Zm1.79,4.25h1.31q0.41,0,.83,0a2.48,2.48,0,0,0,.75-0.17,1.26,1.26,0,0,0,.54-0.41,1.49,1.49,0,0,0,0-1.51,1.26,1.26,0,0,0-.54-0.41,2.27,2.27,0,0,0-.75-0.16l-0.83,0h-1.31v2.73Z" transform="translate(0 0.25)"/></svg>';
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="hfeed site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">


        <nav class="navbar navbar-expand-md navbar-dark bg-university-global">
            <div class="container" >
                <!-- <img src="<?php print get_theme_root_uri() . '/understrap-child/Pantheon_Fist_color_rev.svg' ?>" />   -->
            <h1>Demo University</h1>
            </div>
        </nav>

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>

		<nav class="navbar navbar-expand-md navbar-dark bg-department">

		<?php if ( 'container' == $container ) : ?>
			<div class="container" >
		<?php endif; ?>

					<!-- Your site title as branding in the menu -->
					<?php if ( ! has_custom_logo() ) { ?>

						<?php if ( is_front_page() && is_home() ) : ?>

							<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>

						<?php else : ?>

							<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="url"><?php bloginfo( 'name' ); ?></a>

						<?php endif; ?>


					<?php } else {
						the_custom_logo();
					} ?><!-- end custom logo -->

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- The WordPress Menu goes here -->
				<?php wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'navbarNavDropdown',
						'menu_class'      => 'navbar-nav ml-auto',
						'fallback_cb'     => '',
						'menu_id'         => 'main-menu',
						'depth'           => 2,
						'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
					)
				); ?>
			<?php if ( 'container' == $container ) : ?>
			</div><!-- .container -->
			<?php endif; ?>

		</nav><!-- .site-navigation -->

	</div><!-- #wrapper-navbar end -->
