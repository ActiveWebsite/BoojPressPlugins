<?php
/*
Plugin Name: WordPress Meta Description
Plugin URI: http://www.typomedia.org/wordpress/plugins/wordpress-meta-description/
Description: Activates the excerpt for pages/posts for global support as <code>meta description</code>.
Author: Typomedia Foundation
Version: 1.6
Author URI: http://www.typomedia.org/
*/

if ( !class_exists ('wp_meta_desc_plugin')) {
	class wp_meta_desc_plugin {

	function page_excerpt_init() {
		add_post_type_support( 'page', 'excerpt' );
	}
	
	function cutstr($string, $i) {
		if (strlen(utf8_decode($string)) > $i) {
		$string = substr($string, 0, $i);
		$string .= "...";
	}
	return $string;
	}	
	
	function add_meta_desc_tag() {
		global $post;
		$text = strip_tags($post->post_excerpt);
		$desc = current(explode('\n', wordwrap($text, 153, '...\n')));
		if ( is_single() || is_page() && !empty($desc) ) {
		print '<meta name="description" content="'.$desc.'" />'."\n";
		}
	}	
	
	} // class wp_meta_desc_plugin
}

add_action('init', array('wp_meta_desc_plugin','page_excerpt_init'));
add_action('wp_head', array('wp_meta_desc_plugin','add_meta_desc_tag'));
?>