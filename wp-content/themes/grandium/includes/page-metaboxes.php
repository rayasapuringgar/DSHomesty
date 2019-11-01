<?php

add_filter( 'rwmb_meta_boxes', 'grandium_register_meta_boxes' );
function grandium_register_meta_boxes( $meta_boxes ) {

$prefix = 'grandium_';

$meta_boxes = array();


/* ----------------------------------------------------- */
// Frontpage Settings
/* ----------------------------------------------------- */

$meta_boxes[] = array(
	'id' => 'page-settings',
	'title' => 'Page Settings',
	'pages' => array( 'page' ),
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'type' 		=> 'heading',
			'id'   		=> 'page_design_section',
			'name'		=> 'Mini Title Options',
		),
		array(
			'name' => 'Disable Page Mini Title',
			'id'   => $prefix . "disable_mini_title",
			'type' => 'checkbox',
			'std'  => 0,
		),
		array(
			'name'		=> 'Alternate Page Mini Title',
			'id'		=> $prefix . "mini_title",
			'clone'		=> false,
			'type'		=> 'text'
		),
		array(
			'type' => 'divider',
			'id'   => 'fake_divider_id',
		),
		array(
			'type' 		=> 'heading',
			'id'   		=> 'page_design_section',
			'name'		=> 'Title Options',
		),

		array(
			'name' => 'Disable Page Title',
			'id'   => $prefix . "disable_alt_title",
			'type' => 'checkbox',
			'std'  => 0,
		),
		array(
			'name'		=> 'Alternate Page Title',
			'id'		=> $prefix . "alt_title",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> ''
		),
		array(
			'type' => 'divider',
			'id'   => 'fake_divider_id',
		),
		array(
			'type' 		=> 'heading',
			'id'   		=> 'page_design_section',
			'name'		=> 'Subtitle Options',
		),
		array(
			'name' => 'Disable Page Subtitle',
			'id'   => $prefix . "disable_sub_title",
			'type' => 'checkbox',
			// 0 number is mean false
			'std'  => 0,
		),
		array(
			'name' => esc_html__( 'Page Subtitle / Rich Text Editor', 'grandium' ),
			'id'		=> $prefix . "subtitle",
			'type' => 'wysiwyg',
			'raw'  => false,
			'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
				'media_buttons' => false,
			),
		),
		array(
			'type' => 'divider',
			'id'   => 'fake_divider_id',
		),
		array(
			'type' 		=> 'heading',
			'id'   		=> 'page_design_section',
			'name'		=> 'Design Options',
		),
		array(
			'name' => esc_html__( 'Page breadcrumb background color', 'grandium' ),
			'id'   => $prefix . "pagebgcolor",
			'type' => 'color',
		),
		array(
			'name' => esc_html__( 'Page breadcrumb text color', 'grandium' ),
			'id'   => $prefix . "pagetextcolor",
			'type' => 'color',
		),
		array(
			'name' => esc_html__( 'Page header padding top', 'grandium' ),
			'id'   => $prefix . "headerptop",
			'type' => 'number',
			'min'  => 0,
			'step' => 1,
		),
		array(
			'name' => esc_html__( 'Page header padding bottom', 'grandium' ),
			'id'   => $prefix . "headerpbottom",
			'type' => 'number',
			'min'  => 0,
			'step' => 1,
		),
		array(
			'name'     => esc_html__( 'Page sidebar', 'grandium' ),
			'id'       => $prefix . "pagelayout",
			'type'     => 'select',
			'options'  => array(
				'left-sidebar' => esc_html__( 'left', 'grandium' ),
				'right-sidebar' => esc_html__( 'right', 'grandium' ),
				'full-width' => esc_html__( 'full', 'grandium' ),
			),
			'multiple'    => false,
			'std'         => 'full-width',
			'placeholder' => esc_html__( 'Select an Item', 'grandium' ),
		),
	)
);

