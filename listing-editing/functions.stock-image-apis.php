<?php

/**
 * [Stock image libraries] Fwtch stock images via API
 * 
 * @package     scenic-buses
 * @category    functions
 * @since       11.0.0
 * @version     11.0.0
 * @author  	Andi North <andi@theverycreativefruitbowl.co.uk>
 * @copyright  	2024 The Very Creative Fruit Bowl Company
 * @license   	Proprietary license - You can not use this code without permission
 */


/**
 * Contents
 *
 * [1]	Load the oAuth2 client for connecting to the API
 * [2]	Perform image search on Unsplash
 * [3]	Perform image search on Pixabay
 * [4]	Perform image search on Adobe Stock
 * [5]	Perform image search on Shutterstock
 * [6]	AJAX request handler for search requests
 * [7]	AJAX request handler for adding image to database
 */


/**
 * [1]	Load the oAuth2 client for connecting to the API
 *
 * 		@since 11.0.0
 *
 * 		[i]	Fetch our oAuth2 client files
 */

function scenic_load_api_client() {
	require(plugin_dir_path(__FILE__) . '../helpers/oauth2/Client.php');					// [i]
	require(plugin_dir_path(__FILE__) . '../helpers/oauth2/GrantType/IGrantType.php');		// [i]
	require(plugin_dir_path(__FILE__) . '../helpers/oauth2/GrantType/Password.php');		// [i]
}





/**
 * [2]	Perform image search on Unsplash
 *
 * 		@since 11.0.0
 *
 * 		[i]		Store our Unsplash API key and URL
 * 		[ii]	Define params for search query
 * 		[iii]	Perform the actual query using the oAuth2 Client
 * 		[iv]	If our API request is a success or failure
 * 		[v]		Return error message and error state
 * 		[vi]	Create new empty array for pushing our images to
 * 		[viii]	Loop through all returned images, pushing to our array
 * 		[ix]	Set "Unsplash" as the source of the image
 * 		[x]		Fetch alt and description
 * 		[xi]	Fetch ID of Pixabay asset and its popularity
 * 		[xii]	Fetch useful media URLs
 * 		[xiii]	Fetch media files
 * 		[xiv]	Fetch the name of the user who uploaded the image to Unsplash
 * 		[xv]	Return our images plus other useful data
 */

function scenic_stock_api_search_unsplash($client, $search, $page, $args) {
	$unsplash_url = 'https://api.unsplash.com/search/photos/';														// [i]
	$unsplash_key = '&client_id=vxvYgOYkWCI6VaamHGmIAxspxLMOky9zSGaUbX6KKjg';										// [i]

	$query__term  = urlencode($search);																				// [ii]
	$query__page  = ($page) ?: 1;																					// [ii]

	$response = $client->fetch(																						// [iii]
		$unsplash_url . '?query=' . $query__term . '&page=' . $query__page . '&per_page=30' . $unsplash_key,		// [iii]
		$args,																										// [iii]
		'GET',																										// [iii]
	);																												// [iii]



	if ($response['code'] == 200) :																					// [iv]
		$all_images = array();																						// [vii]


		foreach ($response['result']['results'] as $image) :														// [viii]
			$all_images[] = array(																					// [viii]
				'source'		=> 'Unsplash',																		// [ix]
				'fee'			=> 'Free!',																			// [ix]
				'alt'			=> $image['alt_description'],														// [x]
				'description'	=> $image['description'],															// [x]
				'id'			=> $image['id'],																	// [xi]
				'score'			=> $image['likes'],																	// [xi]
				'urls'	=> array(																					// [xii]
					'download'		=> $image['urls']['full'],														// [xii]
					'library'		=> $image['links']['html'],														// [xii]
					'raw'			=> $image['urls']['raw'],														// [xiii]
					'full'			=> $image['urls']['full'],														// [xiii]
					'medium'		=> $image['urls']['regular'],													// [xiii]
					'small'			=> $image['urls']['small'],														// [xiii]
					'thumb'			=> $image['urls']['thumb'],														// [xiii]
				),																									// [xii]
				'name'			=> $image['user']['name'],															// [xiv]
			);																										// [viii]
		endforeach;																									// [viii]


		return array(																								// [xv]
			'images' 	=> $all_images,																				// [xv]
			'response' 	=> $response,																				// [xv]
			'page'		=> $query__page,																			// [xv]
			'totals'	=> array(																					// [xv]
				'found'		=> $response['result']['total'],														// [xv]
				'returned'	=> count($response['result']['results']),												// [xv]
			),																										// [xv]
			'status' 	=> 200,																						// [xv]
		);																											// [xv]



	else :																											// [iv]
		return array(																								// [v]
			'response' 	=> $response,																				// [v]
			'status' 	=> 500,																						// [v]
		);																											// [v]
	endif;																											// [iv]
}





