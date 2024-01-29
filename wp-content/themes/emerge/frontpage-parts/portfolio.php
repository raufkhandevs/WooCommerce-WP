<?php
/**
 * Template part for displaying front page hero content.
 *
 * @package Moral
 */

// Get default  mods value.
$portfolio = get_theme_mod( 'emerge_portfolio', 'post' );

if ( 'disable' === $portfolio ) {
	return;
}

$default = emerge_get_default_mods();
$section_title = get_theme_mod( 'emerge_portfolio_title', $default['emerge_portfolio_title'] );
?>
<div id="latest-portfolios" class="relative page-section">
    <div class="wrapper">
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
        </div><!-- .section-header -->

        <div class="section-content">
            <div class="grid">
				<?php
				if (  in_array( $portfolio, array( 'post', 'page' ) ) ) {
					$id_arr = array();
					for ( $i=1; $i <= 6; $i++ ) { 
						$ids = get_theme_mod( "emerge_portfolio_{$portfolio}_" . $i );
						if ( $ids ) {
							$id_arr[] = $ids;
						}
					}

					$args = array(
						'post_type' => $portfolio,
                		'order'	=> 'ASC',
						'post__in' => (array)$id_arr,	
                		'orderby' => 'post__in',
						'posts_per_page' => 6,
						'ignore_sticky_posts' => true,
					);

					$query = new WP_Query( $args );

					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							?>
							<div class="grid-item">
				                <div class="grid-inner-wrapper">
				                    <div class="overlay"></div>
				                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?></a>
				                    <div class="hover-item">
				                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
				                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
				                    </div><!-- .hover-item -->
				                </div><!-- .grid-inner-wrapper -->
				            </div><!-- .grid-item -->
						<?php	
						}
						wp_reset_postdata();
					}
				}
				?>
            </div><!-- .grid -->
        </div><!-- .section-content -->
    </div><!-- .wrapper -->
</div><!-- #latest-portfolios -->