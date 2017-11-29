<?php
/**
 * Cards setup class
 *
 * @package Savage
 */

namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Savage\\Cards' ) ) {

	/**
	 * Card setup
	 *
	 * @extends Modules base class.
	 */
	class Cards {

		/**
		 * Static Singleton Holder
		 *
		 * @var self
		 */
		protected static $instance;

		/**
		 * Get (and instantiate, if necessary) the instance of the class
		 *
		 * @return self
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Initializes plugin.
		 */
		public function __construct() {
			require_once 'custom-card.php';
		}
	}
}
