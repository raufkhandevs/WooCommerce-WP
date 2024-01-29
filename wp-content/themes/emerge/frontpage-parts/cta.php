<?php
/**
 * Template part for displaying front page cta.
 *
 * @package Moral
 */

// Get default  mods value.
$default = emerge_get_default_mods();
$cta = get_theme_mod( 'emerge_cta', 'post' );

if ( 'disable' === $cta ) {
    return;
}

if (  in_array( $cta, array( 'post', 'page' ) ) ) {

    if ( 'post' === $cta ) {
        $ids = get_theme_mod( 'emerge_cta_post' );
    } else {
        $ids = get_theme_mod( 'emerge_cta_page' );
    }

    $query = new WP_Query( array( 'ignore_sticky_posts' => true, 'posts_per_page' => 1, 'post_type' => $cta, 'p' => absint( $ids ) ) );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();

            $img_url   = get_the_post_thumbnail_url( $ids, 'full' );
        ?>
        <div id="call-to-action" class="relative page-section" style="background-image: url('<?php echo esc_url( $img_url );?>' );">
            <div class="overlay"></div>
            <div class="wrapper">
                <div class="section-header">
                    <h2 class="section-title"><?php the_title(); ?></h2>
                </div><!-- .section-header -->

                <div class="section-content"><?php the_excerpt(); ?></div><!-- .section-content -->
                <div class="read-more">
                    <a href="<?php the_permalink(); ?>" class="btn btn-white"><?php echo esc_html__( 'Show More', 'emerge' ); ?></a>
                </div><!-- .read-more -->
            </div><!-- .wrapper -->
        </div><!-- #call-to-action -->
        <?php
        }
        wp_reset_postdata();
    }
}
