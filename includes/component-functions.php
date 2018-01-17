<?php
/**
 * Savage component functions
 *
 * @package Savage
 */

if ( ! function_exists( 'savage_image' ) ) {
	/**
	 * Image
	 *
	 * @param array $args Component args.
	 */
	function savage_image( $args ) {
		echo get_the_post_thumbnail( $args['id'] );
	}
}

if ( ! function_exists( 'savage_heading' ) ) {
	/**
	 * Heading
	 *
	 * @param array $args Component args.
	 */
	function savage_heading( $args ) {
		printf( '<h2>%s</h2>', get_the_title( $args['id'] ) );
	}
}

if ( ! function_exists( 'savage_excerpt' ) ) {
	/**
	 * Excerpt
	 *
	 * @param array $args Component args.
	 */
	function savage_excerpt( $args ) {
		$excerpt = get_post_meta( $args['id'], 'savage_excerpt', true );

		if ( ! empty( $excerpt ) ) {
			printf( '<p class="savage-excerpt">%s</p>', esc_html( $excerpt ) );
		}
	}
}
