<?php
/**
 * Savage Component: Avatar
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'id' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if no image.
if ( empty( $args['id'] ) || ! wp_attachment_is_image( $args['id'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-avatar' );

savage_card_component( 'body-header', [
	'content' => wp_get_attachment_image( $args['id'], 'thumbnail', false, [
		'class' => 'savage-card-avatar',
	] ),
] );
