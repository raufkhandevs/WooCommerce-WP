<?php
/**
 * Template part for displaying search results
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Moral
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="featured-post-image">
		    <a href="<?php the_permalink(); ?>">
		        <div class="featured-image" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>);">
		        </div><!-- .featured-image -->
		    </a>
		</div><!-- .featured-post-image -->
	<?php endif; ?>

	<div class="entry-container">
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php emerge_posted_on(); ?>
				<?php emerge_entry_footer(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

		<?php emerge_post_author(); ?>

		<div class="read-more-link">
		    <a href="<?php the_permalink(); ?>"><?php echo esc_html__( 'View the Post', 'emerge' ); ?></a>
		</div><!-- .read-more -->

    </div><!-- .entry-container -->
</article><!-- #post-<?php the_ID(); ?> -->
