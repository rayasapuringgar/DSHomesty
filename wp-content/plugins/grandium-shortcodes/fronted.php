<?php


if ( ! function_exists( 'grandium_element' ) ) {
    function grandium_element( $text='Add your text', $tag='p', $class='', $lineh='', $size='', $color='' ) {

		if ( ( isset( $text ) ) && ( $text != '' ) ) {

            $tags = array(
                'span'  => array( 'class'	=> array(),	'id'	=> array() ),
                'i'     => array( 'class'  => array() ),
                'mark'  => array(),
                'p'     => array( 'class'  => array() ),
                'b'     => array(),
                'br'    => array(),
                'strong'=> array(),
                'a'     => array( 'href' => array(),'class' => array(),'title' => array() )
            );
			$text = wp_kses( $text, $tags );

			$el_tag 	  = ( isset( $tag    ) && $tag  	!= '' ) ? $tag : '';
			$el_class 	= ( isset( $class  ) && $class  != '' ) ? ' class="'.esc_attr( $class ).'"' : '';
			$lineheight = ( isset( $lineh  ) && $lineh  != '' ) ? ' line-height:'.esc_attr( $lineh ).'!important;' 	: '';
			$fontsize 	= ( isset( $size   ) && $size   != '' ) ? ' font-size:'.esc_attr( $size ).'!important;' 	: '';
			$fontcolor 	= ( isset( $color  ) && $color  != '' ) ? ' color:'.esc_attr( $color ).'!important;' 		: '';

            if ( $fontsize != '' || $fontcolor != '' || $lineheight != '' ){
				$style = ' style="'.$fontsize.$fontcolor.$lineheight.'"';
			} else {
				$style = '';
			}

			if ( $el_tag != '' ){
				$element = '<'.$el_tag.''.$el_class.''.$style.'>'.$text.'</'.$el_tag.'>';
			} else {
				$element = $text;
			}

		} else {  return false; } // end $text

      return $element;
    } // end function
} // end function_exists


/*-----------------------------------------------------------------------------------*/
/*	PRODUCT grandium
/*-----------------------------------------------------------------------------------*/

function grandium_slider_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'          => '',
        'css'                 => '',
        'overlaybg'           => '',
        'formheading'         => '',
        'bg_img'              => '',
        'slider_item'         => '',
        'item_heading_1'      => '',
        'item_heading_2'      => '',
        'item_heading_3'      => '',

        'tolineh'             => '',
        'tosize'              => '',
        'tocolor'             => '',
        'twlineh'             => '',
        'twsize'              => '',
        'twcolor'             => '',
        'ttlineh'             => '',
        'ttsize'              => '',
        'ttcolor'             => '',
        'autoplay'            => '',
        'speed'               => '',
        'timeout'             => '',
        'minh'                => '',
    ), $atts) );

    $autoplay = $autoplay == 'yes' ? ' data-autoplay="true"' : ' data-autoplay="false"';
    $speed = $speed ? ' data-speed="'.$speed.'"' : '';
    $timeout = $timeout ? ' data-timeout="'.$timeout.'"' : '';
    $min_h = $minh ? ' style="min-height:'.$minh.'"' : '';

    $css_class    = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id           = ($section_id != '') ? ' id="'. esc_attr($section_id) . '" ' : '';
    $slider_item  = (array) vc_param_group_parse_atts($slider_item);

	$out = '';

	if( $overlaybg !='' || $minh ) {
		$out .= '<style>';
			if( $overlaybg ) { $out .= '.widget-slider .widget-carousel .slider-item:after { background-color: '.$overlaybg.' !important; }'; }
			if( $minh ) { $out .= '.section .widget-slider .widget-carousel .slider-item { min-height: '.$minh.' !important; }'; }
		$out .= '</style>';
	}

    $out .= '<div class="section '. esc_attr($css_class) . '" '.$id.'>';
        $out .= '<div class="widget-slider">';
            $out .= '<div class="wrapper-full">';
			$out .= '<div class="widget-carousel owl-carousel owl-theme"'.$autoplay.$speed.$timeout.'>';

				foreach ( $slider_item as $p ) {
					$img = wp_get_attachment_url( $p['bg_img'],'full' );
					$out .= '<div class="slider-item" data-background="'. $img .'">';
						$out .= '<div class="wrapper">';
                            $out .= '<div class="item-inner">';

                            if ( isset($p['item_heading_1'])   !== '' ){$out .= ''.grandium_element( $p['item_heading_1'], $tag='h5', $class='', $tolineh, $tosize, $tocolor ).''; }
                            if ( isset($p['item_heading_2'])   !== '' ){$out .= ''.grandium_element( $p['item_heading_2'], $tag='h1', $class='', $twlineh, $twsize, $twcolor ).''; }
                            if ( isset($p['item_heading_3'])   !== '' ){$out .= ''.grandium_element( $p['item_heading_3'], $tag='h2', $class='', $ttlineh, $ttsize, $ttcolor ).''; }

                            $out .= '</div>';
                        $out .= '</div>';
                    $out .= '</div>';
				}

                $out .= '</div>';
                $out .= '<!-- Slider Carousel End -->';

				$out .= '<!-- Slider Booking -->';
                $out .= '<div class="slider-booking">';
                    $out .= '<div class="wrapper">';
					$out .= '<h5>'. $formheading .'</h5>';
						$out .= '<ul class="wrapper-list">';
							$out .= ''.do_shortcode($content).'';
						$out .= '</ul>';
                    $out .= '</div>';
                 $out .= '</div>';
                 $out .= '<!-- Slider Booking End -->';

             $out .= '</div>';
         $out .= '</div>';
    $out .= '</div>';
    $out .= '<!-- Section Slider End -->';

	return $out;
}
add_shortcode('grandium_slider', 'grandium_slider_vc');

/*-----------------------------------------------------------------------------------*/
/*	HOW IT grandium
/*-----------------------------------------------------------------------------------*/
function grandium_rooms_carousel_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'          => '',
        'css'                 => '',
        'category'            => 'all',
        'build_query'         => '',
        'heading_visiblity'   => '2',
        'label'               => '',
        'heading'             => '',
        'description'         => '',
        'excerpt_size'        => '105',
        'plineh'              => '',
        'psize'               => '',
        'pcolor'              => '',
        'tlineh'              => '',
        'tsize'               => '',
        'tcolor'              => '',
        'dlineh'              => '',
        'dsize'               => '',
        'dcolor'              => '',
        // slider
        'autoplay'            => '',
        'speed'               => '',
        'timeout'             => '',
        'lgitems'             => '',
        'mditems'             => '',
    ), $atts) );

    $autoplay = $autoplay == 'yes' ? ' data-autoplay="true"' : ' data-autoplay="false"';
    $speed = $speed ? ' data-speed="'.$speed.'"' : '';
    $timeout = $timeout ? ' data-timeout="'.$timeout.'"' : '';
    $lgitems = $lgitems ? ' data-lgitems="'.$lgitems.'"' : ' data-lgitems="3"';
    $mditems = $mditems ? ' data-mditems="'.$mditems.'"' : ' data-mditems="2"';

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';
    $h_v = ($heading_visiblity == '2') ? 'top-over' : '';

    $out = '';

    $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="widget-rooms-carousel '. $h_v .'">';
            $out .= '<div class="wrapper-inner">';

                $out .= '<div class="widget-title">';
                    $out .= '<h5>'. $label .'</h5>';
                    $out .= '<h2>'. $heading .'</h2>';
                    $out .= '<p>'. $description .'</p>';
                $out .= '</div>';

                $out .= '<div class="widget-carousel owl-carousel owl-theme"'.$autoplay.$speed.$timeout.$lgitems.$mditems.'>';

                    global $post,$wp_query;

                    list($args) = vc_build_loop_query($build_query);

                    $grandium_product_query = new WP_Query($args);
                    if( $grandium_product_query->have_posts() ) :
                        while ($grandium_product_query->have_posts()) : $grandium_product_query->the_post();

                            $grandium_name     = rwmb_meta( 'grandium_name');
                            $grandium_rate     = rwmb_meta( 'grandium_rate');
                            $grandium_currency = rwmb_meta( 'grandium_currency');
                            $grandium_price    = rwmb_meta( 'grandium_price');

                            $thumb      = get_post_thumbnail_id();
                            $img_url    = wp_get_attachment_url( $thumb,'full' );
                            $image      = aq_resize( $img_url, 353, 353, true, true, true );

                            $out .= '<div class="rooms-item">';
                                $out .= '<div class="item-inner">';

                                    $out .= '<div class="item-photo">';
                                        $out .= '<a href="'. esc_url( get_permalink() ) . '" data-background="'. esc_url($image) . '"></a>';
                                    $out .= '</div>';

                                    $out .= '<div class="item-desc">';

                                        $rooms_title = get_the_title();
                                        if( $rooms_title != '' ) {
                                            $t_color = ( $tcolor !='' ) ? ' color:'.esc_attr( $rtcolor ).';' : '';
                                            $t_size = ( $tsize !=''  ) ? ' font-size:'.esc_attr( $rtsize ).';' : '';
                                            $t_lineh = ( $tlineh !='' ) ? ' line-height:'.esc_attr( $rtlineh ).';' : '';
                                            $titlestyle = ( $t_color !='' || $t_size !='' || $t_lineh !='' ) ? ' style="'.$t_color.$t_size.$t_lineh.'"' : '';
                                            $out .= '<h2'.$titlestyle.'><a href="'. get_permalink().'">'. esc_html($rooms_title) . '</a></h2>';
                                        }
                                        $rooms_price=$grandium_currency . ' '. $grandium_price;
                                        $out .= ''.grandium_element( $rooms_price, $tag='h3', $class='', $plineh, $psize, $pcolor ).'';

                                        $rooms_desc = substr(get_the_excerpt(), 0, $excerpt_size) ;
                                        if( $rooms_desc != '' ) {
                                            $d_color = ( $dcolor !='' ) ? ' color:'.esc_attr( $dcolor ).';' : '';
                                            $d_size = ( $dsize !=''  ) ? ' font-size:'.esc_attr( $dsize ).';' : '';
                                            $d_lineh = ( $dlineh !='' ) ? ' line-height:'.esc_attr( $dlineh ).';' : '';
                                            $descstyle = ( $d_color !='' || $d_size !='' || $d_lineh !='' ) ? ' style="'.$d_color.$d_size.$d_lineh.'"' : '';
                                            $out .= '<p '.$descstyle.'>' . $rooms_desc . '</p>';

                                        }

                                        if( $grandium_rate !='0' ) {
                                            $out .= '<i class="fa fa-star-'. $grandium_rate . '"></i>';
                                        }
                                    $out .= '</div>';

                                $out .= '</div>';
                            $out .= '</div>';

                        endwhile;
                        wp_reset_postdata();
                    endif;

                    $out .= ' </div>'; // Rooms Carousel End

                $out .= '</div>';
            $out .= '</div>';
        $out .= '</div>';

    return $out;
}
add_shortcode('grandium_rooms_carousel', 'grandium_rooms_carousel_vc');

