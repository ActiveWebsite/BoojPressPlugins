<?php
require_once WTD_PLUGIN_PATH.'/includes/pages/class_parse_page.php';

use Parse\ParseQuery;
use Parse\ParseException;

if(!class_exists('wtd_short_parse_activities_page')){

    class wtd_short_parse_activities_page extends wtd_parse_page{

		private $wtd_categories;

		function __construct(){
			parent::__construct();
		}

		public function page_content($res_id = 'dCSKUv98dd', $parent_cat_id = 'Amf6XE8BOi', $cat_id = ''){
			global $wtd_plugin, $post, $wp_query;
			//Page Content
			ob_start();
			$this->results($res_id, $parent_cat_id, $cat_id);
			$content = ob_get_contents();
			ob_end_clean();
			return $content;
		}

		private function results($res_id, $cat_id, $subcat_id){?>
            <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_activities_page.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
			<link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_frontend.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
		    <div ng-app="activitiesApp" ng-controller="activitiesCtrl">
    	    <div layout="row" layout-sm="column" layout-padding><?php
				global $wp_query, $post, $wtd_plugin, $wtd_connector;
				$wtd_base_request = $wtd_connector->get_base_request();
				$wtd_base_request['resorts'] = array($res_id);
				$wtd_base_request['page'] = 1;
				//$cat_id = $wp_query->query['wtdc'];
				$wtd_base_request['category_id'] = $cat_id;
				if (!empty($subcat_id))
					$wtd_base_request['category_id'] = $subcat_id;
				else 
					$subcat_id = '';	
				$wtd_excluded_cats = get_option('wtd_excluded_cats');
				if (!empty($wtd_excluded_cats))
					$wtd_base_request['excluded_categories'] = json_decode($wtd_excluded_cats); ?>
				<script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse-1.6.14.js"></script>
				<script src="<?php echo WTD_PLUGIN_URL; ?>/assets/js/parse_init.js"></script>
				<script>
					var wtd_categories = <?php echo json_encode($this->wtd_categories);?>;
					var wtd_base_request = <?php echo json_encode($wtd_base_request);?>;
					var cat_id = '<?php echo $cat_id;?>';
					var subcat_id = '<?php echo $subcat_id;?>';
					var wtd_parse_page = 1;
					var cur_category = '<?php echo $cat_id;?>';
				</script>
				<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular-route.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular-animate.min.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular-aria.min.js"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.0.4/angular-material.min.js"></script>
				<script src="<?php echo WTD_PLUGIN_URL; ?>assets/js/pages/activities.js"></script>
				</div>
				<div id="wtd_listing_sc_container" name="wtd_listing_sc_container"></div><?php
				wtd_copyright();?>
			</div>
			<?php
		}

	}
    $wtd_short_parse_activities_page = new wtd_short_parse_activities_page();
}?>