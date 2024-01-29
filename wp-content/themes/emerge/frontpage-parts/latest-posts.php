<?php
/**
 * Template part for displaying front page blog section.
 *
 * @package Moral
 */

// Get default  mods value.
$blog_section = get_theme_mod( 'emerge_blog_section', 'recent-posts' );

if ( 'disable' === $blog_section ) {
	return;
}

$default = emerge_get_default_mods();

?>

<div id="latest-posts" class="relative page-section">
    <div class="wrapper">
        <div class="blog-posts-wrapper">
            <div class="section-header">
            	<?php  
            	$section_title =  get_theme_mod( 'emerge_blog_section_title', $default['emerge_blog_section_title'] );

            	if ( ! empty( $section_title ) ) : ?>
                	<h2 class="section-title"><?php echo esc_html( $section_title ); ?></h2>
            	<?php endif; ?>
            	
            </div><!-- .section-header -->

            <!-- supports col-1, col-2, col-3, col-4 -->
            <?php  
            $post_count = wp_count_posts( 'post' );
            $post_count = $post_count->publish;

            if ( $post_count < 4 ) {
            	$class = $post_count;
            } else {
            	$class = 3;
            }
            ?>
            <div class="section-content col-<?php echo esc_attr( $class ); ?>">
            	<?php  
            	if ( 'recent-posts' === $blog_section ) {
	            	$args = array(
	            			'posts_per_page' => 3,
	            			'ignore_sticky_posts' => true,
	            		);
            	}
            	$query = new WP_Query( $args );

				if ( $query->have_posts() ) :
					while ( $query->have_posts() ) :
						$query->the_post(); ?>
			                <article id="latest-post-01" class="hentry">
			                    <?php if ( has_post_thumbnail() ) : ?>
				                    <div class="featured-image">
				                        <a href="<?php the_permalink(); ?>">
				                        	<?php the_post_thumbnail( 'emerge-home-blog', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
				                        </a>
				                        <div class="overlay"></div>
				                        <div class="read-more">
				                            <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php echo esc_html( get_theme_mod( 'emerge_archive_excerpt', esc_html__( 'View the post', 'emerge' ) ) ); ?></a>
				                        </div><!-- .read-more -->
				                    </div><!-- .featured-image -->
			                    <?php endif; ?>

			                    <div class="entry-container">
			                        <div class="entry-meta">
			                            <?php emerge_posted_on(); ?>
			                            <span class="cat-links"><?php echo get_the_category_list( esc_html__( ', ', 'emerge' ) ); ?></span>
			                        </div><!-- .entry-meta -->

			                        <header class="entry-header">
			                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			                        </header>

			                        <div class="entry-content"><?php the_excerpt(); ?></div><!-- .entry-content -->

			                        <div class="read-more">
			                            <a href="<?php the_permalink(); ?>" class="btn btn-primary"><?php echo esc_html( get_theme_mod( 'emerge_archive_excerpt', esc_html__( 'View the post', 'emerge' ) ) ); ?></a>
			                        </div><!-- .read-more -->
			                    </div><!-- .entry-container -->
			                </article>
			        <?php endwhile; ?>
			        <?php wp_reset_postdata(); ?>
            	<?php endif; ?>
            </div><!-- .section-content -->

            <div class="section-separator"></div>
        </div><!-- .blog-posts-wrapper -->
    </div><!-- .wrapper -->
</div><!-- #latest-posts -->