<?php
/**
 * ReduxFramework WhatToDo Plugin Config File
 * For full documentation, please visit: https://docs.reduxframework.com
 * */
require WTD_PLUGIN_PATH.'/vendor/autoload.php';
use Parse\ParseClient;
use Parse\ParseQuery;
use Parse\ParseException;
use Parse\ParseCloud;

if(!class_exists('wtd_redux_config')){
	global $wtd_api_error, $wtd_client_error, $wtd_redux_config;
	$wtd_api_error = false;
	$wtd_client_error = false;

	class wtd_redux_config{
		public $args = array();
		public $sections = array();
		public $theme;
		public $redux;
		private $paid_resorts;
		private $api_active = false;
		private $wtd_item_types;
		private $wtd_page_types;

		public function __construct(){
			try{
				ParseClient::initialize('uq0vJ1MzPcmMwbLuhxSNFF9tvx3WXHerQO7kKgu3', 'K9Oz5R2I3bWcz1bei7DJ1pLADNNjDX6D9annyOWu',''); // production
				//ParseClient::initialize( 'myAppId', 'restKey', 'mymasterkey' );
				// Users of Parse Server will need to point ParseClient at their remote URL:
				//ParseClient::setServerURL('http://localhost:1337/parse');
			}catch(ParseException $ex){
				var_dump($ex);
			}
			if(!class_exists('ReduxFramework'))
				return;

			$this->wtd_item_types = array('activity', 'event', 'special', 'coupon', 'dining');
			$this->wtd_page_types = array('activities', 'calendar', 'specials', 'coupons', 'dining', 'week', 'weekspecials');
			add_action('redux/page/wtd_plugin/form/before', array($this, 'beforeReduxPanel'));
			add_action('redux/page/wtd_plugin/form/after', array($this, 'afterReduxPanel'));
			// This is needed. Bah WordPress bugs.  ;)
			add_action('init', array($this, 'initSettings'), 1000000);
		}

		public function beforeReduxPanel(){
			echo '<div ng-app="wtdPluginAdmin">';
		}

		public function afterReduxPanel(){
			echo '</div>';
		}

		public function initSettings(){
			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();
			$wtd_set = get_option('wtd_plugin');
			if(!empty($wtd_set['wtd_api_key']))
				$this->api_active = true;
			$wtd_redux_transient = get_option('wtd_plugin-transients');
			if(!empty($wtd_redux_transient['last_save'])){
				$wtd_time_diff = time() - $wtd_redux_transient['last_save'];
				if($wtd_time_diff > (60 * 60))
					delete_option('wtd_plugin-transients');
			}
			// Set the default arguments
			$this->setArguments();
			// Set a few help tabs so you can see how it's done
			$this->setHelpTabs();
			if(!empty($wtd_set['wtd_resorts'])){
				$map_def = array();
				foreach($wtd_set['wtd_resorts'] as $resort){
					$map_def[$resort] = array('lat' => '38', 'lng' => '-95.677068');
				}
				$this->wtd_pages['map-page']['args']['fields'][0]['default'] = $map_def;
			}
			if(!empty($this->wtd_pages)){
				foreach($this->wtd_pages as $key => $value){
					if(!empty($wtd_set[$key]))
						$this->wtd_pages[$key]['enabled'] = 1;
				}
			}
			// Create the sections and fields
			add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array($this, 'compiler_action'), 10, 3);

			$this->setSections();
			if(!isset($this->args['opt_name'])) // No errors please
				return;

			$this->redux = new ReduxFramework($this->sections, $this->args);
		}

		/**
		 * Runs for any field that has compiler set to true
		 * It only runs if a field set with compiler=>true
		 * */
		function compiler_action($options, $css, $changed_values){
			$wtd_feed = get_option('wtd_feed');
			$client_fields = array(
				'first_name',
				'last_name',
				'company',
				'company_address1',
				'company_country',
				'company_city',
				'company_state',
				'company_email',
				'company_zip',
				'company_phone',
				'primary_resort');
			$nav_options = get_option('wtd_nav_options');
			$nav_fields = array(
				'act_page_type',
				'activities_sort_by',
				'act_page_mosaic',
				'calendar_type',
				'dining_page_type',
				'dining_sort_by',
				'map_page_type',
				'specials_type');
			$client_check = false;
			foreach($changed_values as $key => $value){
				$key_parts = explode('-', $key);
				$page_type = $key_parts[0];
				// look for the page type in the wtd_page_types array
				// if its a wtd page then do a check for create or delete
				if(in_array($page_type, $this->wtd_page_types))
					wtd_page_check($key, $value);

				switch($key){
					// if its a resort that has been changed we need to either delete or create some pages
					case 'wtd_resorts':
						toggle_wtd_resort($this->wtd_page_types);
						break;
					/*case 'overview-page':
						$wtd_pages = get_option('wtd_pages');
						if(!empty($options[$key])){
							$args = array(
								'post_type' => 'page',
								'orderby' => 'ID',
								'order' => 'ASC',
								'meta_query' => array(
									array(
										'key' => 'wtd_page',
										'value' => 'overview_page')));
							$page_query = new WP_Query($args);
							if(!$page_query->found_posts){
								$new_page = array(
									'post_title' => 'What To Do Overview',
									'post_content' => '',
									'post_type' => 'page',
									'post_status' => 'publish');
								$page_id = wp_insert_post($new_page);
								update_post_meta($page_id, 'wtd_page', 'overview_page');
								$wtd_pages['overview_page'] = $page_id;
							}
						}else{
							wp_delete_post($wtd_pages['overview_page'], true);
							unset($wtd_pages['overview_page']);
						}
						update_option('wtd_pages', $wtd_pages);
						break;*/
				}
				if(in_array($key, $nav_fields)){
					if(!empty($nav_options))
						$nav_options[$key] = $options[$key];
					else
						$nav_options = array($key => $options[$key]);
					update_option('wtd_nav_options', $nav_options);
				}
				if(in_array($key, $client_fields) && !$client_check){
					$client_post = array();
					foreach($client_fields as $cf){
						if(empty($options[$cf])){
							$client_check = true;
							break;
						}else
							$client_post[$cf] = $options[$cf];
					}
				}
			}
		}

		/**
		 * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 * Simply include this function in the child themes functions.php file.
		 * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 * so you must use get_template_directory_uri() if you want to use any of the built in icons
		 * */
		function dynamic_section($sections){
			//$sections = array();
			$sections[] = array(
				'title' => __('Section via hook', 'wtd-admin'),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'wtd-admin'),
				'icon' => 'el-icon-paper-clip',
				// Leave this as a blank section, no options just some intro text set above.
				'fields' => array());
			return $sections;
		}

		/**
		 * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
		 * */
		function change_arguments($args){
			//$args['dev_mode'] = true;
			return $args;
		}

		/**
		 * Filter hook for filtering the default value of any given field. Very useful in development mode.
		 * */
		function change_defaults($defaults){
			$defaults['str_replace'] = 'Testing filter hook!';
			return $defaults;
		}

		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo(){
			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if(class_exists('ReduxFrameworkPlugin')){
				remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
				// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
				remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
			}
		}

		private function getSetupSection(){
			$this->sections[] = array(
				'title' => __('Setup', 'wtd-admin'),
				'desc' => '<link rel="stylesheet" href="'.WTD_PLUGIN_URL.'assets/css/wtd_redux.css"/><script src="'.WTD_PLUGIN_URL.'assets/js/wtd_redux.js"></script>',
				'icon' => 'el-icon-cog',
				'class' => 'wtd_setup_page',
				'submenu' => false,
				'fields' => array(
					array(
						'id' => 'setup-page',
						'type' => 'callback',
						'callback' => 'wtd_setup_page',
						'title' => 'Options'
					)
				)
			);
			$resorts_active = json_decode(file_get_contents(WTD_API_URL.'?action=get_resorts'));
			$this->sections[] = array(
				'title' => __('Client Information', 'wtd-admin'),
				'icon' => 'el-icon-address-book',
				'subsection' => true,
				'class' => 'client_information',
				'fields' => array(
					array(
						'id' => 'first_name',
						'type' => 'text',
						'title' => 'First Name',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'last_name',
						'type' => 'text',
						'title' => 'Last Name',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company',
						'type' => 'text',
						'title' => 'Company Name',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company_address1',
						'type' => 'text',
						'title' => 'Address Line 1',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company_address2',
						'type' => 'text',
						'title' => 'Address Line 2'),
					array(
						'id' => 'company_country',
						'type' => 'text',
						'title' => 'Country',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company_city',
						'type' => 'text',
						'title' => 'City',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company_state',
						'type' => 'text',
						'title' => 'State',
						'placeholder' => 'State abbreviation (e.g. CO, CA)',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company_zip',
						'type' => 'text',
						'title' => 'ZIP Code',
						'validate' => 'numeric',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company_phone',
						'type' => 'text',
						'title' => 'Phone',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'company_cell',
						'type' => 'text',
						'title' => 'Cell Phone'),
					array(
						'id' => 'company_fax',
						'type' => 'text',
						'title' => 'Fax'),
					array(
						'id' => 'company_email',
						'type' => 'text',
						'title' => 'E-mail Address',
						'validate' => 'email',
						'validate' => 'not_empty',
						'compiler' => true),
					array(
						'id' => 'primary_resort',
						'type' => 'select',
						'title' => 'Primary Resort',
						'options' => $resorts_active))
				);
		}

		private function getResortsSection(){
//			// get all resorts from parse
//			try{
//				$query = new ParseQuery("resort");
//				$results = $query->find();
//				// Create an array of resorts with parse object id and name
//				for($i = 0; $i < count($results); $i++){
//					$object = $results[$i];
//					$resorts[$object->getObjectId()] = $object->get('name');
//				}
//			}catch(ParseException $cx){
//				error_log($cx.getMessage());
//				error_log($cx.getCode());
//			}
			// find which resorts are paid if they have a token
			$query = new ParseQuery("wp_site");
			$query->equalTo('token', get_option('wtd_api_token'));
			$results = $query->find();
			$object = $results[0];
			ob_start();
			if(!empty($object)){
				try{
					$relation = $object->getRelation('resortRelation', 'resort');
					$this->paid_resorts = $relation->getQuery()->find();
				}catch(ParseException $ex){
					var_dump($ex);
				}
			}else
				$this->paid_resorts = array();

			if(!empty($this->paid_resorts)){?>
				<div layout="column">
					<span>Paid Resorts</span><?php
					for($i = 0; $i < count($this->paid_resorts); $i++){
						$resort = $this->paid_resorts[$i];
						$resorts[$resort->getObjectId()] = $resort->name;?>
						<div><?php
							echo $resort->name;?>
						</div><?php
					}?>
				</div><?php
			}else{?>
				<span style="font-weight:bold;color:red;">No paid resorts are active please contact WhatToDo.</span><?php
			}
			$desc = ob_get_contents();
			ob_end_clean();

			$this->sections[] = array(
				'title' => __('Resorts', 'wtd-admin'),
				'desc' => $desc,
				'icon' => 'el-icon-cogs',
				'submenu' => false,
				'fields' => array(
					array(
				        'id' => 'wtd_resorts',
					    'type' => 'select',
					    'multi' => true,
					    'title' => __('Resorts', 'wtd-admin'),
					    'subtitle' => __('Choose the resorts to display on this website.', 'wtd-admin'),
					    //Must provide key => value pairs for radio options
					    'options' => $resorts,
					    'compiler' => true
				    )
			    )
		    );
		}

		private function getAdvancedSection(){
			$this->sections[] = array(
				'title' => __('Advanced', 'wtd-admin'),
				'subsection' => true,
				'fields' => array(
					/*array(
						'id' => 'wtd_change_api',
						'type' => 'info',
						'style' => 'info',
						'title' => '<a href="javascript:void(0);" class="button button-primary wtd_key_changer">Change Client Key</a>',
						'desc' => '<span style="margin-top:20px;float:left;"><b>Note:</b> In event that you need to utilize a different Client Key with this site then use this feature.  Doing so may change the data that is displayed on your site, for example, if the new Client Key has access to different resorts than the one your are currently using.</span>'),
					array(
						'id' => 'wtd_delete_data',
						'type' => 'info',
						'style' => 'info',
						'title' => '<a href="' . admin_url('admin.php?page=wtd_plugin_settings&wtd_pre_reset=1') . '" class="button button-primary wtd_reseter">Reload All WTD Imported Data</a>',
						'desc' => '<span style="margin-top:20px;float:left;"><b>Note:</b>  This feature will delete all What To Do data from your site and import a fresh copy of it. You will rarely, if ever, need to do this. Only use this feature if you are having issues with the data not displaying correctly or expect different data to be displayed than you are seeing. What To Do automatically updates your data by only importing changes and additions, keeping bandwidth usage and processor utilization low, so this feature is typically not used. Using it will not affect the layout or design of any of your What To Do Pages.</span>'),
					array(
						'id' => 'wtd_hard_reset',
						'type' => 'info',
						'style' => 'info',
						'title' => '<a href="' . admin_url('admin.php?page=wtd_plugin_settings&wtd_pre_reset=2') . '" class="button button-primary wtd_hard_reseter">Hard Reset WTD Plug-in</a>',
						'desc' => '<span style="margin-top:20px;float:left;"><b>Note:</b>  Only use this feature if you are requested to by What To Do technical support or your website manager. This feature will reset your entire What To Do plugin, including deleting all What To Do pages, data and your feed settings. The plugin will remain installed but will revert to a brand new installation, ready to be set up again.</span>'),
					*/
					array(
						'id' => 'url_prefix',
						'type' => 'text',
						'title' => 'URL Prefix',
						'readonly' => true,
						'desc' => 'The URL Prefix is the set of characters that is present in the URL for every WTD page. Changing this value may interfere with other posts, pages or plug-ins causing the pages generated by this plug-in to break. Only use this feature if you are fully aware of its purpose or a WTD team member asks you to do that.',
						"default" => 'wtd'),
					array(
						'id' => 'cat_url_prefix',
						'type' => 'text',
						'title' => 'Category URL Prefix',
						'readonly' => true,
						'desc' => 'The Category URL Prefix is the set of characters that is present in the URL for every WTD details page of the items that have only one category. Changing this value may interfere with other posts, pages or plug-ins causing the pages generated by this plug-in to break. Only use this feature if you are fully aware of its purpose or a WTD team member asks you to do that.',
						"default" => 'wtdc'),
					array(
						'id' => 'scat_url_prefix',
						'type' => 'text',
						'title' => 'Sub-Category URL Prefix',
						'readonly' => true,
						'desc' => 'The Sub-Category URL Prefix is the set of characters that is present in the URL for every WTD details page of the items that have two categories. Changing this value may interfere with other posts, pages or plug-ins causing the pages generated by this plug-in to break. Only use this feature if you are fully aware of its purpose or a WTD team member asks you to do that.',
						"default" => 'wtds')
				)
			);
		}

		private function getWhatToDoPagesSection(){
			global $wtd_plugin;
			$this->sections[] = array(
				'title' => __('WTD Pages', 'wtd-admin'),
				'desc' => __('What To Do Pages', 'wtd-admin'),
				'desc' => '',
				'icon' => 'el-icon-website',
				'class' => 'wtd_pages',
				'submenu' => false,
				'fields' => array(
					array(
						'id' => 'activities-page',
						'type' => 'switch',
						'title' => __('Activities', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
					array(
						'id' => 'calendar-page',
						'type' => 'switch',
						'title' => __('Events Calendar', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
					array(
						'id' => 'week-page',
						'type' => 'switch',
						'title' => __('Weekly Events Calendar', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
					array(
						'id' => 'dining-page',
						'type' => 'switch',
						'title' => __('Dining', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
//					array(
//						'id' => 'map-page',
//						'type' => 'switch',
//						'title' => __( 'Activities Map', 'wtd-admin' ),
//						'on' => 'Enable',
//						'off' => 'Disable',
//						'compiler' => true,
//						'default' => 0),
					array(
						'id' => 'coupons-page',
						'type' => 'switch',
						'title' => __('Coupons', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
					array(
						'id' => 'specials-page',
						'type' => 'switch',
						'title' => __('Specials Calendar', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
					array(
						'id' => 'weekspecials-page',
						'type' => 'switch',
						'title' => __('Weekly Specials Calendar', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
					/*array(
						'id' => 'search-page',
						'type' => 'switch',
						'title' => __('Search', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0),
					array(
						'id' => 'overview-page',
						'type' => 'switch',
						'title' => __('Overview', 'wtd-admin'),
						'on' => 'Enable',
						'off' => 'Disable',
						'compiler' => true,
						'default' => 0)*/
				)
			);
			if(isset($wtd_plugin['activities-page'])){
				$this->sections[] = array(
					'icon' => 'el-icon-th-list',
					'title' => 'Activities',
					'desc' => '',
					'class' => 'activities-page',
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'activities_pages',
							'type' => 'callback',
							'title' => 'Preview Pages',
							'callback' => 'wtd_activities_pages'),
						array(
							'id' => 'act_page_type',
							'type' => 'button_set',
							'title' => 'Navigation',
							'options' => array(
								//1 => 'Full Menu',
								2 => 'Top Drop-Down Menu',
								3 => 'Left Side Menu'),
							'default' => 2,
							'compiler' => true),
						/*array(
							'id' => 'activities_sort_by',
							'type' => 'button_set',
							'title' => 'Sort By',
							'options' => array(
								1 => 'Title',
								3 => 'Activity Provider'),
							'default' => 1,
							'compiler' => true),
						array(
							'id' => 'act_page_mosaic',
							'type' => 'switch',
							'title' => 'Mosaic',
							'on' => 'Enable',
							'off' => 'Disable',
							'default' => '',
							'compiler' => true)*/
					)
				);
			}
			if(isset($wtd_plugin['calendar-page'])){
				$this->sections[] = array(
					'icon' => 'el-icon-calendar',
					'title' => 'Events Calendar',
					'desc' => '',
					'class' => 'calendar-page',
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'calendar_pages',
							'type' => 'callback',
							'title' => 'Preview Pages',
							'callback' => 'wtd_calendar_pages'),
						array(
							'id' => 'calendar_type',
							'type' => 'button_set',
							'title' => 'Navigation',
							'options' => array(
								1 => 'One Image',
								2 => 'Four Images',
								3 => 'List View'),
							'default' => 3,
							'compiler' => true)
					)
				);
			}
			if(isset($wtd_plugin['dining-page'])){
				$this->sections[] = array(
					'icon' => 'el-icon-glass',
					'title' => 'Dining',
					'desc' => '',
					'class' => 'dining-page',
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'dining_pages',
							'type' => 'callback',
							'title' => 'Preview Pages',
							'callback' => 'wtd_dining_pages'),
						array(
							'id' => 'dining_page_type',
							'type' => 'button_set',
							'title' => 'Navigation',
							'options' => array(
								//1 => 'Full Menu',
								2 => 'Top Drop-Down Menu',
								3 => 'Left Side Menu'),
							'default' => 2,
							'compiler' => true),
						/*array(
							'id' => 'dining_sort_by',
							'type' => 'button_set',
							'title' => 'Sort By',
							'options' => array(
								1 => 'Title',
								3 => 'Activity Provider'),
							'default' => '',
							'compiler' => true)*/
					)
				);
			}
			if(isset($wtd_plugin['specials-page'])){
				$this->sections[] = array(
					'icon' => 'el-icon-calendar',
					'title' => 'Specials',
					'desc' => '',
					'class' => 'specials-page',
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'specials_pages',
							'type' => 'callback',
							'title' => 'Preview Pages',
							'callback' => 'wtd_specials_pages'),
						array(
							'id' => 'specials_type',
							'type' => 'button_set',
							'title' => 'Navigation',
							'options' => array(
								1 => 'One Image',
								2 => 'Four Images',
								3 => 'List View'),
							'default' => 3,
							'compiler' => true)
					)
				);
			}
			/*if($wtd_plugin['search-page']){
				$this->sections[] = array(
					'icon' => 'el-icon-search',
					'title' => 'Search',
					'class' => 'search-page',
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'shortcode_place',
							'type' => 'callback',
							'title' => 'Shortcode',
							'callback' => 'wtd_shortcode_display'),
						array(
							'id' => 'shortcode_options',
							'type' => 'callback',
							'title' => 'Categories',
							'subtitle' => 'exclude categories from search results',
							'callback' => 'wtd_shortcode_options'),
						array(
							'id' => 'shortcode_temp',
							'type' => 'callback',
							'title' => 'Options<span class="options_wtd_flag" data-place="activities_options">&nbsp</span>',
							'callback' => 'wtd_shortcode_temp')
					)
				);
			}*/
		}

		private function getStylingOptionsSection(){
			$this->sections[] = array(
				'title' => __('Styling Options', 'wtd-admin'),
				'icon' => 'el-icon-brush',
				'submenu' => false,
				'class' => 'wtd_general_style',
				'fields' => array(
					array(
						'id' => 'wtd_copyright_holder',
						'type' => 'button_set',
						'title' => 'What To Do Copyright',
						'options' => array(1 => 'Normal'),
						'default' => 1
					)
				)
			);
//                    $this->sections[] = array(
//                        'title'  => __(  'Full Menu', 'wtd-admin' ),
//                        'icon'   => 'el-icon-th-large',
//                        'class' => 'wtd_typograpy_panel big_menu',
//                        'subsection' => true,
//                        'fields' => array(
//                            array(
//                                'id'       => 'fm_parent_menu',
//                                'type'     => 'typography',
//                                'font-family' => false,
//                                'font-backup' => false,
//                                'line-height' => false,
//                                'text-align' => false,
//                                'font-subsets' => false,
//                                'font-size' => false,
//                                'google' => false,
//                                'units'       =>'px',
//                                'default'     => array(
//                                    'color'       => '#7A644D',
//                                    'font-style'  => '700',
//                                    'font-size'   => '18px',
//                                    'google' => false
//                                )
//
//                            ),
//                            array(
//                                'id'       => 'fm_parent_menu_active',
//                                'type'     => 'typography',
//                                'font-backup' => false,
//                                'font-family' => false,
//                                'font-substes' => false,
//                                'line-height' => false,
//                                'text-align' => false,
//                                'font-subsets' => false,
//                                'google' => false,
//                                'units'       =>'px',
//                                'default'     => array(
//                                    'color'       => '#2E2D2D',
//                                    'font-style'  => '400',
//                                    'font-size'   => '18px',
//                                    'google' => false
//                                )
//
//                            ),
//                            array(
//                                'id'       => 'fm_child_menu_background',
//                                'type'     => 'typography',
//                                'font-backup' => false,
//                                'font-family' => false,
//                                'font-substes' => false,
//                                'line-height' => false,
//                                'text-align' => false,
//                                'font-subsets' => false,
//                                'font-style' => false,
//                                'font-size' => false,
//                                'font-weight' => false,
//                                'units'       =>'px',
//                                'default'     => array(
//                                    'color'       => '#eaeaea'
//                                )
//
//                            ),
//                            array(
//                                'id'       => 'fm_child_menu',
//                                'type'     => 'typography',
//                                'font-family' => false,
//                                'font-backup' => true,
//                                'line-height' => false,
//                                'text-align' => false,
//                                'font-subsets' => false,
//                                'google' => false,
//                                'units'       =>'px',
//                                'subtitle'    => 'Child Menu',
//                                'default'     => array(
//                                    'color'       => '#7A644D',
//                                    'font-style'  => '400',
//                                    'font-size'   => '15px',
//                                    'google' => false
//                                )
//
//                            ),
//                            array(
//                                'id'       => 'fm_child_menu_active',
//                                'type'     => 'typography',
//                                'font-backup' => false,
//                                'font-family' => false,
//                                'font-substes' => false,
//                                'line-height' => false,
//                                'text-align' => false,
//                                'google' => false,
//                                'font-subsets' => false,
//                                'units'       =>'px',
//                                'subtitle'    => 'Parent Menu',
//                                'default'     => array(
//                                    'color'       => '#8a8a8a',
//                                    'font-style'  => '400',
//                                    'font-size'   => '15px',
//                                    'google' => false
//                                )
//
//                            ),
//                            array(
//                                'id'       => 'full_menu_hidden',
//                                'type'     => 'callback',
//                                'callback' => 'wtd_full_menu'
//                            )
//                        )
//                    );
		}

		private function getAddressSection(){
			$this->sections[] = array(
				'title' => __('Physical Address', 'wtd-admin'),
				'icon' => 'el-icon-briefcase',
				'class' => 'wtd_physical_address',
				'subsection' => true,
				'fields' => array(
					array(
						'id' => 'address',
						'type' => 'text',
						'title' => 'Street'),
					array(
						'id' => 'city',
						'type' => 'text',
						'title' => 'City'),
					array(
						'id' => 'state',
						'type' => 'text',
						'title' => 'State',
						'desc' => 'State code (e.g. CO)'),
					array(
						'id' => 'zip',
						'type' => 'text',
						'title' => 'Zip Code',
						'validate' => 'numeric'),
					array(
						'id' => 'user_map',
						'type' => 'callback',
						'title' => 'Map Position',
						'callback' => 'wtd_user_map',
						'default' => array(
							'lat' => '38',
							'lng' => '-95.677068'),
						'compiler' => true)));
		}

		public function getClientDetailsSection(){
			$query = new ParseQuery('wp_site');
			$query->equalTo('token', get_option('wtd_api_token'));
			$results = $query->find();
			ob_start();
			$site = $results[0];?>
			<table class="form-table" id="client_table">
				<tr>
					<th>
						Company
					</th>
					<td><?php
						echo $site->clientName;?>
					</td>
				</tr>
				<tr>
					<th>
						Client Key
					</th>
					<td><?php
						echo $site->apiKey;?>
					</td>
				</tr>
				<tr>
					<th>
						Paid Resorts
					</th>
					<td><?php
						$relation = $site->getRelation('resortRelation', 'resort');
						$paid_resorts = $relation->getQuery()->find();
						for($i = 0; $i < count($paid_resorts); $i++){
							$resort = $paid_resorts[$i];
							echo $resort->name.'<br/>';
						}?>
					</td>
				</tr>
			</table><?php
			$details = ob_get_contents();
			ob_end_clean();
			//Client Details
			$this->sections[] = array(
				'id' => 'client_details',
				'type' => 'info',
				'title' => 'Client Details',
				'style' => 'info',
				'submenu' => false,
				'desc' => $details);
		}

		public function setSections(){
			global $wtd_plugin;
			/**
			 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 * */
			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
			$sample_patterns_url = ReduxFramework::$_url . '../sample/patterns/';
			$sample_patterns = array();
			if(is_dir($sample_patterns_path)):
				if($sample_patterns_dir = opendir($sample_patterns_path)) :
					$sample_patterns = array();
					while(($sample_patterns_file = readdir($sample_patterns_dir)) !== false){
						if(stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false){
							$name = explode('.', $sample_patterns_file);
							$name = str_replace('.' . end($name), '', $sample_patterns_file);
							$sample_patterns[] = array('alt' => $name, 'img' => $sample_patterns_url.$sample_patterns_file);
						}
					}
				endif;
			endif;
			ob_start();
			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name');
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';
			$customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'wtd-admin'), $this->theme->display('Name'));?>
			<div id="current-theme" class="<?php echo esc_attr($class);?>"><?php
				if($screenshot):
					if(current_user_can('edit_theme_options')):?>
						<a href="<?php echo wp_customize_url();?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title);?>">
							<img src="<?php echo esc_url($screenshot);?>" alt="<?php esc_attr_e('Current theme preview', 'wtd-admin');?>"/>
						</a><?php
					endif;?>
					<img class="hide-if-customize" src="<?php echo esc_url($screenshot);?>" alt="<?php esc_attr_e('Current theme preview', 'wtd-admin');?>"/><?php
				endif;?>

				<h4><?php echo $this->theme->display('Name');?></h4>
				<div>
					<ul class="theme-info">
						<li><?php printf(__('By %s', 'wtd-admin'), $this->theme->display('Author'));?></li>
						<li><?php printf(__('Version %s', 'wtd-admin'), $this->theme->display('Version')); ?></li>
						<li><?php echo '<strong>' . __('Tags', 'wtd-admin') . ':</strong> ';?><?php printf($this->theme->display('Tags')); ?></li>
					</ul>
					<p class="theme-description"><?php echo $this->theme->display('Description');?></p><?php
					if($this->theme->parent())
						printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'wtd-admin') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'wtd-admin'), $this->theme->parent()->display('Name'));?>
				</div>
			</div><?php

			$item_info = ob_get_contents();
			ob_end_clean();
			$sampleHTML = '';
			if(file_exists(dirname(__FILE__) . '/info-html.html')){
				Redux_Functions::initWpFilesystem();
				global $wp_filesystem;
				$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
			}

			if(empty(get_option('wtd_api_token'))){
				$this->getSetupSection();
			}else{
				$this->getResortsSection();
				if(!empty($wtd_plugin['wtd_resorts']) && !empty($this->paid_resorts)){
					$this->getClientDetailsSection();
					$this->sections[] = array(
						'title' => __('General Settings', 'wtd-admin'),
						'desc' => '<link rel="stylesheet" href="'.WTD_PLUGIN_URL.'assets/css/wtd_redux.css?wtd_version='.WTD_VERSION.'"/><script src="'.WTD_PLUGIN_URL.'assets/js/wtd_redux.js?wtd_version='.WTD_VERSION.'"></script>',
						'icon' => 'el-icon-cogs',
						'submenu' => false,
						'fields' => array(
							array(
								'id' => 'wtd_api_error',
								'type' => 'info',
								'title' => 'API connection error!',
								'icon' => 'el-icon-error-alt',
								'desc' => '<ul id="wtd_api_errors"></ul>',
								'style' => 'critical')
						)
					);

					$this->getAdvancedSection();
					$this->getAddressSection();
					$this->getWhatToDoPagesSection();
					$this->getStylingOptionsSection();

					$area_cats = array(
						'All Categories' => 'All Categories',
						'Activity Provider' => 'Activity Provider',
						'Concierge' => 'Concierge',
						'Event Calendar' => 'Event Calendar',
						'Hotel-Motel' => 'Hotel-Motel',
						'Information Booth' => 'Information Booth',
						'Property Management' => 'Property Management',
						'Private Vacation Rental' => 'Private Vacation Rental',
						'Real Estate' => 'Real Estate',
						'Restaurant' => 'Restaurant',
						'Wedding' => 'Wedding');
					/*$this->sections[] = array(
						'title' => __('Feed Settings', 'wtd-admin'),
						'icon' => 'el-icon-filter',
						'submenu' => false,
						'class' => 'feed_settings',
						'fields' => array(
							array(
								'id' => 'business_category',
								'type' => 'select',
								'title' => 'Select your website type',
								'subtitle' => 'Select the website type that is closest to your type of business to receive suggestions on optimal feed setup.',
								'desc' => 'Please save the settings after changing this option',
								'multi' => false,
								'options' => $area_cats,
								'default' => 'All Categories',
								'compiler' => true)));*/

					/*$this->sections[] = array(
						'title' => __('Activity Providers', 'wtd-admin'),
						'icon' => 'el-icon-list',
						'subsection' => true,
						'fields' => array(
							array(
								'id' => 'activity_providers',
								'type' => 'button_set',
								'title' => 'Activity Providers',
								//Must provide key => value pairs for options
								'options' => array(
									'1' => 'Default',
									'2' => 'Exclude Certain Activity Providers',
									'3' => 'Include Certain Activity Providers'),
								'default' => '1'),
							));*/
	//				array(
	//						'id' => 'excluded_vendors',
	//						'type' => 'select',
	//						'title' => 'Exclude the following activity providers',
	//						'multi' => true,
	//						'options' => $vendors,
	//						'class' => 'exclude_vendors'),
	//					array(
	//						'id' => 'vendors',
	//						'type' => 'select',
	//						'title' => 'Include only the activities provided by the following activity providers',
	//						'multi' => true,
	//						'options' => $vendors,
	//						'class' => 'include_vendors')
	//			$this->sections[] = array(
	//				'title' => __('Locations', 'wtd-admin'),
	//				'icon' => 'el-icon-map-marker-alt',
	//				'subsection' => true,
	//				'fields' => array(
	//					array(
	//						'id' => 'excluded_locations',
	//						'type' => 'select',
	//						'title' => 'Exclude the following Locations',
	//						'multi' => true,
	//						'options' => $locations)));
					$this->sections[] = array(
						'title' => __('Categories', 'wtd-admin'),
						'icon' => 'el-icon-bookmark',
						'subsection' => true,
						'fields' => array(
							array(
								'id' => 'business_categories',
								'type' => 'callback',
								'title' => 'Categories<span data-place="business_categories_options"></span>',
								'subtitle' => 'This will filter the imported data based on the enabled categories',
								'callback' => 'wtd_bus_options',
								'compiler' => true)));
				}
			}
			if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')){
				$tabs['docs'] = array(
					'icon' => 'el-icon-book',
					'title' => __('Documentation', 'wtd-admin'),
					'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html')));
			}
		}

		public function setHelpTabs(){
			// Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
			$this->args['help_tabs'][] = array(
				'id' => 'redux-help-tab-1',
				'title' => __('Theme Information 1', 'wtd-admin'),
				'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'wtd-admin'));
			$this->args['help_tabs'][] = array(
				'id' => 'redux-help-tab-2',
				'title' => __('Theme Information 2', 'wtd-admin'),
				'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'wtd-admin'));
			// Set the help sidebar
			$this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'wtd-admin');
		}

		/**
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		public function setArguments(){
			$theme = wp_get_theme(); // For use with some settings. Not necessary.
			$this->args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name' => 'wtd_plugin',
				// This is where your data is stored in the database and also becomes your global variable name.
				'display_name' => '<div style="float:left;margin-right: 20px;"><img src="'.WTD_PLUGIN_URL.'/assets/img/whattodo-logo.png" style="float:left;" /></div><br/>',
				'display_version' => '<span style="margin-top:50px;float:right;font-size: 12px;">version '.WTD_VERSION.'</span>',
				'menu_type' => 'menu',
				//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu' => true,
				// Show the sections below the admin menu item or not
				'menu_title' => __('What To Do', 'wtd-plugin'),
				'page_title' => __('What To Do', 'wtd-plugin'),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key' => '',
				// Set it you want google fonts to update weekly. A google_api_key value is required.
				'google_update_weekly' => false,
				// Must be defined to add google fonts to the typography module
				'async_typography' => false,
				// Use a asynchronous font on the front end or font string
				'disable_google_fonts_link' => true,
				// Disable this in case you want to create your own google fonts loader
				'admin_bar' => true,
				// Show the panel pages on the admin bar
				'admin_bar_icon' => WTD_PLUGIN_URL . 'assets/img/wtd_magnifying_glass_20px.png',
				// Choose an icon for the admin bar menu
				'admin_bar_priority' => 50,
				// Choose an priority for the admin bar menu
				'global_variable' => '',
				// Set a different name for your global variable other than the opt_name
				'dev_mode' => false,
				// Show the time the page took to load, etc
				'update_notice' => false,
				// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
				'customizer' => false,
				// Enable basic customizer support
				//'open_expanded'     => true, // Allow you to start the panel in an expanded way initially.
				'disable_save_warn' => false,
				// Disable the save warning when a user changes a field
				// OPTIONAL -> Give you extra features
				'page_priority' => null,
				// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent' => 'themes.php',
				// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions' => 'manage_options',
				// Permissions needed to access the options panel.
				'menu_icon' => WTD_PLUGIN_URL . 'assets/img/wtd_magnifying_glass_20px.png',
				// Specify a custom URL to an icon
				'last_tab' => '',
				// Force your panel to always open to a specific tab (by id)
				'page_icon' => 'icon-themes',
				// Icon displayed in the admin panel next to your menu_title
				'page_slug' => 'wtd_plugin_settings',
				// Page slug used to denote the panel
				'save_defaults' => true,
				// On load save the defaults to DB before user clicks save or not
				'default_show' => false,
				// If true, shows the default value next to each field that is not the default value.
				'default_mark' => '',
				// What to print by the field's title if the value shown is default. Suggested: *
				'show_import_export' => false,
				// Shows the Import/Export panel when not used as a field.
				// CAREFUL -> These options are for advanced use only
				'transient_time' => 60 * MINUTE_IN_SECONDS,
				'output' => false,
				// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag' => true,
				// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database' => '',
				// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
				'system_info' => false,
				// REMOVE
				// HINTS
				'hints' => array(
					'icon' => 'icon-question-sign',
					'icon_position' => 'right',
					'icon_color' => 'lightgray',
					'icon_size' => 'normal',
					'tip_style' => array(
						'color' => 'light',
						'shadow' => true,
						'rounded' => false,
						'style' => '',),
					'tip_position' => array(
						'my' => 'top left',
						'at' => 'bottom right',),
					'tip_effect' => array(
						'show' => array(
							'effect' => 'slide',
							'duration' => '500',
							'event' => 'mouseover',),
						'hide' => array(
							'effect' => 'slide',
							'duration' => '500',
							'event' => 'click mouseleave'))));
			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
			$this->args['share_icons'][] = array(
				'url' => 'https://github.com/WhatToDoInfo/whattodo',
				'title' => 'Visit us on GitHub',
				'icon' => 'el-icon-github'
				//'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
			);
			$this->args['share_icons'][] = array(
				'url' => 'https://www.facebook.com/whattodoaspenglenwood',
				'title' => 'Like us on Facebook',
				'icon' => 'el-icon-facebook');
			$this->args['share_icons'][] = array(
				'url' => 'https://twitter.com/WhatToDoVail',
				'title' => 'Follow us on Twitter',
				'icon' => 'el-icon-twitter');
			$this->args['share_icons'][] = array(
				'url' => 'https://www.linkedin.com/company/1551382',
				'title' => 'Find us on LinkedIn',
				'icon' => 'el-icon-linkedin');
			// Panel Intro text -> before the form
			if(!isset($this->args['global_variable']) || $this->args['global_variable'] !== false){
				if(!empty($this->args['global_variable']))
					$v = $this->args['global_variable'];
				else
					$v = str_replace('-', '_', $this->args['opt_name']);
			}else
				$this->args['intro_text'] = '';
			// Add content after the form.
			$this->args['footer_text'] = __('<p>For more information checkout <a href="support.whattodo.info">support.whattodo.info</a></p>', 'wtd-admin');
		}

		public function validate_callback_function($field, $value, $existing_value){
			$error = true;
			$value = 'just testing';
			/*
          do your validation
          if(something){
            $value = $value;
          }elseif(something else){
            $error = true;
            $value = $existing_value;
          }
         */
			$return['value'] = $value;
			$field['msg'] = 'your custom error message';
			if($error == true)
				{$return['error'] = $field;}
			return $return;
		}

		public function class_field_callback($field, $value){
			print_r($field);
			echo '<br/>CLASS CALLBACK';
			print_r($value);
		}
	}
	$wtd_redux_config = new wtd_redux_config();
}else
	echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
