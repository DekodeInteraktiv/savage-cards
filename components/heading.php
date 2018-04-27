<?php
/**
 * Savage Component: Heading
 *
 * @package Savage
 */

declare( strict_types = 1 );

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'title' => '',
	'attr'  => [],
];

$args = wp_parse_args( $args, $defaults );

// Return early if title isn't defined.
if ( empty( $args['title'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-heading' );

printf( '<h2 class="savage-card-heading"%2$s>%1$s</h2>',
	wp_kses( $args['title'], [
		'br' => [],
	] ),
	savage_attributes( $args['attr'] )
);
