<?php

add_action( 'init', 'grandium_custom_theme_options' );
function grandium_custom_theme_options() {
/* optiontree is not loaded yet, or this is not an admin request */
	if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
	return false;

	$grandium_saved_settings = get_option( ot_settings_id(), array() );
	$grandium_custom_settings = array(
		'contextual_help' => array(
			'sidebar'       => ''
		),
		'sections'        => array(
			array(
				'id'          => 'generalcolor',
				'title'       => 'General Color'
			),
			array(
				'id'          => 'general',
				'title'       => 'Logo Options'
			),
			array(
				'id'          => 'customstyle',
				'title'       => 'Custom CSS & JS'
			),
			array(
				'id'          => 'pre',
				'title'       => 'Preloader'
			),
			array(
				'id'          => 'google_fonts',
				'title'       => 'Google Fonts'
			),
			array(
				'id'          => 'typography',
				'title'       => 'Typography'
			),
			array(
				'id'          => 'header_top',
				'title'       => 'Header Topbar'
			),
			array(
				'id'          => 'header_colors',
				'title'       => 'Header Menu'
			),
			array(
				'id'          => 'sidebars',
				'title'       => 'Sidebars'
			),
			array(
				'id'          => 'header',
				'title'       => 'Blog Page'
			),
			array(
				'id'          => 'header_color',
				'title'       => 'Blog Page Colors'
			),
			array(
				'id'          => 'post_color',
				'title'       => 'Blog Post Colors'
			),

			array(
				'id'          => 'single_header',
				'title'       => 'Single Page'
			),
			array(
				'id'          => 'archive_page',
				'title'       => 'Archive Page'
			),
			array(
				'id'          => 'error_page',
				'title'       => '404 Page'
			),
			array(
				'id'          => 'search_page',
				'title'       => 'Search Page'
			),
			array(
				'id'          => 'breadcrubms',
				'title'       => 'Breadcrubms'
			),
			array(
				'id'          => 'copyright',
				'title'       => 'Footer'
			),
			array(
				'id'          => 'footer_contact',
				'title'       => 'Footer Contact'
			),
			array(
				'id'          => 'copyright_color',
				'title'       => 'Footer Color'
			),
			array(
				'id'          => 'woo',
				'title'       => 'Woocommerce Settings'
			),
			array(
				'id'          => 'maps',
				'title'       => 'Google Maps'
			),
			array(
				'id'          => 'rooms',
				'title'       => 'Rooms Settings'
			)
		), // sidebar end

			// options start
		'settings'        => array(

			array(
				'id'          => 'grandium_theme_color_one',
				'label'       => esc_html__( 'Theme general color', 'grandium' ),
				'desc'        => esc_html__( 'Please select color', 'grandium' ),
				'type'        => 'colorpicker',
				'section'     => 'generalcolor'
			),

			/*** GENERAL SETTINGS. **/
			array(
				'id'          => 'grandium_logo_type',
				'label'       => esc_html__( 'Logo type', 'grandium' ),
				'desc'        => esc_html__( 'Please choose logo type', 'grandium' ),
				'std'         => 'img',
				'type'        => 'select',
				'section'     => 'general',
				'operator'    => 'and',
				'choices'     => array(
					array(
						'value'       => 'img',
						'label'       => esc_html__('image logo', 'grandium' ),
						'src'         => ''
					),
					array(
						'value'       => 'text',
						'label'       => esc_html__( 'Text logo', 'grandium' ),
						'src'         => ''
					)
				)
			),
			array(
				'id'          => 'grandium_logoimg',
				'label'       => 'upload logo image',
				'desc'        => 'upload logo image',
				'type'        => 'upload',
				'section'     => 'general'
			),
			array(
				'id'          => 'grandium_logowidth',
				'label'       => esc_html__( 'Logo image width', 'grandium' ),
				'desc'        => esc_html__( 'Blog pages width', 'grandium' ),
				'std'         => '227',
				'type'        => 'numeric-slider',
				'min_max_step'=> '0,1000',
				'section'     => 'general',
				'operator'    => 'and'
			),
			array(
				'id'          => 'grandium_logoheight',
				'label'       => esc_html__( 'Logo image height', 'grandium' ),
				'desc'        => esc_html__( 'Blog pages height', 'grandium' ),
				'std'         => '70',
				'type'        => 'numeric-slider',
				'min_max_step'=> '0,1000',
				'section'     => 'general',
				'operator'    => 'and'
			),
			array(
				'id'          => 'grandium_textlogo',
				'label'       => 'text logo',
				'desc'        => 'text logo',
				'std'         => 'grandium',
				'type'        => 'text',
				'section'     => 'general'
			),


			// PRELOADER
			array(
				'id'          => 'grandium_pre',
				'label'       => esc_html__( 'Preloader', 'grandium' ),
				'desc'        => sprintf( esc_html__( 'Preloader visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
				'std'         => 'on',
				'type'        => 'on-off',
				'section'     => 'pre'
			),
			array(
				'id'          => 'grandium_custom_preloader',
				'label'       =>  esc_html__( 'Custom preloader background image', 'grandium' ),
				'desc'        =>  esc_html__( 'You can upload your  image', 'grandium' ),
				'type'        => 'upload',
				'section'     => 'pre',
				'operator'    => 'and'
			),


			/**   GOOGLE FONTS SETTINGS.   */
			array(
				'id'          => 'body_google_fonts',
				'label'       => esc_html__( 'google fonts', 'grandium'  ),
				'desc'        => 'add google font and after the save settings follow these steps dashbograndium > appearance > theme options > typography',
				'std'         => '',
				'type'        => 'google-fonts',
				'section'     => 'google_fonts',
				'operator'    => 'and'
			),


			/**  TYPOGRAPHY SETTINGS.  */
			array(
				'id'          => 'grandium_tipigrof',
				'label'       => esc_html__( 'Typography', 'grandium' ),
				'desc'        => 'the typography option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),
			array(
				'id'          => 'grandium_tipigrofa',
				'label'       => esc_html__( 'Typography a', 'grandium' ),
				'desc'        => 'the typography a option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),
			array(
				'id'          => 'grandium_tipigrof1',
				'label'       => esc_html__( 'Typography h1', 'grandium' ),
				'desc'        => 'the typography option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),
			array(
				'id'          => 'grandium_tipigrof2',
				'label'       => esc_html__( 'Typography h2', 'grandium' ),
				'desc'        => 'the typography option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),
			array(
				'id'          => 'grandium_tipigrof3',
				'label'       => esc_html__( 'Typography h3', 'grandium' ),
				'desc'        => 'the typography option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),
			array(
				'id'          => 'grandium_tipigrof4',
				'label'       => esc_html__( 'Typography h4', 'grandium' ),
				'desc'        => 'the typography option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),
			array(
				'id'          => 'grandium_tipigrof5',
				'label'       => esc_html__( 'Typography h5', 'grandium' ),
				'desc'        => 'the typography option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),
			array(
				'id'          => 'grandium_tipigrof6',
				'label'       => esc_html__( 'Typography h6', 'grandium' ),
				'desc'        => 'the typography option type is for adding typography styles to your site.',
				'type'        => 'typography',
				'section'     => 'typography'
			),


		/**
		* HEADER TOP AREA
		*/
		array(
			'id'          => 'grandium_nav_headertop_tab',
			'label'       => esc_html__( 'Topbar General', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'header_top'
		),
		array(
			'id'          => 'grandium_header_top',
			'label'       => esc_html__( 'Header top area visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Header top visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'header_top'
		),
		array(
			'id'          => 'grandium_nav_headertop_contact_tab',
			'label'       => esc_html__( 'Topbar Contact', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'header_top'
		),
		array(
			'id'          => 'grandium_header_top_contact',
			'label'       => esc_html__( 'Header top area contact visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Header top contact visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'header_top',
		),
		array(
			'id'          => 'grandium_header_top_number',
			'label'       => 'Header top phone number area',
			'desc'        => 'Header top phone number area',
			'type'        => 'text',
			'section'     => 'header_top',
		),
		// topbar social
		array(
			'id'          => 'grandium_nav_headertop_social_tab',
			'label'       => esc_html__( 'Topbar Social', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'header_top'
		),
		array(
			'id'          => 'grandium_social_top_display',
			'label'       => esc_html__( 'Header top social icons visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Header top social icons visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'header_top'
		),
		array(
			'id'          => 'grandium_social_top',
			'label'       => 'Header social icons',
			'desc'        => 'Header social icons',
			'type'        => 'list-item',
			'section'     => 'header_top',
			'settings'    => array(
				array(
					'id'          => 'grandium_social_top_text',
					'label'       => 'Social icon name',
					'desc'        => 'Enter font awesome social icon name',
					'type'        => 'text'
				),
				array(
					'id'          => 'grandium_social_top_link',
					'label'       => 'link',
					'desc'        => 'Enter social link',
					'type'        => 'text'
				)
			)
		),
		array(
			'id'          => 'grandium_social_top_target',
			'label'       => esc_html__( 'Header social icon target social media', 'grandium' ),
			'desc'        => esc_html__( 'Select social media target type. default : _blank' , 'grandium' ),
			'std'         => '_blank',
			'type'        => 'select',
			'section'     => 'header_top',
			'choices'     => array(
				array(
					'value'       => '_blank',
					'label'       => esc_html__( '_blank', 'grandium' )
				),
				array(
					'value'       => '_self',
					'label'       => esc_html__( '_self', 'grandium' )
				),
				array(
					'value'       => '_parent',
					'label'       => esc_html__( '_parent', 'grandium' )
				),
				array(
					'value'       => '_top',
					'label'       => esc_html__( '_top', 'grandium' )
				)
			)
		),
		array(
			'id'          => 'grandium_top_sz',
			'label'       => 'Social icon font size',
			'desc'        => 'Set header topbar social icon font size.',
			'type'        => 'text',
			'section'     => 'header_top',
		),
		// topbar social
		array(
			'id'          => 'grandium_nav_headertop_lang_tab',
			'label'       => esc_html__( 'Topbar Language', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'header_top'
		),
		array(
			'id'          => 'grandium_header_top_lang',
			'label'       => esc_html__( 'Header top language dropdown visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Header top language dropdown visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'header_top'
		),
		array(
			'id'          => 'grandium_header_language',
			'label'       => 'Header language dropdown',
			'desc'        => 'Header language dropdown',
			'type'        => 'list-item',
			'section'     => 'header_top',
			'settings'    => array(
				array(
					'id'          => 'grandium_lang_link',
					'label'       => 'Language url',
					'desc'        => 'Enter page url',
					'type'        => 'text'
				),
				array(
					'id'          => 'grandium_lang_text',
					'label'       => 'Name',
					'desc'        => 'Enter language name',
					'type'        => 'text'
				),
				array(
					'id'          => 'grandium_lang_active',
					'label'       => esc_html__( 'Active item', 'grandium' ),
					'desc'        => esc_html__( 'You can select your first active language item', 'grandium' ),
					'std'         => 'deactive',
					'type'        => 'select',
					'operator'    => 'and',
					'choices'     => array(
						array(
						'value'       => 'active',
						'label'       => esc_html__( 'Yes', 'grandium' )
						),
						array(
						'value'       => 'deactive',
						'label'       => esc_html__( 'no', 'grandium' )
						)
					)
				)
			)
		),


		/** NAVIGATION SETTINGS.   */
		array(
			'id'          => 'grandium_nav_static_tab',
			'label'       => esc_html__( 'Static Menu', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_header_bg',
			'label'       => esc_html__( 'Menu background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_nav_menu_ifs',
			'label'       => esc_html__( 'Menu item font-size', 'grandium' ),
			'desc'        => esc_html__( 'Navigation menu item font-size', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'header_colors',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_navitem',
			'label'       => esc_html__( 'Menu item color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_navitemhover',
			'label'       => esc_html__( 'Menu item hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		// sticky
		array(
			'id'          => 'grandium_nav_sticky_tab',
			'label'       => esc_html__( 'Sticky Menu', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_sticky_menu_display',
			'label'       => esc_html__( 'Sticky menu visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'You can enable or disable sticky menu %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'header_colors',
		),
		array(
			'id'          => 'grandium_sticky_header_bg',
			'label'       => esc_html__( 'Sticky menu background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_sticky_navitem',
			'label'       => esc_html__( 'Sticky menu item color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_sticky_navitemhover',
			'label'       => esc_html__( 'Sticky menu item hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		// dropdown
		array(
			'id'          => 'grandium_nav_dropdown_tab',
			'label'       => esc_html__( 'Dropdown Submenu', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_d_header_bg',
			'label'       => esc_html__( 'Dropdown submenu background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_d_navitem',
			'label'       => esc_html__( 'Dropdown submenu menu item color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),
		array(
			'id'          => 'grandium_d_navitemhover',
			'label'       => esc_html__( 'Dropdown submenu menu item hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_colors'
		),

		/**  SIDEBAR TYPE SETTINGS.  **/
		array(
			'id'          => 'grandium_sidebar_layout_tab',
			'label'       => esc_html__( 'Sidebar Layout', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_bloglayout',
			'label'       => esc_html__( 'Blog layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose blog page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_pagelayout',
			'label'       => esc_html__( 'Default page layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose default page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_searchlayout',
			'label'       => esc_html__( 'Search page layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose search page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_postlayout',
			'label'       => esc_html__( 'Blog single page layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose post page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_archivelayout',
			'label'       => esc_html__( 'Archive page layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose archive page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_404layout',
			'label'       => esc_html__( '404 page layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose 404 page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'woosingle',
			'label'       => esc_html__( 'Woocommerce single page layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose woocommerce single page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'woopage',
			'label'       => esc_html__( 'Woocommerce  page layout', 'grandium' ),
			'desc'        => esc_html__( 'Please choose 404 page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'sidebars'
		),

		// sidebars Colors
		array(
			'id'          => 'grandium_sidebar_colors_tab',
			'label'       => esc_html__( 'Sidebar Colors', 'grandium' ),
			'type'        => 'tab',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_sidebarwidgetareabgcolor',
			'label'       => esc_html__( 'Sidebar widget area background color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_sidebarwidgetgeneralcolor',
			'label'       => esc_html__( 'Sidebar widget general color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_sidebarwidgettitlecolor',
			'label'       => esc_html__( 'Sidebar widget title color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_sidebarlinkcolor',
			'label'       => esc_html__( 'Sidebar link title color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_sidebarlinkhovercolor',
			'label'       => esc_html__( 'Sidebar link title hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_sidebarsearchsubmittextcolor',
			'label'       => esc_html__( 'Sidebar search submit text color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'sidebars'
		),
		array(
			'id'          => 'grandium_sidebarsearchsubmitbgcolor',
			'label'       => esc_html__( 'Sidebar search submit background color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'sidebars'
		),

		/**
		* POST SETTINGS.
		*/
		array(
			'id'          => 'grandium_blogposttitlecolor',
			'label'       => esc_html__( 'Blog post title color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogposttitlhoverecolor',
			'label'       => esc_html__( 'Blog post title hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogmetacolor',
			'label'       => esc_html__( 'Blog post meta title color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogmetalinktextcolor',
			'label'       => esc_html__( 'Blog post meta link text color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogmetalinkhovercolor',
			'label'       => esc_html__( 'Blog post meta link text hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogmetalinktextbgcolor',
			'label'       => esc_html__( 'Blog post meta link text background color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogmetalinktextbghovercolor',
			'label'       => esc_html__( 'Blog post meta link text background hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogpostparagraphcolor',
			'label'       => esc_html__( 'Blog post paragraph color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogpostbuttonbgcolor',
			'label'       => esc_html__( 'Blog post button background color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogpostbuttonbghovercolor',
			'label'       => esc_html__( 'Blog post button background hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogpostbuttontitlecolor',
			'label'       => esc_html__( 'Blog post button title color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogpostbuttontitlehovercolor',
			'label'       => esc_html__( 'Blog post button title hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogsharebgcolor',
			'label'       => esc_html__( 'Blog post share icon background color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogsharebghovercolor',
			'label'       => esc_html__( 'Blog post share icon background hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogsharecolor',
			'label'       => esc_html__( 'Blog post share icon color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogsharehovercolor',
			'label'       => esc_html__( 'Blog post share icon hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogcommentformsubmitcolor',
			'label'       => esc_html__( 'Single post comment button title color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogcommentformsubmithovercolor',
			'label'       => esc_html__( 'Single post comment button title hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogcommentformsubmitbgcolor',
			'label'       => esc_html__( 'Single post comment button background color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_blogcommentformsubmitbghovercolor',
			'label'       => esc_html__( 'Single post comment button background hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_pagertitlecolor',
			'label'       => esc_html__( 'Pager button title color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_pagertitlehovercolor',
			'label'       => esc_html__( 'Pager button title hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_pagerbgcolor',
			'label'       => esc_html__( 'Pager button background color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),
		array(
			'id'          => 'grandium_pagerbghovercolor',
			'label'       => esc_html__( 'Pager button background hover color', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'post_color'
		),


		/**
		* BLOG/PAGE HEADER SETTINGS.
		*/
		array(
			'id'          => 'grandium_blog_background_visibility',
			'label'       => esc_html__( 'Pages header background image visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Heading visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => '35',
			'type'        => 'on-off',
			'section'     => 'header'
		),
		array(
			'id'          => 'grandium_otherpageheadbg',
			'label'       =>  esc_html__( 'Blog pages header section background image', 'grandium' ),
			'desc'        =>  esc_html__( 'You can upload your image for parallax header', 'grandium' ),
			'type'        => 'upload',
			'section'     => 'header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_blogheaderbgcolor',
			'label'       => esc_html__( 'Blog pages header section background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker-opacity',
			'section'     => 'header'
		),
		array(
			'id'          => 'grandium_blogheaderbgheight',
			'label'       => esc_html__( 'Blog pages header height', 'grandium' ),
			'desc'        => esc_html__( 'Blog pages header height', 'grandium' ),
			'type'        => 'numeric-slider',
			'std'         => '35',
			'min_max_step'=> '0,100',
			'section'     => 'header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_blogheaderpaddingtop',
			'label'       => esc_html__( 'Header padding top', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_blogheaderpaddingbottom',
			'label'       => esc_html__( 'Header padding bottom', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'header',
			'operator'    => 'and'
		),


		/**
		* SINGLE HEADER SETTINGS.
		*/
		array(
			'id'          => 'grandium_singlepageheadbg',
			'label'       =>  esc_html__( 'Single header section background image', 'grandium' ),
			'desc'        =>  esc_html__( 'You can upload your image for parallax header', 'grandium' ),
			'type'        => 'upload',
			'section'     => 'single_header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_single_room_bg',
			'label'       =>  esc_html__( 'Single room header background image', 'grandium' ),
			'desc'        =>  esc_html__( 'You can upload your image header', 'grandium' ),
			'type'        => 'upload',
			'section'     => 'single_header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_singleheaderbgcolor',
			'label'       => esc_html__( 'Single pages header section background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',

			'section'     => 'single_header'
		),
		array(
			'id'          => 'grandium_single_disable_heading',
			'label'       => esc_html__( 'Single pages heading post title visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please select single pages heading post title  visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'single_header'
		),
		array(
			'id'          => 'grandium_singleheaderbgheight',
			'label'       => esc_html__( 'Single pages header height', 'grandium' ),
			'desc'        => esc_html__( 'Single pages header height', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'single_header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_singleheaderpaddingtop',
			'label'       => esc_html__( 'Header padding top', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),

			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'single_header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_singleheaderpaddingbottom',
			'label'       => esc_html__( 'Header padding bottom', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'single_header',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_singleheadingcolor',
			'label'       => esc_html__( 'Single pages heading color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',

			'section'     => 'single_header'
		),
		array(
			'id'          => 'grandium_single_heading_fontsize',
			'label'       => esc_html__( 'Single heading font size', 'grandium' ),
			'desc'        => esc_html__( 'Enter single heading font size', 'grandium' ),
			'std'         => '48',
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'single_header',
			'operator'    => 'and'
		),


		/**
		* ARCHIVE HEADER SETTINGS.
		*/
		array(
			'id'          => 'grandium_archivepageheadbg',
			'label'       =>  esc_html__( 'Archive header section background image', 'grandium' ),
			'desc'        =>  esc_html__( 'You can upload your image for parallax header', 'grandium' ),
			'type'        => 'upload',
			'section'     => 'archive_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_archiveheaderbgcolor',
			'label'       => esc_html__( 'Archive pages header section background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',

			'section'     => 'archive_page'
		),
		array(
			'id'          => 'grandium_archiveheaderbgheight',
			'label'       => esc_html__( 'Archive pages header height', 'grandium' ),
			'desc'        => esc_html__( 'Archive pages header height', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'archive_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_archiveheaderpaddingtop',
			'label'       => esc_html__( 'Header padding top', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),

			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'archive_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_archiveheaderpaddingbottom',
			'label'       => esc_html__( 'Header padding bottom', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'archive_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_archive_heading_visibility',
			'label'       => esc_html__( 'Archive heading visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Archive heading visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'archive_page'
		),
		array(
			'id'          => 'grandium_archive_heading',
			'label'       => esc_html__( 'Archive heading', 'grandium' ),
			'desc'        => esc_html__( 'Enter archive heading', 'grandium' ),
			'std'         => 'our archive',
			'type'        => 'text',
			'section'     => 'archive_page'
		),
		array(
			'id'          => 'grandium_archive_heading_fontsize',
			'label'       => esc_html__( 'Archive heading font size', 'grandium' ),
			'desc'        => esc_html__( 'Enter archive heading font size', 'grandium' ),
			'std'         => '48',
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'archive_page',
			'operator'    => 'and'
		),

		array(
			'id'          => 'grandium_archiveheadingcolor',
			'label'       => esc_html__( 'Archive pages heading color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'archive_page'
		),

		array(
			'id'          => 'grandium_archive_slogan_visibility',
			'label'       => esc_html__( 'Archive heading visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Archive slogan visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'archive_page'
		),
		array(
			'id'          => 'grandium_archive_slogan',
			'label'       => esc_html__( 'Archive slogan', 'grandium' ),
			'desc'        => esc_html__( 'Enter archive slogan', 'grandium' ),
			'std'         => 'welcome to your archive. this is your all post. edit or delete them, then start writing!',
			'type'        => 'text',
			'section'     => 'archive_page'
		),
		array(
			'id'          => 'grandium_archiveheaderparagraphcolor',
			'label'       => esc_html__( 'Archive pages paragraph/slogan color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'archive_page'
		),



		/**
		* 404 PAGE HEADER SETTINGS.
		*/
		array(
			'id'          => 'grandium_errorpageheadbg',
			'label'       =>  esc_html__( '404 header section background image', 'grandium' ),
			'desc'        =>  esc_html__( 'You can upload your image for parallax header', 'grandium' ),
			'type'        => 'upload',
			'section'     => 'error_page',
			'operator'    => 'and'
		),

		array(
			'id'          => 'grandium_errorheaderbgcolor',
			'label'       => esc_html__( '404 pages header section background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'error_page'
		),

		array(
			'id'          => 'grandium_errorheaderbgheight',
			'label'       => esc_html__('404 pages header height', 'grandium' ),
			'desc'        => esc_html__('404 pages header height', 'grandium' ),
			'type'        => 'numeric-slider',
			'std'         => '37',
			'min_max_step'=> '0,100',
			'section'     => 'error_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_errorheaderpaddingtop',
			'label'       => esc_html__( 'Header padding top', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'error_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_errorheaderpaddingbottom',
			'label'       => esc_html__( 'Header padding bottom', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'error_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_error_heading_visibility',
			'label'       => esc_html__( '404 page heading visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Error heading visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'error_page'
		),
		array(
			'id'          => 'grandium_error_heading',
			'label'       => esc_html__( '404 page heading', 'grandium' ),
			'desc'        => esc_html__( 'Enter error heading', 'grandium' ),
			'std'         => '404 page',
			'type'        => 'text',
			'section'     => 'error_page'
		),
		array(
			'id'          => 'grandium_error_heading_fontsize',
			'label'       => esc_html__('404 page heading font size', 'grandium' ),
			'desc'        => esc_html__( 'Enter 404 page heading font size', 'grandium' ),
			'std'         => '48',
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'error_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_errorheadingcolor',
			'label'       => esc_html__( '404 pages heading color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',

			'section'     => 'error_page'
		),
		array(
			'id'          => 'grandium_error_slogan_visibility',
			'label'       => esc_html__( '404 page slogan visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( '404 page slogan visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'error_page'
		),
		array(
			'id'          => 'grandium_error_slogan',
			'label'       => esc_html__( '404 page slogan', 'grandium' ),
			'desc'        => esc_html__( 'Enter 404 page slogan', 'grandium' ),
			'std'         => 'oops! that page can not be found.',
			'type'        => 'text',
			'section'     => 'error_page'
		),
		array(
			'id'          => 'grandium_errorheaderparagraphcolor',
			'label'       => esc_html__( '404 pages paragraph/slogan color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',

			'section'     => 'error_page'
		),


		/**
		* SEARCH PAGE HEADER SETTINGS.
		*/
		array(
			'id'          => 'grandium_searchpageheadbg',
			'label'       =>  esc_html__( 'Search header section background image', 'grandium' ),
			'desc'        =>  esc_html__( 'You can upload your image for parallax header', 'grandium' ),
			'type'        => 'upload',
			'section'     => 'search_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_searchheaderbgcolor',
			'label'       => esc_html__( 'Search pages header section background color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',

			'section'     => 'search_page'
		),
		array(
			'id'          => 'grandium_searchheaderbgheight',
			'label'       => esc_html__( 'Search pages header height', 'grandium' ),
			'desc'        => esc_html__( 'Search pages header height', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'search_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_searchheaderpaddingtop',
			'label'       => esc_html__( 'Header padding top', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),

			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'search_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_searchheaderpaddingbottom',
			'label'       => esc_html__( 'Header padding bottom', 'grandium' ),
			'desc'        => esc_html__( 'You can use this option for heading text vertical align', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,500',
			'section'     => 'search_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_search_heading_visibility',
			'label'       => esc_html__( 'Search page heading visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Search heading visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'search_page'
		),
		array(
			'id'          => 'grandium_search_heading',
			'label'       => esc_html__( 'Search page heading', 'grandium' ),
			'desc'        => esc_html__( 'Enter search heading', 'grandium' ),
			'std'         => 'search page',
			'type'        => 'text',
			'section'     => 'search_page'
		),
		array(
			'id'          => 'grandium_search_heading_fontsize',
			'label'       => esc_html__( 'Search page heading font size', 'grandium' ),
			'desc'        => esc_html__( 'Enter search page heading font size', 'grandium' ),
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'search_page',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_searchheadingcolor',
			'label'       => esc_html__( 'Search pages heading color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',

			'section'     => 'search_page'
		),
		array(
			'id'          => 'grandium_search_slogan_visibility',
			'label'       => esc_html__( 'Search page slogan visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Search page slogan visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'search_page'
		),
		array(
			'id'          => 'grandium_search_slogan',
			'label'       => esc_html__( 'Search page slogan', 'grandium' ),
			'desc'        => esc_html__( 'Enter search page slogan', 'grandium' ),
			'std'         => 'search completed',
			'type'        => 'text',
			'section'     => 'search_page'
		),
		array(
			'id'          => 'grandium_searchheaderparagraphcolor',
			'label'       => esc_html__( 'Search pages paragraph/slogan color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'search_page'
		),


		/**
		* BLOG/PAGE HEADING COLOR SETTINGS.
		*/
		array(
			'id'          => 'grandium_blogheadingcolor',
			'label'       => esc_html__( 'Blog pages heading color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_color'
		),
		array(
			'id'          => 'grandium_blogsubtitlecolor',
			'label'       => esc_html__( 'Blog pages subtitle color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'header_color'
		),

		/**
		* BREADCRUBMS SETTINGS.
		*/
		array(
			'id'          => 'grandium_breadcrubms',
			'label'       => esc_html__( 'Breadcrubms visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Breadcrubms visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'breadcrubms'
		),
		array(
			'id'          => 'grandium_blogbreadcrubmscolor',
			'label'       => esc_html__( 'Blog pages breadcrubms color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'breadcrubms'
		),
		array(
			'id'          => 'grandium_blogbreadcrubmshovercolor',
			'label'       => esc_html__( 'Blog pages breadcrubms hover color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'breadcrubms'
		),
		array(
			'id'          => 'grandium_blogbreadcrubmscurrentcolor',
			'label'       => esc_html__( 'Blog pages breadcrubms current page text color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'breadcrubms'
		),
		array(
			'id'          => 'grandium_blogbreadcrubmsfontsize',
			'label'       => esc_html__( 'Breadcrubms font size', 'grandium' ),
			'desc'        => esc_html__( 'Blog/pages header breadcrubms font size', 'grandium' ),
			'std'         => '15',
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'breadcrubms',
			'operator'    => 'and'
		),


		/**
		* FOOTER SETTINGS.
		*/
		array(
			'id'          => 'grandium_top_footerwd',
			'label'       => esc_html__( 'Footer top widgetize area section', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please choose footer widgetize section %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'off',
			'type'        => 'on-off',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_newsletter_section',
			'label'       => esc_html__( 'Footer newsletter section', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please choose footer newsletter section %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_footer_newsletter_head',
			'label'       => 'footer newsletter heading',
			'desc'        => 'footer copyright text',
			'std'         => '',
			'type'        => 'text',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_footer_newsletter_desc',
			'label'       => 'footer newsletter description',
			'desc'        => 'footer newsletter text',
			'std'         => '',
			'type'        => 'text',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_footer_powered_area',
			'label'       => esc_html__( 'Footer powered section', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please choose footer copyright section %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_copyright',
			'label'       => 'footer copyright',
			'desc'        => 'footer copyright text',
			'std'         => '',
			'type'        => 'text',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_footer_social_head',
			'label'       => 'footer social heading',
			'desc'        => 'footer copyright text',
			'std'         => '',
			'type'        => 'text',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_footer_social_desc',
			'label'       => 'footer social description',
			'desc'        => 'footer copyright text',
			'std'         => '',
			'type'        => 'text',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_social_section',
			'label'       => esc_html__( 'Social section visibility ', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please choose social section visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'copyright'
		),
		array(
			'id'          => 'grandium_social_item',
			'label'       => 'footer social icons',
			'desc'        => 'footer social icons',
			'type'        => 'list-item',
			'section'     => 'copyright',
			'settings'    => array(
				array(
					'id'          => 'grandium_social_text',
					'label'       => 'social icon name',
					'desc'        => 'enter font awesome social icon name',
					'type'        => 'text'
				),
				array(
					'id'          => 'grandium_social_link',
					'label'       => 'link',
					'desc'        => 'enter font awesome social share link',
					'type'        => 'text'
				)
			)
		),
		array(
			'id'          => 'grandium_social_target',
			'label'       => esc_html__( 'Target social media', 'grandium' ),
			'desc'        => esc_html__( 'Select social media target type. default : _blank' , 'grandium' ),
			'std'         => '_blank',
			'type'        => 'select',
			'section'     => 'copyright',
			'choices'     => array(
				array(
					'value'       => '_blank',
					'label'       => esc_html__( '_blank', 'grandium' )
				),
				array(
					'value'       => '_self',
					'label'       => esc_html__( '_self', 'grandium' )
				),
				array(
					'value'       => '_parent',
					'label'       => esc_html__( '_parent', 'grandium' )
				),
				array(
					'value'       => '_top',
					'label'       => esc_html__( '_top', 'grandium' )
				),
			)
		),
		array(
			'id'          => 'grandium_social_fontsize',
			'label'       => esc_html__( 'Social font size', 'grandium' ),
			'desc'        => esc_html__( 'Footer social font size', 'grandium' ),
			'std'         => '14',
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'copyright',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_social_margin_left',
			'label'       => esc_html__( 'Social margin-left', 'grandium' ),
			'desc'        => esc_html__( 'Footer social margin-left', 'grandium' ),
			'std'         => '10',
			'type'        => 'numeric-slider',
			'min_max_step'=> '0,100',
			'section'     => 'copyright',
			'operator'    => 'and'
		),
		array(
			'id'          => 'grandium_footer_adress_area',
			'label'       => esc_html__( 'Footer adress', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please choose footer contact adress %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'footer_contact'
		),
		array(
			'id'          => 'grandium_footer_adress',
			'label'       => 'Footer adress',
			'desc'        => 'Footer adress',
			'type'        => 'text',
			'section'     => 'footer_contact'
		),
		array(
			'id'          => 'grandium_footer_phone_area',
			'label'       => esc_html__( 'Footer phone', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please choose footer phone adress %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'footer_contact'
		),
		array(
			'id'          => 'grandium_footer_phone',
			'label'       => 'Footer phone',
			'desc'        => 'Footer phone',
			'type'        => 'text',
			'section'     => 'footer_contact'
		),
		array(
			'id'          => 'grandium_footer_mail_area',
			'label'       => esc_html__( 'Footer mail', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Please choose footer mail mail %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'footer_contact'
		),
		array(
			'id'          => 'grandium_footer_mail',
			'label'       => 'Footer mailto url',
			'desc'        => 'example : mailto:someone@example.com',
			'type'        => 'text',
			'section'     => 'footer_contact'
		),
		array(
			'id'          => 'grandium_footer_mail_text',
			'label'       => 'Footer mailto text',
			'desc'        => 'example : someone@example.com',
			'type'        => 'text',
			'section'     => 'footer_contact'
		),

		/**
		* FOOTER COLOR SETTINGS.
		*/
		array(
			'id'          => 'grandium_footerbgcolor',
			'label'       => esc_html__( 'Footer background  color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'copyright_color'
		),
		array(
			'id'          => 'grandium_footer_color',
			'label'       => esc_html__( 'Footer text color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'copyright_color'
		),
		array(
			'id'          => 'grandium_footersocialcolor',
			'label'       => esc_html__( 'Footer social color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'copyright_color'
		),
		array(
			'id'          => 'grandium_footersocialhovercolor',
			'label'       => esc_html__( 'Footer social icon hover color ', 'grandium' ),
			'desc'        => esc_html__( 'Please select color', 'grandium' ),
			'type'        => 'colorpicker',
			'section'     => 'copyright_color'
		),

		// MAPS API
		array(
			'id'          => 'grandium_map_api_key',
			'label'       => 'Google maps api key',
			'desc'        => 'You must create an api key and paste this box. create :https://developers.google.com/maps/documentation/javascript/get-api-key#key ',
			'type'        => 'text',
			'section'     => 'maps'
		),


		// WOOCOMMERCE
		array(
			'id'          => 'woo_column',
			'label'       => esc_html__( 'Woocommerce list page column type', 'grandium' ),
			'desc'        => esc_html__( 'You can change column number via this option', 'grandium' ),
			'std'         => '4',
			'type'        => 'select',
			'section'     => 'woo',
			'choices'     => array(
				array(
					'value'       => '4',
					'label'       => esc_html__( 'default', 'grandium' )
				),
				array(
					'value'       => '3',
					'label'       => esc_html__( '3 column', 'grandium' )
				),
				array(
					'value'       => '2',
					'label'       => esc_html__( '2 column', 'grandium' )
				)
			)
		),
		array(
			'id'          => 'grandium_shop_sub_d_s_t',
			'label'       => esc_html__( 'Shop page mini title visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Shop page mini title visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'woo'
		),
		array(
			'id'          => 'grandium_sub_shop_s_t',
			'label'       => esc_html__( 'Shop page mini title', 'grandium' ),
			'desc'        => esc_html__( 'Shop page mini title ', 'grandium' ),
			'std'         => 'Shop',
			'type'        => 'text',
			'section'     => 'woo'
		),
		array(
			'id'          => 'grandium_shop_d_s_t',
			'label'       => esc_html__( 'Shop page title visibility', 'grandium' ),
			'desc'        => sprintf( esc_html__( 'Shop page title visibility %s or %s.', 'grandium' ), '<code>on</code>', '<code>off</code>' ),
			'std'         => 'on',
			'type'        => 'on-off',
			'section'     => 'woo'
		),
		array(
			'id'          => 'grandium_shop_s_t',
			'label'       => esc_html__( 'Shop page title', 'grandium' ),
			'desc'        => esc_html__( 'Shop page title ', 'grandium' ),
			'std'         => 'Shop',
			'type'        => 'text',
			'section'     => 'woo'
		),
		array(
			'id'          => 'woosingle_layout',
			'label'       => esc_html__( 'Woocommerce single page layout', 'grandium' ),
			'desc'        => esc_html__( 'Choose woocommerce single page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'woo',
			'operator'    => 'and'
		),
		array(
			'id'          => 'woopage_layout',
			'label'       => esc_html__( 'Woocommerce  page layout', 'grandium' ),
			'desc'        => esc_html__( 'Choose woocommerce page layout type', 'grandium' ),
			'std'         => 'right-sidebar',
			'type'        => 'radio-image',
			'section'     => 'woo',
			'operator'    => 'and'
		),


		/**
		* ROOMS SETTINGS
		*/
		array(
			'id'          => 'grandium_rooms_mtitle',
			'label'       => esc_html__( 'Featured room title', 'grandium' ),
			'desc'        =>  esc_html__( 'Please add rooms main title', 'grandium' ),
			'type'        => 'text',
			'section'     => 'rooms'
		),
		array(
			'id'          => 'grandium_rooms_ltitleone',
			'label'       => esc_html__( 'Room details title 1', 'grandium' ),
			'desc'        =>  esc_html__( 'Please add rooms details title 1', 'grandium' ),
			'type'        => 'text',
			'section'     => 'rooms'
		),
		array(
			'id'          => 'grandium_rooms_lstitleone',
			'label'       => esc_html__( 'Room  details subtitle 1', 'grandium' ),
			'desc'        => esc_html__( 'Please add rooms details subtitle 1', 'grandium' ),
			'type'        => 'text',
			'section'     => 'rooms'
		),
		array(
			'id'          => 'grandium_rooms_ltitletwo',
			'label'       => esc_html__( 'Room details title 2', 'grandium' ),
			'desc'        => esc_html__( 'Please add rooms details title 2', 'grandium' ),
			'type'        => 'text',
			'section'     => 'rooms'
		),
		array(
			'id'          => 'grandium_rooms_lstitletwo',
			'label'       => esc_html__( 'Room  details subtitle 2', 'grandium' ),
			'desc'        =>  esc_html__( 'Please add rooms details subtitle 2', 'grandium' ),
			'type'        => 'text',
			'section'     => 'rooms'
		),

		array(
			'id'          => 'additionalcss',
			'label'       => esc_html__( 'Custom css', 'grandium' ),
			'desc'        => esc_html__( 'You can add additional css', 'grandium' ),
			'type'        => 'css',
			'section'     => 'customstyle',
			'rows'        => '20'
		),
		array(
			'id'          => 'additionaljs',
			'label'       => esc_html__( 'Custom js', 'grandium' ),
			'desc'        => esc_html__( 'You can add additional javascript', 'grandium' ),
			'type'        => 'css',
			'section'     => 'customstyle',
			'rows'        => '20'
		),

	));

	/* allow settings to be filtered before saving */
	$grandium_custom_settings = apply_filters( ot_settings_id() . '_args', $grandium_custom_settings );

	/* settings are not the same update the db */
	if ( $grandium_saved_settings !== $grandium_custom_settings ) {
	update_option( ot_settings_id(), $grandium_custom_settings );
	}
	/* lets optiontree know the ui builder is being overridden */
	global $ot_has_custom_theme_options;
	$ot_has_custom_theme_options = true;
}