/**
 * Custom function for the callback referenced above
 */
if(!function_exists('redux_my_custom_field')):
	function redux_my_custom_field($field, $value){
		print_r($field);
		echo '<br/>';
		print_r($value);
	}
endif;
/**
 * Custom function for the callback validation referenced above
 * */
if(!function_exists('redux_validate_callback_function')):
	function redux_validate_callback_function($field, $value, $existing_value){
		$error = true;
		$value = 'just testing';
		/*
      do your validation

      if(something) {
        $value = $value;
      } elseif(something else) {
        $error = true;
        $value = $existing_value;

      }
     */
		$return['value'] = $value;
		$field['msg'] = 'your custom error message';
		if($error == true)
			{$return['error'] = $field;}
		return $return;
	}
endif;

function wtd_hidden_pages($fields, $value){
	global $wtd_syncing, $wtd_modal;
	$options = get_option('wtd_plugin');

	wp_enqueue_media();
	add_thickbox();?>
	<script>
		jQuery(document).ready(function(){
			jQuery(document).on('click', '#wtd_plugin-wtd_menu_generator .ui-corner-right', function(){
				if(jQuery(this).hasClass('ui-state-active'))
					alert('Disabling this will not prevent the "Auto add pages" Wordpress menu option');
			});
			jQuery('#client_identifier').parent().parent().remove();<?php
			if(!empty($options['business_category'])):?>
				jQuery('.resort_flag[data-place="business_categories_options"]').parent().parent().parent().css('display', 'table-row');<?php
			endif;?>
			jQuery('.wtd_reloader').click(function(event){
				event.preventDefault();
				var type = jQuery(this).attr('data-type');
				var page = jQuery(this).attr('data-page');
				jQuery('.redux-action_bar').remove();
				jQuery.ajax({
					type: "POST",
					data: {
						action: "wtd_update_single_feed",
						key: type
					},
					url: ajaxurl,
					beforeSend: function(){
						tb_show("", '#TB_inline?width=310&height=270&inlineId=wtd_modal_reload');
					},
					success: function(data){
						window.location = "<?php echo admin_url('/admin.php?page=wtd_plugin_settings');?>";
					},
					error: function(jqXHR, textStatus, errorThrown){
						window.location = "<?php echo admin_url('/admin.php?page=wtd_plugin_settings');?>";
					}
				});
			});
		});
	</script>
	<div id="wtd_change_key" style="display:none;">
		<p style="margin-top:70px;">
			Please enter your new Client Key:
		</p>
		<input type="text" id="wtd_new_key" style="float:left;width:100%;"/>
		<a href="javascript:void(0)" class="button button-primary" id="wtd_new_key_button" style="margin-top:15px;float:right;">Change Client Key</a>
	</div>
	<script>
		jQuery(document).ready(function(){
			jQuery('.wtd_key_changer').click(function(event){
				event.preventDefault();
				tb_show("", '#TB_inline?width=310&height=270&inlineId=wtd_change_key');
			});
			jQuery('#wtd_new_key_button').click(function(){
				var new_key = jQuery('#wtd_new_key').val();
				if(!new_key)
					jQuery('#wtd_new_key').focus();
				else
					window.location = "<?php echo admin_url('/admin.php?page=wtd_plugin_settings&wtd_new_client_key=');?>" + new_key;
			});
		});
	</script><?php
	$transient = get_transient('wtd_change_key_status');
	if(!empty($transient)):?>
		<div id="wtd_change_key_answer" style="display:none;">
			<p style="margin:30px 0px;"><?php
				if($transient['status']):
					if($transient['status'] == 2)
						$res_message = 'The Client Details have successfully been refreshed.';
					else
						$res_message = 'Your Client Key has successfully been changed.';?>
					<i class="el-icon-ok" style="color:forestgreen;"></i> <?php echo $res_message;
				else:?>
					<i class="el-icon-remove" style="color:red;"></i>
					<b>Error:</b> <?php echo $transient['messages'][0];
				endif;?>
			</p>
		</div>
		<script>
			jQuery(window).load(function(){
				tb_show("", '#TB_inline?width=310&height=95&inlineId=wtd_change_key_answer');
			});
		</script><?php
		delete_transient('wtd_change_key_status');
	endif;?>
	<div id="wtd_modal_reload" style="display:none;">
		<img src="<?php echo WTD_PLUGIN_URL.'/assets/img/wtd_wait.gif';?>" />
		<p>
			There is a process running in the background!<br/> You cannot change any settings right now!<br/> The page will reload as soon as the process ends
		</p>
	</div><?php
}

