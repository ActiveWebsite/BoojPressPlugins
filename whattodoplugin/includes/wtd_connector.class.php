<?php

use kamranahmedse\Geocode;

class wtd_connector{
	private $base_request;
	private $options;
	private $paid_resorts = array();

	public function __construct(){
		$this->options = get_option('wtd_plugin');
		$this->options['wtd_api_key'] = get_option('wtd_api_key');
		$client_info = get_option('wtd_client_details');
		$this->paid_resorts = $client_info['resorts_available'];
		add_action('wp_ajax_wtd_check_email', array($this, 'check_email'));
		add_action('wp_ajax_wtd_lost_key', array($this, 'lost_key'));
		add_action('wp_ajax_wtd_geocode_address', array($this, 'geocode_address'));
	}

	private function prepare_request(){
		global $wpdb;
		//Token
		$this->base_request = array('token' => get_option('wtd_api_token'), 'plugin_version' => WTD_VERSION);

		//todo properly include the request parameters for exclusion
		//Selected Resorts
		if(!empty($this->options['wtd_resorts']))
			$this->base_request['resorts'] = $this->options['wtd_resorts'];
		//Excluded locations
		if(!empty($this->options['excluded_locations']))
			$this->base_request['excluded_locations'] = $this->options['excluded_locations'];
		if(!empty($this->options['business_category']))
			$this->base_request['website_type'] = $this->options['business_category'];
	}

	public function get_base_request(){
		$this->prepare_request();
		return $this->base_request;
	}

	public function update_distance($post_id){
		global $wpdb;
		$query = "SELECT
					pm.*
				FROM
					{$wpdb->postmeta} pm
						JOIN {$wpdb->postmeta} pmm ON pmm.post_id = %s AND pmm.meta_key = 'vend_id'
						JOIN {$wpdb->prefix}wtd_meta wm ON wm.meta_key = 'vend_id' AND wm.wtd_term_id = pmm.meta_value
						JOIN {$wpdb->posts} p ON p.ID = wm.term_id
				WHERE
					pm.post_id = wm.term_id
				AND pm.meta_key IN ('lat','lng')";
		$vendor_metas = $wpdb->get_results($query);
		if($vendor_metas){
			foreach($vendor_metas as $vend_data){
				$name = $vend_data->meta_key;
				$$name = $vend_data->meta_value;
			}
			$origin_lng = (!empty($this->options['user_map']['lng'])) ? $this->options['user_map']['lng'] : 38;
			$origin_lat = (!empty($this->options['user_map']['lat'])) ? $this->options['user_map']['lat'] : - 95.677068;
			if(empty($lat) || empty($lng))
				$distance = 9999999999;
			else
				$distance = 3959 * acos(cos(deg2rad($origin_lat)) * cos(deg2rad($lat)) * cos(deg2rad($lng) - deg2rad($origin_lng) + sin(deg2rad($origin_lat)) * sin(deg2rad($lat))));
			update_post_meta($post_id, 'distance', $distance);
		}
	}

	public function check_email(){
		$url = WTD_API_URL . 'check_new_email';
		$request = array('email' => $_POST['email']);
		die($this->curl($url, $request));
	}

	public function new_client($post){
		global $wtd_client_error;
		$url = WTD_API_URL . 'create_new_client';
		$json = $this->curl($url, $post);
		$response = json_decode($json);
		if($response->status){?>
			<script>
				window.location = "<?php echo admin_url('admin.php?page=wtd_plugin_settings&connect_wtd_api=1&api_key=' . $response->response->api_key);?>";
			</script>
			<style>
				html, body{
					display: none !important;
				}
			</style><?php
		}else
			$wtd_client_error = $response->messages[0];
	}

	public function lost_key(){
		$url = WTD_API_URL . 'lost_key';
		$request = array('email' => $_POST['email'], 'logo_url' => WTD_PLUGIN_URL . 'assets/img/whattodo-logo.png', 'admin_page' => admin_url('admin.php?page=wtd_plugin_settings'));
		die($this->curl($url, $request));
	}

