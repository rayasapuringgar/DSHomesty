<?php
/**
 *
 * @package WordPress
 * @subpackage grandium
 * @since grandium 1.0
 *
*/

/* Set default theme constants */
define( 'grandium_THEME_VERSION', wp_get_theme()->Version );


/*************************************************
## Google Font
*************************************************/

function grandium_fonts_url() {
    $grandium_font_url = '';

    if ( 'off' !== _x( 'on', 'Google font: on or off', 'grandium' ) ) {
		$grandium_font_url = add_query_arg( 'family', urlencode( 'Playfair Display|Lato:300,400,400italic,700,700italic,900,900italic'), "//fonts.googleapis.com/css" );
    }
    return $grandium_font_url;
}

/*************************************************
## Styles and Scripts
*************************************************/


function grandium_scripts() {

	// default comment reply style
	if ( is_singular() )
	wp_enqueue_script( 'comment-reply' );

	/*** CSS FILES ***/

	// style libraries
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/css/owl.carousel.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'owl.theme.default', get_template_directory_uri() . '/css/owl.theme.default.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'jquery-ui-theme', get_template_directory_uri() . '/css/jquery-ui.theme.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific.popup.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'grandium-custom-flexslider', get_template_directory_uri() . '/js/theme-defaults/flexslider/flexslider.css', grandium_THEME_VERSION, false );

	// font family libraries
	if ( ot_get_option('grandium_typicons') == 'on' ) {
		wp_enqueue_style( 'typicons', get_template_directory_uri() . '/css/lib/typicons/src/font/typicons.min.css', grandium_THEME_VERSION, false );
	}
	if ( ot_get_option('grandium_iconic') == 'on' ) {
		wp_enqueue_style( 'openiconic', get_template_directory_uri() . '/css/lib/vc-open-iconic/vc_openiconic.css', grandium_THEME_VERSION, false );
	}
	if ( ot_get_option('grandium_linecons') == 'on' ) {
		wp_enqueue_style( 'linecons', get_template_directory_uri() . '/css/lib/vc-linecons/vc_linecons_icons.css', grandium_THEME_VERSION, false );
	}
	if ( ot_get_option('grandium_entypo') == 'on' ) {
		wp_enqueue_style( 'entypo', get_template_directory_uri() . '/css/lib/vc-entypo/vc_entypo.css', grandium_THEME_VERSION, false );
	}
	if ( ot_get_option('grandium_fonticonpicker') == 'on' ) {
		wp_enqueue_style( 'fonticonpicker', get_template_directory_uri() . '/css/default-styles/jquery.fonticonpicker.min.css', grandium_THEME_VERSION, false );
	}
	if ( ot_get_option('grandium_vcgrey') == 'on' ) {
		wp_enqueue_style( 'fonticonpicker-vcgrey', get_template_directory_uri() . '/css/default-styles/jquery.fonticonpicker.vcgrey.min.css', grandium_THEME_VERSION, false );
	}
	if ( ot_get_option('grandium_awesome') != 'off' ) {
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/default-styles/font.awesome.min.css', grandium_THEME_VERSION, false );
	}
	if ( ot_get_option('grandium_socicons') == 'on' )
		wp_enqueue_style( 'soc-icons', get_template_directory_uri() . '/css/default-styles/socicons.css', grandium_THEME_VERSION, false );

	// theme defaults
	wp_enqueue_style( 'grandium-wordpress', get_template_directory_uri() . '/css/default-styles/wordpress.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'grandium-style', get_template_directory_uri() . '/css/style.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'grandium-responsive', get_template_directory_uri() . '/css/responsive.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'grandium-woocommerce', get_template_directory_uri() . '/css/framework-woocommerce.css', grandium_THEME_VERSION, false );
	wp_enqueue_style( 'grandium-fonts-load', grandium_fonts_url(), array(), '1.0.0' );
	wp_enqueue_style( 'style', get_stylesheet_uri() );


	/*** javascript files ***/

	wp_enqueue_script( 'fonticonpicker', get_template_directory_uri() . '/js/theme-defaults/jquery.fonticonpicker.min.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'isotope', get_template_directory_uri() .  '/js/isotope.pkgd.min.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific.popup.min.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/theme-defaults/jquery.flexslider.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/theme-defaults/jquery.fitvids.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'grandium-blog-js', get_template_directory_uri() . '/js/theme-defaults/blog-script.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_enqueue_script( 'grandium-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), grandium_THEME_VERSION, true);

	// Google maps api & customization
	$grandium_map_api_key = ot_get_option( 'grandium_map_api_key' );
	$grandium_map_api_key_out = ( $grandium_map_api_key != '') ? '' . $grandium_map_api_key . '' : '';
	wp_register_script( 'google-map-api', 'https://maps.googleapis.com/maps/api/js?key='. $grandium_map_api_key_out .'', '3.0.0', true);
	wp_register_script( 'gmaps', get_template_directory_uri() .  '/js/theme-defaults/gmaps.min.js', array('jquery'), grandium_THEME_VERSION, true);
	wp_register_script( 'grandium-google-map', get_template_directory_uri() . '/js/theme-defaults/google-map.js', array('jquery'), grandium_THEME_VERSION, true);


}

