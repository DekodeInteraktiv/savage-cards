<?php
/**
 * Savage Component: Link teaser text
 *
 * @package Savage
 */

declare( strict_types = 1 );

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'teasertext' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if text isn't defined.
if ( empty( $args['teasertext'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-teaser' );

printf( '<p class="savage-card-teaser">%s</p>',
	wp_kses_post( $args['teasertext'] )
);
