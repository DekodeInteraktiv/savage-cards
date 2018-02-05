<?php
/**
 * Savage component functions
 *
 * @package Savage
 */

if ( ! function_exists( 'savage_card_image' ) ) {
	/**
	 * Image
	 *
	 * @param array $args Component args.
	 */
	function savage_card_image( $args ) {
		$image_type = (string) get_post_meta( $args['id'], 'savage_image_type', true );

		switch ( $image_type ) {
			case 'none':
				$url = '';
				break;

			case 'alternative':
				$image_id = get_post_meta( $args['id'], 'savage_image', true );
				$url      = wp_get_attachment_url( $image_id );
				break;

			default:
				$url = get_the_post_thumbnail_url( $args['id'] );
				break;
		}

		if ( ! empty( $url ) ) {
			savage_card_component( 'image', [
				'url' => $url,
			] );
		}
	}
}

if ( ! function_exists( 'savage_card_label' ) ) {
	/**
	 * Label
	 *
	 * @param array $args Component args.
	 */
	function savage_card_label( $args ) {
		$label_type = get_post_meta( $args['id'], 'savage_label', true ) ?? '';

		switch ( $label_type ) {
			case 'manual':
				$label = get_post_meta( $args['id'], 'savage_label_text', true ) ?? '';
				break;

			case 'auto':
				$post_type_label = get_post_type_object( get_post_type( $args['id'] ) )->labels->singular_name;
				$label           = apply_filters( 'savage/card/components/label/auto', $post_type_label, $args['id'] );
				break;

			default:
				$label = '';
				break;
		}

		if ( ! empty( $label ) ) {
			savage_card_component(
				'label', [
					'label' => $label,
				]
			);
		}
	}
}

if ( ! function_exists( 'savage_card_heading' ) ) {
	/**
	 * Heading
	 *
	 * @param array $args Component args.
	 */
	function savage_card_heading( $args ) {
		$title = get_post_meta( $args['id'], 'savage_title', true ) ?: get_the_title( $args['id'] );

		if ( ! empty( $title ) ) {
			savage_card_component( 'heading', [
				'title' => $title,
			] );
		}
	}
}

if ( ! function_exists( 'savage_card_excerpt' ) ) {
	/**
	 * Excerpt
	 *
	 * @param array $args Component args.
	 */
	function savage_card_excerpt( $args ) {
		$excerpt = get_post_meta( $args['id'], 'savage_excerpt', true );

		if ( ! empty( $excerpt ) ) {
			savage_card_component( 'excerpt', [
				'content' => $excerpt,
			] );
		}
	}
}

if ( ! function_exists( 'savage_card_extensions' ) ) {
	/**
	 * Additional fields for default card.
	 *
	 * @param array $args Component args.
	 */
	function savage_card_extensions( $args ) {

		$additional_fields = apply_filters( 'savage/card/components/extensions', [], $args );

		if ( ! empty( $additional_fields ) ) {

			foreach ( $additional_fields as $extension ) {
				savage_card_component( 'extensions', [ $extension ] );
			}
		}
	}
}

if ( ! function_exists( 'savage_card_link' ) ) {
	/**
	 * Link
	 *
	 * @param array $args Component args.
	 */
	function savage_card_link( $args ) {
		$link_text = (string) apply_filters( 'savage/card/components/savage_link/text',
			/* translators: A11y card link text */
			__( 'Read article &quot;%s&quot;', 'savage-card' ),
			$args
		);

		savage_card_component( 'link', [
			'url'   => get_the_permalink( $args['id'] ),
			'title' => sprintf( $link_text, get_the_title( $args['id'] ) ),
		] );
	}
}
