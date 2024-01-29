<?php
/**
 * Moral Theme Customizer
 *
 * @package Moral
 */

/**
 * Get all the default values of the theme mods.
 */
function emerge_get_default_mods() {
	$emerge_default_mods = array(
		// Portfolio
		'emerge_portfolio_title' => esc_html__( 'Our Portfolio', 'emerge' ),

		// Blog section
		'emerge_blog_section_title' => esc_html__( 'Latest From Blog', 'emerge' ),

		// Contact section
		'emerge_contact_title' => esc_html__( 'Get in Touch', 'emerge' ),
	);

	return apply_filters( 'emerge_default_mods', $emerge_default_mods );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function emerge_customize_register( $wp_customize ) {
	$default = emerge_get_default_mods();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'emerge_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'emerge_customize_partial_blogdescription',
		) );
	}

	// Header text display setting
	$wp_customize->add_setting(	
		'emerge_header_text_display',
		array(
			'sanitize_callback' => 'emerge_sanitize_checkbox',
			'default' => true,
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'emerge_header_text_display',
		array(
			'section'		=> 'title_tagline',
			'type'			=> 'checkbox',
			'label'			=> esc_html__( 'Display Site Title and Tagline', 'emerge' ),
		)
	);

	// Header title color setting
	$wp_customize->add_setting(	
		'emerge_header_title_color',
		array(
			'sanitize_callback' => 'emerge_sanitize_hex_color',
			'default' => '#cf3140',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'emerge_header_title_color',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Header Text Color:', 'emerge' ),
			)
		)
	);

	// Header tagline color setting
	$wp_customize->add_setting(	
		'emerge_header_tagline',
		array(
			'sanitize_callback' => 'emerge_sanitize_hex_color',
			'default' => '#2e2e2e',
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control( 
		$wp_customize,
			'emerge_header_tagline',
			array(
				'section'		=> 'colors',
				'label'			=> esc_html__( 'Header Tagline Color:', 'emerge' ),
			)
		)
	);

	// Your latest posts title setting
	$wp_customize->add_setting(	
		'emerge_your_latest_posts_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'Blogs', 'emerge' ),
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'emerge_your_latest_posts_title',
		array(
			'section'		=> 'static_front_page',
			'label'			=> esc_html__( 'Title:', 'emerge' ),
			'active_callback' => 'emerge_is_latest_posts'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'emerge_your_latest_posts_title', 
		array(
	        'selector'            => '.home.blog #page-header .page-title',
			'render_callback'     => 'emerge_your_latest_posts_partial_title',
    	) 
    );

	/**
	 *
	 * 
	 * Home sections panel
	 *
	 * 
	 */
	// Home sections panel
	$wp_customize->add_panel(
		'emerge_home_panel',
		array(
			'title' => esc_html__( 'Homepage Sections Settings', 'emerge' ),
			'priority' => 130
		)
	);

	// Hero content section
	$wp_customize->add_section(
		'emerge_hero_content',
		array(
			'title' => esc_html__( 'Hero Content', 'emerge' ),
			'panel' => 'emerge_home_panel',
		)
	);

	// Hero content enable settings
	$wp_customize->add_setting(
		'emerge_hero_content',
		array(
			'sanitize_callback' => 'emerge_sanitize_select',
			'default' => 'post'
		)
	);

	$wp_customize->add_control(
		'emerge_hero_content',
		array(
			'section'		=> 'emerge_hero_content',
			'label'			=> esc_html__( 'Content type:', 'emerge' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'emerge' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'emerge' ),
					'post' => esc_html__( 'Post', 'emerge' ),
					'page' => esc_html__( 'Page', 'emerge' ),
			 	)
		)
	);

	// Hero content post setting
	$wp_customize->add_setting(
		'emerge_hero_content_post',
		array(
			'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'emerge_hero_content_post',
		array(
			'section'		=> 'emerge_hero_content',
			'label'			=> esc_html__( 'Post:', 'emerge' ),
			'active_callback' => 'emerge_if_hero_content_post',
			'type'			=> 'select',
			'choices'		=> emerge_get_post_choices(),
		)
	);

	// Hero content page setting
	$wp_customize->add_setting(
		'emerge_hero_content_page',
		array(
			'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'emerge_hero_content_page',
		array(
			'section'		=> 'emerge_hero_content',
			'label'			=> esc_html__( 'Page:', 'emerge' ),
			'type'			=> 'dropdown-pages',
			'active_callback' => 'emerge_if_hero_content_page'
		)
	);

	/**
	 * About section
	 */
	// About section
	$wp_customize->add_section(
		'emerge_about',
		array(
			'title' => esc_html__( 'About', 'emerge' ),
			'panel' => 'emerge_home_panel',
		)
	);

	// About enable settings
	$wp_customize->add_setting(
		'emerge_about',
		array(
			'sanitize_callback' => 'emerge_sanitize_select',
			'default' => 'post'
		)
	);

	$wp_customize->add_control(
		'emerge_about',
		array(
			'section'		=> 'emerge_about',
			'label'			=> esc_html__( 'Content type:', 'emerge' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'emerge' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'emerge' ),
					'post' => esc_html__( 'Post', 'emerge' ),
					'page' => esc_html__( 'Page', 'emerge' ),
			 	)
		)
	);

	// About post setting
	$wp_customize->add_setting(
		'emerge_about_post',
		array(
			'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'emerge_about_post',
		array(
			'section'		=> 'emerge_about',
			'label'			=> esc_html__( 'Post:', 'emerge' ),
			'active_callback' => 'emerge_if_about_post',
			'type'			=> 'select',
			'choices'		=> emerge_get_post_choices(),
		)
	);

	// About page setting
	$wp_customize->add_setting(
		'emerge_about_page',
		array(
			'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'emerge_about_page',
		array(
			'section'		=> 'emerge_about',
			'label'			=> esc_html__( 'Page:', 'emerge' ),
			'type'			=> 'dropdown-pages',
			'active_callback' => 'emerge_if_about_page'
		)
	);

	/**
	 * CTA section
	 */
	// CTA section
	$wp_customize->add_section(
		'emerge_cta',
		array(
			'title' => esc_html__( 'Call to action', 'emerge' ),
			'panel' => 'emerge_home_panel',
		)
	);

	// CTA enable settings
	$wp_customize->add_setting(
		'emerge_cta',
		array(
			'sanitize_callback' => 'emerge_sanitize_select',
			'default' => 'post'
		)
	);

	$wp_customize->add_control(
		'emerge_cta',
		array(
			'section'		=> 'emerge_cta',
			'label'			=> esc_html__( 'Content type:', 'emerge' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'emerge' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'emerge' ),
					'post' => esc_html__( 'Post', 'emerge' ),
					'page' => esc_html__( 'Page', 'emerge' ),
			 	)
		)
	);

	// CTA post setting
	$wp_customize->add_setting(
		'emerge_cta_post',
		array(
			'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'emerge_cta_post',
		array(
			'section'		=> 'emerge_cta',
			'label'			=> esc_html__( 'Post:', 'emerge' ),
			'active_callback' => 'emerge_if_cta_post',
			'type'			=> 'select',
			'choices'		=> emerge_get_post_choices(),
		)
	);

	// CTA page setting
	$wp_customize->add_setting(
		'emerge_cta_page',
		array(
			'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
		)
	);

	$wp_customize->add_control(
		'emerge_cta_page',
		array(
			'section'		=> 'emerge_cta',
			'label'			=> esc_html__( 'Page:', 'emerge' ),
			'type'			=> 'dropdown-pages',
			'active_callback' => 'emerge_if_cta_page'
		)
	);

	/**
	 * Portfolio section
	 */
	// Portfolio section
	$wp_customize->add_section(
		'emerge_portfolio',
		array(
			'title' => esc_html__( 'Portfolio', 'emerge' ),
			'description'			=> __( 'The content from post and page is trimmed to 15 words.<b>Please note that posts with no featured image will not be displayed.</b>', 'emerge' ),
			'panel' => 'emerge_home_panel',
		)
	);

	// Portfolio enable settings
	$wp_customize->add_setting(
		'emerge_portfolio',
		array(
			'sanitize_callback' => 'emerge_sanitize_select',
			'default' => 'post'
		)
	);

	$wp_customize->add_control(
		'emerge_portfolio',
		array(
			'section'		=> 'emerge_portfolio',
			'label'			=> esc_html__( 'Content type:', 'emerge' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from.', 'emerge' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'emerge' ),
					'post' => esc_html__( 'Post', 'emerge' ),
					'page' => esc_html__( 'Page', 'emerge' ),
			 	)
		)
	);

	// Portfolio title setting
	$wp_customize->add_setting(
		'emerge_portfolio_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['emerge_portfolio_title'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'emerge_portfolio_title',
		array(
			'section'		=> 'emerge_portfolio',
			'label'			=> esc_html__( 'Title:', 'emerge' ),
			'active_callback' => 'emerge_if_portfolio_not_disabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'emerge_portfolio_title', 
		array(
	        'selector'            => '#latest-portfolios .section-title',
			'render_callback'     => 'emerge_portfolio_partial_title',
    	) 
    );

	for ( $i=1; $i <= 6; $i++ ) { 
		// Portfolio post setting
		$wp_customize->add_setting(
			'emerge_portfolio_post_' . $i,
			array(
				'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'emerge_portfolio_post_' . $i,
			array(
				'section'		=> 'emerge_portfolio',
				'label'			=> esc_html__( 'Post ', 'emerge' ) . $i,
				'active_callback' => 'emerge_if_portfolio_post',
				'type'			=> 'select',
				'choices'		=> emerge_get_post_choices(),
			)
		);

		// Portfolio page setting
		$wp_customize->add_setting(
			'emerge_portfolio_page_' . $i,
			array(
				'sanitize_callback' => 'emerge_sanitize_dropdown_pages',
			)
		);

		$wp_customize->add_control(
			'emerge_portfolio_page_' . $i,
			array(
				'section'		=> 'emerge_portfolio',
				'label'			=> esc_html__( 'Page ', 'emerge' ) . $i,
				'type'			=> 'dropdown-pages',
				'active_callback' => 'emerge_if_portfolio_page'
			)
		);
	}

	/**
	 * Counter section
	 */
	// Counter section
	$wp_customize->add_section(
		'emerge_counter',
		array(
			'title' => esc_html__( 'Counter', 'emerge' ),
			'panel' => 'emerge_home_panel',
		)
	);

	// Counter enable setting
	$wp_customize->add_setting(
		'emerge_enable_counter',
		array(
			'sanitize_callback' => 'emerge_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'emerge_enable_counter',
		array(
			'section'		=> 'emerge_counter',
			'label'			=> esc_html__( 'Enable counter.', 'emerge' ),
			'type'			=> 'checkbox',
		)
	);

	$counter_num = get_theme_mod( 'emerge_counter_num', 4 );
	for ( $i=1; $i <= 3; $i++ ) { 
		// Counter title setting
		$wp_customize->add_setting(
			'emerge_counter_title_' . $i,
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		$wp_customize->add_control(
			'emerge_counter_title_' . $i,
			array(
				'section'		=> 'emerge_counter',
				'label'			=> esc_html__( 'Title ', 'emerge' ) . $i,
				'active_callback' => 'emerge_if_counter_enable'
			)
		);

		// Counter count setting
		$wp_customize->add_setting(
			'emerge_counter_count_' . $i,
			array(
				'sanitize_callback' => 'emerge_sanitize_number_range',
				'capability' => 'manage_options'
			)
		);

		$wp_customize->add_control(
			'emerge_counter_count_' . $i,
			array(
				'section'		=> 'emerge_counter',
				'label'			=> esc_html__( 'Count ', 'emerge' ) . $i,
				'active_callback' => 'emerge_if_counter_enable',
				'type'			=> 'number',
				'input_attrs'	=> array( 'min' => 1 ),
			)
		);
	}

	/**
	 * Blog section section
	 */
	// Blog section section
	$wp_customize->add_section(
		'emerge_blog_section',
		array(
			'title' => esc_html__( 'Blog section', 'emerge' ),
			'description' => esc_html__( 'Images will be cropped and displayed in 400px by 300px. The recommended size for this section is 400px by 300px.', 'emerge' ),
			'panel' => 'emerge_home_panel',
		)
	);

	// Blog section enable settings
	$wp_customize->add_setting(
		'emerge_blog_section',
		array(
			'sanitize_callback' => 'emerge_sanitize_select',
			'default' => 'recent-posts'
		)
	);

	$wp_customize->add_control(
		'emerge_blog_section',
		array(
			'section'		=> 'emerge_blog_section',
			'label'			=> esc_html__( 'Content type:', 'emerge' ),
			'description'			=> esc_html__( 'Choose where you want to render the content from. Only 3 posts will be rendered.', 'emerge' ),
			'type'			=> 'select',
			'choices'		=> array( 
					'disable' => esc_html__( '--Disable--', 'emerge' ),
					'recent-posts' => esc_html__( 'Recent Posts', 'emerge' ),
			 	)
		)
	);

	// Blog section title setting
	$wp_customize->add_setting(
		'emerge_blog_section_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['emerge_blog_section_title'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'emerge_blog_section_title',
		array(
			'section'		=> 'emerge_blog_section',
			'label'			=> esc_html__( 'Title:', 'emerge' ),
			'active_callback' => 'emerge_if_blog_section_not_disabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'emerge_blog_section_title', 
		array(
	        'selector'            => '#latest-posts .section-title',
			'render_callback'     => 'emerge_blog_section_partial_title',
    	) 
    );

	/**
	 * Contact section
	 */
	// Contact section
	$wp_customize->add_section(
		'emerge_contact',
		array(
			'title' => esc_html__( 'Contact', 'emerge' ),
			'panel' => 'emerge_home_panel',
		)
	);

	// Contact enable setting
	$wp_customize->add_setting(
		'emerge_enable_contact',
		array(
			'sanitize_callback' => 'emerge_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'emerge_enable_contact',
		array(
			'section'		=> 'emerge_contact',
			'label'			=> esc_html__( 'Enable contact.', 'emerge' ),
			'type'			=> 'checkbox',
		)
	);

	// Contact title setting
	$wp_customize->add_setting(	
		'emerge_contact_title',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => $default['emerge_contact_title'],
			'transport'	=> 'postMessage',
		)
	);

	$wp_customize->add_control(
		'emerge_contact_title',
		array(
			'section'		=> 'emerge_contact',
			'label'			=> esc_html__( 'Title:', 'emerge' ),
			'active_callback' => 'emerge_if_contact_not_disabled'
		)
	);

	$wp_customize->selective_refresh->add_partial( 
		'emerge_contact_title', 
		array(
	        'selector'            => '#contact-form .section-title',
			'render_callback'     => 'emerge_contact_partial_title',
    	) 
    );

    // Contact shortcode setting
	$wp_customize->add_setting(
		'emerge_contact_shortcode',
		array(
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);

	$wp_customize->add_control(
		'emerge_contact_shortcode',
		array(
			'section'		=> 'emerge_contact',
			'label'			=> esc_html__( 'Contact Shortcode:', 'emerge' ),
			'description'			=> sprintf( esc_html__( 'We recommend %1$s Contact Form 7%2$s for the shortcode. When you actavited CF7 then %3$s Click Here %4$s for shortcode.', 'emerge' ), '<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">', '</a>', '<a href="'. admin_url( $paths = '?page=wpcf7', $scheme = 'admin' ) .'" target="_blank">', '</a>' ),
			'active_callback' => 'emerge_if_contact_not_disabled',
			'type'			=> 'textarea',
		)
	);

	/**
	 *
	 * 
	 * Home sections panel
	 *
	 * 
	 */
	// Home sections panel
	$wp_customize->add_panel(
		'emerge_general_panel',
		array(
			'title' => esc_html__( 'General Settings', 'emerge' ),
			'priority' => 140
		)
	);
	
	/**
	 * Blog/Archive section 
	 */
	// Blog/Archive section 
	$wp_customize->add_section(
		'emerge_archive_settings',
		array(
			'title' => esc_html__( 'Archive/Blog', 'emerge' ),
			'description' => esc_html__( 'Settings for archive pages including blog page too.', 'emerge' ),
			'panel' => 'emerge_general_panel',
		)
	);

	// Archive excerpt setting
	$wp_customize->add_setting(
		'emerge_archive_excerpt',
		array(
			'sanitize_callback' => 'sanitize_text_field',
			'default' => esc_html__( 'View the post', 'emerge' ),
		)
	);

	$wp_customize->add_control(
		'emerge_archive_excerpt',
		array(
			'section'		=> 'emerge_archive_settings',
			'label'			=> esc_html__( 'Excerpt more text:', 'emerge' ),
		)
	);

	// Archive excerpt length setting
	$wp_customize->add_setting(
		'emerge_archive_excerpt_length',
		array(
			'sanitize_callback' => 'emerge_sanitize_number_range',
			'default' => 60,
		)
	);

	$wp_customize->add_control(
		'emerge_archive_excerpt_length',
		array(
			'section'		=> 'emerge_archive_settings',
			'label'			=> esc_html__( 'Excerpt more length:', 'emerge' ),
			'type'			=> 'number',
			'input_attrs'   => array( 'min' => 5 ),
		)
	);

	/**
	 * General settings
	 */
	// General settings
	$wp_customize->add_section(
		'emerge_general_section',
		array(
			'title' => esc_html__( 'General', 'emerge' ),
			'panel' => 'emerge_general_panel',
		)
	);

	// Backtop enable setting
	$wp_customize->add_setting(
		'emerge_back_to_top_enable',
		array(
			'sanitize_callback' => 'emerge_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'emerge_back_to_top_enable',
		array(
			'section'		=> 'emerge_general_section',
			'label'			=> esc_html__( 'Enable Scroll up.', 'emerge' ),
			'type'			=> 'checkbox',
		)
	);

	/**
	 * Footer copyright
	 */
	// Footer copyright
	$wp_customize->add_section(
		'emerge_footer_section',
		array(
			'title' => esc_html__( 'Footer section', 'emerge' ),
			'panel' => 'emerge_general_panel',
		)
	);

	// Footer social menu enable setting
	$wp_customize->add_setting(
		'emerge_enable_footer_social_menu',
		array(
			'sanitize_callback' => 'emerge_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'emerge_enable_footer_social_menu',
		array(
			'section'		=> 'emerge_footer_section',
			'label'			=> esc_html__( 'Enable social menu.', 'emerge' ),
			'type'			=> 'checkbox',
		)
	);

	// Archive excerpt setting
	$wp_customize->add_setting(
		'emerge_footer_copyright_text',
		array(
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'emerge_footer_copyright_text',
		array(
			'section'		=> 'emerge_footer_section',
			'label'			=> esc_html__( 'Write Copyright Text:', 'emerge' ),
			'input_attrs' => array(
			    'placeholder' => esc_html__( 'All Right Reserve.', 'emerge' ),
			)
		)
	);

	// Footer text enable setting
	$wp_customize->add_setting(
		'emerge_enable_footer_text',
		array(
			'sanitize_callback' => 'emerge_sanitize_checkbox',
			'default' => true,
		)
	);

	$wp_customize->add_control(
		'emerge_enable_footer_text',
		array(
			'section'		=> 'emerge_footer_section',
			'label'			=> esc_html__( 'Enable footer text.', 'emerge' ),
			'type'			=> 'checkbox',
		)
	);
}
add_action( 'customize_register', 'emerge_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function emerge_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function emerge_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function emerge_customize_preview_js() {
	wp_enqueue_script( 'emerge-customizer', get_theme_file_uri( '/assets/js/customizer.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'emerge_customize_preview_js' );

/**
 *
 * Sanitization callbacks.
 * 
 */

/**
 * Checkbox sanitization callback example.
 * 
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function emerge_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}


/**
 * HEX Color sanitization callback example.
 *
 * - Sanitization: hex_color
 * - Control: text, WP_Customize_Color_Control
 *
 */
function emerge_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );
	
	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 */
function emerge_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Drop-down Pages sanitization callback example.
 *
 * - Sanitization: dropdown-pages
 * - Control: dropdown-pages
 * 
 */
function emerge_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/**
 * Number Range sanitization callback example.
 *
 * - Sanitization: number_range
 * - Control: number, tel
 * 
 */
function emerge_sanitize_number_range( $number, $setting ) {
	
	// Ensure input is an absolute integer.
	$number = absint( $number );
	
	// Get the input attributes associated with the setting.
	$atts = $setting->manager->get_control( $setting->id )->input_attrs;
	
	// Get minimum number in the range.
	$min = ( isset( $atts['min'] ) ? $atts['min'] : $number );
	
	// Get maximum number in the range.
	$max = ( isset( $atts['max'] ) ? $atts['max'] : $number );
	
	// Get step.
	$step = ( isset( $atts['step'] ) ? $atts['step'] : 1 );
	
	// If the number is within the valid range, return it; otherwise, return the default
	return ( $min <= $number && $number <= $max && is_int( $number / $step ) ? $number : $setting->default );
}

/**
 *
 * Active callbacks.
 * 
 */

/**
 * Check if the hero content is page
 */
function emerge_if_hero_content_page( $control ) {
	return 'page' === $control->manager->get_setting( 'emerge_hero_content' )->value();
}

/**
 * Check if the hero content is post
 */
function emerge_if_hero_content_post( $control ) {
	return 'post' === $control->manager->get_setting( 'emerge_hero_content' )->value();
}

/**
 * Check if the about is page
 */
function emerge_if_about_page( $control ) {
	return 'page' === $control->manager->get_setting( 'emerge_about' )->value();
}

/**
 * Check if the about is post
 */
function emerge_if_about_post( $control ) {
	return 'post' === $control->manager->get_setting( 'emerge_about' )->value();
}

/**
 * Check if the cta is page
 */
function emerge_if_cta_page( $control ) {
	return 'page' === $control->manager->get_setting( 'emerge_cta' )->value();
}

/**
 * Check if the cta is post
 */
function emerge_if_cta_post( $control ) {
	return 'post' === $control->manager->get_setting( 'emerge_cta' )->value();
}

/**
 * Check if the portfolio is not disabled
 */
function emerge_if_portfolio_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'emerge_portfolio' )->value();
}

/**
 * Check if the portfolio is page
 */
function emerge_if_portfolio_page( $control ) {
	return 'page' === $control->manager->get_setting( 'emerge_portfolio' )->value();
}

/**
 * Check if the portfolio is post
 */
function emerge_if_portfolio_post( $control ) {
	return 'post' === $control->manager->get_setting( 'emerge_portfolio' )->value();
}

/**
 * Check if the counter is enabled.
 */
function emerge_if_counter_enable( $control ) {
	return $control->manager->get_setting( 'emerge_enable_counter' )->value();
}

/**
 * Check if the blog section is not disabled
 */
function emerge_if_blog_section_not_disabled( $control ) {
	return 'disable' != $control->manager->get_setting( 'emerge_blog_section' )->value();
}

/**
 * Check if the contact is not disabled
 */
function emerge_if_contact_not_disabled( $control ) {
	return $control->manager->get_setting( 'emerge_enable_contact' )->value();
}

/**
 * Selective refresh.
 */

/**
 * Selective refresh for portfolio title.
 */
function emerge_portfolio_partial_title() {
	return esc_html( get_theme_mod( 'emerge_portfolio_title' ) );
}

/**
 * Selective refresh for blog section title.
 */
function emerge_blog_section_partial_title() {
	return esc_html( get_theme_mod( 'emerge_blog_section_title' ) );
}

/**
 * Selective refresh for contact title.
 */
function emerge_contact_partial_title() {
	return esc_html( get_theme_mod( 'emerge_contact_title' ) );
}

/**
 * Selective refresh for your latest posts title.
 */
function emerge_your_latest_posts_partial_title() {
	return esc_html( get_theme_mod( 'emerge_your_latest_posts_title' ) );
}