add_action( 'wp_enqueue_scripts', 'grandium_scripts' );

/*************************************************
## Sanitizes data
*************************************************/

// Changing excerpt length
function grandium_excerpt_length($length) {
return 27;
}
add_filter('excerpt_length', 'grandium_excerpt_length');

// Changing excerpt more
function grandium_excerpt_more($more) {
return '...';
}
add_filter('excerpt_more', 'grandium_excerpt_more');

/*************************************************
## Sanitizes data
*************************************************/

if ( ! function_exists( 'grandium_sanitize_data' ) ) {
    function grandium_sanitize_data( $data, $type ) {

        // url
        if ( 'url' == $type ) {
            $data = esc_url( $data );
        }

        // HTML
        elseif ( 'html' == $type ) {
            $data = wp_kses( $data, array(
                    'a' => array(
                        'href'  => array(),
                        'title' => array()
                    ),
                    'br' => array(),
                    'em' => array(),
                    'strong'    => array(),
            ) );
        }

        // Videos
        elseif ( 'video' == $type ) {
            $data = wp_kses( $data, array(
                'iframe' => array(
                    'src'               => array(),
                    'type'              => array(),
                    'allowfullscreen'   => array(),
                    'allowscriptaccess' => array(),
                    'height'            => array(),
                    'width'             => array()
                ),
                'embed' => array(
                    'src'               => array(),
                    'type'              => array(),
                    'allowfullscreen'   => array(),
                    'allowscriptaccess' => array(),
                    'height'            => array(),
                    'width'             => array()
                ),
            ) );
        }
        return $data;
    }
}
/*************************************************
## OPTION TREE WEBFONTS API
*************************************************/

add_filter( 'ot_google_fonts_api_key', 'ninetheme_change_ot_google_fonts_api_key' );

function ninetheme_change_ot_google_fonts_api_key( $key ) {
  return "AIzaSyA2rMBHxvoyNhL8gTR2dITpGgXOdAiW6IQ";
}

/*************************************************
## ADMIN NOTICES
*************************************************/


