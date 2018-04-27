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

		$default_image_size = 'full' === $args['size'] ? 'large' : 'medium_large';
		$image_size         = apply_filters( 'savage/card/components/image/size', $default_image_size, $args );

		switch ( $image_type ) {
			case 'none':
				$url = '';
				break;

			case 'alternative':
				$image_id = get_post_meta( $args['id'], 'savage_image', true );
				$image    = wp_get_attachment_image_src( $image_id, $image_size );

				if ( is_array( $image ) && ! empty( $image ) ) {
					$url = $image[0];
				} else {
					$url = wp_get_attachment_url( $image_id ); // Default image as fallback.
				}
				break;
			default:
				$url = apply_filters( 'savage/card/components/image/url', get_the_post_thumbnail_url( $args['id'], $image_size ) );
				break;
		}

		if ( ! empty( $url ) ) {
			savage_card_component( 'image', [
				'url' => $url,
			] );
		}
	}
}

if ( ! function_exists( 'savage_card_meta' ) ) {
	/**
	 * Meta
	 *
	 * @param array $args Component args.
	 */
	function savage_card_meta( $args ) {
		$content = (string) apply_filters( 'savage/card/components/meta', '', $args );

		if ( ! empty( $content ) ) {
			savage_card_component( 'meta', [
				'content' => $content,
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
			'savage_card_meta',
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

			case 'none':
				$label = '';
				break;

			default:
				$post_type_label = get_post_type_object( get_post_type( $args['id'] ) )->labels->singular_name;
				$label           = apply_filters( 'savage/card/components/label/auto', $post_type_label, $args['id'] );
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
		$title = savage_card_get_title( $args['id'] );

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

if ( ! function_exists( 'savage_custom_card_layout' ) ) {
	/**
	 * Custom card layout
	 *
	 * @param array $args Component args.
	 */
	function savage_custom_card_layout( $args ) {
		$layouts = get_field( 'card_content_flex', $args['id'] );
		// Only one layout possible on a card.
		$active_layout = reset( $layouts );
		do_action( 'savage/card/custom/body/layout_content', $active_layout );

		if ( 'card_content' === $active_layout['acf_fc_layout'] ) {
			echo wp_kses_post( $active_layout['content'] );
		}

		savage_card_add_classname( 'savage-has-layout' );
		savage_card_add_classname( 'savage-layout-' . esc_attr( $active_layout['acf_fc_layout'] ) );
	}
}

if ( ! function_exists( 'savage_custom_card_link' ) ) {
	/**
	 * Custom card link
	 *
	 * @param array $args Component args.
	 */
	function savage_custom_card_link( $args ) {
		$link  = get_post_meta( $args['id'], 'card_link', true );
		$title = savage_get_link_title( $link );
		printf(
			'<a href="%s" class="savage-card-teaser"%s>%s</a>',
			esc_url( $link['url'] ),
			! empty( $link['target'] ) ? sprintf( ' target="%s"', esc_attr( $link['target'] ) ) : '',
			esc_html( $title )
		);
	}
}
