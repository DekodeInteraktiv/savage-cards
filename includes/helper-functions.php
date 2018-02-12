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
function savage_card_get_markup( array $args = [] ) {
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
		return $card->get_markup( $args );
	} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		// Translators: %s: card type.
		return sprintf( esc_html__( 'Missing savage card type - %s', 'savage-cards' ), esc_html( $args['type'] ) );
	}
}

/**
 * Get card
 *
 * @param array $args Card options.
 * @return array Card markup and classnames.
 */
function savage_get_card( array $args = [] ) : array {
	return [
		'markup'     => savage_card_get_markup( $args ),
		'classnames' => savage_card_get_classnames(),
	];
}

/**
 * Add card classname
 *
 * @param string $classname Classname.
 */
function savage_card_add_classname( string $classname ) {
	\Dekode\Savage\Classnames::get_instance()->add_classname( $classname );
}

/**
 * Get card classnames
 *
 * @return array Array of classnames.
 */
function savage_card_get_classnames() : array {
	return \Dekode\Savage\Classnames::get_instance()->get_classnames();
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

/**
 * Build tag attributes
 *
 * @param array $attr Array of attributes.
 * @return string Attributes.
 */
function savage_attributes( array $attr = [] ) : string {
	$attributes = '';

	foreach ( $attr as $name => $value ) {
		if ( empty( $value ) || ! $value ) {
			continue;
		}

		if ( ! $name ) {
			$attributes .= ' ' . esc_attr( $value );
			continue;
		}

		$name = esc_attr( $name );

		if ( is_bool( $value ) ) {
			$attributes .= " {$name}";
			continue;
		}

		if ( 'src' === $name || 'href' === $name ) {
			$value = esc_url( $value );
		} else {
			$value = esc_attr( $value );
		}

		$attributes .= " {$name}=\"{$value}\"";
	}

	return $attributes;
}
