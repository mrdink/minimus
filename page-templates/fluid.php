<?php
/**
 * Template Name: Fluid
 *
 * @package Minimus
 */

get_header(); ?>

	<div id="content" class="site-content fluid">
		<div id="primary" class="content-area full-width">
			<main id="main" class="site-main" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->
		</div><!-- #primary -->
	</div><!-- #content -->

<?php get_footer(); ?>
