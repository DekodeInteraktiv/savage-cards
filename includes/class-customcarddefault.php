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

if ( ! class_exists( '\\Dekode\\Savage\\CustomCardDefault' ) && class_exists( '\\Dekode\\Savage\\Card' ) ) {

	/**
	 * Custom card fallback card class.
	 *
	 * @extends Card base class.
	 */
	class CustomCardDefault extends Card {
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

			add_action( 'savage/card/template/footer/custom_card_default', [ $this, 'link' ], 10 );

			parent::__construct( 'custom_card_default' );
		}

		/**
		 * Link
		 *
		 * @param array $args Component args.
		 */
		public function link( array $args ) {
			$link = get_post_meta( $args['id'], 'card_link', true );
			savage_card_component( 'link', $link );
		}
	}
}
