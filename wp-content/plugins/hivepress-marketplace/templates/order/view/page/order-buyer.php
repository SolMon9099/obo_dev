<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( $order->get_buyer__id() && get_current_user_id() !== $order->get_buyer__id() ) :
	?>
	<div class="hp-order__buyer hp-meta">
		<?php
		/* translators: %s: user name. */
		printf( esc_html__( 'Purchased by %s', 'hivepress-marketplace' ), $order->get_buyer__display_name() );
		?>
	</div>
	<?php
endif;
