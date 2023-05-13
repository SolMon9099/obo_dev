<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wc_get_template( 'order/order-details.php', [ 'order_id' => $order->get_id() ] );

if ( get_option( 'hp_order_share_details' ) && get_current_user_id() !== $order->get_buyer__id() ) {
	wc_get_template( 'order/order-details-customer.php', [ 'order' => wc_get_order( $order->get_id() ) ] );
}
