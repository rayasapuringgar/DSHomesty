<?php

$attributes = array(
	array(
		'type' 			=> 'dropdown',
		'heading' 			=> esc_html__( 'Container Layout', 'grandium' ),
		'param_name' 		=> 'grandium_select_container',
		'value' 			=> array(
			esc_html__( 'Select Style', 'grandium' ) 			=> 'select-style',
			esc_html__( 'Centered Content', 'grandium' ) 		=> 'topandbottom',
		),
		'description' 		=> esc_html__( 'Select predefined list design ', 'grandium' ),
		'group' 			=> 'Container Type',
	),
);
vc_add_params( 'vc_row', $attributes );

/*-----------------------------------------------------------------------------------*/
/*	Filter to replace default css class names for vc_row shortcode and vc_column
/*-----------------------------------------------------------------------------------*/

add_filter( 'vc_shortcodes_css_class', 'grandium_custom_css_vc', 10, 2 );
function grandium_custom_css_vc( $class_string, $tag ) {
  if (  $tag == 'vc_row' ) {
    $class_string = str_replace( 'vc_rows', 'remove_vc_row', $class_string );
  }
  return $class_string;
}

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Filter
/*-----------------------------------------------------------------------------------*/

vc_set_as_theme( $disable_updater = false );
vc_is_updater_disabled();



/*-----------------------------------------------------------------------------------*/
/*	SLIDER
/*-----------------------------------------------------------------------------------*/

