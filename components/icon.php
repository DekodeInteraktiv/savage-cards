<?php
/**
 * Savage Component: Icon
 *
 * @package Savage
 */

declare( strict_types = 1 );

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'icon' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if icon isn't defined.
if ( empty( $args['icon'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-icon' );

savage_card_component( 'body-header', [
	'content' => sprintf( '<div class="savage-card-icon">%s</div>', $args['icon'] ),
] );
