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