add_action( 'vc_before_init', 'grandium_slider_integrateWithVC' );
function grandium_slider_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Home Slider", "grandium" ),
		"base" 	 => "grandium_slider",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(

		array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),

		array(
            'type'        => 'textarea',
            'heading'     => esc_html__('Form Heading', 'grandium' ),
            'param_name'  => 'formheading',
            "description" => esc_html__("Add your form heading", "grandium"),
			'group' => esc_html__('Slider Form', 'grandium' ),
        ),
		array(
            'type'        => 'textarea_html',
            'heading'     => esc_html__('Bottom form area', 'grandium' ),
            'param_name'  => 'content',
            "description" => esc_html__("Add your form or any content", "grandium"),
			'group' => esc_html__('Slider Form', 'grandium' ),
        ),
		// slider settings
		array(
			'type' => 'checkbox',
			'param_name' => 'autoplay',
			'heading' => esc_html__('Auto play?', 'grandium'),
			'value' => array( esc_html__('Yes', 'grandium') => 'yes' ),
			'edit_field_class' => 'vc_col-sm-4 pt15'
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Time out', 'grandium'),
			'param_name'    =>'timeout',
			'value'    		=>'5000',
			'description'   => esc_html__('Autoplay interval timeout.Default 5000 ( 5s )', 'grandium'),
			'edit_field_class' => 'vc_col-sm-4'
	 	),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Speed', 'grandium'),
			'param_name'    =>'speed',
			'value'    		=>'250',
			'description'   => esc_html__('Slider speed.Default 250', 'grandium'),
			'edit_field_class' => 'vc_col-sm-4'
	 	),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Slider Min Height', 'grandium'),
			'param_name'    =>'minh',
			'value'    		=>'',
			'description'   => esc_html__('Set your custom slider min height.Use number in ( vh ) or ( px ). Default height is 100vh.', 'grandium')
	 	),
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Slider items', 'grandium' ),
			'param_name'  => 'slider_item',
			'group' => esc_html__('Slider items', 'grandium' ),
			'params' => array(

				array(
					"type" 			=> "attach_image",
					"heading" 		=> esc_html__("Section product centered image", "grandium"),
					"param_name" 	=> "bg_img",
					"description" 	=> esc_html__("Add your image", "grandium"),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Slider first heading", "grandium"),
					"param_name" 	=> "item_heading_1",
					"description" 	=> esc_html__("Add your item heading", "grandium")
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Slider second heading", "grandium"),
					"param_name" 	=> "item_heading_2",
					"description" 	=> esc_html__("Add your item heading", "grandium")
				),

				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Slider third heading", "grandium"),
					"param_name" 	=> "item_heading_3",
					"description" 	=> esc_html__("Add your item heading", "grandium")
				),

			)
		),
		array(
			'type'			=> 'colorpicker',
			'heading'		=> esc_html__('Overlay Color', 'grandium'),
			'param_name'	=> 'overlaybg',
			'description'	=> esc_html__('Add color.', 'grandium'),
			'group' 		=> esc_html__('Overlay 1','grandium'),
		),
    array(
        'type'        => 'css_editor',
        'heading'     => esc_html__('Css', 'grandium' ),
        'param_name'  => 'css',
        'group' => esc_html__('Background options', 'grandium' ),
    ),
		//subtitle style
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title 1 font-size', 'grandium'),
			'param_name'    =>'tosize',
			'description'   => esc_html__('Title 1 fontsize.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title 1 line-height', 'grandium'),
			'param_name'    => 'tolineh',
			'description'   => esc_html__('Change title 1 line-height.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'colorpicker',
			'heading'       => esc_html__('title 1 color', 'grandium'),
			'param_name'    => 'tocolor',
			'description'   => esc_html__('Change title 1 color.', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title 2 font-size', 'grandium'),
			'param_name'    =>'twsize',
			'description'   => esc_html__('Title 2 fontsize.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title 2 line-height', 'grandium'),
			'param_name'    => 'twlineh',
			'description'   => esc_html__('Change title 2 line-height.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'colorpicker',
			'heading'       => esc_html__('title 2 color', 'grandium'),
			'param_name'    => 'twcolor',
			'description'   => esc_html__('Change title 2 color.', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title 3 font-size', 'grandium'),
			'param_name'    =>'ttsize',
			'description'   => esc_html__('Title 3 fontsize.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title 3 line-height', 'grandium'),
			'param_name'    => 'ttlineh',
			'description'   => esc_html__('Change title 3 line-height.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'colorpicker',
			'heading'       => esc_html__('Title 3 color', 'grandium'),
			'param_name'    => 'ttcolor',
			'description'   => esc_html__('Change title 3 color.', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
		),
  ),
) );
}
class WPBakeryShortCode_grandium_slider extends WPBakeryShortCode {
}


/*-----------------------------------------------------------------------------------*/
/*	ROOM CAROUSEL
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_rooms_carousel_integrateWithVC' );
function grandium_rooms_carousel_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Rooms Carousel", "grandium" ),
		"base" 	 => "grandium_rooms_carousel",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(

			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),

			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Select heading visibility', 'grandium' ),
				'param_name'  => 'heading_visiblity',
				'description' => esc_html__('You can hide/show this section heading area.', 'grandium' ),
				'value'       => array(
					esc_html__('Select a option', 		'grandium' )		=> '2',
					esc_html__('Show', 					'grandium' )		=> '1',
					esc_html__('Hide', 					'grandium' )		=> '2',
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Label', 'grandium' ),
				'param_name'  => 'label',
				"description" => esc_html__("Add Your heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Heading', 'grandium' ),
				'param_name'  => 'heading',
				"description" => esc_html__("Add Your heading", "grandium")
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__('Description', 'grandium' ),
				'param_name'  => 'description',
				"description" => esc_html__("Add Your heading", "grandium")
			),
			array(
				'type' => 'loop',
				'heading' => esc_html__('Rooms CPT', 'grandium'),
				'param_name' => 'build_query',
				'settings' => array(
					'size' => array('hidden' => true, 'value' => 4 * 4),
					'order_by' => array('value' => 'date'),
					'post_type' => array('value' => 'rooms', 'hidden' => ''),
				),
				'description' => esc_html__('Create WordPress loop, to populate content from your site.', 'grandium'),
				"group" 	  => esc_html__("Default", "grandium")
			),
			// slider settings
			array(
				'type' => 'checkbox',
				'param_name' => 'autoplay',
				'heading' => esc_html__('Auto play?', 'grandium'),
				'value' => array( esc_html__('Yes', 'grandium') => 'yes' ),
				'group' => esc_html__('Slider Settings', 'grandium' ),
				'edit_field_class' => 'vc_col-sm-4 pt15'
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Time out', 'grandium'),
				'param_name'    =>'timeout',
				'value'    		=>'5000',
				'description'   => esc_html__('Autoplay interval timeout.Default 5000 ( 5s )', 'grandium'),
				'group' => esc_html__('Slider Settings', 'grandium' ),
				'edit_field_class' => 'vc_col-sm-4'
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Speed', 'grandium'),
				'param_name'    =>'speed',
				'value'    		=>'250',
				'description'   => esc_html__('Slider speed.Default 250', 'grandium'),
				'group' => esc_html__('Slider Settings', 'grandium' ),
				'edit_field_class' => 'vc_col-sm-4'
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Large device items count', 'grandium'),
				'param_name'    =>'lgitems',
				'value'    		=>'4',
				'description'   => esc_html__('Set count slides for the large device', 'grandium'),
				'group' => esc_html__('Slider Settings', 'grandium' ),
				'edit_field_class' => 'vc_col-sm-4'
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Medium device items count', 'grandium'),
				'param_name'    =>'mditems',
				'value'    		=>'3',
				'description'   => esc_html__('Set count slides for the medium device', 'grandium'),
				'group' => esc_html__('Slider Settings', 'grandium' ),
				'edit_field_class' => 'vc_col-sm-4'
			),
			array(
				'type'        => 'css_editor',
				'heading'     => esc_html__('Css', 'grandium' ),
				'param_name'  => 'css',
				'group' => esc_html__('Background options', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title font-size', 'grandium'),
				'param_name'    =>'tsize',
				'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title line-height', 'grandium'),
				'param_name'    => 'tlineh',
				'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Title color', 'grandium'),
				'param_name'    => 'tcolor',
				'description'   => esc_html__('Change Title color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description font-size', 'grandium'),
				'param_name'    =>'dsize',
				'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description line-height', 'grandium'),
				'param_name'    => 'dlineh',
				'description'   => esc_html__('Change description line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Description color', 'grandium'),
				'param_name'    => 'dcolor',
				'description'   => esc_html__('Change description color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Price font-size', 'grandium'),
				'param_name'    =>'psize',
				'description'   => esc_html__('Price fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Price line-height', 'grandium'),
				'param_name'    => 'plineh',
				'description'   => esc_html__('Change Price line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Price color', 'grandium'),
				'param_name'    => 'pcolor',
				'description'   => esc_html__('Change Price color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
		),
   ) );
}
class WPBakeryShortCode_grandium_rooms_carousel extends WPBakeryShortCode {
}

/*-----------------------------------------------------------------------------------*/
/*	ROOM CAROUSEL loop
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_rooms_carouseltwo_integrateWithVC' );
function grandium_rooms_carouseltwo_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Rooms Carousel (Loop)", "grandium" ),
		"base" 	 => "grandium_rooms_carouseltwo",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(

			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),

			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__('Select heading visibility', 'grandium' ),
				'param_name'  => 'heading_visiblity',
				'description' => esc_html__('You can hide/show this section heading area.', 'grandium' ),
				'value'       => array(
					esc_html__('Select a option', 		'grandium' )		=> '2',
					esc_html__('Show', 					'grandium' )		=> '1',
					esc_html__('Hide', 					'grandium' )		=> '2',
				),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Label', 'grandium' ),
				'param_name'  => 'label',
				"description" => esc_html__("Add Your heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Heading', 'grandium' ),
				'param_name'  => 'heading',
				"description" => esc_html__("Add Your heading", "grandium")
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__('Description', 'grandium' ),
				'param_name'  => 'description',
				"description" => esc_html__("Add Your heading", "grandium")
			),

			array(
    		'type'          => 'param_group',
    		'heading'       => esc_html__('Slider items', 'grandium' ),
    		'param_name'    => 'sloop',
				'group'         => esc_html__('Default', 'grandium' ),
    		'params'        => array(
					array(
						'type'        => 'attach_image',
						'heading'     => esc_html__('Image', 'grandium' ),
						'param_name'  => 'image',
						"description" => esc_html__("Add/select an image", "grandium")
					),
					array(
						'type'          => 'textfield',
						'heading'       => esc_html__('Image href', 'grandium'),
						'param_name'    =>'imghref',
						'description'   => esc_html__('please add item image href', 'grandium'),
					),
					array(
						'type'          => 'textfield',
						'heading'       => esc_html__('Title', 'grandium'),
						'param_name'    =>'title',
						'description'   => esc_html__('please add item title', 'grandium'),
					),
					array(
						'type'          => 'textfield',
						'heading'       => esc_html__('Title href', 'grandium'),
						'param_name'    =>'titlehref',
						'description'   => esc_html__('please add item title href', 'grandium'),
					),
					array(
						'type'          => 'textfield',
						'heading'       => esc_html__('Currency', 'grandium'),
						'param_name'    =>'grandium_currency',
						'description'   => esc_html__('please add item currency', 'grandium'),
					),
					array(
						'type'          => 'textfield',
						'heading'       => esc_html__('Price', 'grandium'),
						'param_name'    =>'grandium_price',
						'description'   => esc_html__('please add item currency', 'grandium'),
					),
					array(
						'type'          => 'textarea',
						'heading'       => esc_html__('Description', 'grandium'),
						'param_name'    =>'grandium_desc',
						'description'   => esc_html__('please add item description', 'grandium'),
					),
					array(
						'type'         => 'dropdown',
						'heading'      => esc_html__( 'Star', 'grandium' ),
						'param_name'   => 'grandium_rate',
						'value'        => array(
							esc_html__( 'Select style', 'grandium' ) => '',
							esc_html__( 'Star 1', 'grandium' ) => '1',
							esc_html__( 'Star 2', 'grandium' ) => '2',
							esc_html__( 'Star 3', 'grandium' ) => '3',
							esc_html__( 'Star 4', 'grandium' ) => '4',
							esc_html__( 'Star 5', 'grandium' ) => '5',
						),
					),
				),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__('Css', 'grandium' ),
					'param_name'  => 'css',
					'group' => esc_html__('Background options', 'grandium' ),
				),
			//title style
			array(
        'type'         => 'textfield',
        'heading'      => esc_html__('Image width', 'grandium'),
        'param_name'   => 'imgw',
        'description'  => esc_html__('please add image width', 'grandium'),
        'group'        => esc_html__('Custom Style', 'grandium' ),
      ),
      array(
        'type'         => 'textfield',
        'heading'      => esc_html__('Image height', 'grandium'),
        'param_name'   => 'imgh',
        'description'  => esc_html__('please add image height', 'grandium'),
        'group'        => esc_html__('Custom Style', 'grandium' ),
      ),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title font-size', 'grandium'),
				'param_name'    =>'tsize',
				'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title line-height', 'grandium'),
				'param_name'    => 'tlineh',
				'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Title color', 'grandium'),
				'param_name'    => 'tcolor',
				'description'   => esc_html__('Change Title color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description font-size', 'grandium'),
				'param_name'    =>'dsize',
				'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description line-height', 'grandium'),
				'param_name'    => 'dlineh',
				'description'   => esc_html__('Change description line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Description color', 'grandium'),
				'param_name'    => 'dcolor',
				'description'   => esc_html__('Change description color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Price font-size', 'grandium'),
				'param_name'    =>'psize',
				'description'   => esc_html__('Price fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Price line-height', 'grandium'),
				'param_name'    => 'plineh',
				'description'   => esc_html__('Change Price line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Price color', 'grandium'),
				'param_name'    => 'pcolor',
				'description'   => esc_html__('Change Price color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
		),
   ) );
}
class WPBakeryShortCode_grandium_rooms_carouseltwo extends WPBakeryShortCode {
}



/*-----------------------------------------------------------------------------------*/
/*	ROOM CAROUSEL
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_rooms_integrateWithVC' );
function grandium_rooms_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Rooms", "grandium" ),
		"base" 	 => "grandium_rooms",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(

			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Read more text', 'grandium' ),
				'param_name'  => 'read',
				"description" => esc_html__("Add your read more text or leave blank", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Rooms post excerpt size', 'grandium' ),
				'param_name'  => 'excerpt_size',
				"description" => esc_html__("Default value 141. ", "grandium")
			),
			array(
				'type' => 'loop',
				'heading' => esc_html__('Rooms CPT', 'grandium'),
				'param_name' => 'build_query',
				'settings' => array(
					'size' => array('hidden' => false, 'value' => 4 * 4),
					'order_by' => array('value' => 'date'),
					'post_type' => array('value' => 'rooms', 'hidden' => ''),
				),
				'description' => esc_html__('Create WordPress loop, to populate content from your site.', 'grandium'),
				"group" 	  => esc_html__("Query", "grandium")
			),
			array(
				'type'        => 'css_editor',
				'heading'     => esc_html__('Css', 'grandium' ),
				'param_name'  => 'css',
				'group' => esc_html__('Background options', 'grandium' ),
			),

		),
   ) );
}
class WPBakeryShortCode_grandium_rooms extends WPBakeryShortCode {}


/*-----------------------------------------------------------------------------------*/
/*	ABOUT
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_about_integrateWithVC' );
function grandium_about_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "About", "grandium" ),
		"base" 	 => "grandium_about",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('label', 'grandium' ),
				'param_name'  => 'label',
				"description" => esc_html__("Add Your label", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('heading', 'grandium' ),
				'param_name'  => 'heading',
				"description" => esc_html__("Add Your heading", "grandium")
			),
			array(
				'type'        => 'attach_image',
				'heading'     => esc_html__('Background image', 'grandium' ),
				'param_name'  => 'bg_img',
				"description" => esc_html__("Add/select an image", "grandium")
			),
         array(
            'type'        => 'dropdown',
            'heading'     => esc_html__('Background overlay', 'grandium' ),
            'param_name'  => 'overlaybg',
            'description' => esc_html__('You can hide/show this section overlay', 'grandium' ),
            'value'       => array(
               esc_html__('Select a option', 		'grandium' )		=> '',
               esc_html__('Show', 					'grandium' )		=> 'on',
               esc_html__('Hide', 					'grandium' )		=> 'off',
            ),
         ),
			array(
				'type'        => 'textarea_html',
				'heading'     => esc_html__('Description', 'grandium' ),
				'param_name'  => 'content',
				"description" => esc_html__("Add Your heading", "grandium")
			),
			array(
				'type'        => 'vc_link',
				'heading'     => esc_html__('Button (Link)', 'grandium' ),
				'param_name'  => 'link',
				'description' => esc_html__('Add custom link.', 'grandium' ),
			),
			array(
				'type'        => 'css_editor',
				'heading'     => esc_html__('Css', 'grandium' ),
				'param_name'  => 'css',
				'group' => esc_html__('Background options', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title font-size', 'grandium'),
				'param_name'    =>'tsize',
				'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title line-height', 'grandium'),
				'param_name'    => 'tlineh',
				'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Title color', 'grandium'),
				'param_name'    => 'tcolor',
				'description'   => esc_html__('Change Title color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('SubTitle font-size', 'grandium'),
				'param_name'    =>'ssize',
				'description'   => esc_html__('SubTitle fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'textfield',
				'heading'       => esc_html__('SubTitle line-height', 'grandium'),
				'param_name'    => 'slineh',
				'description'   => esc_html__('Change SubTitle line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('SubTitle color', 'grandium'),
				'param_name'    => 'scolor',
				'description'   => esc_html__('Change SubTitle color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
		),
   ) );
} class WPBakeryShortCode_grandium_about extends WPBakeryShortCode {}


/*-----------------------------------------------------------------------------------*/
/*	ABOUT GRID
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_about_two_integrateWithVC' );
function grandium_about_two_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "About Grid", "grandium" ),
		"base" 	 => "grandium_about_two",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
		array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('About grid items', 'grandium' ),
			'param_name'  => 'about_two_item',
			'group' => esc_html__('About items', 'grandium' ),
			'params' => array(

				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('item label', 'grandium' ),
					'param_name'  => 'label',
					"description" => esc_html__("Add a label", "grandium")
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Item heading ", "grandium"),
					"param_name" => "heading",
					"description" => esc_html__("Add your item heading", "grandium"),
				),
				array(
					"type" 			=> "textarea",
					"heading" 		=> esc_html__("Your item description", "grandium"),
					"param_name" 	=> "desc",
					"description" 	=> esc_html__("Add item description", "grandium")
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__('Item URL (Link)', 'grandium' ),
					'param_name'  => 'link',
					'description' => esc_html__('Add custom link.', 'grandium' ),
				),
			)
		),
		array(
			'type'        => 'css_editor',
			'heading'     => esc_html__('Css', 'grandium' ),
			'param_name'  => 'css',
			'group' => esc_html__('Background options', 'grandium' ),
		),
		//title style
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title font-size', 'grandium'),
			'param_name'    =>'tsize',
			'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Title line-height', 'grandium'),
			'param_name'    => 'tlineh',
			'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'colorpicker',
			'heading'       => esc_html__('Title color', 'grandium'),
			'param_name'    => 'tcolor',
			'description'   => esc_html__('Change Title color.', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
		),
		//title style
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('SubTitle font-size', 'grandium'),
			'param_name'    =>'ssize',
			'description'   => esc_html__('SubTitle fontsize.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'textfield',
			'heading'       => esc_html__('SubTitle line-height', 'grandium'),
			'param_name'    => 'slineh',
			'description'   => esc_html__('Change SubTitle line-height.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'colorpicker',
			'heading'       => esc_html__('SubTitle color', 'grandium'),
			'param_name'    => 'scolor',
			'description'   => esc_html__('Change SubTitle color.', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
		),
		//description style
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Description font-size', 'grandium'),
			'param_name'    =>'dsize',
			'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Description line-height', 'grandium'),
			'param_name'    => 'dlineh',
			'description'   => esc_html__('Change Description line-height.use number in ( px or unit )', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
	 ),
	 array(
			'type'          => 'colorpicker',
			'heading'       => esc_html__('Description color', 'grandium'),
			'param_name'    => 'dcolor',
			'description'   => esc_html__('Change Description color.', 'grandium'),
			'group'         => esc_html__('Custom Style', 'grandium' ),
		),
  ),
) );
} class WPBakeryShortCode_grandium_about_two extends WPBakeryShortCode {}

/*-----------------------------------------------------------------------------------*/
/*	FEATURES LEFT RIGHT
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_features_two_integrateWithVC' );
function grandium_features_two_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Features Grid", "grandium" ),
		"base" 	 => "grandium_features_two",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
		array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Label', 'grandium' ),
			'param_name'  => 'label',
			"description" => esc_html__("Add Your heading", "grandium")
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Heading', 'grandium' ),
			'param_name'  => 'heading',
			"description" => esc_html__("Add Your heading", "grandium")
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Item column', 'grandium' ),
			'param_name'  => 'column',
			"description" => esc_html__("Add bootstrap classes, default : col-lg-4 col-sm-6 ", "grandium")
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__('Description', 'grandium' ),
			'param_name'  => 'description',
			"description" => esc_html__("Add Your heading", "grandium")
		),
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Features grid items', 'grandium' ),
			'param_name'  => 'features_two_left_item',
			'group' => esc_html__('Features items', 'grandium' ),
			'params' => array(

				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__('item image', 'grandium' ),
					'param_name'  => 'item_image',
					"description" => esc_html__("Add/select an image", "grandium")
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Item heading ", "grandium"),
					"param_name" => "item_left_heading",
					"description" => esc_html__("Add your item heading", "grandium"),
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Item description", "grandium"),
					"param_name" => "item_left_desc",
					"description" => esc_html__("Add your item description", "grandium"),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__('Item URL (Link)', 'grandium' ),
					'param_name'  => 'link',
					'description' => esc_html__('Add custom link.', 'grandium' ),
				),
			)
		),
		array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group' => esc_html__('Background options', 'grandium' ),
        ),
				//title style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Title font-size', 'grandium'),
					'param_name'    =>'tsize',
					'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Title line-height', 'grandium'),
					'param_name'    => 'tlineh',
					'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Title color', 'grandium'),
					'param_name'    => 'tcolor',
					'description'   => esc_html__('Change Title color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//subtitle style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle font-size', 'grandium'),
					'param_name'    =>'ssize',
					'description'   => esc_html__('SubTitle fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle line-height', 'grandium'),
					'param_name'    => 'slineh',
					'description'   => esc_html__('Change SubTitle line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('SubTitle color', 'grandium'),
					'param_name'    => 'scolor',
					'description'   => esc_html__('Change SubTitle color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//description style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description font-size', 'grandium'),
					'param_name'    =>'dsize',
					'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description line-height', 'grandium'),
					'param_name'    => 'dlineh',
					'description'   => esc_html__('Change Description line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Description color', 'grandium'),
					'param_name'    => 'dcolor',
					'description'   => esc_html__('Change Description color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
      ),
   ) );
} class WPBakeryShortCode_grandium_features_two extends WPBakeryShortCode {}



/*-----------------------------------------------------------------------------------*/
/*	THE WATCH
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_gallery_integrateWithVC' );
function grandium_gallery_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Big Caruosel Gallery", "grandium" ),
		"base" 	 => "grandium_gallery",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Label first text', 'grandium' ),
				'param_name'  => 'label',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Heading first text', 'grandium' ),
				'param_name'  => 'heading',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Description', 'grandium' ),
				'param_name'  => 'description',
				"description" => esc_html__("Add any content - html code.", "grandium")
			),
			array(
				'type'        => 'param_group',
				'heading'     => esc_html__('Gallery items', 'grandium' ),
				'param_name'  => 'gallery_items',
				'group' => esc_html__('Gallery items', 'grandium' ),
				'params' => array(

					array(
						"type" => "textfield",
						"heading" => esc_html__("Item heading ", "grandium"),
						"param_name" => "item_heading",
						"description" => esc_html__("Add your item heading", "grandium"),
					),
					array(
						"type" => "attach_image",
						"heading" => esc_html__("Item image", "grandium"),
						"param_name" => "item_image",
						"description" => esc_html__("Add your image", "grandium"),
					),

				)
			),
			array(
				'type'        => 'css_editor',
				'heading'     => esc_html__('Css', 'grandium' ),
				'param_name'  => 'css',
				'group' => esc_html__('Background options', 'grandium' ),
			),

		),
   ) );
}
class WPBakeryShortCode_grandium_gallery extends WPBakeryShortCode {
}


/*-----------------------------------------------------------------------------------*/
/*	SPLIT grandium
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_video_integrateWithVC' );
function grandium_video_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Video Section", "grandium" ),
		"base" 	 => "grandium_video",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(

			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Label first text', 'grandium' ),
				'param_name'  => 'label',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Heading first text', 'grandium' ),
				'param_name'  => 'heading',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Description', 'grandium' ),
				'param_name'  => 'description',
				"description" => esc_html__("Add any content - html code.", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Popup video url', 'grandium' ),
				'param_name'  => 'video_url',
				"description" => esc_html__("Example : https://vimeo.com/39493181", "grandium")
			),
			array(
				"type" => "attach_image",
				"heading" => esc_html__("Section background image", "grandium"),
				"param_name" => "bg_image",
				"description" => esc_html__("Add image", "grandium"),
			),
			array(
				'type'        => 'css_editor',
				'heading'     => esc_html__('Css', 'grandium' ),
				'param_name'  => 'css',
				'group' => esc_html__('Background options', 'grandium' ),
			),
		),
   ) );
}
class WPBakeryShortCode_grandium_video extends WPBakeryShortCode {
}



/*-----------------------------------------------------------------------------------*/
/*	OFFERS
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_offers_integrateWithVC' );
function grandium_offers_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Offers", "grandium" ),
		"base" 	 => "grandium_offers",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(

			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),
			array(
				"type" 			=> "attach_image",
				"heading" 		=> esc_html__("Section background image", "grandium"),
				"param_name" 	=> "gbg_image",
				"description" 	=> esc_html__("Add image", "grandium"),
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Label first text', 'grandium' ),
				'param_name'  => 'label',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Heading first text', 'grandium' ),
				'param_name'  => 'heading',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__('Description', 'grandium' ),
				'param_name'  => 'description',
				"description" => esc_html__("Add any content - html code.", "grandium")
			),
			array(
				'type'        	=> 'param_group',
				'heading'     	=> esc_html__('Offer item', 'grandium' ),
				'param_name'  	=> 'offer_items',
				'group' 		=> esc_html__('Offer items', 'grandium' ),
				'params' 		=> array(

					array(
						"type" 			=> "textfield",
						"heading" 		=> esc_html__("Item heading ", "grandium"),
						"param_name" 	=> "item_heading",
						"description" 	=> esc_html__("Add your item heading", "grandium"),
					),
					array(
						"type" 			=> "textarea",
						"heading" 		=> esc_html__("Item description", "grandium"),
						"param_name" 	=> "item_desc",
						"description" 	=> esc_html__("Add your item description", "grandium"),
					),
					array(
						"type" 			=> "attach_image",
						"heading" 		=> esc_html__("Item image", "grandium"),
						"param_name" 	=> "item_image",
						"description" 	=> esc_html__("Add your Item image", "grandium"),
					),
					array(
						'type'        => 'vc_link',
						'heading'     => esc_html__('Button uRL (Link)', 'grandium' ),
						'param_name'  => 'link',
						'description' => esc_html__('Button', 'grandium' ),
					),
				)
			),
			array(
				'type'        => 'css_editor',
				'heading'     => esc_html__('Css', 'grandium' ),
				'param_name'  => 'css',
				'group' => esc_html__('Background options', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title font-size', 'grandium'),
				'param_name'    =>'tsize',
				'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title line-height', 'grandium'),
				'param_name'    => 'tlineh',
				'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Title color', 'grandium'),
				'param_name'    => 'tcolor',
				'description'   => esc_html__('Change Title color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//subtitle style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('SubTitle font-size', 'grandium'),
				'param_name'    =>'ssize',
				'description'   => esc_html__('SubTitle fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'textfield',
				'heading'       => esc_html__('SubTitle line-height', 'grandium'),
				'param_name'    => 'slineh',
				'description'   => esc_html__('Change SubTitle line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('SubTitle color', 'grandium'),
				'param_name'    => 'scolor',
				'description'   => esc_html__('Change SubTitle color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//description style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description font-size', 'grandium'),
				'param_name'    =>'dsize',
				'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description line-height', 'grandium'),
				'param_name'    => 'dlineh',
				'description'   => esc_html__('Change Description line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Description color', 'grandium'),
				'param_name'    => 'dcolor',
				'description'   => esc_html__('Change Description color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//description style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description offers font-size', 'grandium'),
				'param_name'    =>'dwsize',
				'description'   => esc_html__('Description offers fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Description offers line-height', 'grandium'),
				'param_name'    => 'dwlineh',
				'description'   => esc_html__('Change Description offers line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Description offers color', 'grandium'),
				'param_name'    => 'dwcolor',
				'description'   => esc_html__('Change Description offers color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
			//title style
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title offers font-size', 'grandium'),
				'param_name'    =>'twsize',
				'description'   => esc_html__('Title offers fontsize.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Title offers line-height', 'grandium'),
				'param_name'    => 'twlineh',
				'description'   => esc_html__('Change Title offers line-height.use number in ( px or unit )', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
		 ),
		 array(
				'type'          => 'colorpicker',
				'heading'       => esc_html__('Title offers color', 'grandium'),
				'param_name'    => 'twcolor',
				'description'   => esc_html__('Change Title offers color.', 'grandium'),
				'group'         => esc_html__('Custom Style', 'grandium' ),
			),
		),
   ) );
}
class WPBakeryShortCode_grandium_offers extends WPBakeryShortCode {
}


/*-----------------------------------------------------------------------------------*/
/*	BLOG
/*-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'grandium_blog_integrateWithVC' );
function grandium_blog_integrateWithVC() {
    vc_map( array(
	"name" 	 => esc_html__( "Blog posts", "grandium" ),
	"base" 	 => "grandium_blog",
	"category" => esc_html__( "Grandium", "grandium"),
	"params"   => array(
		array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
        array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Label first text', 'grandium' ),
			'param_name'  => 'label',
			"description" => esc_html__("Add your first heading", "grandium")
		),
        array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Read more text', 'grandium' ),
			'param_name'  => 'read',
			"description" => esc_html__("Add your read more text or leave blank", "grandium")
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__('Heading first text', 'grandium' ),
			'param_name'  => 'heading',
			"description" => esc_html__("Add your first heading", "grandium")
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__('Description', 'grandium' ),
			'param_name'  => 'description',
			"description" => esc_html__("Add any content - html code.", "grandium")
		),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Post Count', 'grandium' ),
            'param_name'  => 'posts',
            "description" => esc_html__("You can control with number your post.", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Category', 'grandium' ),
            'param_name'  => 'categories',
            "description" => esc_html__("Enter post category or write all", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'excerpt size', 'grandium' ),
            'param_name'  => 'excerpt_size',
            "description" => esc_html__("You can control with number your excerpt size of posts", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'order', 'grandium' ),
            'param_name'  => 'order',
            "description" => esc_html__("Enter post order. DESC or ASC", "grandium"),
        ),

        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'orderby', 'grandium' ),
            'param_name'  => 'orderby',
            "description" => esc_html__("Enter post orderby. Default is : date", "grandium"),
        ),
		// slider settings
		array(
			'type' => 'checkbox',
			'param_name' => 'autoplay',
			'heading' => esc_html__('Auto play?', 'grandium'),
			'value' => array( esc_html__('Yes', 'grandium') => 'yes' ),
			'group' => esc_html__('Slider Settings', 'grandium' ),
			'edit_field_class' => 'vc_col-sm-4 pt15'
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Time out', 'grandium'),
			'param_name'    =>'timeout',
			'value'    		=>'5000',
			'description'   => esc_html__('Autoplay interval timeout.Default 5000 ( 5s )', 'grandium'),
			'group' => esc_html__('Slider Settings', 'grandium' ),
			'edit_field_class' => 'vc_col-sm-4'
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Speed', 'grandium'),
			'param_name'    =>'speed',
			'value'    		=>'250',
			'description'   => esc_html__('Slider speed.Default 250', 'grandium'),
			'group' => esc_html__('Slider Settings', 'grandium' ),
			'edit_field_class' => 'vc_col-sm-4'
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Large device items count', 'grandium'),
			'param_name'    =>'lgitems',
			'value'    		=>'4',
			'description'   => esc_html__('Set count slides for the large device', 'grandium'),
			'group' => esc_html__('Slider Settings', 'grandium' ),
			'edit_field_class' => 'vc_col-sm-4'
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Medium device items count', 'grandium'),
			'param_name'    =>'mditems',
			'value'    		=>'3',
			'description'   => esc_html__('Set count slides for the medium device', 'grandium'),
			'group' => esc_html__('Slider Settings', 'grandium' ),
			'edit_field_class' => 'vc_col-sm-4'
		),
		array(
			'type'          => 'textfield',
			'heading'       => esc_html__('Small device items count', 'grandium'),
			'param_name'    =>'smitems',
			'value'    		=>'2',
			'description'   => esc_html__('Set count slides for the small device', 'grandium'),
			'group' => esc_html__('Slider Settings', 'grandium' ),
			'edit_field_class' => 'vc_col-sm-4'
		),

         array(
            'type'        => 'css_editor',
            'heading'     => esc_html__( 'Css', 'grandium' ),
            'param_name'  => 'css',
            'group'       => esc_html__( 'Background options', 'grandium' ),
        ),
      )
   ) );
} class WPBakeryShortCode_grandium_blog extends WPBakeryShortCode {}


/*-----------------------------------------------------------------------------------*/
/*	SPONSOR
/*-----------------------------------------------------------------------------------*/

add_action( 'vc_before_init', 'grandium_testimonials_integrateWithVC' );
function grandium_testimonials_integrateWithVC() {
	vc_map( array(
		"name" 	 => esc_html__( "Testimonials", "grandium" ),
		"base" 	 => "grandium_testimonials",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Section ID', 'grandium' ),
				'param_name'  => 'section_id',
				"description" => esc_html__("Add Your Section ID", "grandium"),
			),
			array(
					'type'        => 'textfield',
				'heading'     => esc_html__('Label first text', 'grandium' ),
				'param_name'  => 'label',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Heading first text', 'grandium' ),
				'param_name'  => 'heading',
				"description" => esc_html__("Add your first heading", "grandium")
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__('Description', 'grandium' ),
				'param_name'  => 'description',
				"description" => esc_html__("Add any content - html code.", "grandium")
			),
			// slider settings
			array(
				'type' => 'checkbox',
				'param_name' => 'autoplay',
				'heading' => esc_html__('Auto play?', 'grandium'),
				'value' => array( esc_html__('Yes', 'grandium') => 'yes' ),
				'edit_field_class' => 'vc_col-sm-4 pt15'
			),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Time out', 'grandium'),
				'param_name'    =>'timeout',
				'value'    		=>'5000',
				'description'   => esc_html__('Autoplay interval timeout.Default 5000 ( 5s )', 'grandium'),
				'edit_field_class' => 'vc_col-sm-4'
		 	),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Speed', 'grandium'),
				'param_name'    =>'speed',
				'value'    		=>'250',
				'description'   => esc_html__('Slider speed.Default 250', 'grandium'),
				'edit_field_class' => 'vc_col-sm-4'
		 	),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Medium device items count', 'grandium'),
				'param_name'    =>'mditems',
				'value'    		=>'3',
				'description'   => esc_html__('Set count slides for the medium device', 'grandium'),
				'edit_field_class' => 'vc_col-sm-4'
		 	),
			array(
				'type'          => 'textfield',
				'heading'       => esc_html__('Small device items count', 'grandium'),
				'param_name'    =>'smitems',
				'value'    		=>'2',
				'description'   => esc_html__('Set count slides for the small device', 'grandium'),
				'edit_field_class' => 'vc_col-sm-4'
		 	),
			// start param_group
			array(
				'type'        => 'param_group',
				'heading'     => esc_html__('Testimonial item', 'grandium' ),
				'param_name'  => 'testi',
				'group' => esc_html__('Items', 'grandium' ),
				'params' => array(

					array(
						"type" => "attach_image",
						"heading" => esc_html__("Testimonial item image", "grandium"),
						"param_name" => "spon_img",
						"description" => esc_html__("Add your item image", "grandium"),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Testimonial item name', 'grandium' ),
						'param_name'  => 'item_heading',
						"description" => esc_html__("name", "grandium"),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Testimonial item description', 'grandium' ),
						'param_name'  => 'item_desc',
						"description" => esc_html__("description", "grandium"),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Testimonial item company name', 'grandium' ),
						'param_name'  => 'item_company',
						"description" => esc_html__("company", "grandium"),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Testimonial logo image width', 'grandium' ),
						'param_name'  => 'i_width',
						"description" => esc_html__("You can add any number for image width or leave blank", "grandium"),
					),

					array(
						'type'        => 'textfield',
						'heading'     => esc_html__('Testimonial logo image height', 'grandium' ),
						'param_name'  => 'i_height',
						"description" => esc_html__("You can add any number for image height or leave blank", "grandium"),
					),

					array(
						'type'        => 'vc_link',
						'heading'     => esc_html__('URL (Link)', 'grandium' ),
						'param_name'  => 'link',
						'description' => esc_html__('Add custom link.', 'grandium' ),
					),
				),
			), // end param_group

			array(
				'type'        => 'css_editor',
				'heading'     => esc_html__('Css', 'grandium' ),
				'param_name'  => 'css',
				'group' => esc_html__('Background options', 'grandium' ),
			),
		)
		)
   );
}
class WPBakeryShortCode_grandium_testimonials extends WPBakeryShortCode {}


