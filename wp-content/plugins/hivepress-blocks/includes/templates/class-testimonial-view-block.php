<?php
/**
 * Testimonial view block template.
 *
 * @package HivePress\Templates
 */

namespace HivePress\Templates;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Testimonial view block template class.
 *
 * @class Testimonial_View_Block
 */
class Testimonial_View_Block extends Template {

	/**
	 * Class constructor.
	 *
	 * @param array $args Template arguments.
	 */
	public function __construct( $args = [] ) {
		$args = hp\merge_trees(
			[
				'blocks' => [
					'testimonial_container' => [
						'type'       => 'container',
						'_order'     => 10,

						'attributes' => [
							'class' => [ 'hp-testimonial', 'hp-testimonial--view-block' ],
						],

						'blocks'     => [
							'testimonial_image'   => [
								'type'   => 'part',
								'path'   => 'testimonial/view/testimonial-image',
								'_order' => 10,
							],

							'testimonial_content' => [
								'type'       => 'container',
								'_order'     => 20,

								'attributes' => [
									'class' => [ 'hp-testimonial__content' ],
								],

								'blocks'     => [
									'testimonial_text'    => [
										'type'   => 'part',
										'path'   => 'testimonial/view/testimonial-text',
										'_order' => 10,
									],

									'testimonial_summary' => [
										'type'       => 'container',
										'_order'     => 20,

										'attributes' => [
											'class' => [ 'hp-testimonial__summary' ],
										],

										'blocks'     => [
											'testimonial_author' => [
												'type'   => 'part',
												'path'   => 'testimonial/view/testimonial-author',
												'_order' => 10,
											],

											'testimonial_position' => [
												'type'   => 'part',
												'path'   => 'testimonial/view/testimonial-position',
												'_order' => 20,
											],
										],
									],
								],
							],
						],
					],
				],
			],
			$args
		);

		parent::__construct( $args );
	}
}
