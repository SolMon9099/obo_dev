<?php

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
function enqueue_parent_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

/**
 * Proper way to enqueue scripts and styles
 */
function wpdocs_theme_name_scripts() {
	wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'matchHeight',  'https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js', array(), '1.0.0', true );
	wp_enqueue_script( 'hivetheme-child-frontend', get_stylesheet_directory_uri() . '/assets/js/frontend.js', array('hivetheme-core-frontend', 'circle-progress'), '1.0.0', true );
	wp_enqueue_script( 'custom-script',  get_stylesheet_directory_uri() . '/js/custom-script.js');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );

//dequeue your required script file
function your_child_theme_js_file_dequeue() {
   wp_dequeue_script( 'hivetheme-parent-frontend' );
}
add_action( 'wp_print_scripts', 'your_child_theme_js_file_dequeue', 100 );


function custom_map_function() {
	$return_var = '
	<div class="map-wrapper">
	<div class="filters-wrapper-wrapper">
		<div class="filters-wrapper">
			<div class="drawers">
				<div class="drawer pursuit-drawer">
					<button class="drawer-btn pursuit-drawer-btn">Pursuit</button>
					<div class="drawer-dropdown pursuit-drawer-dropdown">
						<div id="pursuit_container"></div>
					</div>
				</div>
				<div class="drawer species-drawer">
					<button class="drawer-btn species-drawer-btn">Species</button>
					<div class="drawer-dropdown species-drawer-dropdown">
						<div id="species_container"></div>
					</div>
				</div>
			</div>
			<button class="clear-filters">Clear Filters</button>
		</div>
		<div class="mobile-fitler-btns">
			<button class="mobile-fitler-btn mobile-filter-pursuit-btn" data-toggle="mobile_pursuit_container">
				<img src="/wp-content/themes/rentalhive-child/images/pursuit.svg" class="non-active">
				<img src="/wp-content/themes/rentalhive-child/images/pursuit-white.svg" class="active">
			</button>
			<button class="mobile-fitler-btn mobile-filter-species-btn" data-toggle="mobile_species_container">
				<img src="/wp-content/themes/rentalhive-child/images/species.svg" class="non-active">
				<img src="/wp-content/themes/rentalhive-child/images/species-white.svg" class="active">
			</button>
		</div>
	</div>

	<div id="map"></div>


	<div class="mobile-drawers">
		<div id="mobile_experience_container" class="mobile-filter-container"></div>
		<div id="mobile_pursuit_container" class="mobile-filter-container"></div>
		<div id="mobile_species_container" class="mobile-filter-container"></div>
	</div>
	</div>

	<script>
	(function($){
		var all_markers = [];
		function checkMapLoaded() {
		  	if (typeof google === "undefined")
			{
				setTimeout(checkMapLoaded,1000);
			}
		}
		
		// Initialize and add the map
		function initMap() {
		  const us = { lat: 30.900521858748274, lng: -83.70663650396979 };
		  var stylers = [
				{
					"featureType": "all",
					"elementType": "labels.text",
					"stylers": [
						{
							"visibility": "off"
						}
					]
				},
				{
					"featureType": "all",
					"elementType": "labels.icon",
					"stylers": [
						{
							"visibility": "off"
						}
					]
				},
				{
					"featureType": "landscape",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#F1E9E1"
						}
					]
				},
				{
					"featureType": "landscape.man_made",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"visibility": "on"
						},
						{
							"gamma": "1.19"
						}
					]
				},
				{
					"featureType": "landscape.man_made",
					"elementType": "geometry.stroke",
					"stylers": [
						{
							"visibility": "on"
						},
						{
							"gamma": "0.00"
						},
						{
							"weight": "2.07"
						}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#b2ac83"
						}
					]
				},
				{
					"featureType": "road.highway",
					"elementType": "geometry.stroke",
					"stylers": [
						{
							"color": "#b2ac83"
						}
					]
				},
				{
					"featureType": "water",
					"elementType": "geometry.fill",
					"stylers": [
						{
							"color": "#8ac0c4"
						}
					]
				}
			]


		  const map = new google.maps.Map(document.getElementById("map"), {
			zoom: 6,
			center: us,
			styles : stylers,
			zoomControl: true,
			mapTypeControl: true,
			mapTypeControlOptions: {
				position: google.maps.ControlPosition.RIGHT_BOTTOM,
			},
  			scaleControl: false,
  			streetViewControl: false,
			fullscreenControl: false
		  });

	';




	$args = array(
		'post_type' => 'hp_listing',
		'posts_per_page' => -1,
		'post_status' => 'publish'
	);

	$post_query = new WP_Query($args);


	if($post_query->have_posts() ) {
		while($post_query->have_posts() ) {

			$count++;

			$post_query->the_post();

			$meta = get_post_meta( get_the_ID() );


			$lat = get_post_meta( get_the_ID(), 'hp_latitude', true );
			$long = get_post_meta( get_the_ID(), 'hp_longitude', true );

			$loc = get_post_meta( get_the_ID(), 'hp_location', true );

			$categories_pursuit = get_the_terms( get_the_ID(), 'hp_listing_category' );
			$categories_species = get_the_terms( get_the_ID(), 'hp_listing_tags' );

			$title = get_the_title();
			$perma = get_the_permalink();

			$return_var .= '
				var species_container = $("#species_container");
				var pursuit_container = $("#pursuit_container");
				var experience_container = $("experience_container")
				var mobile_species_container = $("#mobile_species_container");
				var mobile_pursuit_container = $("#mobile_pursuit_container");
				var mobile_experience_container = $("mobile_experience_container");
				var oms = new OverlappingMarkerSpiderfier(map, {
				  markersWontMove: true,
				  markersWontHide: true,
				  basicFormatEvents: true
				});';

			$return_var .=
				'
				var marker_icon = "/wp-content/themes/rentalhive-child/images/map_marker.svg";';

			$return_var .=	
				'
				var geocoder = new google.maps.Geocoder();
					geocoder.geocode( { "address": "' . $loc . '"}, function(results, status) {
					
					 if (status == google.maps.GeocoderStatus.OK) {
					 	var coord = results[0].geometry.location;
					 }
					
					  
						var cat = [];
					  	';
			
						$species_cat_out = [];
						$pursuit_cat_out = [];

						foreach ($categories_species as $category) {
							$return_var .= 'cat.push("' . $category->name . '");';
							array_push($species_cat_out, $category->name);
						}

						foreach ($categories_pursuit as $category) {
							$return_var .= 'cat.push("' . $category->name . '");';
							array_push($pursuit_cat_out, $category->name);
						}

						$species_cat_out = implode(", ",$species_cat_out);
						$pursuit_cat_out = implode(", ",$pursuit_cat_out);

						
						if( !empty($lat) ) {
							$return_var .= 
							'
							coord = { lat: ' . $lat . ', lng: ' . $long . ' };';
						}
							 
						$return_var .=
						'var marker = new google.maps.Marker({
							position: coord,
							map: map,
							title: "' . $title .'",
							icon: marker_icon,
							tags: cat,
							content: "<div class=\'loop-room-short-attributes mphb_sc_rooms-wrapper\' style=\'flex-direction:column;margin-bottom:0; border:0px; padding:0;\'><h2 style=\'margin-bottom:0;\'>' . $title . '</h2>';


			if (($species_cat_out) != "") {
				$return_var .= '<p><b>Species</b>: ' . $species_cat_out . '</p>';
			}

			if (($pursuit_cat_out) != "") {
				$return_var .= '<p><b>Pursuits</b>: ' . $pursuit_cat_out . '</p>';
			}


			$return_var .= '<a href=' . $perma . '><button class=\'button\'>VIEW</button></a>' . '</div>"' .
				'})

						all_markers.push(marker);
						var infowindow = new google.maps.InfoWindow();
						google.maps.event.addListener(marker, "spider_click", function() {
							infowindow.setContent(this.content);
							infowindow.open(map, this);
						});
						oms.addMarker(marker);

					 
				});';
		}
	}

	wp_reset_postdata(); 

	$return_var .= '
			}

			window.initMap = initMap;

			filterAll = function (y) {
				var checkBoxes = $(":checkbox[name^=species]:checked");
				
				var category = [];
				for (const checkbox of checkBoxes) {
					category.push(checkbox.value);
				}


				if ( category === undefined || category.length == 0 ) {
					for (a = 0; a < all_markers.length; a++) {
						all_markers[a].setVisible(true);
					}
				} else {
					for (i = 0; i < all_markers.length; i++) {
						var hasCat = false,
						hasCatTag = false,
						hasCatTitle = false;

						marker = all_markers[i];	

						for (j = 0; j < category.length; j++) {
							if ( marker.tags.includes(category[j]) ) {
								hasCat = true;
							} else {
								hasCat = false;
							}
						}

						if (hasCat) {
							marker.setVisible(true);
						} else {
							marker.setVisible(false);
						}
					}
				}
			}


			$(document).ready(function() {';
	/*

	$args = [
		'taxonomy'     => 'hp_listing_tags',
		'parent'        => 0,
		'number'        => 10,
		'hide_empty'    => false
	];
	$categories_species = get_terms( $args );*/
	$parent_categories_species = get_terms( 'hp_listing_category', array( 'parent' => 0 ) );

	$categories_species = [];

	foreach ($parent_categories_species as $parent_category) {
		$parent_category_id = $parent_category->term_id;
		$child_categories_species = get_term_children( $parent_category_id, 'hp_listing_category' );
		foreach ($child_categories_species as $child_category_id) {
			array_push($categories_species, $child_category_id);
		}
	}

	foreach ($categories_species as $category_id) {
		$category = get_term($category_id);
		$return_var .= '
				$("<div><input type=\"checkbox\" id=\"' . $category->slug . '\" value=\"' . $category->name . '\" name=\"species\"><label for=\"' . $category->slug . '\" text=\"' . $category->name . '\"><div class=\"checkbox\"></div>' . $category->name . '</label></div>").appendTo(species_container);
										  $("<div><input type=\"checkbox\" id=\"mobile_' . $category->slug . '\" value=\"' . $category->name . '\" name=\"species\"><label for=\"mobile_' . $category->slug . '\" text=\"' . $category->name . '\"><div class=\"checkbox\"></div>' . $category->name . '</label></div>").appendTo(mobile_species_container);
										  ';
	}


	$args = [
		'taxonomy'     => 'hp_listing_category',
		'parent'        => 0,
		'number'        => 10,
		'hide_empty'    => false
	];
	$categories_pursuit = get_terms( $args );

	foreach ($categories_pursuit as $category) {

		$return_var .= '
											  $("<div><input type=\"checkbox\" id=\"' . $category->slug . '\" value=\"' . $category->name . '\" name=\"species\"><label for=\"' . $category->slug . '\" text=\"' . $category->name . '\"><div class=\"checkbox\"></div>' . $category->name . '</label></div>").appendTo(pursuit_container);
										  $("<div><input type=\"checkbox\" id=\"mobile_' . $category->slug . '\" value=\"' . $category->name . '\" name=\"species\"><label for=\"mobile_' . $category->slug . '\" text=\"' . $category->name . '\"><div class=\"checkbox\"></div>' . $category->name . '</label></div>").appendTo(mobile_pursuit_container);
										  ';
	}

	$return_var .= '

											  $("input[type=\'checkbox\']").change(function() {
											  filterAll();
										  });

										  $(".filters-wrapper-wrapper .filters-wrapper .search-wrapper .search-submit").click(function() {

											  filterAll();
										  });

										  $(".filters-wrapper-wrapper .filters-wrapper .search-wrapper .search-clear").click(function() {
											  $(".filters-wrapper-wrapper .filters-wrapper .search-wrapper input").val("");
											  $(this).parent().removeClass("hasInput");
											  filterAll();
										  });


										  $(".filters-wrapper-wrapper .filters-wrapper .clear-filters").click(function() {
											  $("input:checkbox").prop("checked", false);
											  $(".filters-wrapper-wrapper .filters-wrapper .search-wrapper input").val("");
											  for (i = 0; i < all_markers.length; i++) {
												  var hasCat = false;
												  marker = all_markers[i];
												  marker.setVisible(true);
											  }
										  });

										  $(".mobile-fitler-btn").click(function() {
											  var $show_group = "#" + $(this).attr("data-toggle");
											  $(".mobile-fitler-btn").not(this).each(function() {
												  $(this).removeClass("clicked");
											  });
											  $($show_group).show();
											  $(".mobile-filter-container").not($show_group).hide();
											  $(this).addClass("clicked");
										  });

										  $(".mobile-fitler-btn:first-of-type").click();


										  $(".drawer-btn").click(function() {
											  $(this).next().toggleClass("open");
											  $(this).toggleClass("open");
										  });
										 });
		})(jQuery);
		</script>';

	return $return_var;
}