/*-----------------------------------------------------------------------------------*/
/*	rooms carousel loop
/*-----------------------------------------------------------------------------------*/

function grandium_rooms_carouseltwo_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'          => '',
        'css'                 => '',
        'heading_visiblity'   => '2',
        'label'               => '',
        'heading'             => '',
        'description'         => '',
        'sloop'               => '',

        'imgh'                => '',
        'imgw'                => '',
        'plineh'              => '',
        'psize'               => '',
        'pcolor'              => '',
        'tlineh'              => '',
        'tsize'               => '',
        'tcolor'              => '',
        'dlineh'              => '',
        'dsize'               => '',
        'dcolor'              => '',
    ), $atts) );

    $css_class 		= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id 			= ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';
    $h_v 			= ($heading_visiblity == '2') ? 'top-over' : '';

    $slider_loop = (array) vc_param_group_parse_atts($sloop);

	$out = '';

        $out .= '<!-- Section Rooms -->';
        $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
            $out .= '<div class="widget-rooms-carousel '. $h_v .'">';
                $out .= '<div class="wrapper-inner">';

                    $out .= '<!-- Rooms Title -->';
                    $out .= '<div class="widget-title">';

                        $out .= '<h5>'. $label .'</h5>';
                        $out .= '<h2>'. $heading .'</h2>';
                        $out .= '<p>'. $description .'</p>';
                    $out .= '</div>';
                    $out .= '<!-- Rooms Title End -->';

                    $out .= '<!-- Rooms Carousel -->';
                    $out .= '<div class="widget-carousel owl-carousel owl-theme">';


                        foreach ($slider_loop as $item) {

                            $img_w = empty($imgw) ? 353 :$imgw;
                            $img_h = empty($imgh) ? 353 :$imgh;
                            $img  = aq_resize( wp_get_attachment_url( $item['image'],'full' ), $img_w, $img_h , true, true, true );

                            $out .= '<div class="rooms-item">';
                                $out .= '<div class="item-inner">';

                                    $out .= '<div class="item-photo">';
                                        $out .= '<a href="'. esc_url( $item['imghref']) . '" data-background="'. esc_url($img) . '"></a>';
                                    $out .= '</div>';

                                    $out .= '<div class="item-desc">';

                                        $rooms_title = $item['title'];
                                        if( $rooms_title != '' ) {
                                            $t_color = ( $tcolor !='' ) ? ' color:'.esc_attr( $rtcolor ).';' : '';
                                            $t_size = ( $tsize !=''  ) ? ' font-size:'.esc_attr( $rtsize ).';' : '';
                                            $t_lineh = ( $tlineh !='' ) ? ' line-height:'.esc_attr( $rtlineh ).';' : '';
                                            $titlestyle = ( $t_color !='' || $t_size !='' || $t_lineh !='' ) ? ' style="'.$t_color.$t_size.$t_lineh.'"' : '';
                                            $out .= '<h2'.$titlestyle.'><a href="'. esc_url($item['titlehref']).'">'. esc_html($rooms_title) . '</a></h2>';
                                        }

                                        $rooms_price= $item['grandium_currency']. ' '. $item['grandium_price'];
                                        $out .= ''.grandium_element( $rooms_price, $tag='h3', $class='', $plineh, $psize, $pcolor ).'';

                                        $rooms_desc = $item['grandium_desc'] ;

                                        if( $rooms_desc != '' ) {
                                            $d_color = ( $dcolor !='' ) ? ' color:'.esc_attr( $dcolor ).';' : '';
                                            $d_size = ( $dsize !=''  ) ? ' font-size:'.esc_attr( $dsize ).';' : '';
                                            $d_lineh = ( $dlineh !='' ) ? ' line-height:'.esc_attr( $dlineh ).';' : '';
                                            $descstyle = ( $d_color !='' || $d_size !='' || $d_lineh !='' ) ? ' style="'.$d_color.$d_size.$d_lineh.'"' : '';
                                            $out .= '<p '.$descstyle.'>' . $rooms_desc . '</p>';
                                        }

                                        if( $item['grandium_rate'] !='0' ) {
                                            $out .= '<i class="fa fa-star-'. $item['grandium_rate']  . '"></i>';
                                        }

                                    $out .= '</div>';

                                $out .= '</div>';
                            $out .= '</div>';
                        }
                    $out .= ' </div>';// carousel end

                $out .= '</div>';
            $out .= '</div>';
        $out .= '</div>';

    return $out;
}
add_shortcode('grandium_rooms_carouseltwo', 'grandium_rooms_carouseltwo_vc');

/*-----------------------------------------------------------------------------------*/
/*	About grandium
/*-----------------------------------------------------------------------------------*/

function grandium_about_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
    'section_id'        => '',
    'css'               => '',
    'overlaybg'         => '',
    'heading'           => '',
    'label'             => '',
    'link'              => '',
    'bg_img'            => '',
    'features_item'   	=> '',
    'item_heading'      => '',
    'item_desc'         => '',

    'slineh'            => '',
    'ssize'             => '',
    'scolor'            => '',
    'tlineh'            => '',
    'tsize'             => '',
    'tcolor'            => '',
    ), $atts) );


    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';
    $img = wp_get_attachment_url( $bg_img, 'full' );

    $link 		= ( $link == '||' ) ? '' : $link;
    $link 		= vc_build_link( $link );
    $a_href 	= $link['url'];
    $a_title 	= $link['title'];
    $a_target 	= $link['target'];

  	$target 	= ($a_target != '') ? 'target="'. esc_attr($a_target) . '"' : '';
  	$href 		= ($a_href != '')   ? 'href="'. esc_url($a_href) . '"' : '';

    if( $overlaybg =='off' ) {
      $out .= '<style>';
        $out .= '.widget-about-promo:after { display:none }';
      $out .= '</style>';
    }

	$out = '';
    $out .= '<!-- Section About Promo -->';
      $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .' >';
          $out .= '<div class="widget-about-promo" data-background="'. $img .'">';
              $out .= '<div class="wrapper-inner">';
                  $out .= '<div class="widget-inner">';
                      $out .= '<div class="row">';
                          $out .= '<div class="col-md-6">';
                            if ( isset($label)   !== '' ){$out .= ''.grandium_element( $label, $tag='h5', $class='', $slineh, $ssize, $scolor ).''; }
                            if ( isset($heading)   !== '' ){$out .= ''.grandium_element( $heading, $tag='h2', $class='', $tlineh, $tsize, $tcolor ).''; }
								$out .= ''.do_shortcode($content).'';
								if ( $a_title !='' ){ $out .= '<a '. $href .' '. $target .' class="btn">'. $a_title .'</a>'; }
                          $out .= '</div>';
                      $out .= '</div>';
                  $out .= '</div>';
              $out .= '</div>';
          $out .= '</div>';
      $out .= '</div>';
      $out .= '<!-- Section About Promo End -->';

	return $out;
}
add_shortcode('grandium_about', 'grandium_about_vc');



