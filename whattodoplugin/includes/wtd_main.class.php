<?php

global $wpdb;
require_once WTD_PLUGIN_PATH.'/includes/shortcodes/class_resort_shortcode.php';
class wtd_main{
	public function __construct(){
		//Activation Hook
		register_activation_hook(WTD_PLUGIN_FILE, array($this, 'activate'));
		//Register Custom Post Types
		add_action('init', array($this, 'register_post_types'));
		//Admin Init
		add_action('admin_init', array($this, 'admin_init'));
		//Admin Footer
		add_action('admin_footer', array($this, 'admin_footer'));
		//add_action('wp_footer', array($this, 'update'));
		//Update Routine
		add_action('init', array($this, 'plugin_update'));
		//Admin Head
		add_filter('admin_head', array($this, 'admin_head'));
		add_action('wp_head', array($this, 'hook_header'));
		//Frontend Scripts
		add_action('wp_enqueue_scripts', array($this, 'frontend_scripts'));
		// Category Filtering ajax functions
		add_action('wp_ajax_enable_parent_category_filter', array($this, 'enable_parent_category_filter'));
		add_action('wp_ajax_disable_parent_category_filter', array($this, 'disable_parent_category_filter'));
		add_action('wp_ajax_save_excluded_cats', array($this, 'save_excluded_categories'));
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));

		new wtdResortShortcode();
	}

	function admin_scripts($hook){
		wp_enqueue_script('angular', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js');
		wp_enqueue_script('angular-route', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-route.js');
		wp_enqueue_script('angular-animate', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-animate.min.js');
		wp_enqueue_script('angular-aria', 'https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-aria.min.js');
		wp_enqueue_script('angular-material', 'https://ajax.googleapis.com/ajax/libs/angular_material/0.11.0/angular-material.min.js');
		wp_register_style('angular-material-css', 'https://ajax.googleapis.com/ajax/libs/angular_material/0.11.0/angular-material.min.css');
		wp_enqueue_style('angular-material-css');
	}

	function save_excluded_categories(){
		$categories = $_REQUEST['excluded_cats'];
//		$excluded_cats = json_decode(get_option('wtd_excluded_cats'));
//		foreach($categories as $category){
//			if(!in_array($category, $excluded_cats))
//				$excluded_cats[] = $category;
//		}
		update_option('wtd_excluded_cats', json_encode($categories));
		die();
	}

	function enable_parent_category_filter(){
		$cat_id = $_POST['cat_id'];
		$excluded_parent_cats = json_decode(get_option('wtd_excluded_parent_cats'));
		$excluded_parent_cats[] = $cat_id;
		update_option('wtd_excluded_parent_cats', json_encode($excluded_parent_cats));
		die();
	}

	function disable_parent_category_filter(){
		$cat_id = $_POST['cat_id'];
		$idx_to_remove = 0;
		$excluded_parent_cats = json_decode(get_option('wtd_excluded_parent_cats'));
		for($i = 0; $i < count($excluded_parent_cats); $i++){
			if($excluded_parent_cats[$i] == $cat_id)
				$idx_to_remove = $i;
		}
		array_splice($excluded_parent_cats, $idx_to_remove, 1);
		update_option('wtd_excluded_parent_cats', json_encode($excluded_parent_cats));
		die();
	}

	function frontend_scripts() {
		wp_enqueue_script('jquery-masonry');
		wp_enqueue_style('coupon_print', WTD_PLUGIN_URL.'assets/css/coupon_print.css', array(), false, 'print');
	}

	function hook_header(){
		global $post;
		$wtd_pages = get_option('wtd_pages');
		/*
		 * Create arrays for wtd post types and page ids
		 */
		$wtd_types = array('wtd_event', 'wtd_special', 'wtd_coupon', 'wtd_activity', 'wtd_dining');
		$page_ids = array();
		if(!empty($wtd_pages)){
			foreach($wtd_pages as $key => $value){
				foreach($value as $key => $id){
					$page_ids[] = $id;
				}
			}
		}
		// only load up the scripts on what to do pages or posts
		//if(in_array($post->ID, $page_ids) || in_array($post->post_type, $wtd_types) || $post->ID == $wtd_pages['overview_page']){
		if(in_array($post->ID, $page_ids) || in_array($post->post_type, $wtd_types)){
			ob_start();?>
			<!-- Angular Material Dependencies -->
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-route.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-animate.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-aria.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angular_material/0.10.1/angular-material.min.js"></script>
			<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/0.10.1/angular-material.min.css">
			<link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_frontend.css?wtd_version='.WTD_VERSION;?>" media="screen"/><?php
			$output = ob_get_contents();
			ob_end_clean();
			echo $output;
		}
	}

	public function activate(){
		delete_option('_site_transient_update_plugins');
		if(!function_exists('curl_version'))
			die('What To Do Plugin requires cURL PHP extension. Please contact your Server Administrator!');

		$wtd_plugin = get_option('wtd_plugin');
		if(empty($wtd_plugin)){
			$permalinks = get_option('permalink_structure');
			if($permalinks){
				if(!substr_count($permalinks, '%postname%') || substr_count($permalinks, '.'))
					update_option('permalink_structure', '/%postname%/');
			}else
				update_option('permalink_structure', '/%postname%/');
		}
		update_option('wtd_plugin_version', WTD_VERSION);
	}

	public function admin_head(){
		if(isset($_GET['page'])){
			if($_GET['page'] == 'wtd_plugin_settings'){
				//<!-- Parse Dependencies -->
				wp_enqueue_script('parse', 'http://www.parsecdn.com/js/parse-1.3.5.min.js');
				wp_enqueue_script('parse_init', WTD_PLUGIN_URL.'assets/js/parse_init.js');
				/*<script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
				<script src="<?php echo WTD_PLUGIN_URL;?>assets/js/parse_init.js"></script><?php
				*/
			}
		}
	}

	public function register_post_types(){
		//error_reporting(0);
		//Register Activities
		$labels = array();
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => false,
			'show_in_menu' => false,
			'show_in_nav_menus' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'wtd-activity'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor'),
			'taxonomies' => array('wtd_category'));
		register_post_type('wtd_activity', $args);
		//Register Dining
		$labels = array();
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => false,
			'show_in_menu' => false,
			'show_in_nav_menus' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'wtd-dining'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor'),
			'taxonomies' => array('wtd_category'));
		register_post_type('wtd_dining', $args);
		//Register Events
		$labels = array();
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => false,
			'show_in_menu' => false,
			'show_in_nav_menus' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'wtd-event'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor'));
		register_post_type('wtd_event', $args);
		//Register Coupons
		$labels = array();
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => false,
			'show_in_menu' => false,
			'show_in_nav_menus' => false,
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'wtd-coupon',
				'with_front' => false),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor'));
		register_post_type('wtd_coupon', $args);
		//Register Specials
		$labels = array();
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => false,
			'show_in_menu' => false,
			'show_in_nav_menus' => false,
			'query_var' => true,
			'rewrite' => array('slug' => 'wtd-special'),
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => array(
				'title',
				'editor'));
		register_post_type('wtd_special', $args);
	}

	public function admin_footer(){
		global $wtd_plugin;
		if(isset($_GET['page'])){
			if($_GET['page'] == 'wtd_plugin_settings'){?>
				<!-- WhatToDo Dependencies -->
				<script type="text/javascript">
					var token = '<?php echo get_option('wtd_api_token');?>';
					var resorts = '<?php echo json_encode($wtd_plugin['wtd_resorts']);?>';
				</script>
				<script src="<?php echo WTD_PLUGIN_URL;?>assets/js/wtd_redux.js"></script><?php
			}
		}
	}

	public function admin_init(){
		global $wtd_connector;
		if(!empty($_GET['connect_wtd_api'])){
			$api_key = $_GET['api_key'];
			$wtd_connector->first_touch($api_key);
		}
	}

	public function plugin_update(){
		require_once('wtd_plugin_update.class.php');
		$updater = new wtd_plugin_update();
	}

	public function mail_coupon(){
		global $wtd_single_coupon;
		$post = array('key' => 'QLtguR96hBzr-mlY86o7jA',
			'message' => array(
				'from_email' => 'mailer@whattodo.info',
				'to' => array(
					array(
						'email' => $_POST['email'],
						'type' => 'to')),
				'autotext' => true,
				'subject' => 'WHATTODO coupon',
				'html' => $wtd_single_coupon->email($_POST['id'])));
		$url = 'https://mandrillapp.com/api/1.0/messages/send.json';
		$ch = curl_init();
		$timeout = 30;
		$agents = array('Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36');
		curl_setopt($ch, CURLOPT_USERAGENT, $agents[array_rand($agents)]);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		$result = curl_exec($ch);
		$data = curl_getinfo($ch);
		die($result);
	}
}

