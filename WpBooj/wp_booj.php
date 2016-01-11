<?php
/*
Plugin Name: WpBooj
Plugin URI: https://github.com/politeauthority/WpBooj/
Description: Booj plugin. Extendeds Wordpress in many wonderful ways!
Version: 1.9.4
Author: Alix Fullerton
Author URI: http://www.booj.com/
Release Date: 2015-11-09


This version currently supports; 
- PHP 5.5 support
- Adds author meta options in admin
- Facebook status / twitter feed integration.
- Random post button
- Related posts
- Cache anywhere caching
- Proxy url resolution from Apache proxies
- Rebrandable support, allowing multi-domain resolution
- Query debugger.
- Pending Post Emailer
- Google Analytics Management

Developer Notes
- Supports variable table prefixes

*/

define( 'WP_BOOJ_PATH', plugin_dir_path( __FILE__ ) );
require WP_BOOJ_PATH . 'includes/WpBooj.php';
require WP_BOOJ_PATH . 'includes/WpBoojCache.php';

$WpBooj_options = get_option( 'wp-booj' );

new WpBooj();
new WpBoojCache();

// Listen for the plugin activate/deactivate event
register_activation_hook(   __FILE__,   'WpBooj_activate' );
register_deactivation_hook( __FILE__,   'WpBooj_deactivate'  );

if( is_admin() ){
  require WP_BOOJ_PATH . 'includes/WpBoojAdmin.php';
  new WpBoojAdmin();
}

if( $WpBooj_options['related_posts'] == 'on' ){
  require WP_BOOJ_PATH . 'includes/WpBoojRelated.php';
  $WpBoojRelated = new WpBoojRelated();
}

if( $WpBooj_options['use_WpBoojDebug'] == 'on' ){
  require WP_BOOJ_PATH . 'includes/WpBoojDebug.php';
}

function WpBooj_activate(){
  global $wpdb;
  $WpBoojCache_table_sql = "CREATE TABLE {$wpdb->prefix}WpBoojCache (
    `cache_id` int(11) NOT NULL AUTO_INCREMENT,
    `post_id` int(11) DEFAULT NULL,
    `cache_type` varchar(255) DEFAULT NULL,
    `data` longtext DEFAULT NULL,
    `last_update_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
     PRIMARY KEY (`cache_id`)
     ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $WpBoojCache_table_sql );
  wp_schedule_event(time(), 'daily', 'WpBooj_daily');
}

function WpBooj_deactivate(){ 
  global $wpdb;
  $WpBoojCache_table_sql = "DROP TABLE {$wpdb->prefix}WpBoojCache;";
  $wpdb->get_results( $WpBoojCache_table_sql );
}

function WpBooj_daily(){
  $WpBoojCache_table_sql = "TRUNCATE TABLE {$wpdb->prefix}WpBoojCache;";
  $wpdb->get_results( $WpBoojCache_table_sql );
}

if (! function_exists( 'wp_redirect' ) && $WpBooj_options['proxy_admin_urls'] == 'on' ) {
  function wp_redirect($location, $status = 302) {
    global $is_IIS;

    $location = apply_filters('wp_redirect', $location, $status);
    $status   = apply_filters('wp_redirect_status', $status, $location);

    if ( !$location ){ // allows the wp_redirect filter to cancel a redirect
      return false;
    }

    $location = wp_sanitize_redirect($location);

    if ( !$is_IIS && php_sapi_name() != 'cgi-fcgi' )
      status_header($status); // This causes problems on IIS and some FastCGI setups

    $uri_ext = '/' . WpBoojFindURISegment();
    $uri_len = strlen( $uri_ext ) + 1;
    if( substr( $location, 0, 1 ) == '/' && substr( $location, 0, $uri_len ) != $uri_ext ){
      $location = '/blog' . $location;
    }
    header("Location: $location", true, $status);
  } 
}

function WpBoojFindURISegment(){
  $site_url =  get_site_url();
  //Currently we're only going to support .com TLD
  if ( strpos( $site_url, '.com' ) !== false ){
    $exploded = explode( '.com', $site_url );
    if( ! empty( $exploded[1] ) ){
      $uri_segment = explode( '/', $exploded[1] );
      $uri = $uri_segment[1];
    } else{
      $uri = '';
    }
  }
  return $uri;
}

/* End File wp_booj.php */
