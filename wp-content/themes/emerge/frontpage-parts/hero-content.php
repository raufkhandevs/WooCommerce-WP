<?php
/**
 * Template part for displaying front page hero content.
 *
 * @package Moral
 */

// Get default  mods value.
$default = emerge_get_default_mods();
$hero_content = get_theme_mod( 'emerge_hero_content', 'post' );

if ( 'disable' === $hero_content ) {
	return;
}

if (  in_array( $hero_content, array( 'post', 'page' ) ) ) {

	if ( 'post' === $hero_content ) {
		$ids = get_theme_mod( 'emerge_hero_content_post' );
	} else {
		$ids = get_theme_mod( 'emerge_hero_content_page' );
	}

	$query = new WP_Query( array( 'ignore_sticky_posts' => true, 'posts_per_page' => 1, 'post_type' => $hero_content, 'p' => absint( $ids ) ) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
		?>
		<div id="custom-header-media" class="relative">
		    <div class="overlay"></div>
		    <div id="wp-custom-header" class="wp-custom-header">
		    	<?php the_post_thumbnail( 'full', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
		    </div><!--#wp-custom-header -->

		    <div class="wrapper">
		        <header class="entry-header">
		            <h2 class="entry-title">
		        		<a href="<?php the_permalink(); ?>">
		        		  <?php the_title(); ?>
		        		</a>
		            </h2>
		        </header><!-- .entry-header -->
		    </div><!-- .wrapper -->
		</div><!-- #custom-header-media -->
		<?php
		}
		wp_reset_postdata();
	}
}