/*-----------------------------------------------------------------------------------*/
/*	TEAM grandium
/*-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'grandium_team_integrateWithVC' );
function grandium_team_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Team", "grandium" ),
		"base" 	 => "grandium_team",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
		 array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Heading', 'grandium' ),
            'param_name'  => 'heading',
            "description" => esc_html__("Add your section heading", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Label', 'grandium' ),
            'param_name'  => 'label',
            "description" => esc_html__("Add your section heading", "grandium"),
        ),
		array(
            'type'        => 'textarea',
            'heading'     => esc_html__('Description', 'grandium' ),
            'param_name'  => 'description',
            "description" => esc_html__("Add your description", "grandium"),
        ),

		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Team member', 'grandium' ),
			'param_name'  => 'team_items',
			'group' => esc_html__('Team member', 'grandium' ),
			'params' => array(

				array(
					"type" => "attach_image",
					"heading" => esc_html__("Member item image", "grandium"),
					"param_name" => "team_img",
					"description" => esc_html__("Add your item image", "grandium"),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__('Member item image link', 'grandium' ),
					'param_name'  => 'links',
					'description' => esc_html__('Add custom link or leave blank.', 'grandium' ),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Your team member name", "grandium"),
					"param_name" 	=> "item_heading",
					"description" 	=> esc_html__("Add team member name", "grandium")
				),
				array(
					"type" 			=> "textarea",
					"heading" 		=> esc_html__("Your team member position", "grandium"),
					"param_name" 	=> "item_desc",
					"description" 	=> esc_html__("Add your item position", "grandium")
				),
				// social
				array(
					"type" => "textfield",
					"heading" => esc_html__("Member item social name 1", "grandium"),
					"param_name" => "s_n_1",
					"description" => esc_html__("Add your item name", "grandium"),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Member item social link 1', 'grandium' ),
					'param_name'  => 's_u_1',
					'description' => esc_html__('Add social icon link ', 'grandium' ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Member item social name 2", "grandium"),
					"param_name" => "s_n_2",
					"description" => esc_html__("Add your item name", "grandium"),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Member item social link 2', 'grandium' ),
					'param_name'  => 's_u_2',
					'description' => esc_html__('Add social icon link ', 'grandium' ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Member item social name 3", "grandium"),
					"param_name" => "s_n_3",
					"description" => esc_html__("Add your item name", "grandium"),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Member item social link 3', 'grandium' ),
					'param_name'  => 's_u_3',
					'description' => esc_html__('Add social icon link ', 'grandium' ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Member item social name 4", "grandium"),
					"param_name" => "s_n_4",
					"description" => esc_html__("Add your item name", "grandium"),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Member item social link 4', 'grandium' ),
					'param_name'  => 's_u_4',
					'description' => esc_html__('Add social icon link ', 'grandium' ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Member item social name 5", "grandium"),
					"param_name" => "s_n_5",
					"description" => esc_html__("Add your item name", "grandium"),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Member item social link 5', 'grandium' ),
					'param_name'  => 's_u_5',
					'description' => esc_html__('Add social icon link ', 'grandium' ),
				),
				//title style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Title font-size', 'grandium'),
					'param_name'    =>'tsize',
					'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Title line-height', 'grandium'),
					'param_name'    => 'tlineh',
					'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Title color', 'grandium'),
					'param_name'    => 'tcolor',
					'description'   => esc_html__('Change Title color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//subtitle style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle font-size', 'grandium'),
					'param_name'    =>'ssize',
					'description'   => esc_html__('SubTitle fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle line-height', 'grandium'),
					'param_name'    => 'slineh',
					'description'   => esc_html__('Change SubTitle line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('SubTitle color', 'grandium'),
					'param_name'    => 'scolor',
					'description'   => esc_html__('Change SubTitle color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//description style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description font-size', 'grandium'),
					'param_name'    =>'dsize',
					'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description line-height', 'grandium'),
					'param_name'    => 'dlineh',
					'description'   => esc_html__('Change Description line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Description color', 'grandium'),
					'param_name'    => 'dcolor',
					'description'   => esc_html__('Change Description color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),

				//subtitle style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Team heading font-size', 'grandium'),
					'param_name'    =>'stsize',
					'description'   => esc_html__('Team heading fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Team heading line-height', 'grandium'),
					'param_name'    => 'stlineh',
					'description'   => esc_html__('Change Team heading line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Team heading color', 'grandium'),
					'param_name'    => 'stcolor',
					'description'   => esc_html__('Change Team heading color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//title style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Team description font-size', 'grandium'),
					'param_name'    =>'ttsize',
					'description'   => esc_html__('Team description fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Team description line-height', 'grandium'),
					'param_name'    => 'ttlineh',
					'description'   => esc_html__('Change Team description line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Team description color', 'grandium'),
					'param_name'    => 'ttcolor',
					'description'   => esc_html__('Change Team description color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
			)
		),
		// param_group end

        array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group' 	  => esc_html__('Background options', 'grandium' ),
        ),
      ),
   ) );
}
class WPBakeryShortCode_grandium_team extends WPBakeryShortCode {
}


/*-----------------------------------------------------------------------------------*/
/*	FEATURES
/*-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'grandium_features_integrateWithVC' );
function grandium_features_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Features", "grandium" ),
		"base" 	 => "grandium_features",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
		 array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Label', 'grandium' ),
            'param_name'  => 'label',
            "description" => esc_html__("Add your section heading", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Heading', 'grandium' ),
            'param_name'  => 'heading',
            "description" => esc_html__("Add your section heading", "grandium"),
        ),
		array(
            'type'        => 'textarea',
            'heading'     => esc_html__('Description', 'grandium' ),
            'param_name'  => 'description',
            "description" => esc_html__("Add your description", "grandium"),
        ),
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Features items', 'grandium' ),
			'param_name'  => 'features_items',
			'group' => esc_html__('Features item', 'grandium' ),
			'params' => array(

				array(
					"type" => "attach_image",
					"heading" => esc_html__("Features item image", "grandium"),
					"param_name" => "features_img",
					"description" => esc_html__("Add your item image", "grandium"),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Features item name", "grandium"),
					"param_name" 	=> "item_heading",
					"description" 	=> esc_html__("Add features item name", "grandium")
				),

			)
		),
		// param_group end

        array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group' 	  => esc_html__('Background options', 'grandium' ),
        ),
				//title style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Title font-size', 'grandium'),
					'param_name'    =>'tsize',
					'description'   => esc_html__('Title fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Title line-height', 'grandium'),
					'param_name'    => 'tlineh',
					'description'   => esc_html__('Change Title line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Title color', 'grandium'),
					'param_name'    => 'tcolor',
					'description'   => esc_html__('Change Title color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//subtitle style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle font-size', 'grandium'),
					'param_name'    =>'ssize',
					'description'   => esc_html__('SubTitle fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle line-height', 'grandium'),
					'param_name'    => 'slineh',
					'description'   => esc_html__('Change SubTitle line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('SubTitle color', 'grandium'),
					'param_name'    => 'scolor',
					'description'   => esc_html__('Change SubTitle color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//description style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description font-size', 'grandium'),
					'param_name'    =>'dsize',
					'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description line-height', 'grandium'),
					'param_name'    => 'dlineh',
					'description'   => esc_html__('Change Description line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Description color', 'grandium'),
					'param_name'    => 'dcolor',
					'description'   => esc_html__('Change Description color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//title style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Item title font-size', 'grandium'),
					'param_name'    =>'ftsize',
					'description'   => esc_html__('Item title fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Item title line-height', 'grandium'),
					'param_name'    => 'ftlineh',
					'description'   => esc_html__('Change Item title line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Item title color', 'grandium'),
					'param_name'    => 'ftcolor',
					'description'   => esc_html__('Change Item title color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
      ),
   ) );
}
class WPBakeryShortCode_grandium_features extends WPBakeryShortCode {
}


/*-----------------------------------------------------------------------------------*/
/*	grandium TIMELINE
/*-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'grandium_timeline_integrateWithVC' );
function grandium_timeline_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Timeline", "grandium" ),
		"base" 	 => "grandium_timeline",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
		 array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Heading', 'grandium' ),
            'param_name'  => 'heading',
            "description" => esc_html__("Add your section heading", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Label', 'grandium' ),
            'param_name'  => 'label',
            "description" => esc_html__("Add your section heading", "grandium"),
        ),
		array(
            'type'        => 'textarea',
            'heading'     => esc_html__('Description', 'grandium' ),
            'param_name'  => 'description',
            "description" => esc_html__("Add your description", "grandium"),
        ),
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Timeline item', 'grandium' ),
			'param_name'  => 'timeline_items',
			'group' => esc_html__('Timeline Items', 'grandium' ),
			'params' => array(
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Your item time", "grandium"),
					"param_name" 	=> "item_time",
					"description" 	=> esc_html__("Add Your item label", "grandium")
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Your item title", "grandium"),
					"param_name" 	=> "item_heading",
					"description" 	=> esc_html__("Add Your item title", "grandium")
				),
				array(
					"type" 			=> "textarea",
					"heading" 		=> esc_html__("Your item description", "grandium"),
					"param_name" 	=> "item_desc",
					"description" 	=> esc_html__("Add item description", "grandium")
				),
			)
		),
		// param_group end


         array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group' 	  => esc_html__('Background options', 'grandium' ),
        ),
      ),
   ) );
}
class WPBakeryShortCode_grandium_timeline extends WPBakeryShortCode {}

/*-----------------------------------------------------------------------------------*/
/*	grandium TIMELINE
/*-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'grandium_services_integrateWithVC' );
function grandium_services_integrateWithVC() {
   vc_map( array(
		"name" 	 	=> esc_html__( "Services", "grandium" ),
		"base" 	 	=> "grandium_services",
		"category" 	=> esc_html__( "Grandium", "grandium"),
		"params"   	=> array(
		 array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Services item', 'grandium' ),
			'param_name'  => 'services_items',
			'group' => esc_html__('Services Items', 'grandium' ),
			'params' => array(
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Services item image", "grandium"),
					"param_name" => "features_img",
					"description" => esc_html__("Add your item image", "grandium"),
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Services item image small", "grandium"),
					"param_name" => "features_img_small",
					"description" => esc_html__("Add your item image", "grandium"),
				),
				array(
					"type" 			=> "textfield",
					"heading" 		=> esc_html__("Your item lable", "grandium"),
					"param_name" 	=> "item_heading",
					"description" 	=> esc_html__("Add Your item lable", "grandium")
				),
				array(
					"type" 			=> "textarea",
					"heading" 		=> esc_html__("Your item title", "grandium"),
					"param_name" 	=> "item_desc",
					"description" 	=> esc_html__("Add item title", "grandium")
				),
				array(
					"type" 			=> "textarea",
					"heading" 		=> esc_html__("Your item content", "grandium"),
					"param_name" 	=> "item_content",
					"description" 	=> esc_html__("Add your item content. You can use html <p> element for paragraph", "grandium")
				),
				array(
					"type"        => "vc_link",
					"heading"     => esc_html__("Item URL ( link)", "grandium"),
					"param_name"  => "links",
					"description" => esc_html__("Add any url", "grandium")
				),
			)
		),
		// param_group end


         array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group' 	  => esc_html__('Background options', 'grandium' ),
        ),
				//subtitle style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle font-size', 'grandium'),
					'param_name'    =>'ssize',
					'description'   => esc_html__('SubTitle fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('SubTitle line-height', 'grandium'),
					'param_name'    => 'slineh',
					'description'   => esc_html__('Change SubTitle line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('SubTitle color', 'grandium'),
					'param_name'    => 'scolor',
					'description'   => esc_html__('Change SubTitle color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
				//description style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description font-size', 'grandium'),
					'param_name'    =>'dsize',
					'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description line-height', 'grandium'),
					'param_name'    => 'dlineh',
					'description'   => esc_html__('Change Description line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Description color', 'grandium'),
					'param_name'    => 'dcolor',
					'description'   => esc_html__('Change Description color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),

				//button style
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Button font-size', 'grandium'),
					'param_name'    =>'bsize',
					'description'   => esc_html__('Button fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
 				 'type'          => 'colorpicker',
 				 'heading'       => esc_html__('Button color', 'grandium'),
 				 'param_name'    => 'bcolor',
 				 'description'   => esc_html__('Change Button color.', 'grandium'),
 				 'group'         => esc_html__('Custom Style', 'grandium' ),
 			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Button bg color', 'grandium'),
					'param_name'    => 'bgcolor',
					'description'   => esc_html__('Change Button bg color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
      ),
   ) );
}
class WPBakeryShortCode_grandium_services extends WPBakeryShortCode {}

/*-----------------------------------------------------------------------------------*/
/*	PORTFOLIO
/*-----------------------------------------------------------------------------------*/
add_action( 'vc_before_init', 'grandium_portfolio_integrateWithVC' );
function grandium_portfolio_integrateWithVC() {
   vc_map( array(
      "name" 			=> esc_html__( "Portfolio", "grandium" ),
      "base" 			=> "grandium_portfolio",
	  "icon"            => "icon-wpb-row",
	  "category" 		=> esc_html__( "Grandium", "grandium"),
	  "description" 	=> esc_html__("Frontpage portfolio section", "grandium"),
      "params" 			=> array(
		 array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Portfolio Count', 'grandium' ),
            'param_name'  => 'posts',
            "description" => esc_html__("You can control with number your portfolio posts", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'Portfolio top menu all photos text option', 'grandium' ),
            'param_name'  => 'all',
            "description" => esc_html__("You can control all text or leave blank", "grandium"),
        ),

        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'order', 'grandium' ),
            'param_name'  => 'order',
            "description" => esc_html__("Enter portfolio item order. DESC or ASC", "grandium"),
        ),

        array(
            'type'        => 'textfield',
            'heading'     => esc_html__( 'orderby', 'grandium' ),
            'param_name'  => 'orderby',
            "description" => esc_html__("Enter post orderby. Default is : date", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Category', 'grandium' ),
            'param_name'  => 'portfolio_category',
            "description" => esc_html__("Enter Portfolio category or write all", "grandium"),
        ),

	    array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group'       => esc_html__('Background options', 'grandium' ),
        ),
      )
   ) );
}
class WPBakeryShortCode_grandium_portfolio extends WPBakeryShortCode {
}

