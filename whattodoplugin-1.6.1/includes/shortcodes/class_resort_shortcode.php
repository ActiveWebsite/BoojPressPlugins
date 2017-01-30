<?php

class wtdResortShortcode{

	function __construct(){
		add_shortcode('wtdResort', array($this, 'shortcode'));

		/**
		 * @return string folder content
		 */
		add_action('wp_ajax_resort_shortcode_tinymce', array($this, 'resort_shortcode_ajax_tinymce'));
	}

	/**
	 * Call TinyMCE window content via admin-ajax
	 *
	 * @since 1.7.0
	 * @return html content
	 */
	function resort_shortcode_ajax_tinymce(){
		if(!current_user_can('edit_pages') && !current_user_can('edit_posts')) // check for rights
			die(__("You are not allowed to be here"));
		include_once WTD_PLUGIN_PATH.'/includes/shortcodes/tinymce/resort_shortcode.php';
		die();
	}

	function shortcode($atts){
		$params = shortcode_atts(array(
			'type' => 'default',
			'width' => '100%',
			'height' => '400px'
		), $atts);

		switch($params['type']){
			default:
				$response = $this->display();
				break;
		}
		return $response;
	}

	function display(){

	}
}
?>