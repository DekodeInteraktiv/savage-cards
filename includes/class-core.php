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
	 * Plugin base directory
	 *
	 * @var string $dir
	 */
	public $dir;

	/**
	 * Plugin base URL
	 *
	 * @var string $url
	 */
	public $url;

	/**
	 * Cards.
	 *
	 * @var array $_cards
	 */
	private $_cards = [];

	/**
	 * Hold the class instance.
	 *
	 * @var Core $_instance
	 */
	private static $_instance = null;

	/**
	 * Core constructor.
	 *
	 * @param string $dir Plugin base directory.
	 * @param string $url Plugin base url.
	 * @return void
	 */
	private function __construct( $dir, $url ) {
		$this->dir = $dir;
		$this->url = $url;

		// Load text domain on plugins_loaded.
		add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

		// Register card field group.
		add_action( 'acf/include_fields', [ $this, 'register_card_meta_field_group' ] );

		// Register cards.
		add_action( 'plugins_loaded', [ $this, 'register_cards' ] );

	}

	/**
	 * Get Core instance.
	 *
	 * @param string $dir Plugin base directory.
	 * @param string $url Plugin base url.
	 * @return Core Core instance.
	 */
	public static function get_instance( string $dir = '', string $url = '' ) : Core {

		if ( null === self::$_instance ) {
			self::$_instance = new Core( $dir, $url );
		}

		return self::$_instance;
	}

	/**
	 * Load textdomain for translations.
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'savage-cards', false, $this->dir . '/languages' );
	}

	/**
	 * Register default field group for card meta.
	 *
	 * @return void
	 */
	public function register_card_meta_field_group() {

		$fields_before = apply_filters( 'savage/card/field_group/fields_before', [] );
		$fields_after = apply_filters( 'savage/card/field_group/fields_after', [] );

		$meta_fields = [
			[
				'key' => 'savage_card_field_image_type',
				'label' => __( 'Image on card', 'savage-cards' ),
				'name' => 'savage_image_type',
				'type' => 'select',
				'required' => 0,
				'choices' => apply_filters( 'savage/card/meta/image_types', [
					'featured' => __( 'Use featured image', 'savage-cards' ),
					'alternative' => __( 'Use alternative image', 'savage-cards' ),
					'none' => __( 'No image', 'savage-cards' ),
				] ),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'return_format' => 'value',
			],
			[
				'key' => 'savage_card_field_image',
				'label' => __( 'Alternative image:', 'savage-cards' ),
				'name' => 'savage_image',
				'type' => 'image',
				'required' => 1,
				'conditional_logic' => [
					[
						[
							'field' => 'savage_card_field_image_type',
							'operator' => '==',
							'value' => 'alternative',
						],
					],
				],
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			],
			[
				'key' => 'savage_card_field_title',
				'label' => __( 'Override title', 'savage-cards' ),
				'name' => 'savage_title',
				'type' => 'text',
				'instructions' => __( 'Leave empty to use post title', 'savage-cards' ),
				'required' => 0,
				'maxlength' => '',
			],
			[
				'key' => 'savage_card_field_tagline_type',
				'label' => __( 'Tagline', 'savage-cards' ),
				'name' => 'savage_tagline',
				'type' => 'select',
				'required' => 0,
				'choices' => apply_filters( 'savage/card/meta/tagline_types', [
					'none' => __( 'Ingen', 'savage-cards' ),
					'auto' => __( 'Auto', 'savage-cards' ),
					'manual' => __( 'Manuell', 'savage-cards' ),
				] ),
				'allow_null' => 0,
				'multiple' => 0,
				'ui' => 0,
				'ajax' => 0,
				'return_format' => 'value',
			],
			[
				'key' => 'savage_card_field_tagline_text',
				'label' => '',
				'name' => 'savage_tagline_text',
				'type' => 'text',
				//'instructions' => __( 'Max xx chars.', 'savage-cards' ),
				'required' => 1,
				'conditional_logic' => [
					[
						[
							'field' => 'savage_card_field_tagline_type',
							'operator' => '==',
							'value' => 'manual',
						],
					],
				],
				'maxlength' => '',
			],
			[
				'key' => 'savage_card_field_excerpt',
				'label' => __( 'Excerpt', 'savage-cards' ),
				'name' => 'savage_excerpt',
				'type' => 'textarea',
				'instructions' => __( 'Max xx chars.', 'savage-cards' ),
				'required' => 0,
				'maxlength' => '',
				'rows' => 3,
				'new_lines' => '',
			],
			[
				'key' => 'savage_card_field_more_text',
				'label' => __( 'Link text', 'savage-cards' ),
				'name' => 'savage_link_title',
				'type' => 'text',
				'instructions' => __( '"Read more"-text', 'savage-cards' ),
				'required' => 0,
				'conditional_logic' => 0,
				'maxlength' => '',
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

		// Include custom fields before and after flexible content field.
		$field_group_fields = array_merge( $fields_before, $meta_fields, $fields_after );

		acf_add_local_field_group(
			[
				'key'            => 'savage_card_meta_fields',
				'title'          => __( 'Card content', 'savage-cards' ),
				'fields'         => $field_group_fields,
				'location' => apply_filters( 'savage/card/meta/locations', $location ),
				'position' => 'side',
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
}
