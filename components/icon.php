<?php
/**
 * Savage Component: Icon
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'icon' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if icon isn't defined.
if ( empty( $args['icon'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-icon' );

?>
<div class="savage-card-icon">
	<div class="savage-card-icon-inner">
		<div class="savage-card-icon-content">
			<?php
				echo wp_kses( $args['icon'], [
					'svg'  => [
						'class'   => true,
						'id'      => true,
						'viewbox' => true,
						'xmlns'   => true,
					],
					'path' => [
						'class' => true,
						'd'     => true,
					],
				] );
			?>
		</div>
	</div>
</div>
