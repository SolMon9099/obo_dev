<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<div class="hp-testimonial__image">
	<?php if ( $testimonial->get_image__url( 'thumbnail' ) ) : ?>
		<img src="<?php echo esc_url( $testimonial->get_image__url( 'thumbnail' ) ); ?>" alt="<?php echo esc_attr( $testimonial->get_author() ); ?>" loading="lazy">
	<?php else : ?>
		<img src="<?php echo esc_url( hivepress()->get_url() . '/assets/images/placeholders/user-square.svg' ); ?>" alt="<?php echo esc_attr( $testimonial->get_author() ); ?>" loading="lazy">
	<?php endif; ?>
</div>
