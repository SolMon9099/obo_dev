<?php
/**
 * Feature block.
 *
 * @package HivePress\Blocks
 */

namespace HivePress\Blocks;

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Feature block class.
 *
 * @class Feature
 */
class Feature extends Block {

	/**
	 * Feature icon.
	 *
	 * @var string
	 */
	protected $icon;

	/**
	 * Feature caption.
	 *
	 * @var string
	 */
	protected $caption;

	/**
	 * Class initializer.
	 *
	 * @param array $meta Block meta.
	 */
	public static function init( $meta = [] ) {
		$meta = hp\merge_arrays(
			[
				'label'    => esc_html__( 'Feature', 'hivepress-blocks' ),

				'settings' => [
					'icon'    => [
						'label'    => esc_html__( 'Icon', 'hivepress-blocks' ),
						'type'     => 'select',
						'options'  => 'icons',
						'required' => true,
						'_order'   => 10,
					],

					'caption' => [
						'label'  => esc_html__( 'Caption', 'hivepress-blocks' ),
						'type'   => 'text',
						'_order' => 20,
					],
				],
			],
			$meta
		);

		parent::init( $meta );
	}

	/**
	 * Renders block HTML.
	 *
	 * @return string
	 */
	public function render() {
		$output = '';

		if ( $this->icon ) {
			$output = '<div class="hp-feature">';

			// Render icon.
			$output .= '<i class="hp-feature__icon fas fa-' . esc_attr( $this->icon ) . '"></i>';

			// Render caption.
			if ( $this->caption ) {
				$output .= '<div class="hp-feature__caption hp-meta">' . esc_html( $this->caption ) . '</div>';
			}

			$output .= '</div>';
		}

		return $output;
	}
}