// price table
$meta_boxes[] = array(
	'id' 		=> 'eventssettings',
	'title' 	=> 'Price table',
	'pages' 	=> array( 'price' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'fields' 	=> array(

		array(
			'name'		=> 'Select price table type - color',
			'id'		=> $prefix . "pricecategories",
			'type'		=> 'select',
			'options'	=> array(
			    'select'		=> 'Select a section',
				'best'				=> 'Best',
				'normal'			=> 'Normal'
			),
			'multiple'	=> false,
			'std'		=> 'Select a Section'
		),

		array(
			'name'		=> 'Price pack name',
			'id'		=> $prefix . "packname",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> 'Basic'
		),

		array(
			'name'		=> 'Price currency',
			'id'		=> $prefix . "currency",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '$'
		),

		array(
			'name'		=> 'Price amount',
			'id'		=> $prefix . "priceamount",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '120'
		),
		array(
			'name'		=> 'Price delimiter',
			'id'		=> $prefix . "pricedelimiter",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '/'
		),

		array(
			'name'		=> 'Price period',
			'id'		=> $prefix . "pricedate",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> 'mo'
		),

	    array(
			'name'		=> 'Pack description',
			'id'		=> $prefix . "pricedescription",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> 'Lorem Ipsum is simply dummy text of the printing'
		),

		array(
			'name'  => 'Table Features List',
			'desc'  => 'Format: 140GB or any text',
			'id'    => $prefix . 'features_list',
			'type'  => 'text',
			'std'   => 'Enhanced Security',
			'class' => 'custom-class',
			'clone' => true,
			'clone-group' => 'my-clone-group','clone-group' => 'my-clone-group',
            ),

		array(
			'name'		=> 'Price button link',
			'id'		=> $prefix . "btn_link",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '#'
		),

		array(
			'name'		=> 'Price button link text',
			'id'		=> $prefix . "btn_title",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> 'Select plan'
		),
		array(
			'name'		=> 'Select target type',
			'id'		=> $prefix . "pricebtn_target",
			'type'		=> 'select',
			'multiple'	=> false,
			'std'		=> '_blank',
			'options'	=> array(
				'_blank'		=> '_blank',
				'_self'			=> '_self',
				'_parent'		=> '_parent',
				'_top'			=> '_top',
			)
		),
	)
);

// rooms
$meta_boxes[] = array(
	'id' 		=> 'rooms',
	'title' 	=> 'Rooms',
	'pages' 	=> array( 'rooms' ),
	'context' 	=> 'normal',
	'priority' 	=> 'high',
	'fields' 	=> array(

	    array(
			'name'		=> 'Currency',
			'id'		=> $prefix . "currency",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '$'
		),

	    array(
			'name'		=> 'Price',
			'id'		=> $prefix . "price",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '320'
		),

	    array(
			'name'		=> 'Sale Price',
			'id'		=> $prefix . "sale_price",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '200'
		),

	    array(
			'name'		=> 'Day Label',
			'id'		=> $prefix . "label",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> 'Per Night'
		),

		array(
			'name'		=> 'Select room rate',
			'id'		=> $prefix . "rate",
			'type'		=> 'select',
			'options'	=> array(
			    '0'		=> 'Select a section',
				'1'		=> '1',
				'2'		=> '2',
				'3'		=> '3',
				'4'		=> '4',
				'5'		=> '5'
			),
			'multiple'	=> false,
			'std'		=> 'Select a Section'
		),

		array(
			'name'  => 'Room features list',
			'desc'  => 'Format: BREAKFAST, TV and more',
			'id'    => $prefix . 'features_list',
			'type'  => 'text',
			'std'   => 'BREAKFAST',
			'clone' => true,
			'clone-group' => 'room-clone-group','clone-group' => 'room-clone-group',
        ),
		array(
			'name' => esc_html__('Room gallery images', 'grandium'),
			'desc' => esc_html__('Select the images from the media library or upload your new ones.', 'grandium'),
			'id'   => $prefix . 'rooms_images',
			'type' => 'image_advanced',
		),
		array(
			'name'		=> 'Single room page shortcode area visibility',
			'id'		=> $prefix . "room_shortcode_v",
			'type'		=> 'select',
			'options'	=> array(
			    's'		=> 'Select a section',
				'h'		=> 'hide',
				's'		=> 'show'
			),
			'multiple'	=> false,
			'std'		=> 'Select a Section'
		),
		array(
			'name'		=> 'Single room page price area visibility',
			'id'		=> $prefix . "grandium_room_price_v",
			'type'		=> 'select',
			'options'	=> array(
			    's'		=> 'Select a section',
				'h'		=> 'hide',
				's'		=> 'show'
			),
			'multiple'	=> false,
			'std'		=> 'Select a Section'
		),
		array(
			'name'		=> 'Single room page features area visibility',
			'id'		=> $prefix . "features_list_v",
			'type'		=> 'select',
			'options'	=> array(
			    's'		=> 'Select a section',
				'h'		=> 'hide',
				's'		=> 'show'
			),
			'multiple'	=> false,
			'std'		=> 'Select a Section'
		),
		array(
			'name'		=> 'Room shortcode area',
			'id'		=> $prefix . "room_shortcode",
			'desc' 		=> 'You can use booked shortcode in the tinyMCE editor menu, click on settings icon',
			'clone'		=> false,
			'type'		=> 'wysiwyg',
			'std'		=> '[booked-calendar size="small"]'
		),
		array(
			'name'		=> 'Select button type',
			'id'		=> $prefix . "button_type",
			'type'		=> 'select',
			'options'	=> array(
			    'permalink'		=> 'Select a section',
				'permalink'		=> 'Permalink',
				'custom'		=> 'Custom'
			),
			'multiple'	=> false,
			'std'		=> 'Select a Section'
		),
      array(
         'name'		=> 'Select link target type',
         'id'		=> $prefix . "room_target",
         'type'		=> 'select',
         'options'	=> array(
            '_self'		=> 'Select an option',
            '_self'		=> 'Self',
            '_blank'		=> 'Blank',
            '_parent'	=> 'Parent',
            '_top'		=> 'Top',
         ),
         'multiple'	=> false,
         'std'		=> 'Select a Section'
      ),
		array(
			'name'		=> 'Room button link',
			'id'		=> $prefix . "btn_link",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> '#'
		),

		array(
			'name'		=> 'Room button link text',
			'id'		=> $prefix . "btn_title",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> 'Select plan'
		),

		array(
			'name'		=> 'Select button target type',
			'id'		=> $prefix . "btn_target",
			'type'		=> 'select',
			'multiple'	=> false,
			'std'		=> '_blank',
			'options'	=> array(
				'_blank'		=> '_blank',
				'_self'			=> '_self',
				'_parent'		=> '_parent',
				'_top'			=> '_top',
			)
		),

	)
);




$meta_boxes[] = array(
	'title' 		=> esc_html__( 'Member Social Box', 'grandium' ),
	'pages'    		=> array( 'team' ),
	'clone-group' 	=> 'my-clone-group','clone-group' => 'my-clone-group',
	'id' 			=> 'mm_review',
	'context'     	=> 'normal',
	'priority'    	=> 'high',
	'fields' 		=> array(

		array(
			'name'		=> 'Team Job',
			'id'		=> $prefix . "team_job",
			'clone'		=> false,
			'type'		=> 'text',
			'std'		=> 'Developer'
		),
		array(
			'name'		=> 'Select social icon font family',
			'id'		=> $prefix . "font_family",
			'type'		=> 'select',
			'multiple'	=> false,
			'std'		=> 'etline',
			'options'	=> array(
				'select'		=> 'Select font-family',
				'fontawesome'	=> 'Fontawesome',
				'socicon'		=> 'Socicon',
				'etline'		=> 'Et-line',
			)
		),
		array(
			'name'		=> 'Select target type',
			'id'		=> $prefix . "social_target",
			'type'		=> 'select',
			'multiple'	=> false,
			'std'		=> '_blank',
			'options'	=> array(
				'_blank'		=> '_blank',
				'_self'			=> '_self',
				'_parent'		=> '_parent',
				'_top'			=> '_top',
			)
		),

		array(
			'name'  => 'Social Icon Name',
			'desc'  => 'Format: facebook. Enter social icon name here',
			'id'    => $prefix . 'social_icon',
			'type'  => 'text',
			'std'   => 'facebook',
			'class' => 'custom-class',
			'clone' => true,
			'clone-group' => 'my-clone-group','clone-group' => 'my-clone-group',
		),

		array(
			'name'  => 'Social Url',
			'desc'  => 'Format: http://facebook.com',
			'id'    => $prefix . 'social_url',
			'type'  => 'text',
			'std'   => '#',
			'class' => 'custom-class',
			'clone' => true,
			'clone-group' => 'my-clone-group',
		),
	),
);


/*-----------------------------------------------------------------------------------*/
/*  Metaboxes for blog posts
/*-----------------------------------------------------------------------------------*/

    /* Gallery Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Gallery Settings', 'grandium'),
        'pages'    => array('post'),

        'fields' => array(
            array(
                'name' => esc_html__('Select Images', 'grandium'),
                'desc' => esc_html__('Select the images from the media library or upload your new ones.', 'grandium'),
                'id'   => $prefix . 'gallery_image',
                'type' => 'image_advanced',
            )
        )
    );

    /* Quote Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Quote Settings', 'grandium'),
        'pages'    => array('post'),
        'fields' => array(
            array(
                'name' => esc_html__('The Quote', 'grandium'),
                'desc' => esc_html__('Write your quote in this field.', 'grandium'),
                'id'   => $prefix . 'quote_text',
                'type' => 'textarea',
                'rows' => 5
            ),
            array(
                'name' => esc_html__('The Author', 'grandium'),
                'desc' => esc_html__('Enter the name of the author of this quote.', 'grandium'),
                'id'   => $prefix . 'quote_author',
                'type' => 'text'
            ),
            array(
                'name' => esc_html__('Background Color', 'grandium'),
                'desc' => esc_html__('Choose the background color for this quote.', 'grandium'),
                'id'   => $prefix . 'quote_bg',
                'type' => 'color'
            ),
            array(
                'name' => esc_html__('Background Opacity', 'grandium'),
                'desc' => esc_html__('Choose the opacity of the background color.', 'grandium'),
                'id'   => $prefix . 'quote_bg_opacity',
                'type' => 'text',
                'std' => 80
            )
        )
    );

    /* Link Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Link Settings', 'grandium'),
        'pages'    => array('post'),
        'fields' => array(
            array(
                'name' => esc_html__('The URL', 'grandium'),
                'desc' => esc_html__('Insert the URL you wish to link to.', 'grandium'),
                'id'   => $prefix . 'the_link',
                'type' => 'textarea',
            ),
            array(
                'name' => esc_html__('Background Color', 'grandium'),
                'desc' => esc_html__('Choose the background color for this link.', 'grandium'),
                'id'   => $prefix . 'link_bg',
                'type' => 'color',
                'std'  => '#d5d85f'
            ),
            array(
                'name' => esc_html__('Background Opacity', 'grandium'),
                'desc' => esc_html__('Choose the opacity of the background color.', 'grandium'),
                'id'   => $prefix . 'link_bg_opacity',
                'type' => 'text',
                'std' => 80
            )
        )
    );

    /* Image Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Image Settings', 'grandium'),
        'pages'    => array('post'),
        'fields' => array(
            array(
                'name' => esc_html__('Enable Lightbox', 'grandium'),
                'desc' => esc_html__('Check this to enable the lightbox.', 'grandium'),
                'id'   => $prefix . 'enable_lightbox',
                'type' => 'select',
                'options'  => array(
                    'value1' => esc_html__( 'Yes', 'grandium' ),
                    'value2' => esc_html__( 'No', 'grandium' ),
                ),
                'multiple'    => false,
                'std'         => 'Yes'
            ),
            array(
                'name' => esc_html__('Enter URL', 'grandium'),
                'desc' => esc_html__('Insert the url for the image.', 'grandium'),
                'id'   => $prefix . 'the_image_url',
                'type' => 'text',
            )
        )
    );

    /* Audio Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Audio Settings', 'grandium'),
        'pages'    => array('post'),
        'fields' => array(
            array(
            'type' => 'heading',
            'name' => esc_html__( 'These settings enable you to embed audio in your posts. Note that for audio, you must supply both MP3 and OGG files to satisfy all browsers. For poster you can select a featured image.', 'grandium' ),
            'id'   => 'audio_head'
            ),
            array(
                'name' => esc_html__('MP3 File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .mp3 audio file.', 'grandium'),
                'id'   => $prefix . 'audio_mp3',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('OGA File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .oga, .ogg audio file.', 'grandium'),
                'id'   => $prefix . 'audio_ogg',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Divider', 'grandium'),
                'desc' => esc_html__('divider.', 'grandium'),
                'id'   => $prefix . 'audio_divider',
                'type' => 'divider'
            ),
            array(
                'name' => esc_html__('SoundCloud', 'grandium'),
                'desc' => esc_html__('Enter the url of the soundcloud audio.', 'grandium'),
                'id'   => $prefix . 'audio_sc',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Color', 'grandium'),
                'desc' => esc_html__('Choose the color.', 'grandium'),
                'id'   => $prefix . 'audio_sc_color',
                'type' => 'color',
                'std'  => '#ff7700'
            )
        )
    );

    /* Status Post Format */

    $meta_boxes[] = array(
        'title'    => esc_html__('Status Settings', 'grandium'),
        'pages'    => array('post'),
        'fields' => array(
            array(
                'name' => esc_html__('Style', 'grandium'),
                'desc' => esc_html__('Select status style.', 'grandium'),
                'id'   => $prefix . 'status_style',
                'type' => 'select',
                'options'  => array(
                    'value1' => esc_html__( 'Normal', 'grandium' ),
                    'value2' => esc_html__( 'Background', 'grandium' ),
                ),
                'multiple'    => false,
                'std'         => 'Static'
            ),
            array(
                'name' => esc_html__('Background Color', 'grandium'),
                'desc' => esc_html__('Choose the background color for this status.', 'grandium'),
                'id'   => $prefix . 'status_bg',
                'type' => 'color',
                'std'  => '#d5d85f'
            ),
            array(
                'name' => esc_html__('Background Opacity', 'grandium'),
                'desc' => esc_html__('Choose the opacity of the background color.', 'grandium'),
                'id'   => $prefix . 'status_bg_opacity',
                'type' => 'text',
                'std' => 80
            )
        )
    );

    /* Video Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Video Settings', 'grandium'),
        'pages'    => array('post'),
        'fields' => array(
            array(
            'type' => 'heading',
            'name' => esc_html__( 'These settings enable you to embed videos into your posts. Note that for video, you must supply an M4V file to satisfy both HTML5 and Flash solutions. The optional OGV format is used to increase x-browser support for HTML5 browsers such as Firefox and Opera. For the poster, you can select a featured image.', 'grandium' ),
            'id'   => 'video_head'
            ),
            array(
                'name' => esc_html__('M4V File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .m4v video file.', 'grandium'),
                'id'   => $prefix . 'video_m4v',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('OGV File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .ogv video file.', 'grandium'),
                'id'   => $prefix . 'video_ogv',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('WEBM File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .webm video file.', 'grandium'),
                'id'   => $prefix . 'video_webm',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Embeded Code', 'grandium'),
                'desc' => esc_html__('Select the preview image for this video.', 'grandium'),
                'id'   => $prefix . 'video_embed',
                'type' => 'textarea',
                'rows' => 8
            )
        )
    );


/*-----------------------------------------------------------------------------------*/
/*  Metaboxes for portfolio
/*-----------------------------------------------------------------------------------*/

    /* Gallery Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Gallery Settings', 'grandium'),
        'pages'    => array('portfolio'),
        'fields' => array(
            array(
                'name' => esc_html__('Gallery Style', 'grandium'),
                'desc' => esc_html__('Select the gallery style.', 'grandium'),
                'id'   => $prefix . 'gallery_style',
                'type' => 'select',
                'options'  => array(
                    'value1' => esc_html__( 'Slider', 'grandium' ),
                    'value2' => esc_html__( 'Grid', 'grandium' ),
                ),
                'std'         => 'value1'
            ),
            array(
                'name' => esc_html__('Select Images', 'grandium'),
                'desc' => esc_html__('Select the images from the media library or upload your new ones.', 'grandium'),
                'id'   => $prefix . 'gallery_image',
                'type' => 'image_advanced',
            )
        )
    );

    /* Audio Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Audio Settings', 'grandium'),
        'pages'    => array('portfolio'),
        'fields' => array(
            array(
            'type' => 'heading',
            'name' => esc_html__( 'These settings enable you to embed audio in your posts. Note that for audio, you must supply both MP3 and OGG files to satisfy all browsers. For poster you can select a featured image.', 'grandium' ),
            'id'   => 'audio_head'
            ),
            array(
                'name' => esc_html__('MP3 File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .mp3 audio file.', 'grandium'),
                'id'   => $prefix . 'audio_mp3',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('OGA File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .oga, .ogg audio file.', 'grandium'),
                'id'   => $prefix . 'audio_ogg',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Divider', 'grandium'),
                'desc' => esc_html__('divider.', 'grandium'),
                'id'   => $prefix . 'audio_divider',
                'type' => 'divider'
            ),
            array(
                'name' => esc_html__('SoundCloud', 'grandium'),
                'desc' => esc_html__('Enter the url of the soundcloud audio.', 'grandium'),
                'id'   => $prefix . 'audio_sc',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Color', 'grandium'),
                'desc' => esc_html__('Choose the color.', 'grandium'),
                'id'   => $prefix . 'audio_sc_color',
                'type' => 'color',
                'std'  => '#ff7700'
            )
        )
    );



    /* Video Post Format ------------*/

    $meta_boxes[] = array(
        'title'    => esc_html__('Video Settings', 'grandium'),
        'pages'    => array('portfolio'),
        'fields' => array(
            array(
            'type' => 'heading',
            'name' => esc_html__( 'These settings enable you to embed videos into your posts. Note that for video, you must supply an M4V file to satisfy both HTML5 and Flash solutions. The optional OGV format is used to increase x-browser support for HTML5 browsers such as Firefox and Opera. For the poster, you can select a featured image.', 'grandium' ),
            'id'   => 'video_head'
            ),
            array(
                'name' => esc_html__('M4V File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .m4v video file.', 'grandium'),
                'id'   => $prefix . 'video_m4v',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('OGV File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .ogv video file.', 'grandium'),
                'id'   => $prefix . 'video_ogv',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('WEBM File URL', 'grandium'),
                'desc' => esc_html__('The URL to the .webm video file.', 'grandium'),
                'id'   => $prefix . 'video_webm',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__('Embeded Code', 'grandium'),
                'desc' => esc_html__('Select the preview image for this video.', 'grandium'),
                'id'   => $prefix . 'video_embed',
                'type' => 'textarea',
                'rows' => 8
            )
        )
    );

  //end
 return $meta_boxes;
}



function grandium_admin_scripts() {
    wp_register_script('grandium_custom_admin', 	get_template_directory_uri() . '/js/theme-defaults/jquery.custom.admin.js');
    wp_enqueue_script('grandium_custom_admin');
}

function grandium_admin_styles() {
    wp_register_style('grandium_options_css', 		get_template_directory_uri() . '/css/admin-style/admin-style.css');
    wp_register_style('grandium_options_grey_css', 	get_template_directory_uri() . '/css/admin-style/admin-style-grey.css');
    wp_enqueue_style('grandium_options_css');
    wp_enqueue_style('grandium_options_grey_css');
}

add_action('admin_print_scripts', 'grandium_admin_scripts');
add_action('admin_print_styles', 'grandium_admin_styles');

?>
