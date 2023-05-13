<?php
/**
 * Theme component.
 *
 * @package HiveTheme\Components
 */

namespace HiveTheme\Components;

use HiveTheme\Helpers as ht;
use HivePress\Helpers as hp;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Theme component class.
 *
 * @class Theme
 */
final class Theme extends Component {

	/**
	 * Class constructor.
	 *
	 * @param array $args Component arguments.
	 */
	public function __construct( $args = [] ) {

		// Set hero background.
		add_action( 'wp_enqueue_scripts', [ $this, 'set_hero_background' ] );

		// Render hero content.
		add_filter( 'hivetheme/v1/areas/site_hero', [ $this, 'render_hero_content' ] );

		// Alter styles.
		add_filter( 'hivetheme/v1/styles', [ $this, 'alter_styles' ] );
		add_filter( 'hivepress/v1/styles', [ $this, 'alter_styles' ] );

		// Check HivePress status.
		if ( ! ht\is_plugin_active( 'hivepress' ) ) {
			return;
		}

		// Alter strings.
		add_filter( 'hivepress/v1/strings', [ $this, 'alter_strings' ] );

		// Alter post types.
		add_filter( 'hivepress/v1/post_types', [ $this, 'alter_post_types' ] );

		// Alter attributes.
		add_filter( 'hivepress/v1/models/listing/attributes', [ $this, 'alter_listing_attributes' ] );
		add_filter( 'hivepress/v1/models/vendor/attributes', [ $this, 'alter_vendor_attributes' ] );

		// Alter blocks.
		add_filter( 'hivepress/v1/blocks/listings/meta', [ $this, 'alter_slider_block_meta' ] );
		add_filter( 'hivepress/v1/blocks/vendors/meta', [ $this, 'alter_slider_block_meta' ] );
		add_filter( 'hivepress/v1/blocks/testimonials/meta', [ $this, 'alter_slider_block_meta' ] );

		add_filter( 'hivepress/v1/blocks/listings', [ $this, 'alter_slider_block_args' ], 10, 2 );
		add_filter( 'hivepress/v1/blocks/vendors', [ $this, 'alter_slider_block_args' ], 10, 2 );
		add_filter( 'hivepress/v1/blocks/testimonials', [ $this, 'alter_slider_block_args' ], 10, 2 );

		if ( ! is_admin() ) {

			// Alter menus.
			add_filter( 'hivepress/v1/menus/listing_manage/items', [ $this, 'alter_listing_manage_menu' ], 100, 2 );

			// Alter templates.
			add_filter( 'hivepress/v1/templates/listing_view_block', [ $this, 'alter_listing_view_block' ], 100 );
			add_filter( 'hivepress/v1/templates/listing_view_page', [ $this, 'alter_listing_view_page' ], 100 );

			if ( hivepress()->get_version( 'geolocation' ) ) {
				foreach ( (array) get_option( 'hp_geolocation_models', [ 'listing' ] ) as $model ) {
					add_filter( 'hivepress/v1/templates/' . $model . 's_view_page', [ $this, 'alter_listings_view_page' ], 100, 2 );
				}
			}

			add_filter( 'hivepress/v1/templates/listing_category_view_block', [ $this, 'alter_listing_category_view_block' ] );

			add_filter( 'hivepress/v1/templates/vendor_view_block/blocks', [ $this, 'alter_vendor_view_block' ], 10, 2 );
		}

		parent::__construct( $args );
	}

	/**
	 * Sets hero background.
	 */
	public function set_hero_background() {
		$style = '';

		// Get image URL.
		$image_url = get_header_image();

		if ( is_singular( 'post' ) && has_post_thumbnail() ) {
			$image_url = get_the_post_thumbnail_url( null, 'ht_cover_large' );
		} elseif ( ht\is_plugin_active( 'hivepress' ) && is_tax( 'hp_listing_category' ) ) {
			$image_id = get_term_meta( get_queried_object_id(), 'hp_image', true );

			if ( $image_id ) {
				$image = wp_get_attachment_image_src( $image_id, 'ht_cover_large' );

				if ( $image ) {
					$image_url = ht\get_first_array_value( $image );
				}
			}
		}

		// Add background styles.
		if ( $image_url ) {
			$style .= '.header-hero { background-image: url(' . esc_url( $image_url ) . ') }';
		}

		if ( get_header_textcolor() && get_header_textcolor() !== 'blank' ) {
			$style .= '.header-hero { color: #' . esc_attr( get_header_textcolor() ) . ' }';
		}

		// Add inline style.
		if ( $style ) {
			wp_add_inline_style( 'hivetheme-parent-frontend', $style );
		}
	}

