<?php
/**
 * Savage Component: Image
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'url' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if url isn't defined.
if ( empty( $args['url'] ) ) {
	return;
}

printf( '<div class="savage-image-cover"><span style="background-image: url(%s);"></span></div>',
	esc_url( $args['url'] )
);
