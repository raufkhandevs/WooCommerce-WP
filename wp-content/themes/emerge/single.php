<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Moral
 */

get_header(); ?>

	<div id="inner-content-wrapper" class="page-section">
        <div class="wrapper">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <div class="single-post-wrapper">
						<?php
						while ( have_posts() ) : the_post();

							get_template_part( 'template-parts/content', 'single' );
							?>
					</div>
							<?php
							the_post_navigation( array(
									'prev_text'          => emerge_get_svg( array( 'icon' => 'left-arrow' ) ) . '<span class="prev">' . esc_html__( 'Previous', 'emerge' ) . '</span><span>%title</span>',
									'next_text'          => '<span class="next">' . esc_html__( 'Next', 'emerge' ) . '</span><span>%title</span>' . emerge_get_svg( array( 'icon' => 'left-arrow' ) ),
								) );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile; // End of the loop.
						?>
				</main><!-- #main -->
			</div><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!-- .wrapper -->
    </div><!-- #inner-content-wrapper-->
<?php
get_footer();