	/**
	 * Renders hero content.
	 *
	 * @param string $output Hero content.
	 * @return string
	 */
	public function render_hero_content( $output ) {
		$classes = [];

		// Render header.
		if ( is_page() ) {

			// Get content.
			$content = '';

			$parts = get_extended( get_post_field( 'post_content' ) );

			if ( $parts['extended'] ) {
				$content = apply_filters( 'the_content', $parts['main'] );

				$classes[] = 'header-hero--large';
			} else {
				$classes[] = 'header-hero--title';
			}

			// Check title.
			$title = get_the_ID() !== absint( get_option( 'page_on_front' ) );

			if ( ht\is_plugin_active( 'hivepress' ) ) {
				$title = $title && ! hivepress()->request->get_context( 'post_query' );
			}

			// Render part.
			if ( $content ) {
				$output .= $content;
			} elseif ( $title ) {
				$output .= hivetheme()->template->render_part( 'templates/page/page-title' );
			}
		} elseif ( is_singular( 'post' ) ) {

			// Add classes.
			$classes = array_merge(
				$classes,
				[
					'post',
					'post--single',
				]
			);

			// Render part.
			$output .= hivetheme()->template->render_part( 'templates/post/single/post-header' );
		} elseif ( ht\is_plugin_active( 'hivepress' ) && is_tax( 'hp_listing_category' ) ) {

			// Add classes.
			$classes = array_merge(
				$classes,
				[
					'hp-listing-category',
					'hp-listing-category--view-page',
				]
			);

			// Render part.
			$output .= hivetheme()->template->render_part(
				'hivepress/listing-category/view/page/listing-category-header',
				[
					'listing_category' => \HivePress\Models\Listing_Category::query()->get_by_id( get_queried_object() ),
				]
			);
		}

		// Add wrapper.
		if ( $output ) {
			$output = hivetheme()->template->render_part(
				'templates/page/page-header',
				[
					'class'   => implode( ' ', $classes ),
					'content' => $output,
				]
			);
		}

		return $output;
	}

	/**
	 * Alters styles.
	 *
	 * @param array $styles Styles.
	 * @return array
	 */
	public function alter_styles( $styles ) {
		$styles['fontawesome']['src'] = hivetheme()->get_url( 'parent' ) . '/assets/css/fontawesome.min.css';

		unset( $styles['fontawesome_solid'] );

		return $styles;
	}

	/**
	 * Alters strings.
	 *
	 * @param array $strings Strings.
	 * @return array
	 */
	public function alter_strings( $strings ) {
		return array_merge(
			$strings,
			[
				'reply_to_listing'                      => ht\get_array_value( $strings, 'send_message' ),

				'vendor'                                => esc_html__( 'Host', 'rentalhive' ),
				'vendors'                               => esc_html__( 'Hosts', 'rentalhive' ),
				'view_vendor'                           => esc_html__( 'View Host', 'rentalhive' ),
				'add_vendor'                            => esc_html__( 'Add Host', 'rentalhive' ),
				'edit_vendor'                           => esc_html__( 'Edit Host', 'rentalhive' ),
				'search_vendors'                        => esc_html__( 'Search Hosts', 'rentalhive' ),
				'no_vendors_found'                      => esc_html__( 'No hosts found.', 'rentalhive' ),
				'vendor_attributes'                     => esc_html__( 'Host Attributes', 'rentalhive' ),
				'vendor_search_form'                    => esc_html__( 'Host Search Form', 'rentalhive' ),
				'vendors_page'                          => esc_html__( 'Hosts Page', 'rentalhive' ),
				'regular_vendors_per_page'              => esc_html__( 'Hosts per Page', 'rentalhive' ),
				'choose_page_that_displays_all_vendors' => esc_html__( 'Choose a page that displays all hosts.', 'rentalhive' ),
				'display_vendors_on_frontend'           => esc_html__( 'Display hosts on the front-end', 'rentalhive' ),
				'display_only_verified_vendors'         => esc_html__( 'Display only verified hosts', 'rentalhive' ),
				'mark_vendor_as_verified'               => esc_html__( 'Mark this host as verified', 'rentalhive' ),
				'only_vendors_can_make_offers'          => esc_html__( 'Only hosts can make offers.', 'rentalhive' ),

				'places'                                => esc_html__( 'Guests', 'rentalhive' ),
				/* translators: %s: number. */
				'places_n'                              => esc_html__( 'Guests: %s', 'rentalhive' ),
				'min_places_per_booking'                => esc_html__( 'Minimum Guests per Booking', 'rentalhive' ),
				'max_places_per_booking'                => esc_html__( 'Maximum Guests per Booking', 'rentalhive' ),
			]
		);
	}