/*-----------------------------------------------------------------------------------*/
/*	ABOUT GRID
/*-----------------------------------------------------------------------------------*/

function grandium_about_two_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'        => '',
        'css'               => '',
        'heading'           => '',
        'label'             => '',
        'link'          		=> '',
        'about_two_item'    => '',
        'item_heading'      => '',
        'item_desc'         => '',

        'slineh'            => '',
        'ssize'             => '',
        'scolor'            => '',
        'tlineh'            => '',
        'tsize'             => '',
        'tcolor'            => '',
        'dlineh'            => '',
        'dsize'             => '',
        'dcolor'            => '',
    ), $atts) );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$about_two_item = (array) vc_param_group_parse_atts($about_two_item);

	$out = '';
	$out .= '<div class="section '. esc_attr($css_class) . '" '. $id .' >';
        $out .= '<div class="widget-about-grid">';
            $out .= '<div class="wrapper-inner">';
                $out .= '<div class="widget-inner">';

				foreach ( $about_two_item as $v ) {

					if ( isset($v['link'])){
						$btn_link 	= vc_build_link($v['link']) ;
						$btn_title 	= vc_build_link($v['link']) ;
						$a_href 	= $btn_link['url'];
						$a_title 	= $btn_title['title'];
						$a_target 	= $btn_link['target'];

						$target = ($a_target != '') ? 'target="'. esc_attr($a_target) . '"' : '';
						$href = ($a_href != '')   ? 'href="'. esc_url($a_href) . '"' : '';
					}

                    $out .= '<div class="widget-item">';
                        if ( isset($v['label'])   !== '' ){$out .= ''.grandium_element( $v['label'], $tag='h5', $class='', $slineh, $ssize, $scolor ).''; }
                        if ( isset($v['heading'])   !== '' ){$out .= ''.grandium_element( $v['heading'], $tag='h2', $class='', $tlineh, $tsize, $tcolor ).''; }
                        if ( isset($v['desc'])   !== '' ){$out .= ''.grandium_element( $v['desc'], $tag='p', $class='', $dlineh, $dsize, $tcolor ).''; }
						$out .= '<p></p>';
						if ( $a_title !='' ){ $out .= '<a '. $href .' '. $target .' class="btn">'. $a_title .'</a>'; }
                    $out .= '</div>';
				}

                $out .= '</div>';
            $out .= '</div>';
        $out .= '</div>';
    $out .= '</div>';

	return $out;
}
add_shortcode('grandium_about_two', 'grandium_about_two_vc');


/*-----------------------------------------------------------------------------------*/
/*	ABOUT
/*-----------------------------------------------------------------------------------*/
function grandium_features_two_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'           		=> '',
        'css'                  		=> '',
        'label'                		=> '',
        'heading'                	=> '',
        'description'               => '',
        'item_image'                => '',
        'link'                		=> '',

        'features_two_left_item'    => '',
        'column'                    => '',
        'item_left_heading'         => '',
        'item_left_desc'            => '',

        'slineh'            => '',
        'ssize'             => '',
        'scolor'            => '',
        'tlineh'            => '',
        'tsize'             => '',
        'tcolor'            => '',
        'dlineh'            => '',
        'dsize'             => '',
        'dcolor'            => '',
    ), $atts) );

	$features_two_left_item = (array) vc_param_group_parse_atts($features_two_left_item);
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
    $out .= '<!-- Section Features -->';
    $out .= '<div '. $id .' class="section '. esc_attr($css_class) . '">';
        $out .= '<div class="widget-features-grid">';
            $out .= '<div class="wrapper-inner">';
                $out .= '<!-- Features Title -->';
                $out .= '<div class="widget-title">';
                if ( isset($label)   !== '' ){$out .= ''.grandium_element( $label, $tag='h5', $class='', $slineh, $ssize, $scolor ).''; }
                if ( isset($heading)   !== '' ){$out .= ''.grandium_element( $heading, $tag='h2', $class='', $tlineh, $tsize, $tcolor ).''; }
                if ( isset($description)   !== '' ){$out .= ''.grandium_element( $description, $tag='p', $class='', $dlineh, $dsize, $tcolor ).''; }

                $out .= '</div>';
                $out .= '<!-- Features Title End -->';
                $out .= '<!-- Features Content -->';
                $out .= '<div class="widget-inner">';
                    $out .= '<div class="row">';

						foreach ( $features_two_left_item as $v ) {

							if ( isset($v['link'])){
								$btn_link = vc_build_link($v['link']) ;
								$btn_title = vc_build_link($v['link']) ;
								$a_href = $btn_link['url'];
								$a_title = $btn_title['title'];
								$a_target = $btn_link['target'];
							}
                     $clmn = ($column != '') ? 'class="'. esc_attr($column) . '"' : 'class="col-lg-4 col-sm-6"';
							$out .= '<div '. $clmn .'>';
								$img_url = wp_get_attachment_url( $v['item_image'],'full' );
								$image = aq_resize( $img_url, 670, 690, true, true, true );

								$out .= '<div class="features-item" data-background="'. $image .'">';
									if ( isset($v['link'])){ 	$out .= '<a href="'. esc_url($a_href) . '" target="'. $a_target .'">'; }

										$out .= '<h3>'.$v['item_left_heading'].'</h3>';
										$out .= '<p>'.$v['item_left_desc'].'</p>';
									if ( isset($v['link'])){ $out .= '</a>'; }
							   $out .= ' </div>';
							$out .= '</div>';

                  } // foreach end

                    $out .= '</div>';
                $out .= '</div>';
                $out .= '<!-- Features Content End -->';
            $out .= '</div>';
        $out .= '</div>';
    $out .= '</div>';
    $out .= '<!-- Section Features End -->';

	return $out;
}
add_shortcode('grandium_features_two', 'grandium_features_two_vc');


/*-----------------------------------------------------------------------------------*/
/*	gallery
/*-----------------------------------------------------------------------------------*/


function grandium_gallery_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
		'section_id'        => '',
		'css'               => '',
		'label'           	=> '',
		'heading'           => '',
		'description'       => '',
		'item_image'        => '',
		'gallery_items'     => '',
		'item_heading'    	=> ''
    ), $atts) );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';
	$gallery_item = (array) vc_param_group_parse_atts($gallery_items);

	$out = '';
	 $out .= '<!-- Section Gallery -->';
     $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
         $out .= '<div class="widget-gallery-carousel">';
             $out .= '<div class="wrapper-full-inner">';

				$out .= '<!-- Gallery Title -->';
				$out .= '<div class="widget-title">';
					$out .= '<h5>'. $label .'</h5>';
					$out .= '<h2>'. $heading .'</h2>';
					$out .= '<p>'. $description .'</p>';
				$out .= '</div>';
				$out .= '<!-- Gallery Title End -->';

                 $out .= '<!-- Gallery Carousel -->';
                 $out .= '<div class="widget-carousel owl-carousel owl-theme">';
					foreach ( $gallery_item as $v ) {
						$out .= '<div class="gallery-item">';

                        $img_urls = wp_get_attachment_url( $v['item_image'],'full' );
                        $img_url = aq_resize( $img_urls, 767, 767, true, true, true );

							 $out .= '<a href="'. $img_url .'" data-background="'. $img_url .'"  class="grandium-popup-gallery">';
								 if ( isset($v['item_heading'])){ $out .= '<span class="item-text">'.$v['item_heading'].'</span>'; }
							$out .= ' </a>';
						$out .= '</div>';
					}
				$out .= '</div>';
                 $out .= '<!-- Gallery Carousel End -->';
            $out .= '</div>';
            $out .= '</div>';
        $out .= '</div>';
     $out .= '<!-- Section Gallery End -->';

 return $out;
}
add_shortcode('grandium_gallery', 'grandium_gallery_vc');



