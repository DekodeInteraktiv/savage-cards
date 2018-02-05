<?php
/**
 * Savage Component: Extensions
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

foreach ( $args as $value ) {
	echo wp_kses_post( $value );
}
