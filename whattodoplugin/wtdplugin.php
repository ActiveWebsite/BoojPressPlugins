<?php
/**
 * Plugin Name: What To Do Plugin
 * Plugin URI: http://sales.whattodo.info/
 * Description: This plugin allows you to display dynamically updated information, events, activities, discounts and more on your website. Note: This plugin requires Mcrypt extension (PHP), cURL extension (PHP)
 * Version: 1.2.0.0
 * Author: What To Do
 * Author URI: http://www.whattodo.info/splash/
 * License: Licensed Under What To Do LLC.
 * Text Domain: whattodoplugin
 */
 
define('WTD_PLUGIN_PATH', dirname(__FILE__));
define('WTD_PLUGIN_URL', plugins_url('/', __FILE__));
define('WTD_PLUGIN_FILE', __FILE__);
define('WTD_VERSION', '1.2.0.0');
define('WTD_API_URL', 'http://admin.whattodo.info/admin/support/scp/ajax/parse/data_handler.php'); // production
define('WTD_IMG_BASE', 'http://cdn.whattodo.info/');
define('WTD_LEAD_BASE', 'http://whattodosites.com/wtd/lead/single/');

global $wtd_syncing, $wtd_modal;
$wtd_syncing = false;
$wtd_modal = false;

//Functionality
require_once WTD_PLUGIN_PATH.'/includes/framework/ReduxCore/framework.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_main.class.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_redux_config.class.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_connector.class.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_ical_generator.class.php';
require_once WTD_PLUGIN_PATH.'/includes/class_wtd_rewrite.php';

//Pages
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_activities_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_dining_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_coupons_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_coupon.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_calendar_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_event.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_specials_calendar_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_special.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_week_events.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_week_specials.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_activity.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_dining.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_overview_page.class.php';

$wtd_main = new wtd_main();
$wtd_rewrite = new wtdRewrite();
$wtd_connector = new wtd_connector();

include_once WTD_PLUGIN_PATH.'/includes/shortcodes/tinymce.php';

// called when the redux framework options are saved
add_action('redux/options/wtd_plugin/saved', 'optionsUpdate');
function optionsUpdate(){
	global $wp_rewrite;
	// flush the url rewrite rules after we have saved the redux options
	$wp_rewrite->flush_rules();
}?>