	/**
	 * Alters post types.
	 *
	 * @param array $post_types Post types.
	 * @return array
	 */
	public function alter_post_types( $post_types ) {
		$post_types['vendor']['rewrite']['slug'] = 'host';

		return $post_types;
	}

	/**
	 * Alters listing attributes.
	 *
	 * @param array $attributes Attributes.
	 * @return array
	 */
	public function alter_listing_attributes( $attributes ) {
		if ( hivepress()->get_version( 'tags' ) ) {
			$attributes['tags']['search_field']['_order'] = 190;
		}

		return $attributes;
	}

	/**
	 * Alters vendor attributes.
	 *
	 * @param array $attributes Attributes.
	 * @return array
	 */
	public function alter_vendor_attributes( $attributes ) {
		if ( ! isset( $attributes['listing_count'] ) ) {
			$attributes['listing_count'] = [
				'protected'      => true,
				/* translators: %s: number. */
				'display_format' => sprintf( esc_html__( '%s Listings', 'rentalhive' ), '%value%' ),

				'display_areas'  => [
					'view_block_primary',
				],

				'edit_field'     => [
					'type'      => 'number',
					'min_value' => 0,
				],
			];
		}

		return $attributes;
	}

	/**
	 * Alters slider block meta.
	 *
	 * @param array $meta Block meta.
	 * @return array
	 */
	public function alter_slider_block_meta( $meta ) {
		$meta['settings']['slider'] = [
			'label'  => esc_html__( 'Display in a slider', 'rentalhive' ),
			'type'   => 'checkbox',
			'_order' => 100,
		];

		return $meta;
	}

	/**
	 * Alters slider block arguments.
	 *
	 * @param array  $args Block arguments.
	 * @param object $block Block object.
	 * @return array
	 */
	public function alter_slider_block_args( $args, $block ) {
		if ( hp\get_array_value( $args, 'slider' ) ) {
			$attributes = [
				'data-component' => 'slider',
				'class'          => [ 'hp-' . $block::get_meta( 'name' ) . '--slider', 'content-slider', 'alignfull' ],
			];

			if ( in_array( $block::get_meta( 'name' ), [ 'listings', 'vendors' ], true ) ) {
				$attributes['data-type'] = 'carousel';
			}

			$args['attributes'] = hp\merge_arrays(
				hp\get_array_value( $args, 'attributes', [] ),
				$attributes
			);
		}

		return $args;
	}

	/**
	 * Alters listing manage menu.
	 *
	 * @param array  $items Menu items.
	 * @param object $menu Menu object.
	 * @return array
	 */
	public function alter_listing_manage_menu( $items, $menu ) {
		if ( hivepress()->get_version( 'geolocation' ) && isset( $items['listing_view'] ) ) {

			// Get listing.
			$listing = $menu->get_context( 'listing' );

			if ( $listing && $listing->get_location() ) {
				$items['listing_location'] = [
					'label'  => esc_html__( 'Location', 'rentalhive' ),
					'url'    => $items['listing_view']['url'] . '#location',
					'_order' => 15,
				];
			}
		}

		return $items;
	}

	/**
	 * Alters listing view block.
	 *
	 * @param array $template Template arguments.
	 * @return array
	 */
	public function alter_listing_view_block( $template ) {
		if ( hivepress()->get_version( 'reviews' ) ) {
			$template = hivepress()->template->merge_blocks(
				$template,
				[
					'listing_header' => [
						'blocks' => [
							'listing_rating' => array_merge(
								hivepress()->template->fetch_block( $template, 'listing_rating' ),
								[
									'_order' => 5,
								]
							),
						],
					],
				]
			);
		}

		return hivepress()->template->merge_blocks(
			$template,
			[
				'listing_header' => [
					'blocks' => [
						'listing_category' => array_merge(
							hivepress()->template->fetch_block( $template, 'listing_category' ),
							[
								'_order' => 5,
							]
						),
					],
				],

				'listing_title'  => [
					'blocks' => [
						'listing_featured_badge' => array_merge(
							hivepress()->template->fetch_block( $template, 'listing_featured_badge' ),
							[
								'_order' => 30,
							]
						),
					],
				],
			]
		);
	}