/*-----------------------------------------------------------------------------------*/
/*	PAGE CONTACT
/*-----------------------------------------------------------------------------------*/


add_action( 'vc_before_init', 'grandium_contact_vc_integrateWithVC' );
function grandium_contact_vc_integrateWithVC() {
	vc_map( array(
	"name" 	 => esc_html__( "Contact Section", "grandium" ),
	"base" 	 => "grandium_contact",
	"category" => esc_html__( "Grandium", "grandium"),
	"params"   => array(
		array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Heading', 'grandium' ),
            'param_name'  => 'heading',
            "description" => esc_html__("Add your heading", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Google map text', 'grandium' ),
            'param_name'  => 'read',
            "description" => esc_html__("Default value : MAP", "grandium"),
			'group' 	  => esc_html__('Map', 'grandium' ),
        ),
		//	start param_group
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Contact info', 'grandium' ),
			'param_name'  => 'contact_items',
			'group' 	  => esc_html__('Details', 'grandium' ),
			'params'	  => array(

				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Item heading', 'grandium' ),
					'param_name'  => 'item_head',
					"description" => esc_html__("Left", "grandium"),
				),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__("First line", "grandium"),
					"param_name"  => "first_line",
					"description" => esc_html__("Add contact detail - Default for adresses", "grandium")
				),
				array(
					"type"        => "textfield",
					"heading"     => esc_html__("Second line", "grandium"),
					"param_name"  => "second_line",
					"description" => esc_html__("Add contact detail - Default for phone numbers", "grandium")
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Mail', 'grandium' ),
					'param_name'  => 'item_mail',
					'description' => esc_html__('Add mail url', 'grandium' ),
				),
			)
		),
		// param_group end

		// form
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__('Contact form visibility', 'grandium' ),
			'param_name'  => 'form',
			'description' => esc_html__('You can hide/show this section heading area.', 'grandium' ),
			'group'       => esc_html__( 'Form', 'grandium' ),
			'value'       => array(
				esc_html__('Select a option', 		'grandium' )		=> '',
				esc_html__('Show', 					'grandium' )		=> '1',
				esc_html__('Hide', 					'grandium' )		=> '2',
			),
		),
		array(
			"type"        => "textfield",
			"heading"     => esc_html__( "Contact form heading", "grandium" ),
			"param_name"  => "form_head",
			"description" => esc_html__( "Contact form heading", "grandium" ),
			'group'       => esc_html__( 'Form', 'grandium' ),
		),
		array(
			"type"        => "textfield",
			"heading"     => esc_html__("Contact form description", "grandium"),
			"param_name"  => "form_desc",
			"description" => esc_html__("Add Contact form description", "grandium"),
			'group'       => esc_html__( 'Form', 'grandium' ),
		),
		array(
			"type"        => "textarea_html",
			"heading"     => esc_html__("Contact form ", "grandium"),
			"param_name"  => 'content',
			"description" => esc_html__("Copy paste your contact form shortcode", "grandium"),
			'group'       => esc_html__( 'Form', 'grandium' ),
		),

		// bottom
		//	start param_group
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__('Comments area visibility', 'grandium' ),
			'param_name'  => 'comment_area',
			'description' => esc_html__('You can hide/show this section heading area.', 'grandium' ),
			'group'       => esc_html__( 'Comment', 'grandium' ),
			'value'       => array(
				esc_html__('Select a option', 		'grandium' )		=> '',
				esc_html__('Show', 					'grandium' )		=> '1',
				esc_html__('Hide', 					'grandium' )		=> '2',
			),
		),
		array(
			'type'        => 'param_group',
			'heading'     => esc_html__('Comment area', 'grandium' ),
			'param_name'  => 'comment_items',
			'group' => esc_html__('Comment', 'grandium' ),
			'params' => array(

				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Icon', 'grandium' ),
					'param_name'  => 'c_icon_name',
					"description" => esc_html__("Example : fa fa-facebook", "grandium"),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__('Comment item name', 'grandium' ),
					'param_name'  => 'c_item_name',
					'description' => esc_html__('Add mail url', 'grandium' ),
				),
				array(
					"type"        => "vc_link",
					"heading"     => esc_html__("Item URL ( link)", "grandium"),
					"param_name"  => "links",
					"description" => esc_html__("Add any url", "grandium")
				),
			)
		),
		// param_group end

        array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group'       => esc_html__('Background', 'grandium' )
        ),
      ),
   ) );
}
class WPBakeryShortCode_grandium_contact extends WPBakeryShortCode {}

