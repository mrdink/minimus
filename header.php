<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Minimus
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'minimus' ); ?></a>

	<header id="masthead" class="site-header contain-to-grid<?php minimus_fixed_navigation(); ?>" role="banner">
		<nav id="site-navigation" class="main-navigation top-bar" data-topbar role="navigation">
			<ul class="title-area">
		    <li class="name">
		      <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		    </li>
		     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
		    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
		  </ul><!-- .title-area -->

		  <section class="top-bar-section">
				<?php if ( function_exists( 'minimus_build_topbar') ) { ?>
					<?php minimus_build_topbar(); ?>
				<?php } ?>
			</section><!-- .top-bar-section -->
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