if(!function_exists('wtd_video_id_generator')){
	function wtd_video_id_generator($url){
		$id = '';
		if(substr_count($url, 'you')){
			$parts = parse_url($url);
			if(isset($parts['query']))
				$query_parts = parse_str($parts['query'], $query);
			if(!empty($query['v']))
				$id = $query['v'];
			else
				$id = str_replace('/embed/', '', $parts['path']);
		}
		return $id;
	}
}

if(!function_exists('wtd_copyright')){
	function wtd_copyright(){
		global $wtd_plugin;
		ob_start();
		if($wtd_plugin['wtd_copyright_holder']):?>
			<div class="wtd_clearfix"></div>
			<div id="wtd_footer">
				<div class="wtd_copyright_image_holder">
					<a href="http://www.whattodo.info" target="_blank">
						<img src="<?php echo WTD_PLUGIN_URL; ?>assets/img/whattodo-logo.png" class="wtd_copyright_image"/>
					</a>
				</div>
				<div class="wtd_footer_left">
					Content provided by
					<a href="http://www.whattodo.info" target="_blank">WhatToDo.info</a>
					<br/> Copyright <?php echo date('Y', time()); ?> All Rights reserved.
				</div>
				<div class="wtd_footer_right">
					To get listed on this site or to get
					<a href="http://www.whattodo.info" target="_blank">WhatToDo.info resort content</a>
					for your site visit
					<a href="http://sales.whattodo.info">sales.whattodo.info</a>.
				</div>
			</div><?php
		else:?>
			<div class="wtd_copyright_small">&copy; <?php echo date('Y', time());?> <a href="http://www.whattodo.info" target="_blank">WhatToDo.info</a></div><?php
		endif;
		echo ob_get_clean();
	}
}

if(!function_exists('wtd_excerpt_generator')){
	function wtd_excerpt_generator($text, $post = false, $force_url = false){
		$text = strip_tags($text);
		if(strlen($text) >= 250){
			$s = substr($text, 0, 261);
			$result = substr($s, 0, strrpos($s, ' ')) . ' ...';
		}else
			$result = $text;
		$url = false;
		if($force_url)
			$url = $force_url;
		elseif($post)
			$url = get_permalink($post->ID);
		if($url)
			$result .= ' <br/><a href="' . $url . '">Read More</a>';
		echo $result;
	}
}

if(!function_exists('wtd_get_image_url')){
	function wtd_get_image_url($field){
		if(substr_count($field, WTD_IMG_BASE))
			return $field;
		else
			return WTD_IMG_BASE . $field;
	}
}?>
