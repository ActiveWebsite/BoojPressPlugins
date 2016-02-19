<?php

if(!class_exists('wtd_parse_specials_page')){
	class wtd_parse_specials_page{
		public function __construct(){
			$wtd_plugin = get_option('wtd_plugin');
			//Page Content
			if(!empty($wtd_plugin['specials-page']))
				add_action('the_content', array($this, 'page_content'), 99);

			//Ajax calls
			add_action('wp_ajax_wtd_build_specials_calendar', array($this, 'build_calendar'));
			add_action('wp_ajax_nopriv_wtd_build_specials_calendar', array($this, 'build_calendar'));
			add_filter('the_content', 'wpautop');
		}

		public function page_content($content){
			global $wtd_plugin, $wtd_connector, $post, $wpdb;

			if(!is_singular('page') || !in_the_loop())
				return $content;

			$wtd_pages = get_option('wtd_pages');
			if(!empty($wtd_pages['specials_pages'])){
				if(in_array($post->ID, $wtd_pages['specials_pages'])){
					ob_start();
					$res_id = get_post_meta($post->ID, 'res_id', true);?>
					<script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script><?php

					$step = 24 * 60 * 60;
					$first_day = date('Y-m-1');
					$temp_arr = explode('-', $first_day);
					$first_timestamp = strtotime($first_day);
					if($temp_arr[1] == 12){
						$next_month = 1;
						$next_year = intval(date('Y')) + 1;
						$prev_month = 11;
						$prev_year = date('Y');
					}elseif($temp_arr[1] == 1){
						$next_month = 2;
						$next_year = date('Y');
						$prev_month = 12;
						$prev_year = intval(date('Y')) - 1;
					}else{
						$next_month = $temp_arr[1] + 1;
						$prev_month = $temp_arr[1] - 1;
						$prev_year = $next_year = date('Y');
					}
					$next_month_name = date('F', strtotime($temp_arr[0] . '-' . $next_month . '-1'));
					$prev_month_name = date('F', strtotime($temp_arr[0] . '-' . $prev_month . '-1'));
					$current_day_week = date('l', $first_timestamp);
					$current_timestamp = $first_timestamp;
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
					//Next Month
					$next_start = strtotime(date($next_year . '-' . $next_month . '-1'));
					while(date('l', $next_start) != "Sunday"){
						$next_start = $next_start - $step;
					}
					$next_end = strtotime($next_year . '-' . $next_month . '-1');
					$next_end = strtotime(date('Y-m-t', $next_end));
					while(date('l', $next_end) != "Sunday"){
						$next_end = $next_end + $step;
					}
					$next_start = date('c', $next_start);
					$next_end = date('c', $next_end);
					//Previous Month
					$prev_start = strtotime(date($prev_year . '-' . $prev_month . '-1'));
					while(date('l', $prev_start) != "Sunday"){
						$prev_start = $prev_start - $step;
					}
					$prev_end = strtotime($prev_year . '-' . $prev_month . '-1');
					$prev_end = strtotime(date('Y-m-t', $prev_end));
					while(date('l', $prev_end) != "Sunday"){
						$prev_end = $prev_end + $step;
					}
					$prev_start = date('c', $prev_start);
					$prev_end = date('c', $prev_end);
					$wtd_base_request = $wtd_connector->get_base_request();

					$resort = $wpdb->get_var($wpdb->prepare("SELECT wtd_term_id FROM {$wpdb->prefix}wtd_meta WHERE term_id = %s AND meta_key = 'res_id'", $res_id));
					$wtd_base_request['resorts'] = array($resort);?>
					<link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'/assets/css/wtd_calendar_page.css';?>"/>
					<script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
					<script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse_init.js"></script>
					<script>
						var wtd_start_date = "<?php echo $start;?>";
						var wtd_end_date = "<?php echo $end;?>";
						var wtd_year = "<?php echo date('Y');?>";
						var wtd_month = "<?php echo date('m');?>";
						var win_width = jQuery(window).width();
						function calendar_repair(){
							if(jQuery('#dates .small-events').length > 0){
								var max_height = 0;
								jQuery('#dates .small-events').each(function(){
									var height = jQuery(this).height();
									if(max_height < height)
										max_height = height;
								});
								jQuery('#dates .day').height(1.5 * max_height);
							}
							var width = jQuery('#events_header span').first().width();
							var relative = width / 5;
							relative = relative + 'px';
							jQuery('#events_header span').attr('style', 'font-size:' + relative);
							var width = jQuery('#dates .day').first().width();
							var relative = width / 8;
							relative = relative + 'px';
							jQuery('.current_date').attr('style', 'font-size:' + relative);
							if(jQuery('.day.type1').length > 0){
								jQuery('.day img').first().load(function(){
									var imgwidth = jQuery(this).width();
									jQuery('.day img').each(function(){
										var height = jQuery(this).height();
										if(imgwidth != height && height){
											var diff = (imgwidth - height) / 2;
											jQuery(this).css({'margin': diff + "px 0px"});
										}
									});
									if(win_width > 768)
										jQuery('#dates .day').height(1.3 * imgwidth);
									else
										jQuery('#dates .day').height(1.3 * imgwidth);
								});
							}
							if(jQuery('.day.type2').length > 0){
								jQuery('.day img').first().load(function(){
									var imgwidth = jQuery(this).width();
									jQuery('.day img').each(function(){
										var height = jQuery(this).height();
										if(width != height && height){
											var diff = (imgwidth - height) / 2;
											jQuery(this).css({'margin': diff + "px 0px"});
										}
									});
									if(win_width > 768)
										jQuery('#dates .day').height(3 * imgwidth);
									else
										jQuery('#dates .day').height(1.8 * imgwidth);
								});
							}
							if(jQuery('#dates .small-events').length > 0){
								var max_height = 0;
								jQuery('#dates .small-events').each(function(){
									var height = jQuery(this).height();
									if(max_height < height)
										max_height = height;
								});
								jQuery('#dates .day').height(1.5 * max_height);
							}
						}
						function modal_repair(sel){
							var img_height = 0;
							jQuery(sel + ' .contents a img').each(function(){
								if(jQuery(this).height() > img_height)
									img_height = jQuery(this).height();
							});
							var img_width = jQuery(sel + ' .contents a img').first().width();
							jQuery(sel + ' .contents a img').each(function(){
								var height = jQuery(this).height();
								if(img_width != height && height){
									var diff = (img_width - height) / 2;
									jQuery(this).css({'margin': diff + "px 0px"});
								}
							});
							var relative = img_width / 10;
							var lheight = img_width / 7;
							relative = relative + 'px';
							lheight = lheight + 'px';
							jQuery('.wtd_events_modal .contents a span').css('font-size', relative);
							jQuery('.wtd_events_modal .contents a span').css('line-height', lheight);
							jQuery('.wtd_events_modal .contents a').height(1.65 * img_height);
							var max_height = 0;
							jQuery('.wtd_events_modal .contents a span').each(function(){
								if(jQuery(this).height() >= max_height){
									max_height = parseInt(jQuery(this).height());
								}
							});
							var top = img_width + 5;
							jQuery('.wtd_events_modal .contents a span').css('top', top);
							jQuery('.wtd_events_modal .contents a span').css('overflow', 'visible');
						}
						function wtd_get_month(start, end, year, month){
							var base_request = <?php echo json_encode($wtd_base_request);?>;
							base_request.start = start;
							base_request.end = end;
							jQuery('#modal_background').addClass('month_loader');
							jQuery('#month_loader').show();
							Parse.Cloud.run('specials_calendar_short', base_request, {
								success: function(result){
									jQuery.ajax({
										url: wtd_ajax_url,
										type: 'post',
										dataType: 'json',
										data: {
											action: 'wtd_build_specials_calendar',
											data: result,
											start: start,
											end: end,
											year: year,
											month: month
										},
										success: function(data){
											jQuery('#modal_background').removeClass('month_loader');
											jQuery('#month_loader').hide();
											jQuery('#dates').html(data.html);
											jQuery('#prev_month').attr('data-start', data.prev_start).html(data.prev_month_text).attr('data-end', data.prev_end).attr('data-month', data.prev_month).attr('data-year', data.prev_year);
											jQuery('#next_month').attr('data-start', data.next_start).html(data.next_month_text).attr('data-end', data.next_end).attr('data-month', data.next_month).attr('data-year', data.next_year);
											jQuery('#curent_month span').html(data.curent_month);
											calendar_repair();
										}
									});
								},
								error: function(error){
									console.log(error);
								}
							});
						}
						jQuery(document).ready(function(){
							jQuery(document).on('click', '#dates .day:not(.nomodal)', function(event){
								if(event.target.nodeName != 'A'){
									var i = jQuery(this).attr('data-i');
									jQuery('#modal_' + i).fadeIn();
									jQuery('#modal_background').show();
									jQuery('html,body').css({'overflow': 'hidden'});
									modal_repair('#modal_' + i);
								}
							});
							jQuery(document).on('click', '.wtd_events_modal .control a', function(event){
								jQuery(this).parent().parent().hide();
								jQuery('#modal_background').hide();
								jQuery('html,body').css({'overflow': 'auto'});
							});
							jQuery(document).on('click', '#modal_background', function(event){
								jQuery(this).hide();
								jQuery('.wtd_events_modal').hide();
								jQuery('html,body').css({'overflow': 'auto'});
							});
							jQuery(window).resize(function(){
								jQuery('.wtd_events_modal').each(function(){
									if(jQuery(this).is(':visible')){
										var id = '#' + jQuery(this).attr('id');
										modal_repair(id);
									}
								});
								win_width = jQuery(window).width();
								if(win_width > 768){
									calendar_repair();
								}else{
									jQuery('#dates .day').removeAttr('style');
									jQuery('.current_date').removeAttr('style');
								}
								if(jQuery('.day.type2').length > 0){
									jQuery('.day img').each(function(){
										var width = jQuery(this).width();
										var height = jQuery(this).height();
										if(imgwidth != height && height){
											var diff = (width - height) / 2;
											jQuery(this).css({'margin': diff + "px 0px"});
										}
									});
									var imgwidth = jQuery('.day img').first().width();
									if(win_width > 768)
										jQuery('#dates .day').height(3 * imgwidth);
									else
										jQuery('#dates .day').height(1.8 * imgwidth);
								}
								if(jQuery('.day.type1').length > 0){
									var imgwidth = jQuery('.day img').first().width();
									jQuery('.day img').each(function(){
										var height = jQuery(this).height();
										if(imgwidth != height && height){
											var diff = (imgwidth - height) / 2;
											jQuery(this).css({'margin': diff + "px 0px"});
										}
									});
									if(win_width > 768)
										jQuery('#dates .day').height(1.3 * imgwidth);
									else
										jQuery('#dates .day').height(1.3 * imgwidth);
								}
							});
							if(win_width > 768){
								if(jQuery('#dates .small-events').length > 0)
									calendar_repair();
							}
							jQuery(document).on('click', '.month_loader', function(event){
								event.preventDefault();
							});
							jQuery('.get_month').click(function(event){
								event.preventDefault();
								var start = jQuery(this).attr('data-start');
								var end = jQuery(this).attr('data-end');
								var month = jQuery(this).attr('data-month');
								var year = jQuery(this).attr('data-year');
								wtd_get_month(start, end, year, month);
							});
							wtd_get_month(wtd_start_date, wtd_end_date, wtd_year, wtd_month);
						});
					</script>
					<div class="row" id="calendar_controller">
						<a href="javascript:void(0);" id="prev_month" class="get_month" data-start="<?php echo $prev_start;?>" data-end="<?php echo $prev_end;?>" data-month="<?php echo $prev_month;?>" data-year="<?php echo $prev_year;?>">&laquo; <?php echo $prev_month_name;?></a>
						<span id="curent_month"><span><?php echo date('F Y');?></span></span>
						<a href="javascript:void(0);" id="next_month" class="get_month" data-start="<?php echo $next_start;?>" data-end="<?php echo $next_end;?>" data-month="<?php echo $next_month;?>" data-end="<?php echo $next_month;?>"><?php echo $next_month_name;?> &raquo;</a>
					</div>
					<div id="wtd_events">
						<div id="modal_background"></div>
						<div id="month_loader">
							<img src="<?php echo WTD_PLUGIN_URL . '/assets/img/loader.gif';?>"/>
							<span>Loading</span>
						</div>
						<div id="events_header">
							<span>Sun</span>
							<span>Mon</span>
							<span>Tues</span>
							<span>Wed</span>
							<span>Thurs</span>
							<span>Fri</span>
							<span>Sat</span>
						</div>
						<div id="dates">
							<div class="wtd_row"><?php
								$start = strtotime($start);
								$end = strtotime($end);
								$i = 0;
								while($start < $end){?>
									<div data-date="" class="day type1">
										<span class="current_date">&nbsp;</span>
										<span>&nbsp;</span>
									</div><?php
									$start += $step;
									$i ++;
									if($i % 7 == 0 && $i != 0)
										echo '</div><div class="wtd_row">';
								}?>
							</div>
						</div>
					</div><?php
					wtd_copyright();
					$content = ob_get_clean();
				}
			}
			return $content;
		}

		public function build_calendar(){
			global $wtd_plugin, $wpdb, $wtd_connector;
			$event_post_id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'wtd_special' LIMIT 1");
			$post_url = get_permalink($event_post_id);
			//Data Mapping
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
			$first_day = $_POST['year'] . '-' . $_POST['month'] . '-' . '1';
			$first_timestamp = strtotime($first_day);
			if($_POST['month'] == 12){
				$next_month = 1;
				$next_year = intval(date('Y', $first_timestamp)) + 1;
				$prev_month = 11;
				$prev_year = date('Y', $first_timestamp);
			}elseif($_POST['month'] == 1){
				$next_month = 2;
				$next_year = date('Y', $first_timestamp);
				$prev_month = 12;
				$prev_year = intval(date('Y', $first_timestamp)) - 1;
			}else{
				$next_month = $_POST['month'] + 1;
				$prev_month = $_POST['month'] - 1;
				$prev_year = $next_year = date('Y', $first_timestamp);
			}
			$next_month_name = date('F', strtotime($next_year . '-' . $next_month . '-1'));
			$prev_month_name = date('F', strtotime($prev_year . '-' . $prev_month . '-1'));
			$month = date('m', $first_timestamp);
			$start = strtotime(date($_POST['year'] . '-' . $_POST['month'] . '-1'));
			while(date('l', $start) != "Sunday"){
				$start = $start - $step;
			}
			$end = strtotime($_POST['year'] . '-' . $_POST['month'] . '-1');
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
            <div class="wtd_row"><?php
				//Next Month
				$next_start = strtotime(date($next_year . '-' . $next_month . '-1'));
				while(date('l', $next_start) != "Sunday"){
					$next_start = $next_start - $step;
				}
				$next_end = strtotime($next_year . '-' . $next_month . '-1');
				$next_end = strtotime(date('Y-m-t', $next_end));
				while(date('l', $next_end) != "Sunday"){
					$next_end = $next_end + $step;
				}
				$next_start = date('c', $next_start);
				$next_end = date('c', $next_end);
				//Previous Month
				$prev_start = strtotime(date($prev_year . '-' . $prev_month . '-1'));
				while(date('l', $prev_start) != "Sunday"){
					$prev_start = $prev_start - $step;
				}
				$prev_end = strtotime($prev_year . '-' . $prev_month . '-1');
				$prev_end = strtotime(date('Y-m-t', $prev_end));
				while(date('l', $prev_end) != "Sunday"){
					$prev_end = $prev_end + $step;
				}
				$prev_start = date('c', $prev_start);
				$prev_end = date('c', $prev_end);
				$i = 0;
				$type = $wtd_plugin['specials_type'];
				foreach($month_days as $date => $events){
					$date_timemstamp = strtotime($date);
					if($i % 7 == 0 && $i != 0)
						echo '</div><div class="wtd_row">';
					$results = $events;
					$modal = '';
					if(!count($results))
						$modal = 'nomodal';
					switch($type):
						case 1:
							$images = '';
							if(!empty($results))
								$images = '<img src="' . wtd_get_image_url($results[0]->image) . '" class="main_thumb"/>';
							$events_text = count($results) . ' &nbsp;&nbsp;Specials';
							break;
						case 2:
							$images = '';
							if(!empty($results)){
								for($k = 0; $k < 4; $k ++){
									if(!empty($results[$k]))
										$images .= '<img src="' . wtd_get_image_url($results[$k]->image) . '"/>';
								}
							}
							$events_text = count($results) . ' &nbsp;&nbsp;Specials';
							break;
						case 3:
							$images = '';
							$count = count($results);
							if(!empty($results)){
								$images = '<div class="small-events">';
								$k = 0;
								foreach($results as $key => $row){
									$event_url = $post_url . $row->id . '/' . sanitize_title($row->name);
									if($k == 3)
										break;
									$images .= '<a href="' . $event_url . '">&middot; ' . $row->name . '</a>';
									$k ++;
								}
								$images .= '</div>';
							}
							$events_text = $count . ' &nbsp;&nbsp;Specials';
							if(!count($results))
								$modal = 'nomodal';
							break;
					endswitch;
					$not_month = '';
					if($month != date('m', $date_timemstamp))
						$not_month = 'not_month';?>

					<div data-i="<?php echo $i;?>" data-date="<?php echo $date_timemstamp;?>" class="day type<?php echo $type . ' ' . $not_month . ' ' . $modal;?>">
						<span class="current_date"><?php echo date('M jS', $date_timemstamp);?></span>
						<span><?php echo $events_text;?></span><?php
						echo $images;?>
					</div><?php
					if(!$modal){?>
						<div id="modal_<?php echo $i;?>" class="wtd_events_modal">
							<div class="control">
								<h2><?php echo date('l, jS F', $date_timemstamp); ?></h2>
								<a href="javascript:void(0);">X</a>
							</div>
							<div class="contents">
								<div class="wtd_row"><?php
									$j = 0;
									foreach($results as $row){
										$event_url = $post_url . $row->id . '/' . sanitize_title($row->name);
										if($j % 5 == 0 && $j != 0)
											echo '</div><div class="wtd_row">';?>
										<a href="<?php echo $event_url;?>" title="<?php echo $row->name;?>">
											<img src="<?php echo wtd_get_image_url($row->image);?>" alt="<?php echo $row->name;?>"/>
											<span class="wtd_event_modal"><?php echo $row->name;?>
											<br/><?php echo $row->vendor;?></span>
										</a><?php
										$j++;
									}?>
								</div>
							</div>
						</div><?php
					}
					$i++;
				}?>
            </div><?php
			$html = ob_get_clean();
			$return = array(
				'html' => $html,
				'prev_month' => $prev_month,
				'prev_year' => $prev_year,
				'prev_month_text' => '&laquo ' . $prev_month_name,
				'next_month' => $next_month,
				'next_year' => $next_year,
				'next_month_text' => $next_month_name . ' &raquo;',
				'curent_month' => date('F Y', $first_timestamp),
				'next_start' => $next_start,
				'next_end' => $next_end,
				'prev_start' => $prev_start,
				'prev_end' => $prev_end);
			die(json_encode($return));
		}
	}

	$wtd_parse_specials_page = new wtd_parse_specials_page();
}?>