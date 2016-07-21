<?php

if(!class_exists('wtd_parse_single_coupon')){
    class wtd_parse_single_coupon{

        public $disclaimer;

        public function __construct(){
            add_action('the_content', array($this, 'coupon_content'), 99);
            //Ajax calls
            add_action('wp_ajax_wtd_build_coupon', array($this, 'build_content'));
            add_action('wp_ajax_nopriv_wtd_build_coupon', array($this, 'build_content'));
	        add_action('wp_ajax_wtd_mail_coupon', array($this, 'mail_coupon'));
	        add_action('wp_ajax_nopriv_wtd_mail_coupon', array($this, 'mail_coupon'));
	        $this->disclaimer = 'Coupon Disclaimer: Print as many coupons as you want. Copyright &copy; What to Do '.date('Y', time()).' Unless stated coupon offers have no cash value, are subject to change, may have blackout dates, may contain errors & omissions, do not apply to sale items, cannot be used with other special offers or discounts & are one per person (no group orders).Check usage with merchant & present coupon before purchase.';
        }

        public function coupon_content($content){
            global $wpdb, $post, $wtd_plugin, $wtd_connector, $wp_query;
            if(!is_singular('wtd_coupon') || !in_the_loop())
                return $content;
            if($post->post_type == 'wtd_coupon'){
                remove_filter('the_content', 'theme_formatter', 99);
                remove_filter('the_content', 'wpautop', 99);
	            $query = "SELECT
								p.post_name
							FROM
								wp_posts p,
								wp_postmeta pm
							WHERE
								pm.post_id = p.ID
							AND pm.meta_value = 'coupons_page'
							AND	p.post_type = 'page'";
	            $coupons_page = $wpdb->get_var($query);
	            $coupons_page = site_url().'/'.$wtd_plugin['url_prefix'].'/'.$coupons_page.'/';
                ob_start();?>
	            <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/coupon_print.css?wtd_version='.WTD_VERSION;?>" media="print"/>
            	<link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL.'assets/css/wtd_coupons_page.css?wtd_version='.WTD_VERSION;?>" media="screen"/>
	            <div ng-app="couponApp" ng-controller="couponCtrl">
		            <div class="coupon-header" layout="row" layout-align="space-between start">
			            <a href="javascript: history.go(-1);">Back to Coupons List</a>
			            <a href="javascript:sendEmail();">Email</a>
			            <a href="javascript:window.print();">Print</a>
		            </div>
		            <div layout="row" layout-align="center center" ng-hide="progress == false" layout-padding>
			            <md-progress-circular class="md-primary" md-mode="indeterminate"></md-progress-circular>
		            </div>
	                <div id="wtd_coupon_sc_container" ng-hide="progress == true">
	                    <div class="wtd_single_coupon_container" id="wtd_parse_content"></div>
	                </div>
	            </div><?php
                wtd_copyright();
                $base_request = $wtd_connector->get_base_request();
                $base_request['coupon_id'] = $wp_query->query['wtd_parse_id'];?>
                <script src="//www.parsecdn.com/js/parse-1.3.5.min.js"></script>
                <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/parse_init.js"></script>
                <script>
                    var wtd_base_request = <?php echo json_encode($base_request);?>;
                </script>
	            <script src="<?php echo WTD_PLUGIN_URL;?>/assets/js/single_pages/coupon.js"></script><?php
                $content = ob_get_clean();
            }
            return $content;
        }

        public function build_content(){
            global $wtd_connector;
            $encrypted_data = $_POST['data'];
            $data = $wtd_connector->decrypt_parse_response($encrypted_data);
            $coupon = $data->coupon;
            if(!empty($data->addresses))
                $addresses = $data->addresses;
            $vendor = $data->vendor;
	        ob_start();?>
            <div layout="column" layout-padding>
	            <div layout="row" layout-align="center center" layout-margin layout-padding>
		            <div layout="column" flex layout-margin layout-padding>
						<span style="font-size:x-large;"><?php
							echo $coupon->title.' by '.$vendor->displayName.'</span><br/><span style="font-size:large;">'.$coupon->offer;?>
						</span>
		            </div>
                    <img class="coupon-logo" src="<?php echo $coupon->logoUrl;?>" />
	            </div>
	            <div layout="column" layout-padding>
					<div layout="row">						
							<span flex>Expires: <?php echo date('m/d/Y', strtotime($coupon->expireDate->iso)); ?></span><?php
							if(!empty($coupon->couponCode)){?>
                                <span flex>Code: <?php echo $coupon->couponCode; ?></span><?php
                            }?>
                	</div><?php
				
	                if(!empty($addresses)){?>
		                <div>
			                Locations:
						</div><?php
	                    foreach($addresses as $address){?>
                            <div><?php
                                $location_display = $address->address;
                                if(!empty($location_display) && !empty($address->city))
                                    $location_display .= ', ' . $address->city;
                                elseif(!empty($address->city))
                                    $location_display = $address->city;
                                if(!empty($address->state))
                                    $location_display .= ', ' . $address->state;
                                if(!empty($address->postalCode))
                                    $location_display .= ' ' . $address->postalCode;
                                //if(!empty($address->phone))
                                //    $location_display .= ' Tel. <a href="callto://'.$address->phone.'">(' . substr($address->phone,0,3).') '.substr($address->phone,3,3).'-'.substr($address->phone,6,4).'</a>';
                               	if(!empty($address->geoLocation) && $address->geoLocation->latitude != 0 && $address->geoLocation->longitude != 0 )
                                    $location_display .= ' -  <a class="wtd_direction_link" target="_blank" href="https://maps.google.com/?saddr=Current+Location%&daddr=' . $address->geoLocation->latitude . ',' . $address->geoLocation->longitude . '">View Directions</a>';
                        		if(!empty($address->phone))
                                    $location_display .= '<br /> Tel. <a href="tel:'.$address->phone.'">(' . substr($address->phone,0,3).') '.substr($address->phone,3,3).'-'.substr($address->phone,6,4).'</a>';
								echo $location_display;?>
							</div><?php
                        }
	                }
		        	if(!empty($coupon->website)){?>
						<div><?php
         					$listing_web = $coupon->website;
							$web_coup_url = (substr_count($listing_web, 'http://')) ? $listing_web : 'http://' . $listing_web;?>
		            		Website:<a href="<?php echo $web_coup_url;?>" target="_blank"> <?php echo $listing_web;?></a>
						</div><?php
					}?>
				</div>	
		        <div class="expireBig"><?php
					echo $this->disclaimer;?>
	            </div>
            </div><?php
	        $content = ob_get_contents();
	        ob_end_clean();
	        $response['content'] = $content;
	        $response['coupon_id'] = $coupon->objectId;
	        $response['data'] = $encrypted_data;
	        echo json_encode($response, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_NUMERIC_CHECK);
            die();
        }

	    public function email($data){
	        $coupon = $data->coupon;
	        $vendor = $data->vendor;?>
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                    <title>Print <?php $coupon->title; ?></title>
                    <link rel="stylesheet" href="<?php echo WTD_PLUGIN_URL."assets/css/wtd_coupons_page.css"; ?>"/>
                </head>
                <body id="wtd-print-coupon">
                    <table BORDER="0" WIDTH="400" style="display: block;margin: 0 auto;border: 1px solid;margin-top: 20px;">
                        <tr>
                            <td>
                                <div class="image-container">
                                    <img src="<?php echo $coupon->logoUrl; ?>" alt="Vendor Image"/>
                                </div>
                            </td>
                            <td>
                                <div class="coupon-text">
                                    <div class="coupon-title"><?php echo $vendor->displayName;?></div>
                                    <div class="coupon-desc"><?php echo $coupon->title;?>
                                        <br/><?php echo $coupon->offer;?>
                                    </div>
                                    <div class="coupon-valid">Valid to <?php echo date('m/d/Y', strtotime($coupon->expireDate->iso));?></div><?php
                                    $ccode = $coupon->couponCode;
                                    if(!empty($ccode)){?>
                                        <div class="coupon-id">ID: <?php
                                            echo $ccode;?>
                                        </div><?php
                                    }?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="coupon-restrictions">
                                    Restrictions Apply. Check with vendor prior to purchase. Void if detached from terms &amp; conditions below.
                                </div>
                                <div class="terms-block">
                                    <div class="terms-heading">
                                        TERMS &amp; CONDITIONS
                                    </div>
                                    <div class="terms-content"><?php
                                        echo $this->disclaimer;?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </body>
            </html><?php
	        return ob_get_clean();
		}

	    public function mail_coupon(){
	        global $wtd_connector;
		    $coupon = $wtd_connector->decrypt_parse_response($_POST['coupon']);
		    $post = array('key' => 'QLtguR96hBzr-mlY86o7jA',
			    'message' => array(
				    'from_email' => 'mailer@whattodo.info',
				    'to' => array(
					    array(
						    'email' => $_POST['email'],
						    'type' => 'to')),
				    'autotext' => true,
				    'subject' => 'WHATTODO coupon',
				    'html' => $this->email($coupon)));
		    $url = 'https://mandrillapp.com/api/1.0/messages/send.json';
		    $ch = curl_init();
		    $timeout = 30;
		    $agents = array('Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36');
		    curl_setopt($ch, CURLOPT_USERAGENT, $agents[array_rand($agents)]);
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_VERBOSE, true);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		    $result = curl_exec($ch);
//		    $data = curl_getinfo($ch);
		    die($result);
	    }
    }
    $wtd_parse_single_coupon = new wtd_parse_single_coupon();
}?>