<?php
/**
 * Plugins configuration.
 *
 * @package HiveTheme\Configs
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

return [
	[
		'name' => 'HivePress Favorites',
		'slug' => 'hivepress-favorites',
	],

	[
		'name' => 'HivePress Messages',
		'slug' => 'hivepress-messages',
	],

	[
		'name' => 'HivePress Reviews',
		'slug' => 'hivepress-reviews',
	],

	[
		'name'   => 'HivePress Bookings',
		'slug'   => 'hivepress-bookings',
		'source' => hivetheme()->get_path( 'parent' ) . '/vendor/hivepress/hivepress-bookings.zip',
	],

	[
		'name'   => 'HivePress Tags',
		'slug'   => 'hivepress-tags',
		'source' => hivetheme()->get_path( 'parent' ) . '/vendor/hivepress/hivepress-tags.zip',
	],

	[
		'name'   => 'HivePress Blocks',
		'slug'   => 'hivepress-blocks',
		'source' => hivetheme()->get_path( 'parent' ) . '/vendor/hivepress/hivepress-blocks.zip',
	],
];
