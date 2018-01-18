<?php
/**
 * Savage Component: Heading
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'title' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if title isn't defined.
if ( empty( $args['title'] ) ) {
	return;
}

printf( '<h2 class="savage-card-heading">%s</h2>',
	wp_kses( $args['title'], [
		'br' => [],
	] )
);
