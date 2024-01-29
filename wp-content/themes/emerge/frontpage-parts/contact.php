<?php
/**
 * Template part for displaying front page contact.
 *
 * @package Moral
 */
// Get default  mods value.
$default = emerge_get_default_mods();

// Get the content type.
$contact = get_theme_mod( 'emerge_enable_contact', true );

// Bail if the section is disabled.
if ( ! $contact ) {
	return;
}
?>

<div id="contact-form" class="relative page-section">
    <div class="wrapper">
        <div class="section-header">
        	<?php  
        	$titles   = get_theme_mod( 'emerge_contact_title', $default['emerge_contact_title'] );

        	if ( ! empty( $titles ) ) : ?>
            	<h2 class="section-title"><?php echo esc_html( $titles ); ?></h2>
        	<?php endif;  ?>
        </div><!-- .section-header -->

        <?php 
        $contact_shortcode = get_theme_mod( 'emerge_contact_shortcode' );
        if ( ! empty( $contact_shortcode ) ) : ?>
	    	<div class="section-content">
	    		<?php echo do_shortcode( wp_kses_post( $contact_shortcode ) ); ?>
	        </div><!-- .section-content -->
    	<?php endif; ?>
    </div><!-- .wrapper -->
</div><!-- #contact-form -->