function wtd_activities_pages($field, $value){
	$pages = get_option('wtd_pages');
	foreach($pages['activities_pages'] as $key => $page){
		if(get_post($page))
			echo '<a href="' . get_permalink($page) . '" target="_blank" class="wtd_generated_page">' . get_the_title($page) . '</a>';
	}
	if(!count($pages['activities_pages']))
		echo '<p>The pages are generated in the background. Their links will appear here as soon as they are published!</p>';
}

function wtd_map_pages($field, $value){
	$pages = get_option('wtd_pages');
	foreach($pages['map_pages'] as $page){
		echo '<a href="' . get_permalink($page) . '" target="_blank" class="wtd_generated_page">' . get_the_title($page) . '</a>';
	}
	if(!count($pages['map_pages']))
		{echo '<p>The pages are generated in the background. Their links will appear here as soon as they are published!</p>';}
}

function wtd_map_temp($field, $value){
	global $wpdb;
	$place = "map_options";
	$not_allowed = $wpdb->get_results('SELECT term_id FROM ' . $wpdb->prefix . 'wtd_meta WHERE meta_key = "cat_id" AND wtd_term_id IN (6,903,1008) LIMIT 3');
	$exclude = array();
	foreach($not_allowed as $n){
		$exclude[] = $n->term_id;
	}
	$options = get_option('wtd_plugin');
	foreach($options['wtd_resorts'] as $resort){
		$cats = get_terms('wtd_category', array(
			'parent' => 0,
			'post_type' => array('wtd_activity'),
			'exclude' => $exclude,
			'cache_domain' => 'wtd_activities_' . $resort,
			'resorts' => array($resort)));
		echo '<div class="category_full resort_hide" data-place="' . $place . '">';
		foreach($cats as $cat){
			$cat_enable = 'selected';
			$cat_disable = '';
			if(!empty($options[$place][$resort][$cat->term_id]['parent'])){
				$cat_enable = '';
				$cat_disable = 'selected';
			}?>
			<div id="<?php echo $place . '_';?><?php echo $resort;?>_parent_term_<?php echo $cat->term_id;?>" class="wtd_cat_container">
				<fieldset class="redux-field-container redux-field redux-container-switch" data-id="category-<?php echo $cat->term_id;?>" data-type="switch">
					<div class="switch-options">
						<label class="cb-enable <?php echo $cat_enable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="1" data-resort="<?php echo $resort;?>">
							<span>Show</span>
						</label>
						<label class="cb-disable <?php echo $cat_disable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="0" data-resort="<?php echo $resort;?>">
							<span>Hide</span>
						</label>
					</div>
				</fieldset>
				<span>Show/Hide "<?php echo $cat->name;?>" Category</span>
				<hr/>
				<h4>Disable individual Subcategories</h4><?php
				$ch = get_terms('wtd_category', array(
					'parent' => $cat->term_id,
					'post_type' => array('wtd_activity'),
					'cache_domain' => 'wtd_activities_' . $resort,
					'resorts' => array($resort)));
				foreach($ch as $c){
					$icon = 'el-icon-check';
					$class = 'button-primary';
					if(!empty($options[$place][$resort][$cat->term_id]['children'][$c->term_id]) || !empty($options[$place][$resort][$cat->term_id]['parent'])){
						$icon = "el-icon-check-empty";
						$class = '';
					}
					echo '<a href="javascript:void(0);" title="' . $c->name . '" data-term="' . $c->term_id . '" data-parent="' . $cat->term_id . '" data-place="' . $place . '" data-resort="' . $resort . '" class="wtd_scat button ' . $class . '"><label class="term-count">' . $c->count . '</label><span>' . $c->name . '</span><i class="' . $icon . '"></i></a>';
				}?>
			</div><?php
		}
		echo '</div>';
	}
}

