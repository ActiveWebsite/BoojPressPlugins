<?php
global $wpdb;
$wtd_pages = get_option($wtd_pages);
//		if(!substr_count(ini_get("disable_functions"), 'set_time_limit'))
//			set_time_limit(0);

//Delete Activities Page
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
//Delete Dining Page
$args = array('post_type' => 'wtd_dining');
$query = new WP_Query($args);
if($query->found_posts){
	while($query->found_posts){
		foreach($query->posts as $post){
			wp_delete_post($post->ID, true);
		}
		$query = new WP_Query($args);
	}
}
//Delete Events Page
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
//Delete Specials Page
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
//Delete Coupons Page
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

//Delete Overview Page

if(!empty($wtd_pages['overview-page']))
	wp_delete_post($wtd_pages['overview-page'], true);

$query = "DROP TABLE IF EXISTS wp_wtd_meta";
$wpdb->query($query);

//Delete options
delete_option('wtd_api_key');
delete_option('wtd_api_token');
delete_option('wtd_plugin_version');
delete_option('wtd_plugin');
delete_option('wtd_pages');
delete_option('wtd_plugin-transients');
delete_option('wtd_feed');
delete_option('wtd_nav_options');
delete_option('wtd_syncing');
delete_option('wtd_reseting');
delete_option('wtd_updating');
delete_option('wtd_terms_synced');
delete_option('wtd_categories');
delete_option('wtd_category_children');
delete_option('wtd_resort_children');
delete_option('wtd_location_children');
delete_option('wtd_client_details');
delete_option('wtd_excluded_parent_cats');
delete_option('wtd_excluded_cats');
delete_option('wtd_excluded_categories');
delete_option('wtd_api_active');
delete_option('wtd_mapped_categories');
delete_option('wtd_db_version');