/**
 * [2]	Perform image search on Pixabay
 *
 * 		@since 11.0.0
 *
 * 		[i]		Store our Pixabay API key and URL
 * 		[ii]	Define params for search query
 * 		[iii]	Perform the actual query using the oAuth2 Client
 * 		[iv]	If our API request is a success or failure
 * 		[v]		Return error message and error state
 * 		[vi]	Create new empty array for pushing our images to
 * 		[viii]	Loop through all returned images, pushing to our array
 * 		[ix]	Set "Pixabay" as the source of the image
 * 		[x]		Fetch alt and description
 * 		[xi]	Fetch ID of Pixabay asset and its popularity
 * 		[xii]	Fetch useful media URLs
 * 		[xiii]	Fetch media files
 * 		[xiv]	Set user who uploaded's name to Pixabay
 * 		[xv]	Return our images plus other useful data
 */

function scenic_stock_api_search_pixabay($client, $search, $page, $args) {
	$pixabay_url = 'https://pixabay.com/api/?image_type=photo&pretty=true';											// [i]
	$pixabay_key = '&key=42626386-e6bc272ecd2ab2a98970c6884';														// [i]

	$query__term  = urlencode($search);																				// [ii]
	$query__page  = ($page) ?: 1;																					// [ii]

	$response = $client->fetch(																						// [iii]
		$pixabay_url . '&q=' . $query__term . '&page=' . $query__page . '&per_page=30' . $pixabay_key,				// [iii]
		$args,																										// [iii]
		'GET',																										// [iii]
	);																												// [iii]



	if ($response['code'] == 200) :																					// [iv]
		$all_images = array();																						// [vii]


		foreach ($response['result']['hits'] as $image) :															// [viii]
			$all_images[] = array(																					// [viii]
				'source'		=> 'Pixabay',																		// [ix]
				'fee'			=> 'Free!',																			// [ix]
				'alt'			=> '',																				// [x]
				'description'	=> $image['tags'],																	// [x]
				'id'			=> $image['id'],																	// [xi]
				'score'			=> $image['likes'],																	// [xi]
				'urls'	=> array(																					// [xii]
					'download'		=> $image['largeImageURL'],														// [xii]
					'library'		=> $image['pageURL'],															// [xii]
					'raw'			=> $image['largeImageURL'],														// [xiii]
					'full'			=> $image['largeImageURL'],														// [xiii]
					'medium'		=> $image['webformatURL'],														// [xiii]
					'small'			=> $image['webformatURL'],														// [xiii]
					'thumb'			=> $image['previewURL'],														// [xiii]
				),																									// [xii]
				'name'			=> 'Pixabay',																		// [xiv]
			);																										// [viii]
		endforeach;																									// [viii]


		return array(																								// [xv]
			'images' 	=> $all_images,																				// [xv]
			'response' 	=> $response,																				// [xv]
			'page'		=> $query__page,																			// [xv]
			'totals'	=> array(																					// [xv]
				'found'		=> $response['result']['totalHits'],													// [xv]
				'returned'	=> count($response['result']['hits']),													// [xv]
			),																										// [xv]
			'status' 	=> 200,																						// [xv]
		);																											// [xv]



	else :																											// [iv]
		return array(																								// [v]
			'response' 	=> $response,																				// [v]
			'status' 	=> 500,																						// [v]
		);																											// [v]
	endif;																											// [iv]
}





