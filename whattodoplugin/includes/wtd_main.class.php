<?php

global $wpdb;
class wtd_main{
		
	public function __construct(){
		
		
		//Activation Hook
		register_activation_hook(WTD_PLUGIN_FILE,array(&$this,'activate'));
		
		//Init Hook
		add_action('init',array(&$this,'init'),1);
		
		//Register Custom Post Types
		add_action('init',array($this,'register_post_types'));
		
		//Admin Init
		add_action('admin_init',array(&$this,'admin_init'));

		//Admin Footer
		add_action('admin_footer',array(&$this,'admin_footer'));
		
		add_action('wp_footer',array(&$this,'footer'));
		
		//WP Head
		add_action('wp_head',array($this,'wp_head'));
		
		//Update Routine
		add_action('wp_footer',array(&$this,'update'));
		
		//URL Rewrite
		add_action('init',array(&$this,'url_rewrite'));
		
		//Custom Post Types Rewrite
		add_filter('post_type_link', array(&$this,'post_permalink'), 10, 3);
		add_filter('post_link', array(&$this,'post_permalink'), 10, 3);
		add_filter('_get_page_link', array(&$this,'page_permalink_2'), 10, 2);
		add_filter('page_link', array(&$this,'page_permalink'), 10, 3);
		
		//Update Routine
		add_action('init',array(&$this,'plugin_update'));
		
		//Ajax Update Runner
		add_action('wp_ajax_wtd_update_feed',array(&$this,'update_feed'));
		add_action('wp_ajax_nopriv_wtd_update_feed',array(&$this,'update_feed'));

		add_action('wp_ajax_wtd_update_single_feed',array(&$this,'update_single_feed'));
		add_action('wp_ajax_nopriv_wtd_update_single_feed',array(&$this,'update_single_feed'));

		//Ajax Update Runner
		add_action('wp_ajax_wtd_start_sync',array(&$this,'compile_process'));
		add_action('wp_ajax_nopriv_wtd_start_sync',array(&$this,'compile_process'));

		//Events Delete Runner
		add_action('wp_ajax_wtd_events_delete',array(&$this,'wtd_events_delete'));
		add_action('wp_ajax_nopriv_wtd_events_delete',array(&$this,'wtd_events_delete'));

		//Events Delete Runner
		add_action('wp_ajax_wtd_mail_coupon',array(&$this,'mail_coupon'));
		add_action('wp_ajax_nopriv_wtd_mail_coupon',array(&$this,'mail_coupon'));
		

		//Ajax Update Check
		add_action('wp_ajax_wtd_check_background',array(&$this,'check_background_update'));
		
		//Comments Open
		add_filter( 'comments_open', array(&$this,'wtd_comments_open'), 10, 2 );
		
		//Comments Number
		add_filter( 'get_comments_number', array(&$this,'wtd_get_comments_number'), 10, 2 );

		//Admin Head
		add_filter( 'admin_head', array(&$this,'admin_head') );

        //Custom Scripts
        add_action( 'wp_enqueue_scripts', array(&$this,'wtd_custom_scripts') );



    }

	public function activate(){
        delete_option('_site_transient_update_plugins');
		if (!function_exists('curl_version'))
			die('What To Do Plugin requires cURL PHP extension. Please contact your Server Administrator!');
		$wtd_plugin = get_option('wtd_plugin');
        if (empty($wtd_plugin)) {


            $permalinks = get_option('permalink_structure');
            if ($permalinks) {
                if (!substr_count($permalinks, '%postname%') || substr_count($permalinks, '.'))
                    update_option('permalink_structure', '/%postname%/');
            } else
                update_option('permalink_structure', '/%postname%/');


            //Create meta table
            global $wpdb;
            $meta_table = $wpdb->prefix . 'wtd_meta';
            $sql = 'CREATE TABLE IF NOT EXISTS ' . $meta_table . '(
				id int(11) NOT NULL AUTO_INCREMENT,
				term_id int(11) NOT NULL,
				wtd_term_id int(11),
				wtd_term_type varchar(252),
				meta_key varchar(252),
				meta_value text,
				PRIMARY KEY id (id)	
		    )';
            $wpdb->query($sql);

        }else{

            $this->new_version_changes();

        }

