<?php

/*
Plugin Name: Grandium Shortcodes
Plugin URI: http://themeforest.net/user/Ninetheme
Description: Shortcodes for Ninetheme WordPress Themes - grandium Version
Version: 1.3.8
Author: Ninetheme
Author URI: http://themeforest.net/user/Ninetheme
*/
/************************************************
## HTML heading element settings function
*************************************************/

add_action('plugins_loaded', 'grandium_vc_loaded');
function grandium_vc_loaded() {

	if ( class_exists('Vc_Manager') ) {

		// image resizer
		require_once plugin_dir_path(__FILE__) . 'aq_resizer.php';

		// shortcode functions
		require_once plugin_dir_path(__FILE__) . 'fronted.php';

	} else {

		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		deactivate_plugins(plugin_basename(__FILE__));

	}
}