/*-----------------------------------------------------------------------------------*/
/*	VIDEO
/*-----------------------------------------------------------------------------------*/

function grandium_video_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
		'section_id'        => '',
		'css'               => '',
		'label'           	=> '',
		'heading'           => '',
		'description'       => '',
		'video_url'       	=> '',
		'bg_image'        	=> ''
    ), $atts) );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';
	$bg_image_out = wp_get_attachment_url( $bg_image,'full' );


	$out = '';
	$out .= '<!-- Section Video -->';
    $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="widget-video-full" data-background="'. $bg_image_out . '">';
            $out .= '<div class="wrapper-full-inner">';

                $out .= '<!-- Video Title -->';
                $out .= '<div class="widget-title">';
					$out .= '<h5>'. $label .'</h5>';
					$out .= '<h2>'. $heading .'</h2>';
					$out .= '<p>'. $description .'</p>';
                $out .= '</div>
                <!-- Video Title End -->
                <!-- Video Content -->';
				if ( $video_url !=''){
					$out .= '<div class="widget-inner">';
						$out .= '<a href="'. esc_attr($video_url) . '" class="video-play popup-video"><i class="fa fa-play"></i></a>';
					$out .= '</div>';
				}
                $out .= '<!-- Video Content End -->
           </div>
       </div>
    </div>
    <!-- Section Video End -->';

 return $out;
}
add_shortcode('grandium_video', 'grandium_video_vc');

/*-----------------------------------------------------------------------------------*/
/*	OFFERS
/*-----------------------------------------------------------------------------------*/

function grandium_offers_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'        => '',
        'css'               => '',
        'label'           	=> '',
        'heading'           => '',
        'description'       => '',
        'offer_items'       => '',
        'item_image'      	=> '',
        'item_heading'      => '',
        'item_desc'      	=> '',
        'link'       		=> '',
        'video_url'       	=> '',
        'gbg_image'        	=> '',

        'slineh'            => '',
        'ssize'             => '',
        'scolor'            => '',
        'tlineh'            => '',
        'tsize'             => '',
        'tcolor'            => '',
        'dlineh'            => '',
        'dsize'             => '',
        'dcolor'            => '',
        'twlineh'           => '',
        'twsize'            => '',
        'twcolor'           => '',
        'dwlineh'           => '',
        'dwsize'            => '',
        'dwcolor'           => '',
    ), $atts) );

    $css_class 		= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id 			= ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';
	$bg_image_out 	= wp_get_attachment_url( $gbg_image,'full' );
	$offer_item 	= (array) vc_param_group_parse_atts($offer_items);

	$out = '';
    $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
          $out .= ' <div class="widget-offers-grid" data-background="'. $bg_image_out . '">';
              $out .= ' <div class="wrapper-inner">';

                $out .= '<div class="widget-title">';

                if ( isset($label)   !== '' ){$out .= ''.grandium_element( $label, $tag='h5', $class='', $slineh, $ssize, $scolor ).''; }
                if ( isset($heading)   !== '' ){$out .= ''.grandium_element( $heading, $tag='h2', $class='', $tlineh, $tsize, $tcolor ).''; }
                if ( isset($description)   !== '' ){$out .= ''.grandium_element( $description, $tag='p', $class='', $dlineh, $dsize, $tcolor ).''; }

                $out .= '</div>';

                   $out .= '<div class="widget-inner">';

						foreach ( $offer_item as $v ) {

							if ( isset($v['link'])){
								$btn_link = vc_build_link($v['link']) ;
								$btn_title = vc_build_link($v['link']) ;
								$a_href = $btn_link['url'];
								$a_title = $btn_title['title'];
								$a_target = $btn_link['target'];

								$target = (isset($v['a_target']) != '') ? 'target="'. isset($v['a_target']) .'"' : '';
							}
							$img_url = wp_get_attachment_url( $v['item_image'],'full' );
							$out .= ' <div class="offers-item">';
							   $out .= '<div class="item-inner">';
								   $out .= '<div class="item-photo" data-background="'. $img_url .'"></div>';
								   $out .= '<div class="item-desc">';
                                       if ( isset($v['item_heading'])   !== '' ){$out .= ''.grandium_element( $v['item_heading'], $tag='h3', $class='', $twlineh, $twsize, $twcolor ).''; }
                                       if ( isset($v['item_desc'])   !== '' ){$out .= ''.grandium_element( $v['item_desc'], $tag='p', $class='', $dwlineh, $dwsize, $dwcolor ).''; }

									    if ( isset($v['link'])){ $out .= '<a href="'. esc_url($a_href) . '" '. esc_attr($target) . ' class="btn-link">'. $a_title . '</a>'; }
								   $out .= '</div>';
							   $out .= '</div>';
							$out .= '</div>';

						}

					$out .= ' </div>
                <!-- Offers Content End -->
            </div>
        </div>
    </div>
    <!-- Section Offers End -->';

 return $out;
}
add_shortcode('grandium_offers', 'grandium_offers_vc');


/*-----------------------------------------------------------------------------------*/
/*	LATEST BLOG
/*-----------------------------------------------------------------------------------*/
function grandium_blog_vc($atts){
	extract(shortcode_atts(array(
        'css'            	=> '',
        'section_id'        => '',
        'read'        		=> '',
        'heading'    		=> '',
        'label'    			=> '',
        'description'    	=> '',
        'posts'          	=> '8',
        'categories'     	=> 'all',
        'order'     		=> 'DESC',
        'orderby'     		=> 'date',
        'excerpt_size'   	=> '50',
        'btntitle'   	    => '',
        'autoplay'            => '',
        'speed'               => '',
        'timeout'             => '',
        'lgitems'             => '',
        'mditems'             => '',
        'smitems'             => '',
    ), $atts) );

    $autoplay = $autoplay == 'yes' ? ' data-autoplay="true"' : ' data-autoplay="false"';
    $speed = $speed ? ' data-speed="'.$speed.'"' : '';
    $timeout = $timeout ? ' data-timeout="'.$timeout.'"' : '';
    $lgitems = $lgitems ? ' data-lgitems="'.$lgitems.'"' : ' data-lgitems="4"';
    $mditems = $mditems ? ' data-mditems="'.$mditems.'"' : ' data-mditems="3"';
    $smitems = $smitems ? ' data-smitems="'.$smitems.'"' : ' data-smitems="2"';

    global $post;
	$grandium_args = array(
		'post_type'         => 'post',
		'posts_per_page'    => $posts,
		'order'             => $order,
		'orderby'           => $orderby,
		'post_status'       => 'publish'
    );
    if($categories != 'all'){
    	$str = $categories;
    	$arr = explode(',', $str);
		$grandium_args['tax_query'][] = array(
			'taxonomy' 	    => 'category',
			'field' 	    => 'slug',
			'terms' 	    => $arr
		);
	}

	$css_class 	= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
	$id 		= ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
	$out .= '<!-- Section Blog -->';
	$out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="widget-blog-carousel">';
            $out .= '<div class="wrapper-full-inner">';

                $out .= '<!-- Blog Title -->';
				$out .= '<div class="widget-title">';
					$out .= '<h5>'. $label .'</h5>';
					$out .= '<h2>'. $heading .'</h2>';
					$out .= '<p>'. $description .'</p>';
                $out .= '</div>';
                $out .= '<!-- Blog Title End -->';

                $out .= '<!-- Blog Carousel -->';
                $out .= '<div class="widget-carousel owl-carousel owl-theme"'.$autoplay.$speed.$timeout.$mditems.$smitems.'>';

				$grandium_blog_query = new WP_Query($grandium_args);
				if( $grandium_blog_query->have_posts() ) :
				while ($grandium_blog_query->have_posts()) : $grandium_blog_query->the_post();

					$thumb 		= get_post_thumbnail_id();
					$img_url 	= wp_get_attachment_url( $thumb,'full' );
					$image 		= aq_resize( $img_url, 319, 319, true, true, true );

					$post_format = '';

					// gallery formats
					if ( has_post_format( 'gallery' )) {

						 $slideimage = rwmb_meta( 'grandium_gallery_image', 'type=image_advanced' );

						$post_format .='<div class="media-gallery">';
							$post_format .='<div class="media-carousel owl-carousel owl-theme owl-type1">';
							 foreach ( $slideimage as $image ) {
								$slide_image = aq_resize( $image['full_url'], 319, 319, true, true, true );
								$post_format .='<a href="'. get_permalink().'" data-background="'.$slide_image.'"></a>';
							 }
							$post_format .='</div>';
						$post_format .='</div>';

					} else if ( has_post_format( 'video' )) {

						$video_embed = rwmb_meta( 'grandium_video_embed', 'type=textarea' );
						$post_format .=' <div class="media-video video-full">';
							$post_format .=''. $video_embed . '';
						$post_format .='</div>';

					} else if ( has_post_format( 'standart' )) {

						$post_format .='<div class="media-photo">';
						  $post_format .=' <a href="'. get_permalink().'" data-background="'. $image . '"></a>  ';
						$post_format .='</div>';

					} else if ( get_post_format() == false ) {
						$post_format .='<div class="media-photo">';
						   $post_format .=' <a href="'. get_permalink().'" data-background="'. $image . '"></a>  ';
						$post_format .='</div>';

					} else   {
						$post_format .='<div class="media-photo">';
                               $post_format .=' <a href="'. get_permalink().'" data-background="'. $image . '"></a>  ';
                            $post_format .='</div>';
					}

					//	post format return
                    $out .= '<div class="blog-item">';

                        $out .= '<div class="item-media">';
                            $out .= '<div class="item-date"><b>' . get_the_time('j') . '</b>' . get_the_time('F') . '</div>';

							$out .= $post_format;


                        $out .= '</div>';
					//	post format return end

					//	post format description
                        $out .= '<div class="item-desc">';
                            $out .= '<h3><a href="'. get_permalink().'">' . get_the_title() . '</a></h3>';
                            $out .= '<h5>' . get_the_author() . '</h5>';
                            $out .= '<p>' . substr(get_the_excerpt(), 0, $excerpt_size) . '</p>';
							$read_text = ( $read == '' ) ? ''. esc_html__('READ MORE','grandium').'' : ''.esc_html($read).'';
                            $out .= '<a href="'. get_permalink().'" class="btn-link">'. $read_text . '</a>';
                        $out .= '</div>';
                    $out .= '</div>';

					endwhile;
					wp_reset_query();
				endif;

                $out .= '</div>
                <!-- Blog Carousel End -->
            </div>
        </div>
    </div>
    <!-- Section Blog End -->';

	return $out;
}
add_shortcode('grandium_blog', 'grandium_blog_vc');


