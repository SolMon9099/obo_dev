<?php
/**
 * Orders block.
 *
 * @package HivePress\Blocks
 */

namespace HivePress\Blocks;

use HivePress\Helpers as hp;
use HivePress\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Orders block class.
 *
 * @class Orders
 */
class Orders extends Block {

	/**
	 * Renders block HTML.
	 *
	 * @return string
	 */
	public function render() {
		$output = '';

		if ( have_posts() ) {
			$output .= '<table class="hp-orders hp-table hp-block">';

			while ( have_posts() ) {
				the_post();

				// Get order.
				$order = Models\Order::query()->get_by_id( get_post() );

				if ( $order ) {

					// Render order.
					$output .= ( new Template(
						[
							'template' => 'order_edit_block',

							'context'  => [
								'order' => $order,
							],
						]
					) )->render();
				}
			}

			$output .= '</table>';

			// Reset query.
			wp_reset_postdata();
		}

		return $output;
	}
}
