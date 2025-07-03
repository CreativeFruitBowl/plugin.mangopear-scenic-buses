<?php

/**
 * [OpenAI] Use OpenAI to generate content on the fly
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
 * [1]	
 */


/**
 * [1]	
 *
 * 		@since 11.0.0
 *
 * 		[i]	
 */

function scenic_load_openai_client() {
	require(plugin_dir_path(__FILE__) . '../helpers/openai/OpenAi.php');	// [i]
	require(plugin_dir_path(__FILE__) . '../helpers/openai/Url.php');		// [i]

	return SCENIC_OPENAI_API_KEY;
}





/**
 * [2]	
 */

function scenic_handle_ajax_scenic_openai_location_subtitle() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'scenic-global-nonce')) {												// [i]
		wp_send_json_error('Security key could not be validated. Refresh the page and try again.', 500);			// [i]
		exit;																										// [i]
	}																												// [i]


	if (! isset($_REQUEST)) :																						// [ii]
		wp_send_json_error('There was no data sent with your request. Please try again.', 500);						// [ii]
		exit;																										// [ii]
	else :																											// [ii]
		$openai_key = scenic_load_openai_client();																	// []
		$open_ai = new Orhanerday\OpenAi\OpenAi($openai_key);														// []


		$place_term_id = intval($_REQUEST['locationID']);
		$place_post_id = get_field('related-place-to-visit', 'route__locations_' . $place_term_id);

		$location_name = get_the_title($place_term_id);


		$json_response = $open_ai->chat([
			'model' 			=> 'gpt-4o',
			'messages' 			=> array(
				array(
					'role'	  => 'user',
					'content' => "Write a 15 to 22 word long headline for $location_name, based on tourism by public transport (bus, coach and train etc), all in British English and sentence case. Make it very creative. No quote marks around the text.",
				),
			),
			'n'					=> 3,
			'temperature' 		=> 1.1,
			'max_tokens' 		=> 150,
			'frequency_penalty' => 0,
			'presence_penalty' 	=> 0.6,
		]);


		$response = json_decode($json_response);


		wp_send_json_success(																						// []
			array(																									// []
				'result'	=> $response,																			// []
				'place'		=> $place_term_id,
				'place-name' => $location_name,
			),																										// []
			200																										// []
		);																											// []
	endif;																											// [ii]
}


add_action('wp_ajax_scenic_openai_location_subtitle', 'scenic_handle_ajax_scenic_openai_location_subtitle');





/**
 * [3]	
 */

