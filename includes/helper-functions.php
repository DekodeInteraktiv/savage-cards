<?php
/**
 * Helper functions in global namespace.
 *
 * @package Savage
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register card
 *
 * @param \Dekode\Savage\Card $card Card object.
 *
 * @return void
 */
function savage_register_card( \Dekode\Savage\Card $card ) {

	if ( did_action( 'savage/cards_registered' ) ) {
		_doing_it_wrong( __METHOD__, esc_html__( 'Cards have already been registered. Please run savage_register_card() on action savage/register_cards.', 'savage-cards' ), '1.0.0' );
	}

	add_filter( 'savage/cards', function( array $cards ) use ( $card ) : array {
		$cards[] = $card;
		return $cards;
	} );
}

/**
 * Get card markup
 *
 * @param array $args Card options.
 */
function savage_card_get_markup( array $args = [] ) : string {
	$args = wp_parse_args( $args, [
		'id'   => 0,
		'size' => 'small',
		'type' => 'defaultcard',
	] );

	if ( 0 === $args['id'] ) {
		return null;
	}

	$card = \Dekode\Savage\Core::get_instance()->get_card( $args['type'] );

	if ( $card instanceof Dekode\Savage\Card ) {
		return $card->get_markup( $args );
	} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		// Translators: %s: card type.
		return sprintf( esc_html__( 'Missing savage card type - %s', 'savage-cards' ), esc_html( $args['type'] ) );
	}
}

/**
 * Get card
 *
 * @param array $args Card options.
 * @return array Card markup and classnames.
 */
function savage_get_card( array $args = [] ) : array {
	return [
		'markup'     => savage_card_get_markup( $args ),
		'classnames' => savage_card_get_classnames(),
	];
}

/**
 * Add card classname
 *
 * @param string $classname Classname.
 */
function savage_card_add_classname( string $classname ) {
	\Dekode\Savage\Classnames::get_instance()->add_classname( sanitize_html_class( $classname ) );
}

/**
 * Get card classnames
 *
 * @return array Array of classnames.
 */
function savage_card_get_classnames() : array {
	return \Dekode\Savage\Classnames::get_instance()->get_classnames();
}

/**
 * Component
 *
 * @param string $name Name of component.
 * @param array  $args Arguments to pass to the component.
 * @return void
 */
function savage_card_component( string $name, array $args = [] ) {
	$templates = [
		'components/' . $name . '/' . $name . '.php',
		'components/' . $name . '.php',
	];

	$component = '';
	foreach ( $templates as $template ) {
		if ( file_exists( SAVAGE_CARDS_PATH . '/' . $template ) ) {
			$component = SAVAGE_CARDS_PATH . '/' . $template;
			break;
		}
	}

	if ( $component && 0 === validate_file( $component ) ) {
		include $component;
	}
}

/**
 * Build tag attributes
 *
 * @param array $attr Array of attributes.
 * @return string Attributes.
 */
function savage_attributes( array $attr = [] ) : string {
	$attributes = '';

	foreach ( $attr as $name => $value ) {
		if ( empty( $value ) || ! $value ) {
			continue;
		}

		if ( ! $name ) {
			$attributes .= ' ' . esc_attr( $value );
			continue;
		}

		$name = esc_attr( $name );

		if ( is_bool( $value ) ) {
			$attributes .= " {$name}";
			continue;
		}

		if ( 'src' === $name || 'href' === $name ) {
			$value = esc_url( $value );
		} else {
			$value = esc_attr( $value );
		}

		$attributes .= " {$name}=\"{$value}\"";
	}

	return $attributes;
}

/**
 * Get post title
 *
 * @param int $id Post id.
 * @return string Post title
 */
function savage_card_get_title( int $id ) : string {
	return get_post_meta( $id, 'savage_title', true ) ?: get_the_title( $id );
}

/**
 * Cached version of url_to_postid, which can be expensive.
 *
 * Examine a url and try to determine the post ID it represents.
 *
 * @param string $url Permalink to check.
 * @return int Post ID, or 0 on failure.
 */
function savage_url_to_postid( string $url ) : int {
	// Sanity check; no URLs not from this site.
	if ( wp_parse_url( $url, PHP_URL_HOST ) !== wp_parse_url( home_url(), PHP_URL_HOST ) ) {
		return 0;
	}

	$cache_key = md5( $url );
	$post_id   = wp_cache_get( $cache_key, 'url_to_postid' );

	if ( false === $post_id ) {
		$post_id = url_to_postid( $url ); // phpcs:ignore
		wp_cache_set( $cache_key, $post_id, 'url_to_postid', 3 * HOUR_IN_SECONDS );
	}

	return (int) $post_id;
}

/**
 * Get link title from link field
 *
 * @param array  $link Link field.
 * @param string $fallback Fallback link text if no text is found.
 * @return string Link title.
 */
function savage_get_link_title( array $link, string $fallback = '' ) : string {
	// Return early if link title already exists.
	if ( ! empty( $link['title'] ) ) {
		return $link['title'];
	}

	// Try find post id based on url and return post title if found.
	$post_id = hogan_url_to_postid( $link['url'] );
	if ( 0 !== $post_id ) {
		$title = get_the_title( $post_id );
		// Check if the post does have a title.
		if ( ! empty( $title ) ) {
			return $title;
		}
	}

	if ( ! empty( $fallback ) ) {
		return $fallback;
	}

	// Return url as a last resort.
	return $link['url'];
}
