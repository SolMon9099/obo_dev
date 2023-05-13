<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<time class="hp-listing__created-date hp-meta" datetime="<?php echo esc_attr( $booking->get_created_date() ); ?>">
	<?php
	/* translators: %1$s: booking date, %2$s: user name. */
	printf( esc_html__( 'Booked on %1$s by %2$s', 'hivepress-bookings' ), $booking->display_created_date(), $booking->get_user__display_name() );
	?>
</time>
