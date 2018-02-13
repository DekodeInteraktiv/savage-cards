<?php
/**
 * Custom Card class
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
	 * Custom card class.
	 *
	 * @extends Card base class.
	 */
	class CustomCard extends Card {
		/**
		 * Post type key
		 *
		 * @var string $post_type
		 */
		private $post_type;

		/**
		 * Card constructor.
		 */
		public function __construct() {
			$this->components = [
				'image',
				'heading',
				'excerpt',
			];

			$this->post_type = 'savage_custom_card';
			$this->register_card_post_type();
			add_filter( 'acf/fields/wysiwyg/toolbars', [ $this, 'append_card_toolbar' ] );
			add_action( 'acf/include_fields', [ $this, 'register_field_group' ] );

			add_action( 'savage/card/template/footer/' . $this->post_type, [ $this, 'template_link' ], 10 );

			parent::__construct( $this->post_type );
		}

		/**
		 * Register post type
		 *
		 * @package Savage
		 */
		public function register_card_post_type() {

			register_post_type( $this->post_type, [
				'labels'              => [
					'name'               => esc_html_x( 'Custom cards', 'post type general name', 'savage-cards' ),
					'singular_name'      => esc_html_x( 'Custom cards', 'post type singular name', 'savage-cards' ),
					'menu_name'          => esc_html_x( 'Custom cards', 'admin menu', 'savage-cards' ),
					'name_admin_bar'     => esc_html_x( 'Custom cards', 'add new on admin bar', 'savage-cards' ),
					'add_new'            => esc_html__( 'Add new', 'savage-cards' ),
					'add_new_item'       => esc_html__( 'Add', 'savage-cards' ),
					'new_item'           => esc_html__( 'Add', 'savage-cards' ),
					'edit_item'          => esc_html__( 'Edit', 'savage-cards' ),
					'view_item'          => esc_html__( 'Show', 'savage-cards' ),
					'all_items'          => esc_html__( 'Custom cards', 'savage-cards' ),
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
		 * Register custom card field group
		 *
		 * @package Savage
		 */
		public function register_field_group() {

			acf_add_local_field_group(
				[
					'key'      => $this->post_type . '_group',
					'title'    => __( 'Card content', 'savage-cards' ),
					'fields'   => [
						[
							'key'           => $this->field_key . '_link',
							'label'         => __( 'Card link', 'savage-cards' ),
							'name'          => 'card_link',
							'type'          => 'link',
							'instructions'  => '',
							'required'      => 1,
							'return_format' => 'array',
						],
						[
							'key'               => $this->field_key . '_background',
							'label'             => __( 'Card background color', 'savage-cards' ),
							'name'              => 'card_background',
							'type'              => 'select',
							'instructions'      => '',
							'conditional_logic' => 0,
							'choices'           => apply_filters(
								'savage/card/custom/bg_color_options', [
									'bg_default' => __( 'Default', 'savage-cards' ),
								]
							),
							'default_value'     => [],
							'ui'                => 0,
							'ajax'              => 0,
							'return_format'     => 'value',
						],
						[
							'key'          => $this->field_key . '_flex',
							'label'        => __( 'Card fields', 'savage-cards' ),
							'name'         => 'card_content_flex',
							'type'         => 'flexible_content',
							'instructions' => '',
							'required'     => 0,
							'layouts'      => [
								[
									'key'        => $this->field_key . '_flex_standard',
									'name'       => 'card_standard',
									'label'      => __( 'Standard', 'savage-cards' ),
									'display'    => 'block',
									'sub_fields' => [
										[
											'key'          => $this->field_key . '_flex_standard_tagline',
											'label'        => __( 'Custom card tagline', 'savage-cards' ),
											'name'         => 'tagline',
											'type'         => 'text',
											'instructions' => '',
											'required'     => 0,
											'conditional_logic' => 0,
											'wrapper'      => [
												'width' => '60',
											],
											'default_value' => '',
											'placeholder'  => '',
											'maxlength'    => '',
										],
										[
											'key'          => $this->field_key . '_flex_standard_title',
											'label'        => __( 'Custom card title', 'savage-cards' ),
											'name'         => 'title',
											'type'         => 'text',
											'instructions' => '',
											'required'     => 1,
											'wrapper'      => [
												'width' => '60',
											],
											'default_value' => '',
											'placeholder'  => '',
											'prepend'      => '',
											'append'       => '',
											'maxlength'    => '',
										],
										[
											'key'          => $this->field_key . '_flex_standard_text',
											'label'        => __( 'Custom card text', 'savage-cards' ),
											'name'         => 'text',
											'type'         => 'textarea',
											'instructions' => '',
											'maxlength'    => '',
											'rows'         => 2,
											'new_lines'    => '',
										],
									],
									'min'        => '',
									'max'        => '',
								],
							],
							'button_label' => __( 'Select a card type', 'savage-cards' ),
							'min'          => 0,
							'max'          => 1,
						],
					],
					'location' => [
						[
							[
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => $this->post_type,
							],
						],
					],
				]
			);
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

		/**
		 * Custom card template link
		 *
		 * @param array $args Component args.
		 */
		public function template_link( $args ) {
			$link = get_post_meta( $args['id'], 'card_link', true );

			if ( ! empty( $link ) ) {
				savage_card_component( 'link', $link );
			}
		}

	}
}