        update_option('wtd_plugin_version',WTD_VERSION);
		
	}

    private function new_version_changes(){

        $syncing = array('changed' => array('fake_hard_reset' => 1),'options' => get_option('wtd_plugin'));
        update_option('wtd_syncing',$syncing);

        update_option('wtd_reseting',1);

        update_option('wtd_plugin_version', WTD_VERSION);

    }

    public function admin_head(){
        $plugin_version = get_option('wtd_plugin_version');
        if (!empty($plugin_version))
            if ($plugin_version != WTD_VERSION){
                $this->new_version_changes();
            }
    }
	
	public function init(){
        global $wpdb;
        $wtd_plugin = get_option('wtd_plugin');


        if (isset($_GET['wtd_plugin_new_version'])) {
            $wpdb->query("update wp_options set option_value='' where option_name='_site_transient_update_plugins'");
            die();
        }

        global $wtd_excluded_categories;
        $wtd_excluded_categories = array();
        if (!empty($wtd_plugin['business_categories_options']['user'])){
            foreach ($wtd_plugin['business_categories_options']['user'] as $parent_id => $value){
                if (!empty($value['parent'])){
                    $wtd_excluded_categories[] = $parent_id;
                    $children = $wpdb->get_results(
                        $wpdb->prepare(
                            'SELECT tt.term_id FROM '.$wpdb->term_taxonomy.' tt WHERE
										tt.taxonomy = "wtd_category"
										AND tt.parent = %s',
                            $parent_id
                        )
                    );
                    if ($children && !is_wp_error($children)){
                        foreach ($children as $child)
                            $wtd_excluded_categories[] = $child->term_id;
                    }
                }else{
                    if (!empty($value['children']))
                        foreach ($value['children'] as $child_id => $child)
                            $wtd_excluded_categories[] = $child_id;
                }
            }
        }

        global $wtd_page_ids;
        $wtd_page_ids = array();
        $wtd_pages = get_option('wtd_pages');
        if (!empty($wtd_pages))
            foreach ($wtd_pages as $page)
                if (!empty($page))
                    $wtd_page_ids = array_merge($wtd_page_ids,$page);



	}
	
	public function footer(){
		
	}
	
	public function register_post_types(){

		//Register Activities
		$labels = array();
		$args = array(	
			'labels'             => $labels,	
			'public'             => true,	
			'publicly_queryable' => true,	
			'show_ui'            => false,	
			'show_in_menu'       => false,	
			'show_in_nav_menus'  => false,
			'query_var'          => true,	
			'rewrite'            => array( 'slug' => 'wtd-activity' ),	
			'capability_type'    => 'post',	
			'has_archive'        => true,	
			'hierarchical'       => false,	
			'supports'           => array( 'title', 'editor'),
			'taxonomies' => array('wtd_category')
		);	
		
		register_post_type( 'wtd_activity', $args );	
		
		//Register Activity Providers
		$labels = array();
		$args = array(	
			'labels'             => $labels,	
			'public'             => true,	
			'publicly_queryable' => true,	
			'show_ui'            => false,	
			'show_in_menu'       => false,	
			'show_in_nav_menus'  => false,
			'query_var'          => true,	
			'rewrite'            => array( 'slug' => 'wtd-activity-provider' ),	
			'capability_type'    => 'post',	
			'has_archive'        => true,	
			'hierarchical'       => false,	
			'supports'           => array( 'title', 'editor')
		);	
		
		register_post_type( 'wtd_aprovider', $args );	
		
		//Register Events
		$labels = array();
		$args = array(	
			'labels'             => $labels,	
			'public'             => true,	
			'publicly_queryable' => true,	
			'show_ui'            => false,	
			'show_in_menu'       => false,	
			'show_in_nav_menus'  => false,
			'query_var'          => true,	
			'rewrite'            => array( 'slug' => 'wtd-event' ),	
			'capability_type'    => 'post',	
			'has_archive'        => true,	
			'hierarchical'       => false,	
			'supports'           => array( 'title', 'editor')
		);	
		register_post_type( 'wtd_event', $args );	
		
		//Register Coupons
		$labels = array();
		$args = array(
			'labels'             => $labels,	
			'public'             => true,	
			'publicly_queryable' => true,	
			'show_ui'            => false,
			'show_in_menu'       => false,
			'show_in_nav_menus'  => false,
			'query_var'          => true,	
			'rewrite'            => array( 'slug' => 'wtd-coupon','with_front' => FALSE ),	
			'capability_type'    => 'post',	
			'has_archive'        => true,	
			'hierarchical'       => false,	
			'supports'           => array( 'title', 'editor')
		);	
		register_post_type( 'wtd_coupon', $args );	
		
		//Register Specials
		$labels = array();
		$args = array(	
			'labels'             => $labels,	
			'public'             => true,	
			'publicly_queryable' => true,	
			'show_ui'            => false,	
			'show_in_menu'       => false,	
			'show_in_nav_menus'  => false,
			'query_var'          => true,	
			'rewrite'            => array( 'slug' => 'wtd-special' ),	
			'capability_type'    => 'post',	
			'has_archive'        => true,	
			'hierarchical'       => false,	
			'supports'           => array( 'title', 'editor')
		);	
		register_post_type( 'wtd_special', $args );	
		
		//Register Categories
		$labels = array();	
		$args = array(	
			'hierarchical'      => true,	
			'labels'            => $labels,	
			'show_ui'           => false,	
			'show_in_menu'      => false,	
			'show_admin_column' => false,	
			'show_in_nav_menus' => false,
			'query_var'         => true,	
			'rewrite'           => array( 'slug' => 'wtd-category' ),	
			'public'        => true	
		);	
		
		register_taxonomy( 'wtd_category', array( 'wtd_event','wtd_activity','wtd_coupon','wtd_special' ), $args );	
		
		//Register Resorts
		$labels = array();	
		$args = array(	
			'hierarchical'      => true,	
			'labels'            => $labels,	
			'show_ui'           => false,	
			'show_in_menu'      => false,	
			'show_admin_column' => false,	
			'show_in_nav_menus' => false,
			'query_var'         => true,	
			'rewrite'           => false,	
			'public'        => true	
		);	
		
		register_taxonomy( 'wtd_resort', array( 'wtd_event','wtd_activity','wtd_coupon','wtd_special' ), $args );	
		
		
		//Register Locations
		$labels = array();	
		$args = array(	
			'hierarchical'      => true,	
			'labels'            => $labels,	
			'show_ui'           => false,	
			'show_in_menu'      => false,	
			'show_admin_column' => false,	
			'show_in_nav_menus' => false,
			'query_var'         => true,	
			'rewrite'           => false,	
			'public'            => true	
		);	
		
		register_taxonomy( 'wtd_location', array( 'wtd_event','wtd_activity','wtd_coupon','wtd_special' ), $args );

        if (isset($_GET['wtd_single_activity_update'])) {
            global $wtd_connector;
            $wtd_connector->single_activity($_GET['wtd_single_activity_update']);
            die();
        }
	}
	
	public function url_rewrite(){
		
	global $wp_rewrite;
        global $wpdb;
        global $wtd_plugin;
        $wtd_plugin = get_option('wtd_plugin');

		$options = get_option('wtd_pages');
        $front_id = intval(get_option('page_on_front'));
		$array = array();
        if (!empty($options))
            foreach ($options as $option)
                if (is_array($option))
                    $array = array_merge($array,$option);
        if (count($array))
            $db_results = $wpdb->get_results(
                $wpdb->prepare(
                    'SELECT * FROM '.$wpdb->posts.' WHERE ID IN ('.implode(',',$array).') LIMIT %d',
                    count($array)
                )
            );
        $posts = array();
        if (count($array))
            foreach ($db_results as $res)
                $posts[intval($res->ID)] = $res;

		if (!empty($options['activities_pages'])){
			foreach ($options['activities_pages'] as $page){
                $page = intval($page);
				if(!empty($posts[$page]) && ($front_id !== $page)){
                    $post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/?$', 'index.php?pagename='.$post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/category/(.+)/?$', 'index.php?pagename='.$post->post_name.'&wtdc=$matches[1]', 'top');
				}elseif($front_id == $page){
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/category/(.+)/?$', 'index.php?wtdc=$matches[1]&page_id='.$page, 'top');
                }
			}
		}
		
		if (!empty($options['coupons_pages'])){
			foreach ($options['coupons_pages'] as $page){
                $page = intval($page);
                if(!empty($posts[$page]) && ($front_id !== $page)){
                    $post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/?$', 'index.php?pagename='.$post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/category/(.+)/?$', 'index.php?pagename='.$post->post_name.'&wtdc=$matches[1]', 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/all', 'index.php?pagename='.$post->post_name.'&all=1', 'top');
				}
			}
		}
		
		if (!empty($options['dining_pages'])){
			foreach ($options['dining_pages'] as $page){
                $page = intval($page);
                if(!empty($posts[$page]) && ($front_id !== $page)){
                    $post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/?$', 'index.php?pagename='.$post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/category/(.+)/?$', 'index.php?pagename='.$post->post_name.'&wtdc=$matches[1]', 'top');
				}elseif(($front_id == $page)){
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/category/(.+)/?$', 'index.php?wtdc=$matches[1]&page_id='.$page, 'top');
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/all', 'index.php?all=1&page_id='.$page, 'top');
                }
			}
		}
		
		if (!empty($options['map_pages'])){
			foreach ($options['map_pages'] as $page){
                $page = intval($page);
                if(!empty($posts[$page]) && ($front_id !== $page)){
                    $post = $posts[$page];
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/?$', 'index.php?pagename='.$post->post_name, 'top');
					add_rewrite_rule($wtd_plugin['url_prefix'].'/'.$post->post_name.'/category/(.+)/?$', 'index.php?pagename='.$post->post_name.'&wtdc=$matches[1]', 'top');
				}elseif(($front_id == $page)){
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/category/(.+)/?$', 'index.php?wtdc=$matches[1]', 'top');
                }
			}
		}
		
		if (!empty($options['custom_pages'])){
			foreach ($options['custom_pages'] as $page){
                $page = intval($page);
                if(!empty($posts[$page]) && ($front_id !== $page)){
                    $post = $posts[$page];
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/' . $post->post_name . '/category/(.+)/?$', 'index.php?pagename=' . $post->post_name . '&wtdc=$matches[1]', 'top');
                }elseif($front_id == $page){
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/category/(.+)/?$', 'index.php?wtdc=$matches[1]&page_id='.$page, 'top');
                }
            }
		}

		if (!empty($options['calendar_pages'])){
			foreach ($options['calendar_pages'] as $page) {
                $page = intval($page);
                if (!empty($posts[$page]) && ($front_id !== $page)) {
                    $post = $posts[$page];
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
                }
			}
		}
		if (!empty($options['week_pages'])){
			foreach ($options['week_pages'] as $page) {
                $page = intval($page);
                if (!empty($posts[$page]) && ($front_id !== $page)) {
                    $post = $posts[$page];
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
                }
			}
		}
		if (!empty($options['week_specials_pages'])){
			foreach ($options['week_specials_pages'] as $page) {
                $page = intval($page);
                if (!empty($posts[$page]) && ($front_id !== $page)) {
                    $post = $posts[$page];
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
                }
			}
		}
		
		if (!empty($options['specials_pages'])){
			foreach ($options['specials_pages'] as $page){
                $page = intval($page);
                if (!empty($posts[$page]) && ($front_id !== $page)) {
                    $post = $posts[$page];
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
                }
			}
		}
		if (!empty($options['search_page'])){
			foreach ($options['search_page'] as $page){
                $page = intval($page);
                if (!empty($posts[$page]) && ($front_id !== $page)) {
                    $post = $posts[$page];
                    add_rewrite_rule($wtd_plugin['url_prefix'].'/' . $post->post_name . '/?$', 'index.php?pagename=' . $post->post_name, 'top');
                }
			}
		}


        add_rewrite_rule($wtd_plugin['url_prefix'].'/special/(.+)/(.+)/?$', 'index.php?wtd_special=wtd-special&wtd_parse_id=$matches[1]&wtd_special_name=$matches[2]', 'top');
        add_rewrite_rule($wtd_plugin['url_prefix'].'/event/(.+)/(.+)/?$', 'index.php?wtd_event=wtd-event&wtd_parse_id=$matches[1]&wtd_event_name=$matches[2]', 'top');

		add_rewrite_tag('%wtd_parse_id%','([^&]+)');
		add_rewrite_tag('%wtd_special_name%','([^&]+)');
		add_rewrite_tag('%wtd_event_name%','([^&]+)');
		add_rewrite_tag('%wtdc%','([^&]+)');

		add_rewrite_rule($wtd_plugin['cat_url_prefix'].'/activity/(.+)/(.+)/?$', 'index.php?wtd_activity=$matches[2]', 'top');
		add_rewrite_rule($wtd_plugin['scat_url_prefix'].'/activity/(.+)/(.+)/(.+)/?$', 'index.php?wtd_activity=$matches[3]', 'top');
		
		add_rewrite_rule($wtd_plugin['cat_url_prefix'].'/coupon/(.+)/(.+)/?$', 'index.php?wtd_coupon=$matches[2]', 'top');
		add_rewrite_rule($wtd_plugin['scat_url_prefix'].'/coupon/(.+)/(.+)/(.+)/?$', 'index.php?wtd_coupon=$matches[3]', 'top');

		$wp_rewrite->flush_rules();
		
	}
	
	
	public function post_permalink($url, $post, $leavename) {
        global $wpdb;
        global $wtd_plugin;
        $site_url = get_home_url();
        $front_id = get_option('page_on_front');
        $front_id = intval($front_id);
        $post_types = array(
                'wtd_activity' => 'activity',
                'wtd_coupon' => 'coupon'
        );
        if (!empty($post_types[$post->post_type])){
            $term = $wpdb->get_row(
                $wpdb->prepare(
                    '
                        SELECT t.*, tt.parent FROM  '.$wpdb->term_relationships.' tr
                        RIGHT JOIN '.$wpdb->term_taxonomy.' tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
                        RIGHT JOIN '.$wpdb->terms.' t ON (t.term_id = tt.term_id)
                        WHERE tr.object_id = %s AND tt.taxonomy = "wtd_category"  LIMIT 1
                    ',
                    $post->ID
                )
            );
            //$terms = wp_get_post_terms($post->ID,'wtd_category');
            if (!empty($term)){
                if ($term->parent){
                    //$parent = get_term($term->parent,'wtd_category');
                    $parent = $wpdb->get_row(
                        $wpdb->prepare(
                            'SELECT * FROM '.$wpdb->terms.' WHERE term_id = %s LIMIT 1',
                            $term->parent
                        )

                    );
                    $url = $site_url.'/'.$wtd_plugin['scat_url_prefix'].'/'.$post_types[$post->post_type].'/'.$parent->slug.'/'.$term->slug.'/'.$post->post_name;
                }else{
                    $url = $site_url.'/'.$wtd_plugin['cat_url_prefix'].'/'.$post_types[$post->post_type].'/'.$term->slug.'/'.$post->post_name;
                }
            } 
        }

        if ($post->post_type == 'wtd_event'){
            $url = $site_url.'/'.$wtd_plugin['url_prefix'].'/event/';
        }

        if ($post->post_type == 'wtd_special'){
            $url = $site_url.'/'.$wtd_plugin['url_prefix'].'/special/';
        }

        if ($post->post_type == 'page'){
            global $wtd_page_ids;
            if (in_array($post->ID,$wtd_page_ids)){
                $p_id = intval($post->ID);
                if ($front_id != $p_id)
                    $url = $site_url.'/'.$wtd_plugin['url_prefix'].'/'.$post->post_name.'/';
                else
                    $url = $site_url.'/'.$wtd_plugin['url_prefix'].'/';
            }
        }
		
		
        return $url;

	}
	
	public function page_permalink($link , $post_id, $sample){
        global $wtd_page_ids;
        global $wtd_plugin;
        $post_id = intval($post_id);
        $front_id = get_option('page_on_front');
        $front_id = intval($front_id);
        $site_url = get_home_url();
        $post = get_post($post_id);
		if (in_array($post_id,$wtd_page_ids)){
            if ($front_id != $post_id)
                $link = $site_url.'/'.$wtd_plugin['url_prefix'].'/'.$post->post_name.'/';
            else
                $link = $site_url.'/'.$wtd_plugin['url_prefix'].'/';
		}
		return $link;
	}

	public function page_permalink_2($link , $post_id){
        global $wtd_page_ids;
        global $wtd_plugin;
        $post_id = intval($post_id);
        $front_id = get_option('page_on_front');
        $front_id = intval($front_id);
        $site_url = get_home_url();
        $post = get_post($post_id);
        if (in_array($post_id,$wtd_page_ids)){
            if ($front_id != $post_id)
                $link = $site_url.'/'.$wtd_plugin['url_prefix'].'/'.$post->post_name.'/';
            else
                $link = $site_url.'/'.$wtd_plugin['url_prefix'].'/';
		}
		return $link;
	}
	
	public function admin_footer(){
		global $wtd_api_error;
		if ($wtd_api_error){
			echo '<script>';
			foreach ($wtd_api_error as $err)
				echo 'jQuery(\'#wtd_api_errors\').append(\'<li>'.$err.'</li>\');';
			echo '</script>';
		}
		
		global $wtd_syncing;
		global $wtd_modal;
		$modal_text = '';
		$opt = get_option('wtd_syncing');
		$wtd_reseting = get_option('wtd_reseting');
		switch ($wtd_modal):
			case 1: $modal_text="Some of the enabled pages need data that is not yet imported. The import process is running in background and it may take a while. As soon as the data is available you will see the enabled pages published!<br/>
				 The page may reload several times until the process ends.";
				 break;
                case 2: $modal_text="The changed settings require data import. The import process is running in background. All the available pages will be regenerated!<br/>
				 The page may reload several times until the process ends.";
				 break;
			case 3: $modal_text="Importing <strong>Locations, Activity Providers</strong> and <strong>Categories</strong>!<br/>
				 The page will reload automatically when the process ends.";
				 break;
			case 4: $modal_text="Erasing data in the background!<br/>
				 The page may reload several times until the process ends.";
				 break;
				
		endswitch;
		$terms_synced = get_option('wtd_terms_synced');
		if ($wtd_syncing){
			wp_enqueue_media();
			add_thickbox();
			?>
			<style>
				.redux-container .redux-action_bar{
					display:none;
				}
			</style>
			<div id="wtd_modal" style="display:none;">
			 <img src="<?php echo WTD_PLUGIN_URL.'/assets/img/wtd_wait.gif';?>"/>
			 <p>
				 <?php echo $modal_text; ?>
			 </p>
			</div>
			<script>
            function wtd_trigger_routine(){
                jQuery.ajax({
                    type: 'POST',
                    data: {
                        action: 'wtd_start_sync'
                    },
                    url : ajaxurl,
                    success: function(data){
                        var response = jQuery.parseJSON(data);
                        if(typeof response == 'object'){
                            wtd_trigger_routine();
                        }else{
                            window.location = "<?php echo admin_url('/admin.php?page=wtd_plugin_settings');?>";
                        }
                    },
                    error: function(jqXHR,textStatus,errorThrown){
                        window.location = "<?php echo admin_url('/admin.php?page=wtd_plugin_settings');?>";
                    }
                });
            }
			jQuery(window).load(function() {
				wtd_start_sync = true;
                wtd_trigger_routine();
				<?php if ($wtd_modal): ?>
				tb_show("",'#TB_inline?width=310&height=270&inlineId=wtd_modal');
				<?php endif; ?>
				<?php if ($terms_synced) foreach ($terms_synced as $term): ?>
					var section = jQuery('.<?php echo $term;?>').attr('id');
					jQuery('#'+section+'_li').hide();
				<?php endforeach;?>
			});
			</script>
			<?php 
		}
		?>
		<style>
			.toplevel_page_wtd_plugin_settings img{
				padding-top:8px !important;
			}
		</style>
		<?php 
		
	}
	
	public function admin_init(){
		
		if (!empty($_GET['connect_wtd_api'])){
			global $wtd_connector;
			$api_key = $_GET['api_key'];
			$wtd_connector->first_touch($api_key);
		}

		if (!empty($_GET['wtd_new_client_key'])){
            echo '<style>body{display:none;}</style>';

			global $wtd_connector;
			$api_key = $_GET['wtd_new_client_key'];
            if (!empty($_GET['wtd_refresh_details']))
			    $wtd_connector->change_client_key($api_key,true);
            else
                $wtd_connector->change_client_key($api_key);

            echo '<script>window.location="'.admin_url('admin.php?page=wtd_plugin_settings').'";</script>';
            die();

		}
		
		if (!empty($_GET['wtd_pre_reset'])){

			update_option('wtd_reseting',1);
				
			echo '<style>body{display:none;}</style><script>window.location="'.admin_url('admin.php?page=wtd_plugin_settings&wtd_reset_data='.$_GET['wtd_pre_reset']).'";</script>';
			
		}
		if (!empty($_GET['wtd_reset_data'])){
			
			global $wtd_syncing;
			global $wtd_modal;
			$wtd_syncing = true;
			$syncing = array('changed' => array('reset_data' => $_GET['wtd_reset_data']),'options' => get_option('wtd_plugin'));
			update_option('wtd_syncing',$syncing);
			$wtd_modal = 4;
			
		}
		
		if (!empty($_POST['wtd_plugin']['business_categories_options']['user'])){
			global $wpdb;
			$old_categories = get_option('wtd_excluded_categories');
			if ($old_categories != $_POST['wtd_plugin']['business_categories_options']['user']){
				update_option('wtd_excluded_categories',$_POST['wtd_plugin']['business_categories_options']['user']);
				$in = array();
				if (!empty($_POST['wtd_plugin']['business_categories_options']['user'])){
					foreach ($_POST['wtd_plugin']['business_categories_options']['user'] as $parent_id => $value){
						if (!empty($value['parent'])){
							$in[] = $parent_id;
							$children = $wpdb->get_results(
								$wpdb->prepare(
									'SELECT tt.term_id FROM '.$wpdb->term_taxonomy.' tt WHERE 
										tt.taxonomy = "wtd_category" 
										AND tt.parent = %s',
										$parent_id
								)
							);
							if ($children && !is_wp_error($children)){
								foreach ($children as $child)
									$in[] = $child->term_id;
							}
						}else{
							if (!empty($value['children']))
								foreach ($value['children'] as $child_id => $child)
									$in[] = $child_id;
						}
					}
				}
				
				$args = array(
					'posts_per_page' => -1,
					'post_type' => array(
						'wtd_activity',
						'wtd_event',
						'wtd_coupon',
						'wtd_special'
					),
					'tax_query' => array(
						array(
						'taxonomy' => 'wtd_category',
						'field' => 'id',
						'terms' => $in,
						'operator' => 'IN'
						)
					)
				);
				
				$disabled_posts = new WP_Query($args);
                if ($disabled_posts->found_posts) {
                    $implode = array();
                    foreach ($disabled_posts->posts as $post)
                        $implode[] = $post->ID;
                    $wpdb->query(
                        'UPDATE ' . $wpdb->posts . ' SET `post_status` = "draft" WHERE `ID` IN (' . implode(',', $implode) . ')'
                    );
                }

                $enabled_cats = get_terms('wtd_category',array('exclude' => $in));
                $in = array();
                if (!empty($enabled_cats) && !is_wp_error($enabled_cats))
                    foreach ($enabled_cats as $e)
                        $in[] = $e->term_id;
                $args = array(
                    'posts_per_page' => -1,
                    'post_type' => array(
                        'wtd_activity',
                        'wtd_event',
                        'wtd_coupon',
                        'wtd_special'
                    ),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'wtd_category',
                            'field' => 'id',
                            'terms' => $in,
                            'operator' => 'IN'
                        )
                    )
                );
                $enabled_posts = new WP_Query($args);
                if ($enabled_posts->found_posts) {
                    $implode = array();
                    foreach ($enabled_posts->posts as $post)
                        $implode[] = $post->ID;
                    $wpdb->query(
                        'UPDATE ' . $wpdb->posts . ' SET `post_status` = "publish" WHERE `ID` IN (' . implode(',', $implode) . ')'
                    );
                }

			}
		}

        if (!empty($_GET['wtd_reload'])){
            $type = $_GET['wtd_reload'];
            $page = $_GET['wtd_page'];
            $wtd_feed = get_option('wtd_feed');
            unset($wtd_feed[$type]);
            update_option('wtd_feed',$wtd_feed);
            $options = get_option('wtd_plugin');
            $compile = array(
                'options' => $options,
                'changed' => array(
                    $page => 1
                )
            );
            update_option('wtd_syncing',$compile);
            echo '<style>body{display:none;}</style><script>window.location="'.admin_url('admin.php?page=wtd_plugin_settings').'";</script>';
        }

	}
	
	public function wp_head(){
        global $wp_query;
		?>
		<script>wtd_ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";</script>
		<?php 
	}

    public function wtd_events_delete(){
        global $wpdb;
        $page_limit = 10;
        $query = $wpdb->prepare(
            'SELECT * FROM '.$wpdb->postmeta.' WHERE meta_key = "eve_date" AND meta_value < %s LIMIT '.$page_limit,
            date('Y-m-01')
        );
        $post_ids = $wpdb->get_results($query);
        while (!empty($post_ids)){
            foreach ($post_ids as $post_id)
                wp_delete_post($post_id->post_id,true);

            $post_ids = $wpdb->get_results($query);
        }
    }
	
	public function update(){

        //Events Deleter
        if (date('Y-m-d') == date('Y-m-01')){
            ?>
            <script>
                jQuery(window).load(function () {
                    jQuery.ajax({
                        type: 'POST',
                        data: {
                            action: 'wtd_events_delete'
                        },
                        url: wtd_ajax_url
                    });
                });
            </script>
            <?php
        }

        //Feed Update
	$wtd_feed = get_option('wtd_feed');
        $updating = get_option('wtd_updating');
        $wtd_reseting = get_option('wtd_reseting');
        global $wtd_plugin;
        if($wtd_feed && empty($updating) && empty($wtd_reseting)) {
                $difference = $wtd_plugin['feed_update_time'] * 60;
                foreach ($wtd_feed as $key => $time)
                        if (((time() - $time) > $difference) && $key != 'categories') {?>
                        <script>
                        jQuery(window).load(function () {
                            jQuery.ajax({
                                type: 'POST',
                                data: {
                                    action: 'wtd_update_feed',
                                    key: '<?php echo $key;?>'
                                },
                                url: wtd_ajax_url
                            });
                        });
                        </script><?php
                    break;
                }
        }elseif(!empty($updating) && $wtd_feed && empty($wtd_reseting)){?>
            <script>
                jQuery(window).load(function () {
                    jQuery.ajax({
                        type: 'POST',
                        data: {
                            action: 'wtd_update_feed',
                            key: '<?php echo $updating;?>'
                        },
                        url: wtd_ajax_url
                    });
                });
            </script>
            <?php
        }
	}
	
	
	public function wtd_comments_open( $open, $post_id ) {
			
			global $post;
			
			$post_types = array(
				'wtd_activity',
				'wtd_aprovider',
				'wtd_coupon',
				'wtd_event',
				'wtd_special'
			);
			
			if( $post->post_type )
			if( in_array($post->post_type,$post_types) ) {
					$open = false;
			}
			return $open;
	}
	
	public function wtd_get_comments_number( $count, $post_id ) {
			$post = get_post($post_id);
		
			$post_types = array(
				'wtd_activity',
				'wtd_aprovider',
				'wtd_coupon',
				'wtd_event',
				'wtd_special'
			);
			
			if( $post->post_type )
			if( in_array($post->post_type,$post_types) ) {
					$count = 0;
			}
			return $count;
	}
	
	
	public function update_feed(){
		if (!empty($_POST['key'])){
			global $wtd_connector;
			$key = $_POST['key'];
			$wtd_feed = get_option('wtd_feed');
            update_option('wtd_updating',$key);
            foreach ($wtd_feed as $key => $time) {
                if(!empty($time))
                    $wtd_connector->update(array($key => $wtd_feed[$key]));
            }
            delete_option('wtd_updating');
			foreach ($wtd_feed as $key => $feed)
                $wtd_feed[$key] = time();
            update_option('wtd_feed',$wtd_feed);
		}
	}

	public function update_single_feed(){
		if (!empty($_POST['key'])){
            var_dump($_POST);
			global $wtd_connector;
			$key = $_POST['key'];
			$wtd_feed = get_option('wtd_feed');
            update_option('wtd_updating',$key);
			$wtd_connector->update(array($key => $wtd_feed[$key]-(24*60*60)));
//			$wtd_connector->update($wtd_feed);
            delete_option('wtd_updating');
			$wtd_feed[$key] = time();
//			foreach ($wtd_feed as $key => $feed)
//                $wtd_feed[$key] = time();
            update_option('wtd_feed',$wtd_feed);
		}
	}
	
	
	public function compile_process(){
		global $wtd_connector;
		global $wpdb;
		$opt = get_option('wtd_syncing');
		if (!empty($opt)):
			$menu_flag = false;
			$changed_values = $opt['changed'];
			$options = $opt['options'];
			$wtd_pages = get_option('wtd_pages');
			if (!$wtd_pages)
            $wtd_pages = array();
			$terms_synced = get_option('wtd_terms_synced');
			$wtd_feed = get_option('wtd_feed');
            $last_pages = array('calendar-page','specials-page', 'week-page');
            $reimport = false;
            foreach ($last_pages as $lpage)
                if (!empty($changed_values[$lpage])){
                    $old_value = $changed_values[$lpage];
                    unset($changed_values[$lpage]);
                    $changed_values[$lpage] = $old_value;
                }
			foreach ($changed_values as $key => $value){

				if ($key == 'new_version'){
                    $cats = array(
                        'activities' => $wtd_connector->category_mapping('wtd_activity'),
                        'coupons' => $wtd_connector->category_mapping('wtd_coupon'),
                        'events' => $wtd_connector->category_mapping('wtd_event'),
                        'specials' => $wtd_connector->category_mapping('wtd_special')
                    );
                    update_option('wtd_mapped_categories', $cats);
                    unset ($changed_values[$key]);
                    update_option('wtd_syncing',array(
                        'changed' => $changed_values,
                        'options' => $options
                    ));
                }
				if ($key == 'reset_data'){

                    if ($changed_values[$key] == 1) {
                        $wtd_connector->reset_data();
                        $reimport = true;
                    }else
                        $wtd_connector->reset_data(true);
					delete_option('wtd_reseting');

				}

				if ($key == 'fake_hard_reset'){

                    $wtd_connector->reset_data();
                    $wtd_connector->fake_reset();
                    $reimport = true;
                    $reimport_all = true;
					delete_option('wtd_reseting');

				}

				if ($key == 'wtd_resorts'){
					$wtd_connector->sync_vendors();
					$wtd_connector->sync_locations();
					$wtd_connector->sync_categories();
                    unset ($changed_values[$key]);
                    update_option('wtd_syncing',array(
                        'changed' => $changed_values,
                        'options' => $options
                    ));
                    die(json_encode(
                        array(
                            'refresh' => 1
                        )
                    ));
				}
				//Sync Process
				if (in_array($key,array('activities-page','map-page','search-page')) && intval($options[$key])){
					if (empty($wtd_feed['activities'])){
						$wtd_connector->sync_short_activities();
						$wtd_feed['activities'] = time();
						update_option('wtd_feed',$wtd_feed);
                        unset ($changed_values[$key]);
                        update_option('wtd_syncing',array(
                            'changed' => $changed_values,
                            'options' => $options
                        ));
                        die(json_encode(
                            array(
                                'refresh' => 1
                            )
                        ));
					}
					unset($terms_synced[$key]);
					update_option('wtd_terms_synced',$terms_synced);
				}


				if (in_array($key,array('dining-page')) && intval($options[$key])) {
						if (empty($wtd_feed['dining'])){
							$wtd_connector->sync_short_dining();
							$wtd_feed['dining'] = time();
							update_option('wtd_feed',$wtd_feed);
                            unset ($changed_values[$key]);
                            update_option('wtd_syncing',array(
                                'changed' => $changed_values,
                                'options' => $options
                            ));
                            die(json_encode(
                                array(
                                    'refresh' => 1
                                )
                            ));
						}
				}

				if ($key == 'coupons-page' && intval($options[$key])){
					if (empty($wtd_feed['coupons'])){
						$wtd_connector->sync_short_coupons();
						$wtd_feed['coupons'] = time();
						update_option('wtd_feed',$wtd_feed);
                        unset ($changed_values[$key]);
                        update_option('wtd_syncing',array(
                            'changed' => $changed_values,
                            'options' => $options
                        ));
                        die(json_encode(
                            array(
                                'refresh' => 1
                            )
                        ));
					}
					unset($terms_synced[$key]);
					update_option('wtd_terms_synced',$terms_synced);
				}


			}

			
		endif;	
		delete_option('wtd_syncing');
		delete_option('wtd_terms_synced');
        if ($reimport){
            $to_reimport = array(
                'activities-page',
                'search-page',
                'dining-page',
                'coupons-page'
            );
            if (!empty($reimport_all))
                $to_reimport = array_merge(array('wtd_resorts'),$to_reimport);

            $changed = array();
            foreach ($to_reimport as $page)
                if (!empty($options[$page]))
                    $changed[$page] = 1;
            update_option('wtd_syncing',array('changed' => $changed,'options' => $options));

        }
	}

	
	public function plugin_update(){
		
        require_once ('wtd_plugin_update.class.php');
		$updater = new wtd_plugin_update();
		
	}

	public function check_background_update(){
		if (!get_option('wtd_syncing'))
			echo json_encode(array('response' => true));
		else
			echo json_encode(array('response' => false));
		die();
	}

    public function wtd_custom_scripts(){
        wp_enqueue_script(
            'wtd_scripts',
            WTD_PLUGIN_URL.'assets/js/wtd_frontend.js',
            array( 'jquery' )
        );
        wp_enqueue_style(
            'wtd_frontend',
            WTD_PLUGIN_URL.'assets/css/wtd_frontend.css',
            array(),
            WTD_VERSION
        );
    }

    public function mail_coupon(){

        global $wtd_single_coupon;
        $post = array(
            'key' => 'QLtguR96hBzr-mlY86o7jA',
            'message' => array(
                'from_email' => 'mailer@whattodo.info',
                'to' => array(
                    array(
                        'email' => $_POST['email'],
                        'type' => 'to'
                    )
                ),
                'autotext' => true,
                'subject' => 'WHATTODO coupon',
                'html' => $wtd_single_coupon->email($_POST['id'])
            )

        );

        $url = 'https://mandrillapp.com/api/1.0/messages/send.json';
        $ch = curl_init();

        $timeout = 30;

        $agents = array(
            'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.67 Safari/537.36'

        );
        curl_setopt($ch,CURLOPT_USERAGENT,$agents[array_rand($agents)]);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT,         300);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,  $timeout );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch,CURLOPT_POSTFIELDS,http_build_query($post));



        $result = curl_exec($ch);
        $data = curl_getinfo($ch);
        die($result);

    }

}

if (!function_exists('wtd_excerpt_generator')){

    function wtd_excerpt_generator($text, $post = false, $force_url = false){

        $text = strip_tags($text);
        if(strlen($text) >= 250) {
            $s = substr($text, 0, 261);
            $result = substr($s, 0, strrpos($s, ' ')) . ' ...';
        }else
            $result = $text;

        $url = false;
        if ($force_url)
            $url = $force_url;
        elseif ($post)
            $url = get_permalink($post->ID);

        if ($url)
            $result .= ' <br/><a href="'.$url.'">Read More</a>';

        echo $result;

    }

}

if (!function_exists('wtd_video_id_generator')){

    function wtd_video_id_generator($url){

        $id = '';

        if (substr_count($url,'you')){
                $parts = parse_url($url);
                $query_parts = parse_str($parts['query'], $query);
                if (!empty($query['v']))
                    $id = $query['v'];
                else
                    $id = str_replace('/embed/','',$parts['path']);

        }

        return $id;

    }

}

if (!function_exists('wtd_get_image_url')){

    function wtd_get_image_url($field){

        if (substr_count($field,WTD_IMG_BASE))
            return $field;
        else
            return WTD_IMG_BASE.$field;

    }

}

?>
