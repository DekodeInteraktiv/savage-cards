<?php
/**
 * Helper functions in global namespace.
 *
 * @package Savage
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register card
 *
 * @param \Dekode\Savage\Card $card Card object.
 *
 * @return void
 */
function savage_register_card( \Dekode\Savage\Card $card ) {

	if ( did_action( 'savage/cards_registered' ) ) {
		_doing_it_wrong( __METHOD__, esc_html__( 'Cards have already been registered. Please run savage_register_card() on action savage/register_cards.', 'savage-cards' ), '1.0.0' );
	}

	add_filter( 'savage/cards', function( array $cards ) use ( $card ) : array {
		$cards[] = $card;
		return $cards;
	} );
}