add_shortcode('custom_map', 'custom_map_function');


function experience_loop_function() {
	$return_var = '
			<div class="hp-posts hp-block hp-grid">
			<div class="hp-row">';

	$args = array(
		'post_type' => 'experience',
		'posts_per_page' => 3
	);

	$post_query = new WP_Query($args);

	if($post_query->have_posts() ) {
		while($post_query->have_posts() ) {
			$post_query->the_post();

			$thumb = get_the_post_thumbnail_url();


			$return_var .= '
			<div class="hp-grid__item hp-col-sm-4 hp-col-xs-12">
			<article class="post--archive post-309 post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">';
			if ( get_the_post_thumbnail_url() ) {
				$return_var .= '<header class="post__header">
			<div class="post__image">
			<a href="' . get_the_permalink() . '">
			<img width="400" height="267" src="' . $thumb  . '" class="attachment-ht_landscape_small size-ht_landscape_small wp-post-image" alt="" loading="lazy">
			</a>
			</div>
			</header>';
			}

			$return_var .= '<div class="post__content">
			<h4 class="post__title">
			<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
			</h4>
			<div class="post__details">
			<time datetime="' . get_the_date( 'Y-m-d' ) . '" class="post__date">' . get_the_date( 'F j, Y' ) . '</time>
			</div>
			</div>
			</article>
			</div>
			';
		}
	}

	wp_reset_postdata();

	$return_var .= '</div></div>';

	return $return_var;
}



