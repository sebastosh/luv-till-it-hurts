<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Atomic Blocks
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="post-content">
		<header class="entry-header">
			<?php if( is_front_page() ) { ?>

			<?php } else { ?>
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			<?php } ?>
		</header>

		<?php if ( has_post_thumbnail() ) { ?>
			<div class="featured-image">
				<?php the_post_thumbnail( 'atomic-blocks-featured-image' ); echo get_post(get_post_thumbnail_id())->post_excerpt; ?>
			</div>
		<?php } ?>

		<div class="entry-content">

			<?php
			// Get the content
			the_content( esc_html__( 'Read More', 'atomic-blocks' ) );

			// Post pagination links
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'atomic-blocks' ),
				'after'  => '</div>',
			) );

			// Comments template
			comments_template(); ?>
		</div><!-- .entry-content -->
	</div><!-- .post-content-->

</article><!-- #post-## -->
