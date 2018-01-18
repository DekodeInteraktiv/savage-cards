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
		$title = get_post_meta( $args['id'], 'savage_title', true ) ?: get_the_title( $args['id'] );

		if ( ! empty( $title ) ) {
			printf( '<h2 class="savage-title">%s</h2>', esc_html( $title ) );
		}
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
