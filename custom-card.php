<?php
/**
 * Post type for custom cards
 *
 * @package Savage
 */

namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', __NAMESPACE__ . '\\register_card_post_type' );

/**
 * Register post type
 *
 * @package Savage
 */
function register_card_post_type() {
	register_post_type( 'custom-card' , array(
		'labels' => array(
			'name'               => esc_html_x( 'Manual cards', 'post type general name', 'savage-cards' ),
			'singular_name'      => esc_html_x( 'Manual cards', 'post type singular name', 'savage-cards' ),
			'menu_name'          => esc_html_x( 'Manual cards', 'admin menu', 'savage-cards' ),
			'name_admin_bar'     => esc_html_x( 'Manual cards', 'add new on admin bar', 'savage-cards' ),
			'add_new'            => esc_html__( 'Add new', 'savage-cards' ),
			'add_new_item'       => esc_html__( 'Add', 'savage-cards' ),
			'new_item'           => esc_html__( 'Add', 'savage-cards' ),
			'edit_item'          => esc_html__( 'Edit', 'savage-cards' ),
			'view_item'          => esc_html__( 'Show', 'savage-cards' ),
			'all_items'          => esc_html__( 'Manual cards', 'savage-cards' ),
			'search_items'       => esc_html__( 'Search', 'savage-cards' ),
			'parent_item_colon'  => esc_html__( 'Parent:', 'savage-cards' ),
			'not_found'          => esc_html__( 'Nothing found.', 'savage-cards' ),
			'not_found_in_trash' => esc_html__( 'Nothing found in trashcan.', 'savage-cards' ),
		),
		'public' => true,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'show_in_nav_menus' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'has_archive' => false,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 1,
		'supports' => array( 'title', 'revisions' ),
		'menu_icon' => 'dashicons-portfolio',
	) );
}
