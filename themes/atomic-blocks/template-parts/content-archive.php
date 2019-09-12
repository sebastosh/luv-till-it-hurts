<?php
/**
 * The template used for displaying standard post content
 *
 * @package Atomic Blocks
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="archive-content">

		<header class="entry-header">
			<?php if( is_single() ) { ?>
				<h1 class="entry-title">
			POOOPSS		<?php the_title(); ?>
				</h1>
			<?php } else { ?>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			<?php } ?>

			<?php atomic_blocks_post_byline(); ?>
		</header>

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="featured-image">
					<?php the_post_thumbnail( 'atomic-blocks-featured-image' ); echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
			</div>
		<?php } ?>

		<div class="entry-content">

			<?php

			// Post pagination links
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'atomic-blocks' ),
				'after'  => '</div>',
			) );

			if ( is_single()  ) {

				// Author profile box
				atomic_blocks_author_box();

				// Post navigations
				if( is_archive() ) {
					if( get_next_post() || get_previous_post() ) {
						atomic_blocks_post_navs();
				} }

			} ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