function wtd_map_options($field, $value){
	global $wpdb;
	$place = "map_options";
	$options = get_option('wtd_plugin');?>
	<fieldset class="redux-field-container redux-field redux-container-button_set" data-type="button_set">
		<span>Select resort</span>
		<section class="buttonset ui-buttonset wtd_resorts_selector"><?php
			$right = count($options['wtd_resorts']) - 1;
			foreach($options['wtd_resorts'] as $key => $resort){
				$rpost = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->terms . ' WHERE term_id = %d LIMIT 1', $resort));
				if($key == 0)
					{$bclass = 'ui-corner-left';}
				elseif($key == $right)
					{$bclass = 'ui-corner-right';}
				else
					{$bclass = '';}?>
				<label class="ui-button ui-widget ui-state-default ui-button-text-only resort_selector <?php echo $bclass;?>" data-resort="<?php echo $resort;?>" data-place="<?php echo $place;?>" role="button" aria-disabled="false">
					<span class="ui-button-text"><?php echo $rpost->name;?></span>
				</label><?php
			}?>
		</section>
		<hr/>
	</fieldset><?php
	$not_allowed = $wpdb->get_results('SELECT term_id FROM ' . $wpdb->prefix . 'wtd_meta WHERE meta_key = "cat_id" AND wtd_term_id IN (6,903,1008) LIMIT 3');
	$exclude = array();
	foreach($not_allowed as $n){
		$exclude[] = $n->term_id;
	}
	foreach($options['wtd_resorts'] as $resort){
		$cats = get_terms('wtd_category', array(
			'parent' => 0,
			'post_type' => array('wtd_activity'),
			'exclude' => $exclude,
			'cache_domain' => 'wtd_activities_' . $resort,
			'resorts' => array($resort)));
		echo '<section class="wtd_button_grid resort_hide" id="' . $place . '_' . $resort . '_firsst" data-place="' . $place . '">';
		foreach($cats as $key => $category){
			$icon = 'el-icon-check';
			if(!empty($options[$place][$resort][$category->term_id]['parent']))
				{$icon = 'el-icon-check-empty';}
			echo '<a href="javascript:void(0);" class="button wtd_cat" data-place="' . $place . '" data-resort="' . $resort . '" data-term="' . $category->term_id . '"><label class="term-count">' . $category->count . '</label><span>' . $category->name . '</span><i class="' . $icon . '"></i></a>';
		}
		echo '</section>';
		echo '<section id="' . $place . '_inputs">';
		if(!empty($value)){
			foreach($options[$place][$resort] as $term_id => $val){
				if(!empty($val['parent']))
					{echo '<input type="hidden" id="' . $place . '_' . $resort . '_term_' . $term_id . '" name="wtd_plugin[' . $place . '][' . $resort . '][' . $term_id . '][parent]" value="1"/>';}
				foreach($val['children'] as $child_id => $child){
					echo '<input type="hidden" id="' . $place . '_' . $resort . '_term_' . $child_id . '" name="wtd_plugin[' . $place . '][' . $resort . '][' . $term_id . '][children][' . $child_id . ']" value="1"/>';
				}
			}
		}
		echo '</section>';
	}
}

function wtd_dining_pages($field, $value){
	$pages = get_option('wtd_pages');
	foreach($pages['dining_pages'] as $page){
		echo '<a href="'.get_permalink($page).'" target="_blank" class="wtd_generated_page">'.get_the_title($page).'</a>';
	}
	if(!count($pages['dining_pages']))
		echo '<p>The pages are generated in the background. Their links will appear here as soon as they are published!</p>';
}

function wtd_dining_resorts($fields, $value){
	global $wpdb;
	$place = 'dining_options';?>
	<fieldset class="redux-field-container redux-field redux-container-button_set" data-type="button_set">
		<section class="buttonset ui-buttonset wtd_resorts_selector"><?php
			$options = get_option('wtd_plugin');
			$right = count($options['wtd_resorts']) - 1;
			foreach($options['wtd_resorts'] as $key => $resort){
				$rpost = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->terms . ' WHERE term_id = %d LIMIT 1', $resort));
				if($key == 0)
					{$bclass = 'ui-corner-left';}
				elseif($key == $right)
					{$bclass = 'ui-corner-right';}
				else
					{$bclass = '';}?>
				<label class="ui-button ui-widget ui-state-default ui-button-text-only resort_selector <?php echo $bclass;?>" data-resort="<?php echo $resort;?>" data-place="<?php echo $place;?>" role="button" aria-disabled="false">
					<span class="ui-button-text"><?php echo $rpost->name;?></span>
				</label><?php
			}?>
		</section>
	</fieldset><?php
}