/**
 * [2]	Perform image search on Pixabay
 *
 * 		@since 11.0.0
 *
 * 		[i]		Store our Pixabay API key and URL
 * 		[ii]	Define params for search query
 * 		[iii]	Perform the actual query using the oAuth2 Client
 * 		[iv]	If our API request is a success or failure
 * 		[v]		Return error message and error state
 * 		[vi]	Create new empty array for pushing our images to
 * 		[viii]	Loop through all returned images, pushing to our array
 * 		[ix]	Set "Pixabay" as the source of the image
 * 		[x]		Fetch alt and description
 * 		[xi]	Fetch ID of Pixabay asset and its popularity
 * 		[xii]	Fetch useful media URLs
 * 		[xiii]	Fetch media files
 * 		[xiv]	Set user who uploaded's name to Pixabay
 * 		[xv]	Return our images plus other useful data
 */

function scenic_stock_api_search_shutterstock($client, $search, $page, $args) {
	$shutterstock_access = get_option('shutterstock_option_name')['app_token'];
	$client->setAccessToken($shutterstock_access);
	$client->setAccessTokenType(1);

	$http_headers = array();
	$http_headers['user-agent'] = 'Scenic';

	$shutterstock_url = 'https://api.shutterstock.com/v2/images/search';											// [i]

	$query__term  = urlencode($search);																				// [ii]
	$query__page  = ($page) ?: 1;																					// [ii]

	$response = $client->fetch(																						// [iii]
		$shutterstock_url . '?query=' . $query__term . '&page=' . $query__page . '&per_page=30&spellcheck_query=false&region=GB&image_type=photo',				// [iii]
		$args,																										// [iii]
		'GET',																										// [iii]
		$http_headers
	);																												// [iii]



	if ($response['code'] == 200) :																					// [iv]
		$all_images = array();																						// [vii]


		foreach ($response['result']['data'] as $image) :																		// [viii]
			$all_images[] = array(																					// [viii]
				'source'		=> 'shutterstock',																		// [ix]
				'fee'			=> '$10',																			// [ix]
				'alt'			=> '',																				// [x]
				'description'	=> $image['description'],																	// [x]
				'id'			=> $image['id'],																	// [xi]
				'score'			=> 5000,																	// [xi]
				'urls'	=> array(																					// [xii]
					'download'		=> $image['assets']['preview']['url'],														// [xii]
					'library'		=> $image['url'],															// [xii]
					'raw'			=> $image['assets']['preview']['url'],														// [xiii]
					'full'			=> $image['assets']['preview']['url'],														// [xiii]
					'medium'		=> $image['assets']['preview']['url'],														// [xiii]
					'small'			=> $image['assets']['preview']['url'],														// [xiii]
					'thumb'			=> $image['assets']['preview']['url'],														// [xiii]
				),																									// [xii]
				'name'			=> 'shutterstock',																		// [xiv]
			);																										// [viii]
		endforeach;																									// [viii]

		return array(																								// [xv]
			'images' 	=> $all_images,																				// [xv]
			'response' 	=> $response,																				// [xv]
			'page'		=> $query__page,																			// [xv]
			'totals'	=> array(																					// [xv]
				'found'		=> $response['result']['total_count'],													// [xv]
				'returned'	=> count($response['result']['data']),													// [xv]
			),																										// [xv]
			'status' 	=> 200,																						// [xv]
		);																											// [xv]



	else :																											// [iv]
		return array(																								// [v]
			'response' 	=> $response,																				// [v]
			'status' 	=> 500,																						// [v]
		);																											// [v]
	endif;																											// [iv]
}





