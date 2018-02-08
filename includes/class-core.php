<?php
/**
 * Core savage class.
 *
 * @package Savage
 */

declare( strict_types = 1 );
namespace Dekode\Savage;

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

/**
 * Core savage class.
 */
class Core {
	/**
	 * Cards.
	 *
	 * @var array $_cards
	 */
	private $_cards = [];

	/**
	 * Default card layouts.
	 *
	 * @var array $_default_card_post_types
	 */
	private $_default_card_post_types = [];

	/**
	 * Default card layout.
	 *
	 * @var string $_default_card
	 */
	private $_default_card = '';

	/**
	 * Default card components
	 *
	 * @var array $_components
	 */
	private $_components = [];

	/**
	 * Hold the class instance.
	 *
	 * @var Core $_instance
	 */
	private static $_instance = null;

	/**
	 * Core constructor.
	 *
	 * @return void
	 */
	private function __construct() {
		add_action( 'init', [ $this, 'init' ] );

		// Register card field group.
		add_action( 'acf/include_fields', [ $this, 'register_card_meta_field_group' ] );

		// Register cards (need to be after plugins/themes has applied savage card filter).
		add_action( 'plugins_loaded', [ $this, 'register_cards' ], 50 );

		add_action( 'savage/register_cards', [ $this, 'register_core_cards' ] );
	}

	/**
	 * Get Core instance.
	 *
	 * @return Core Core instance.
	 */
	public static function get_instance() : Core {

		if ( null === self::$_instance ) {
			self::$_instance = new Core();
		}

		return self::$_instance;
	}

	/**
	 * Init
	 *
	 * @return void
	 */
	public function init() {
		// Allow people overwriting as late as posible to funcitons can be
		// overwritten in the theme.
		require_once 'component-functions.php';

		$this->_default_card            = (string) apply_filters( 'savage/card/default_card', 'defaultcard' );
		$this->_default_card_post_types = (array) apply_filters( 'savage/card/default_card_post_types', [ 'post', 'page' ] );

		$this->_components = (array) apply_filters(
			'savage/card/default_components', [
				'image'      => [
					'filter'   => 'header',
					'callback' => 'savage_card_image',
					'priority' => 10,
				],
				'label'      => [
					'filter'   => 'body',
					'callback' => 'savage_card_label',
					'priority' => 10,
				],
				'heading'    => [
					'filter'   => 'body',
					'callback' => 'savage_card_heading',
					'priority' => 20,
				],
				'excerpt'    => [
					'filter'   => 'body',
					'callback' => 'savage_card_excerpt',
					'priority' => 30,
				],
				'linkteaser' => [
					'filter'   => 'body',
					'callback' => 'savage_card_linkteaser',
					'priority' => 40,
				],
				'link'       => [
					'filter'   => 'footer',
					'callback' => 'savage_card_link',
					'priority' => 10,
				],
			]
		);

		$this->register_card_components();
	}

	/**
	 * Register core cards
	 *
	 * @return void
	 */
	public function register_core_cards() {
		require_once 'class-defaultcard.php';
		require_once 'class-customcard.php';

		savage_register_card( new \Dekode\Savage\DefaultCard() );
		savage_register_card( new \Dekode\Savage\CustomCard() );
	}

