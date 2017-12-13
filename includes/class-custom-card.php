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

			add_action( 'savage/card/register_post_type/custom_card', [ $this, 'register_card_post_type' ] );

			parent::__construct();
		}

		/**
		 * Register post type
		 *
		 * @package Savage
		 */
		public function register_card_post_type() {
		}

		/**
		 * Field definitions for card.
		 *
		 * @return array $fields Fields for this module
		 */
		public function get_fields() : array {
			return [];
		}
	}
}