add_shortcode('experience_loop', 'experience_loop_function');


function full_experience_loop_function() {
	$return_var = '
			<div class="hp-posts hp-block hp-grid">
			<div class="hp-row">';

	$args = array(
		'post_type' => 'experience',
		'posts_per_page' => -1
	);

	$post_query = new WP_Query($args);

	if($post_query->have_posts() ) {
		while($post_query->have_posts() ) {
			$post_query->the_post();

			$thumb = get_the_post_thumbnail_url();


			$return_var .= '
			<div class="hp-grid__item hp-col-sm-4 hp-col-xs-12">
			<article class="post--archive post-309 post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized">';
			if ( get_the_post_thumbnail_url() ) {
				$return_var .= '<header class="post__header">
			<div class="post__image">
			<a href="' . get_the_permalink() . '">
			<img width="400" height="267" src="' . $thumb  . '" class="attachment-ht_landscape_small size-ht_landscape_small wp-post-image" alt="" loading="lazy">
			</a>
			</div>
			</header>';
			}

			$return_var .= '<div class="post__content">
			<h4 class="post__title">
			<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
			</h4>
			<div class="post__details">
			<time datetime="' . get_the_date( 'Y-m-d' ) . '" class="post__date">' . get_the_date( 'F j, Y' ) . '</time>
			</div>
			</div>
			</article>
			</div>
			';
		}
	}

	wp_reset_postdata();

	$return_var .= '</div></div>';

	return $return_var;
}



