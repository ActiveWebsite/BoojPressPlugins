<?php
require_once WTD_PLUGIN_PATH.'/includes/pages/class_parse_page.php';

if(!class_exists('wtd_parse_calendar_page')){
    class wtd_parse_calendar_page extends wtd_parse_page{

		public function __construct(){
            parent::__construct();
		    //Page Content
            if(!empty($this->wtd_plugin['calendar-page']))
                add_action('the_content', array($this, 'page_content'), 99);
            //Ajax calls
	        add_action('wp_ajax_nopriv_get_date_dialog', array($this, 'build_date_dialog'));
	        add_action('wp_ajax_get_date_dialog', array($this, 'build_date_dialog'));
            add_action('wp_ajax_wtd_build_calendar', array($this, 'build_calendar'));
            add_action('wp_ajax_nopriv_wtd_build_calendar', array($this, 'build_calendar'));
            add_filter('the_content', 'wpautop');
        }

        public function build_html(){
        }

	    public function build_date_dialog(){
            global $wtd_plugin;
			if($wtd_plugin['start_url'] == 2 || empty($wtd_plugin['start_url']))
				$start_url = site_url();
			else
				$start_url = home_url();
			$timestamp = $_POST['timestamp'];
		    $res_id = $_POST['res_id'];
		    $resort_query = new \Parse\ParseQuery('resort');
		    $resort_query->equalTo('objectId', $res_id);
            	    $date = new DateTime("@$timestamp");
		    $query = new \Parse\ParseQuery('event');
		    $query->equalTo('eventDate', $date);
		    $query->matchesQuery('resortObjectId', $resort_query);
		    $results = $query->find();
            echo $this->twig->render('md_dialog.twig', array(
                'date' => $date->format('F j, Y'),
                'events' => $results,
                'url_prefix' => $start_url.'/'.$wtd_plugin['url_prefix'].'/event/'
            ));
		    die();
	    }

        public function page_content($content){
            global $wtd_connector, $post;
            if(!is_singular('page') || !in_the_loop())
                return $content;
            $wtd_pages = get_option('wtd_pages');
            $res_id = get_post_meta($post->ID, 'res_id', true);
            $page_type = get_post_meta($post->ID, 'wtd_page', true);
            if(!empty($wtd_pages['calendar_pages'][$res_id]) && $page_type == 'calendar_page'){
                if(in_array($post->ID, $wtd_pages['calendar_pages'])){
                    ob_start();
                    $res_id = get_post_meta($post->ID, 'res_id', true);?>
		    <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse-1.6.14.js"></script><?php
                    $step = 24 * 60 * 60;
                    $start = strtotime(date('Y-m-1'));
                    while(date('l', $start) != "Sunday"){
                        $start = $start - $step;
                    }
                    $end = strtotime(date('Y-m-t'));
                    while(date('l', $end) != "Sunday"){
                        $end = $end + $step;
                    }
                    $start = date('c', $start);
                    $end = date('c', $end);
                    $wtd_base_request = $wtd_connector->get_base_request();
                    $wtd_base_request['resorts'] = array($res_id);?>
                    <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'/assets/css/wtd_calendar_page.css';?>"/>
		    <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse-1.6.14.js"></script>
		    <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse_init.js"></script> 
		    <script>
			var base_request = <?php echo json_encode($wtd_base_request);?>;
                        var wtd_start_date = new Date('<?php echo $start;?>');
                        var wtd_end_date = new Date('<?php echo $end;?>');
						var res_id = '<?php echo $res_id;?>';
                    </script>
	                <div ng-app="calendarApp" ng-controller="calendarCtrl">
	                    <div flex="100" layout="row" layout-align="space-between center" layout-padding layout-margin style="font-weight:bold;" ng-hide="progress == true">
		                    <a id="prev_month" ng-click="get_last_month()">
			                    &laquo; Previous Month
	                        </a>
	                        <span id="current_month"></span>
	                        <a id="next_month" ng-click="get_next_month()">
                                Next Month &raquo;
		                    </a>
	                    </div>
	                    <div id="wtd_events" ng-hide="progress == true">
	                        <div id="events_header" layout="row" layout-padding hide-sm style="font-weight: bold;">
	                            <span flex>Sun</span>
	                            <span flex>Mon</span>
	                            <span flex>Tues</span>
	                            <span flex>Wed</span>
	                            <span flex>Thurs</span>
	                            <span flex>Fri</span>
	                            <span flex>Sat</span>
	                        </div>
	                    </div>
		                <div id="dates" ng-hide="progress == true"></div>
		                <div layout="row" layout-align="center center" ng-hide="progress == false" layout-padding>
			                <md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
		                </div>
	                </div>
	                <script type="text/javascript" src="<?php echo WTD_PLUGIN_URL; ?>assets/js/pages/calendar.js"></script><?php
                    wtd_copyright();
                    $content = ob_get_clean();
                }
            }
            return $content;
        }

        public function build_calendar(){
            global $wtd_plugin, $wtd_connector;
			if($wtd_plugin['start_url'] == 2 || empty($wtd_plugin['start_url']))
				$start_url = site_url();
			else
				$start_url = home_url();
			$data = $wtd_connector->decrypt_parse_response($_POST['data']);

            $dates = array();
            foreach($data as $event){
                $date = strtotime($event->date);
                if(empty($dates[date('Y-m-d', $date)]))
                    $dates[date('Y-m-d', $date)] = array($event);
                else
                    $dates[date('Y-m-d', $date)][] = $event;
            }
            $step = 24 * 60 * 60;
            $first_day = $_POST['month'].'/1/'.$_POST['year'];

            $first_timestamp = strtotime($first_day);
            $month = date('m', $first_timestamp);
            $start = strtotime(date($_POST['month'].'/1/'.$_POST['year']));
            while(date('l', $start) != "Sunday"){
                $start = $start - $step;
            }
            $end = strtotime($_POST['month'].'/1/'.$_POST['year']);
            $end = strtotime(date('Y-m-t', $end));
            while(date('l', $end) != "Sunday"){
                $end = $end + $step;
            }
            $temp_time = $start;
            $month_days = array();
            while($temp_time < $end){
                $month_days[date('Y-m-d', $temp_time)] = array();
                if(!empty($dates[date('Y-m-d', $temp_time)]))
                    $month_days[date('Y-m-d', $temp_time)] = $dates[date('Y-m-d', $temp_time)];
                $temp_time += $step;
            }
            ob_start();?>
            <div class="month">
                <div class="week"><?php
                    $i = 0;
                    $type = $wtd_plugin['calendar_type'];
                    foreach($month_days as $date => $events){
                        $date_timestamp = strtotime($date);
                        if($i % 7 == 0 && $i != 0)
                            echo '</div><div class="week">';
                        $results = $events;
                        switch($type){
                            case 1:
                                $images = '<div class="small-events" layout="column">';
                                $count = count($results);
                                if(!empty($results))
                                    $images .= '<img src="' . wtd_get_image_url($results[0]->image) . '" class="main_thumb"/>';
                                else
                                    $count = "No";
                                if($count == 1)
                                    $events_text = $count . ' &nbsp;&nbsp;Event';
                                elseif($count == "No")
                                    $events_text = $count . ' &nbsp;&nbsp;Events';
                                else
                                    $events_text = 'See all '.$count . ' &nbsp;&nbsp;Events';
                                $images .= '</div>';
                                break;
                            case 2:
                                $images = '<div class="small-events" layout="column">';
                                $count = count($results);
                                if(!empty($results)){
                                    for($k = 0; $k < 4; $k ++){
                                        if(!empty($results[$k]))
                                            $images .= '<img src="' . wtd_get_image_url($results[$k]->image) . '" style="max-height:30px; max-width:30px;"/>';
                                    }
                                }else
                                    $count = "No";
                                if($count == 1)
                                    $events_text = $count . ' Event';
                                elseif($count == "No")
                                    $events_text = $count . ' Events';
                                else
                                    $events_text = 'See all '.$count . ' Events';
                                $images .= '</div>';
                                break;
                            case 3:
                            default:
                                $images = '';
                                $count = count($results);
                                if(!empty($results)){
                                    $images = '<div class="small-events">';
                                    $k = 0;
                                    foreach($results as $key => $row){
                                        $event_url = $start_url. '/' . $wtd_plugin['url_prefix'] . '/event/' . $row->id . '/' . sanitize_title($row->name) . '/';
                                        if($k == 3)
                                            break;
                                        $images .= '<a href="' . $event_url . '">&middot; ' . $row->name . '</a><br/>';
                                        $k ++;
                                    }
                                    $images .= '</div>';
                                }else
                                    $count = "No";
                                if($count == 1)
                                    $events_text = $count . ' Event';
                                elseif($count == "No")
                                    $events_text = $count . ' Events';
                                else
                                    $events_text = 'See all '.$count . ' Events';
                                break;
                        }
                        $not_month = '';
                        if($month != date('m', $date_timestamp))
                            $not_month = 'not_month ';?>
                        <div class="<?php echo $not_month; ?>day type<?php echo $type; ?>" <?php echo (empty($not_month)) ? '' : 'hide-sm'; ?> layout="column" layout-padding><?php
                            if($count > 0){?>
                                <div layout="column" title="See more events" class="day-list" onclick="showDateDialog(event, <?php echo $date_timestamp; ?>)"><?php
                            }else{?>
                                <div layout="column" title="No events" class="day-list"><?php
                            }?>
                                <span><em> <?php echo date('M jS', $date_timestamp); ?></em></span><?php
                                echo $images;?>
                            </div><?php
                            if($count > 0){?>
                                <div hide-sm class="cal-day-footer" onclick="showDateDialog(event, <?php echo $date_timestamp; ?>)">
                                    <span class="date-dialog-link"><?php echo $events_text; ?></span>
                                </div><?php
                            }else{?>
                                <div hide-sm class="cal-day-footer" >
                                    <span class="date-dialog-link"><?php echo $events_text; ?></span>
                                </div><?php
                            }?>
                        </div><?php
                        $i ++;
                    }?>
                </div>
	        </div><?php
            $html = ob_get_clean();
	        $time = $_POST['end'];
	        // take two weeks off the end time as its a 5 week calendar to be sure its the current month
	        $time = $time - (7 * 24 * 60 * 60) * 1000 * 2;
	        // convert time from milliseconds to seconds
	        $time = $time/1000;
	        $date = new DateTime('@'.$time);
            $return = array(
                'html' => $html,
	            'current_month' => $date->format('F')
            );
            die(json_encode($return));
        }
	}
	$wtd_parse_calendar_page = new wtd_parse_calendar_page();
}?>