function wtd_calendar_pages($field, $value){
	$pages = get_option('wtd_pages');
	foreach($pages['calendar_pages'] as $page){
		echo '<a href="' . get_permalink($page) . '" target="_blank" class="wtd_generated_page">' . get_the_title($page) . '</a>';
	}
	if(!count($pages['calendar_pages']))
		echo '<p>The pages are generated in the background. Their links will appear here as soon as they are published!</p>';
}

function wtd_calendar_temp($field, $value){
	global $wpdb, $wtd_redux_config;
	$place = "calendar_options";
	$options = get_option('wtd_plugin');

	$cats = $wtd_redux_config->mapped_categories['events'];
	foreach($options['wtd_resorts'] as $resort){
		echo '<div class="category_full resort_hide" data-place="' . $place . '">';
		foreach($cats as $pcat){
			$cat = $pcat['parent'];
			$cat_enable = 'selected';
			$cat_disable = '';
			if(!empty($options[$place][$resort][$cat->term_id]['parent'])){
				$cat_enable = '';
				$cat_disable = 'selected';
			}?>
			<div id="<?php echo $place . '_';?><?php echo $resort;?>_parent_term_<?php echo $cat->term_id;?>" class="wtd_cat_container">
				<fieldset class="redux-field-container redux-field redux-container-switch" data-id="category-<?php echo $cat->term_id;?>" data-type="switch">
					<div class="switch-options">
						<label class="cb-enable <?php echo $cat_enable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="1" data-resort="<?php echo $resort;?>">
							<span>Show</span>
						</label>
						<label class="cb-disable <?php echo $cat_disable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="0" data-resort="<?php echo $resort;?>">
							<span>Hide</span>
						</label>
					</div>
				</fieldset>
				<span>Show/Hide "<?php echo $cat->name;?>" Category</span>
				<hr/>
				<h4>Disable individual Subcategories</h4><?php
				$ch = $pcat['children'];
				foreach($ch as $c){
					$icon = 'el-icon-check';
					$class = 'button-primary';
					if(!empty($options[$place][$resort][$cat->term_id]['children'][$c->term_id]) || !empty($options[$place][$resort][$cat->term_id]['parent'])){
						$icon = "el-icon-check-empty";
						$class = '';
					}
					echo '<a href="javascript:void(0);" title="' . $c->name . '" data-term="' . $c->term_id . '" data-parent="' . $cat->term_id . '" data-place="' . $place . '" data-resort="' . $resort . '" class="wtd_scat button ' . $class . '"><label class="term-count">' . $c->count . '</label><span>' . $c->name . '</span><i class="' . $icon . '"></i></a>';
				}?>
			</div><?php
		}
		echo '</div>';
	}
}

function wtd_week_pages($field, $value){
	$pages = get_option('wtd_pages');
	foreach($pages['week_pages'] as $page){
		echo '<a href="' . get_permalink($page) . '" target="_blank" class="wtd_generated_page">' . get_the_title($page) . '</a>';
	}
	if(!count($pages['week_pages']))
		{echo '<p>The pages are generated in the background. Their links will appear here as soon as they are published!</p>';}
}

function wtd_week_temp($field, $value){
	global $wpdb, $wtd_redux_config;
	$place = "week_options";
	$options = get_option('wtd_plugin');

	$cats = $wtd_redux_config->mapped_categories['events'];
	foreach($options['wtd_resorts'] as $resort){
		echo '<div class="category_full resort_hide" data-place="' . $place . '">';
		foreach($cats as $pcat){
			$cat = $pcat['parent'];
			$cat_enable = 'selected';
			$cat_disable = '';
			if(!empty($options[$place][$resort][$cat->term_id]['parent'])){
				$cat_enable = '';
				$cat_disable = 'selected';
			}?>
			<div id="<?php echo $place . '_';?><?php echo $resort;?>_parent_term_<?php echo $cat->term_id;?>" class="wtd_cat_container">
				<fieldset class="redux-field-container redux-field redux-container-switch" data-id="category-<?php echo $cat->term_id;?>" data-type="switch">
					<div class="switch-options">
						<label class="cb-enable <?php echo $cat_enable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="1" data-resort="<?php echo $resort;?>">
							<span>Show</span>
						</label>
						<label class="cb-disable <?php echo $cat_disable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="0" data-resort="<?php echo $resort;?>">
							<span>Hide</span>
						</label>
					</div>
				</fieldset>
				<span>Show/Hide "<?php echo $cat->name;?>" Category</span>
				<hr/>
				<h4>Disable individual Subcategories</h4><?php
				$ch = $pcat['children'];
				foreach($ch as $c){
					$icon = 'el-icon-check';
					$class = 'button-primary';
					if(!empty($options[$place][$resort][$cat->term_id]['children'][$c->term_id]) || !empty($options[$place][$resort][$cat->term_id]['parent'])){
						$icon = "el-icon-check-empty";
						$class = '';
					}
					echo '<a href="javascript:void(0);" title="' . $c->name . '" data-term="' . $c->term_id . '" data-parent="' . $cat->term_id . '" data-place="' . $place . '" data-resort="' . $resort . '" class="wtd_scat button ' . $class . '"><label class="term-count">' . $c->count . '</label><span>' . $c->name . '</span><i class="' . $icon . '"></i></a>';
				}?>
			</div><?php
		}
		echo '</div>';
	}
}

function wtd_specials_pages($field, $value){
	$pages = get_option('wtd_pages');
	foreach($pages['specials_pages'] as $page){
		echo '<a href="' . get_permalink($page) . '" target="_blank" class="wtd_generated_page">' . get_the_title($page) . '</a>';
	}
}

function wtd_specials_temp($field, $value){
	global $wpdb, $wtd_redux_config;
	$place = "specials_options";
	$options = get_option('wtd_plugin');

	$cats = $wtd_redux_config->mapped_categories['specials'];
	foreach($options['wtd_resorts'] as $resort){
		echo '<div class="category_full resort_hide" data-place="' . $place . '">';
		foreach($cats as $pcat){
			$cat = $pcat['parent'];
			$cat_enable = 'selected';
			$cat_disable = '';
			if(!empty($options[$place][$resort][$cat->term_id]['parent'])){
				$cat_enable = '';
				$cat_disable = 'selected';
			}?>
			<div id="<?php echo $place . '_';?><?php echo $resort;?>_parent_term_<?php echo $cat->term_id;?>" class="wtd_cat_container">
				<fieldset class="redux-field-container redux-field redux-container-switch" data-id="category-<?php echo $cat->term_id;?>" data-type="switch">
					<div class="switch-options">
						<label class="cb-enable <?php echo $cat_enable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="1" data-resort="<?php echo $resort;?>">
							<span>Show</span>
						</label>
						<label class="cb-disable <?php echo $cat_disable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="0" data-resort="<?php echo $resort;?>">
							<span>Hide</span>
						</label>
					</div>
				</fieldset>
				<span>Show/Hide "<?php echo $cat->name;?>" Category</span>
				<hr/>
				<h4>Disable individual Subcategories</h4><?php
				$ch = $pcat['children'];
				foreach($ch as $c){
					$icon = 'el-icon-check';
					$class = 'button-primary';
					if(!empty($options[$place][$resort][$cat->term_id]['children'][$c->term_id]) || !empty($options[$place][$resort][$cat->term_id]['parent'])){
						$icon = "el-icon-check-empty";
						$class = '';
					}
					echo '<a href="javascript:void(0);" title="' . $c->name . '" data-term="' . $c->term_id . '" data-parent="' . $cat->term_id . '" data-place="' . $place . '" data-resort="' . $resort . '" class="wtd_scat button ' . $class . '"><label class="term-count">' . $c->count . '</label><span>' . $c->name . '</span><i class="' . $icon . '"></i></a>';
				}?>
			</div><?php
		}
		echo '</div>';
	}
}

function wtd_coupons_pages($field, $value){
	$pages = get_option('wtd_pages');
	foreach($pages['coupons_pages'] as $page){
		echo '<a href="' . get_permalink($page) . '" target="_blank" class="wtd_generated_page">' . get_the_title($page) . '</a>';
	}
	if(!count($pages['coupons_pages']))
		{echo '<p>The pages are generated in the background. Their links will appear here as soon as they are published!</p>';}
}

function wtd_coupons_temp($field, $value){
	global $wpdb, $wtd_redux_config;
	$place = "coupons_options";
	$options = get_option('wtd_plugin');

	$cats = $wtd_redux_config->mapped_categories['coupons'];
	foreach($options['wtd_resorts'] as $resort){
		echo '<div class="category_full resort_hide" data-place="' . $place . '">';
		foreach($cats as $pcat){
			$cat = $pcat['parent'];
			$cat_enable = 'selected';
			$cat_disable = '';
			if(!empty($options[$place][$resort][$cat->term_id]['parent'])){
				$cat_enable = '';
				$cat_disable = 'selected';
			}?>
			<div id="<?php echo $place . '_';?><?php echo $resort;?>_parent_term_<?php echo $cat->term_id;?>" class="wtd_cat_container">
				<fieldset class="redux-field-container redux-field redux-container-switch" data-id="category-<?php echo $cat->term_id;?>" data-type="switch">
					<div class="switch-options">
						<label class="cb-enable <?php echo $cat_enable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="1" data-resort="<?php echo $resort;?>">
							<span>Show</span>
						</label>
						<label class="cb-disable <?php echo $cat_disable;?>" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="0" data-resort="<?php echo $resort;?>">
							<span>Hide</span>
						</label>
					</div>
				</fieldset>
				<span>Show/Hide "<?php echo $cat->name;?>" Category</span>
				<hr/>
				<h4>Disable individual Subcategories</h4><?php
				$ch = $pcat['children'];
				foreach($ch as $c){
					$icon = 'el-icon-check';
					$class = 'button-primary';
					if(!empty($options[$place][$resort][$cat->term_id]['children'][$c->term_id]) || !empty($options[$place][$resort][$cat->term_id]['parent'])){
						$icon = "el-icon-check-empty";
						$class = '';
					}
					echo '<a href="javascript:void(0);" title="' . $c->name . '" data-term="' . $c->term_id . '" data-parent="' . $cat->term_id . '" data-place="' . $place . '" data-resort="' . $resort . '" class="wtd_scat button ' . $class . '"><label class="term-count">' . $c->count . '</label><span>' . $c->name . '</span><i class="' . $icon . '"></i></a>';
				}?>
			</div><?php
		}
		echo '</div>';
	}
}

function wtd_user_map($field, $value){?>
	<a href="javascript:void(0);" id="address_coder" class="button button-primary" style="margin-top:15px">Place Address on the map</a>
	<p>You can always change the marker position by dragging it into the right place.</p>
	<input type="hidden" name="wtd_plugin[user_map][lat]" id="map_user_lat" class="compiler" value="<?php echo $value['lat']; ?>"/>
	<input type="hidden" name="wtd_plugin[user_map][lng]" id="map_user_lng" class="compiler" value="<?php echo $value['lng']; ?>"/>
	<section id="map_canvas_user" class="wtd_map_place"></section>
	<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	<script>
		var map_user_lat = '<?php echo $value['lat'];?>';
		var map_user_lng = '<?php echo $value['lng'];?>';
		var map_user_loaded = false;
		var user_marker;
		var user_map;
		var geocoder = new google.maps.Geocoder();
		function getLocation(){
			if(navigator.geolocation)
				navigator.geolocation.getCurrentPosition(showPosition);
			else
				alert("Geolocation is not supported by this browser.");
		}
		function showPosition(position){
			jQuery('#map_user_lat').val(position.coords.latitude);
			jQuery('#map_user_lng').val(position.coords.longitude);
			var location = new google.maps.LatLng(position.coords.latitude, position.coords.longitude, 4);
			user_map.setZoom(17);
			user_map.setCenter(location);
			user_marker.setPosition(location);
		}
		function user_map_init(){
			var map_canvas = document.getElementById('map_canvas_user');
			var map_options = {
				navigationControl: true,
				mapTypeControl: true,
				scaleControl: true,
				center: new google.maps.LatLng(map_user_lat, map_user_lng, 4),
				zoom: <?php echo ($value['lng'] == '-95.677068') ? 3 : 11; ?>
			}
			user_map = new google.maps.Map(map_canvas, map_options);
			var location = new google.maps.LatLng(map_user_lat, map_user_lat);
			var animation = google.maps.Animation.DROP;
			user_marker = new google.maps.Marker({
				draggable: true,
				map: user_map,
				animation: animation,
				position: new google.maps.LatLng(map_user_lat, map_user_lng, 4),
				optimized: false
			});
			google.maps.event.addListener(user_marker, 'dragend', function(event){
				jQuery('#map_user_lat').val(this.getPosition().lat());
				jQuery('#map_user_lng').val(this.getPosition().lng());
				redux_change(jQuery('#map_user_lat'));
			});
			google.maps.event.addListenerOnce(user_map, 'idle', function(){
				map_user_loaded = true;
			});
		}
		jQuery(document).ready(function(){
			if(!map_user_loaded)
				user_map_init();
			jQuery('#geofinder_coder').click(function(event){
				event.preventDefault();
				getLocation();
			});
			jQuery('#address_coder').click(function(event){
				event.preventDefault();
				var address = '';
				if(jQuery('#address-text').val())
					address = address + jQuery('#address-text').val();
				if(jQuery('#city-text').val())
					address = address + ',' + jQuery('#city-text').val();
				if(jQuery('#state-text').val())
					address = address + ',' + jQuery('#state-text').val();
				if(jQuery('#zip-text').val())
					address = address + ' ' + jQuery('#zip-text').val();
				jQuery.ajax({
					url: ajaxurl,
					data: {
						address: address,
						action: 'wtd_geocode_address'
					},
					type: 'post',
					dataType: 'json',
					success: function(data){
						if(data.lng && data.lat){
							var latlng = new google.maps.LatLng(data.lat, data.lng, 4)
							user_map.setCenter(latlng);
							user_map.setZoom(17);
							user_marker.setPosition(latlng);
							jQuery('#map_user_lat').val(data.lat);
							jQuery('#map_user_lng').val(data.lng);
							redux_change(jQuery('#map_user_lat'));
						}else
							alert('We could not place the address on the map! Please drag the marker to the right position');
					}
				});
			});
		});
	</script><?php
}

