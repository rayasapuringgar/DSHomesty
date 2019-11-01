<?php
/**
 * Rooms Post Type
 *
 * @package   Rooms_Post_Type
 * @author    Devin Price
 * @author    Gary Jones
 * @license   GPL-2.0+
 * @link      http://wptheming.com/rooms-post-type/
 * @copyright 2011 Devin Price, Gary Jones
 */

/**
 * Register post types and taxonomies.
 *
 * @package Rooms_Post_Type
 * @author  Devin Price
 * @author  Gary Jones
 */
class Rooms_Post_Type_Registrations {

	public $post_type;

	public $taxonomies;

	public function init() {
		// Add the rooms post type and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 */
	public function register() {
		global $rooms_post_type_post_type, $rooms_post_type_taxonomy_category, $rooms_post_type_taxonomy_tag;

		$rooms_post_type_post_type = new Rooms_Post_Type_Post_Type;
		$rooms_post_type_post_type->register();
		$this->post_type = $rooms_post_type_post_type->get_post_type();

		$rooms_post_type_taxonomy_category = new Rooms_Post_Type_Taxonomy_Category;
		$rooms_post_type_taxonomy_category->register();
		$this->taxonomies[] = $rooms_post_type_taxonomy_category->get_taxonomy();
		register_taxonomy_for_object_type(
			$rooms_post_type_taxonomy_category->get_taxonomy(),
			$rooms_post_type_post_type->get_post_type()
		);

		$rooms_post_type_taxonomy_tag = new Rooms_Post_Type_Taxonomy_Tag;
		$rooms_post_type_taxonomy_tag->register();
		$this->taxonomies[] = $rooms_post_type_taxonomy_tag->get_taxonomy();
		register_taxonomy_for_object_type(
			$rooms_post_type_taxonomy_tag->get_taxonomy(),
			$rooms_post_type_post_type->get_post_type()
		);
	}

	/**
	 * Unregister post type and taxonomies registrations.
	 */
	public function unregister() {
		global $rooms_post_type_post_type, $rooms_post_type_taxonomy_category, $rooms_post_type_taxonomy_tag;
		$rooms_post_type_post_type->unregister();
		$this->post_type = null;

		$rooms_post_type_taxonomy_category->unregister();
		unset( $this->taxonomies[ $rooms_post_type_taxonomy_category->get_taxonomy() ] );

		$rooms_post_type_taxonomy_tag->unregister();
		unset( $this->taxonomies[ $rooms_post_type_taxonomy_tag->get_taxonomy() ] );
	}
}
