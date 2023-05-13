<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>
<td class="hp-order__total">
	<span><?php echo esc_html( $order->display_total() ); ?></span>
</td>
