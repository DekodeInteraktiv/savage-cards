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

			register_post_type( 'savage_custom_card' , [
				'labels' => [
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
				'public' => false,
				'publicly_queryable' => false,
				'exclude_from_search' => true,
				'show_in_nav_menus' => false,
				'show_ui' => true,
				'show_in_menu' => true,
				'has_archive' => false,
				'rewrite' => false,
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 'title', 'revisions', 'thumbnail' ),
				'menu_icon' => 'dashicons-portfolio',
			] );
		}

		/**
		 * Register manual card field group
		 *
		 * @package Savage
		 */
		public function register_field_group() {

			acf_add_local_field_group( [
				'key' => 'savage_custom_card_group',
				'title' => __( 'Card content', 'savage-cards' ),
				'fields' => [
					[
						'key' => $this->field_key . '_background',
						'label' => __( 'Card background', 'savage-cards' ),
						'name' => 'card_background',
						'type' => 'select',
						'instructions' => '',
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '50',
						],
						'choices' => [
							'bg_default' => __( 'Default', 'savage-cards' ),
							'bg_color' => __( 'Background color', 'savage-cards' ),
						],
						'default_value' => [],
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
					],
					[
						'key' => $this->field_key . '_color',
						'label' => __( 'Select color', 'savage-cards' ),
						'name' => 'bg_color',
						'type' => 'select',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => [
							[
								[
									'field' => $this->field_key . '_background',
									'operator' => '==',
									'value' => 'bg_color',
								],
							],
						],
						'wrapper' => [
							'width' => '50',
						],
						'choices' => apply_filters( 'savage/card/custom/bg_color_options', [] ),
						'default_value' => [],
						'ui' => 0,
						'ajax' => 0,
						'return_format' => 'value',
					],
					[
						'key' => $this->field_key . '_link',
						'label' => __( 'Card link', 'savage-cards' ),
						'name' => 'card_link',
						'type' => 'link',
						'instructions' => '',
						'required' => 1,
						'return_format' => 'array',
					],
					[
						'key' => $this->field_key . '_flex',
						'label' => __( 'Card content', 'savage-cards' ),
						'name' => 'card_content_flex',
						'type' => 'flexible_content',
						'instructions' => '',
						'required' => 1,
						'layouts' => [
							[
								'key' => $this->field_key . '_flex_standard',
								'name' => 'card_standard',
								'label' => __( 'Standard', 'savage-cards' ),
								'display' => 'block',
								'sub_fields' => [
									[
										'key' => $this->field_key . '_flex_standard_img',
										'label' => __( 'Bilde', 'savage-cards' ),
										'name' => 'image',
										'type' => 'button_group',
										'instructions' => __( 'Uses featured image', 'savage-cards' ),
										'required' => 0,
										'choices' => apply_filters( 'savage/card/custom/image_options', [
											'false' => __( 'Uten bilde', 'savage-cards' ),
											'true' => __( 'Med bilde', 'savage-cards' ),
										]),
										'allow_null' => 0,
										'layout' => 'horizontal',
										'return_format' => 'value',
									],
									[
										'key' => $this->field_key . '_flex_standard_tagline',
										'label' => __( 'Tagline', 'savage-cards' ),
										'name' => 'tagline',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => [
											'width' => '60',
										],
										'default_value' => '',
										'placeholder' => '',
										'maxlength' => '',
									],
									[
										'key' => $this->field_key . '_flex_standard_title',
										'label' => __( 'Tittel', 'savage-cards' ),
										'name' => 'title',
										'type' => 'text',
										'instructions' => '',
										'required' => 1,
										'wrapper' => [
											'width' => '60',
										],
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									],
									[
										'key' => $this->field_key . '_flex_standard_text',
										'label' => __( 'Tekst', 'savage-cards' ),
										'name' => 'text',
										'type' => 'textarea',
										'instructions' => '',
										'maxlength' => '',
										'rows' => 2,
										'new_lines' => '',
									],
								],
								'min' => '',
								'max' => '',
							],
						],
						'button_label' => __( 'Velg type kort', 'savage-cards' ),
						'min' => 1,
						'max' => 1,
					],
				],
				'location' => [
					[
						[
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'savage_custom_card',
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
