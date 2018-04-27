<?php
/**
 * Savage Component: Excerpt
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
savage_card_add_classname( 'savage-has-excerpt' );

printf( '<p class="savage-card-excerpt">%s</p>',
	wp_kses( $args['content'], [
		'br' => [],
	] )
);
