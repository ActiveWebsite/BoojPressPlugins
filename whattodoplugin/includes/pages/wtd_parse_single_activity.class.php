<?php
require_once WTD_PLUGIN_PATH.'/includes/class_utility.php';

if(!class_exists('wtd_parse_single_activity')){
    class wtd_parse_single_activity{

	    public $utility;

        function __construct(){
            add_action('the_content', array($this, 'activity_content'), 99);
            //Ajax calls
            add_action('wp_ajax_wtd_build_activity', array($this, 'build_content'));
            add_action('wp_ajax_nopriv_wtd_build_activity', array($this, 'build_content'));
	        add_filter('the_title', array($this, 'the_title'));
	        $this->utility = new wtdUtility();
        }

	    public function the_title($title){
		    if(!is_singular('wtd_activity') || !in_the_loop())
			    return $title;
		    return '';
	    }

        public function activity_content($content){
            global $wpdb, $post, $wtd_plugin, $wtd_connector, $wp_query;
			if($wtd_plugin['start_url'] == 2 || empty($wtd_plugin['start_url']))
				$start_url = site_url();
			else
				$start_url = home_url();

            if(!is_singular('wtd_activity') || !in_the_loop())
                return $content;
            if($post->post_type == 'wtd_activity'){
	            $query = "SELECT
								p.post_name
							FROM
								wp_posts p,
								wp_postmeta pm
							WHERE
								pm.post_id = p.ID
							AND pm.meta_value = 'activities_page'
							AND	p.post_type = 'page'";
	            $activities_page = $wpdb->get_var($query);
	            $activities_page = $start_url.'/'.$wtd_plugin['url_prefix'].'/'.$activities_page.'/';
                ob_start();
                $res_id = get_post_meta($post->ID, 'res_id', true);?>
	            <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_activities_page.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
                <div ng-app="activityApp" ng-controller="activityCtrl">
	                <div layout="row" layout-align="center center" ng-hide="progress == false" layout-padding>
		                <md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
	                </div>
                    <div class="wtd_single_listing_container" id="wtd_parse_content" ng-hide="progress == true"></div>
                </div><?php
                wtd_copyright();
                $base_request = $wtd_connector->get_base_request();
                $base_request['object_id'] = $wp_query->query['wtd_parse_id'];?>
	    	<script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse-1.6.14.js"></script>
            	<script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse_init.js"></script>
                <script>
                    var wtd_base_request = <?php echo json_encode($base_request);?>;
	                var parent_page = '<?php echo $activities_page;?>';
                </script>
	            <script type="text/javascript" src="<?php echo WTD_PLUGIN_URL;?>assets/js/single_pages/activity.js"></script><?php
                $content = ob_get_clean();
            }
            return $content;
        }

        public function build_content(){
            global $wtd_connector;
            $data = $wtd_connector->decrypt_parse_response($_POST['data']);
            $activity = $data->activity;
            if(!empty($data->addresses))
                $addresses = $data->addresses;
            if(!empty($data->images))
                $images = $data->images;
            if(!empty($data->relvideos))
                $videos = $data->relvideos;
	        ob_start();?>
	        <div layout="column"><?php
		        $this->utility->displayVideo($videos); ?>
	            <div layout="column">
		            <div layout="row" layout-align="center center" layout-margin layout-padding>
	                    <img class="wtd_single_listing_sc_image" src="<?php echo $activity->logoUrl;?>" />
		            </div>
	                <h3><?php echo $activity->name;?></h3>
	                <p class="wtd_text_bold"><?php
	                    echo $activity->vend_name;?>
	                </p>
	                <p><?php echo $activity->description;?></p>
	                <p class="wtd_text_bold">
	                    Contact Information
	                </p><?php
	                if(!empty($addresses)):
	                    foreach($addresses as $address):?>
	                        <p><?php
	                            $location_display = $address->address;
	                            if(!empty($location_display) && !empty($address->city))
	                                $location_display .= ', ' . $address->city;
	                            elseif(!empty($address->city))
	                                $location_display = $address->city;
	                            if(!empty($location_display) && !empty($address->state))
	                                $location_display .= ', ' . $address->state;
	                            elseif(!empty($address->state))
	                                $location_display = $address->state;
	                            if(!empty($location_display) && !empty($address->postalCode))
	                                $location_display .= ' ' . $address->postalCode;
	                            elseif(!empty($address->postalCode))
	                                $location_display = $address->postalCode;
	                            if(!empty($address->geoLocation) && $address->geoLocation->latitude != 0 && $address->geoLocation->longitude != 0 )
	                                $location_display .= ' - <a class="wtd_direction_link" target="_blank" href="https://maps.google.com/?saddr=Current+Location%&daddr=' . $address->geoLocation->latitude . ',' . $address->geoLocation->longitude . '">View Directions</a>';
	                            echo $location_display;?>
	                        </p><?php
	                    endforeach;
	                endif;
	                if(!empty($activity->phone)):
	                    $listing_phone = $activity->phone;?>
	                    <p>
	                        <span class="expireBig"><?php echo " (" . substr($listing_phone, 0, 3) . ") " . substr($listing_phone, 3, 3) . "-" . substr($listing_phone, 6);?></span>
	                    </p><?php
	                endif;
	                if(!empty($activity->website)):
	                    $listing_web = $activity->website;?>
	                    <p>
	                        <span class="expireBig">
	                            <a href="<?php echo (substr_count($listing_web, 'http://')) ? $listing_web : 'http://' . $listing_web;?>" target="_blank"><?php
	                                echo $listing_web;?>
	                            </a>
	                        </span>
	                    </p><?php
	                endif;
		            $this->utility->displayGallery($images);?>
	            </div>
            </div><?php
            die(ob_get_clean());
        }
    }
    $wtd_parse_single_activity = new wtd_parse_single_activity();
}?>