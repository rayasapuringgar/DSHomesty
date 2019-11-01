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
 * Rooms post type.
 *
 * @package Rooms_Post_Type
 * @author  Devin Price
 * @author  Gary Jones
 */
class Rooms_Post_Type_Post_Type extends Gamajorooms_Post_Type {
	/**
	 * Post type ID.
	 *
	 * @since 1.0.0
	 *
	 * @type string
	 */
	protected $post_type = 'rooms';

	/**
	 * Return post type default arguments.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type default arguments.
	 */
	protected function default_args() {
		$labels = array(
			'name'               => __( 'Rooms', 'rooms-post-type' ),
			'singular_name'      => __( 'Rooms Item', 'rooms-post-type' ),
			'menu_name'          => _x( 'Rooms', 'admin menu', 'rooms-post-type' ),
			'name_admin_bar'     => _x( 'Rooms Item', 'add new on admin bar', 'rooms-post-type' ),
			'add_new'            => __( 'Add New Item', 'rooms-post-type' ),
			'add_new_item'       => __( 'Add New Rooms Item', 'rooms-post-type' ),
			'new_item'           => __( 'Add New Rooms Item', 'rooms-post-type' ),
			'edit_item'          => __( 'Edit Rooms Item', 'rooms-post-type' ),
			'view_item'          => __( 'View Item', 'rooms-post-type' ),
			'all_items'          => __( 'All Rooms Items', 'rooms-post-type' ),
			'search_items'       => __( 'Search Rooms', 'rooms-post-type' ),
			'parent_item_colon'  => __( 'Parent Rooms Item:', 'rooms-post-type' ),
			'not_found'          => __( 'No rooms items found', 'rooms-post-type' ),
			'not_found_in_trash' => __( 'No rooms items found in trash', 'rooms-post-type' ),
		);

		$supports = array(
			'title',
			'editor',
			'excerpt',
			'thumbnail',
			'author',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'rooms', ), // Permalinks format
			'menu_position'   => 5,
			'menu_icon'       => ( version_compare( $GLOBALS['wp_version'], '3.8', '>=' ) ) ? 'dashicons-format-gallery' : false ,
			'has_archive'     => true,
		);

		return apply_filters( 'roomsposttype_args', $args );
	}

	/**
	 * Return post type updated messages.
	 *
	 * @since 1.0.0
	 *
	 * @return array Post type updated messages.
	 */
	public function messages() {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Rooms item updated.', 'rooms-post-type' ),
			2  => __( 'Custom field updated.', 'rooms-post-type' ),
			3  => __( 'Custom field deleted.', 'rooms-post-type' ),
			4  => __( 'Rooms item updated.', 'rooms-post-type' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Rooms item restored to revision from %s', 'rooms-post-type' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Rooms item published.', 'rooms-post-type' ),
			7  => __( 'Rooms item saved.', 'rooms-post-type' ),
			8  => __( 'Rooms item submitted.', 'rooms-post-type' ),
			9  => sprintf(
				__( 'Rooms item scheduled for: <strong>%1$s</strong>.', 'rooms-post-type' ),
				/* translators: Publish box date format, see http://php.net/date */
				date_i18n( __( 'M j, Y @ G:i', 'rooms-post-type' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Rooms item draft updated.', 'rooms-post-type' ),
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink         = get_permalink( $post->ID );
			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );

			$view_link    = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View rooms item', 'rooms-post-type' ) );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview rooms item', 'rooms-post-type' ) );

			$messages[1]  .= $view_link;
			$messages[6]  .= $view_link;
			$messages[9]  .= $view_link;
			$messages[8]  .= $preview_link;
			$messages[10] .= $preview_link;
		}

		return $messages;
	}
}
