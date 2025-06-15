<?php

	/**
	 * Plugin name: Scenic Buses
	 * Plugin URI:	https://mangopear.co.uk/
	 * Description:	Bespoke plugin for the Scenic Buses website - this includes post types and functions for searches and directory listings etc.
	 * Version:		3.0.0
	 * Author:		Andi North
	 * Author URI:	https://mangopear.co.uk
	 * License:		GNU General Public License
	 */
	

	/**
	 * Core mangopear website plugin
	 *
	 * @package  	scenic-buses
	 * @author  	Andi North <andi@mangopear.co.uk>
	 * @copyright  	2017 Mangopear creative
	 * @license   	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
	 * @version  	3.0.0
	 * @link 		https://mangopear.co.uk/
	 * @since   	3.0.0
	 */
	

	/**
	 * Contents
	 *
	 * [1]	Global variables
	 * [2]	Post type registration
	 * [3]	Register an options page for ACF
	 * [4]	Register our custom listing editing functionality
	 * [5]	Add custom CSS to admin for routes list
	 */
	

	/**
	 * [1]	Global variables
	 *
	 * 		These global variables are used throughout this document, typically to avoid repitition.
	 *
	 * 		[a]	$var to get the plugin directory URL
	 */
	
	$plugin_path = plugin_dir_path(__FILE__); // [a]





	/**
	 * [2]	Post type registration
	 *
	 * 		Group of includes for our various custom post types
	 *
	 * 		[a]	Routes, including taxonomies
	 * 		[b]	Custom URL rewrites for operators taxonomy
	 */

	require_once $plugin_path . 'post-types/mangopear.post-type.routes.php'; 				// [a]
	require_once $plugin_path . 'post-types/mangopear.post-type.destinations.php'; 			// [a]
	require_once $plugin_path . 'post-types/mangopear.post-type.attractions.php'; 			// [a]
	require_once $plugin_path . 'post-types/mangopear.post-type.reviews.php'; 				// [a]
	require_once $plugin_path . 'post-types/scenic.post-type.travelogues.php'; 				// [a]
	require_once $plugin_path . 'post-types/scenic.post-type.service-updates.php'; 			// [a]
	require_once $plugin_path . 'post-types/functions.custom-url-endpoints.operators.php'; 	// [b]





	/**
	 * [3]	Register an options page for ACF
	 *
	 * 		@since 1.0.0
	 *
	 * 		[a]	Add our include
	 */

	require_once $plugin_path . 'settings/settings.options-page.php'; 		// [a]





	/**
	 * [4]	Other custom functionality
	 *
	 * 		@since 10.0.0
	 *
	 * 		[a]	Custom user password reset process
	 */

	require_once $plugin_path . 'functions/functions.custom-password-reset-flow.php'; 	// [a]





	/**
	 * [5]	Register our custom listing editing functionality
	 *
	 * 		@since 1.0.0
	 *
	 * 		[a]	Add our include
	 */

	require_once $plugin_path . 'listing-editing/listing-editing.php'; 					// [a]