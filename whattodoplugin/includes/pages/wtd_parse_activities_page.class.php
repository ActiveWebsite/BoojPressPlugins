<?php
use Parse\ParseQuery;
use Parse\ParseException;

if(!class_exists('wtd_parse_activities_page')){

    class wtd_parse_activities_page{

        private $wtd_categories;

        function __construct(){
            $wtd_plugin = get_option('wtd_plugin');
            //Page Content
            if(!empty($wtd_plugin['activities-page']))
                add_action('the_content', array($this, 'page_content'), 99);
            //Ajax calls
            add_action('wp_ajax_wtd_build_activities_list', array($this, 'build_list'));
            add_action('wp_ajax_nopriv_wtd_build_activities_list', array($this, 'build_list'));
            add_filter('the_content', 'wpautop');
        }

        public function page_content($content){
			global $wtd_plugin, $post, $wp_query;
            if(!is_singular('page') || !in_the_loop())
                return $content;
            $res_id = get_post_meta($post->ID, 'res_id', true);
            $wtd_pages = get_option('wtd_pages');
			$page_type = get_post_meta($post->ID, 'wtd_page', true);
            if(!empty($wtd_pages['activities_pages'][$res_id]) || $page_type == 'activity_page'){
                if(in_array($post->ID, $wtd_pages['activities_pages'])){
	                remove_filter('the_content', 'theme_formatter', 99);
	                remove_filter('the_content', 'wpautop');
	                ob_start();
		            if(empty($wp_query->query['wtdc']) && empty($_GET['wtdc']))
	                    $this->matrix();
	                elseif(!empty($wp_query->query['wtdc']) || !empty($_GET['wtdc'])){
	                    switch($wtd_plugin['act_page_type']):
	                        case 2:
	                            $this->results();
	                            break;
	                        case 3:
							default:
	                            $this->results();
	                            break;
	                    endswitch;
	                }
	                $content = ob_get_contents();
	                ob_end_clean();
	            }
            }
            return $content;
        }

        private function matrix(){
			global $post;
            $res_id = get_post_meta($post->ID, 'res_id', true);
	        $query = new ParseQuery("resort");
	        try{
		        $resort = $query->get($res_id);
	        }catch(ParseException $ex){
		        error_log($ex->getMessage());
	        }

	        $query = new ParseQuery('resortParentCategories');
	        $query->equalTo('deleted', false);
	        $query->containedIn('cat_class', ['A', 'R']);
			$query->equalTo('resortObjectId', $resort);
	        $query->greaterThan("activityCnt", 0);
			$query->ascending('name');
	        try{
		        $parent_cats = $query->find();
	        }catch(ParseException $ex){
		        error_log($ex->getMessage());
	        }?>
            <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL."assets/css/styles/wtd_menu.css?wtd_version=".WTD_VERSION;?>" media="screen"/>
	        <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL."assets/css/styles/masonry.css?wtd_version=".WTD_VERSION;?>" media="screen"/>
            <div id="wtd_parent_menu" class="grid">
	            <div class="masonry-column-width"></div><?php
                for($i = 0; $i < count($parent_cats); $i++){
	                $parent_cat = $parent_cats[$i];
	                $url = '/'.$post->post_name.'/whattodo/'.strtolower($parent_cat->get('name')).'/'.$parent_cat->getObjectId().'/';
                    //if($image):?>
                        <div class="masonry-entry">
	                        <div class="masonry-thumbnail">
	                            <a href="<?php echo $url;?>" title="<?php echo $parent_cat->get('name');?>">
	                                <img src="<?php echo WTD_IMG_BASE.$parent_cat->get('cat_img');?>" class="masonry-thumb"/>
	                            </a>
	                        </div>
	                        <div class="masonry-details">
	                            <h5>
	                                <a href="<?php echo $url;?>" title="<?php echo $parent_cat->get('name');?>">
		                                <span class="masonry-post-title"><?php echo $parent_cat->get('name');?></span>
	                                </a>
	                            </h5>
	                        </div>
                        </div><?php
                    //endif;
                }?>
            </div>
	        <script type="text/javascript">
		        jQuery(document).ready(function(){
			        var grid = jQuery('.grid').masonry({
				        // options
				        itemSelector: '.masonry-entry',
				        columnWidth: '.masonry-column-width',
				        percentPosition: true,
				        gutter: 10
			        });
			        // layout Masonry after each image loads
			        grid.imagesLoaded().progress(function(){
				        grid.masonry('layout');
			        });
		        });
			</script><?php
            wtd_copyright();
        }

        private function results(){
			global $wp_query, $post, $wtd_plugin, $wtd_connector;
            $res_id = get_post_meta($post->ID, 'res_id', true);
            $parent_cat_id = get_query_var('wtdc');
            $cat_id = get_query_var('wtds');
	        $excluded_cats = json_decode(get_option('wtd_excluded_cats'));
	        if(empty($cat_id) & isset($_GET['wtds']))
		        $cat_id = $_GET['wtds'];
	        // get parent category
	        $query = new ParseQuery('resortParentCategories');
            $parent_cat = $query->get($parent_cat_id);
	        // get category if its set
	        if(!empty($cat_id)){
		        $query = new ParseQuery('resortCategory');
		        $cat = $query->get($cat_id);
	        }
	        // parent restriction query
            $parent_cat_query = new ParseQuery('resortParentCategories');
            $parent_cat_query->equalTo('objectId', $parent_cat_id);
			// subcategory query
            $query = new ParseQuery('resortCategory');
            $query->matchesQuery('parentResCatObjectId', $parent_cat_query);
	        $query->equalTo('deleted',false);
			$query->greaterThan('activityCnt', 0);
	        if(!empty($excluded_cats))
	            $query->notContainedIn('objectId', $excluded_cats);
	        $query->ascending('name');
	        try{
		        $categories = $query->find();
	        }catch(\Parse\ParseException $ex){
		        var_dump($ex);
	        }?>
            <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_activities_page.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
	        <div ng-app="activitiesApp" ng-controller="activitiesCtrl">
	            <div layout="row" layout-sm="column" layout-padding><?php
	                if($wtd_plugin['act_page_type'] == 3):?>
	                    <ul layout="column"><?php
		                    for($i = 0; $i < count($categories); $i++):
		                        $category = $categories[$i];
			                    $category_url_name = strtolower($parent_cat->get('name'));
			                    $category_url_name = str_replace(' ', '-', $category_url_name);
		                        $category_url_name = str_replace('/', '-', $category_url_name);
			                    $subcategory_url_name = strtolower($category->get('name'));
			                    $subcategory_url_name = str_replace(' ', '-', $subcategory_url_name);
			                    $subcategory_url_name = str_replace(',', '', $subcategory_url_name);
			                    $subcategory_url_name = str_replace('/', '-', $subcategory_url_name);
			                    $url = '/'.$post->post_name.'/whattodo/'.$category_url_name.'/'.$parent_cat->getObjectId().'/'.$subcategory_url_name.'/'.$category->getObjectId().'/';?>
		                        <li class="wtd_subcategory_menu_item <?php echo ($category->getObjectId() == $wp_query->query['wtds']) ? 'active' : '';?>">
		                            <a href="<?php echo $url;?>"><?php echo $category->get('name');?></a>
		                        </li><?php
		                    endfor;?>
	                    </ul><?php
	                endif;
		            if($wtd_plugin['act_page_type'] == 2)
		                $column_size = 100;
		            else
		                $column_size = 75;?>
	                <div layout="row" layout-align="center start" ng-hide="progress == false" layout-padding flex="100">
		                <md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
	                </div>
	                <div layout="column" flex="<?php echo $column_size;?>" flex-sm="100" ng-hide="progress == true">
	                    <div layout="row" style="margin-bottom: 5px;">
		                    <a id="parent_<?php echo $post->ID;?>_header" href="<?php echo get_post_permalink($post->ID);?>" class="wtd_pull_left"><?php
		                        echo $post->post_title;?>
		                    </a><?php
		                    if(!empty($parent_cat_id)):
			                    $category_url_name = strtolower($parent_cat->get('name'));
			                    $category_url_name = str_replace(' ', '-', $category_url_name);
			                    //http://realty.home/vail-valley-activities/whattodo/spa-&-fitness/ZUNm0C89zy/fitness-centers/QoljJWroB8/
			                    $url = '/'.$post->post_name.'/whattodo/'.$category_url_name.'/'.$parent_cat->getObjectId().'/';?>
			                    <span class="wtd_bread_separator">&gt;</span>
			                    <a id="parent_<?php echo $parent_cat->getObjectId();?>_header" class="wtd_pull_left" href="<?php echo $url;?>"><?php
			                        echo $parent_cat->get('name');?>
			                    </a><?php
		                    endif;
	                        if($wtd_plugin['act_page_type'] == 2){?>
		                        <span class="wtd_bread_separator">&gt;</span>
		                        <select class="wtd_subcategory_navigator">
			                        <option>Select Subcategory</option><?php
			                        for($i = 0; $i < count($categories); $i ++){
				                        $category = $categories[$i];
				                        $selected = '';
				                        if($cat_id == $category->getObjectId())
					                        $selected = ' selected="selected"';
				                        $category_url_name = strtolower($parent_cat->get('name'));
				                        $category_url_name = str_replace(' ', '-', $category_url_name);
				                        $category_url_name = str_replace('/', '-', $category_url_name);
				                        $subcategory_url_name = strtolower($category->get('name'));
				                        $subcategory_url_name = str_replace(' ', '-', $subcategory_url_name);
				                        $subcategory_url_name = str_replace(',', '', $subcategory_url_name);
										$subcategory_url_name = str_replace('/', '-', $subcategory_url_name);
				                        $url = '/'.$post->post_name.'/whattodo/'.$category_url_name.'/'.$parent_cat->getObjectId().'/'.$subcategory_url_name.'/'.$category->getObjectId().'/';
				                        echo '<option value="'.$url.'" '.$selected.'>'.$category->get('name').'</option>';
			                        }?>
		                        </select><?php
	                        }elseif(!empty($cat_id)){?>
			                    <span class="wtd_bread_separator">&gt;</span>
			                    <span class="wtd_current_cat"><?php echo $cat->name;?></span><?php
		                    }?>
	                    </div>
	                    <script>
	                        jQuery('.wtd_subcategory_navigator').change(function(){
	                            var val = jQuery('.wtd_subcategory_navigator option:selected').val();
	                            if(val)
	                                window.location = val;
	                        });
	                    </script>
	                    <div id="wtd_listing_sc_container" layout="column" layout-align="start start"></div>
	                </div>
	            </div>
            </div><?php
            $wtd_base_request = $wtd_connector->get_base_request();
            $wtd_base_request['resorts'] = array($res_id);
            $wtd_base_request['page'] = 1;
            $cat_id = $wp_query->query['wtdc'];
            if(empty($cat_id) && isset($_GET['wtdc']))
               $cat_id = $_GET['wtdc'];
			if(isset($wp_query->query['wtds']))
            	$subcat_id = $wp_query->query['wtds'];
			else
				$subcat_id = NULL;
            if(empty($subcat_id) && isset($_GET['wtds']))
                $subcat_id = $_GET['wtds'];
            $wtd_base_request['category_id'] = $cat_id;
            if(!empty($subcat_id))
                $wtd_base_request['category_id'] = $subcat_id;
            $wtd_excluded_cats = get_option('wtd_excluded_cats');
	        if(!empty($wtd_excluded_cats))
                $wtd_base_request['excluded_categories'] = json_decode($wtd_excluded_cats);?>
            <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
            <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse_init.js"></script>
            <script>
                var wtd_categories = <?php echo json_encode($this->wtd_categories);?>;
                var wtd_base_request = <?php echo json_encode($wtd_base_request);?>;
                var cat_id = '<?php echo $cat_id;?>';
                var subcat_id = '<?php echo $subcat_id;?>';
                var wtd_parse_page = 1;
                var cur_category = '<?php echo $cat_id;?>';
            </script>
	        <script src="<?php echo WTD_PLUGIN_URL;?>assets/js/pages/activities.js"></script><?php
            wtd_copyright();
        }

        public function build_list(){
            global $wtd_connector, $wtd_plugin;
            $data = $wtd_connector->decrypt_parse_response($_POST['data']);
            ob_start();
            if(!empty($data)):
                $activities = $data;
                foreach($activities as $key => $activity):
                    if(!empty($activity->addresses))
                        $addresses = $activity->addresses;
                    if(!empty($activity->vendor))
                        $vendor = $activity->vendor;
                    $activity_url = '/'.$wtd_plugin['url_prefix'].'/activity/'.$activity->id.'/'.sanitize_title($activity->title).'/';?>
                    <div class="wtd_listing_container wtd_parse_result md-whiteframe-z2" layout="column"><?php
                        $title = '<span class="wtd_listing_title">'.$activity->title.'</span>';
                        if(!empty($title) && !empty($vendor) && !substr_count($title, $vendor))
                            $title .= ' - <span class="wtd_listing_vendor">'.$vendor.'</span>';
                        elseif(empty($title) && !substr_count($title, $vendor))
                            $title .= '<span class="wtd_listing_vendor">'.$vendor.'</span>';?>
                        <div layout="row" layout-sm="column" class="wtd_listing_title_bar" layout-align="center start"><?php
							if($activity->vend_rec_type == 'wfree'){
								echo $title;
							}else{?>
                            	<a href="<?php echo $activity_url;?>"><?php echo $title;?></a><?php
							}?>	
                        </div>
	                    <div layout="row" offset="3" layout-sm="column" layout-align="center start" layout-padding><?php
                            if(!empty($activity->thumbUrl) && $activity->vend_rec_type != 'wfree'){?>
                                <div flex="20" flex-sm="100" class="wtd_listing_sc_imageArea">
                                    <a href="<?php echo $activity_url;?>">
                                        <img src="<?php echo $activity->thumbUrl;?>" alt="<?php echo $activity->title; ?>" layout-padding />
                                    </a>
                                </div><?php
                            }?>
	                        <div flex="75" flex-sm="100" layout-padding layout="column"><?php
								if($activity->vend_rec_type != 'wfree'){
	                            	echo "<div>";
	                                $desc = strip_tags($activity->description);
	                                wtd_excerpt_generator($desc, false, $activity_url);
	                            	echo "</div>";
								}
	                            if(!empty($addresses)):
	                                if(count($addresses) == 1):
	                                    $address = $addresses[0];?>
	                                    <div flex><?php
	                                        $display_address = '';
	                                        if(!empty($address->address))
	                                            $street = $address->address;
	                                        if(!empty($street))
	                                            $display_address .= $street;
	                                        if(!empty($address->city))
	                                            $city = $address->city;
	                                        if(!empty($city)){
	                                            if(!$display_address)
	                                                $display_address .= $city;
	                                            else
	                                                $display_address .= ' in ' . $city;
	                                        }
	                                        if(!empty($address->state))
	                                            $state = $address->state;
	                                        if(!empty($state)){
	                                            if(empty($display_address))
	                                                $display_address .= $state;
	                                            else
	                                                $display_address .= ', ' . $state;
	                                        }
	                                        if(!empty($address->phone))
	                                            $phone = $address->phone;
	                                        if(!empty($phone))
	                                            $display_address .= " (" . substr($phone, 0, 3) . ") " . substr($phone, 3, 3) . "-" . substr($phone, 6);
	                                        else
	                                            $display_address .= '';
	                                        echo $display_address;?>
	                                    </div><?php
	                                else:
										$locations = array();
	                                    foreach($addresses as $add){
	                                        if(!empty($add->location)){
	                                            if(!in_array(ucfirst($add->location), $locations))
	                                                $locations[] = ucfirst($add->location);
	                                        }elseif(!empty($add->city)){
	                                            if(!in_array(ucfirst($add->city), $locations))
	                                                $locations[] = ucfirst($add->city);
	                                        }
	                                    }
	                                    $address = 'Various Locations in '.implode(', ', $locations);?>
	                                    <div flex><?php echo $address;?></div><?php
									endif;
	                            endif;?>
                            </div>
                        </div>
                    </div><?php
                endforeach;
            else:?>
                No listings of this type are available.<?php
            endif;
		    if($_POST['page'] != 1){?>
	            <a href="javascript:void(0)" id="wtd_parse_prev">&laquo; Previous</a><?php
            }
            if(count($data) == 10){?>
	            <a href="javascript:void(0)" id="wtd_parse_next" style="float:right;">Next &raquo;</a><?php
            }
            die();
        }
    }
    $wtd_parse_activities_page = new wtd_parse_activities_page();
}?>