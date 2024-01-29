<?php
/**
 * Template part for displaying front page hero content.
 *
 * @package Moral
 */

$counter = get_theme_mod( 'emerge_enable_counter', true );

if ( ! $counter ) {
	return;
}

?>
<div id="counter" class="relative page-section">
    <div class="wrapper">
        <div class="section-content col-3">
        	<?php for ( $i=1; $i <= 3; $i++ ) { ?>
	            <div class="hentry">
	                <div class="statwrap">
	                    <h2 class="stat-count"><?php echo absint( get_theme_mod( 'emerge_counter_count_' . $i ) ); ?></h2>
	                    <h5><?php echo esc_html( get_theme_mod( 'emerge_counter_title_' . $i ) ); ?></h5>
	                </div><!-- .statwrap -->
	            </div><!-- .hentry -->
        	<?php } ?>
        </div><!-- .section-content -->
    </div><!-- .wrapper -->
</div><!-- #counter -->