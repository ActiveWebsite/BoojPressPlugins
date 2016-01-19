<?php
/**
 * Plugin Name: What To Do Plugin
 * Plugin URI: http://sales.whattodo.info/
 * Description: This plugin allows you to display dynamically updated information, events, activities, discounts and more on your website. Note: This plugin requires Mcrypt extension (PHP), cURL extension (PHP)
 * Version: 1.0.2
 * Author: What To Do
 * Author URI: http://www.whattodo.info/splash/
 * License: Licensed Under What To Do LLC.
 */
 
define('WTD_PLUGIN_PATH', dirname(__FILE__));
define('WTD_PLUGIN_URL', plugins_url('/', __FILE__));
define('WTD_PLUGIN_FILE', __FILE__);
define('WTD_VERSION','1.0.2');
define('WTD_API_URL', 'http://admin.whattodo.info/wtd_plugin_api/api/');
define('WTD_IMG_BASE', 'http://cdn.whattodo.info/');
define('WTD_LEAD_BASE', 'http://whattodosites.com/wtd/lead/single/');

global $wtd_syncing;
$wtd_syncing = false;
 
global $wtd_modal;
$wtd_modal = false;

//Functionality
require_once WTD_PLUGIN_PATH.'/includes/framework/ReduxCore/framework.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_main.class.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_redux_config.class.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_connector.class.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_query_filter.class.php';
require_once WTD_PLUGIN_PATH.'/includes/wtd_ical_generator.class.php';

//Pages
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_activities_page.class.php';
//require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_single_activity.class.php';
//require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_calendar_page.class.php';
//require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_single_event.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_dining_page.class.php';
//require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_specials_page.class.php';
//require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_single_special.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_coupons_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_single_coupon.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_custom_page.class.php';
//require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_week_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_search_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_calendar_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_event.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_specials_page.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_special.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_week_events.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_week_specials.class.php';
require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_parse_single_activity.class.php';

//require_once WTD_PLUGIN_PATH.'/includes/pages/wtd_map_page.class.php';

$wtd_main = new wtd_main();
$wtd_connector = new wtd_connector();

?>
