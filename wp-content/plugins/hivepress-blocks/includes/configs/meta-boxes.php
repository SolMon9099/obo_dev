<?php
/**
 * Meta boxes configuration.
 *
 * @package HivePress\Configs
 */

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

return [
	'testimonial_settings' => [
		'title'  => hivepress()->translator->get_string( 'settings' ),
		'screen' => 'testimonial',

		'fields' => [
			'url'      => [
				'label'  => esc_html__( 'URL', 'hivepress-blocks' ),
				'type'   => 'url',
				'_order' => 10,
			],

			'position' => [
				'label'      => esc_html__( 'Position', 'hivepress-blocks' ),
				'type'       => 'text',
				'max_length' => 256,
				'_order'     => 20,
			],
		],
	],
];
