<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Moral
 */

get_header(); ?>
    
    <div id="page-header">
        <div class="wrapper">
            <header class="page-header">
				<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'emerge' ); ?></h1>
			</header><!-- .page-header -->
        </div><!-- #page-header -->
    </div><!-- #page-header -->

	<div id="inner-content-wrapper" class="page-section">
        <div class="wrapper">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <div class="single-post-wrapper">

						<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'emerge' ); ?></p>

						<?php get_search_form(); ?>
					</div>
				</main><!-- #main -->
			</div><!-- #primary -->
            
            <?php get_sidebar(); ?>

		</div><!-- .wrapper -->
    </div><!-- #inner-content-wrapper-->

<?php
get_footer();