/*-----------------------------------------------------------------------------------*/
/*	SPONSOR grandium
/*-----------------------------------------------------------------------------------*/

function grandium_testimonials_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
	'css'            	=> '',
	'section_id'        => '',
	'heading'    		=> '',
	'label'    			=> '',
	'description'    	=> '',
	'link'       		=> '',
	'item_heading'      => '',
	'item_desc'      	=> '',
	'item_company'      => '',
	'spon_img'       	=> '',
	'i_width'       	=> '80',
	'i_height'       	=> '80',
	'testi'           	=> '',
    'autoplay'            => '',
    'speed'               => '',
    'timeout'             => '',
    'mditems'             => '',
    'smitems'             => '',
    ), $atts) );

    $autoplay = $autoplay == 'yes' ? ' data-autoplay="true"' : ' data-autoplay="false"';
    $speed = $speed ? ' data-speed="'.$speed.'"' : '';
    $timeout = $timeout ? ' data-timeout="'.$timeout.'"' : '';
    $mditems = $mditems ? ' data-mditems="'.$mditems.'"' : ' data-mditems="3"';
    $smitems = $smitems ? ' data-smitems="'.$smitems.'"' : ' data-smitems="2"';

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';
	$testi_items = (array) vc_param_group_parse_atts( $testi );

	$out = '';
	$out .= '<!-- Section testimonials -->';
	$out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="widget-testimonials-carousel">';
            $out .= '<div class="wrapper-inner">';

                $out .= '<!-- testimonials Title -->';
				$out .= '<div class="widget-title">';
					$out .= '<h5>'. $label .'</h5>';
					$out .= '<h2>'. $heading .'</h2>';
					$out .= '<p>'. $description .'</p>';
                $out .= '</div>';
                $out .= '<!-- testimonials Title End -->';

                  $out .= '<!-- Testimonials Carousel -->';
                  $out .= '<div class="widget-carousel owl-carousel owl-theme"'.$autoplay.$speed.$timeout.$mditems.$smitems.'>';

					foreach ( $testi_items as $v ) {

						$img_url = wp_get_attachment_url( $v['spon_img'],'full' );
						if ( isset($v['i_width'] ) && isset($v['i_height']) ){
							$image   = aq_resize( $img_url, $v['i_width'], $v['i_height'], true, true, true );
						}
						if ( isset($v['link'])){
							$btn_link = vc_build_link($v['link']) ;
							$btn_title = vc_build_link($v['link']) ;
							$a_href = $btn_link['url'];
							$a_title = $btn_title['title'];
							$a_target = $btn_link['target'];
						}

						$out .= '<div class="testimonials-item">';
							  $out .= '<div class="item-comment">';
								 if ( isset( $v['item_desc'] ) !='' ){ $out .= ''.$v['item_desc'].''; }
							  $out .= '</div>';
							  $out .= '<div class="item-customer">';

							if ( isset($v['link'])){ 	$out .= '<a href="'. esc_url($a_href) . '" target="'. $a_target .'">'; }
								if ( isset($v['i_width']) && isset($v['i_height']) ){
									$out .= '<div class="customer-photo" data-background="'. esc_url($image) . '"></div>';
								} else {
									$out .= '<div class="customer-photo" data-background="'. esc_url($img_url) . '"></div>';
								}
							if ( isset($v['link'])){ $out .= '</a>'; }

								if ( isset( $v['item_heading'] ) !='' ){ $out .= '<h5>'.$v['item_heading'].'</h5>'; }
								if ( isset( $v['item_company'] ) !='' ){$out .= '<h6>'.$v['item_company'].'</h6>'; }
							  $out .= '</div>';
						$out .= ' </div>';
					}

                  $out .= '</div>';
                  $out .= '<!-- Testimonials Carousel End -->';
              $out .= '</div>';
          $out .= '</div>';
      $out .= '</div>';
      $out .= '<!-- Section Testimonials End -->';

 return $out;
}
add_shortcode('grandium_testimonials', 'grandium_testimonials_vc');


/*-----------------------------------------------------------------------------------*/
/*	TEAM ITEM
/*-----------------------------------------------------------------------------------*/