add_shortcode('full_experience_loop', 'full_experience_loop_function');


add_filter(
	'hivepress/v1/templates/listings_view_page',
	function( $template ) {
		return hivepress()->helper->merge_trees(
			$template,
			[
				'blocks' => [
					'listings' => [
						'columns' => 3,
					],
				],
			]
		);
	}
);

add_filter(
	'hivepress/v1/models/listing',
	function( $model ) {
		$model['fields']['images']['max_files'] = 20;

		return $model;
	},
	100
);



// Our custom post type function for experiences
function register_custom_post_types() {

	/**
     *
     * Custom Post Type : Experience
     */
	$expLabels = array(
		'name'                => _x('Experiences', 'Post Type General Name', 'our_framework_v3.2.3'),
		'singular_name'       => _x('Experience', 'Post Type Singular Name', 'our_framework_v3.2.3'),
		'menu_name'           => __('Experiences', 'our_framework_v3.2.3'),
		'parent_item_colon'   => __('Parent Experience', 'our_framework_v3.2.3'),
		'all_items'           => __('All Experiences', 'our_framework_v3.2.3'),
		'view_item'           => __('View Experience', 'our_framework_v3.2.3'),
		'add_new_item'        => __('Add Experience', 'our_framework_v3.2.3'),
		'add_new'             => __('Add New', 'our_framework_v3.2.3'),
		'edit_item'           => __('Edit Experience', 'our_framework_v3.2.3'),
		'update_item'         => __('Update Experience', 'our_framework_v3.2.3'),
		'search_items'        => __('Search Experience', 'our_framework_v3.2.3'),
		'not_found'           => __('Not Found', 'our_framework_v3.2.3'),
		'not_found_in_trash'  => __('Not found in Trash', 'our_framework_v3.2.3'),
	);

	register_post_type(
		'experience',
		array(
			'labels'              => $expLabels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt'  ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 8,
			'can_export'          => true,
			'rewrite'             => ['slug' => 'experience'],
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest'        => true,
			'menu_icon'           => 'dashicons-admin-site',
		)
	);
}
// Hooking up our function to theme setup
add_action('init', 'register_custom_post_types');