function wtd_bus_options($field, $value){
	$place = 'business_categories_options';
	$parent_filters = get_option('wtd_excluded_parent_cats');
	if(!empty($parent_filters))
		$enabled_parent_cat_filters = json_decode($parent_filters);
	$excluded_cats = get_option('wtd_excluded_cats');?>
	<div ng-controller="categoryExclusion"><?php
		$query = new ParseQuery('wp_site');
		$query->equalTo('token', get_option('wtd_api_token'));
		$site_results = $query->find();
		$site = $site_results[0];
		$relation = $site->getRelation('resortRelation', 'resort');
		$resorts = $relation->getQuery()->find();
		$query = new ParseQuery('resortParentCategories');
		$query->equalTo('deleted', false);
		$query->containedIn('resortObjectId', $resorts);
		$query->includeKey('resortObjectId');
		$results = $query->find();?>
		<script type="text/javascript"><?php
			if(empty($enabled_parent_cat_filters)){?>
				var enabled_parent_filters = null;
				var excluded_cats = null;<?php
			}else{?>
				var enabled_parent_filters = JSON.parse('<?php echo (empty($parent_filters)) ? '{"result":true}' : $parent_filters;?>');<?php
				if(empty($excluded_cats)){?>
					var excluded_cats = null;<?php
				}else{?>
					var excluded_cats = JSON.parse('<?php echo $excluded_cats;?>');<?php
				}
			}?>

			jQuery(document).ready(function(){
				if(enabled_parent_filters!= null && enabled_parent_filters!= undefined ){
					for(var i = 0; i < enabled_parent_filters.length; i++){
						var parent_id = enabled_parent_filters[i];
						Parse.Cloud.run('get_subcategory_list_v2', {
							parent_id: parent_id,
							token: token
						}, {
							success: function(result){
								showSubcategoryList(parent_id, result);
							},
							error: function(error){
								console.log(error);
							}
						});
					}
				}
			});
		</script>
		<div data-place="<?php echo $place;?>"><?php
			for($i = 0; $i < count($results); $i++){
				$cat = $results[$i];
				$cat_id = $cat->getObjectId();
				$cat_enable = '';
				$cat_disable = 'selected';
				if(!empty($enabled_parent_cat_filters)){
					if(in_array($cat->getObjectId(), $enabled_parent_cat_filters)){
						$cat_enable = 'selected';
						$cat_disable = '';
					}
				}?>
				<div id="<?php echo $place;?>_parent_<?php echo $cat_id;?>">
					<fieldset class="redux-field-container redux-field redux-container-switch" data-id="category-<?php echo $cat->getObjectId();?>" data-type="switch">
						<div class="switch-options">
							<label id="<?php echo $cat_id;?>_filter_enabled" class="cb-enable <?php echo $cat_enable;?>" ng-click="getSubcategories('<?php echo $cat->getObjectId();?>');" data-val="1">
								<span>Enable</span>
							</label>
							<label id="<?php echo $cat_id;?>_filter_disabled" class="cb-disable <?php echo $cat_disable;?>" onclick="disableParentCategoryFilter('<?php echo $cat->getObjectId();?>', this);" data-place="<?php echo $place;?>" data-term="<?php $cat_id;?>" data-val="0">
								<span>Disable</span>
							</label>
						</div>
					</fieldset>
					<span style="font-weight:bold;"><em><?php echo $cat->resortObjectId->name.' - '.$cat->get('name');?></em> Category Filter</span>
					<div id="<?php echo $cat->getObjectId();?>_children" layout="row" layout-wrap><?php
						if(!empty($enabled_parent_cat_filters)){
							if(in_array($cat->getObjectId(), $enabled_parent_cat_filters)){
								try{
									$subcategories = ParseCloud::run("get_subcategory_list_v2", ['parent_id' => $cat_id, 'token' => get_option('wtd_api_token')]);
								}catch(ParseException $ex){
									var_dump($cat_id);
									var_dump($ex);
								}
								$subcategories = json_decode($subcategories);
								for($j = 0; $j < count($subcategories); $j++){
									$sub_cat = $subcategories[$j];
									$selected = '';
									if(!empty($excluded_cats)){
										if(in_array($sub_cat->objectId, json_decode($excluded_cats)))
											$selected = ' checked ';
									}
									echo '<div flex="33"><input type="checkbox" name="excluded_cats[]" id="excluded_cats[]" onchange="saveExcludedCats();" value="'.$sub_cat->objectId.'" '.$selected.' />'.$sub_cat->name.'</div>';
								}
							}
						}?>
					</div>
					<hr/>
				</div><?php
			}?>
		</div>
	</div><?php
}

//function wtd_setup_page($field, $value){
//	$query = new ParseQuery('resort');
//	try{
//		$query->equalTo('state', 'CO');
//
//		$site_results = $query->find();
//	}catch(ParseException $ex){
//		var_dump($ex);
//	}
//
//	var_dump($site_results);
//}

function wtd_setup_page($field, $value){
	wp_enqueue_media();
	add_thickbox();?>
	<script src="<?php echo WTD_PLUGIN_URL;?>assets/js/external/jquery.validate.min.js"></script>
	<div id="info-import_feed" class="redux-normal  redux-info-field redux-field-info wtd_setup_box">
		<i class="el-icon-adult icon-large"></i>
		<h2>Enter your api key</h2>
		<p>
			<input type="text" id="wtd_api_key-text" placeholder="Enter your Client Key"/>
			<a href="javascript:void(0);" id="wtd_connector" class="wtd_button">
				<i class="el-icon-ok"></i>
				CONNECT
			</a>
			<a href="javascript:void(0);" id="wtd_pass_forgotten" class="wtd_button">
				<i class="el-icon-key"></i>
				Forgot key?
			</a>
			<ul class="wtd_error_ul" id="wtd_api_errors"></ul>
		</p>
	</div>
	<div id="wtd_lost_key" style="display:none;">
		<div id="wtd_waiting_for_response" style="display:none;">
			<img src="<?php echo WTD_PLUGIN_URL;?>assets/img/wtd_wait.gif" style="margin-top:65px;"/>
		</div>
		<div id="wtd_ask_for_mail">
			<ul id="wtd_lost_api_answer"></ul>
			<p style="margin-top:70px;">
				Please enter your e-mail address:
			</p>
			<input type="text" id="lost_key_email" style="float:left;width:100%;" placeholder="e.g. mail@domain.com"/>
			<a href="javascript:void(0)" class="button button-primary" id="wtd_send_lost" style="margin-top:15px;float:right;">Send Key</a>
		</div>
	</div>
	<style>
		.redux-main{
			margin-left: 0px !important;
		}
		.redux-sidebar, .wtd_setup_page h3, .redux-container .redux-action_bar input, #wtd_new_email-error, .expand_options{
			display: none !important;
		}
	</style>
	<script>
		jQuery('.wtd_setup_page th').remove();
		jQuery('.redux-container #info_bar').hide();
		jQuery('#wtd_connector').click(function(event){
			event.preventDefault();
			var api_key = jQuery('#wtd_api_key-text').val();
			if(!api_key)
				jQuery('#wtd_api_key-text').focus();
			else
				window.location = "<?php echo admin_url('admin.php?page=wtd_plugin_settings&connect_wtd_api=1');?>&api_key="+api_key;
		});
		jQuery('#wtd_pass_forgotten').click(function(){
			tb_show("", '#TB_inline?width=307&height=260&inlineId=wtd_lost_key');
		});
		jQuery(document).on('click', '#wtd_send_lost', function(event){
			event.preventDefault();
			var mail = jQuery('#lost_key_email').val();
			if(!mail)
				jQuery('#lost_key_email').focus();
			else{
				jQuery.ajax({
					type: 'post',
					dataType: 'json',
					data: {
						action: 'wtd_lost_key',
						email: mail
					},
					url: "<?php echo admin_url('/admin-ajax.php');?>",
					beforeSend: function(){
						jQuery('#wtd_ask_for_mail').hide();
						jQuery('#wtd_waiting_for_response').show();
					},
					success: function(data){
						jQuery('#wtd_ask_for_mail').show();
						jQuery('#wtd_waiting_for_response').hide();
						console.log(data);
					}
				});
			}
		});
	</script><?php
}

function wtd_client_details($field, $value){
	global $wpdb;
	$client_details = get_option('wtd_client_details');?>
	<table class="form-table" id="client_table">
		<tr>
			<th>
				Company
			</th>
			<td><?php
				echo $client_details['company'];?>
			</td>
		</tr>
		<tr>
			<th>
				Client Key
			</th>
			<td><?php
				echo $client_details['api_key'];?>
			</td>
		</tr>
		<tr>
			<th>
				Paid Resorts
			</th>
			<td><?php
				$query = new ParseQuery('wp_site');
				$query->equalTo('token', get_option('wtd_api_token'));
				$results = $query->find();
				for($i = 0; $i < count($results); $i++){
					$site = $results[$i];
					echo $site->get('name');
				}?>
			</td>
		</tr>
	</table><?php
}

