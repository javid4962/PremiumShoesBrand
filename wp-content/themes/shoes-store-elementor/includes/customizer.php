<?php

if ( class_exists("Kirki")){

	Kirki::add_config('theme_config_id', array(
		'capability'   =>  'edit_theme_options',
		'option_type'  =>  'theme_mod',
	));

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'shoes_store_elementor_logo_resizer',
		'label'       => esc_html__( 'Adjust Logo Size', 'shoes-store-elementor' ),
		'section'     => 'title_tagline',
		'default'     => 70,
		'choices'     => [
			'min'  => 10,
			'max'  => 300,
			'step' => 10,
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_enable_logo_text',
		'section'     => 'title_tagline',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Site Title and Tagline', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

  	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'shoes_store_elementor_display_header_title',
		'label'       => esc_html__( 'Site Title Enable / Disable Button', 'shoes-store-elementor' ),
		'section'     => 'title_tagline',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'shoes_store_elementor_display_header_text',
		'label'       => esc_html__( 'Tagline Enable / Disable Button', 'shoes-store-elementor' ),
		'section'     => 'title_tagline',
		'default'     => '0',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_site_tittle_font_heading',
		'section'     => 'title_tagline',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Site Title Font Size', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_site_tittle_font_size',
		'type'        => 'number',
		'section'     => 'title_tagline',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.logo a'),
				'property' => 'font-size',
				'suffix' => 'px'
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_site_tittle_transform_heading',
		'section'     => 'title_tagline',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Site Title Text Transform', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'settings'    => 'shoes_store_elementor_site_tittle_transform',
		'section'     => 'title_tagline',
		'default'     => 'none',
		'choices'     => [
			'none' => esc_html__( 'Normal', 'shoes-store-elementor' ),
			'uppercase' => esc_html__( 'Uppercase', 'shoes-store-elementor' ),
			'lowercase' => esc_html__( 'Lowercase', 'shoes-store-elementor' ),
			'capitalize' => esc_html__( 'Capitalize', 'shoes-store-elementor' ),
		],
		'output' => array(
			array(
				'element'  => array( '.logo a'),
				'property' => ' text-transform',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_site_tagline_font_heading',
		'section'     => 'title_tagline',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Site Tagline Font Size', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_site_tagline_font_size',
		'type'        => 'number',
		'section'     => 'title_tagline',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.logo span'),
				'property' => 'font-size',
				'suffix' => 'px'
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_logo_settings_premium_features',
		'section'     => 'title_tagline',
		'priority'    => 50,
		'default'     => '<h3 style="color: #2271b1; padding:5px 20px 5px 20px; background:#fff; margin:0;  box-shadow: 0 2px 4px rgba(0,0,0, .2); ">' . esc_html__( 'Unlock More Features in the Premium Version!', 'shoes-store-elementor' ) . '</h3><ul style="color: #121212; padding: 5px 20px 20px 30px; background:#fff; margin:0;" ><li style="list-style-type: square;" >' . esc_html__( 'Customizable Text Logo', 'shoes-store-elementor' ) . '</li><li style="list-style-type: square;" >'.esc_html__( 'Enhanced Typography Options', 'shoes-store-elementor' ) .'</li><li style="list-style-type: square;" >'.esc_html__( 'Priority Support', 'shoes-store-elementor' ) .'</li><li style="list-style-type: square;" >'.esc_html__( '....and Much More', 'shoes-store-elementor' ) . '</li></ul><div style="background: #fff; padding: 0px 10px 10px 20px;"><a href="' . esc_url( __( 'https://www.wpelemento.com/elementor/shoes-store-wordpress-theme', 'shoes-store-elementor' ) ) . '" class="button button-primary" target="_blank">'. esc_html__( 'Upgrade for more', 'shoes-store-elementor' ) .'</a></div>',
	) );
	
	// TYPOGRAPHY SETTINGS
	Kirki::add_panel( 'shoes_store_elementor_typography_panel', array(
		'priority' => 10,
		'title'    => __( 'Typography', 'shoes-store-elementor' ),
	) );

	//Heading 1 Section

	Kirki::add_section( 'shoes_store_elementor_h1_typography_setting', array(
		'title'    => __( 'Heading 1', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_h1_typography_heading',
		'section'     => 'shoes_store_elementor_h1_typography_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading 1 Typography', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'shoes_store_elementor_h1_typography_font',
		'section'   =>  'shoes_store_elementor_h1_typography_setting',
		'default'   =>  [
			'font-family'   =>  'Mulish',
			'variant'       =>  '700',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h1',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 2 Section

	Kirki::add_section( 'shoes_store_elementor_h2_typography_setting', array(
		'title'    => __( 'Heading 2', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_h2_typography_heading',
		'section'     => 'shoes_store_elementor_h2_typography_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading 2 Typography', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'shoes_store_elementor_h2_typography_font',
		'section'   =>  'shoes_store_elementor_h2_typography_setting',
		'default'   =>  [
			'font-family'   =>  'Mulish',
			'font-size'       => '',
			'variant'       =>  '700',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h2',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 3 Section

	Kirki::add_section( 'shoes_store_elementor_h3_typography_setting', array(
		'title'    => __( 'Heading 3', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_h3_typography_heading',
		'section'     => 'shoes_store_elementor_h3_typography_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading 3 Typography', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'shoes_store_elementor_h3_typography_font',
		'section'   =>  'shoes_store_elementor_h3_typography_setting',
		'default'   =>  [
			'font-family'   =>  'Mulish',
			'variant'       =>  '700',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h3',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 4 Section

	Kirki::add_section( 'shoes_store_elementor_h4_typography_setting', array(
		'title'    => __( 'Heading 4', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_h4_typography_heading',
		'section'     => 'shoes_store_elementor_h4_typography_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading 4 Typography', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'shoes_store_elementor_h4_typography_font',
		'section'   =>  'shoes_store_elementor_h4_typography_setting',
		'default'   =>  [
			'font-family'   =>  'Mulish',
			'variant'       =>  '700',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h4',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 5 Section

	Kirki::add_section( 'shoes_store_elementor_h5_typography_setting', array(
		'title'    => __( 'Heading 5', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_h5_typography_heading',
		'section'     => 'shoes_store_elementor_h5_typography_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading 5 Typography', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'shoes_store_elementor_h5_typography_font',
		'section'   =>  'shoes_store_elementor_h5_typography_setting',
		'default'   =>  [
			'font-family'   =>  'Mulish',
			'variant'       =>  '700',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h5',
				'suffix' => '!important'
			],
		],
	) );

	//Heading 6 Section

	Kirki::add_section( 'shoes_store_elementor_h6_typography_setting', array(
		'title'    => __( 'Heading 6', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_h6_typography_heading',
		'section'     => 'shoes_store_elementor_h6_typography_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Heading 6 Typography', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'shoes_store_elementor_h6_typography_font',
		'section'   =>  'shoes_store_elementor_h6_typography_setting',
		'default'   =>  [
			'font-family'   =>  'Mulish',
			'variant'       =>  '700',
			'font-size'       => '',
			'line-height'   =>  '',
			'letter-spacing'    =>  '',
			'text-transform'    =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   =>  'h6',
				'suffix' => '!important'
			],
		],
	) );

	//body Typography

	Kirki::add_section( 'shoes_store_elementor_body_typography_setting', array(
		'title'    => __( 'Content Typography', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_typography_panel',
		'priority' => 0,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_body_typography_heading',
		'section'     => 'shoes_store_elementor_body_typography_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Content  Typography', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'  =>  'typography',
		'settings'  => 'shoes_store_elementor_body_typography_font',
		'section'   =>  'shoes_store_elementor_body_typography_setting',
		'default'   =>  [
			'font-family'   =>  'Padauk',
			'variant'       =>  '',
		],
		'transport'     =>  'auto',
		'output'        =>  [
			[
				'element'   => 'body',
				'suffix' => '!important'
			],
		],
	) );

	// Theme Options Panel
	Kirki::add_panel( 'shoes_store_elementor_theme_options_panel', array(
		'priority' => 10,
		'title'    => __( 'Theme Options', 'shoes-store-elementor' ),
	) );
	
	// HEADER SECTION

	Kirki::add_section( 'shoes_store_elementor_section_header',array(
		'title' => esc_html__( 'Header Settings', 'shoes-store-elementor' ),
		'description'    => esc_html__( 'Here you can add header information.', 'shoes-store-elementor' ),
		'panel' => 'shoes_store_elementor_theme_options_panel',
		'tabs'  => [
			'header' => [
				'label' => esc_html__( 'Header', 'shoes-store-elementor' ),
			],
			'menu'  => [
				'label' => esc_html__( 'Menu', 'shoes-store-elementor' ),
			],
		],
		'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'tab'      => 'header',
		'settings'    => 'shoes_store_elementor_sticky_header',
		'label'       => esc_html__( 'Enable/Disable Sticky Header', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => 'on',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'menu',
		'settings'    => 'shoes_store_elementor_menu_size_heading',
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Menu Font Size(px)', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_menu_size',
		'label'       => __( 'Enter a value in pixels. Example:20px', 'shoes-store-elementor' ),
		'type'        => 'text',
		'tab'      => 'menu',
		'section'     => 'shoes_store_elementor_section_header',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array( '#main-menu a', '#main-menu ul li a', '#main-menu li a'),
				'property' => 'font-size',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'menu',
		'settings'    => 'shoes_store_elementor_menu_text_transform_heading',
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Menu Text Transform', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'menu',
		'settings'    => 'shoes_store_elementor_menu_text_transform',
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => 'uppercase',
		'choices'     => [
			'none' => esc_html__( 'Normal', 'shoes-store-elementor' ),
			'uppercase' => esc_html__( 'Uppercase', 'shoes-store-elementor' ),
			'lowercase' => esc_html__( 'Lowercase', 'shoes-store-elementor' ),
			'capitalize' => esc_html__( 'Capitalize', 'shoes-store-elementor' ),
		],
		'output' => array(
			array(
				'element'  => array( '#main-menu a', '#main-menu ul li a', '#main-menu li a'),
				'property' => ' text-transform',
			),
		),
	 ) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'tab'      => 'header',
		'settings'    => 'shoes_store_elementor_google_translator',
		'label'       => esc_html__( 'Language Translator', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => 0,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'tab'      => 'header',
		'settings'    => 'shoes_store_elementor_currency_switcher',
		'label'       => esc_html__( 'Currency Switcher', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => 0,
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'tab'      => 'header',
		'label'    => esc_html__( 'Contact Button', 'shoes-store-elementor' ),
		'settings' => 'shoes_store_elementor_header_button_text',
		'section'  => 'shoes_store_elementor_section_header',
		'default'  => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'url',
		'tab'      => 'header',
		'label'    =>  esc_html__( 'Button Link', 'shoes-store-elementor' ),
		'settings' => 'shoes_store_elementor_header_button_url',
		'section'  => 'shoes_store_elementor_section_header',
		'default'  => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'tab'      => 'header',
		'label'    => esc_html__( 'Advertisement Text', 'shoes-store-elementor' ),
		'settings' => 'shoes_store_elementor_header_advertisement_text',
		'section'  => 'shoes_store_elementor_section_header',
		'default'  => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'url',
		'tab'      => 'header',
		'label'    =>  esc_html__( 'Wishlist Link', 'shoes-store-elementor' ),
		'settings' => 'shoes_store_elementor_header_wishlist_url',
		'section'  => 'shoes_store_elementor_section_header',
		'default'  => '',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'tab'      => 'header',
		'settings'    => 'shoes_store_elementor_cart_box_enable',
		'label'       => esc_html__( 'Enable/Disable Shopping Cart', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => 'on',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'tab'      => 'header',
		'settings'    => 'shoes_store_elementor_disable_search_icon',
		'label'       => esc_html__( 'Enable/Disable Search', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_section_header',
		'default'     => 'on',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_menu_color',
		'label'       => __( 'Menu Color', 'shoes-store-elementor' ),
		'type'        => 'color',
		'tab'      => 'menu',
		'section'     => 'shoes_store_elementor_section_header',
		'transport' => 'auto',
		'default'     => '#000000',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => array( '#main-menu a', '#main-menu ul li a', '#main-menu li a'),
				'property' => 'color',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_menu_hover_color',
		'label'       => __( 'Menu Hover Color', 'shoes-store-elementor' ),
		'type'        => 'color',
		'tab'      => 'menu',
		'default'     => '#fc1313',
		'section'     => 'shoes_store_elementor_section_header',
		'transport' => 'auto',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => array( '#main-menu a:hover', '#main-menu ul li a:hover', '#main-menu li:hover > a','#main-menu a:focus','#main-menu li.focus > a','#main-menu ul li.current-menu-item > a','#main-menu ul li.current_page_item > a','#main-menu ul li.current-menu-parent > a','#main-menu ul li.current_page_ancestor > a','#main-menu ul li.current-menu-ancestor > a'),
				'property' => 'color',
			),

		),
	) );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_submenu_color',
		'label'       => __( 'Submenu Color', 'shoes-store-elementor' ),
		'type'        => 'color',
		'tab'      => 'menu',
		'section'     => 'shoes_store_elementor_section_header',
		'transport' => 'auto',
		'default'     => '#000000',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => array( '#main-menu ul.children li a', '#main-menu ul.sub-menu li a'),
				'property' => 'color',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_submenu_hover_color',
		'label'       => __( 'Submenu Hover Color', 'shoes-store-elementor' ),
		'type'        => 'color',
		'tab'      => 'menu',
		'section'     => 'shoes_store_elementor_section_header',
		'transport' => 'auto',
		'default'     => '#fff',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => array( '#main-menu ul.children li a:hover', '#main-menu ul.sub-menu li a:hover'),
				'property' => 'color',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_submenu_hover_background_color',
		'label'       => __( 'Submenu Hover Background Color', 'shoes-store-elementor' ),
		'type'        => 'color',
		'tab'      => 'menu',
		'section'     => 'shoes_store_elementor_section_header',
		'transport' => 'auto',
		'default'     => '#fc1313',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => array( '#main-menu ul.children li a:hover', '#main-menu ul.sub-menu li a:hover'),
				'property' => 'background',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'custom',
		'tab'      => 'header',
		'settings'    => 'shoes_store_elementor_logo_settings_premium_features_header',
		'section'     => 'shoes_store_elementor_section_header',
		'priority'    => 50,
		'default'     => '<h3 style="color: #2271b1; padding:5px 20px 5px 20px; background:#fff; margin:0;  box-shadow: 0 2px 4px rgba(0,0,0, .2); ">' . esc_html__( 'Enhance your header design now!', 'shoes-store-elementor' ) . '</h3><ul style="color: #121212; padding: 5px 20px 20px 30px; background:#fff; margin:0;" ><li style="list-style-type: square;" >' . esc_html__( 'Customize your header background color', 'shoes-store-elementor' ) . '</li><li style="list-style-type: square;" >'.esc_html__( 'Adjust icon and text font sizes', 'shoes-store-elementor' ) .'</li><li style="list-style-type: square;" >'.esc_html__( 'Explore enhanced typography options', 'shoes-store-elementor' ) .'</li><li style="list-style-type: square;" >'.esc_html__( '....and Much More', 'shoes-store-elementor' ) . '</li></ul><div style="background: #fff; padding: 0px 10px 10px 20px;"><a href="' . esc_url( __( 'https://www.wpelemento.com/elementor/shoes-store-wordpress-theme', 'shoes-store-elementor' ) ) . '" class="button button-primary" target="_blank">'. esc_html__( 'Upgrade for more', 'shoes-store-elementor' ) .'</a></div>',
	) );

	//ADDITIONAL SETTINGS

	Kirki::add_section( 'shoes_store_elementor_additional_setting',array(
		'title' => esc_html__( 'Additional Settings', 'shoes-store-elementor' ),
		'panel' => 'shoes_store_elementor_theme_options_panel',
		'tabs'  => [
			'general' => [
				'label' => esc_html__( 'General', 'shoes-store-elementor' ),
			],
			'header-image'  => [
				'label' => esc_html__( 'Header Image', 'shoes-store-elementor' ),
			],
		],
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'general',
		'settings'    => 'shoes_store_elementor_preloader_hide',
		'label'       => esc_html__( 'Here you can enable or disable your preloader.', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '0',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'general',
		'settings'    => 'shoes_store_elementor_scroll_enable_setting',
		'label'       => esc_html__( 'Here you can enable or disable your scroller.', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '0',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'general',
		'settings'    => 'shoes_store_elementor_single_page_layout_heading',
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Single Page Layout', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'general',
		'settings'    => 'shoes_store_elementor_single_page_layout',
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => 'One Column',
		'choices'     => [
			'Left Sidebar' => esc_html__( 'Left Sidebar', 'shoes-store-elementor' ),
			'Right Sidebar' => esc_html__( 'Right Sidebar', 'shoes-store-elementor' ),
			'One Column' => esc_html__( 'One Column', 'shoes-store-elementor' ),
		],
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'header-image',
		'settings'    => 'shoes_store_elementor_header_background_attachment_heading',
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Header Image Attachment', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'header-image',
		'settings'    => 'shoes_store_elementor_header_background_attachment',
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => 'scroll',
		'choices'     => [
			'scroll' => esc_html__( 'Scroll', 'shoes-store-elementor' ),
			'fixed' => esc_html__( 'Fixed', 'shoes-store-elementor' ),
		],
		'output' => array(
			array(
				'element'  => '.header-image-box',
				'property' => 'background-attachment',
			),
		),
	 ) );
	 
	 Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'header-image',
		'settings'    => 'shoes_store_elementor_header_image_height_heading',
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Header Image height', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_header_image_height',
		'label'       => __( 'Image Height', 'shoes-store-elementor' ),
		'description'    => esc_html__( 'Enter a value in pixels. Example:500px', 'shoes-store-elementor' ),
		'type'        => 'text',
		'tab'      => 'header-image',
		'default'    => [
			'desktop' => '550px',
			'tablet'  => '350px',
			'mobile'  => '200px',
		],
		'responsive' => true,
		'section'     => 'shoes_store_elementor_additional_setting',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.header-image-box'),
				'property' => 'height',
				'media_query' => [
					'desktop' => '@media (min-width: 1024px)',
					'tablet'  => '@media (min-width: 768px) and (max-width: 1023px)',
					'mobile'  => '@media (max-width: 767px)',
				],
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'header-image',
		'settings'    => 'shoes_store_elementor_header_overlay_heading',
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Header Image Overlay', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_header_overlay_setting',
		'label'       => __( 'Overlay Color', 'shoes-store-elementor' ),
		'type'        => 'color',
		'tab'      => 'header-image',
		'section'     => 'shoes_store_elementor_additional_setting',
		'transport' => 'auto',
		'default'     => '#000000b3',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => '.header-image-box:before',
				'property' => 'background',
			),
		),
	) );

	 Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'header-image',
		'settings'    => 'shoes_store_elementor_header_page_title',
		'label'       => esc_html__( 'Enable / Disable Header Image Page Title.', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'header-image',
		'settings'    => 'shoes_store_elementor_header_breadcrumb',
		'label'       => esc_html__( 'Enable / Disable Header Image Breadcrumb.', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_additional_setting',
		'default'     => '1',
		'priority'    => 10,
	] );

	// WOOCOMMERCE SETTINGS

	Kirki::add_section( 'shoes_store_elementor_woocommerce_settings', array(
		'title'          => esc_html__( 'Woocommerce Settings', 'shoes-store-elementor' ),
		'panel'    => 'woocommerce',
		'description'    => esc_html__( 'Woocommerce Settings of themes', 'shoes-store-elementor' ),
		'priority'       => 160,
	) );
 
	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'shoes_store_elementor_shop_page_sidebar',
		'label'       => esc_html__( 'Enable/Disable Shop Page Sidebar', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => 'true',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'label'       => esc_html__( 'Shop Page Layouts', 'shoes-store-elementor' ),
		'settings'    => 'shoes_store_elementor_shop_page_layout',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => 'Right Sidebar',
		'choices'     => [
			'Right Sidebar' => esc_html__( 'Right Sidebar', 'shoes-store-elementor' ),
			'Left Sidebar' => esc_html__( 'Left Sidebar', 'shoes-store-elementor' ),
		],
		'active_callback'  => [
			[
				'setting'  => 'shoes_store_elementor_shop_page_sidebar',
				'operator' => '===',
				'value'    => true,
			],
		]

	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'select',
		'label'       => esc_html__( 'Products Per Row', 'shoes-store-elementor' ),
		'settings'    => 'shoes_store_elementor_products_per_row',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => '3',
		'priority'    => 10,
		'choices'     => [
			'2' => '2',
			'3' => '3',
			'4' => '4',
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'label'       => esc_html__( 'Products Per Page', 'shoes-store-elementor' ),
		'settings'    => 'shoes_store_elementor_products_per_page',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => '9',
		'priority'    => 10,
		'choices'  => [
					'min'  => 0,
					'max'  => 50,
					'step' => 1,
				],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'settings'    => 'shoes_store_elementor_single_product_sidebar',
		'label'       => esc_html__( 'Enable / Disable Single Product Sidebar', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => 'true',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'label'       => esc_html__( 'Single Product Layout', 'shoes-store-elementor' ),
		'settings'    => 'shoes_store_elementor_single_product_sidebar_layout',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => 'Right Sidebar',
		'choices'     => [
			'Right Sidebar' => esc_html__( 'Right Sidebar', 'shoes-store-elementor' ),
			'Left Sidebar' => esc_html__( 'Left Sidebar', 'shoes-store-elementor' ),
		],
		'active_callback'  => [
			[
				'setting'  => 'shoes_store_elementor_single_product_sidebar',
				'operator' => '===',
				'value'    => true,
			],
		]
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_products_button_border_radius_heading',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Products Button Border Radius', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'slider',
		'settings'    => 'shoes_store_elementor_products_button_border_radius',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => '1',
		'priority'    => 10,
		'choices'  => [
					'min'  => 1,
					'max'  => 50,
					'step' => 1,
				],
		'output' => array(
			array(
				'element'  => array('.woocommerce ul.products li.product .button',' a.checkout-button.button.alt.wc-forward','.woocommerce #respond input#submit', '.woocommerce a.button', '.woocommerce button.button','.woocommerce input.button','.woocommerce #respond input#submit.alt','.woocommerce button.button.alt','.woocommerce input.button.alt'),
				'property' => 'border-radius',
				'units' => 'px',
			),
		),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_sale_badge_position_heading',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Sale Badge Position', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'settings'    => 'shoes_store_elementor_sale_badge_position',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'     => 'right',
		'choices'     => [
			'right' => esc_html__( 'Right', 'shoes-store-elementor' ),
			'left' => esc_html__( 'Left', 'shoes-store-elementor' ),
		],
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_products_sale_font_size_heading',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Sale Font Size', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'text',
		'settings'    => 'shoes_store_elementor_products_sale_font_size',
		'section'     => 'shoes_store_elementor_woocommerce_settings',
		'priority'    => 10,
		'output' => array(
			array(
				'element'  => array('.woocommerce span.onsale','.woocommerce ul.products li.product .onsale'),
				'property' => 'font-size',
				'units' => 'px',
			),
		),
	] );
	
	// POST SECTION

	Kirki::add_section( 'shoes_store_elementor_blog_post',array(
		'title' => esc_html__( 'Post Settings', 'shoes-store-elementor' ),
		'description'    => esc_html__( 'Here you can add post information.', 'shoes-store-elementor' ),
		'panel' => 'shoes_store_elementor_theme_options_panel',
		'tabs'  => [
			'blog-post' => [
				'label' => esc_html__( 'Blog Post', 'shoes-store-elementor' ),
			],
			'single-post'  => [
				'label' => esc_html__( 'Single Post', 'shoes-store-elementor' ),
			],
		],
		'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_post_layout_heading',
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Blog Layout', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_post_layout',
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => 'Right Sidebar',
		'choices'     => [
			'Left Sidebar' => esc_html__( 'Left Sidebar', 'shoes-store-elementor' ),
			'Right Sidebar' => esc_html__( 'Right Sidebar', 'shoes-store-elementor' ),
			'One Column' => esc_html__( 'One Column', 'shoes-store-elementor' ),
			'Three Columns' => esc_html__( 'Three Columns', 'shoes-store-elementor' ),
			'Four Columns' => esc_html__( 'Four Columns', 'shoes-store-elementor' ),
		],
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_date_hide',
		'label'       => esc_html__( 'Enable / Disable Post Date', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_author_hide',
		'label'       => esc_html__( 'Enable / Disable Post Author', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_comment_hide',
		'label'       => esc_html__( 'Enable / Disable Post Comment', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_blog_post_featured_image',
		'label'       => esc_html__( 'Enable / Disable Post Image', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_length_setting_heading',
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Blog Post Content Limit', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'number',
		'tab'      => 'blog-post',
		'settings'    => 'shoes_store_elementor_length_setting',
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '15',
		'priority'    => 10,
		'choices'  => [
					'min'  => -10,
					'max'  => 40,
						'step' => 1,
				],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'label'       => esc_html__( 'Enable / Disable Single Post Tag', 'shoes-store-elementor' ),
		'settings'    => 'shoes_store_elementor_single_post_tag',
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'label'       => esc_html__( 'Enable / Disable Single Post Category', 'shoes-store-elementor' ),
		'settings'    => 'shoes_store_elementor_single_post_category',
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'settings'    => 'shoes_store_elementor_post_comment_show_hide',
		'label'       => esc_html__( 'Show / Hide Comment Box', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'toggle',
		'tab'      => 'single-post',
		'settings'    => 'shoes_store_elementor_single_post_featured_image',
		'label'       => esc_html__( 'Enable / Disable Single Post Image', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '1',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'tab'      => 'single-post',
		'settings'    => 'shoes_store_elementor_single_post_radius',
		'section'     => 'shoes_store_elementor_blog_post',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Single Post Image Border Radius(px)', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_single_post_border_radius',
		'label'       => __( 'Enter a value in pixels. Example:15px', 'shoes-store-elementor' ),
		'type'        => 'text',
		'tab'      => 'single-post',
		'section'     => 'shoes_store_elementor_blog_post',
		'transport' => 'auto',
		'output' => array(
			array(
				'element'  => array('.post-img img'),
				'property' => 'border-radius',
			),
		),
	) );

	// No Results Page Settings

	Kirki::add_section( 'shoes_store_elementor_no_result_section', array(
		'title'          => esc_html__( '404 &No Results Page Settings', 'shoes-store-elementor' ),
		'panel'    => 'shoes_store_elementor_theme_options_panel',
		'priority'       => 160,
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_page_not_found_title_heading',
		'section'     => 'shoes_store_elementor_no_result_section',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( '404 Page Title', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'shoes_store_elementor_page_not_found_title',
		'section'  => 'shoes_store_elementor_no_result_section',
		'default'  => esc_html__('404 Error!', 'shoes-store-elementor'),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_page_not_found_text_heading',
		'section'     => 'shoes_store_elementor_no_result_section',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( '404 Page Text', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'shoes_store_elementor_page_not_found_text',
		'section'  => 'shoes_store_elementor_no_result_section',
		'default'  => esc_html__('The page you are looking for may have been moved, deleted, or possibly never existed.', 'shoes-store-elementor'),
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'     => 'custom',
		'settings' => 'shoes_store_elementor_page_not_found_line_break',
		'section'  => 'shoes_store_elementor_no_result_section',
		'default'  => '<hr>',
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_no_results_title_heading',
		'section'     => 'shoes_store_elementor_no_result_section',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'No Results Title', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'shoes_store_elementor_no_results_title',
		'section'  => 'shoes_store_elementor_no_result_section',
		'default'  => esc_html__('Nothing Found', 'shoes-store-elementor'),
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_no_results_content_heading',
		'section'     => 'shoes_store_elementor_no_result_section',
		'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'No Results Content', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'shoes_store_elementor_no_results_content',
		'section'  => 'shoes_store_elementor_no_result_section',
		'default'  => esc_html__('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'shoes-store-elementor'),
	] );

	// FOOTER SECTION

	Kirki::add_section( 'shoes_store_elementor_footer_section', array(
        'title'          => esc_html__( 'Footer Settings', 'shoes-store-elementor' ),
        'description'    => esc_html__( 'Here you can change copyright text', 'shoes-store-elementor' ),
        'panel'    => 'shoes_store_elementor_theme_options_panel',
		'priority'       => 160,
    ) );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_footer_text_heading',
		'section'     => 'shoes_store_elementor_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Copyright Text', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'     => 'text',
		'settings' => 'shoes_store_elementor_footer_text',
		'section'  => 'shoes_store_elementor_footer_section',
		'default'  => '',
		'priority' => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_footer_enable_heading',
		'section'     => 'shoes_store_elementor_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Enable / Disable Footer Link', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

    Kirki::add_field( 'theme_config_id', [
		'type'        => 'switch',
		'settings'    => 'shoes_store_elementor_copyright_enable',
		'label'       => esc_html__( 'Section Enable / Disable', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_footer_section',
		'default'     => '1',
		'priority'    => 10,
		'choices'     => [
			'on'  => esc_html__( 'Enable', 'shoes-store-elementor' ),
			'off' => esc_html__( 'Disable', 'shoes-store-elementor' ),
		],
	] );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_footer_background_widget_heading',
		'section'     => 'shoes_store_elementor_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Widget Background', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id',
	[
		'settings'    => 'shoes_store_elementor_footer_background_widget',
		'type'        => 'background',
		'section'     => 'shoes_store_elementor_footer_section',
		'default'     => [
			'background-color'      => 'rgba(0,0,0,1)',
			'background-image'      => '',
			'background-repeat'     => 'no-repeat',
			'background-position'   => 'center center',
			'background-size'       => 'cover',
			'background-attachment' => 'scroll',
		],
		'transport'   => 'auto',
		'output'      => [
			[
				'element' => '.footer-widget',
			],
		],
	]);

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_footer__widget_alignment_heading',
		'section'     => 'shoes_store_elementor_footer_section',
		'default'     => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Footer Widget Alignment', 'shoes-store-elementor' ) . '</h3>',
	] );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'select',
		'settings'    => 'shoes_store_elementor_footer__widget_alignment',
		'section'     => 'shoes_store_elementor_footer_section',
		'default'     => 'left',
		'choices'     => [
			'center' => esc_html__( 'center', 'shoes-store-elementor' ),
			'right' => esc_html__( 'right', 'shoes-store-elementor' ),
			'left' => esc_html__( 'left', 'shoes-store-elementor' ),
		],
		'output' => array(
			array(
				'element'  => '.footer-area',
				'property' => 'text-align',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_footer_copright_color_heading',
		'section'     => 'shoes_store_elementor_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Copyright Background Color', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_footer_copright_color',
		'type'        => 'color',
		'label'       => __( 'Background Color', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_footer_section',
		'transport' => 'auto',
		'default'     => '#000000',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => '.footer-copyright',
				'property' => 'background',
			),
		),
	) );
	Kirki::add_field( 'theme_config_id', [
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_footer_copright_text_color_heading',
		'section'     => 'shoes_store_elementor_footer_section',
			'default'         => '<h3 style="color: #2271b1; padding:10px; background:#fff; margin:0; border-left: solid 5px #2271b1; ">' . __( 'Copyright Text Color', 'shoes-store-elementor' ) . '</h3>',
		'priority'    => 10,
	] );

	Kirki::add_field( 'theme_config_id', array(
		'settings'    => 'shoes_store_elementor_footer_copright_text_color',
		'type'        => 'color',
		'label'       => __( 'Text Color', 'shoes-store-elementor' ),
		'section'     => 'shoes_store_elementor_footer_section',
		'transport' => 'auto',
		'default'     => '#ffffff',
		'choices'     => [
			'alpha' => true,
		],
		'output' => array(
			array(
				'element'  => array( '.footer-copyright a', '.footer-copyright p'),
				'property' => 'color',
			),
		),
	) );

	Kirki::add_field( 'theme_config_id', array(
		'type'        => 'custom',
		'settings'    => 'shoes_store_elementor_logo_settings_premium_features_footer',
		'section'     => 'shoes_store_elementor_footer_section',
		'priority'    => 50,
		'default'     => '<h3 style="color: #2271b1; padding:5px 20px 5px 20px; background:#fff; margin:0;  box-shadow: 0 2px 4px rgba(0,0,0, .2); ">' . esc_html__( 'Elevate your footer with premium features:', 'shoes-store-elementor' ) . '</h3><ul style="color: #121212; padding: 5px 20px 20px 30px; background:#fff; margin:0;" ><li style="list-style-type: square;" >' . esc_html__( 'Tailor your footer layout', 'shoes-store-elementor' ) . '</li><li style="list-style-type: square;" >'.esc_html__( 'Integrate an email subscription form', 'shoes-store-elementor' ) .'</li><li style="list-style-type: square;" >'.esc_html__( 'Personalize social media icons', 'shoes-store-elementor' ) .'</li><li style="list-style-type: square;" >'.esc_html__( '....and Much More', 'shoes-store-elementor' ) . '</li></ul><div style="background: #fff; padding: 0px 10px 10px 20px;"><a href="' . esc_url( __( 'https://www.wpelemento.com/elementor/shoes-store-wordpress-theme', 'shoes-store-elementor' ) ) . '" class="button button-primary" target="_blank">'. esc_html__( 'Upgrade for more', 'shoes-store-elementor' ) .'</a></div>',
	) );
}
