<?php
/**
 * Savage Component: Image
 *
 * @package Savage
 */

if ( ! isset( $args ) || ! is_array( $args ) ) {
	return;
}

$defaults = [
	'url' => '',
];

$args = wp_parse_args( $args, $defaults );

// Return early if url isn't defined.
if ( empty( $args['url'] ) ) {
	return;
}

// Add card classname.
savage_card_add_classname( 'savage-has-image' );

?>
<div class="savage-card-image">
	<div class="savage-card-image-inner">
		<?php
		printf( '<span class="savage-card-image-image" style="background-image: url(%s);"></span>',
			esc_url( $args['url'] )
		);
		?>
	</div>
</div>
