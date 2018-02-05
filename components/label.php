<?php
/**
 * Savage Component: Label
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'label' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if title isn't defined.
if ( empty( $args['label'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-label' );

printf(
	'<p class="savage-card-label">%s</p>',
	esc_html( $args['label'] )
);