function wtd_full_menu($field, $value){
	ob_start();?>
	<link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL . 'assets/css/wtd_activities_page.css'; ?>" media="screen"/>
	<style>
		.typography-preview{
			display: none !Important;
		}
		.iris-picker{
			z-index: 999 !important;
		}
	</style>
	<div id="wtd-navigator">
		<div class="wtd_parent_menu">
            <span class="wtd_parent_menu_item active">
                <a href="javascript:void(0);">Item 1</a>
            </span>
            <span class="wtd_parent_menu_item">
                <a href="javascript:void(0);">Item 2</a>
            </span>
            <span class="wtd_parent_menu_item">
                <a href="javascript:void(0);">Item 3</a>
            </span>
            <span class="wtd_parent_menu_item">
                <a href="javascript:void(0);">Item 4</a>
            </span>
            <span class="wtd_parent_menu_item">
                <a href="javascript:void(0);">Item 5</a>
            </span>
            <span class="wtd_parent_menu_item">
                <a href="javascript:void(0);">Item 6</a>
            </span>
            <span class="wtd_parent_menu_item">
                <a href="javascript:void(0);">Item 7</a>
            </span>
		</div>
		<div class="wtd_contents">
			<div class="wtd_menu" style="display:block;">
                <span class="wtd_menu_item">
                    <a href="javascript:void(0);" class="active">Subitem 1</a>
                </span>
                <span class="wtd_menu_item">
                    <a href="javascript:void(0);">Subitem 2</a>
                </span>
                <span class="wtd_menu_item">
                    <a href="javascript:void(0);">Subitem 3</a>
                </span>
                <span class="wtd_menu_item">
                    <a href="javascript:void(0);">Subitem 4</a>
                </span>
                <span class="wtd_menu_item">
                    <a href="javascript:void(0);">Subitem 5</a>
                </span>
                <span class="wtd_menu_item">
                    <a href="javascript:void(0);">Subitem 6</a>
                </span>
                <span class="wtd_menu_item">
                    <a href="javascript:void(0);">Subitem 7</a>
                </span>
			</div>
		</div>
	</div><?php
	$html = ob_get_clean();?>
	<script>
		var wtd_big_menu = '<?php echo str_replace("\n",'',trim($html));?>';
		var wtd_parent_inactive_color = '';
		jQuery('.wtd_typograpy_panel.big_menu h3').after(wtd_big_menu);
		jQuery('#wtd_plugin-fm_parent_menu').before('<h3 style="margin:0px !important;">Parent Menu</h4>');
		jQuery('#wtd_plugin-fm_parent_menu_active').before('<h5 style="margin-bottom:0px !important;">Active Item</h5>');
		jQuery('#wtd_plugin-fm_parent_menu_active .picker-wrapper label').html('Background Color');
		jQuery('#wtd_plugin-fm_child_menu_background').before('<h3 style="margin-bottom:0px !important;margin-top:30px;">Child Menu</h4>');
		jQuery('#wtd_plugin-fm_child_menu_active').before('<h5 style="margin-bottom:0px !important;">Active Item</h5>');
		jQuery('#wtd_plugin-fm_child_menu_active .picker-wrapper label').html('Background Color');
		jQuery('#wtd_plugin-fm_child_menu_background .picker-wrapper label').html('Child Menu Background Color');
		function wtd_typo_change(mainID, family, size, transform, fontVariant, decoration, style, color, units){
			switch(mainID){
				case 'fm_parent_menu':
					wtd_parent_inactive_color = color;
					jQuery('#wtd-navigator .wtd_parent_menu span a').css({
						'font-size': size + units,
						'font-weight': style,
						'text-decoration': decoration,
						'color': color
					});
					jQuery('#wtd-navigator .wtd_parent_menu span.active a').css({'color': '#fff'});
					jQuery('#wtd-navigator .wtd_parent_menu span:not(.active)').hover(function(){
						jQuery(this).find('a').css({'color': '#fff'});
					}, function(){
						jQuery(this).find('a').css({'color': color});
					});
					break;
				case 'fm_parent_menu_active':
					jQuery('#wtd-navigator .wtd_parent_menu span.active').css({
						'background-color': color
					});
					jQuery('#wtd-navigator .wtd_parent_menu span:not(.active)').hover(function(){
						jQuery(this).css({'background': color});
					}, function(){
						jQuery(this).css({'background': 'none'});
					});
					jQuery('#wtd-navigator .wtd_parent_menu span.active a').css({
						'font-size': size + units,
						'font-weight': style
					});
					break;
				case 'fm_child_menu':
					wtd_parent_inactive_color = color;
					jQuery('#wtd-navigator .wtd_menu .wtd_menu_item a').css({
						'font-size': size + units,
						'font-weight': style,
						'text-decoration': decoration,
						'color': color
					});
					jQuery('#wtd-navigator .wtd_menu .wtd_menu_item a.active').css({'color': '#fff'});
					jQuery('#wtd-navigator .wtd_menu .wtd_menu_item a:not(.active)').hover(function(){
						jQuery(this).css({'color': '#fff'});
					}, function(){
						jQuery(this).css({'color': color});
					});
					break;
				case 'fm_child_menu_active':
					jQuery('#wtd-navigator .wtd_menu .wtd_menu_item a.active').css({
						'background-color': color
					});
					jQuery('#wtd-navigator .wtd_menu .wtd_menu_item a:not(.active)').hover(function(){
						jQuery(this).css({'background': color});
					}, function(){
						jQuery(this).css({'background': 'none'});
					});
					jQuery('#wtd-navigator .wtd_menu .wtd_menu_item a.active').css({
						'font-size': size + units,
						'font-weight': style
					});
					break;
				case 'fm_child_menu_background':
					jQuery('#wtd-navigator .wtd_menu').css({
						'background-color': color
					});
					break;
			}
		}
		function wtd_color_changed(u, id){
			setTimeout(function(){
				var color = jQuery('#' + id + '-color').val();
			}, 200);
		}
		var big_menu_design_id = jQuery('.big_menu').attr('id');
	</script><?php
}

function create_wtd_pages($key, $options, $wtd_pages){
	// get the type from the key
	$key_parts = explode('-', $key);
	$type = $key_parts[0];
	if(!empty($options['wtd_resorts'])){
		foreach($options['wtd_resorts'] as $res_id){
			$args = array(
				'post_type' => 'page',
				'orderby' => 'ID',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'wtd_page',
						'value' => $type.'_page'),
					array(
						'key' => 'res_id',
						'value' => $res_id)));
			$page_query = new WP_Query($args);
			if(!$page_query->found_posts){
				$query = new ParseQuery("resort");
				try{
				  $resort = $query->get($res_id);
				  // The object was retrieved successfully.
				}catch(ParseException $ex) {
				  // The object was not retrieved successfully.
				  // error is a ParseException with an error code and message.
				}

				$resort_name = $resort->get('name');
				$rname = explode(',', $resort_name);
				switch($type){
					case 'weekspecials':
						$new_page_name = "Weekly Specials";
						break;
					case 'week':
						$new_page_name = 'This Week';
						break;
					default:
						$new_page_name = $type;
						break;
				}
				$new_page = array(
					'post_title' => $rname[0] .' '.ucfirst($new_page_name),
					'post_content' => '',
					'post_type' => 'page',
					'post_status' => 'publish');
				$page_id = wp_insert_post($new_page);
				update_post_meta($page_id, 'wtd_page', $type.'_page');
				update_post_meta($page_id, 'res_id', $res_id);
				$wtd_pages[$type.'_pages'][$res_id] = $page_id;
			}
		}
	}
	return $wtd_pages;
}

function create_wtd_post($type){
	$args = array(
		'post_type' => 'wtd_'.$type,
		'orderby' => 'ID',
		'order' => 'ASC');
	$post_query = new WP_Query($args);
	if(!$post_query->found_posts){
		$new_post = array(
			'post_title' => 'WhatToDo '.ucfirst($type),
			'post_content' => '',
			'post_name' => 'wtd-'.$type,
			'post_type' => 'wtd_'.$type,
			'post_status' => 'publish');
		wp_insert_post($new_post);
	}
}

function delete_wtd_post($type){
	global $post;
	$args = array(
		'post_type' => 'wtd_'.$type,
		'orderby' => 'ID',
		'order' => 'ASC');
	$post_query = new WP_Query($args);
	while($post_query->have_posts()){
		$post_query->the_post();
		wp_delete_post($post->ID, true);
	}
}

function delete_wtd_pages($key, $options, $wtd_pages){
	// get the type from the key
	$key_parts = explode('-', $key);
	$type = $key_parts[0];
	foreach($options['wtd_resorts'] as $res_id){
		$post_id = $wtd_pages[$type.'_pages'][$res_id];
		// 2nd parameter is force delete and bypasses the trash can if true
		wp_delete_post($post_id, true);
	}
	unset($wtd_pages[$type.'_pages']);
	return $wtd_pages;
}

function toggle_wtd_resort($page_types){
	global $wtd_plugin;
	$wtd_pages = get_option('wtd_pages');
	$resorts = array();
	foreach($wtd_plugin['wtd_resorts'] as $key => $resort_id){
		$resorts[] = $resort_id;
		foreach($page_types as $type){
			$args = array(
				'post_type' => 'page',
				'orderby' => 'ID',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'wtd_page',
						'value' => $type.'_page'),
					array(
						'key' => 'res_id',
						'value' => $resort_id)));
			$page_query = new WP_Query($args);
			if(!$page_query->found_posts){
				$query = new ParseQuery("resort");
				try{
				  $resort = $query->get($resort_id);
				  // The object was retrieved successfully.
				}catch(ParseException $ex) {
				  // The object was not retrieved successfully.
				  // error is a ParseException with an error code and message.
				}

				$resort_name = $resort->get('name');
				$rname = explode(',', $resort_name);
				$new_page = array(
					'post_title' => $rname[0] .' '.ucfirst($type),
					'post_content' => '',
					'post_type' => 'page',
					'post_status' => 'publish');
				$page_id = wp_insert_post($new_page);
				update_post_meta($page_id, 'wtd_page', $type.'_page');
				update_post_meta($page_id, 'res_id', $resort_id);
				$wtd_pages[$type.'_pages'][$resort_id] = $page_id;
			}
		}
		// todo remove any pages that are associated with a resort that has been turned off
		foreach($wtd_pages as $resort_page){
			foreach($resort_page as $resort_id => $post_id){
				if(!in_array($resort_id, $resorts)){
					// 2nd parameter is force delete and bypasses the trash can if true
					wp_delete_post($post_id, true);
					unset($wtd_pages[$resort_page][$resort_id]);
				}
			}
		}
	}
	update_option('wtd_pages', $wtd_pages);
}
/*
 * Called when the redux framework options are saved via the compiler
 * This function will create or delete the necessary pages for the plugin
 */