function grandium_team_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'        => '',
        'css'               => '',
        'label'             => '',
        'heading'           => '',
        'description'       => '',

        'team_img'          => '',
        'team_social'       => '',
        'link'       		=> '',
        'links'       		=> '',
        'icon_name'         => '',
        'sociallink'        => '',

        'team_items'    	=> '',
        'item_heading'      => '',
        'item_desc'         => '',

        's_n_1'         	=> '',
        's_n_2'         	=> '',
        's_n_3'         	=> '',
        's_n_4'         	=> '',
        's_n_5'         	=> '',
        's_u_1'         	=> '',
        's_u_2'         	=> '',
        's_u_3'         	=> '',
        's_u_4'         	=> '',
        's_u_5'         	=> '',

        'slineh'            => '',
        'ssize'             => '',
        'scolor'            => '',
        'tlineh'            => '',
        'tsize'             => '',
        'tcolor'            => '',
        'dlineh'            => '',
        'dsize'             => '',
        'dcolor'            => '',
        'stlineh'           => '',
        'stsize'            => '',
        'stcolor'           => '',
        'ttlineh'           => '',
        'ttsize'            => '',
        'ttcolor'           => '',
    ), $atts) );

	$team_item = (array) vc_param_group_parse_atts($team_items);
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
	$out .= '<!-- Section Team -->';
    $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="widget-team-carousel">';
            $out .= '<div class="wrapper-inner">';

               $out .= ' <!-- Team Title -->';
               $out .= '<div class="widget-title">';

               if ( isset($label)   !== '' ){$out .= ''.grandium_element( $label, $tag='h5', $class='', $slineh, $ssize, $scolor ).''; }
               if ( isset($heading)   !== '' ){$out .= ''.grandium_element( $heading, $tag='h2', $class='', $tlineh, $tsize, $tcolor ).''; }
               if ( isset($description)   !== '' ){$out .= ''.grandium_element( $description, $tag='p', $class='', $dlineh, $dsize, $dcolor ).''; }

               $out .= '</div>';
               $out .= '<!-- Team Title End -->';

               $out .= '<!-- Team Carousel -->';
               $out .= '<div class="widget-carousel owl-carousel owl-theme">';

					foreach ( $team_item as $v ) {

						$out .= '<div class="team-item">';
							$out .= '<div class="item-inner">';

                        if ( isset($v['links'])){
      							$btn_link = vc_build_link($v['links']) ;
      							$btn_target = vc_build_link($v['links']) ;
      							$a_href = $btn_link['url'];
      							$a_target = $btn_target['target'];
      						}

                                $href         = ($a_href != '')   ? 'href="'. $a_href . '"' : '';
                                $target       = ($a_target != '') ? 'target="'. $a_target . '"' : '';

   								$out .= '<div class="item-photo">';
   									$image = wp_get_attachment_url( $v['team_img'], 'full' );
                              if ( $a_href !=''){
      								$out .= '<a '. $href . ''. $target .' data-background="'. esc_url($image) . '"></a>';
                              } else {
      									$out .= '<a data-background="'. esc_url($image) . '"></a>';
                              }
   								$out .= '</div>';

								$out .= '<div class="item-desc">';

                                        if ( isset($v['item_heading'])   !== '' ){$out .= ''.grandium_element( $v['item_heading'], $tag='h3', $class='', $stlineh, $stsize, $stcolor ).''; }
                                        if ( isset($v['item_desc'])   !== '' ){$out .= ''.grandium_element( $v['item_desc'], $tag='h4', $class='', $ttlineh, $ttsize, $ttcolor ).''; }

									$out .= '<ul>';
										if ( isset( $v['s_n_1'] ) !='' ){ $out .= '<li><a href="'.$v['s_u_1'] . '"><i class="fa fa-'.$v['s_n_1'] . '"></i></a></li>'; }
										if ( isset( $v['s_n_2'] ) !='' ){ $out .= '<li><a href="'.$v['s_u_2'] . '"><i class="fa fa-'.$v['s_n_2'] . '"></i></a></li>'; }
										if ( isset( $v['s_n_3'] ) !='' ){ $out .= '<li><a href="'.$v['s_u_3'] . '"><i class="fa fa-'.$v['s_n_3'] . '"></i></a></li>'; }
										if ( isset( $v['s_n_4'] ) !='' ){ $out .= '<li><a href="'.$v['s_u_4'] . '"><i class="fa fa-'.$v['s_n_4'] . '"></i></a></li>'; }
										if ( isset( $v['s_n_5'] ) !='' ){ $out .= '<li><a href="'.$v['s_u_5'] . '"><i class="fa fa-'.$v['s_n_5'] . '"></i></a></li>'; }
									$out .= '</ul>';

								$out .= '</div>';
							$out .= '</div>';
						$out .= '</div>';
					}

                $out .= '</div>
                <!-- Team Carousel End -->
            </div>
        </div>
    </div>
    <!-- Section Team End -->';

 return $out;
}
add_shortcode('grandium_team', 'grandium_team_vc');


/*-----------------------------------------------------------------------------------*/
/*	Features
/*-----------------------------------------------------------------------------------*/

function grandium_features_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'           	=> '',
        'css'                  	=> '',
        'label'              	=> '',
        'heading'              	=> '',
        'description'          	=> '',
        'features_img'          => '',
        'features_items'    	=> '',
        'item_heading'          => '',

        'slineh'            => '',
        'ssize'             => '',
        'scolor'            => '',
        'tlineh'            => '',
        'tsize'             => '',
        'tcolor'            => '',
        'dlineh'            => '',
        'dsize'             => '',
        'dcolor'            => '',
        'ftlineh'           => '',
        'ftsize'            => '',
        'ftcolor'           => '',
    ), $atts) );

	$features_item = (array) vc_param_group_parse_atts($features_items);
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
	$out .= '<!-- Section Features -->';
	$out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
         $out .= '<div class="widget-features-carousel">';
             $out .= '<div class="wrapper-inner">';

                 $out .= '<!-- Features Title -->';
                 $out .= '<div class="widget-title">';
                 if ( isset($label)   !== '' ){$out .= ''.grandium_element( $label, $tag='h5', $class='', $slineh, $ssize, $scolor ).''; }
                 if ( isset($heading)   !== '' ){$out .= ''.grandium_element( $heading, $tag='h2', $class='', $tlineh, $tsize, $tcolor ).''; }
                 if ( isset($description)   !== '' ){$out .= ''.grandium_element( $description, $tag='p', $class='', $dlineh, $dsize, $dcolor ).''; }
					$out .= '</div>';
                 $out .= '<!-- Features Title End -->';

                 $out .= '<!-- Features Carousel -->';
                 $out .= '<div class="widget-carousel owl-carousel owl-theme">';

					foreach ( $features_item as $v ) {
						$out .= '<div class="features-item">';
							$image = wp_get_attachment_url( $v['features_img'], 'full' );
							$out .= '<div class="item-inner" data-background="'. esc_url($image) . '">';
              if ( isset($v['item_heading'])   !== '' ){$out .= ''.grandium_element( $v['item_heading'], $tag='h5', $class='', $ftlineh, $ftsize, $ftcolor ).''; }

							$out .= '</div>';
						$out .= '</div>';
					}
                $out .= '</div>
                <!-- Features Carousel End -->
            </div>
        </div>
    </div>
    <!-- Section Features End -->';

 return $out;
}
add_shortcode('grandium_features', 'grandium_features_vc');


/*-----------------------------------------------------------------------------------*/
/*	TIMELINE grandium
/*-----------------------------------------------------------------------------------*/

function grandium_timeline_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
		'section_id'           	=> '',
		'css'                  	=> '',
		'heading'              	=> '',
		'description'          	=> '',
		'label'          		=> '',

		'timeline_items'    	=> '',
		'item_time'          	=> '',
		'item_heading'          => '',
		'item_desc'          	=> ''
    ), $atts) );

	$timeline_item = (array) vc_param_group_parse_atts($timeline_items);
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
	$out .= '<!-- Section History -->';
   	$out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="widget-history-timeline">';
            $out .= '<div class="wrapper-inner">';

               $out .= ' <!-- History Title -->';
               $out .= ' <div class="widget-title">';
					$out .= '<h5>'. $label .'</h5>';
					$out .= '<h2>'. $heading .'</h2>';
					$out .= '<p>'. $description .'</p>';
                $out .= '</div>';
                $out .= '<!-- History Title End -->';

                $out .= '<!-- History Content -->';
                $out .= '<div class="widget-inner">';
                    $out .= '<ul>';
						foreach ( $timeline_item as $v ) {
							$out .= '<li>';
								if ( isset( $v['item_time'] ) !='' ){  $out .= '<h5>'.$v['item_time'].'</h5>'; }
								if ( isset( $v['item_heading'] ) !='' ){$out .= '<h3>'.$v['item_heading'].'</h3>'; }
								if ( isset( $v['item_desc'] ) !='' ){$out .= '<p>'.$v['item_desc'].'</p>'; }
						   $out .= ' </li>';
						}
                   $out .= ' </ul>
                </div>
                <!-- History Content End -->
            </div>
        </div>
    </div>
    <!-- Section History End -->';

 return $out;
}
add_shortcode('grandium_timeline', 'grandium_timeline_vc');

/*-----------------------------------------------------------------------------------*/
/*	SERVICES
/*-----------------------------------------------------------------------------------*/

