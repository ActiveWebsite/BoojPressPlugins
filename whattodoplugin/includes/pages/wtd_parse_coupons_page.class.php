<?php
use Parse\ParseQuery;

if(!class_exists('wtd_parse_coupons_page')){

    class wtd_parse_coupons_page{

        function __construct(){
            $wtd_plugin = get_option('wtd_plugin');
            //Page Content
            if(!empty($wtd_plugin['coupons-page']))
                add_action('the_content', array($this, 'page_content'), 99);
            //Ajax calls
            add_action('wp_ajax_wtd_build_coupons_list', array($this, 'build_list'));
            add_action('wp_ajax_nopriv_wtd_build_coupons_list', array($this, 'build_list'));
            add_filter('the_content', 'wpautop');
        }

        public function page_content($content){
			global $wtd_plugin, $post, $wp_query;
            if(!is_singular('page') || !in_the_loop())
                return $content;
            $res_id = get_post_meta($post->ID, 'res_id', true);
	        $page_type = get_post_meta($post->ID, 'wtd_page', true);
            $wtd_pages = get_option('wtd_pages');
			//if(!empty($wtd_pages['coupons_pages'][$res_id] && $page_type == 'coupons_page')){
            if(!empty($wtd_pages['coupons_pages'] && $page_type == 'coupons_page')){
                if(in_array($post->ID, $wtd_pages['coupons_pages'])){
                    remove_filter('the_content', 'theme_formatter', 99);
                    remove_filter ('the_content', 'wpautop', 99);
                    $content = '<div ng-app="couponsApp" ng-controller="couponsCtrl">';
                    $content .= $this->results($content, $res_id);
                    $content .= '</div>';
                }else
                    add_filter('the_content', 'wpautop');
            }
            return $content;
        }

        private function results($content, $res_id){
			global $wtd_connector;
            ob_start();?>
	        <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_frontend.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
            <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_coupons_page.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
            <div layout="row" layout-align="center center" ng-hide="progress == false" layout-padding>
                <md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
            </div>
            <div id="wtd_coupon_sc_container" layout="column" layout-align="center center" ng-hide="progress == true"></div><?php
            $wtd_base_request = $wtd_connector->get_base_request();
            $wtd_base_request['resorts'] = array($res_id);
            $wtd_base_request['page'] = 1;?>
	    <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse-1.6.14.js"></script>
            <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse_init.js"></script>
            <script>
                var wtd_base_request = <?php echo json_encode($wtd_base_request);?>;
                var wtd_parse_page = 1;
            </script>
	        <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/pages/coupons.js"></script><?php
            wtd_copyright();
            $content = ob_get_clean();
            return $content;
        }

        public function build_list(){
            global $wtd_connector, $wtd_plugin;
            if($wtd_plugin['start_url'] == 2 || empty($wtd_plugin['start_url']))
                $start_url = site_url();
            else
                $start_url = home_url();

            $coupons = $wtd_connector->decrypt_parse_response($_POST['data']);
            ob_start();
            if(!empty($coupons)):
                $i = 0;
                foreach($coupons as $key => $coupon){?>
                    <div layout="column" class="md-whiteframe-z1 layout-padding layout-margin" style="max-width:600px;">
                        <div layout="row">
                            <div flex="70" flex-sm="100">
                                <a href="<?php echo $start_url. '/' . $wtd_plugin['url_prefix'] . '/coupon/' . $coupon->id; ?>">
                                    <span class="business"><?php echo htmlspecialchars_decode($coupon->title)." by ".htmlspecialchars_decode($coupon->vendor);?></span><br />
                                    <?php echo htmlspecialchars_decode($coupon->offer);?>
                                </a>
	                        </div>
                            <div flex="30" hide-sm layout="row" layout-align="center start">
                                <img src="<?php echo $coupon->logoUrl; ?>" alt="Vendor Image" style="max-height:100%;max-width:100%;width:100px;"/>
                            </div>
						</div><?php
                        if(!empty($coupon->couponCode)){?>
                            <div layout="row" layout-sm="column" flex>
								<span flex>Expires: <?php echo date('m/d/Y', strtotime($coupon->expireDate)); ?></span>
								<span flex>Code: <?php echo $coupon->couponCode; ?></span>
							</div><?php
                        }else{?>
                        	<div>
								<span flex>Expires <?php echo date('m/d/Y', strtotime($coupon->expireDate)); ?></span>
							</div><?php
						}?>	
						<div>
							<!--googleoff:index-->
							<span class="disclaimer" flex>Coupon Disclaimer: Print as many coupons as you want. Copyright &copy; What To Do <?php echo date("Y") ?> Unless stated coupon offers have no cash value, are subject to change, may have blackout dates, may contain errors & omissions, do not apply to sale items, cannot be used with other special offers or discounts & are one per person (no group orders).Check usage with merchant & present coupon before purchase.</span>
							<!--googleon:index-->
                        </div>
                    </div><?php
                    $i++;
                }
            else:?>
                No listings of this type are available.<?php
            endif;
                if($_POST['page'] != 1):?>
                    <a href="javascript:void(0)" class="wtd_pull_left" id="wtd_parse_prev">&laquo; Previous</a><?php
                endif;
                if(count($coupons) == 10):?>
                    <a href="javascript:void(0)" class="wtd_pull_right" id="wtd_parse_next">Next &raquo;</a><?php
                endif;
            die();
        }
    }
    $wtd_parse_coupons_page = new wtd_parse_coupons_page();
}?>