	public function first_touch($api_key){
		global $wtd_api_error;

		//Connect To API
		$params = array(
			'action' => 'firstTouch',
			'site_url' => get_home_url(),
			'site_name' => get_bloginfo('name'),
			'api_key' => $api_key,
			'plugin_version' => WTD_VERSION);
		$this->options['wtd_api_key'] = $api_key;
		$response = $this->curl(WTD_API_URL, $params);
		$api_token = json_decode($response);
		if($response){
			update_option('wtd_api_token', $api_token);
			update_option('wtd_api_key', $api_key);
			header('Location:' . admin_url('/admin.php?page=wtd_plugin_settings'));
			return true;
		}else
			$wtd_api_error = array('There was a server error. Please try again in a bit! ');
	}

	public function change_client_key($new_key, $refresh = false){
		if(empty($this->base_request))
			$this->prepare_request();
		$url = WTD_API_URL . 'new_api_key';
		$params = array_merge(array('new_api_key' => $new_key), $this->base_request);
		$json = $this->curl($url, $params);
		$response = json_decode($json);
		$transient = array();
		if($response->status){
			update_option('wtd_client_details', (array) $response->response->client_details);
			update_option('wtd_api_key', $new_key);
			if($refresh)
				$transient['status'] = 2;
			else
				$transient['status'] = 1;
		}else{
			$transient['status'] = 0;
			$transient['messages'] = (array) $response->messages;
		}
		set_transient('wtd_change_key_status', $transient, HOUR_IN_SECONDS);
	}

	public function map_icons(){
		global $wpdb;
		$query = "DELETE FROM {$wpdb->prefix}wtd_meta WHERE meta_key = 'map_icon'";
		$wpdb->query($query);
		$icons = json_decode(file_get_contents(WTD_PLUGIN_URL . 'assets/maps/data.json'));
		foreach($icons as $icon){
			$icon_query = "SELECT * FROM {$wpdb->prefix}wtd_meta WHERE wtd_term_id = %s AND meta_key = 'map_icon' LIMIT 1";
			$check_icon = $wpdb->get_results($wpdb->prepare($icon_query, $icon->cat_id));
			if(empty($check_icon)){
				$term_query = "SELECT term_id FROM {$wpdb->prefix}wtd_meta WHERE wtd_term_id = %s AND meta_key = 'cat_id' LIMIT 1";
				$term_id = $wpdb->get_var($wpdb->prepare($term_query, $icon->cat_id));
				if(!empty($term_id))
					$wpdb->insert($wpdb->prefix . 'wtd_meta', array('term_id' => $term_id, 'wtd_term_id' => $icon->cat_id, 'meta_key' => 'map_icon', 'meta_value' => $icon->icon));
			}
		}
		$query = "SELECT
					wm.*
				FROM
					{$wpdb->prefix}wtd_meta wm
				WHERE
					wm.meta_key = 'cat_id'
				AND (SELECT COUNT(*) FROM {$wpdb->prefix}wtd_meta wtdm WHERE wtdm.meta_key = 'map_icon' AND wtdm.wtd_term_id = wm.wtd_term_id) = 0";
		$no_icons = $wpdb->get_results($query);
		if(!empty($no_icons)){
			foreach($no_icons as $row){
				$wpdb->insert($wpdb->prefix . 'wtd_meta',
					array(
						'meta_key' => 'map_icon',
						'wtd_term_id' => $row->wtd_term_id,
						'term_id' => $row->term_id,
						'meta_value' => WTD_PLUGIN_URL . 'assets/img/map_icons/wtd_icon.png'));
			}
		}
	}

	public function geocode_address(){
		require_once WTD_PLUGIN_PATH . '/includes/libs/GeoCoder.php';
		$address = $_POST['address'];
		$geocode = new Geocode($address);
		die(json_encode(array('lat' => $geocode->getLatitude(), 'lng' => $geocode->getLongitude())));
	}

