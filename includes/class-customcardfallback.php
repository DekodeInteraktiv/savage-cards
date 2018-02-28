<?php
/**
 * Custom card fallback card class
 *
 * @package Savage
 */

declare( strict_types = 1 );
namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( '\\Dekode\\Savage\\CustomCardFallback' ) && class_exists( '\\Dekode\\Savage\\Card' ) ) {

	/**
	 * Custom card fallback card class.
	 *
	 * @extends Card base class.
	 */
	class CustomCardFallback extends Card {
		/**
		 * Card constructor.
		 */
		public function __construct() {
			$this->components = [
				'image',
				'body-header',
				'label',
				'heading',
				'excerpt',
				'linkteaser',
			];

			add_action( 'savage/card/template/footer/custom_fallback_card', [ $this, 'link' ], 10 );

			parent::__construct( 'custom_fallback_card' );
		}

		/**
		 * Link
		 *
		 * @param array $args Component args.
		 */
		public function link( $args ) {
			$link = get_post_meta( $args['id'], 'card_link', true );
			savage_card_component( 'link', $link );
		}
	}
}
