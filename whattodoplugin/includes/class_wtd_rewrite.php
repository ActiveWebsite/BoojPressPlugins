<?php

class wtdRewrite{
	function __construct(){
		//Init Hook
		add_action('init', array($this, 'init'), 1);
		add_action('wp_footer', array($this, 'footer'));
		//WP Head
		add_action('wp_head', array($this, 'wp_head'));
		//URL Rewrite
		add_action('init', array($this, 'url_rewrite'));
		//Custom Scripts
		add_action('wp_enqueue_scripts', array($this, 'wtd_custom_scripts'));
	}

	public function wp_head(){?>
		<script>wtd_ajax_url = "<?php echo admin_url('admin-ajax.php');?>";</script><?php
	}

	public function init(){

	}

	public function footer(){

	}

	public function wtd_custom_scripts(){
		wp_enqueue_script('wtd_scripts', WTD_PLUGIN_URL . 'assets/js/wtd_frontend.js', array('jquery'));
		wp_enqueue_style('wtd_frontend', WTD_PLUGIN_URL . 'assets/css/wtd_frontend.css', array(), WTD_VERSION);
	}

	public function url_rewrite(){
		global $wpdb, $wtd_plugin, $wp_rewrite;
		$wtd_plugin = get_option('wtd_plugin');
		if(!isset($wtd_plugin['url_prefix']))
			$wtd_plugin['url_prefix'] = 'wtd';
		$options = get_option('wtd_pages');
		$front_id = intval(get_option('page_on_front'));
		$array = array();
 		if(!empty($options)){
			foreach($options as $key => $value){
				foreach($value as $res_id => $page_id)
				$array[] = $page_id;
			}
		}
		if(count($array))
			$db_results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->posts} WHERE ID IN (" . implode(',', $array) . ") LIMIT %d", count($array)));
		$posts = array();
		if(count($array)){
			foreach($db_results as $res){
				$posts[intval($res->ID)] = $res;
			}
		}
		/*
		if(!empty($options['activities_pages'])){
			foreach($options['activities_pages'] as $key => $value){
				$page = intval($value);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($post->name.'/category/(.+)/?$', 'index.php?pagename='.$post->post_name.'&wtdc=$matches[1]', 'top');
				}elseif($front_id == $page)
					add_rewrite_rule('/category/(.+)/?$', 'index.php?wtdc=$matches[1]&page_id='.$page, 'top');
			}
		}
		if(!empty($options['coupons_pages'])){
			foreach($options['coupons_pages'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/category/(.+)/?$', 'index.php?pagename=' . $post->post_name . '&wtdc=$matches[1]', 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/all', 'index.php?pagename=' . $post->post_name . '&all=1', 'top');
				}
			}
		}
		if(!empty($options['dining_pages'])){
			foreach($options['dining_pages'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/category/(.+)/?$', 'index.php?pagename=' . $post->post_name . '&wtdc=$matches[1]', 'top');
				}elseif(($front_id == $page)){
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/category/(.+)/?$', 'index.php?wtdc=$matches[1]&page_id=' . $page, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/all', 'index.php?all=1&page_id=' . $page, 'top');
				}
			}
		}
		if(!empty($options['map_pages'])){
			foreach($options['map_pages'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/category/(.+)/?$', 'index.php?pagename=' . $post->post_name . '&wtdc=$matches[1]', 'top');
				}elseif(($front_id == $page))
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/category/(.+)/?$', 'index.php?wtdc=$matches[1]', 'top');
			}
		}
		if(!empty($options['custom_pages'])){
			foreach($options['custom_pages'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/category/(.+)/?$', 'index.php?pagename=' . $post->post_name . '&wtdc=$matches[1]', 'top');
				}elseif($front_id == $page)
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/category/(.+)/?$', 'index.php?wtdc=$matches[1]&page_id=' . $page, 'top');
			}
		}
		if(!empty($options['week_pages'])){
			foreach($options['week_pages'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
				}
			}
		}
		if(!empty($options['week_specials_pages'])){
			foreach($options['week_specials_pages'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
				}
			}
		}
		if(!empty($options['specials_pages'])){
			foreach($options['specials_pages'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
				}
			}
		}
		if(!empty($options['search_page'])){
			foreach($options['search_page'] as $page){
				$page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
					$post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'] . '/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
				}
			}
		}*/
	    add_rewrite_rule('^'.$wtd_plugin['url_prefix'].'/dining/(.+)/(.+)/?$', 'index.php?wtd_dining=wtd-dining&wtd_parse_id=$matches[1]&wtd_dining_name=$matches[2]', 'top');
		add_rewrite_rule('^'.$wtd_plugin['url_prefix'].'/activity/(.+)/(.+)/?$', 'index.php?wtd_activity=wtd-activity&wtd_parse_id=$matches[1]&wtd_activity_name=$matches[2]', 'top');
		add_rewrite_rule('^'.$wtd_plugin['url_prefix'].'/coupon/(.+)/?$', 'index.php?wtd_coupon=wtd-coupon&wtd_parse_id=$matches[1]', 'top');
		add_rewrite_rule('^'.$wtd_plugin['url_prefix'].'/special/(.+)/(.+)/?$', 'index.php?wtd_special=wtd-special&wtd_parse_id=$matches[1]&wtd_special_name=$matches[2]', 'top');
		add_rewrite_rule('^'.$wtd_plugin['url_prefix'].'/event/(.+)/(.+)/?$', 'index.php?wtd_event=wtd-event&wtd_parse_id=$matches[1]&wtd_event_name=$matches[2]', 'top');
		add_rewrite_rule('^(.+)/whattodo/(.+)/(.+)/(.+)/(.+)/?$', 'index.php?pagename=$matches[1]&wtdc=$matches[3]&wtds=$matches[5]', 'top');
		add_rewrite_rule('^(.+)/whattodo/(.+)/(.+)/?$', 'index.php?pagename=$matches[1]&wtdc=$matches[3]', 'top');
		add_rewrite_tag('%wtd_parse_id%', '([^&]+)');
		add_rewrite_tag('%wtd_activity_name%','([^&]+)');
		add_rewrite_tag('%wtd_dining_name%','([^&]+)');
		add_rewrite_tag('%wtd_coupon_name%','([^&]+)');
		add_rewrite_tag('%wtd_special_name%', '([^&]+)');
		add_rewrite_tag('%wtd_event_name%', '([^&]+)');
		add_rewrite_tag('%wtdc%', '([^&]+)');
		add_rewrite_tag('%wtds%', '([^&]+)');
		//$wp_rewrite->flush_rules();
	}
}?>