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
	

	if (!function_exists('scenic_register_type_destinations')) {
		function scenic_register_type_destinations() {
			
			/**
			 * [a]	Define the labels for our post type
			 */
			
			$labels = array(
				'name'					=> _x('Places to visit',		'Post Type General Name', 	'scenic'),
				'singular_name'			=> _x('Place to visit',			'Post Type Singular Name',	'scenic'),
				'menu_name'				=> __('Places to visit',		'scenic'),
				'parent_item_colon'		=> __('Parent destination:',	'scenic'),
				'all_items'				=> __('All destinations',		'scenic'),
				'view_item'				=> __('View destination',		'scenic'),
				'add_new_item'			=> __('Add new destination',	'scenic'),
				'add_new'				=> __('Add new',				'scenic'),
				'edit_item'				=> __('Edit destination',		'scenic'),
				'update_item'			=> __('Update destination',		'scenic'),
				'search_items'			=> __('Search destinations',	'scenic'),
				'not_found'				=> __('Not found',				'scenic'),
				'not_found_in_trash'	=> __('Not found in trash',		'scenic'),
			);


			/**
			 * [b]	Define the permalinks for the post type
			 */
			
			$rewrite = array(
				'slug'					=> 'destinations',
				'with_front'			=> true,
				'pages'					=> true,
				'feeds'					=> true,
			);


			/**
			 * [c]	Define settings for the post type
			 */
			
			$args = array(
				'label'					=> __('Places to visit',														'scenic'),
				'description'			=> __('Places you can visit on the UK & Ireland\'s most scenic bus routes.',	'scenic'),
				'labels'				=> $labels,
				'supports'				=> array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes'),
				'taxonomies'			=> array('route__locations'),
				'hierarchical'			=> true,
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
			
			register_post_type('destinations', $args);
		}


		/**
		 * [e]	Hook into plugin activation
		 */
		
		add_action('init', 'scenic_register_type_destinations', 0);
	}

?>