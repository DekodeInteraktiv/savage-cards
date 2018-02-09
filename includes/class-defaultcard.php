<?php
/**
 * Default Card class
 *
 * @package Savage
 */

declare( strict_types = 1 );
namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Savage\\DefaultCard' ) && class_exists( '\\Dekode\\Savage\\Card' ) ) {

	/**
	 * Default card class.
	 *
	 * @extends Card base class.
	 */
	class DefaultCard extends Card {
		/**
		 * Card constructor.
		 */
		public function __construct() {
			$this->components = [
				'image',
				'icon',
				'label',
				'heading',
				'excerpt',
				'linkteaser',
				'link',
			];

			parent::__construct( 'defaultcard' );
		}
	}
}
