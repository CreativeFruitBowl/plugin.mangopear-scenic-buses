<?php

	/**
	 * Register custom post type for the website: Attractions [attractions]
	 *
	 * @category 	Post types
	 * @package  	scenic-buses
	 * @author  	Andi North <andi@scenic.co.uk>
	 * @copyright  	2023 scenic creative
	 * @license   	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
	 * @version  	3.2.0
	 * @link 		https://scenic.co.uk/
	 * @since   	3.2.0
	 */
	

	/**
	 * Contents
	 *
	 * [1]	Register post type: Attractions
	 */
	

	/**
	 * [1]	Register post type: Attractions
	 *
	 * 		[a]	Define the labels for our post type
	 * 		[b]	Define the permalinks for the post type
	 * 		[c]	Define settings for the post type
	 * 		[d]	Register the post type in WordPress
	 * 		[e]	Hook into plugin activation
	 */
	

	if (!function_exists('scenic_register_type_attractions')) {
		function scenic_register_type_attractions() {
			
			/**
			 * [a]	Define the labels for our post type
			 */
			
			$labels = array(
				'name'					=> _x('Things to do',			'Post Type General Name', 	'scenic'),
				'singular_name'			=> _x('Thing to do',			'Post Type Singular Name',	'scenic'),
				'menu_name'				=> __('Things to do',			'scenic'),
				'parent_item_colon'		=> __('Parent attraction:',		'scenic'),
				'all_items'				=> __('All attractions',		'scenic'),
				'view_item'				=> __('View attraction',		'scenic'),
				'add_new_item'			=> __('Add new attraction',		'scenic'),
				'add_new'				=> __('Add new',				'scenic'),
				'edit_item'				=> __('Edit attraction',		'scenic'),
				'update_item'			=> __('Update attraction',		'scenic'),
				'search_items'			=> __('Search attractions',		'scenic'),
				'not_found'				=> __('Not found',				'scenic'),
				'not_found_in_trash'	=> __('Not found in trash',		'scenic'),
			);


			/**
			 * [b]	Define the permalinks for the post type
			 */
			
			$rewrite = array(
				'slug'					=> 'attractions',
				'with_front'			=> true,
				'pages'					=> true,
				'feeds'					=> true,
			);


			/**
			 * [c]	Define settings for the post type
			 */
			
			$args = array(
				'label'					=> __('Attractions',																'scenic'),
				'description'			=> __('Attractions you can reach on the UK & Ireland\'s most scenic bus routes.',	'scenic'),
				'labels'				=> $labels,
				'supports'				=> array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
				'taxonomies'			=> array('route__locations'),
				'hierarchical'			=> false,
				'public'				=> true,
				'show_ui'				=> true,
				'show_in_menu'			=> true,
				'menu_icon'				=> 'dashicons-location',
				'show_in_nav_menus'		=> false,
				'show_in_admin_bar'		=> true,
				'menu_position'			=> 45,
				'can_export'			=> true,
				'has_archive'			=> true,
				'exclude_from_search'	=> false,
				'publicly_queryable'	=> true,
				'rewrite'				=> $rewrite,
				'capability_type'		=> 'page',
				'show_in_rest'			=> true,
			);


			/**
			 * [d]	Register the post type in WordPress
			 */
			
			register_post_type('attractions', $args);
		}


		/**
		 * [e]	Hook into plugin activation
		 */
		
		add_action('init', 'scenic_register_type_attractions', 0);
	}





	/**
	 * [2]	Register taxonomy: Route locations
	 */
	
	if (! function_exists('scenic_register_taxonomy_attraction_types')) {
		function scenic_register_taxonomy_attraction_types() {
			$labels = array(
				'name'                       => _x('Attraction types', 					'Taxonomy General Name', 	'mangopear'),
				'singular_name'              => _x('Attraction type', 					'Taxonomy Singular Name', 	'mangopear'),
				'menu_name'                  => __('Attraction types', 					'mangopear'),
				'all_items'                  => __('All types', 						'mangopear'),
				'parent_item'                => __('Parent type', 						'mangopear'),
				'parent_item_colon'          => __('Parent type:', 						'mangopear'),
				'new_item_name'              => __('New type', 							'mangopear'),
				'add_new_item'               => __('Add new type', 						'mangopear'),
				'edit_item'                  => __('Edit type', 						'mangopear'),
				'update_item'                => __('Update type', 						'mangopear'),
				'separate_items_with_commas' => __('Separate types with commas', 		'mangopear'),
				'search_items'               => __('Search types', 						'mangopear'),
				'add_or_remove_items'        => __('Add or remove types', 				'mangopear'),
				'choose_from_most_used'      => __('Choose from the most used types', 	'mangopear'),
				'not_found'                  => __('Category not found', 				'mangopear'),
			);


			$rewrite = array(
				'slug'                       => 'attractions/types',
				'with_front'                 => true,
				'hierarchical'               => true,
			);


			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => false,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => false,
				'query_var'                  => 'attraction_types',
				'rewrite'                    => $rewrite,
				'show_in_rest'				 => true,
			);


			register_taxonomy('attraction_types', array('attractions'), $args);


		/*
			wp_insert_term('None selected', 'attraction_types', array('slug' => 'none'));
			wp_insert_term('Airport', 'attraction_types', array('slug' => 'airport'));
			wp_insert_term('Theme park', 'attraction_types', array('slug' => 'amusement_park'));
			wp_insert_term('Aquarium', 'attraction_types', array('slug' => 'aquarium'));
			wp_insert_term('Gallery', 'attraction_types', array('slug' => 'art_gallery'));
			wp_insert_term('Bakery', 'attraction_types', array('slug' => 'bakery'));
			wp_insert_term('Pub or bar', 'attraction_types', array('slug' => 'bar'));
			wp_insert_term('Beach', 'attraction_types', array('slug' => 'beach'));
			wp_insert_term('Book store', 'attraction_types', array('slug' => 'book_store'));
			wp_insert_term('Bowling abbey', 'attraction_types', array('slug' => 'bowling_alley'));
			wp_insert_term('Bus station', 'attraction_types', array('slug' => 'bus_station'));
			wp_insert_term('Cafe', 'attraction_types', array('slug' => 'cafe'));
			wp_insert_term('Campsite', 'attraction_types', array('slug' => 'campground'));
			wp_insert_term('Casino', 'attraction_types', array('slug' => 'casino'));
			wp_insert_term('Cemetery', 'attraction_types', array('slug' => 'cemetery'));
			wp_insert_term('Church', 'attraction_types', array('slug' => 'church'));
			wp_insert_term('City hall', 'attraction_types', array('slug' => 'city_hall'));
			wp_insert_term('Clothing store', 'attraction_types', array('slug' => 'clothing_store'));
			wp_insert_term('Local shop', 'attraction_types', array('slug' => 'convenience_store'));
			wp_insert_term('Department store', 'attraction_types', array('slug' => 'department_store'));
			wp_insert_term('Hindu Temple', 'attraction_types', array('slug' => 'hindu_temple'));
			wp_insert_term('Historical landmark', 'attraction_types', array('slug' => 'historical_landmark'));
			wp_insert_term('Hospital', 'attraction_types', array('slug' => 'hospital'));
			wp_insert_term('Jewellery store', 'attraction_types', array('slug' => 'jewelry_store'));

			wp_insert_term('library', 'attraction_types', array('slug' => 'Library'));
			wp_insert_term('light_rail_station', 'attraction_types', array('slug' => 'Underground or tram stop'));
			wp_insert_term('lodging', 'attraction_types', array('slug' => 'Lodging'));
			wp_insert_term('meal_delivery', 'attraction_types', array('slug' => 'Food & drink'));
			wp_insert_term('meal_takeaway', 'attraction_types', array('slug' => 'Takeaway food & drink'));
			wp_insert_term('mosque', 'attraction_types', array('slug' => 'Mosque'));
			wp_insert_term('movie_theater', 'attraction_types', array('slug' => 'Cinema'));
			wp_insert_term('museum', 'attraction_types', array('slug' => 'Museum'));
			wp_insert_term('natural_feature', 'attraction_types', array('slug' => 'Natural landmark'));
			wp_insert_term('night_club', 'attraction_types', array('slug' => 'Night club'));
			wp_insert_term('park', 'attraction_types', array('slug' => 'Park'));
			wp_insert_term('pier', 'attraction_types', array('slug' => 'Pier'));
			wp_insert_term('restaurant', 'attraction_types', array('slug' => 'Restaurant'));
			wp_insert_term('rv_park', 'attraction_types', array('slug' => 'Caravan park'));
			wp_insert_term('shoe_store', 'attraction_types', array('slug' => 'Shoe shop'));
			wp_insert_term('shopping_mall', 'attraction_types', array('slug' => 'Shopping centre'));
			wp_insert_term('spa', 'attraction_types', array('slug' => 'Spa'));
			wp_insert_term('stadium', 'attraction_types', array('slug' => 'Stadium'));
			wp_insert_term('storage', 'attraction_types', array('slug' => 'Storage'));
			wp_insert_term('store', 'attraction_types', array('slug' => 'Shop'));
			wp_insert_term('subway_station', 'attraction_types', array('slug' => 'Underground or tram stop'));
			wp_insert_term('supermarket', 'attraction_types', array('slug' => 'Supermarket'));
			wp_insert_term('synagogue', 'attraction_types', array('slug' => 'Synagogue'));
			wp_insert_term('taxi_stand', 'attraction_types', array('slug' => 'Taxi stand'));
			wp_insert_term('tourist_attraction', 'attraction_types', array('slug' => 'Tourist attraction'));
			wp_insert_term('train_station', 'attraction_types', array('slug' => 'Railway station'));
			wp_insert_term('transit_station', 'attraction_types', array('slug' => 'Travel interchange'));
			wp_insert_term('university', 'attraction_types', array('slug' => 'University'));
			wp_insert_term('zoo', 'attraction_types', array('slug' => 'Zoo'));
		*/
		
		}


		add_action('init', 'scenic_register_taxonomy_attraction_types', 0);
	}

?>