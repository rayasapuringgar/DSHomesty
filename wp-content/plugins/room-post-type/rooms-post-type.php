<?php
/**
 * Rooms Post Type
 *
 * @wordpress-plugin
 * Plugin Name: Rooms Manager
 * Plugin URI:  http://www.ninetheme.com/
 * Description: Enables a rooms post type and taxonomies.
 * Version:     1.1.0
 * Author:      Ninetheme
 * Author URI:  http://www.ninetheme.com/
 * Text Domain: roomsposttype
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Required files for registering the post type and taxonomies.
require plugin_dir_path( __FILE__ ) . 'includes/class-rooms-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/interface-gamajo-rooms-registerable.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-rooms-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-rooms-taxonomy.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-rooms-post-type-post-type.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-rooms-post-type-taxonomy-category.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-rooms-post-type-taxonomy-tag.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-rooms-post-type-registrations.php';

// Instantiate registration class, so we can add it as a dependency to main plugin class.
$rooms_post_type_registrations = new Rooms_Post_Type_Registrations;

// Instantiate main plugin file, so activation callback does not need to be static.
$rooms_post_type = new Rooms_Post_Type( $rooms_post_type_registrations );

// Register callback that is fired when the plugin is activated.
register_activation_hook( __FILE__, array( $rooms_post_type, 'activate' ) );

// Initialise registrations for post-activation requests.
$rooms_post_type_registrations->init();

add_action( 'init', 'rooms_post_type_init', 100 );
/**
 * Adds styling to the dashboard for the post type and adds rooms posts
 * to the "At a Glance" metabox.
 *
 * Adds custom taxonomy body classes to rooms posts on the front end.
 *
 * @since 0.8.3
 */
function rooms_post_type_init() {
	if ( is_admin() ) {
		global $rooms_post_type_admin, $rooms_post_type_registrations;
		// Loads for users viewing the WordPress dashboard
		if ( ! class_exists( 'Gamajoroomsrooms_Dashboard_Glancer' ) ) {
			require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-rooms-dashboard-glancer.php';  // WP 3.8
		}
		require plugin_dir_path( __FILE__ ) . 'includes/class-rooms-post-type-admin.php';
		$rooms_post_type_admin = new Rooms_Post_Type_Admin( $rooms_post_type_registrations );
		$rooms_post_type_admin->init();
	} else {
		// Loads for users viewing the front end
		if ( apply_filters( 'roomsposttype_add_taxonomy_terms_classes', true ) ) {
			if ( ! class_exists( 'Gamajorooms_Single_Entry_Term_Body_Classes' ) ) {
				require plugin_dir_path( __FILE__ ) . 'includes/class-gamajo-rooms-single-entry-term-body-classes.php';
			}
			$rooms_post_type_body_classes = new Gamajorooms_Single_Entry_Term_Body_Classes;
			$rooms_post_type_body_classes->init( 'rooms' );
		}
	}
}
