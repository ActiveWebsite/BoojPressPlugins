<?php
require_once WTD_PLUGIN_PATH.'/includes/class_utility.php';

if(!class_exists('wtd_parse_single_event')){

	class wtd_parse_single_event{

		public $utility;

        function __construct(){
            add_action('the_content', array($this, 'single_event'));
            //Ajax calls
            add_action('wp_ajax_wtd_build_event', array($this, 'build_content'));
            add_action('wp_ajax_nopriv_wtd_build_event', array($this, 'build_content'));
            add_filter('the_title', array($this, 'the_title'));
	        $this->utility = new wtdUtility();
        }

        public function the_title($title){
            if(!is_singular('wtd_event') || !in_the_loop())
                return $title;
            return '';
        }

        public function single_event($content){
	        global $wtd_plugin, $post, $wpdb, $wp_query, $wtd_connector;
			if($wtd_plugin['start_url'] == 2 || empty($wtd_plugin['start_url']))
				$start_url = site_url();
			else
				$start_url = home_url();
			if(!is_singular('wtd_event') || !in_the_loop())
                return $content;

            if($post->post_type == 'wtd_event'){
                // todo hook up to resort id to call the correct page
	            $query = "SELECT
							p.post_name
						FROM
							wp_posts p,
							wp_postmeta pm
						WHERE
							pm.post_id = p.ID
						AND pm.meta_value = 'calendar_page'
						AND	p.post_type = 'page'";
	            $calendar_page = $wpdb->get_var($query);
	            $calendar_page = $start_url.'/'.$wtd_plugin['url_prefix'].'/'.$calendar_page.'/';
                remove_filter('the_content', 'theme_formatter', 99);
                remove_filter('the_content', 'wpautop', 99);
                ob_start();?>
                <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'/assets/css/wtd_calendar_page.css?wtd_version='.WTD_VERSION; ?>"/>
                <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_activities_page.css?wtd_version='.WTD_VERSION; ?>"/><?php
                $base_request = $wtd_connector->get_base_request();
                $base_request['event_id'] = $wp_query->query['wtd_parse_id'];
                $iPod = stripos($_SERVER['HTTP_USER_AGENT'], "iPod");
                $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
                $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");
                $mac = stripos($_SERVER['HTTP_USER_AGENT'], "Mac");
                //if($iPod || $iPhone || $iPad || $mac):?>
	                <form method="post" id="ical">
	                    <input type="hidden" name="wtd_data" id="ical_wtd_data" value=""/>
	                    <input type="hidden" name="wtd_build_ical" value="1"/>
	                    <a href="javascript:jQuery('#ical').submit()" class="wtd_ical_button">Add to iCal</a>
	                </form><?php
                //endif;?>
                <div ng-app="eventApp" ng-controller="eventCtrl">
                    <div layout="row" layout-align="center center" ng-hide="progress == false" layout-padding>
                        <md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
                    </div>
                    <div id="wtd_event_sc_container" ng-hide="progress == true" ng-bind-html="content"></div>
                </div><?php
                wtd_copyright();?>
	    	<script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse-1.6.14.js"></script>
            	<script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse_init.js"></script>
                <script>
                    var wtd_base_request = <?php echo json_encode($base_request);?>;
	                var return_page = '<?php echo $calendar_page;?>';
                </script>
	            <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/single_pages/event.js"></script><?php
                $content = ob_get_clean();
            }
            return $content;
        }

        public function build_content(){
            global $wtd_connector;
            $data = $wtd_connector->decrypt_parse_response($_POST['data']);
            $event = $data->event;
            $addresses = $data->addresses;
            $vendor = $data->vendor;
            if(!empty($data->videos))
                $videos = $data->videos;
            ob_start();?>
            <div class="wtd_single_event_container">
                <div class="wtd_event_sc_event_list">
                    <div class="wtd_event_sc_top_content clearfix">
	                    <div class="wtd_single_event_sc_image">
		                    <img src="<?php echo wtd_get_image_url($event->logoUrl); ?>" alt="Vendor Image"/>
	                    </div><?php
                        $this->utility->displayVideo($videos); ?>
                        <hr/>
                        <div class="wtd_single_event_sc_left_content"><?php
                            $event_title = $event->name;
                            if(!empty($event_title) && !empty($vendor->displayName) && !substr_count($event_title,$vendor->displayName))
                                $event_title .= ', '.$vendor->displayName;
                            elseif(!empty($vendor->displayName) && empty($event_title))
                                $event_title = $vendor->displayName;?>
                            <h2><?php echo $event_title;?></h2>
                            <p><?php
                                $eve_timestamp = strtotime($event->eventDate->iso);
                                $eve_date = date('D, M j, Y', $eve_timestamp);
                                echo '<strong>' . $eve_date . '</strong>';?>
                            </p><?php
	                        if($event->startTime != "00:00:00" && $event->startTime != "23:59:59" && !empty($event->startTime)):?>
                                <p><?php
                                    $start = new DateTime(date('Y-m-d '.$event->startTime)); ?>
                                    Start Time: <strong><?php echo $start->format('g:i a');?></strong>
                                </p><?php
	                        endif;
	                        if(!empty($event->description)):?>
                                <p><?php
	                                echo $event->description;?>
                                </p><?php
	                        endif;?>
							<p><strong>Contact Information:</strong><br /><?php
	                        if(!empty($event->phone)){
                                $strevent_phone = $event->phone;
                                if(strlen($strevent_phone) == 10)
                                    $event_phone = ' <a href="tel:' . $strevent_phone . '">(' . substr($strevent_phone, 0, 3) . ') ' . substr($strevent_phone, 3, 3) . '-' . substr($strevent_phone, 6) . '</a>';
                                echo "Phone: " . $event_phone . "<br />";
                            }
	                        if(!empty($event->email) && filter_var($event->email, FILTER_VALIDATE_EMAIL)){?>
                                Email Us @ <a href="mailto:<?php echo $event->email; ?>"><?php echo $event->email; ?></a><br/><?php
                            }
	                        if(!empty($event->website)){?>
                                Visit Us at <a href="<?php echo (substr_count($event->website, 'http://')) ? $event->website : 'http://' . $event->website; ?>" target="_blank"><?php echo $event->website; ?></a><br/><?php
                            }?>
							</p><?php
                            if(!empty($addresses)):
                                foreach($addresses as $address){
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
                                    echo '<p>'.$location_display.'</p>';
                                }
                            endif;?>
                        </div>
                    </div><?php
	                $this->utility->displayGallery($data->images);?>
                </div>
            </div><?php
            die(ob_get_clean());
        }
    }
    $wtd_parse_calendar_page = new wtd_parse_single_event();
}?>
