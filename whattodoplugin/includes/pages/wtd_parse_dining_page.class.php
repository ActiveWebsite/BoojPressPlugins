<?php
use Parse\ParseQuery;

if(!class_exists('wtd_parse_dining_page')){

    class wtd_parse_dining_page{

        private $wtd_categories;

        function __construct(){
            $wtd_plugin = get_option('wtd_plugin');
            //Page Content
            if(!empty($wtd_plugin['dining-page']))
                add_action('the_content', array($this, 'page_content'), 99);
            //Ajax calls
            add_action('wp_ajax_wtd_build_dining_list', array($this, 'build_list'));
            add_action('wp_ajax_nopriv_wtd_build_dining_list', array($this, 'build_list'));
            add_filter('the_content', 'wpautop');
        }

        public function page_content($content){
			global $post;
            if(!is_singular('page') || !in_the_loop())
                return $content;
            $res_id = get_post_meta($post->ID, 'res_id', true);
            $wtd_pages = get_option('wtd_pages');
	        $page_type = get_post_meta($post->ID, 'wtd_page', true);
            if(!empty($wtd_pages['dining_pages'][$res_id]) && $page_type == 'dining_page'){
	            if(in_array($post->ID, $wtd_pages['dining_pages'])){
                    remove_filter('the_content', 'theme_formatter', 99);
                    remove_filter('the_content', 'wpautop');
		            ob_start();
                    $this->results();
		            $content = ob_get_contents();
		            ob_end_clean();
	            }
            }
            return $content;
        }

        private function results(){
			global $wp_query, $post, $wtd_plugin, $wtd_connector;
            $res_id = get_post_meta($post->ID, 'res_id', true);
	        $query = new ParseQuery("resort");
	        try{
		        $resort = $query->get($res_id);
		        // The object was retrieved successfully.
	        }catch(ParseException $ex){
		        error_log($ex->getMessage());
	        }
            $cat_id = get_query_var('wtds');
	        if(empty($cat_id) && isset($_GET['wtds']))
		        $cat_id = $_GET['wtds'];	
	        // get parent category
	        $query = new ParseQuery('resortParentCategories');
            $query->equalTo('cat_class', 'D');
            $query->equalTo('resortObjectId', $resort);
            $parent_cat = $query->find();
            $parent_cat = $parent_cat[0];
	        // get category if its set
	        if(!empty($cat_id)){
		        $query = new ParseQuery('resortCategory');
                try{
                    $cat = $query->get($cat_id);
                }catch(\Parse\ParseException $ex){
                    var_dump($ex);
                }
	        }
	        // parent restriction query
            $parent_cat_query = new ParseQuery('resortParentCategories');
            $parent_cat_query->equalTo('objectId', $parent_cat->getObjectId());
			// subcategory query
            $query = new ParseQuery('resortCategory');
            $query->matchesQuery('parentResCatObjectId', $parent_cat_query);
            $query->greaterThan('diningCnt', 0);
	        $query->ascending('name');
            $categories = $query->find();?>
	        <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_activities_page.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
	        <div ng-app="diningApp" ng-controller="diningCtrl">
		        <div layout="row" layout-sm="column" layout-padding><?php
			        if($wtd_plugin['dining_page_type'] == 3):?>
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
			        if($wtd_plugin['dining_page_type'] == 2)
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
						        $url = '/'.$wtd_plugin['url_prefix'].'/'.$post->post_name.'/whattodo/'.$category_url_name.'/'.$parent_cat->getObjectId().'/';?>
						        <span class="wtd_bread_separator">&gt;</span>
						        <a id="parent_<?php echo $parent_cat->getObjectId();?>_header" class="wtd_pull_left" href="<?php echo $url;?>"><?php
						        echo $parent_cat->get('name');?>
						        </a><?php
					        endif;
					        if($wtd_plugin['dining_page_type'] == 2){?>
						        <span class="wtd_bread_separator">&gt;</span>
						        <select class="wtd_subcategory_navigator">
							        <option>Select Subcategory</option><?php
							        for($i = 0; $i < count($categories); $i++){
								        $category = $categories[$i];
								        $category_url_name = strtolower($parent_cat->get('name'));
								        $category_url_name = str_replace(' ', '-', $category_url_name);
								        $category_url_name = str_replace('/', '-', $category_url_name);
								        $subcategory_url_name = strtolower($category->get('name'));
								        $subcategory_url_name = str_replace(' ', '-', $subcategory_url_name);
								        $subcategory_url_name = str_replace(',', '', $subcategory_url_name);
								        $subcategory_url_name = str_replace('/', '-', $subcategory_url_name);
								        $url = '/'.$post->post_name.'/whattodo/'.$category_url_name.'/'.$parent_cat->getObjectId().'/'.$subcategory_url_name.'/'.$category->getObjectId().'/';
								        $selected = '';
								        if($cat_id == $category->getObjectId())
									        $selected = ' selected="selected"';
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
				        <div layout="row" layout-align="center center" ng-hide="progress == false" layout-padding>
					        <md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
				        </div>
				        <div id="wtd_listing_sc_container" layout="column" layout-align="start start"></div>
			        </div>
		        </div>
	        </div><?php
            $wtd_base_request = $wtd_connector->get_base_request();
            $wtd_base_request['resorts'] = array($res_id);
            $wtd_base_request['page'] = 1;
            $subcat_id = "";
	        if(!empty($cat))
                $subcat_id = $cat->getObjectId();
            if(!empty($subcat_id))
                $wtd_base_request['category_id'] = $subcat_id;?>
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
	        <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/pages/dining.js"></script><?php
            wtd_copyright();
        }

        public function build_list(){
            global $wtd_connector, $wtd_plugin;
            $data = $wtd_connector->decrypt_parse_response($_POST['data']);
            ob_start();
            if(!empty($data)):
                $dining = $data;				
                foreach($dining as $key => $dining):
                    if(!empty($dining->addresses))
                        $addresses = $dining->addresses;
                    if(!empty($dining->vendor))
                        $vendor = $dining->vendor;
                    $dining_url = '/'.$wtd_plugin['url_prefix'].'/dining/'.$dining->id.'/'.sanitize_title($dining->title).'/';?>
                    <div class="wtd_listing_container wtd_parse_result md-whiteframe-z2" layout="column">
                        <div><?php
                            $title = '<span class="wtd_listing_title">'.$dining->title.'</span>';
                            if(!empty($dining->title) && !empty($vendor) && !substr_count($title, $vendor))
                                $title .= ' - <span class="wtd_listing_vendor">'.$vendor.'</span>';
                            elseif(empty($dining->title) && !substr_count($title, $vendor))
                                $title .= '<span class="wtd_listing_vendor">'.$vendor.'</span>';?>
	                        <div layout="row" layout-sm="column" class="wtd_listing_title_bar" layout-align="center start"><?php
		                        if($dining->vend_rec_type == 'wfree'){
			                        echo $title;
		                        }else{?>
			                        <a href="<?php echo $dining_url;?>"><?php echo $title;?></a><?php
		                        }?>
	                        </div>
                            <div layout="row" offset="3" layout-sm="column" layout-align="center start" layout-padding><?php
                                if(!empty($dining->logoUrl) && $dining->vend_rec_type != 'wfree'){?>
                                    <div flex="20" flex-sm="100" class="wtd_listing_sc_imageArea">
                                        <a href="<?php echo $dining_url;?>">
                                            <img src="<?php echo $dining->logoUrl;?>" alt="<?php echo $dining->title;?>" layout-padding />
                                        </a>
                                    </div><?php
                                }?>
                                <div flex="75" flex-sm="100" layout-padding layout="column"><?php
                                    if($dining->vend_rec_type != 'wfree'){
                                        echo "<div>";
                                        $desc = strip_tags($dining->description);
                                        wtd_excerpt_generator($desc, false, $dining_url);
                                        echo "</div>";
                                    }
                                    if(!empty($addresses)):
                                    if(count($addresses) == 1):
                                        $address = $addresses[0];?>
                                        <div><?php
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
                                        <div><?php echo $address;?></div><?php
                                    endif;
                                endif;?>
                                </div>
                            </div>
                        </div>
                    </div><?php
                    endforeach;
            else:?>
                No listings of this type are available.<?php
            endif;
                if($_POST['page'] != 1):?>
                    <a href="javascript:void(0)" class="wtd_pull_left" id="wtd_parse_prev">&laquo; Previous</a><?php
                endif;
                if(count($data) == 10):?>
                    <a href="javascript:void(0)" class="wtd_pull_right" id="wtd_parse_next">Next &raquo;</a><?php
                endif;
            die();
        }
    }
    $wtd_parse_dining_page = new wtd_parse_dining_page();
}?>