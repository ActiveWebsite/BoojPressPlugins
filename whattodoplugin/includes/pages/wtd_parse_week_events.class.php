<?php
if(!class_exists('wtd_parse_week_events')){
	class wtd_parse_week_events{
		public function __construct(){
			$wtd_plugin = get_option('wtd_plugin');
			//Page Content
			if(!empty($wtd_plugin['week-page']))
				add_action('the_content', array($this, 'page_content'), 99);
			//Ajax calls
			add_action('wp_ajax_wtd_build_week_events', array($this, 'build_week'));
			add_action('wp_ajax_nopriv_wtd_build_week_events', array($this, 'build_week'));
			add_filter('the_content', 'wpautop');
		}

		public function page_content($content){
			global $post;
			if(!is_singular('page') || !in_the_loop())
				return $content;
			$res_id = get_post_meta($post->ID, 'res_id', true);
			$page_type = get_post_meta($post->ID, 'wtd_page', true);
			$wtd_pages = get_option('wtd_pages');
			if(!empty($wtd_pages['week_pages'][$res_id]) && $page_type == 'week_page'){
				if(in_array($post->ID, $wtd_pages['week_pages'])){
					remove_filter('the_content', 'theme_formatter', 99);
					remove_filter('the_content', 'wpautop');
					$content = $this->content($res_id);
				}
			}
			return $content;
		}

		public function content($res_id){
			global $wtd_connector;
			ob_start();?>
			<link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_week_page.css?wtd_version='.WTD_VERSION; ?>" media="screen"/><?php
			$wtd_base_request = $wtd_connector->get_base_request();
			$wtd_base_request['resorts'] = array($res_id);
			$start_date = new DateTime();
			$start = date('c');
			$end = date('c', time() + (7 * 24 * 60 * 60));?>
			<div ng-app="eventApp" ng-controller="eventCtrl">
				<div layout="row" layout-align="space-between center" ng-hide="progress == true">
					<md-button ng-click="get_last_week()">Last Week</md-button>
					<md-button ng-click="get_next_week()">Next Week</md-button>
				</div>
				<div layout="row" layout-align="center center" ng-hide="progress == false" layout-padding>
					<md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
				</div>
				<div id="wtd_listing_sc_container" ng-hide="progress == true"></div>
			</div>
			<script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
			<script src="<?php echo WTD_PLUGIN_URL; ?>/assets/js/parse_init.js"></script>
			<script>
				var wtd_base_request = <?php echo json_encode($wtd_base_request);?>;
				var start = new Date('<?php echo $start;?>');
				var end = new Date('<?php echo $end;?>');
			</script>
			<script src="<?php echo WTD_PLUGIN_URL; ?>/assets/js/pages/event_week.js"></script><?php
			wtd_copyright();
			$content = ob_get_clean();
			return $content;
		}

		public function build_week(){
			global $wtd_connector, $wtd_plugin;
			$data = $wtd_connector->decrypt_parse_response($_POST['data']);
			ob_start();
			if(!empty($data)):
				$i = 0;
				$day = null;
				$events = $data;
				foreach($events as $key => $event):
					$addresses = $event->addresses;
					$vendor = $event->vendor;
					$event_url = '/'.$wtd_plugin['url_prefix'].'/event/'.$event->id.'/'.sanitize_title($event->name).'/';
					$event_day = new DateTime('@'.strtotime($event->date));
					if($event_day != $day){
						$day = new DateTime('@'.strtotime($event->date));?>
						<span><?php echo $day->format('m/d/Y');?></span><?php
					}?>
					<div class="wtd_event_container md-whiteframe-z2" layout-padding>
						<div class="wtd_listing_sc_top_content"><?php
							$title = $event->name;?>
							<p class="wtd_listing_title_bar">
								<a href="<?php echo $event_url; ?>"><?php echo $title.' - '.$vendor; ?></a>
							</p>
							<div layout="row">
								<a href="<?php echo $event_url; ?>">
									<img class="wtd_event_image" layout-margin src="<?php echo $event->image; ?>" alt="<?php echo $title; ?>"/>
								</a>
								<div flex layout="column">
									<div class="wtd_excerpt"><?php
										$desc = $event->description;
										wtd_excerpt_generator($desc, false, $event_url);?>
									</div><?php
									if(!empty($vendor)):?>
										<div>Event Hosted by: <?php echo $vendor; ?></div><?php
									endif; ?>
									<div class="wtd_week_date"><?php
										$time = strtotime($event->date);
										echo date('D, F d, Y', $time);?>
									</div><?php
									if($event->startTime != "00:00:00" && $event->startTime != "23:59:59" && !empty($event->startTime)): ?>
										<div class="wtd_week_date"><?php
											$start = new DateTime(date('Y-m-d ' . $event->startTime));?>
											Start Time: <?php echo $start->format('g:i a'); ?>
										</div><?php
									endif;?>
									<div class="result_address"><?php
										if(!empty($addresses)){
											if(count($addresses) == 1){
												$address = $addresses[0];
												$display_address = '';
												$street = $address->address;
												if(!empty($street))
													$display_address .= $street;
												$city = $address->city;
												if(!empty($city)){
													if(!$display_address)
														$display_address .= $city;
													else
														$display_address .= ' in ' . $city;
												}
												$state = $address->state;
												if(!empty($state)){
													if(empty($display_address))
														$display_address .= $state;
													else
														$display_address .= ', ' . $state;
												}
												$phone = $address->phone;
												if(!empty($phone))
													$display_address .= " (" . substr($phone, 0, 3) . ") " . substr($phone, 3, 3) . "-" . substr($phone, 6);
												else
													$display_address .= '';
											}else{
												$cities = array();
												foreach($addresses as $address){
													if(!in_array($address->city, $cities))
														$cities[] = $address->city;
												}
												$display_address = 'Various Locations in ' . implode(', ', $cities);
											}
											echo '<p>' . $display_address . '</p>';
										}?>
									</div>
								</div>
							</div>
						</div>
					</div><?php
					$i ++;
				endforeach;
			else:?>
				No events available.<?php
			endif;
			die(ob_get_clean());
		}
	}
	$wtd_parse_week_events = new wtd_parse_week_events();
}?>