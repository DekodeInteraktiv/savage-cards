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
		$this->_default_card            = (string) apply_filters( 'savage/default_card', 'defaultcard' );
		$this->_default_card_post_types = (array) apply_filters( 'savage/default_card_post_types', [ 'post', 'page' ] );
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
				'choices'       => apply_filters( 'savage/card/meta/image_types', [
					'featured'    => __( 'Use featured image', 'savage-cards' ),
					'alternative' => __( 'Use alternative image', 'savage-cards' ),
					'none'        => __( 'No image', 'savage-cards' ),
				] ),
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
				'key'          => 'savage_card_field_title',
				'label'        => __( 'Override title', 'savage-cards' ),
				'name'         => 'savage_title',
				'type'         => 'text',
				'instructions' => __( 'Leave empty to use post title', 'savage-cards' ),
				'required'     => 0,
				'maxlength'    => '',
			],
			[
				'key'           => 'savage_card_field_tagline_type',
				'label'         => __( 'Tagline', 'savage-cards' ),
				'name'          => 'savage_tagline',
				'type'          => 'select',
				'required'      => 0,
				'choices'       => apply_filters( 'savage/card/meta/tagline_types', [
					'none'   => __( 'No tagline', 'savage-cards' ),
					'auto'   => __( 'Auto', 'savage-cards' ),
					'manual' => __( 'Manual', 'savage-cards' ),
				] ),
				'allow_null'    => 0,
				'multiple'      => 0,
				'ui'            => 0,
				'ajax'          => 0,
				'return_format' => 'value',
			],
			[
				'key'               => 'savage_card_field_tagline_text',
				'label'             => '',
				'name'              => 'savage_tagline_text',
				'type'              => 'text',
				'required'          => 1,
				'conditional_logic' => [
					[
						[
							'field'    => 'savage_card_field_tagline_type',
							'operator' => '==',
							'value'    => 'manual',
						],
					],
				],
				'maxlength'         => '',
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

		$hide_on_screen = [
			'the_content',
			'custom_fields',
			'discussion',
			'comments',
			'revisions',
			'slug',
			'author',
			'format',
			'tags',
			'send-trackbacks',
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
				'hide_on_screen' => apply_filters( 'savage/card/field_group/hide_on_screen', $hide_on_screen ),
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
