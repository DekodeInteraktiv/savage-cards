<?php
/**
 * Base class for Cards.
 *
 * @package Savage
 */

declare( strict_types = 1 );
namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The class.
 */
abstract class Card {

	/**
	 * Card name.
	 *
	 * @var string $name
	 */
	public $name;

	/**
	 * Module field key prefix.
	 *
	 * @var string $field_key
	 */
	public $field_key;

	/**
	 * Constructor.
	 *
	 * @param string $name Card name.
	 */
	public function __construct( string $name = '' ) {
		$this->name      = ! empty( $name ) ? sanitize_key( $name ) : strtolower( substr( strrchr( get_class( $this ), '\\' ), 1 ) );
		$this->field_key = 'savage_' . $this->name;
	}

	/**
	 * Get card markup
	 *
	 * @param array $args Card option.
	 */
	public function get_markup( array $args = [] ) {
		ob_start();

		do_action( 'savage/template/before/' . $this->name );

		printf( '<h2>%s</h2>', get_the_title( $args['id'] ) );

		do_action( 'savage/template/after/' . $this->name );

		$card = ob_get_clean();
		return $card;
	}
}
