<?php
/**
 * Theme styles configuration.
 *
 * @package HiveTheme\Configs
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

return [
	[
		'selector'   => '
			.hp-feature__icon::after,
			.wp-block-button.is-style-primary .wp-block-button__link
		',

		'properties' => [
			[
				'name'      => 'background-color',
				'theme_mod' => 'primary_color',
			],
		],
	],

	[
		'selector'   => '
			.tagcloud a:hover,
			.wp-block-tag-cloud a:hover
		',

		'properties' => [
			[
				'name'      => 'border-color',
				'theme_mod' => 'primary_color',
			],
		],
	],

	[
		'selector'   => '
			.content-slider .slick-arrow:hover,
			.pagination > span:not(.dots),
			.pagination .nav-links > span:not(.dots),
			.pagination ul li span.current:not(.dots),
			.hp-listing--view-block .hp-listing__location i,
			.hp-listing--view-page .hp-listing__location i,
			.hp-listing--view-block .hp-listing__attributes--primary .hp-listing__attribute,
			.hp-listing--view-page .hp-listing__attributes--primary .hp-listing__attribute,
			.hp-vendor--view-block .hp-vendor__attributes--primary .hp-vendor__attribute,
			.hp-vendor--view-page .hp-vendor__attributes--primary .hp-vendor__attribute,
			.hp-offer__attributes--primary .hp-offer__attribute,
			.hp-feature__icon,
			.woocommerce nav.woocommerce-pagination > span:not(.dots),
			.woocommerce nav.woocommerce-pagination .nav-links > span:not(.dots),
			.woocommerce nav.woocommerce-pagination ul li span.current:not(.dots)
		',

		'properties' => [
			[
				'name'      => 'color',
				'theme_mod' => 'primary_color',
			],
		],
	],

	[
		'selector'   => '
			.header-hero,
			.content-title::before,
			.post--archive .post__categories a,
			.wp-block-button.is-style-secondary .wp-block-button__link,
			.hp-page__title::before,
			.hp-section__title::before,
			.hp-listing--view-page .hp-listing__categories a
		',

		'properties' => [
			[
				'name'      => 'background-color',
				'theme_mod' => 'secondary_color',
			],
		],
	],

	[
		'selector'   => '
			.content-section
		',

		'properties' => [
			[
				'name'      => 'background-color',
				'theme_mod' => 'secondary_background',
			],
		],
	],
];
