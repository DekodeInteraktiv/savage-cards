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

/**
 * Get card markup
 *
 * @param array $args Card options.
 */
function savage_card( array $args = [] ) {
	$args = wp_parse_args( $args, [
		'id'   => 0,
		'size' => 'small',
		'type' => 'defaultcard',
	] );

	if ( 0 === $args['id'] ) {
		return;
	}

	$card = \Dekode\Savage\Core::get_instance()->get_card( $args['type'] );

	if ( $card instanceof Dekode\Savage\Card ) {
		echo $card->get_markup( $args ); // WPCS: XSS OK.
	} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		// Translators: %s: card type.
		printf( esc_html__( 'Missing savage card type - %s', 'savage-cards' ), esc_html( $args['type'] ) );
	}
}

/**
 * Component
 *
 * @param string $name Name of component.
 * @param array  $args Arguments to pass to the component.
 * @return void
 */
function savage_card_component( string $name, array $args = [] ) {
	$templates = [
		'components/' . $name . '/' . $name . '.php',
		'components/' . $name . '.php',
	];

	$component = '';
	foreach ( $templates as $template ) {
		if ( file_exists( SAVAGE_CARDS_PATH . '/' . $template ) ) {
			$component = SAVAGE_CARDS_PATH . '/' . $template;
			break;
		}
	}

	if ( $component && 0 === validate_file( $component ) ) {
		include $component;
	}
}
