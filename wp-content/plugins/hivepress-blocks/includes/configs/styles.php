<?php
/**
 * Styles configuration.
 *
 * @package HivePress\Configs
 */

use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

return [
	'blocks_frontend' => [
		'handle'  => 'hivepress-blocks-frontend',
		'src'     => hivepress()->get_url( 'blocks' ) . '/assets/css/frontend.min.css',
		'version' => hivepress()->get_version( 'blocks' ),
		'scope'   => [ 'frontend', 'editor' ],
	],
];