add_filter(
	'hivepress/v1/forms/listing_update/errors',
	function( $errors, $form ) {
		$listing = $form->get_model();

		if ( $listing && ! $listing->get_image__id() ) {
			$errors[] = 'Please upload at least one image.';
		}

		return $errors;
	},
	100,
	2
);

add_filter(
	'hivepress/v1/forms/listing_submit',
	function( $form ) {
		if(isset($form['fields']['categories'])){
			$form['fields']['categories']['label'] = "Pursuits";
			$form['fields']['categories']['description'] = "Select all that apply to your property, but limit it to 5 Pursuits";
			$form['fields']['categories']['multiple'] = true;	
		}
		if(isset($form['fields']['tags'])){
			$form['fields']['tags']['label'] = "Species Tags";
			$form['fields']['tags']['description'] = "List species that can be targeted near your property";
		}
		if(isset($form['fields']['price_extras'])){
			$form['fields']['price_extras']['label'] = "Pet Fees and Additional Guest Fees";
		}
		if(isset($form['fields']['price'])){
			$form['fields']['price']['label'] = "Price per night";
		}
		if(isset($form['fields']['location'])){
			$form['fields']['location']['label'] = "Address";
			$form['fields']['location']['description'] = "Street Address, Unit, City, State, Zip Code";
		}
		$form['fields']['images']['statuses']['optional'] = null;
		return $form;
	},
	1000
);


add_filter( 
	'hivepress/v1/models/listing/attributes', 
	function ($attributes){
		if(isset($attributes['tags'])){
			$attributes['tags']['edit_field']['max_values'] = 15;
		}
		
		return $attributes;
	},
	1000
);

add_filter(
	'hivepress/v1/forms/listing_search',
	function($form){
		if(isset($form['fields']['s'])){
			$form['fields']['s']['placeholder'] = 'Species or Activity';
		}
		
		return $form;
	},
	1000
);

?>
