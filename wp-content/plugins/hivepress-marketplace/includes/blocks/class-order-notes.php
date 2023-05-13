<?php
/**
 * Order notes block.
 *
 * @package HivePress\Blocks
 */

namespace HivePress\Blocks;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Order notes class.
 *
 * @class Order_Notes
 * @todo fix markup and style notes.
 */
class Order_Notes extends Block {

	/**
	 * Renders block HTML.
	 *
	 * @return string
	 */
	public function render() {
		$output = '';

		// Get order.
		$order = $this->get_context( 'order' );

		if ( ! $order ) {
			return $output;
		}

		$order = wc_get_order( $order->get_id() );

		// Get notes.
		$notes = $order->get_customer_order_notes();

		if ( $notes ) {
			$output .= '<ol class="hp-order__notes">';

			foreach ( array_reverse( $notes ) as $note ) {
				$output .= '<li>';

				// Render note.
				$output .= '<div>' . wpautop( wptexturize( $note->comment_content ) ) . '</div>';
				$output .= '<span class="hp-meta">' . date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $note->comment_date ) ) . '</span>';

				$output .= '</li>';
			}

			$output .= '</ol>';
		}

		return $output;
	}
}
