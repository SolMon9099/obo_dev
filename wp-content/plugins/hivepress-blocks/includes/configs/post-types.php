<?php
/**
 * Post types configuration.
 *
 * @package HivePress\Configs
 */

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

return [
	'testimonial' => [
		'public'    => false,
		'show_ui'   => true,
		'supports'  => [ 'title', 'editor', 'thumbnail' ],
		'menu_icon' => 'dashicons-testimonial',

		'labels'    => [
			'name'               => esc_html__( 'Testimonials', 'hivepress-blocks' ),
			'singular_name'      => esc_html__( 'Testimonial', 'hivepress-blocks' ),
			'add_new_item'       => esc_html__( 'Add Testimonial', 'hivepress-blocks' ),
			'add_new'            => esc_html_x( 'Add New', 'testimonial', 'hivepress-blocks' ),
			'edit_item'          => esc_html__( 'Edit Testimonial', 'hivepress-blocks' ),
			'new_item'           => esc_html__( 'Add Testimonial', 'hivepress-blocks' ),
			'all_items'          => esc_html__( 'Testimonials', 'hivepress-blocks' ),
			'search_items'       => esc_html__( 'Search Testimonials', 'hivepress-blocks' ),
			'not_found'          => esc_html__( 'No testimonials found.', 'hivepress-blocks' ),
			'not_found_in_trash' => esc_html__( 'No testimonials found.', 'hivepress-blocks' ),
		],
	],
];
