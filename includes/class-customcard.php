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

			$this->post_type = 'savage_custom_card';
			$this->register_card_post_type();
			add_filter( 'acf/fields/wysiwyg/toolbars', [ $this, 'append_card_toolbar' ] );
			add_action( 'acf/include_fields', [ $this, 'register_field_group' ] );

			add_action( 'savage/card/template/header/' . $this->post_type, [ $this, 'template_header' ] );
			add_action( 'savage/card/template/body/' . $this->post_type, [ $this, 'template_body' ] );
			add_action( 'savage/card/template/footer/' . $this->post_type, [ $this, 'template_footer' ] );

			parent::__construct( $this->post_type );
		}

		/**
		 * Register post type
		 *
		 * @package Savage
		 */
		public function register_card_post_type() {

			register_post_type(
				$this->post_type, [
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
				]
			);
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
							'label'        => __( 'Card content', 'savage-cards' ),
							'name'         => 'card_content_flex',
							'type'         => 'flexible_content',
							'instructions' => __( 'If layouts are added, layout content overrides card meta fields', 'savage-cards' ),
							'required'     => 0,
							'layouts'      => apply_filters(
								'savage/card/custom/layouts', [
									[
										'key'        => $this->field_key . '_flex_standard',
										'name'       => 'card_content',
										'label'      => __( 'Editor', 'savage-cards' ),
										'display'    => 'block',
										'sub_fields' => [
											[
												'key'     => $this->field_key . '_flex_editor_content',
												'type'    => 'wysiwyg',
												'name'    => 'content',
												'label'   => '',
												'tabs'    => apply_filters( 'savage/card/custom/layout/editor/tabs', 'all' ),
												'media_upload' => apply_filters( 'savage/card/custom/layout/editor/allow_media_upload', 0 ),
												'toolbar' => apply_filters( 'savage/card/custom/layout/editor/toolbar', 'savage_card_toolbar' ),
											],
										],
										'min'        => '',
										'max'        => '',
									],
								]
							),
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
		 *
		 * @return array $toolbars Array with new toolbars.
		 */
		public function append_card_toolbar( array $toolbars ) : array {

			$toolbars['savage_card_toolbar'] = [
				1 => [
					'formatselect',
					'bold',
					'italic',
					'blockquote',
					'numlist',
					'bullist',
					'link',
					'unlink',
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
		 * Check if post has custom content
		 *
		 * @param int $id Post id.
		 * @return bool True if post has custom content, otherwise false.
		 */
		private function has_custom_content( int $id ) : bool {
			return ! empty( get_post_meta( $id, 'card_content_flex', true ) );
		}

		/**
		 * Custom card layout content
		 *
		 * @param array $args Component args.
		 */
		public function template_header( array $args ) {
			if ( ! $this->has_custom_content( $args['id'] ) ) {
				do_action( 'savage/card/template/header/custom_card_default', $args );
			}
		}

		/**
		 * Custom card layout content
		 *
		 * @param array $args Component args.
		 */
		public function template_body( array $args ) {
			if ( ! $this->has_custom_content( $args['id'] ) ) {
				do_action( 'savage/card/template/body/custom_card_default', $args );
			} else {
				$layouts = get_field( 'card_content_flex', $args['id'] );
				// Only one layout possible on a card.
				$active_layout = reset( $layouts );
				do_action( 'savage/card/custom/body/layout_content', $active_layout );

				if ( 'card_content' === $active_layout['acf_fc_layout'] ) {
					echo wp_kses_post( $active_layout['content'] );
				}

				savage_card_add_classname( 'savage-has-layout' );
				savage_card_add_classname( 'savage-layout-' . esc_attr( $active_layout['acf_fc_layout'] ) );

			}
		}

		/**
		 * Custom card template link
		 *
		 * @param array $args Component args.
		 */
		public function template_footer( array $args ) {
			if ( ! $this->has_custom_content( $args['id'] ) ) {
				do_action( 'savage/card/template/footer/custom_card_default', $args );
			} else {
				$link  = get_post_meta( $args['id'], 'card_link', true );
				$title = $this->get_link_field_title( $link );
				printf(
					'<a href="%s" class="savage-card-teaser"%s>%s</a>',
					esc_url( $link['url'] ),
					! empty( $link['target'] ) ? sprintf( ' target="%s"', esc_attr( $link['target'] ) ) : '',
					esc_html( $title )
				);
			}
		}

		/**
		 * Get post title from URL if title is empty.
		 *
		 * @param array $link_values The link field array.
		 */
		protected function get_link_field_title( $link_values ) {
			if ( empty( $link_values['title'] ) && false !== strpos( $link_values['url'], home_url() ) ) {
				$link_title = get_the_title( url_to_postid( $link_values['url'] ) );
			} elseif ( empty( $link_values['title'] ) ) {
				$link_title = $link_values['url'];
			} else {
				$link_title = $link_values['title'];
			}
			return $link_title;
		}

	}
}
