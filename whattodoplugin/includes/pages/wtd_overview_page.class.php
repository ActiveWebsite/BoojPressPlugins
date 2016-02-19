<?php
use Parse\ParseQuery;

if(!class_exists('wtd_parse_overview_page')){

    class wtd_parse_overview_page{

        private $wtd_categories;

        function __construct(){
            $wtd_plugin = get_option('wtd_plugin');
            //Page Content
            if(!empty($wtd_plugin['overview-page']))
                add_action('the_content', array($this, 'page_content'), 99);

            add_filter('the_content', 'wpautop');
        }

        public function page_content($content){
	        global $wtd_plugin, $post;
	        if(!is_singular('page') || !in_the_loop())
		        return $content;
	        $wtd_pages = get_option('wtd_pages');
	        $page_type = get_post_meta($post->ID, 'wtd_page', true);
	        $res_id = $wtd_plugin['wtd_resorts'][0];
	        $resort_query = new ParseQuery('resort');
	        $resort_query->equalTo('objectId', $res_id);
	        $results = array();
	        if(!empty($wtd_pages['activities_pages'])){
		        $activity_query = new ParseQuery('activity');
	            $activity_query->matchesQuery('resortObjectId', $resort_query);
		        $activity_query->includeKey('vendorObjectId');
		        $activity_query->skip(15);
		        $activity_query->limit(6);
		        $activity_results = $activity_query->find();
		        for($i = 0; $i < count($activity_results); $i++){
			        $result = $activity_results[$i];
			        $results[] = array('type' => 'activity', 'wtd_item' => $result);
		        }
            }
	        if(!empty($wtd_pages['calendar_pages'])){
		        $event_query = new ParseQuery('event');
		        $event_query->matchesQuery('resortObjectId', $resort_query);
		        $event_query->includeKey('vendorObjectId');
		        $event_query->limit(6);

		        $event_results = $event_query->find();
		        for($i = 0; $i < count($event_results); $i++){
			        $result = $event_results[$i];
			        $results[] = array('type' => 'event', 'wtd_item' => $result);
		        }
	        }
	        if(!empty($wtd_pages['coupons_pages'])){
		        $coupon_query = new ParseQuery('coupon');
		        $coupon_query->matchesQuery('resortObjectId', $resort_query);
		        $coupon_query->includeKey('vendorObjectId');
		        $coupon_query->limit(6);

		        $coupon_results = $coupon_query->find();
		        for($i = 0; $i < count($coupon_results); $i++){
			        $result = $coupon_results[$i];
			        $results[] = array('type' => 'coupon', 'wtd_item' => $result);
		        }
	        }
            if(!empty($page_type == 'overview_page') && $post->ID == $wtd_pages['overview_page']){
	            ob_start();?>
	            <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL."assets/css/styles/masonry.css?wtd_version=".WTD_VERSION;?>" media="screen"/>
                <div ng-app="overviewApp" ng-controller="overviewCtrl" style="margin-bottom: 10px;">
		            <div class="grid">
			            <div class="masonry-column-width"></div><?php
			            shuffle($results);  // randomize the array before display
//			            $last_idx = count($results) - 1;
//			            unset($results[$last_idx]);
//			            unset($results[$last_idx - 1]);
		                for($i = 0; $i < count($results); $i++){
			                $wtd_item = $results[$i]['wtd_item'];
			                $wtd_item_type = $results[$i]['type'];
			                switch($wtd_item_type){
				                case 'activity':
					                $query = $wtd_item->imageRelation->getQuery();
					                $query->limit(1);
					                $images = $query->find();
					                $image_url = $images[0]->imageUrl;
					                $url = '/'.$wtd_plugin['url_prefix'].'/'.$wtd_item_type.'/'.$wtd_item->getObjectId().'/'.sanitize_title($wtd_item->name).'/';
					                break;
				                case 'coupon':
									$image_url = $wtd_item->vendorObjectId->logoUrl;
					                $url = '/'.$wtd_plugin['url_prefix'].'/'.$wtd_item_type.'/'.$wtd_item->getObjectId().'/'.sanitize_title($wtd_item->name).'/';
					                break;
				                case 'event':
									$name = $wtd_item->name;
									if(!empty($wtd_item->title))
										$name = $wtd_item->title;
				                    $url = '/'.$wtd_plugin['url_prefix'].'/'.$wtd_item_type.'/'.$wtd_item->getObjectId().'/'.sanitize_title($name).'/';
					                break;
				                default:
					                break;
			                }?>
			                <div class="masonry-entry md-whiteframe-z2" onclick="window.location.assign('<?php echo $url;?>');"><?php
				                if($wtd_item_type != 'coupon'){?>
					                <div class="header"><?php
					                    echo $wtd_item->vendorObjectId->displayName; ?>
					                </div><?php
				                }?>
				                <div><?php
					                switch($wtd_item_type){
						                case 'coupon':?>
											<img src="<?php echo $image_url;?>" style="max-width: 60px;width: 60px;"/>
											<div style="float:right;">
							                    <span style="font-size:12px;font-style:italic;padding: 10px;"><?php echo $wtd_item->title;?></span>
											</div><?php
							                break;
						                case 'activity':
							                echo '<img src="'.$image_url.'" style="max-width: 90%;max-height: 80%;"/>';
							                break;
						                case 'event':
							                echo '<span>'.$wtd_item->eventDate->format('m-d-Y').'</span>';
							                break;
					                }?>
				                </div><?php
				                if($wtd_item_type != 'coupon'){?>
					                <div><?php
					                    echo $wtd_item->name;?>
					                </div><?php
				                }?>
			                </div><?php
		                }?>
		            </div>
                </div>
	            <script type="text/javascript" src="<?php echo WTD_PLUGIN_URL;?>assets/js/single_pages/overview.js"></script><?php
	            $content = ob_get_contents();
	            ob_end_clean();
//                remove_filter('the_content', 'theme_formatter', 99);
//                remove_filter('the_content', 'wpautop');
            }
            return $content;
        }
    }
    $wtd_parse_overview_page = new wtd_parse_overview_page();
}?>