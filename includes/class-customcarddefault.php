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

			if ( empty( $link['title'] ) ) {
				$link_text = (string) apply_filters( 'savage/card/components/savage_link/text',
					/* translators: A11y card link text */
					__( 'Read article &quot;%s&quot;', 'savage-card' ),
					$args
				);

				$fallback_text = savage_card_get_title( $args['id'] );
				$link['title'] = sprintf( $link_text, savage_get_link_title( $link, $fallback_text ) );
			}

			savage_card_component( 'link', $link );
		}
	}
}
