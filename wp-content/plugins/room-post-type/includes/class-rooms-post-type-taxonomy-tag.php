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
 * Rooms tag taxonomy.
 *
 * @package Rooms_Post_Type
 * @author  Devin Price
 * @author  Gary Jones
 */
class Rooms_Post_Type_Taxonomy_Tag extends Gamajorooms_Taxonomy {
	/**
	 * Taxonomy ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $taxonomy = 'rooms_tag';

	/**
	 * Return taxonomy default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Taxonomy default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'                       => __( 'Rooms Tags', 'rooms-post-type' ),
			'singular_name'              => __( 'Rooms Tag', 'rooms-post-type' ),
			'menu_name'                  => __( 'Rooms Tags', 'rooms-post-type' ),
			'edit_item'                  => __( 'Edit Rooms Tag', 'rooms-post-type' ),
			'update_item'                => __( 'Update Rooms Tag', 'rooms-post-type' ),
			'add_new_item'               => __( 'Add New Rooms Tag', 'rooms-post-type' ),
			'new_item_name'              => __( 'New Rooms Tag Name', 'rooms-post-type' ),
			'parent_item'                => __( 'Parent Rooms Tag', 'rooms-post-type' ),
			'parent_item_colon'          => __( 'Parent Rooms Tag:', 'rooms-post-type' ),
			'all_items'                  => __( 'All Rooms Tags', 'rooms-post-type' ),
			'search_items'               => __( 'Search Rooms Tags', 'rooms-post-type' ),
			'popular_items'              => __( 'Popular Rooms Tags', 'rooms-post-type' ),
			'separate_items_with_commas' => __( 'Separate rooms tags with commas', 'rooms-post-type' ),
			'add_or_remove_items'        => __( 'Add or remove rooms tags', 'rooms-post-type' ),
			'choose_from_most_used'      => __( 'Choose from the most used rooms tags', 'rooms-post-type' ),
			'not_found'                  => __( 'No rooms tags found.', 'rooms-post-type' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => false,
			'rewrite'           => array( 'slug' => 'rooms_tag' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		return apply_filters( 'roomsposttype_tag_args', $args );
	}
}