function grandium_services_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
        'section_id'           	=> '',
        'css'                  	=> '',
        'features_img'          => '',
        'features_img_small'    => '',
        'links'    				=> '',
        'services_items'    	=> '',
        'item_heading'          => '',
        'item_content'          => '',
        'item_desc'          	=> '',

        'slineh'            => '',
        'ssize'             => '',
        'scolor'            => '',
        'tlineh'            => '',
        'tsize'             => '',
        'tcolor'            => '',
        'dlineh'            => '',
        'dsize'             => '',
        'dcolor'            => '',
        'bgcolor'           => '',
        'bsize'             => '',
        'bcolor'            => '',
    ), $atts) );

	$services_item = (array) vc_param_group_parse_atts($services_items);
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
	$out .= '<!-- Section Services -->';
  	$out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="wrapper-inner">';
            $out .= '<!-- Services List -->';
            $out .= '<div class="widget-services-list">';

			foreach ( $services_item as $v ) {

				if ( isset($v['links'])){
					$btn_link 		= vc_build_link($v['links']) ;
					$btn_title 		= vc_build_link($v['links']) ;
					$btn_target 	= vc_build_link($v['links']) ;
					$a_href 		= $btn_link['url'];
					$a_title 		= $btn_title['title'];
					$a_target 		= $btn_target['target'];

				$href 	= ( $a_href != '' )   ? 'href="'. $a_href .'"' : '';
				$target = ($a_target != '') ? 'target="'. esc_attr($a_target) . '"' : '';
				}
				$image 			= wp_get_attachment_url( $v['features_img'], 'full' );
				$image_small 	= wp_get_attachment_url( $v['features_img_small'], 'full' );

                $out .= '<div class="services-item">';

                    $out .= '<div class="item-photo">';

                        if ( $image !='' ){  $out .= '<div class="photo-big" data-background="'. esc_url($image) . '"></div>'; }
                        if ( $image_small !='' ){  $out .= '<div class="photo-small" data-background="'. esc_url($image_small) . '"></div>'; }

                        if ( $a_title !='' ){
                          $b_color         = ( $bcolor    !='' ) ? ' color:'.esc_attr( $bcolor ).';' : '';
                          $b_size          = ( $bsize     !=''  ) ? ' font-size:'.esc_attr( $bsize ).';' : '';
                          $b_bgcolor       = ( $bgcolor   !='' ) ? ' background-color:'.esc_attr( $bgcolor ).';' : '';
                          $titlestyle      = ( $b_color   !='' || $b_size !='' || $b_bgcolor !='' ) ? ' style="'.$b_color.$b_size.$b_bgcolor.'"' : '';
                          $out .= '<a '.$href . ''. $target .' '.$titlestyle.' class="btn btn-default">'. $a_title .'</a>';
                        }

                    $out .= '</div>';

                    $out .= '<div class="item-desc">';
                    if ( isset($v['item_heading'])   !== '' ){$out .= ''.grandium_element( $v['item_heading'], $tag='h5', $class='', $slineh, $ssize, $scolor ).''; }
                    if ( isset($v['item_desc'])   !== '' ){$out .= ''.grandium_element( $v['item_desc'], $tag='h2', $class='', $tlineh, $tsize, $tcolor ).''; }
                    if ( isset($v['item_content'])   !== '' ){$out .= ''.grandium_element( $v['item_content'], $tag='p', $class='', $dlineh, $dsize, $tcolor ).''; }


                    $out .= '</div>';
                $out .= '</div>';
			}

           $out .= ' </div>
            <!-- Services List End -->
        </div>
    </div>
    <!-- Section Services End -->';

 return $out;
}
add_shortcode('grandium_services', 'grandium_services_vc');

/*-----------------------------------------------------------------------------------*/
/*	PORTFOLIO
/*-----------------------------------------------------------------------------------*/
function grandium_portfolio_vc($atts){
	extract(shortcode_atts(array(
		'section_id'       	   => '',
		'css'              	   => '',
		'all'              	   => '',
		'posts'                => '16',
		'order'                => 'DESC',
		'orderby'              => 'date',
		'portfolio_category'   => 'all'
    ), $atts));

	global $post;
	$args = array(
		'post_type'			=> 'portfolio',
		'posts_per_page'	=> $posts,
		'order' 			=> $order,
		'orderby'			=> $orderby,
		'post_status' 		=> 'publish'
	);
    if($portfolio_category != 'all'){
    	$str = $portfolio_category;
    	$arr = explode(',', $str);
		$args['tax_query'][] = array(
      'taxonomy' 	=> 'portfolio_category',
      'field' 	=> 'slug',
       'terms' 	=> $arr );
	}

	$count =0;

	$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
	$id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

    $out = '';
	$out .= '<!-- Section Gallery -->';
    $out .= '<div class="section '. esc_attr($css_class) . '" '.$id.'>';
        $out .= '<div class="wrapper-inner">';

            $out .= '<!-- Gallery Filter -->';
            $out .= '<div class="widget-filter-top">';
                $out .= '<ul>';
					$all_text = ( $all == '' ) ? ''. esc_html__('ALL PHOTOS','grandium').'' : ''.esc_html($all).'';
					$out .= '<li class="active"><a href="#" data-filter="*">'. $all_text . '</a></li>';

					$terms = get_terms("portfolio_category");
					$count = count($terms);
					if ( $count > 0 ){
						foreach ( $terms as $term ) {
							$termname = strtolower($term->name);
							$termname = strtolower($term->name);
							$termname = str_replace(' ', '-', $termname);
							$out .='<li><a href="#" data-filter=".'.$term->slug.'">'.$term->name.'</a></li>';
						}
					}
                $out .= '</ul>';
            $out .= '</div>';
            $out .= '<!-- Gallery Filter End -->';

            $out .= '<!-- Gallery List -->';
            $out .= '<div class="widget-gallery-grid">';
                $out .= '<div class="row">';

				$grandium_port_query = new WP_Query($args);
				if( $grandium_port_query->have_posts() ) :
				while ($grandium_port_query->have_posts()) : $grandium_port_query->the_post();
				$count++;

					$terms = get_the_terms( $post->ID, 'portfolio_category' );
					if ( $terms && ! is_wp_error( $terms ) ) :
						$links = array();
						foreach ( $terms as $term )
						{
							$links[] = $term->slug;
						}
						$links = str_replace(' ', '-', $links);
						$tax = join( " ", $links );
					else :
					$tax = '';
					endif;

					$thumb = get_post_thumbnail_id();
					$img_url = wp_get_attachment_url( $thumb,'full' );

                    $out .= '<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 isotope-item '. strtolower($tax).'">';
                        $out .= '<div class="gallery-item">';
                            $out .= '<a href="'. esc_url($img_url) . '" data-background="'. esc_url($img_url) . '" title="'.get_the_title().'" class="grandium-popup-gallery"></a>';
                        $out .= '</div>';
                    $out .= '</div>';


					endwhile;
					wp_reset_postdata();
					endif;

                $out .= '</div>';
            $out .= '</div>';
            $out .= '<!-- Gallery List End -->';
        $out .= '</div>';
    $out .= '</div>';
    $out .= '<!-- Section Gallery End -->';

  return $out;
}
add_shortcode('grandium_portfolio', 'grandium_portfolio_vc');


