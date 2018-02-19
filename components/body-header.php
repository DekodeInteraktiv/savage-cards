<?php
/**
 * Savage Component: Body header
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'content' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if no content.
if ( empty( $args['content'] ) ) {
	return;
}

global $allowedposttags;

// Add card classname.
savage_card_add_classname( 'savage-has-body-header' );

?>
<div class="savage-card-body-header">
	<div class="savage-card-body-header-inner">
		<div class="savage-card-body-header-content">
			<?php
			echo wp_kses( $args['content'], array_merge( $allowedposttags, [
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
			] ) );
			?>
		</div>
	</div>
</div>