function grandium_theme_activation_notice()
{
    global $current_user;

    $user_id = $current_user->ID;

    if (!get_user_meta($user_id, 'grandium_theme_activation_notice')) {
        ?>

        <div class="updated notice">
			<p>
				<?php
				echo sprintf(
					esc_html__('If you need help about demodata installation, please read docs and %s', 'grandium'),
					'<a target="_blank" href="' . esc_url('https://ninetheme.com/contact/') . '">' . esc_html__('Open a ticket', 'grandium') . '</a>
					' . esc_html__('or', 'grandium') . ' <a href="' . esc_url( wp_nonce_url( add_query_arg( 'grandium-ignore-notice', 'dismiss_admin_notices' ), 'grandium-dismiss-' . get_current_user_id() ) ) . '">' . esc_html__('Dismiss this notice', 'grandium') . '</a>');
				?>
			</p>
		</div>

<?php
    }
}


add_action('admin_notices', 'grandium_theme_activation_notice');

function grandium_theme_activation_notice_ignore()
{
    global $current_user;

    $user_id = $current_user->ID;

    if (isset($_GET['grandium-ignore-notice'])) {
        add_user_meta($user_id, 'grandium_theme_activation_notice', 'true', true);
    }
}
add_action('admin_init', 'grandium_theme_activation_notice_ignore');

/*************************************************
## Admin style and scripts
*************************************************/

function grandium_admin_style() {

	// Update CSS within in Admin
	wp_enqueue_style('grandium-custom-admin', get_template_directory_uri().'/css/admin-style/admin.css');

}
add_action('admin_enqueue_scripts', 'grandium_admin_style');


/*************************************************
## Theme option & Metaboxes & shortcodes
*************************************************/

	// VC plugin shortcode map
	if(function_exists('vc_set_as_theme')) {
		require_once get_template_directory() . '/includes/vc_admin.php';
	}

	// Metabox plugin check
	if ( ! function_exists( 'rwmb_meta' ) ) {
		function rwmb_meta( $key, $args = '', $post_id = null ) {
			return false;
		}
	}

	require_once get_template_directory() . '/includes/TinyMCE-editor-shortcode/shortcodes.php';


	// theme default breadcrumb
	require_once get_template_directory() . '/includes/breadcrumb.php';

	// custom css codes for color, sizes and more
	require_once get_template_directory() . '/includes/custom-style.php';

	// theme pagination functions
	require_once get_template_directory() . '/includes/template-tags.php';

	// page, post, custom post type metaboxes
	require_once get_template_directory() . '/includes/page-metaboxes.php';

  // Option tree controllers
    if ( ! class_exists( 'OT_Loader' )){

     function ot_get_option() {
       return false;
     }

    }

// add filter for  options panel loader
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );

// Theme options admin panel setings file
include_once get_template_directory() . '/includes/theme-options.php';


/*************************************************
## Theme Setup
*************************************************/

if ( ! isset( $content_width ) ) $content_width = 960;

function grandium_theme_setup() {

	add_editor_style ( 'custom-editor-style.css' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'post-formats', array( 'gallery' , 'video' , 'audio' ));
	add_post_type_support( 'portfolio', 'post-formats' );
	add_image_size( 'grandium_member_thumb', 650, 650, true); 		// Team Member thumbnails

	// woocommerce
	if ( class_exists( 'woocommerce' ) ) {
		add_theme_support( 'woocommerce' );
	}

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'grandium', get_template_directory() . '/languages' );

	register_nav_menus( array(
		'primary-left' 	=> esc_html__( 'Header main left Menu',  'grandium' ),
		'primary-right' => esc_html__( 'Header main right Menu', 'grandium' ),
		'footer' 		=> esc_html__( 'Footer short menu', 	 'grandium' ),
	) );

}
add_action( 'after_setup_theme', 'grandium_theme_setup' );


/*************************************************
## Widget columns
*************************************************/

