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
		do_action( 'savage/card/template/init', $this->name );

		ob_start();

		/*
		 * @hooked savage_card_image - 10
		 */
		do_action( 'savage/card/template/header/' . $this->name, $args );

		?>
		<div class="savage-card-body">
			<div class="savage-card-body-inner">
				<?php

				/*
				 * @hooked savage_card_body_header - 10
				 * @hooked savage_card_label - 20
				 * @hooked savage_card_heading - 30
				 * @hooked savage_card_excerpt - 40
				 * @hooked savage_card_linkteaser - 50
				 */
				do_action( 'savage/card/template/body/' . $this->name, $args );

				?>
			</div>
		</div>
		<?php

		/*
		 * @hooked savage_card_link - 10
		 */
		do_action( 'savage/card/template/footer/' . $this->name, $args );

		$card = ob_get_clean();
		return $card;
	}
}
