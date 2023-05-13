<?php
/**
 * Testimonials block.
 *
 * @package HivePress\Blocks
 */

namespace HivePress\Blocks;

use HivePress\Helpers as hp;
use HivePress\Models;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Testimonials block class.
 *
 * @class Testimonials
 */
class Testimonials extends Block {

	/**
	 * Columns number.
	 *
	 * @var int
	 */
	protected $columns;

	/**
	 * Testimonials number.
	 *
	 * @var int
	 */
	protected $number;

	/**
	 * Container attributes.
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Class initializer.
	 *
	 * @param array $meta Block meta.
	 */
	public static function init( $meta = [] ) {
		$meta = hp\merge_arrays(
			[
				'label'    => esc_html__( 'Testimonials', 'hivepress-blocks' ),

				'settings' => [
					'columns' => [
						'label'    => hivepress()->translator->get_string( 'columns_number' ),
						'type'     => 'select',
						'default'  => 2,
						'required' => true,
						'_order'   => 10,

						'options'  => [
							1 => '1',
							2 => '2',
							3 => '3',
						],
					],

					'number'  => [
						'label'     => hivepress()->translator->get_string( 'items_number' ),
						'type'      => 'number',
						'min_value' => 1,
						'default'   => 2,
						'required'  => true,
						'_order'    => 20,
					],
				],
			],
			$meta
		);

		parent::init( $meta );
	}

	/**
	 * Bootstraps block properties.
	 */
	protected function boot() {

		// Set attributes.
		$this->attributes = hp\merge_arrays(
			$this->attributes,
			[
				'class' => [ 'hp-testimonials', 'hp-block', 'hp-grid' ],
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

		if ( $this->number ) {

			// Get column width.
			$column_width = hp\get_column_width( $this->columns );

			// Query testimonials.
			$testimonials = Models\Testimonial::query()->filter(
				[
					'status' => 'publish',
				]
			)->order( [ 'created_date' => 'desc' ] )
			->limit( $this->number )
			->get();

			// Render testimonials.
			if ( $testimonials->count() ) {
				$output  = '<div ' . hp\html_attributes( $this->attributes ) . '>';
				$output .= '<div class="hp-row">';

				foreach ( $testimonials as $testimonial ) {
					$output .= '<div class="hp-grid__item hp-col-sm-' . esc_attr( $column_width ) . ' hp-col-xs-12">';

					// Render testimonial.
					$output .= ( new Template(
						[
							'template' => 'testimonial_view_block',

							'context'  => [
								'testimonial' => $testimonial,
							],
						]
					) )->render();

					$output .= '</div>';
				}

				$output .= '</div>';
				$output .= '</div>';
			}
		}

		return $output;
	}
}