	/**
	 * Register default field group for card meta.
	 *
	 * @return void
	 */
	public function register_card_meta_field_group() {

		$fields_before = apply_filters( 'savage/card/field_group/fields_before', [] );
		$fields_after  = apply_filters( 'savage/card/field_group/fields_after', [] );

		$meta_fields = [
			[
				'key'           => 'savage_card_field_image_type',
				'label'         => __( 'Image on card', 'savage-cards' ),
				'name'          => 'savage_image_type',
				'type'          => 'select',
				'required'      => 0,
				'choices'       => apply_filters(
					'savage/card/meta/image_types', [
						'featured'    => __( 'Use featured image', 'savage-cards' ),
						'alternative' => __( 'Use alternative image', 'savage-cards' ),
						'none'        => __( 'No image', 'savage-cards' ),
					]
				),
				'allow_null'    => 0,
				'multiple'      => 0,
				'ui'            => 0,
				'ajax'          => 0,
				'return_format' => 'value',
			],
			[
				'key'               => 'savage_card_field_image',
				'label'             => __( 'Alternative image:', 'savage-cards' ),
				'name'              => 'savage_image',
				'type'              => 'image',
				'required'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'savage_card_field_image_type',
							'operator' => '==',
							'value'    => 'alternative',
						],
					],
				],
				'return_format'     => 'array',
				'preview_size'      => 'thumbnail',
				'library'           => 'all',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => '',
			],
			[
				'key'           => 'savage_card_field_label_type',
				'label'         => __( 'Label', 'savage-cards' ),
				'name'          => 'savage_label',
				'type'          => 'select',
				'required'      => 0,
				'choices'       => [
					'auto'   => __( 'Auto', 'savage-cards' ),
					'manual' => __( 'Manual', 'savage-cards' ),
					'none'   => __( 'No label', 'savage-cards' ),
				],
				'allow_null'    => 0,
				'multiple'      => 0,
				'ui'            => 0,
				'ajax'          => 0,
				'return_format' => 'value',
			],
			[
				'key'               => 'savage_card_field_label_text',
				'label'             => '',
				'instructions'      => __( 'Add label text here', 'savage-cards' ),
				'name'              => 'savage_label_text',
				'type'              => 'text',
				'required'          => 0,
				'conditional_logic' => [
					[
						[
							'field'    => 'savage_card_field_label_type',
							'operator' => '==',
							'value'    => 'manual',
						],
					],
				],
				'maxlength'         => '',
			],
			[
				'key'          => 'savage_card_field_title',
				'label'        => __( 'Override title', 'savage-cards' ),
				'name'         => 'savage_title',
				'type'         => 'text',
				'instructions' => __( 'Leave empty to use post title', 'savage-cards' ),
				'required'     => 0,
				'maxlength'    => '',
			],
			[
				'key'          => 'savage_card_field_excerpt',
				'label'        => __( 'Excerpt', 'savage-cards' ),
				'name'         => 'savage_excerpt',
				'type'         => 'textarea',
				'instructions' => __( 'Max xx chars.', 'savage-cards' ),
				'required'     => 0,
				'maxlength'    => '',
				'rows'         => 3,
				'new_lines'    => '',
			],
			[
				'key'               => 'savage_card_field_more_text',
				'label'             => __( 'Link text', 'savage-cards' ),
				'name'              => 'savage_link_title',
				'type'              => 'text',
				'instructions'      => __( '"Read more"-text', 'savage-cards' ),
				'required'          => 0,
				'conditional_logic' => 0,
				'maxlength'         => '',
			],
		];

		$location = [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				],
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
				],
			],
		];

		// Include custom fields before and after default fields.
		$field_group_fields = array_merge( $fields_before, $meta_fields, $fields_after );

		acf_add_local_field_group(
			[
				'key'            => 'savage_card_meta_fields',
				'title'          => __( 'Card content', 'savage-cards' ),
				'fields'         => $field_group_fields,
				'location'       => apply_filters( 'savage/card/meta/locations', $location ),
				'position'       => 'side',
				'hide_on_screen' => apply_filters( 'savage/card/field_group/hide_on_screen', [] ),
			]
		);
	}

	/**
	 * Register cards from filter into core plugin.
	 *
	 * @return void
	 */
	public function register_cards() {

		do_action( 'savage/register_cards' );

		foreach ( apply_filters( 'savage/cards', [] ) as $card ) {

			if ( ! ( $card instanceof Card ) ) {
				$card = new $card();
			}

			$this->_cards[ $card->name ] = $card;
		}

		do_action( 'savage/cards_registered' );
	}

	/**
	 * Get component
	 *
	 * @param string       $key Component key.
	 * @param array|string $component Component or component key.
	 */
	private function get_component( $key, $component ) {
		if ( is_array( $component ) && isset( $this->_components[ $key ] ) ) {
			return wp_parse_args( $component, $this->_components[ $key ] );
		} elseif ( isset( $this->_components[ $component ] ) ) {
			return $this->_components[ $component ];
		}

		return false;
	}

	/**
	 * Register card components
	 */
	public function register_card_components() {
		foreach ( $this->_cards as $name => $card ) {
			if ( isset( $card->components ) ) {
				foreach ( $card->components as $key => $component ) {
					$valid_component = $this->get_component( $key, $component );
					if ( $valid_component && function_exists( $valid_component['callback'] ) ) {
						add_action( 'savage/card/template/' . $valid_component['filter'] . '/' . $name, $valid_component['callback'], $valid_component['priority'] );
					}
				}
			}
		}
	}

	/**
	 * Get cards.
	 *
	 * @param string $type Card type.
	 */
	public function get_card( $type ) {
		if ( in_array( $type, $this->_default_card_post_types, true ) ) {
			$type = $this->_default_card;
		}

		return isset( $this->_cards[ $type ] ) ? $this->_cards[ $type ] : false;
	}
}
