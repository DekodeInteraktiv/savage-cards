<?php
/**
 * Classnames class
 *
 * @package Savage
 */

declare( strict_types = 1 );
namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Savage\\Classnames' ) ) {

	/**
	 * Default card class.
	 *
	 * @extends Card base class.
	 */
	class Classnames {
		/**
		 * Hold the class instance.
		 *
		 * @var Classnames $_instance
		 */
		private static $_instance = null;

		/**
		 * Hold the classnames.
		 *
		 * @var array $classnames
		 */
		private $_classnames = [];

		/**
		 * Card constructor.
		 */
		public function __construct() {
			$this->classnames = [];

			/*
			 * Reset at 0 to be sure reset function is runned before we start
			 * adding card classnames.
			 */
			add_action( 'savage/card/template/init', [ $this, 'reset_classnames' ], 0 );
		}

		/**
		 * Get Classnames instance.
		 *
		 * @return Classnames Classnames instance.
		 */
		public static function get_instance() : Classnames {

			if ( null === self::$_instance ) {
				self::$_instance = new Classnames();
			}

			return self::$_instance;
		}

		/**
		 * Reset
		 */
		public function reset_classnames() {
			$this->classnames = [];
		}

		/**
		 * Add classname
		 *
		 * @param string $classname Classname.
		 */
		public function add_classname( string $classname ) {
			$this->classnames[] = $classname;
		}

		/**
		 * Get classnames
		 *
		 * @return array Classnames.
		 */
		public function get_classnames() : array {
			return $this->classnames;
		}
	}
}
