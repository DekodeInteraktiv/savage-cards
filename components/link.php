<?php
/**
 * Savage Component: Link
 *
 * @package Savage
 */

declare( strict_types = 1 );

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'url'    => '',
	'title'  => '',
	'target' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if url isn't defined.
if ( empty( $args['url'] ) ) {
	return;
}

printf( '<a href="%s" class="savage-card-link"%s><span class="screen-reader-text">%s</span></a>',
	esc_url( $args['url'] ),
	! empty( $args['target'] ) ? sprintf( ' target="%s"', esc_attr( $args['target'] ) ) : '',
	esc_html( $args['title'] )
);
