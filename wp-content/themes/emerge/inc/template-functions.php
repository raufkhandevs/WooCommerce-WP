<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Moral
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function emerge_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	$classes[] = 'classic-menu';

	// When  hero content is enabled or disabled.
	$hero_content = get_theme_mod( 'emerge_hero_content', 'post' );
	if( emerge_is_frontpage() ) {
		if ( 'disable' === $hero_content ) {
			$classes[] =  'relative-header';
		}
	} else {
		$classes[] = 'relative-header';
	}

	// When  color scheme is light or dark.
	$classes[] =  'lite-version';
	
	// When global archive layout is checked.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'right-sidebar';
	} else {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'emerge_body_classes' );

function emerge_post_classes( $classes ) {
	if ( emerge_is_page_displays_posts() ) {
		// Search 'has-post-thumbnail' returned by default and remove it.
		$key = array_search( 'has-post-thumbnail', $classes );
		unset( $classes[ $key ] );
		
		if( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		} else {
			$classes[] = 'no-post-thumbnail';
		}
	}

	return $classes;
}
add_filter( 'post_class', 'emerge_post_classes' );

/**
 * Excerpt length
 * 
 * @since Moral 1.0.0
 * @return Excerpt length
 */
function emerge_excerpt_length( $length ){
	if ( is_admin() ) {
		return $length;
	}

	$length = get_theme_mod( 'emerge_archive_excerpt_length', 60 );
	return $length;
}
add_filter( 'excerpt_length', 'emerge_excerpt_length', 999 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function emerge_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'emerge_pingback_header' );

/**
 * Get an array of post id and title.
 * 
 */
function emerge_get_post_choices() {
	$choices = array( '' => esc_html__( '--Select--', 'emerge' ) );
	$args = array( 'numberposts' => -1, );
	$posts = get_posts( $args );

	foreach ( $posts as $post ) {
		$id = $post->ID;
		$title = $post->post_title;
		$choices[ $id ] = $title;
	}

	return $choices;
}

/**
 * Checks to see if we're on the homepage or not.
 */
function emerge_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Your latest posts".
 */
function emerge_is_latest_posts() {
	return ( is_front_page() && is_home() );
}

/**
 * Checks to see if Static Front Page is set to "Posts page".
 */
function emerge_is_frontpage_blog() {
	return ( is_home() && ! is_front_page() );
}

/**
 * Checks to see if the current page displays any kind of post listing.
 */
function emerge_is_page_displays_posts() {
	return ( emerge_is_frontpage_blog() || is_search() || is_archive() || emerge_is_latest_posts() );
}

/**
 * Pagination in archive/blog/search pages.
 */
function emerge_posts_pagination() { 
	the_posts_pagination();
}