/*-----------------------------------------------------------------------------------*/
/*	rooms list
/*-----------------------------------------------------------------------------------*/
function grandium_rooms_vc($atts){
	extract(
		shortcode_atts(
			array(
				'section_id'       	   => '',
				'css'              	   => '',
				'read'                 => '',
				'build_query'         => '',
				'excerpt_size'         => '141',
			),
			$atts
		)
	);

	$css_class 	= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
	$id 		= ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

    $out = '';
	 $out .= '<!-- Section Rooms -->';
     $out .= '<div class="section '. esc_attr($css_class) . '" '.$id.'>';
         $out .= '<div class="wrapper-inner">';
            $out .= ' <!-- Rooms List -->';
             $out .= '<div class="widget-rooms-list">';


            global $post,$wp_query;

            list($args) = vc_build_loop_query($build_query);


			$grandium_rooms_query 	= new WP_Query($args);
			if( $grandium_rooms_query->have_posts() ) :
			    while ($grandium_rooms_query->have_posts()) :
			        $grandium_rooms_query->the_post();

        			$grandium_features_list		= 	rwmb_meta( 'grandium_features_list');
        			$grandium_name				= 	rwmb_meta( 'grandium_name');
        			$grandium_label				= 	rwmb_meta( 'grandium_label');
        			$grandium_rate				= 	rwmb_meta( 'grandium_rate');
        			$grandium_currency			= 	rwmb_meta( 'grandium_currency');
        			$grandium_price			    = 	rwmb_meta( 'grandium_price');
        			$grandium_sale_price		= 	rwmb_meta( 'grandium_sale_price');
        			$grandium_button_type	    = 	rwmb_meta( 'grandium_button_type');
        			$target	                    = 	rwmb_meta( 'grandium_room_target');
        			$grandium_btn_link		    = 	rwmb_meta( 'grandium_btn_link');
        			$grandium_btn_text		    = 	rwmb_meta( 'grandium_btn_title');

        			$thumb 						= get_post_thumbnail_id();
        			$img_url 					= wp_get_attachment_url( $thumb,'full' );
        			$image   					= aq_resize( $img_url, 600, 600, true, true, true );


                 $out .= '<div class="rooms-item">';

                     $out .= '<div class="item-photo">';
                         $out .= '<a href="'. get_permalink() .'" data-background="'. esc_url($image) . '"></a>';
                     $out .= '</div>';

                     $out .= '<div class="item-desc">';
                         $out .= '<h2><a href="'. get_permalink() .'">' . get_the_title() . '</a></h2>';
                         $out .= '<p>' . substr(get_the_excerpt(), 0, $excerpt_size) . '</p>';
                         $out .= '<div class="desc-features">';
                             $out .= '<ul>';
							 	if ( !empty($grandium_features_list) ) {
    							 	foreach ( $grandium_features_list as $item ) {
    									$out .= '<li><i class="fa fa-check"></i> '. $item . '</li>';
    								}
                                }
                            $out .= ' </ul>';
                         $out .= '</div>';
                     $out .= '</div>';

                     $out .= '<div class="item-price">';
                         $out .= '<div class="price-inner">';
                             if( $grandium_rate !='0' ) { $out .= '<i class="fa fa-star-'. $grandium_rate . '"></i>'; }
                             $out .= '<h3>'. $grandium_currency . ' '. $grandium_sale_price . '</h3>';
                             $out .= '<h4>'. $grandium_currency . ' '. $grandium_price . '</h4>';
                             $out .= '<h5>'. $grandium_label . '</h5>';
	                          $read_text = ( $read == '' ) ? ''. esc_html__('ROOM DETAIL','grandium').'' : ''.esc_html($read).'';


                           if( $grandium_button_type =='permalink' ) {
                              $out .= '<a href="'. get_permalink() .'" class="btn">'. $read_text . '</a>';
                           } else {
                              $out .= '<a href="'. $grandium_btn_link . '" class="btn" target="'. $target . '">'. $grandium_btn_text . '</a>';
                           }


                         $out .= '</div>';
                     $out .= '</div>';

                 $out .= '</div>';


			endwhile;
			wp_reset_postdata();
			endif;

            $out .= ' </div>';
			$out .= '<!-- Rooms List End -->';

			$out .= '<!-- Pager -->';
            $out .= '<div class="widget-pager">';
                the_posts_pagination(
					array(
						'prev_text'          => esc_html__( 'Previous page', 'grandium' ),
						'next_text'          => esc_html__( 'Next page', 'grandium' ),
						'before_page_number' => '<span class="meta-nav screen-reader-text"></span>',
					)
				);
			$out .= ' </div>';
			$out .= '<!-- Pager End -->';

        $out .= ' </div>';
     $out .= '</div>';
     $out .= '<!-- Section Rooms End -->';

  return $out;
}
add_shortcode('grandium_rooms', 'grandium_rooms_vc');

/*-----------------------------------------------------------------------------------*/
/*	CONTACTS
/*-----------------------------------------------------------------------------------*/
function grandium_contact_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
		'section_id'          	=> '',
		'css'                 	=> '',
		'heading'             	=> '',
		'comment_area'        	=> '1',
		'comment_items'        	=> '',
		'contact_items'        	=> '',
		'c_item_name'           => '',
		'c_icon_name'           => '',
		'read'           		=> 'MAP',
		'links'           		=> '',
		'form'          		=> '1',
		'form_head'          	=> '',
		'form_desc'           	=> '',
		'item_head'        		=> '',
		'first_line'        	=> '',
		'second_line'        	=> '',
		'item_mail'        		=> ''
    ), $atts) );

	$comment_item 	= (array) vc_param_group_parse_atts($comment_items);
	$contact_item 	= (array) vc_param_group_parse_atts($contact_items);
    $css_class 		= apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id 			= ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
	$out .= '<!-- Section Contact -->';
    $out .= '<div class="section '. esc_attr($css_class) . '" '. $id .'>';
        $out .= '<div class="wrapper-inner">';
            $out .= '<div class="row">';
				// 1
                $out .= '<div class="col-lg-6">';
                    $out .= '<!-- Contact Info -->';
                    $out .= '<div class="widget-contact-info">';
                        $out .= '<ul>';

							foreach ( $contact_item as $v ) {
								$out .= '<li>';
									if ( isset( $v['item_head'] ) !='' )	{ $out .= '<h5>'.$v['item_head'].'</h5>'; }
									$out .= '<ul>';
										if ( isset( $v['first_line'] ) !='' )	{ $out .= '<li>'.$v['first_line'].'</li>'; }
										if ( isset( $v['second_line'] ) !='' )	{ $out .= '<li>'.$v['second_line'].'</li>'; }
										if ( isset( $v['item_mail'] ) !='' )	{ $out .= '<li><a href="mailto:'.$v['item_mail'].'">'.$v['item_mail'].'</a></li> ';}
									$out .= '</ul>';
								$out .= '</li>';
							}

                        $out .= '</ul>';
                    $out .= '</div>';
                    $out .= '<!-- Contact Info End -->';
                $out .= '</div>';

				if( $form =='1' ) {
				// 2
				$out .= ' <div class="col-lg-6">';
                    $out .= '<!-- Contact Form -->';
                    $out .= '<div class="widget-contact-form">';
                        $out .= '<h5>'. $form_head  . '</h5>';
                        $out .= '<p>'.  $form_desc  . '</p>';
                        $out .= '<div class="data-form">';
                           $out .= ''.do_shortcode($content).'';
                        $out .= '</div>';
                    $out .= '</div>';
                   $out .= ' <!-- Contact Form End -->';
				$out .= ' </div>';
				}

				if( $comment_area =='1' ) {
			    // 3
                $out .= '<div class="col-lg-12">';
                    $out .= '<!-- Contact Review -->';
                    $out .= '<div class="widget-contact-review">';
                        $out .= '<div class="row">';

                        foreach ( $comment_item as $item ) {

                            $link    = !empty($item['links']) ? vc_build_link($item['links']) : '';
                            $href    = $link ? ' href="'.$link['url'].'"' : '';
                            $a_title = $link ? ' title="'.$link['title'].'"' : '';
                            $target  = $link ? ' target="'.$link['target'].'"' : '';

                            $icon = (isset($item['c_icon_name']) != '') ? $item['c_icon_name'] : '';
                            $name = (isset($item['c_item_name']) != '') ? $item['c_item_name'] : '';

                            $out .= '<div class="col-lg-3 col-md-6 col-sm-6">';
                                $out .= '<div class="review-item">';
                                    $out .= '<div class="item-inner">';
                                        if( $href ) {
                                            $out .= '<a'.$href.$target.$a_title.'><i class="'.$icon.'"></i> '.$name.'</a>';
                                        } else {
                                            $out .= '<i class="'.$icon.'"></i> '.$name;
                                        }
                                    $out .= '</div>';
                               $out .= ' </div>';
                            $out .= '</div>';
                        }

                       $out .= ' </div>';
                   $out .= ' </div>';
                $out .= '</div>'; // end review
				}

            $out .= '</div>';
        $out .= '</div>';
    $out .= '</div>';
    $out .= '<!-- Section Contact End -->';

	return $out;
}
add_shortcode('grandium_contact', 'grandium_contact_vc');

/*-----------------------------------------------------------------------------------*/
/*	TIMELINE grandium
/*-----------------------------------------------------------------------------------*/

function grandium_heading_type_vc( $atts, $content = null ) {
    extract( shortcode_atts(array(
		'section_id'           	=> '',
		'css'                  	=> '',
		'heading'              	=> '',
		'description'          	=> ''
    ), $atts) );

    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ),  $atts );
    $id = ($section_id != '') ? 'id="'. esc_attr($section_id) . '"' : '';

	$out = '';
	$out .= '<section '. $id .' class="row '. esc_attr($css_class) . '">';
       $out .= '<div class="container">';

			$out .= '<div class="row section-header wow fadeInUp">';
          if ( isset($heading)   !== '' ){$out .= ''.grandium_element( $heading, $tag='h2', $class='', $hlineh, $hsize, $hcolor ).''; }
          if ( isset($description)   !== '' ){$out .= ''.grandium_element( $description, $tag='p', $class='', $dlineh, $dsize, $dcolor ).''; }
            $out .= '</div>';

		$out .= '</div>'; // container
	$out .= '</section>';

 return $out;
}
add_shortcode('grandium_heading_type', 'grandium_heading_type_vc');