function grandium_widgets_init() {

	register_sidebar( array(
		'name' => esc_html__( 'Blog Sidebar', 'grandium' ),
		'id' => 'sidebar-1',
		'description'   => esc_html__( 'These are widgets for the Blog page.','grandium' ),
		'before_widget' => '<div class="widget  %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-heading"><span>',
		'after_title'   => '</span></h5>'
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Widgetize footer', 'grandium' ),
		'id' => 'grandium_widgetize_footer',
		'description'   => esc_html__( 'These are widgets for the footer widgetize section.','grandium' ),
		'before_widget' => '<div class="col-sm-3"><div class="widget  %2$s">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<h5 class="uppercase">',
		'after_title'   => '</h5>'
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Widgetize single post right column', 'grandium' ),
		'id' => 'grandium_widgetize_single_room',
		'description'   => esc_html__( 'These are widgets for the footer widgetize section.','grandium' ),
		'before_widget' => '<div class="widget  %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="uppercase">',
		'after_title'   => '</h5>'
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Newsletter footer', 'grandium' ),
		'id' => 'grandium_newsletter_footer',
		'description'   => esc_html__( 'These are widgets for the footer newsletter section.','grandium' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => ''
	) );
	// woocommerce sidebars
	register_sidebar( array(
		'name' 			=> esc_html__( 'Woo Single Sidebar', 'grandium' ),
		'id' 			=> 'shop-single-page-sidebar',
		'description'   => esc_html__( 'These are widgets for the Blog page.','grandium' ),
		'before_widget' => '<div class="widget  %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="uppercase">',
		'after_title'   => '</h5>'
	) );
	register_sidebar( array(
		'name' 			=> esc_html__( 'Woo Shop Page Sidebar', 'grandium' ),
		'id' 			=> 'shop-page-sidebar',
		'description'   => esc_html__( 'These are widgets for the Blog page.','grandium' ),
		'before_widget' => '<div class="widget  %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="uppercase">',
		'after_title'   => '</h5>'
	) );

}
add_action( 'widgets_init', 'grandium_widgets_init' );

/*************************************************
## Include the TGM_Plugin_Activation class.
*************************************************/

require_once get_template_directory() . '/includes/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'grandium_register_required_plugins' );

function grandium_register_required_plugins() {
    $url = 'https://ninetheme.com/documentation';
    $plugins = array(
        array(
        'name' => esc_html__('Contact Form 7', "grandium"),
        'slug' => 'contact-form-7',
        ),
        array(
        'name' => esc_html__('Breadcrumb NavXT', 'grandium'),
        'slug' => 'breadcrumb-navxt',
        ),
        array(
        'name' => esc_html__('Custom Post Type Permalinks', 'grandium'),
        'slug' => 'custom-post-type-permalinks',
        ),
        array(
        'name' => esc_html__('Portfolio / Gallery Manager', "grandium"),
        'slug' => 'portfolio-post-type',
        'source' => get_template_directory() . '/plugins/portfolio-post-type.zip',
        ),
        array(
        'name' => esc_html__('Meta Box', "grandium"),
        'slug' => 'meta-box',
        'required' => true,
        ),
        array(
        'name' => esc_html__('Theme Options Panel', "grandium"),
        'slug' => 'option-tree',
        'source' => $url . '/plugins/option-tree.zip',
        'required' => true,
        ),
        array(
        'name' => esc_html__('Metabox Show/Hide', "grandium"),
        'slug' => 'meta-box-show-hide',
        'source' => $url . '/plugins/meta-box-show-hide.zip',
        'required' => true,
        ),
        array(
        'name' => esc_html__('Metabox Tabs', "grandium"),
        'slug' => 'meta-box-tabs',
        'source' => $url . '/plugins/meta-box-tabs.zip',
        'required' => true,
        ),
        array(
        'name' => esc_html__('Envato Auto Update Theme', "grandium"),
        'slug' => 'envato-market',
        'source' => $url . '/plugins/envato-market.zip',
        'required' => false,
        ),
        array(
        'name' => esc_html__('Visual Composer', "grandium"),
        'slug' => 'js_composer',
        'source' => $url . '/plugins/js_composer.zip',
        'required' => true,
        ),
        array(
        'name' => esc_html__('Revolution Slider', "grandium"),
        'slug' => 'revolution_slider',
        'source' => $url . '/plugins/revolution_slider.zip',
        'required' => false,
        ),
        array(
        'name' => esc_html__('Booked', 'grandium'),
        'slug' => 'booked',
        'source' => $url . '/plugins/booked.zip',
        'required' => false,
        ),
        array(
        'name' => esc_html__('HBook - Hotel Booking', "grandium"),
        'slug' => 'hbook',
        'source' => $url . '/plugins/hbook.zip',
        'required' => false,
        ),
        array(
        'name' =>  esc_html__('Room Post Type', "grandium"),
        'slug' => 'room-post-type',
        'source' => $url . '/plugins/rooms-post-type.zip',
        'required' => false,
        ),
        array(
        'name' => esc_html__('Grandium Shortcodes', "grandium"),
        'slug' => 'grandium-shortcodes',
        'source' => get_template_directory() . '/plugins/grandium-shortcodes.zip',
        'required' => true,
        'version' => '1.3.8',
        ),

        );

  $config = array(
		'id' => 'tgmpa',
		'default_path' => '',
		'menu' => 'tgmpa-install-plugins',
		'parent_slug' => 'themes.php',
		'capability' => 'edit_theme_options',
		'has_notices' => true,
		'dismissable' => true,
		'dismiss_msg' => '',
		'is_automatic' => true,
		'message' => '',
	);
	tgmpa( $plugins, $config );
}



/*************************************************
## Register Menu
*************************************************/

class grandium_wp_bootstrap_navwalker extends Walker_Nav_Menu {

	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" sub\">\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		 * Dividers, Headers or Disabled
		 */
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider item-has-children sub">';
		} else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider item-has-children sub">';
		} else if ( strcasecmp( $item->attr_title, 'dropdown-header item-has-children') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header item-has-children sub">' . esc_attr( $item->title );
		} else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled sub"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} else {

			$class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ( $args->has_children )
				$class_names .= ' sub item-has-children-style';

			if ( in_array( 'current-menu-item', $classes ) )
				$class_names .= ' active';

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title']  = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';

			// If item has_children add atts to a.
			if ( $args->has_children && $depth === 0 ) {
				$atts['class']			= ' sub';
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			} else {
				$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			}

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			/*
			 * Glyphicons
			 **/
			if ( ! empty( $item->attr_title ) )
				$item_output .= '<a'. $attributes .'><span class=" ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
			else
				$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ( $args->has_children && 0 === $depth ) ? ' </a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	 * Traverse elements to create list from elements.
	 **/
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( ! $element )
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_object( $args[0] ) )
           $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	/**
	 * Menu Fallback
	 **/
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id )
					$fb_output .= ' id="' . $container_id . '"';

				if ( $container_class )
					$fb_output .= ' class="' . $container_class . '"';

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id )
				$fb_output .= ' id="' . $menu_id . '"';

			if ( $menu_class )
				$fb_output .= ' class="' . $menu_class . '"';

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">' . esc_html__('Add a menu','grandium') .'</a></li>';
			$fb_output .= '</ul>';

			if ( $container )
				$fb_output .= '</' . $container . '>';

			echo wp_kses( $fb_output, grandium_allowed_html() );
		}
	}
}



