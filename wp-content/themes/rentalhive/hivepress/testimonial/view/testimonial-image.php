<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$image_url = hivepress()->get_url() . '/assets/images/placeholders/image-landscape.svg';

if ( $testimonial->get_image__url( 'hp_landscape_large' ) ) :
	$image_url = $testimonial->get_image__url( 'hp_landscape_large' );
endif;
?>
<div class="hp-testimonial__image" style="background-image:url(<?php echo esc_url( $image_url ); ?>)"></div>
