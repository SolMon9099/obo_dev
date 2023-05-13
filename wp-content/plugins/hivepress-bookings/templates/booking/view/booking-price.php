<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( isset( $booking_price ) ) :
	?>
	<div class="hp-booking__price hp-listing__attribute hp-listing__attribute--price">
		<?php echo $booking_price; ?>
	</div>
	<?php
endif;

if ( get_option( 'hp_listing_allow_price_extras' ) && $booking->get_price_extras() ) :
	?>
	<div class="hp-listing__attribute hp-listing__attribute--price-extras">
		<?php echo esc_html( implode( ', ', array_column( $booking->get_price_extras(), 'name' ) ) ); ?>
	</div>
	<?php
endif;
