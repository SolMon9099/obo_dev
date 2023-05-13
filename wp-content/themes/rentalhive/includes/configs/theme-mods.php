<?php
/**
 * Theme mods configuration.
 *
 * @package HiveTheme\Configs
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

return [
	'colors' => [
		'fields' => [
			'primary_color'        => [
				'default' => '#43824f',
			],

			'secondary_color'      => [
				'default' => '#f1bd6c',
			],

			'secondary_background' => [
				'label'   => esc_html__( 'Background Color', 'rentalhive' ),
				'type'    => 'color',
				'default' => '#faf9f5',
			],
		],
	],

	'fonts'  => [
		'fields' => [
			'heading_font'        => [
				'default' => 'Lexend',
			],

			'heading_font_weight' => [
				'default' => '500',
			],

			'body_font'           => [
				'default' => 'Inter',
			],

			'body_font_weight'    => [
				'default' => '400,500',
			],
		],
	],
];
