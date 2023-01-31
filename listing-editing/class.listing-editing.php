<?php

	/**
	 * Functionality to enable listing editing
	 *
	 * @package  	scenic
	 * @author  	Andi North <andi@mangopear.co.uk>
	 * @copyright  	2023 Mangopear creative
	 * @license   	GNU General Public License <http://opensource.org/licenses/gpl-license.php>
	 * @version  	1.0.0
	 * @since   	1.0.0
	 */
	

	/**
	 * Contents
	 *
	 * [1]	Global variables
	 * [2]	Include other files
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
	 * [2]	Include other files
	 *
	 * 		[a]	Custom URL endpoints for editing views
	 */

	require_once $plugin_path . 'functions.custom-url-endpoints.php'; 	// [a]