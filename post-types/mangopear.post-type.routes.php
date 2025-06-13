<?php

	/**
	 * Register custom post type for the website: Bus & train routes [routes]
	 *
	 * @category 	Post types
	 * @package  	scenic-buses
	 * @author  	Andi North <andi@mangopear.co.uk>
	 * @copyright  	2017 Mangopear creative
	 * @license   	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
	 * @version  	3.1.0
	 * @link 		https://mangopear.co.uk/
	 * @since   	3.1.0
	 */
	

	/**
	 * Contents
	 *
	 * [1]	Register post type: Routes
	 * [2]	Register taxonomy: Route locations
	 * [5]	Register taxonomy: Tickets
	 */
	

	/**
	 * [1]	Register post type: Routes
	 *
	 * 		[a]	Define the labels for our post type
	 * 		[b]	Define the permalinks for the post type
	 * 		[c]	Define settings for the post type
	 * 		[d]	Register the post type in WordPress
	 * 		[e]	Hook into plugin activation
	 */
	

	if (!function_exists('mangopear_register_type_routes')) {
		function mangopear_register_type_routes() {
			
			/**
			 * [a]	Define the labels for our post type
			 */
			
			$labels = array(
				'name'					=> _x('Routes',				'Post Type General Name', 	'mangopear'),
				'singular_name'			=> _x('Route',				'Post Type Singular Name',	'mangopear'),
				'menu_name'				=> __('Routes',				'mangopear'),
				'parent_item_colon'		=> __('Parent route:',		'mangopear'),
				'all_items'				=> __('All routes',			'mangopear'),
				'view_item'				=> __('View route',			'mangopear'),
				'add_new_item'			=> __('Add new route',		'mangopear'),
				'add_new'				=> __('Add new',			'mangopear'),
				'edit_item'				=> __('Edit route',			'mangopear'),
				'update_item'			=> __('Update route',		'mangopear'),
				'search_items'			=> __('Search routes',		'mangopear'),
				'not_found'				=> __('Not found',			'mangopear'),
				'not_found_in_trash'	=> __('Not found in trash',	'mangopear'),
			);


			/**
			 * [b]	Define the permalinks for the post type
			 */
			
			$rewrite = array(
				'slug'					=> 'routes',
				'with_front'			=> true,
				'pages'					=> true,
				'feeds'					=> true,
				'ep_mask'				=> EP_PERMALINK,
			);


			/**
			 * [c]	Define settings for the post type
			 */
			
			$args = array(
				'label'					=> __('routes',																'mangopear'),
				'description'			=> __('Bus and train routes across the UK', 								'mangopear'),
				'labels'				=> $labels,
				'supports'				=> array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'page-attributes'),
				'taxonomies'			=> array('route__locations', 'route__genres', 'route__collections', 'tickets', 'operators'),
				'hierarchical' 			=> true,
				'public'				=> true,
				'show_ui'				=> true,
				'show_in_menu'			=> true,
				'menu_icon'				=> 'dashicons-rest-api',
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
			
			register_post_type('routes', $args);
		}


		/**
		 * [e]	Hook into plugin activation
		 */
		
		add_action('init', 'mangopear_register_type_routes', 0);
	}





	/**
	 * [2]	Register taxonomy: Route locations
	 */
	
	if (! function_exists('mangopear_register_taxonomy_route_locations')) {
		function mangopear_register_taxonomy_route_locations() {
			$labels = array(
				'name'                       => _x('Locations', 							'Taxonomy General Name', 	'mangopear'),
				'singular_name'              => _x('Location', 								'Taxonomy Singular Name', 	'mangopear'),
				'menu_name'                  => __('Locations', 							'mangopear'),
				'all_items'                  => __('All locations', 						'mangopear'),
				'parent_item'                => __('Parent location', 						'mangopear'),
				'parent_item_colon'          => __('Parent location:', 						'mangopear'),
				'new_item_name'              => __('New location', 							'mangopear'),
				'add_new_item'               => __('Add new location', 						'mangopear'),
				'edit_item'                  => __('Edit location', 						'mangopear'),
				'update_item'                => __('Update location', 						'mangopear'),
				'separate_items_with_commas' => __('Separate locations with commas', 		'mangopear'),
				'search_items'               => __('Search locations', 						'mangopear'),
				'add_or_remove_items'        => __('Add or remove locations', 				'mangopear'),
				'choose_from_most_used'      => __('Choose from the most used locations', 	'mangopear'),
				'not_found'                  => __('Category not found', 					'mangopear'),
			);


			$rewrite = array(
				'slug'                       => 'locations',
				'with_front'                 => true,
				'hierarchical'               => true,
			);


			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => false,
				'query_var'                  => 'route__locations',
				'rewrite'                    => $rewrite,
				'show_in_rest'				 => true,
			);


			register_taxonomy('route__locations', array('routes'), $args);
		}


		add_action('init', 'mangopear_register_taxonomy_route_locations', 0);
	}





	/**
	 * [3]	Register taxonomy: Route collections
	 */
	
	if (! function_exists('mangopear_register_taxonomy_route_collections')) {
		function mangopear_register_taxonomy_route_collections() {
			$labels = array(
				'name'                       => _x('Collections', 							'Taxonomy General Name', 	'mangopear'),
				'singular_name'              => _x('Collection', 							'Taxonomy Singular Name', 	'mangopear'),
				'menu_name'                  => __('Collections', 							'mangopear'),
				'all_items'                  => __('All collections', 						'mangopear'),
				'parent_item'                => __('Parent collection', 					'mangopear'),
				'parent_item_colon'          => __('Parent collection:', 					'mangopear'),
				'new_item_name'              => __('New collection', 						'mangopear'),
				'add_new_item'               => __('Add new collection', 					'mangopear'),
				'edit_item'                  => __('Edit collection', 						'mangopear'),
				'update_item'                => __('Update collection', 					'mangopear'),
				'separate_items_with_commas' => __('Separate collections with commas', 		'mangopear'),
				'search_items'               => __('Search collections', 					'mangopear'),
				'add_or_remove_items'        => __('Add or remove collections', 			'mangopear'),
				'choose_from_most_used'      => __('Choose from the most used collections', 'mangopear'),
				'not_found'                  => __('Category not found', 					'mangopear'),
			);


			$rewrite = array(
				'slug'                       => 'collections',
				'with_front'                 => true,
				'hierarchical'               => true,
			);


			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => false,
				'query_var'                  => 'route__collections',
				'rewrite'                    => $rewrite,
				'show_in_rest'				 => true,
			);


			register_taxonomy('route__collections', array('routes'), $args);
		}


		add_action('init', 'mangopear_register_taxonomy_route_collections', 0);
	}





	/**
	 * [4]	Register taxonomy: Operators
	 */
	
	if (! function_exists('mangopear_register_taxonomy_operators')) {
		function mangopear_register_taxonomy_operators() {
			$labels = array(
				'name'                       => _x('Operators', 							'Taxonomy General Name', 	'mangopear'),
				'singular_name'              => _x('Operator', 								'Taxonomy Singular Name', 	'mangopear'),
				'menu_name'                  => __('Operators', 							'mangopear'),
				'all_items'                  => __('All operators', 						'mangopear'),
				'parent_item'                => __('Parent operator', 					'mangopear'),
				'parent_item_colon'          => __('Parent operator:', 					'mangopear'),
				'new_item_name'              => __('New operator', 						'mangopear'),
				'add_new_item'               => __('Add new operator', 					'mangopear'),
				'edit_item'                  => __('Edit operator', 						'mangopear'),
				'update_item'                => __('Update operator', 					'mangopear'),
				'separate_items_with_commas' => __('Separate operators with commas', 		'mangopear'),
				'search_items'               => __('Search operators', 					'mangopear'),
				'add_or_remove_items'        => __('Add or remove operators', 			'mangopear'),
				'choose_from_most_used'      => __('Choose from the most used operators', 'mangopear'),
				'not_found'                  => __('Category not found', 					'mangopear'),
			);


			$rewrite = array(
				'slug'                       => 'operators',
				'with_front'                 => true,
				'hierarchical'               => true,
			);


			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => true,
				'query_var'                  => 'operators',
				'rewrite'                    => $rewrite,
				'show_in_rest'				 => true,
			);


			register_taxonomy('operators', array('routes'), $args);
		}


		add_action('init', 'mangopear_register_taxonomy_operators', 0);
	}





	/**
	 * [5]	Register taxonomy: Tickets
	 */
	
	if (! function_exists('mangopear_register_taxonomy_tickets')) {
		function mangopear_register_taxonomy_tickets() {
			$labels = array(
				'name'                       => _x('Tickets', 							'Taxonomy General Name', 	'mangopear'),
				'singular_name'              => _x('Ticket', 							'Taxonomy Singular Name', 	'mangopear'),
				'menu_name'                  => __('Tickets', 							'mangopear'),
				'all_items'                  => __('All tickets', 						'mangopear'),
				'parent_item'                => __('Parent ticket', 					'mangopear'),
				'parent_item_colon'          => __('Parent ticket:', 					'mangopear'),
				'new_item_name'              => __('New ticket', 						'mangopear'),
				'add_new_item'               => __('Add new ticket', 					'mangopear'),
				'edit_item'                  => __('Edit ticket', 						'mangopear'),
				'update_item'                => __('Update ticket', 					'mangopear'),
				'separate_items_with_commas' => __('Separate tickets with commas', 		'mangopear'),
				'search_items'               => __('Search tickets', 					'mangopear'),
				'add_or_remove_items'        => __('Add or remove tickets', 			'mangopear'),
				'choose_from_most_used'      => __('Choose from the most used tickets', 'mangopear'),
				'not_found'                  => __('Category not found', 				'mangopear'),
			);


			$rewrite = array(
				'slug'                       => 'tickets',
				'with_front'                 => true,
				'hierarchical'               => true,
			);


			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => true,
				'query_var'                  => 'tickets',
				'rewrite'                    => $rewrite,
				'show_in_rest'				 => true,
			);


			register_taxonomy('tickets', array('routes'), $args);
		}


		add_action('init', 'mangopear_register_taxonomy_tickets', 0);
	}





	/**
	 * [3]	Register taxonomy: Route genres
	 */
	
	if (! function_exists('mangopear_register_taxonomy_route_genres')) {
		function mangopear_register_taxonomy_route_genres() {
			$labels = array(
				'name'                       => _x('Genres', 							'Taxonomy General Name', 	'mangopear'),
				'singular_name'              => _x('Genre', 							'Taxonomy Singular Name', 	'mangopear'),
				'menu_name'                  => __('Genres', 							'mangopear'),
				'all_items'                  => __('All genres', 						'mangopear'),
				'parent_item'                => __('Parent genre', 					'mangopear'),
				'parent_item_colon'          => __('Parent genre:', 					'mangopear'),
				'new_item_name'              => __('New genre', 						'mangopear'),
				'add_new_item'               => __('Add new genre', 					'mangopear'),
				'edit_item'                  => __('Edit genre', 						'mangopear'),
				'update_item'                => __('Update genre', 					'mangopear'),
				'separate_items_with_commas' => __('Separate genres with commas', 		'mangopear'),
				'search_items'               => __('Search genres', 					'mangopear'),
				'add_or_remove_items'        => __('Add or remove genres', 			'mangopear'),
				'choose_from_most_used'      => __('Choose from the most used genres', 'mangopear'),
				'not_found'                  => __('Category not found', 					'mangopear'),
			);


			$rewrite = array(
				'slug'                       => 'genres',
				'with_front'                 => true,
				'hierarchical'               => true,
			);


			$args = array(
				'labels'                     => $labels,
				'hierarchical'               => true,
				'public'                     => true,
				'show_ui'                    => true,
				'show_admin_column'          => true,
				'show_in_nav_menus'          => true,
				'show_tagcloud'              => false,
				'query_var'                  => 'route__genres',
				'rewrite'                    => $rewrite,
				'show_in_rest'				 => true,
			);


			register_taxonomy('route__genres', array('routes'), $args);
		}


		add_action('init', 'mangopear_register_taxonomy_route_genres', 0);
	}
	
?>