	/**
	 * Alters listing view page.
	 *
	 * @param array $template Template arguments.
	 * @return array
	 */
	public function alter_listing_view_page( $template ) {
		$template = hivepress()->template->merge_blocks(
			$template,
			[
				'page_header'  => [
					'blocks'     => [
						'listing_category'        => array_merge(
							hivepress()->template->fetch_block( $template, 'listing_category' ),
							[
								'_order' => 5,
							]
						),

						'listing_title'           => hivepress()->template->fetch_block( $template, 'listing_title' ),
						'listing_details_primary' => hivepress()->template->fetch_block( $template, 'listing_details_primary' ),
						'page_topbar'             => hivepress()->template->fetch_block( $template, 'page_topbar' ),
						'listing_images'          => hivepress()->template->fetch_block( $template, 'listing_images' ),
					],

					'attributes' => [
						'class' => [ 'hp-listing', 'hp-listing--view-page' ],
					],
				],

				'page_sidebar' => [
					'blocks' => [
						'listing_topbar' => [
							'type'       => 'container',
							'_order'     => 10,

							'attributes' => [
								'class' => [ 'hp-listing__topbar', 'hp-widget', 'widget', 'widget--sidebar' ],
							],

							'blocks'     => [
								'listing_attributes_primary' => hivepress()->template->fetch_block( $template, 'listing_attributes_primary' ),
							],
						],
					],
				],
			]
		);

		if ( hivepress()->get_version( 'reviews' ) ) {
			$template = hivepress()->template->merge_blocks(
				$template,
				[
					'listing_topbar' => [
						'blocks' => [
							'listing_rating' => array_merge(
								hivepress()->template->fetch_block( $template, 'listing_rating' ),
								[
									'_order' => 20,
								]
							),
						],
					],
				]
			);
		}

		if ( hivepress()->get_version( 'geolocation' ) ) {
			$template = hivepress()->template->merge_blocks(
				$template,
				[
					'page_content' => [
						'blocks' => [
							'location_container' => [
								'type'   => 'section',
								'title'  => esc_html__( 'Location', 'rentalhive' ),
								'_order' => 90,

								'blocks' => [
									'listing_map' => hp\merge_arrays(
										hivepress()->template->fetch_block( $template, 'listing_map' ),
										[
											'_order'     => 10,

											'attributes' => [
												'id' => 'location',
												'data-height' => 200,
											],
										]
									),
								],
							],
						],
					],
				]
			);
		}

		return $template;
	}

	/**
	 * Alters listings view page.
	 *
	 * @param array  $template_args Template arguments.
	 * @param object $template Template object.
	 * @return array
	 */
	public function alter_listings_view_page( $template_args, $template ) {
		$model = $template::get_meta( 'model' );

		if ( ! $model ) {
			return $template_args;
		}

		$template_args = hivepress()->template->merge_blocks(
			$template_args,
			[
				'page_topbar' => [
					'blocks' => [
						$model . '_map_toggle' => [
							'type'       => 'toggle',
							'icon'       => 'map',
							'_order'     => 15,

							'captions'   => [
								esc_html__( 'Show Map', 'rentalhive' ),
								esc_html__( 'Hide Map', 'rentalhive' ),
							],

							'attributes' => [
								'class'       => [ 'hp-link--hide-map' ],
								'data-toggle' => 'map',
							],
						],
					],
				],
			]
		);

		return hivepress()->template->merge_blocks(
			$template_args,
			[
				'page_content' => [
					'blocks' => [
						$model . '_map' => hp\merge_arrays(
							hivepress()->template->fetch_block( $template_args, $model . '_map' ),
							[
								'_order'     => 5,

								'attributes' => [
									'id'          => 'map',
									'data-height' => 200,
								],
							]
						),
					],
				],
			]
		);
	}

	/**
	 * Alters listing category view block.
	 *
	 * @param array $template Template arguments.
	 * @return array
	 */
	public function alter_listing_category_view_block( $template ) {
		return hivepress()->template->merge_blocks(
			$template,
			[
				'listing_category_header' => [
					'blocks' => [
						'listing_category_count' => hivepress()->template->fetch_block( $template, 'listing_category_count' ),
					],
				],

				'listing_category_name'   => [
					'tag' => 'h3',
				],
			]
		);
	}

	/**
	 * Alters vendor view block.
	 *
	 * @param array  $blocks Block arguments.
	 * @param object $template Template object.
	 * @return array
	 */
	public function alter_vendor_view_block( $blocks, $template ) {

		// Get vendor.
		$vendor = $template->get_context( 'vendor' );

		if ( $vendor ) {

			// Get listing count.
			$listing_count = hivepress()->cache->get_user_cache( $vendor->get_user__id(), 'listing_count', 'models/listing' );

			if ( ! is_null( $listing_count ) && $vendor->get_listing_count() !== $listing_count ) {

				// Set listing count.
				$vendor->set_listing_count( $listing_count )->save_listing_count();
			}
		}

		if ( hivepress()->get_version( 'reviews' ) ) {
			$blocks = hivepress()->template->merge_blocks(
				$blocks,
				[
					'vendor_rating' => [
						'_order' => 5,
					],
				]
			);
		}

		return $blocks;
	}
}
