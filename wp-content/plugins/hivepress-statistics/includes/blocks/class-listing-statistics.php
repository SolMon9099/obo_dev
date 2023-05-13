<?php
/**
 * Listing statistics block.
 *
 * @package HivePress\Blocks
 */

namespace HivePress\Blocks;

use HivePress\Helpers as hp;
use HivePress\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Listing statistics class.
 *
 * @class Listing_Statistics
 */
class Listing_Statistics extends Block {

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
		$output = '';

		// Get listing.
		$listing = $this->get_context( 'listing' );

		if ( is_admin() && get_post_type() === 'hp_listing' ) {
			$listing = Models\Listing::query()->get_by_id( get_post() );
		}

		if ( hp\is_class_instance( $listing, '\HivePress\Models\Listing' ) ) {

			// Get cached statistics.
			$statistics = hivepress()->cache->get_post_cache( $listing->get_id(), 'statistics' );

			if ( is_null( $statistics ) ) {
				$statistics = [];

				// Get API token.
				$token = hivepress()->google->get_token( 'ganalytics' );

				if ( $token ) {

					// Get URL path.
					$path = substr( hivepress()->router->get_url( 'listing_view_page', [ 'listing_id' => $listing->get_id() ] ), strlen( home_url() ) );

					// Get API response.
					$response = json_decode(
						wp_remote_retrieve_body(
							wp_remote_get(
								'https://www.googleapis.com/analytics/v3/data/ga?' . http_build_query(
									[
										'ids'        => 'ga:' . get_option( 'hp_ganalytics_view_id' ),
										'start-date' => '29daysAgo',
										'end-date'   => 'today',
										'metrics'    => 'ga:users,ga:newUsers,ga:pageviews',
										'dimensions' => 'ga:date',
										'filters'    => 'ga:pagePath=@' . urldecode( $path ),
									]
								),
								[
									'headers' => [
										'Authorization' => 'Bearer ' . $token,
									],
								]
							)
						),
						true
					);

					if ( is_array( $response ) && isset( $response['rows'] ) ) {

						// Get statistics.
						$statistics = (array) $response['rows'];

						// Cache statistics.
						hivepress()->cache->set_post_cache( $listing->get_id(), 'statistics', null, $statistics, HOUR_IN_SECONDS );
					}
				}
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
					[ 'all_visitors', 'new_visitors', 'views' ],
					array_fill(
						0,
						3,
						[
							'fill'        => false,
							'borderWidth' => 2,
							'data'        => [],
						]
					)
				),
				[
					'all_visitors' => [
						'label'                => esc_html__( 'All Visitors', 'hivepress-statistics' ),
						'borderColor'          => '#ff6384',
						'pointBackgroundColor' => '#ff6384',
					],

					'new_visitors' => [
						'label'                => esc_html__( 'New Visitors', 'hivepress-statistics' ),
						'borderColor'          => '#4bc0c0',
						'pointBackgroundColor' => '#4bc0c0',
					],

					'views'        => [
						'label'                => esc_html__( 'Views', 'hivepress-statistics' ),
						'borderColor'          => '#36a2eb',
						'pointBackgroundColor' => '#36a2eb',
					],
				]
			);

			// Populate datasets.
			foreach ( $statistics as $counts ) {

				// Remove date.
				array_shift( $counts );

				// Add counts.
				$datasets['all_visitors']['data'][] = (int) array_shift( $counts );
				$datasets['new_visitors']['data'][] = (int) array_shift( $counts );
				$datasets['views']['data'][]        = (int) array_shift( $counts );
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
						'label' => esc_html__( 'Today', 'hivepress-statistics' ),
						'start' => -1,
					],

					'yesterday' => [
						'label'  => esc_html__( 'Yesterday', 'hivepress-statistics' ),
						'start'  => -2,
						'period' => 1,
					],

					'week'      => [
						/* translators: %s: days number. */
						'label' => sprintf( esc_html__( 'Last %s Days', 'hivepress-statistics' ), 7 ),
						'start' => -7,
					],

					'month'     => [
						/* translators: %s: days number. */
						'label' => sprintf( esc_html__( 'Last %s Days', 'hivepress-statistics' ), 30 ),
						'start' => -30,
					],
				]
			);

			// Calculate totals.
			foreach ( $totals as $period => $total ) {
				$totals[ $period ]['data'] = array_merge(
					$total['data'],
					[
						'all_visitors' => array_sum( array_slice( $datasets['all_visitors']['data'], $total['start'], $total['period'] ) ),
						'new_visitors' => array_sum( array_slice( $datasets['new_visitors']['data'], $total['start'], $total['period'] ) ),
						'views'        => array_sum( array_slice( $datasets['views']['data'], $total['start'], $total['period'] ) ),
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
