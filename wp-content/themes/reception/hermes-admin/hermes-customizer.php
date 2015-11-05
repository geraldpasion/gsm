<?php			

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */

function reception_customizer( $wp_customize ) {

	// Define array of web safe fonts
	$reception_fonts = array(
		'default' => __('Default','reception'),
		'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
		'Georgia, serif' => 'Georgia, serif',
		'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
		'"Roboto", Arial, Helvetica, sans-serif' => 'Roboto, Arial, Helvetica, sans-serif',
		'"Palatino Linotype", "Book Antiqua", Palatino, serif' => 'Palatino Linotype, Book Antique, Palatino, serif',
		'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
	);
	
	$wp_customize->add_section(
		'reception_section_general',
		array(
			'title' => __('General Settings','reception'),
			'description' => __('This controls various general theme settings.','reception'),
			'priority' => 5,
		)
	);

	$wp_customize->add_section(
		'reception_section_homepage',
		array(
			'title' => __('Homepage Settings','reception'),
			'description' => __('This controls various homepage theme settings.','reception'),
			'priority' => 25,
		)
	);

	$wp_customize->add_section(
		'reception_section_fonts',
		array(
			'title' => __('Fonts & Color Settings','reception'),
			'description' => __('Customize theme fonts and color of elements.','reception'),
			'priority' => 35,
		)
	);


	$wp_customize->add_setting( 
		'reception_logo_upload',
		array(
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'file-upload',
			array(
				'label' => __('Logo File Upload','reception'),
				'section' => 'reception_section_general',
				'settings' => 'reception_logo_upload'
			)
		)
	);

	$wp_customize->add_setting(
		'reception_display_contacts', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_html',
			'default' => '0',
	));
	
	$wp_customize->add_control(
		'reception_display_contacts', 
		array(
			'label'      => __('Display Contacts in Header', 'reception'),
			'section'    => 'reception_section_general',
			'type'    => 'checkbox',
	));

	$wp_customize->add_setting(
		'reception_header_telephone',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		'reception_header_telephone',
		array(
			'label' => __('Contact: Telephone','reception'),
			'section' => 'reception_section_general',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'reception_header_address',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		'reception_header_address',
		array(
			'label' => __('Contact: Address','reception'),
			'section' => 'reception_section_general',
			'type' => 'text',
		)
	);
	
	$wp_customize->add_setting(
		'reception_header_email',
		array(
			'default' => '',
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		'reception_header_email',
		array(
			'label' => __('Contact: Email','reception'),
			'section' => 'reception_section_general',
			'type' => 'text',
		)
	);

	$copyright_default = __('Copyright &copy; ','reception') . date("Y",time()) . ' ' . get_bloginfo('name') . '. ' . __('All Rights Reserved', 'reception');
	$wp_customize->add_setting(
		'reception_copyright_text',
		array(
			'default' => $copyright_default,
			'sanitize_callback' => 'esc_html',
		)
	);

	$wp_customize->add_control(
		'reception_copyright_text',
		array(
			'label' => __('Copyright text in Footer','reception'),
			'section' => 'reception_section_general',
			'type' => 'text',
		)
	);

	$wp_customize->add_setting(
		'reception_display_slideshow', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_html',
			'default' => '0',
	));
	
	$wp_customize->add_control(
		'reception_display_slideshow',
		array(
			'label'      => __('Display Slideshow', 'reception'),
			'section'    => 'reception_section_homepage',
			'type'    => 'checkbox',
	));

	$wp_customize->add_setting(
		'reception_slideshow_autoplay', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_html',
			'default' => '0',
	));
	
	$wp_customize->add_control(
		'reception_slideshow_autoplay', 
		array(
			'label'      => __('Autoplay Slideshow', 'reception'),
			'section'    => 'reception_section_homepage',
			'type'    => 'checkbox',
	));

	$wp_customize->add_setting(
		'reception_page_slideshow', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'reception_sanitize_integer',
	));
	
	$wp_customize->add_control(
		'reception_page_slideshow', 
		array(
			'label'      => __('Slideshow Page (with images)', 'reception'),
			'section'    => 'reception_section_homepage',
			'type'    => 'dropdown-pages',
	));

	$wp_customize->add_setting(
		'reception_slideshow_number',
		array(
			'default' => '5',
			'sanitize_callback' => 'reception_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		'reception_slideshow_number',
		array(
			'label' => __('Number of Images to Display','reception'),
			'section' => 'reception_section_homepage',
			'type' => 'text',
		)
	);	

	$wp_customize->add_setting(
		'reception_slideshow_speed',
		array(
			'default' => '5000',
			'sanitize_callback' => 'reception_sanitize_integer',
		)
	);

	$wp_customize->add_control(
		'reception_slideshow_speed',
		array(
			'label' => __('Slideshow Autoplay Speed (in milliseconds)','reception'),
			'section' => 'reception_section_homepage',
			'type' => 'text',
		)
	);	

	$wp_customize->add_setting(
		'reception_display_feat_pages', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'esc_html',
			'default' => '0',
	));
	
	$wp_customize->add_control(
		'reception_display_feat_pages', 
		array(
			'label'      => __('Display Featured Pages', 'reception'),
			'section'    => 'reception_section_homepage',
			'type'    => 'checkbox',
	));

	$wp_customize->add_setting(
		'reception_page_feat_1', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'reception_sanitize_integer',
	));
	
	$wp_customize->add_control(
		'reception_page_feat_1', 
		array(
			'label'      => __('Featured Page #1', 'reception'),
			'section'    => 'reception_section_homepage',
			'type'    => 'dropdown-pages',
	));
	
	$wp_customize->add_setting(
		'reception_page_feat_2', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'reception_sanitize_integer',
	));
	
	$wp_customize->add_control(
		'reception_page_feat_2', 
		array(
			'label'      => __('Featured Page #2', 'reception'),
			'section'    => 'reception_section_homepage',
			'type'    => 'dropdown-pages',
	));
	
	$wp_customize->add_setting(
		'reception_page_feat_3', 
		array(
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'reception_sanitize_integer',
	));
	
	$wp_customize->add_control(
		'reception_page_feat_3', 
		array(
			'label'      => __('Featured Page #3', 'reception'),
			'section'    => 'reception_section_homepage',
			'type'    => 'dropdown-pages',
	));

	$wp_customize->add_setting(
		'reception_font_main',
		array(
			'default' => 'default',
			'sanitize_callback' => 'sanitize_font',
		)
	);
	
	$wp_customize->add_control(
		'reception_font_main',
		array(
			'type' => 'select',
			'label' => __('Choose the main body font','reception'),
			'section' => 'reception_section_fonts',
			'choices' => $reception_fonts,
		)
	);

	$wp_customize->add_setting(
		'reception_color_wrapper',
		array(
			'default' => 'ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'reception_color_wrapper',
			array(
				'label' => __('Theme wrapper background color','reception'),
				'section' => 'reception_section_fonts',
				'settings' => 'reception_color_wrapper',
			)
		)
	);

	$wp_customize->add_setting(
		'reception_color_menu',
		array(
			'default' => '0068b3',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'reception_color_menu',
			array(
				'label' => __('Menu background color','reception'),
				'section' => 'reception_section_fonts',
				'settings' => 'reception_color_menu',
			)
		)
	);

	$wp_customize->add_setting(
		'reception_color_contacts',
		array(
			'default' => 'f5e4b5',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'reception_color_contacts',
			array(
				'label' => __('Header Contacts background color','reception'),
				'section' => 'reception_section_fonts',
				'settings' => 'reception_color_contacts',
			)
		)
	);

	$wp_customize->add_setting(
		'reception_color_body',
		array(
			'default' => '555555',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'reception_color_body',
			array(
				'label' => __('Main body text color','reception'),
				'section' => 'reception_section_fonts',
				'settings' => 'reception_color_body',
			)
		)
	);

	$wp_customize->add_setting(
		'reception_color_link',
		array(
			'default' => 'ce003c',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'reception_color_link',
			array(
				'label' => __('Main body anchor(link) color','reception'),
				'section' => 'reception_section_fonts',
				'settings' => 'reception_color_link',
			)
		)
	);

	$wp_customize->add_setting(
		'reception_color_link_hover',
		array(
			'default' => '0068b3',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'reception_color_link_hover',
			array(
				'label' => __('Main body anchor(link) :hover color','reception'),
				'section' => 'reception_section_fonts',
				'settings' => 'reception_color_link_hover',
			)
		)
	);

}
add_action( 'customize_register', 'reception_customizer' );

function reception_sanitize_integer( $input ) {
	if( is_numeric( $input ) ) {
		return intval( $input );
	}
}