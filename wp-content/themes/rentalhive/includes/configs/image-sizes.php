<?php
/**
 * Image sizes configuration.
 *
 * @package HiveTheme\Configs
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

return [
	'landscape_small' => [
		'width'  => 400,
		'height' => 300,
		'crop'   => true,
	],

	'cover_large'     => [
		'width'  => 1600,
		'height' => 800,
		'crop'   => true,
	],
];
