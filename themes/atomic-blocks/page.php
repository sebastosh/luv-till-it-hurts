<?php
/**
 * The template for displaying default pages.
 *
 * @package Atomic Blocks
 */

get_header(); ?>

<div class="sidebar">
	<?php if ( is_active_sidebar( 'page-sidebar' ) ) : ?>
		<div class="side-widgets">
			<?php if ( is_active_sidebar( 'page-sidebar' ) ) { ?>
				<div class="side-column">
					<?php dynamic_sidebar( 'page-sidebar' ); ?>
				</div>
			<?php } ?>
		</div>
	<?php endif; ?>
</div><!-- .side-bottom -->
</div><!-- .sidebar -->


	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php while ( have_posts() ) : the_post();

				// Page content template
				get_template_part( 'template-parts/content-page' );

			endwhile; ?>


		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
