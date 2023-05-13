<?php
/**
 * Vendor statistics block.
 *
 * @package HivePress\Blocks
 */

namespace HivePress\Blocks;

use HivePress\Helpers as hp;
use HivePress\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Vendor statistics class.
 *
 * @class Vendor_Statistics
 */
class Vendor_Statistics extends Block {

	/**
	 * Chart attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Bootstraps block properties.
	 */
	protected function boot() {

		// Set attributes.
		$this->attributes = hp\merge_arrays(
			$this->attributes,
			[
				'class'          => [ 'hp-chart' ],
				'data-component' => 'chart',
			]
		);

		parent::boot();
	}

	/**
	 * Renders block HTML.
	 *
	 * @return string
	 */
	public function render() {
		global $wpdb;

		$output = '';

		// Get vendor.
		$vendor = $this->get_context( 'vendor' );

		if ( is_admin() && get_post_type() === 'hp_vendor' ) {
			$vendor = Models\Vendor::query()->get_by_id( get_post() );
		}

		if ( $vendor ) {

			// Get cached statistics.
			$statistics = hivepress()->cache->get_post_cache( $vendor->get_id(), 'statistics' );

			if ( is_null( $statistics ) ) {
				$statistics = [];

				// Fill dates.
				$start_time = strtotime( '-29 days' );
				$end_time   = time();

				while ( $start_time <= $end_time ) {
					$date = date( 'Y-m-d', $start_time );

					$statistics[ $date ] = [ $date, 0, 0 ];

					$start_time += DAY_IN_SECONDS;
				}

				// Get results.
				if ( get_option( 'hp_vendor_include_taxes' ) ) {
					$results = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT DATE(post_date) AS date, COUNT(*), SUM(meta_value)
							FROM {$wpdb->posts}
							INNER JOIN {$wpdb->postmeta} ON ID = post_id
							WHERE post_type = %s AND post_status IN(%s, %s, %s)
							AND meta_key = %s AND post_author = %d
							AND post_date > NOW() - INTERVAL 29 DAY
							GROUP BY date",
							'shop_order',
							'wc-completed',
							'wc-processing',
							'wc-refunded',
							'_order_total',
							$vendor->get_user__id()
						),
						OBJECT_K
					);
				} else {
					$results = $wpdb->get_results(
						$wpdb->prepare(
							"SELECT DATE(orders.post_date) AS date, COUNT(*), SUM(totals.meta_value-taxes.meta_value)
							FROM {$wpdb->posts} AS orders
							INNER JOIN {$wpdb->postmeta} AS totals ON orders.ID = totals.post_id
							INNER JOIN {$wpdb->postmeta} AS taxes ON orders.ID = taxes.post_id
							WHERE orders.post_type = %s AND orders.post_status IN(%s, %s, %s)
							AND totals.meta_key = %s AND taxes.meta_key = %s AND orders.post_author = %d
							AND orders.post_date > NOW() - INTERVAL 29 DAY
							GROUP BY date",
							'shop_order',
							'wc-completed',
							'wc-processing',
							'wc-refunded',
							'_order_total',
							'_order_tax',
							$vendor->get_user__id()
						),
						OBJECT_K
					);
				}

				// Normalize results.
				$results = array_map(
					function( $result ) {
						return array_values( (array) $result );
					},
					$results
				);

				// Merge results.
				$statistics = array_values( array_merge( $statistics, $results ) );

				// Cache statistics.
				hivepress()->cache->set_post_cache( $vendor->get_id(), 'statistics', null, $statistics, DAY_IN_SECONDS );
			}

			// Get dates.
			$dates = array_map(
				function( $counts ) {
					return hp\get_first_array_value( $counts );
				},
				$statistics
			);

			// Set datasets.
			$datasets = hp\merge_arrays(
				array_combine(
					[ 'orders', 'revenue' ],
					array_fill(
						0,
						2,
						[
							'fill'        => false,
							'borderWidth' => 2,
							'data'        => [],
						]
					)
				),
				[
					'orders'  => [
						'label'                => hivepress()->translator->get_string( 'orders' ),
						'borderColor'          => '#ff6384',
						'pointBackgroundColor' => '#ff6384',
					],

					'revenue' => [
						'label'                => esc_html__( 'Revenue', 'hivepress-marketplace' ),
						'borderColor'          => '#4bc0c0',
						'pointBackgroundColor' => '#4bc0c0',
					],
				]
			);

			// Populate datasets.
			foreach ( $statistics as $counts ) {

				// Remove date.
				array_shift( $counts );

				// Add counts.
				$datasets['orders']['data'][]  = floatval( array_shift( $counts ) );
				$datasets['revenue']['data'][] = floatval( array_shift( $counts ) );
			}

			// Set totals.
			$totals = hp\merge_arrays(
				array_combine(
					[ 'today', 'yesterday', 'week', 'month' ],
					array_fill(
						0,
						4,
						[
							'period' => null,
							'data'   => [],
						]
					)
				),
				[
					'today'     => [
						'label' => esc_html__( 'Today', 'hivepress-marketplace' ),
						'start' => -1,
					],

					'yesterday' => [
						'label'  => esc_html__( 'Yesterday', 'hivepress-marketplace' ),
						'start'  => -2,
						'period' => 1,
					],

					'week'      => [
						/* translators: %s: days number. */
						'label' => sprintf( esc_html__( 'Last %s Days', 'hivepress-marketplace' ), 7 ),
						'start' => -7,
					],

					'month'     => [
						/* translators: %s: days number. */
						'label' => sprintf( esc_html__( 'Last %s Days', 'hivepress-marketplace' ), 30 ),
						'start' => -30,
					],
				]
			);

			// Calculate totals.
			foreach ( $totals as $period => $total ) {
				$totals[ $period ]['data'] = array_merge(
					$total['data'],
					[
						'orders'  => array_sum( array_slice( $datasets['orders']['data'], $total['start'], $total['period'] ) ),
						'revenue' => hivepress()->woocommerce->format_price( array_sum( array_slice( $datasets['revenue']['data'], $total['start'], $total['period'] ) ) ),
					]
				);
			}

			// Render totals.
			$output .= '<table class="hp-table">';

			// Render columns.
			$output .= '<thead><tr>';
			$output .= '<th></th>';

			foreach ( $datasets as $dataset ) {
				$output .= '<th>' . esc_html( $dataset['label'] ) . '</th>';
			}

			$output .= '</tr></thead>';

			// Render rows.
			$output .= '<tbody>';

			foreach ( $totals as $total ) {
				$output .= '<tr>';

				// Render label.
				$output .= '<th>' . esc_html( $total['label'] ) . '</th>';

				// Render counts.
				foreach ( $total['data'] as $count ) {
					$output .= '<td>' . esc_html( $count ) . '</td>';
				}

				$output .= '</tr>';
			}

			$output .= '</tbody>';
			$output .= '</table>';

			// Render chart.
			$output .= '<div><canvas data-labels="' . hp\esc_json( wp_json_encode( $dates ) ) . '" data-datasets="' . hp\esc_json( wp_json_encode( array_values( $datasets ) ) ) . '" ' . hp\html_attributes( $this->attributes ) . '></canvas></div>';
		}

		return $output;
	}
}