/**********************************
## THEME ALLOWED HTML TAG
/**********************************/


if (! function_exists('grandium_allowed_html')) {
    function grandium_allowed_html()
    {
        $allowed_tags = array(
        'a' => array(
            'class' => array(),
            'href'  => array(),
            'rel'   => array(),
            'title' => array(),
            'target' => array(),
        ),
        'abbr' => array(
            'title' => array(),
        ),
        'iframe' => array(
            'src' => array(),
        ),
        'b' => array(),
        'br' => array(),
        'blockquote' => array(
            'cite'  => array(),
        ),
        'cite' => array(
            'title' => array(),
        ),
        'code' => array(),
        'del' => array(
            'datetime' => array(),
            'title' => array(),
        ),
        'dd' => array(),
        'div' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'dl' => array(),
        'dt' => array(),
        'em' => array(),
        'h1' => array(),
        'h2' => array(),
        'h3' => array(),
        'h4' => array(),
        'h5' => array(),
        'h6' => array(),
        'i' => array(
            'class'  => array(),
        ),
        'img' => array(
            'alt'    => array(),
            'class'  => array(),
            'height' => array(),
            'src'    => array(),
            'width'  => array(),
        ),
        'li' => array(
            'class' => array(),
        ),
        'ol' => array(
            'class' => array(),
        ),
        'p' => array(
            'class' => array(),
        ),
        'q' => array(
            'cite' => array(),
            'title' => array(),
        ),
        'span' => array(
            'class' => array(),
            'title' => array(),
            'style' => array(),
        ),
        'strike' => array(),
        'strong' => array(),
        'ul' => array(
            'class' => array(),
        ),
    );

        return $allowed_tags;
    }
}