function wtd_page_check($key, $value){
	global $post;
	$options = get_option('wtd_plugin');
	$wtd_pages = get_option('wtd_pages');

	switch($key){
		case 'activities-page':
			if(!empty($options[$key])){
				if(!empty($options['wtd_resorts'])){
					foreach($options['wtd_resorts'] as $res_id){
						$options['activities_options']['page_style'][$res_id] = 1;
						$options['activities_options']['dropdown'][$res_id] = 0;
						$options['activities_options']['mosaic'][$res_id] = 1;
					}
					$wtd_pages = create_wtd_pages($key, $options, $wtd_pages);
					create_wtd_post('activity');
				}
			}else{
				$wtd_pages = delete_wtd_pages($key, $options, $wtd_pages);
				delete_wtd_post('activity');
				unset($options['activities_options']);
			}
			break;
		case 'dining-page':
			if(!empty($options[$key])){
				$wtd_pages = create_wtd_pages($key, $options, $wtd_pages);
				create_wtd_post('dining');
			}else{
				$wtd_pages = delete_wtd_pages($key, $options, $wtd_pages);
				delete_wtd_pages('dining');
			}
			break;
		case 'calendar-page':
		case 'week-page':
			if(!empty($options[$key])){
				$wtd_pages = create_wtd_pages($key, $options, $wtd_pages);
				create_wtd_post('event');
			}else{
				// todo add check to see if we can delete the event post here
				$wtd_pages = delete_wtd_pages($key, $options, $wtd_pages);
			}
			break;
		case 'coupons-page':
			if(!empty($options[$key])){
				$wtd_pages = create_wtd_pages($key, $options, $wtd_pages);
				create_wtd_post('coupon');
			}else{
				$wtd_pages = delete_wtd_pages($key, $options, $wtd_pages);
				delete_wtd_post('coupon');
			}
			break;
		case 'weekspecials-page':
		case 'specials-page':
			if(!empty($options[$key])){
				$wtd_pages = create_wtd_pages($key, $options, $wtd_pages);
				create_wtd_post('special');
			}else{
				// todo add check to see if we can delete the special post here
				$wtd_pages = delete_wtd_pages($key, $options, $wtd_pages);
			}
			break;
		case 'overview-page':
			if(!empty($options[$key])){
				$args = array(
					'post_type' => 'page',
					'orderby' => 'ID',
					'order' => 'ASC',
					'meta_query' => array(
						array(
							'key' => 'wtd_page',
							'value' => 'overview_page')));
				$page_query = new WP_Query($args);
				if(!$page_query->found_posts){
					$new_page = array(
						'post_title' => 'What To Do Overview',
						'post_content' => '',
						'post_type' => 'page',
						'post_status' => 'publish');
					$page_id = wp_insert_post($new_page);
					update_post_meta($page_id, 'wtd_page', 'overview_page');
					$wtd_pages['overview_page'] = $page_id;
				}
			}else{
				delete_wtd_post($wtd_pages['overview_page']);
				unset($wtd_pages['overview_page']);
			}
			break;
	}
	/*
	// Map
    if ($key == 'map-page'){
        if(!empty($options[$key])){
            if(!empty($options['wtd_resorts']))
                foreach ($options['wtd_resorts'] as $res_id){
                    wtd_check_post_type(
                        array(
                            'post_type' => 'wtd_activity',
                            'page' => $key,
                            'res_id' => $res_id,
                            'limit' => 100,
                            'type' => 'activities'
                        )
                    );
                    $res_term = $wpdb->get_var(
                        $wpdb->prepare(
                            'SELECT wtd_term_id FROM '.$wpdb->prefix.'wtd_meta WHERE term_id = %s AND meta_key = "res_id" LIMIT 1',
                            $res_id
                        )
                    );
                    $options['map_position'][$res_id]['lat'] = $options['user_map']['lat'];
                    $options['map_position'][$res_id]['lng'] = $options['user_map']['lng'];
                    $args = array(
                        'post_type' => 'page',
                        'orderby' => 'ID',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                                'key' => 'wtd_page',
                                'value' => 'map_page'
                            ),
                            array(
                                'key' => 'res_id',
                                'value' => $res_id
                            )
                        )
                    );
                    $page_query = new WP_Query($args);
                    if (!$page_query->found_posts){
                        $transient = 1;
                        $resort = get_term($res_id,'wtd_resort');
                        $rname = explode(',',$resort->name);
                        $new_page = array(
                            'post_title' => $rname[0].' Map',
                            'post_content' => '',
                            'post_type' => 'page',
                            'post_status' => 'publish'
                        );
                        $page_id = wp_insert_post($new_page);
                        update_post_meta($page_id,'wtd_page','map_page');
                        update_post_meta($page_id,'res_id',$res_id);
                        if (empty($wtd_pages['map_pages']))
                            $wtd_pages['map_pages'] = array($res_id => $page_id);
                        else
                            $wtd_pages['map_pages'][$res_id] = $page_id;
                    } elseif(!empty($wtd_pages['map_pages']))
                        if (!in_array($page_query->posts[0]->ID, $wtd_pages['map_pages'])) {
                            $transient = 1;
                            for($i = 1; $i < $page_query->found_posts; $i++)
                                wp_delete_post($page_query->posts[$i]->ID, true);
                            $wtd_pages['map_pages'][$res_id] = $page_query->posts[0]->ID;
                        }
                }
        }
    }
	//Calendar
	//Week
	if($key == 'week-page'){
		if(!empty($options[$key])){
			if(!empty($options['wtd_resorts'])){
				foreach($options['wtd_resorts'] as $res_id){
					$args = array(
						'post_type' => 'page',
						'orderby' => 'ID',
						'order' => 'ASC',
						'meta_query' => array(
							array(
								'key' => 'wtd_page',
								'value' => 'week_page'),
							array(
								'key' => 'res_id',
								'value' => $res_id)));
					$page_query = new WP_Query($args);
					if(!$page_query->found_posts){
						$transient = 1;
						$options['calendar_options']['page_style'][$res_id] = 1;
						$resort = get_term($res_id, 'wtd_resort');
						$rname = explode(',', $resort->name);
						$new_page = array(
							'post_title' => $rname[0] . ' Events This Week',
							'post_content' => '',
							'post_type' => 'page',
							'post_status' => 'publish');
						$page_id = wp_insert_post($new_page);
						update_post_meta($page_id, 'wtd_page', 'week_page');
						update_post_meta($page_id, 'res_id', $res_id);
						if(empty($wtd_pages['week_pages']))
							$wtd_pages['week_pages'] = array($res_id => $page_id);
						else
							$wtd_pages['week_pages'][$res_id] = $page_id;
					}elseif(!empty($wtd_pages['week_pages'])){
						if(!in_array($page_query->posts[0]->ID, $wtd_pages['week_pages'])){
							$transient = 1;
							for($i = 1; $i < $page_query->found_posts; $i ++){
								wp_delete_post($page_query->posts[$i]->ID, true);
							}
							$wtd_pages['week_pages'][$res_id] = $page_query->posts[0]->ID;
						}
					}
				}
				$args = array(
					'post_type' => 'wtd_event',
					'orderby' => 'ID',
					'order' => 'ASC');
				$post_query = new WP_Query($args);
				if(!$post_query->found_posts){
					$new_post = array(
						'post_title' => 'WTD Event',
						'post_content' => '',
						'post_name' => 'wtd-event',
						'post_type' => 'wtd_event',
						'post_status' => 'publish');
					$post = wp_insert_post($new_post);
				}
			}
		}
	}
	//Week Specials
	if($key == 'week-specials-page'){
		if(!empty($options[$key])){
			if(!empty($options['wtd_resorts'])){
				foreach($options['wtd_resorts'] as $res_id){
					$args = array(
						'post_type' => 'page',
						'orderby' => 'ID',
						'order' => 'ASC',
						'meta_query' => array(
							array(
								'key' => 'wtd_page',
								'value' => 'week_specials_page'),
							array(
								'key' => 'res_id',
								'value' => $res_id)));
					$page_query = new WP_Query($args);
					if(!$page_query->found_posts){
						$transient = 1;
						$resort = get_term($res_id, 'wtd_resort');
						$rname = explode(',', $resort->name);
						$new_page = array(
							'post_title' => $rname[0] . ' Specials This Week',
							'post_content' => '',
							'post_type' => 'page',
							'post_status' => 'publish');
						$page_id = wp_insert_post($new_page);
						update_post_meta($page_id, 'wtd_page', 'week_specials_page');
						update_post_meta($page_id, 'res_id', $res_id);
						if(empty($wtd_pages['week_specials_pages']))
							$wtd_pages['week_specials_pages'] = array($res_id => $page_id);
						else
							$wtd_pages['week_specials_pages'][$res_id] = $page_id;
					}elseif(!empty($wtd_pages['week_specials_pages'])){
						if(!in_array($page_query->posts[0]->ID, $wtd_pages['week_specials_pages'])){
							$transient = 1;
							for($i = 1; $i < $page_query->found_posts; $i ++){
								wp_delete_post($page_query->posts[$i]->ID, true);
							}
							$wtd_pages['week_specials_pages'][$res_id] = $page_query->posts[0]->ID;
						}
					}
				}
				$args = array(
					'post_type' => 'wtd_special',
					'orderby' => 'ID',
					'order' => 'ASC');
				$post_query = new WP_Query($args);
				if(!$post_query->found_posts){
					$new_post = array(
						'post_title' => 'WTD Special',
						'post_content' => '',
						'post_name' => 'wtd-special',
						'post_type' => 'wtd_special',
						'post_status' => 'publish');
					$post = wp_insert_post($new_post);
				}
			}
		}
	}
	//Search
	if($key == 'search-page'){
		if(!empty($options[$key])){
			$args = array(
				'post_type' => 'page',
				'orderby' => 'ID',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'wtd_page',
						'value' => 'search_page')));
			$page_query = new WP_Query($args);
			if(!$page_query->found_posts){
				$transient = 1;
				$new_page = array(
					'post_title' => 'Search',
					'post_content' => '',
					'post_type' => 'page',
					'post_status' => 'publish');
				$page_id = wp_insert_post($new_page);
				update_post_meta($page_id, 'wtd_page', 'search_page');
				if(empty($wtd_pages['search_page']))
					$wtd_pages['search_page'] = array($page_id);
				else
					$wtd_pages['search_page'][] = $page_id;
			}elseif(!empty($wtd_pages['search_page'])){
				if(!in_array($page_query->posts[0]->ID, $wtd_pages['search_page'])){
					$transient = 1;
					for($i = 1; $i < $page_query->found_posts; $i ++){
						wp_delete_post($page_query->posts[$i]->ID, true);
					}
					$wtd_pages['search_page'][] = $page_query->posts[0]->ID;
				}
			}
		}else{
			$args = array(
				'post_type' => 'page',
				'orderby' => 'ID',
				'order' => 'ASC',
				'meta_query' => array(
					array(
						'key' => 'wtd_page',
						'value' => 'search_page')));
			$page_query = new WP_Query($args);
			foreach($page_query->posts as $post){
				wp_delete_post($post->ID, true);
			}
			$wtd_pages['search_page'] = array();
		}
	}
	*/

	update_option('wtd_plugin', $options);
	update_option('wtd_pages', $wtd_pages);
}

function wtd_shortcode_temp($field, $value){
	global $wpdb, $wtd_redux_config;
	$place = "shortcode_options";
	$exclude = array();
	$options = get_option('wtd_plugin');

	$cats = $wtd_redux_config->mapped_categories['activities'];
	foreach($exclude as $x){
		unset($cats[$x]);
	}
	foreach($options['wtd_resorts'] as $resort){
		echo '<div class="category_full resort_hide" data-place="' . $place . '">';
		foreach($cats as $pcat){
			$cat = $pcat['parent'];
			$cat_enable = 'selected';
			$cat_disable = '';
			if(!empty($options[$place][$resort][$cat->term_id]['parent'])){
				$cat_enable = '';
				$cat_disable = 'selected';
			}?>
			<div id="<?php echo $place . '_';?><?php echo $resort;?>_parent_term_<?php echo $cat->term_id;?>" class="wtd_cat_container">
				<fieldset class="redux-field-container redux-field redux-container-switch" data-id="category-<?php echo $cat->term_id;?>" data-type="switch">
					<div class="switch-options">
						<label class="cb-enable <?php echo $cat_enable;?> wtd_shortcode_button" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="1" data-resort="<?php echo $resort;?>">
							<span>Show</span>
						</label>
						<label class="cb-disable <?php echo $cat_disable;?> wtd_shortcode_button" data-place="<?php echo $place;?>" data-term="<?php echo $cat->term_id;?>" data-val="0" data-resort="<?php echo $resort;?>">
							<span>Hide</span>
						</label>
					</div>
				</fieldset>
				<span>Show/Hide "<?php echo $cat->name;?>" Category</span>
				<hr/>
				<h4>Disable individual Subcategories</h4><?php
				$ch = $pcat['children'];
				foreach($ch as $c){
					$icon = 'el-icon-check';
					$class = 'button-primary';
					if(!empty($options[$place][$resort][$cat->term_id]['children'][$c->term_id]) || !empty($options[$place][$resort][$cat->term_id]['parent'])){
						$icon = "el-icon-check-empty";
						$class = '';
					}
					echo '<a href="javascript:void(0);" title="' . $c->name . '" data-term="' . $c->term_id . '" data-parent="' . $cat->term_id . '" data-place="' . $place . '" data-resort="' . $resort . '" class="wtd_shortcode_button wtd_scat button ' . $class . '"><label class="term-count">' . $c->count . '</label><span>' . $c->name . '</span><i class="' . $icon . '"></i></a>';
				}?>
			</div><?php
		}
		echo '</div>';
	}
}

function wtd_shortcode_options($field, $value){
	global $wpdb, $wtd_redux_config;
	$place = "shortcode_options";?>
	<fieldset class="redux-field-container redux-field redux-container-button_set" data-type="button_set">
		<span>Select resort</span>
		<section class="buttonset ui-buttonset wtd_resorts_selector"><?php
			$options = get_option('wtd_plugin');
			$right = count($options['wtd_resorts']) - 1;
			foreach($options['wtd_resorts'] as $key => $resort){
				$rpost = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->terms . ' WHERE term_id = %d LIMIT 1', $resort));
				if($key == 0)
					{$bclass = 'ui-corner-left';}
				elseif($key == $right)
					{$bclass = 'ui-corner-right';}
				else
					{$bclass = '';}?>
				<label class="ui-button ui-widget ui-state-default ui-button-text-only resort_selector <?php echo $bclass;?>" data-resort="<?php echo $resort;?>" data-place="<?php echo $place;?>" role="button" aria-disabled="false">
					<span class="ui-button-text"><?php echo $rpost->name;?></span>
				</label><?php
			}?>
		</section>
		<hr/>
	</fieldset><?php

	$not_allowed = $wpdb->get_results('SELECT term_id FROM ' . $wpdb->prefix . 'wtd_meta WHERE meta_key = "cat_id" AND wtd_term_id IN (6,903,1008) LIMIT 3');
	$exclude = array();
	foreach($not_allowed as $n){
		$exclude[] = $n->term_id;
	}
	$options = get_option('wtd_plugin');

	$cats = $wtd_redux_config->mapped_categories['activities'];
	foreach($exclude as $x){
		unset($cats[$x]);
	}
	foreach($options['wtd_resorts'] as $resort){
		echo '<section id="' . $place . '_' . $resort . '_first" class="resort_hide" data-place="' . $place . '">';
		foreach($cats as $key => $pcategory){
			$category = $pcategory['parent'];
			$icon = 'el-icon-check';
			if(!empty($options[$place][$resort][$category->term_id]['parent'])){
				$icon = 'el-icon-check-empty';
			}
			echo '<a href="javascript:void(0);" class="button wtd_cat wtd_shortcode_button" data-place="' . $place . '" data-term="' . $category->term_id . '" data-resort="' . $resort . '"><label class="term-count">' . $category->count . '</label><span>' . $category->name . '</span><i class="' . $icon . '"></i></a>';
		}
		echo '</section>';
	}
	echo '<section id="' . $place . '_inputs">';
	foreach($options['wtd_resorts'] as $resort){
		if(!empty($options[$place][$resort])){
			foreach($options[$place][$resort] as $term_id => $val){
				if(!empty($val['parent']))
					{echo '<input type="hidden" data-term="' . $term_id . '" id="' . $place . '_' . $resort . '_term_' . $term_id . '" name="wtd_plugin[' . $place . '][' . $resort . '][' . $term_id . '][parent]" value="1"/>';}
				if(!empty($val['children'])){
					foreach($val['children'] as $child_id => $child){
						echo '<input type="hidden" data-term="' . $child_id . '" id="' . $place . '_' . $resort . '_term_' . $child_id . '" name="wtd_plugin[' . $place . '][' . $resort . '][' . $term_id . '][children][' . $child_id . ']" value="1"/>';
					}
				}
			}
		}
	}
	echo '</section>';
}

function wtd_shortcode_display($field, $value){?>
    <p>Post/Page Content&nbsp;&nbsp;&nbsp;<pre id="wtd_pre_post">[wtd_search_form]</pre></p>
    <p>Theme File&nbsp;&nbsp;&nbsp;<pre id="wtd_pre_theme"><?php echo '&lt;?php echo do_shortcode(\'[wtd_search_form]\'); ?>';?> </pre></p>
    <p>You can display the search form by inserting the code above inside your post/page content or your theme files.</p><?php
}