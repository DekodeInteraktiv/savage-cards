<?php
/**
 * Savage Component: Meta
 *
 * @package Savage
 */

declare( strict_types = 1 );

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'content' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if content isn't defined.
if ( empty( $args['content'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-meta' );

savage_card_component( 'body-header', [
	'content' => sprintf( '<div class="savage-card-meta"><div class="savage-card-meta-inner">%s</div></div>', $args['content'] ),
] );