/*-----------------------------------------------------------------------------------*/
/*	grandium Heading
/*-----------------------------------------------------------------------------------*/

add_action( 'vc_before_init', 'grandium_heading_type_integrateWithVC' );
function grandium_heading_type_integrateWithVC() {
   vc_map( array(
		"name" 	 => esc_html__( "Heading", "grandium" ),
		"base" 	 => "grandium_heading_type",
		"category" => esc_html__( "Grandium", "grandium"),
		"params"   => array(
		 array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Section ID', 'grandium' ),
            'param_name'  => 'section_id',
            "description" => esc_html__("Add Your Section ID", "grandium"),
        ),
        array(
            'type'        => 'textfield',
            'heading'     => esc_html__('Heading', 'grandium' ),
            'param_name'  => 'heading',
            "description" => esc_html__("Add your section heading", "grandium"),
        ),
		array(
            'type'        => 'textarea',
            'heading'     => esc_html__('Description', 'grandium' ),
            'param_name'  => 'description',
            "description" => esc_html__("Add your description", "grandium"),
        ),
        array(
            'type'        => 'css_editor',
            'heading'     => esc_html__('Css', 'grandium' ),
            'param_name'  => 'css',
            'group' 	  => esc_html__('Background options', 'grandium' ),
        ),
				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Heading font-size', 'grandium'),
					'param_name'    =>'hsize',
					'description'   => esc_html__('Heading fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Heading line-height', 'grandium'),
					'param_name'    => 'hlineh',
					'description'   => esc_html__('Change heading line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Heading color', 'grandium'),
					'param_name'    => 'hcolor',
					'description'   => esc_html__('Change heading color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),

				array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description font-size', 'grandium'),
					'param_name'    =>'dsize',
					'description'   => esc_html__('Description fontsize.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'textfield',
					'heading'       => esc_html__('Description line-height', 'grandium'),
					'param_name'    => 'dlineh',
					'description'   => esc_html__('Change description line-height.use number in ( px or unit )', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
			 ),
			 array(
					'type'          => 'colorpicker',
					'heading'       => esc_html__('Description color', 'grandium'),
					'param_name'    => 'dcolor',
					'description'   => esc_html__('Change description color.', 'grandium'),
					'group'         => esc_html__('Custom Style', 'grandium' ),
				),
      ),
   ) );
}
class WPBakeryShortCode_grandium_heading_type extends WPBakeryShortCode {
}