	private function wtd_decryptor($encrypted){
		if(!empty($this->options['wtd_api_key'])){
			$api_key = $this->options['wtd_api_key'];
			$encrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $api_key, base64_decode($encrypted), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		}
		return $encrypted;
	}

	public function curl($url, $param = false){
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
		if($param){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($param));
		}else
			curl_setopt($ch, CURLOPT_POST, 0);
		$result = curl_exec($ch);
		$data = curl_getinfo($ch);
		curl_close($ch);
		return $this->wtd_decryptor($result);
	}

	public function decrypt_parse_response($data){
		$pos = max(strrpos($data, ']'), strrpos($data, '}'));
		$data = substr($data, 0, $pos + 1);
		$blocksize = 16;
		$len = mb_strlen($data);
		$pad = ord($data[$len - 1]);
		if($pad && $pad < $blocksize){
		$pm = preg_match('/' . chr($pad) . '{' . $pad . '}$/', $data);
		if($pm)
			$data = mb_substr($data, 0, $len - $pad);
		}
		return json_decode(stripslashes($data));
	}

	public function fake_hard(){

	}

	public function reset_data($force = false){
		global $wpdb;
//		if(!substr_count(ini_get("disable_functions"), 'set_time_limit'))
//			set_time_limit(0);
		$wtd_pages = get_option('wtd_pages');
		//Delete Activities
		$args = array('post_type' => 'wtd_activity');
		$query = new WP_Query($args);
		if($query->found_posts){
			while($query->found_posts){
				foreach($query->posts as $post){
					wp_delete_post($post->ID, true);
				}
				$query = new WP_Query($args);
			}
		}
		//Delete Events
		$args = array('post_type' => 'wtd_event');
		$query = new WP_Query($args);
		if($query->found_posts){
			while($query->found_posts){
				foreach($query->posts as $post){
					wp_delete_post($post->ID, true);
				}
				$query = new WP_Query($args);
			}
		}
		//Delete Specials
		$args = array('post_type' => 'wtd_special');
		$query = new WP_Query($args);
		if($query->found_posts){
			while($query->found_posts){
				foreach($query->posts as $post){
					wp_delete_post($post->ID, true);
				}
				$query = new WP_Query($args);
			}
		}
		//Delete Coupons
		$args = array('post_type' => 'wtd_coupon');
		$query = new WP_Query($args);
		if($query->found_posts){
			while($query->found_posts){
				foreach($query->posts as $post){
					wp_delete_post($post->ID, true);
				}
				$query = new WP_Query($args);
			}
		}
		//Delete options
		delete_option('wtd_feed');
		if($force){
			unset($this->options['activities-page']);
			unset($this->options['calendar-page']);
			unset($this->options['dining-page']);
			unset($this->options['map-page']);
			unset($this->options['coupons-page']);
			unset($this->options['specials-page']);
			unset($this->options['week-page']);
			unset($this->options['week-specials-page']);
			unset($this->options['search-page']);
			update_option('wtd_plugin', $this->options);
			if($wtd_pages){
				foreach($wtd_pages as $key => $pages){
					$wtd_pages[$key] = array();
				}
				update_option('wtd_pages', $wtd_pages);
			}
			//Delete Pages
			$args = array(
				'post_type' => 'page',
				'meta_query' => array(
					array(
						'key' => 'wtd_page',
						'value' => array(
							'activities_page',
							'calendar_page',
							'dining_page',
							'specials_page',
							'map_page',
							'coupons_page',
							'search_page',
							'week_page',
							'weekspecials_page'),
						'compare' => 'IN')));
			$query = new WP_Query($args);
			if($query->found_posts){
				while($query->found_posts){
					foreach($query->posts as $post){
						wp_delete_post($post->ID, true);
					}
					$query = new WP_Query($args);
				}
			}
			delete_option('wtd_api_key');
			delete_option('wtd_terms_synced');
			delete_option('wtd_plugin');
			delete_option('wtd_pages');
		}
	}
}?>
