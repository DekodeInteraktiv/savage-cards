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
	 */
	public function __construct() {

		$this->name      = strtolower( substr( strrchr( get_class( $this ), '\\' ), 1 ) );
		$this->field_key = 'savage_' . $this->name;

	}
}