/**
 * [6]	AJAX request handler for search requests
 */

function scenic_handle_ajax_scenic_stock_api_search() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'scenic-stock-api-nonce')) {											// [i]
		wp_send_json_error('Security key could not be validated. Refresh the page and try again.', 500);			// [i]
		exit;																										// [i]
	}																												// [i]


	if (! isset($_REQUEST)) :																						// [ii]
		wp_send_json_error('There was no data sent with your request. Please try again.', 500);						// [ii]
		exit;																										// [ii]
	else :																											// [ii]
		$networks = $_REQUEST['networks'];																			// []
		$search   = $_REQUEST['location'];																			// []
		$page     = ($_REQUEST['page']) ?: 1;																		// []
		$args     = array();																						// []

		$images         = array();																					// []
		$return         = array();																					// []

		$returned_total = 0;																						// []
		$found_total    = 0;																						// []


		scenic_load_api_client();																					// []
		$client = new OAuth2\Client('sugar', '');																	// []


		if (in_array('unsplash', $networks)) {																		// []
			$unsplash = scenic_stock_api_search_unsplash($client, $search, $page, $args);							// []

			$images = array_merge($images, $unsplash['images']);													// []
			$return['unsplash'] = $unsplash;																		// []

			$found_total    = $found_total    + $unsplash['totals']['found'];										// []
			$returned_total = $returned_total + $unsplash['totals']['returned'];									// []
		}																											// []


		if (in_array('pixabay', $networks)) {																		// []
			$pixabay = scenic_stock_api_search_pixabay($client, $search, $page, $args);								// []

			$images = array_merge($images, $pixabay['images']);														// []
			$return['pixabay'] = $pixabay;																			// []

			$found_total    = $found_total    + $pixabay['totals']['found'];										// []
			$returned_total = $returned_total + $pixabay['totals']['returned'];										// []
		}																											// []


		if (in_array('shutterstock', $networks)) {																	// []
			$shutterstock = scenic_stock_api_search_shutterstock($client, $search, $page, $args);						// []

			$images = array_merge($images, $shutterstock['images']);														// []
			$return['shutterstock'] = $shutterstock;																			// []

			$found_total    = $found_total    + $shutterstock['totals']['found'];										// []
			$returned_total = $returned_total + $shutterstock['totals']['returned'];										// []
		}																											// []


		usort($images, fn($a, $b) => $b['score'] <=> $a['score']);													// []


		wp_send_json_success(																						// []
			array(																									// []
				'search'	=> $_REQUEST['location'],																// []
				'page'		=> $page,																				// []
				'images' 	=> $images,																				// []
				'totals'	=> array(																				// []
					'found'		=> $found_total,																	// []
					'returned'	=> $returned_total,																	// []
				),																									// []
				'return'	=> $return,																				// []
			),																										// []
			200																										// []
		);																											// []
	endif;																											// [ii]
}


add_action('wp_ajax_scenic_stock_api_search', 'scenic_handle_ajax_scenic_stock_api_search');





/**
 * [7]	AJAX request handler for adding image to media library
 */

