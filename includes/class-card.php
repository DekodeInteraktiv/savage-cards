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
	 * Constructor.
	 */
	public function __construct() {

		$this->name = strtolower( substr( strrchr( get_class( $this ), '\\' ), 1 ) );
	}

	/**
	 * Field definitions for card.
	 *
	 * @return array $fields Fields for this card
	 */
	abstract protected function get_fields() : array;
}
