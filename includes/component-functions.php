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

if ( ! function_exists( 'savage_card_icon' ) ) {
	/**
	 * Icon
	 *
	 * @param array $args Component args.
	 */
	function savage_card_icon( $args ) {
		$icon = (string) apply_filters( 'savage/card/components/icon', '', $args );

		if ( ! empty( $icon ) ) {
			savage_card_component( 'icon', [
				'icon' => $icon,
			] );
		}
	}
}

if ( ! function_exists( 'savage_card_avatar' ) ) {
	/**
	 * Avatar
	 *
	 * @param array $args Component args.
	 */
	function savage_card_avatar( $args ) {
		$id = (int) absint( apply_filters( 'savage/card/components/avatar', 0, $args ) );

		if ( 0 !== $id ) {
			savage_card_component( 'avatar', [
				'id' => $id,
			] );
		}
	}
}

if ( ! function_exists( 'savage_card_body_header' ) ) {
	/**
	 * Body header
	 *
	 * @param array $args Component args.
	 */
	function savage_card_body_header( $args ) {
		$components = (array) apply_filters( 'savage/card/components/body_header/components', [
			'savage_card_icon',
			'savage_card_avatar',
		], $args );

		foreach ( $components as $component ) {
			if ( function_exists( $component ) ) {
				ob_start();
				call_user_func( $component, $args );
				$content = ob_get_clean();

				if ( ! empty( $content ) ) {
					echo $content; // WPCS: XSS OK.
					break;
				}
			}
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
				'attr'  => apply_filters( 'savage/card/components/heading/attr', [], $args ),
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

if ( ! function_exists( 'savage_card_linkteaser' ) ) {
	/**
	 * Link teaser text
	 *
	 * @param array $args Component args.
	 */
	function savage_card_linkteaser( $args ) {
		$savage_teaser = apply_filters( 'savage/card/components/savage_link/teaser', get_post_meta( $args['id'], 'savage_link_title', true ), $args );

		if ( ! empty( $savage_teaser ) ) {
			savage_card_component( 'linkteaser', [
				'teasertext' => $savage_teaser,
			] );
		}
	}
}