function scenic_handle_ajax_scenic_stock_api_add_to_library() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'scenic-stock-api-nonce')) :											// [i]
		wp_send_json_error('Security key could not be validated. Refresh the page and try again.', 500);			// [i]
		exit;																										// [i]
	endif;																											// [i]



	if (! isset($_REQUEST)) :																						// [ii]
		wp_send_json_error('There was no data sent with your request. Please try again.', 500);						// [ii]
		exit;																										// [ii]
	endif;																											// []



	if (isset($_REQUEST)) :																							// [ii]
		$request_type 		 = $_REQUEST['type'];																	// []
		$place_post_id 		 = intval($_REQUEST['locationID']);														// []
		$attraction_id 		 = intval($_REQUEST['attractionID']);													// []

		$image_source        = $_REQUEST['imageSource'];															// []
		$image_fee           = $_REQUEST['imageFee'];																// []
		$image_id            = $_REQUEST['imageId'];																// []

		$image_score         = $_REQUEST['imageScore'];																// []
		$image_name          = $_REQUEST['imageName'];																// []
		$image_alt           = $_REQUEST['imageAlt'];																// []
		$image_description   = $_REQUEST['imageDescription'];														// []

		$image_library       = $_REQUEST['imageLibraryUrl'];														// []
		$image_download      = $_REQUEST['imageDownload'];															// []

		$image_asset__raw    = $_REQUEST['imageSrcRaw'];															// []
		$image_asset__full   = $_REQUEST['imageSrcFull'];															// []
		$image_asset__medium = $_REQUEST['imageSrcMedium'];															// []
		$image_asset__small  = $_REQUEST['imageSrcSmall'];															// []
		$image_asset__thumb  = $_REQUEST['imageSrcThumb'];															// []




		if (! $image_download) :																					// []
			wp_send_json_error('No asset to upload.', 500);															// [ii]
			exit;																									// [ii]



		else :
			switch ($image_source) :
				case "Unsplash" :
					$attachment_id = media_sideload_image($image_download . '.jpeg', 0, 0, 'id');
					update_field('unsplash-url', 	$image_asset__raw, 	$attachment_id);
					break;

				default :
					$attachment_id = media_sideload_image($image_download, 0, 0, 'id');
					break;
			endswitch;



			update_field('copyright', 		$image_name, 	           $attachment_id);
			update_field('copyright__url', 	$image_library,            $attachment_id);

			update_field('asset-id', 		$image_id, 		           $attachment_id);
			update_field('source', 			strtolower($image_source), $attachment_id);



			$current_ids_only  = array();																		// []	New empty array for filtering current gallery items
			$gallery_asset_ids = array();																		// []	New empty array for creating ACF field data
			$media_ids         = array($attachment_id);															// []	Cast to array

			$place_term_id     = get_field('related-location', $place_post_id)->term_id;						// []	Fetch term ID from post meta

			switch ($request_type) :
				case "addToLocation" :
					$current_gallery = get_field('gallery', $place_post_id);									// []	Get current gallery items
					foreach ($current_gallery as $image) { $current_ids_only[] = $image['id']; }				// []	Loop through current gallery, fetching media ID and store to array

					$new_media_ids = array_unique(array_merge($current_ids_only, $media_ids));					// []	Make sure the selected image isn't already in the gallery
					foreach ($new_media_ids as $id) { $gallery_asset_ids[] = intval($id); }						// []	Build new array of media IDs
					update_field('gallery', $gallery_asset_ids, $place_post_id);								// []	Update field
					break;


				case "addToAttraction" :
					$current_gallery = get_field('gallery', $attraction_id);									// []	Get current gallery items
					foreach ($current_gallery as $image) { $current_ids_only[] = $image['id']; }				// []	Loop through current gallery, fetching media ID and store to array

					$new_media_ids = array_unique(array_merge($current_ids_only, $media_ids));					// []	Make sure the selected image isn't already in the gallery
					foreach ($new_media_ids as $id) { $gallery_asset_ids[] = intval($id); }						// []	Build new array of media IDs
					update_field('gallery', $gallery_asset_ids, $attraction_id);								// []	Update field
					break;
			endswitch;



			update_field('field_639da280c74b8', $place_term_id, $attachment_id);								// []	Add location ID to media meta
		endif;																									// []
	endif;																										// []


	wp_send_json_success(array(
		'attachment_id' => $attachment_id,
		'location_id'	=> $place_post_id,
		'locations'		=> $locations,
	), 200);
}


add_action('wp_ajax_scenic_stock_add_to_library', 'scenic_handle_ajax_scenic_stock_api_add_to_library');





/**
 * [4]	Fetch from Adobe Stock
 */

function scenic_stock_image_fetch_from_adobe() {
	
}