/*************************************************
## grandium Comment
*************************************************/

	if ( ! function_exists( 'grandium_comment' ) ) {
    function grandium_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
                // Display trackbacks differently than normal comments. ?>
                <li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
                <p><strong><?php esc_html_e( 'Pingback:', 'grandium' ); ?></strong> <?php comment_author_link(); ?></p>
            <?php
            break;
            default :
                // Proceed with normal comments. ?>
                <li id="li-comment-<?php comment_ID(); ?>" class="comments">
                    <div id="comment-<?php comment_ID(); ?>" <?php comment_class( 'clr' ); ?>>
                        <span class="avatar-class">
                            <?php echo get_avatar( $comment, 50 ); ?>
                        </span><!-- .comment-author -->
                        <div class="comment-details clr who-comment">
                            <header class="comment-meta">
                                <cite class="fn name"><?php comment_author_link(); ?></cite>
                                <span class="comment-date">
                                <?php
                                    printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                                        esc_url( get_comment_link( $comment->comment_ID ) ),
                                        get_comment_time( 'c' ),
                                        sprintf( _x( '%1$s', '1: date', 'grandium' ), get_comment_date() )
                                    ); ?>
                                </span><!-- .comment-date -->
                            </header><!-- .comment-meta -->
                            <?php if ( '0' == $comment->comment_approved ) : ?>
                                <p class="comment-awaiting-moderation">
                                    <?php esc_html_e( 'Your comment is awaiting moderation.', 'grandium' ); ?>
                                </p><!-- .comment-awaiting-moderation -->
                            <?php endif; ?>
                            <div class="comment-content entry clr">
                                <?php comment_text(); ?>
                            </div><!-- .comment-content -->
                            <footer class="comment-footer clr">
                                <?php
                                // Cancel comment link
                                comment_reply_link( array_merge( $args, array(
                                    'reply_text'    => esc_html__( 'Reply', 'grandium' ) . '',
                                    'depth' => $depth,
                                    'max_depth' => $args['max_depth']
                                ) ) ); ?>
                                <?php
                                // Edit comment link
                                edit_comment_link( esc_html__( 'Edit', 'grandium' ), '<div class="edit-comment">', '</div>' ); ?>
                            </footer>
                        </div><!-- .comment-details -->
                    </div><!-- #comment-## -->
            <?php
            break;
        endswitch;
    }
}



/*************************************************
## SANITIZE MODIFIED VC-ELEMENTS OUTPUT
*************************************************/


if (!function_exists('grandium_vc_sanitize_data')) {
    function grandium_vc_sanitize_data($html_data)
    {
        return $html_data;
    }
}



/*************************************************
## THEME SETUP WIZARD
    https://github.com/richtabor/MerlinWP
*************************************************/


require_once get_parent_theme_file_path( '/includes/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/includes/merlin/class-merlin.php' );
require_once get_parent_theme_file_path( '/includes/demo-wizard-config.php' );

function grandium_merlin_local_import_files() {
	return array(
		array(

			'import_file_name'         => 'Demo Import',
            // xml data
			'local_import_file'        => get_parent_theme_file_path( 'includes/merlin/demodata/data.xml' ),
            // widget data
			'local_import_widget_file' => get_parent_theme_file_path( 'includes/merlin/demodata/widgets.wie' ),
            // option tree -> theme options
            'local_import_option_tree_file' => get_parent_theme_file_path( '/includes/merlin/demodata/optiontree.txt' ),

		)
	);
}
add_filter( 'merlin_import_files', 'grandium_merlin_local_import_files' );


/**
 * Execute custom code after the whole import has finished.
 */
function grandium_merlin_after_import_setup() {
	// Assign menus to their locations.
	$primary = get_term_by( 'name', 'Header Right menu', 'nav_menu' );
	$primary2 = get_term_by( 'name', 'Header left menu', 'nav_menu' );
	$primary3 = get_term_by( 'name', 'Footer', 'nav_menu' );

	set_theme_mod(
		'nav_menu_locations', array(
            'primary-left' => $primary->term_id,
            'primary-right' => $primary2->term_id,
            'footer' => $primary3->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Frontpage' );
	$blog_page_id  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'merlin_after_all_import', 'grandium_merlin_after_import_setup' );


add_action('init', 'do_output_buffer'); function do_output_buffer() { ob_start(); }




function grandium_merlin_generate_child_functions_php( $output, $slug ) {

    $slug_no_hyphens = strtolower( preg_replace( '#[^a-zA-Z]#', '', $slug ) );
    $output = "
    <?php
    /**
    * Theme functions and definitions.
    */
    function {$slug_no_hyphens}_child_enqueue_styles() {
    wp_enqueue_style( '{$slug}-child-style',
    get_stylesheet_directory_uri() . '/style.css');
    }
    add_action( 'wp_enqueue_scripts', '{$slug_no_hyphens}_child_enqueue_styles' );\n
    ";
    // Let's remove the tabs so that it displays nicely.
    $output = trim( preg_replace( '/\t+/', '', $output ) );
    // Filterable return.
    return $output;

}
add_filter( 'merlin_generate_child_functions_php', 'grandium_merlin_generate_child_functions_php', 10, 2 );
