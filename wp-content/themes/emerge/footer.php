<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Moral
 */

$default = emerge_get_default_mods();
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<!-- supports col-1, col-2, col-3 and col-4 -->
		<!-- supports unequal-width and equal-width -->
		<?php  
		$count = 0;
		for ( $i=1; $i <=3 ; $i++ ) { 
			if ( is_active_sidebar( 'footer-' . $i ) ) {
				$count++;
			}
		}
		
		if ( 0 !== $count ) : ?>
			<div class="footer-widget-area page-section unequal-width col-<?php echo esc_attr( $count );?>">
			    <div class="wrapper">
					<?php 
					for ( $j=1; $j <=3; $j++ ) { 
						if ( is_active_sidebar( 'footer-' . $j ) ) {
			    			echo '<div class="hentry">';
							dynamic_sidebar( 'footer-' . $j ); 
							echo "</div>";
						}
					}
					?>
				</div><!-- .wrapper -->
			</div><!-- .footer-widget-area -->

		<?php endif;

		$footer_menu = get_theme_mod( 'emerge_enable_footer_social_menu', true );
		$footer_text = get_theme_mod( 'emerge_enable_footer_text', true );

		if ( $footer_menu || $footer_text ) :
		?>
			<div class="site-info">
				<!-- supports col-1 and col-2 -->
				<?php 

				$class = ( $footer_menu && $footer_text ) ? 'col-2' : 'col-1' ;
				?>
				<div class="wrapper <?php echo esc_attr( $class ); ?>">
					<?php if ( $footer_text ) { ?>
					    <div class="footer-copyright">
					    <?php echo esc_html( get_theme_mod( 'emerge_footer_copyright_text', __( 'All Right Reserve.', 'emerge' ) ) ); ?>
					        <?php printf( esc_html__( 'Theme: Emerge by %1$s.', 'emerge' ), '<a href="' . esc_url( 'http://moralthemes.com/' ) . '">Moral Themes</a>' )?>
					    </div><!-- .footer-copyright -->
					<?php } ?>
				    
				    <?php if ( $footer_menu && has_nav_menu( 'social' ) ) :
						wp_nav_menu( array(
							'theme_location' => 'social',
							'menu_class'	 => 'social-icons',
							'container_class' => 'social-menu',
							'depth'          => 1,
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>' . emerge_get_svg( array( 'icon' => 'chain' ) ),
						) );
				    endif; ?>
				</div><!-- .wrapper -->    
				
			</div><!-- .site-info -->
		<?php endif; ?>
	</footer><!-- #colophon -->
	
	<div class="menu-overlay"></div>

	<?php  
	$backtop = get_theme_mod( 'emerge_back_to_top_enable', true );
	if ( $backtop ) { ?>
		<div class="backtotop"><?php echo emerge_get_svg( array( 'icon' => 'up-arrow' ) ); ?></div>
	<?php }	?>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
