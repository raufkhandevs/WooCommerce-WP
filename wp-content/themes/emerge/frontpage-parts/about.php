<?php
/**
 * Template part for displaying front page about.
 *
 * @package Moral
 */
// Get default  mods value.
$default = emerge_get_default_mods();

// Get the content type.
$about = get_theme_mod( 'emerge_about', 'post' );

// Bail if the section is disabled.
if ( 'disable' === $about ) {
	return;
}

// Query if the content type is either post or page.
if (  in_array( $about, array( 'post', 'page' ) ) ) {

	if ( 'post' === $about ) {
		$ids = get_theme_mod( 'emerge_about_post' );
	} else {
		$ids = get_theme_mod( 'emerge_about_page' );
	}

	$query = new WP_Query( array( 'ignore_sticky_posts' => true, 'posts_per_page' => 1, 'post_type' => $about, 'p' => absint( $ids ) ) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			?>
			<div id="about-us" class="relative page-section">
			    <div class="wrapper">
			        <div class="section-header">
			            <h2 class="section-title"><?php the_title(); ?></h2>
			        </div><!-- .section-header -->

			        <?php $class = ( has_post_thumbnail() ) ? 'has-featured-image' : 'no-featured-image' ; ?>
			        <article class="<?php echo esc_attr( $class ); ?>">
			        	<?php if ( has_post_thumbnail() ) : ?>
				            <div class="featured-image">  
				                <?php the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
				            </div><!-- .featured-image -->
			        	<?php endif; ?>

			            <div class="entry-container">
			                <div class="section-header">
			                    <h2 class="section-title"><?php the_title(); ?></h2>
			                </div><!-- .section-header -->

			                <div class="entry-content">
			                	<?php the_excerpt(); ?>
			                </div><!-- .entry-content -->

			                <div class="read-more">
			                    <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php echo esc_html__( 'Read More', 'emerge' ); ?></a>
			                </div><!-- .read-more -->
			            </div><!-- .entry-container -->
			        </article>
			    </div><!-- .wrapper -->
			</div><!-- #about-us -->
		<?php
		}
		wp_reset_postdata();
	}
}
