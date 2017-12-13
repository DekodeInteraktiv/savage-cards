<?php
/**
 * Post type and field group for custom cards
 * TODO: move everything to CustomCard class
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
 */
function register_card_post_type() {
	register_post_type( 'savage-custom-card' , array(
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
		'public' => false,
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
		'supports' => array( 'title', 'revisions', 'thumbnail' ),
		'menu_icon' => 'dashicons-portfolio',
	) );
}

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group( array(
	'key' => 'group_59ef00baddca2',
	'title' => 'Kort',
	'fields' => array(
		array(
			'key' => 'field_5a296c42b5d6e',
			'label' => 'Tittel',
			'name' => 'title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a296c54b5d6f',
			'label' => 'Tagline',
			'name' => 'tagline',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a296c5eb5d70',
			'label' => 'Tekst',
			'name' => 'text',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'hogan',
			'media_upload' => 0,
			'delay' => 0,
		),
		array(
			'key' => 'field_5a296d718032f',
			'label' => 'Lenke til',
			'name' => 'link',
			'type' => 'link',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'savage-custom-card',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_59ef00baddca2',
	'title' => 'Kort',
	'fields' => array(
		array(
			'key' => 'field_5a296c42b5d6e',
			'label' => 'Tittel',
			'name' => 'title',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a296c54b5d6f',
			'label' => 'Tagline',
			'name' => 'tagline',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5a296c5eb5d70',
			'label' => 'Tekst',
			'name' => 'text',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'hogan',
			'media_upload' => 0,
			'delay' => 0,
		),
		array(
			'key' => 'field_5a296d718032f',
			'label' => 'Lenke til',
			'name' => 'link',
			'type' => 'link',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'savage-custom-card',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