function scenic_handle_ajax_scenic_openai_location_content() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'scenic-global-nonce')) {												// [i]
		wp_send_json_error('Security key could not be validated. Refresh the page and try again.', 500);			// [i]
		exit;																										// [i]
	}																												// [i]


	if (! isset($_REQUEST)) :																						// [ii]
		wp_send_json_error('There was no data sent with your request. Please try again.', 500);						// [ii]
		exit;																										// [ii]
	else :																											// [ii]
		$openai_key = scenic_load_openai_client();																	// []
		$open_ai = new Orhanerday\OpenAi\OpenAi($openai_key);														// []


		$place_term_id = intval($_REQUEST['locationID']);
		$place_post_id = get_field('related-place-to-visit', 'route__locations_' . $place_term_id);

		$location_name = get_the_title($place_term_id);
		$length = intval($_REQUEST['contentLength']);


		$prompt  = "You are writing engaging, tourism-focused content for the website scenicbuses.co.uk. Your task is to generate a headline and a short feature about a city, town, village, or attraction – in this case, $location_name.";
		$prompt .= "The audience is made up of travellers exploring Britain without a car. Write in a friendly, natural tone – not overly formal or promotional. Avoid repeating generic phrases like 'public transport options' or 'sustainable travel'.";
		$prompt .= "Mention the experience of travelling without a car as part of the trip, not as a selling point.";
		$prompt .= "Highlight attractions, scenic views, nearby countryside and charming local spots that are easy to reach.";
		$prompt .= "Use short paragraphs and write clearly. Always write in British English with correct grammar. The headline should be between 15 and 22 words long and written in sentence case – capitalise only the first word and proper nouns. Wrap the headline in:";
		$prompt .= "<h3 class=\"js-ai-content__heading\">...</h3>";
		$prompt .= "Wrap all paragraph content in:";
		$prompt .= "<div class=\"js-ai-content__body\"><p>...</p><p>...</p></div>";
		$prompt .= "Only return the final HTML output – no preamble, explanations or quotes. Write creatively and with a clear tourism focus, suitable for the Scenic website. The body content should be approximately $length words long.";


		$json_response = $open_ai->chat([
			'model' 			=> 'gpt-4o',
			'messages' 			=> array(
				array(
					'role'	  => 'user',
					'content' => $prompt,
				),
			),
			'n'					=> 3,
			'temperature' 		=> 0.9,
			'max_tokens' 		=> 1000,
			'frequency_penalty' => 0,
			'presence_penalty' 	=> 0.6,
		]);


		$response = json_decode($json_response);


		wp_send_json_success(																						// []
			array(																									// []
				'result'	=> $response,																			// []
				'length'	=> $length . ' words',
				'place'		=> $place_term_id,
				'place-name' => $location_name,
			),																										// []
			200																										// []
		);																											// []
	endif;																											// [ii]
}


add_action('wp_ajax_scenic_openai_location_content', 'scenic_handle_ajax_scenic_openai_location_content');





/**
 * [4]	Social media: Route post generation
 */

function scenic_handle_ajax_scenic_openai_route_socials() {
	if (! wp_verify_nonce($_REQUEST['nonce'], 'scenic-global-nonce')) {												// [i]
		wp_send_json_error('Security key could not be validated. Refresh the page and try again.', 500);			// [i]
		exit;																										// [i]
	}																												// [i]


	if (! isset($_REQUEST)) :																						// [ii]
		wp_send_json_error('There was no data sent with your request. Please try again.', 500);						// [ii]
		exit;																										// [ii]
	else :																											// [ii]
		$openai_key = scenic_load_openai_client();																	// []
		$open_ai = new Orhanerday\OpenAi\OpenAi($openai_key);														// []


		$route_id    = intval($_REQUEST['routeID']);
		$route_url   = get_permalink($route_id);
		$route_name  = get_field('identifier--brand', $route_id);
		$route_title = get_field('route-description--marketing', $route_id);


		$prompt  = 'Give me a social media post idea based on this page: ' . $route_url . ' - a bus route called "' . $route_name . '" (' . $route_title . ')';
		$prompt .= 'Don\'t give me a generic idea - I want a specific post that I can share on socials. Make the content in the post unique to the page I have referenced.';
		$prompt .= 'Return the result as a HTML table. Do not add any extra text to the response other than the formatted table.';
		$prompt .= 'Use sentence case for all content, you can include a few emojis.';
		$prompt .= 'Use these as the column headers: Post title, Post content, Hashtags, Suggestion for image (text description).';


		$json_response = $open_ai->chat([
			'model' 			=> 'gpt-4o',
			'messages' 			=> array(
				array(
					'role'	  => 'user',
					'content' => $prompt,
				),
			),
			'n'					=> 8,
			'temperature' 		=> 0.9,
			'max_tokens' 		=> 275,
			'frequency_penalty' => 0,
			'presence_penalty' 	=> 0.6,
		]);


		$response = json_decode($json_response);


		wp_send_json_success(																						// []
			array(																									// []
				'result'	=> $response,																			// []
				'length'	=> $length,
			),																										// []
			200																										// []
		);																											// []
	endif;																											// [ii]
}


add_action('wp_ajax_scenic_openai_route_socials', 'scenic_handle_ajax_scenic_openai_route_socials');