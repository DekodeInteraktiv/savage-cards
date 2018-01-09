<?php
/**
 * Custom Card (manual card) class
 *
 * @package Savage
 */

declare( strict_types = 1 );
namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Savage\\CustomCard' ) && class_exists( '\\Dekode\\Savage\\Card' ) ) {

	/**
	 * Manual card class.
	 *
	 * @extends Card base class.
	 */
	class CustomCard extends Card {

		/**
		 * Card constructor.
		 */
		public function __construct() {

			$this->register_card_post_type();
			add_filter( 'acf/fields/wysiwyg/toolbars', [ $this, 'append_card_toolbar' ] );
			add_action( 'acf/include_fields', [ $this, 'register_field_group' ] );

			parent::__construct();
		}

		/**
		 * Register post type
		 *
		 * @package Savage
		 */
		public function register_card_post_type() {

			register_post_type( 'savage_custom_card', [
				'labels'              => [
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
				],
				'public'              => false,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_in_nav_menus'   => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'has_archive'         => false,
				'rewrite'             => false,
				'capability_type'     => 'post',
				'hierarchical'        => false,
				'supports'            => [ 'title', 'revisions', 'thumbnail' ],
				'menu_icon'           => 'dashicons-portfolio',
			] );
		}

		/**
		 * Register manual card field group
		 *
		 * @package Savage
		 */
		public function register_field_group() {

			acf_add_local_field_group( [
				'key'      => 'savage_custom_card_group',
				'title'    => __( 'Card content (not ready for use)', 'savage-cards' ),
				'fields'   => [
					[
						'key'          => $this->field_key . '_title',
						'label'        => __( 'Card title', 'savage-cards' ),
						'name'         => 'card_title',
						'type'         => 'text',
						'instructions' => __( 'This is the title showed on the card', 'savage-cards' ),
						'required'     => 0,
						'maxlength'    => '',
					],
					[
						'key'           => $this->field_key . '_tagline',
						'label'         => __( 'Tagline', 'savage-cards' ),
						'name'          => 'card_tagline',
						'type'          => 'text',
						'instructions'  => '',
						'required'      => 0,
						'default_value' => '',
						'maxlength'     => '',
					],
					[
						'key'          => $this->field_key . '_formatted_text',
						'label'        => __( 'Text', 'savage-cards' ),
						'name'         => 'card_text',
						'type'         => 'wysiwyg',
						'instructions' => '',
						'required'     => 0,
						'tabs'         => apply_filters( 'savage/card/custom/content/tabs', 'all' ),
						'toolbar'      => apply_filters( 'savage/card/custom/content/toolbar', 'savage_card_toolbar' ),
						'media_upload' => 0,
					],
					[
						'key'           => $this->field_key . '_link',
						'label'         => __( 'Link to', 'savage-cards' ),
						'name'          => 'card_link',
						'type'          => 'link',
						'instructions'  => '',
						'required'      => 0,
						'wrapper'       => [
							'width' => '50',
						],
						'return_format' => 'array',
					],
				],
				'location' => [
					[
						[
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'savage_custom_card',
						],
					],
				],
			]);
		}

		/**
		 * Add custom toolbars
		 *
		 * @param array $toolbars Current Toolbars.
		 * @return array $toolbars Array with new toolbars.
		 */
		public function append_card_toolbar( array $toolbars ) : array {

			$toolbars['savage_card_toolbar'] = [
				1 => [
					'bold',
					'italic',
					'blockquote',
					'numlist',
					'bullist',
					'pastetext',
					'removeformat',
					'code',
					'undo',
					'redo',
				],
			];
			return $toolbars;
		}

	}
}
