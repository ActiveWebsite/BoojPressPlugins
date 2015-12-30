<?php
/***********************************************************
   _ _ _     _____           _ 
  | | | |___| __  |___ ___  |_|
  | | | | . | __ -| . | . | | |
  |_____|  _|_____|___|___|_| |
        |_|               |___|

  WpBooj

*/

class WpBooj {
  
  function __construct(){
    // Permissions
    add_filter( 'user_has_cap', array( $this, 'capability_filter'), 10, 3 );
    
    // Actions for front end url fixes
    add_action( 'wp_head',    array( $this, 'redirect_activeclients' ) );
    add_action( 'wp_head',    array( $this, 'relative_urls' ) );
    add_action( 'init',       array( $this, 'x_forwarded' ) );

    // Actions for random post 
    add_action( 'init', array( $this, 'random_post' ) );
    add_action( 'template_redirect', array( $this, 'random_template' ) );  
    
    // Actions for feed modifications
    add_action( 'rss2_item', array( $this, 'feed_featured_image_enclosure' ) );
    add_action( 'rss2_item', array( $this, 'feed_realtor_image_enclosure' ) );
    add_action( 'rss2_item', array( $this, 'feed_post_id_append' ) );    

    add_action( 'wp_footer', array( $this, 'google_analyitics' ) );    
  }

  /**********
    Permissions
    Custom permissions sets for Booj users
   */
  public function capability_filter( $allcaps, $cap, $args ){
    $Admin = get_role('admin');
    $Contributor = get_role('contributor');
    $Contributor->add_cap( 'upload_files');
    return $allcaps;
  }


  /***********************************************************
     _____  
    |  |  |___| |___ 
    |  |  |  _| |_ -|
    |_____|_| |_|___|
  
    Urls

  */

  public function relative_urls(){
    /***
      This allows for a single blog to properly resolve to multiple domains,
      while still supporting the apache proxy from Enterprise app servers.

      This function is called at wp_head, may want to move to init.
    */
    global $WpBooj_options;
    if( $WpBooj_options['relative_urls'] == 'on' ){
      $rebranded = WpBooj::get_dynamic_url();
      if( $rebranded[1] ){
        define( 'WP_SITEURL', $rebranded[0] );
        define( 'WP_HOME',    $rebranded[0] );
      }
    }
  }

  public function get_dynamic_url(){
    /***
      This does most of the work for Relative Urls ( relative_urls )
      Looks for proxy and a differing X-Forwarded-Host then the Wordpress
      site_url it will return the correct url to resolve to and if it had 
      to adjust the url or not.
      @return array(
        $correct_url : str,  url to use regaurdless of dynamics,
        $changed     : bool, weather or not the change is dynamic.
      )
    */    
    global $WpBooj_options;
    if( $WpBooj_options['relative_urls'] == 'on' ){
      $headers         = apache_request_headers();
      $blog_url        = get_bloginfo( 'wpurl' );
      $blog_url_strip  = str_replace( array( 'http://', 'www'), '', $blog_url );
      if( isset($headers['X-Forwarded-Host'] ) && $headers['X-Forwarded-Host'] != $blog_url_strip ){
        $rebranded = $headers['X-Forwarded-Host'];
      } elseif( $_SERVER['HTTP_HOST'] != $blog_url_strip ){
        $rebranded = $_SERVER['HTTP_HOST'];
      } else {
        $rebranded = False;
      }
      if( $rebranded ){
        if($rebranded != 'thelocallantern.com'){
          $rebranded .= '/blog/';          
        }
      } elseif ( $rebranded ){
        $rebranded .= '/';
      }
      if( $rebranded ){
        $rebranded = 'http://' . $rebranded;
        return array( $rebranded, True );
     }
    }
    return array( $blog_url, False );
   }

  public function redirect_activeclients(){
    /***
      Stops users and bots from accessing the active-clients.com location
      @todo : this could create a potential redirect loop, should update.
    */
    global $WpBooj_options;
    if( 
      $WpBooj_options['proxy_admin_urls'] == 'on' && 
      ! isset( $_SERVER['HTTP_X_FORWARDED_HOST'] ) &&
      $WpBooj_options['relative_urls'] != 'on'
      )
    {
      header( 'Location: ' . get_site_url() . '/' );   
    }
  }

  /***                                                                                                                                                             
    This takes the HTTP_X_FORWARDED_FOR var and replaces the REMOTE_ADDR                                                                                           
    We do this to help our security plugins find the remote user through the proxy,                                                                                
    and not the app server that directed them there.                                                                                                               
  */
  public function x_forwarded(){
    global $_SERVER;
    global $WpBooj_options;
    if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && $WpBooj_options['proxy_admin_urls'] == 'on' ){
      if( strpos( $_SERVER['HTTP_X_FORWARDED_FOR'], ',' ) !== False ){
        $new_remote_addr = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
        $new_remote_addr = $new_remote_addr[0];
      } else {
        $new_remote_addr = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }
      $_SERVER['REMOTE_ADDR'] = $new_remote_addr;
    }
  }


  /***********************************************************                                                              
     _____             _            _____         _           _   
    |  _  |___ ___ _ _| |___ ___   |     |___ ___| |_ ___ ___| |_ 
    |   __| . | . | | | | .'|  _|  |   --| . |   |  _| -_|   |  _|
    |__|  |___|  _|___|_|__,|_|    |_____|___|_|_|_| |___|_|_|_|  
              |_|                                                 

    Popular Content

    Select and generate the popular posts, authors, and top content authors.
    Many of these methods require the Wp_PostViews plugin that Booj has modified.

  */

  public static function get_top_content_creators( $num_creators = 3, $blacklist_ids = array() ){
    global $wpdb;
    if( ! empty( $blacklist_ids ) ){
      $where = ' WHERE ';
      foreach( $blacklist_ids as $blacklist_id ) {
        $where .= '`post_author` != ' . $blacklist_id . ' AND ';
      }
      $where = substr( $where, 0, -4 );
    } else {
      $where = "";
    }

    $sql = "SELECT DISTINCT(post_author), COUNT(*) FROM {$wpdb->prefix}posts ".$where." GROUP BY 1 ORDER BY 2 DESC LIMIT " . $num_creators;

    $authors_db = $wpdb->get_results( $sql  );

    $authors = array();
    foreach( $authors_db  as $author ){
      $authors[] = get_userdata( $author->post_author );
    }
    return $authors;
  }

  /***
    GET TOP POSTS
    @desc: Collects the posts with the most views for the current blog. 
      This is done through wordpress meta_key meta_value store for posts
      
    @requirements: Wp_PostViews

    @usage:
      foreach( WpBooj::get_top_posts( 5 ) as $post ){ echo $post['post_title']; }

    @params:
      $count ( defaults 5 )

    @return: 
      array()
   */
  public static function get_top_posts( $count = 5, $months_back = False ){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( is_plugin_active( 'wp-postviews/wp-postviews.php' ) ){
      global $WpBooj_options;
      if( isset( $WpBooj_options['use_WpBoojCache'] ) && $WpBooj_options['use_WpBoojCache'] == 'on' ){
        $popular_cache = WpBoojCache::check( $post_id = 0, $type = 'WpBoojTopPosts' );
        if( $popular_cache ){
          return $popular_cache;
        }
      }
      if( $months_back ){
        $_1_month = 2678400;
        $time_back = date( 'Y-m-d', ( time() - ( $_1_month * $months_back ) ) );
        $where_append = ' AND `posts`.`post_date` > "' . $time_back . '" ';
      } else {
        $where_append = '';
      }
      global $wpdb;
      $sql = "SELECT                                                                                                                                                                                                                           
          posts.ID,                                                                                                                                                                                                                            
          meta.meta_value,                                                                                                                                                                                                                     
          posts.post_title,                                                                                                                                                                                                                    
          posts.post_name,                                                                                                                                                                                                                     
          posts.post_date                                                                                                                                                                                                                      
        FROM `{$wpdb->prefix}postmeta` as meta                                                                                                                                                                                                 
        INNER JOIN `{$wpdb->prefix}posts` as posts                                                                                                                                                                                             
        ON `meta`.`post_id`  = posts.ID                                                                                                                                                                                                        
        WHERE `meta`.`meta_key` = 'views' ". $where_append ."                                                                                                                                                                                  
        ORDER BY CAST( `meta_value` AS DECIMAL ) DESC                                                                                                                                                                                          
        LIMIT " . $count;
      $posts = $wpdb->get_results( $sql  );
      $popular = array();
      foreach( $posts as $key => $post ){
        $popular[$key]['post_id']    = $post->ID;
        $popular[$key]['post_views'] = $post->meta_value;
        $popular[$key]['post_title'] = $post->post_title;
        $popular[$key]['post_slug']  = $post->post_name;
        $popular[$key]['post_date']  = $post->post_date;
        $popular[$key]['url']      = '/' . WpBoojFindURISegment() . '/' . date( 'Y/m/', strtotime( $popular[$key]['post_date'] ) ) . $popular[$key]['post_slug'];
      }
      if( count( $popular ) == $count && isset( $WpBooj_options['use_WpBoojCache'] ) && $WpBooj_options['use_WpBoojCache'] == 'on' ){
        WpBoojCache::store( $post_id = 0, $post_type = 'WpBoojTopPosts', $popular );
      }
      return $popular;
    } else {
      return 'Please install and enable the plugin "Wp Post Views"';
    }
  }

  public static function get_top_posts_for_loop( $count = 10 ){
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( is_plugin_active( 'wp-postviews/wp-postviews.php' ) ){
      global $wpdb;
      $sql = "SELECT 
          posts.`ID`, 
          meta.`meta_value`
        FROM `{$wpdb->prefix}postmeta` as meta
        INNER JOIN `{$wpdb->prefix}posts` as posts
        ON meta.`post_id`  = posts.`ID`
        WHERE meta.`meta_key` = 'views' AND 
          posts.`post_type` = 'post'AND 
          posts.`post_status` = 'publish'
        ORDER BY CAST( `meta_value` AS DECIMAL ) DESC 
        LIMIT " . $count;
      $posts = $wpdb->get_results( $sql  );
      $popular = array();
      foreach( $posts as $key => $post ){
        $popular[] = get_post( $post->ID );
      }
      return $popular;
    } else {
      exit( 'Please install and enable the plugin "Wp Post Views"' );
    }
  }


  /***********************************************************
     _____         _     _ 
    |   __|___ ___|_|___| |
    |__   | . |  _| | .'| |
    |_____|___|___|_|__,|_|

    Social

    A grab bag of social plugins.

  */
  /***
    Get the most recent facebook status.
    @params
      id        : ex( 'aclient')
      appId     : ex( '121207014572698' )
      appSecret : ex( '20b366570115d4444ff61274d7bf4338')
  */
  public static function get_latest_fb_status( $id, $appId, $appSecret ){
    $facebook_url = "https://graph.facebook.com/$id/feed?fields=message,name,link&limit=1&access_token=$appId|$appSecret";
    $curl = curl_init( $facebook_url );
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $results = json_decode(curl_exec($curl), true);
    curl_close($curl);
    if ( isset($results['data']) ){
      $results = isset($results['data'][0]) ? $results['data'][0] : false;
    } else {
      throw new Exception('Problem with Facebook');
    }
    $results['created_time'] = strtotime( $results['created_time'] );
    return $results;
  }

  public static function get_twitter_widget( $twitter_handle ){
    $script = '<a class="twitter-timeline" href="https://twitter.com/'.$twitter_handle.'" data-widget-id="553063792964153344">Tweets by @'.$twitter_handle.'</a>
      <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
      </script>';
    return $script;
  }

  /************************************************************
     _____           _ 
    |   __|___ ___ _| |
    |   __| -_| -_| . |
    |__|  |___|___|___|
  
    Feed
    
    Grabs images for feed enclosures when needed.

  */
  function feed_featured_image_enclosure() {
    if ( ! has_post_thumbnail() )
      return;
    $thumbnail_size = apply_filters( 'rss_enclosure_image_size', 'thumbnail' );
    $thumbnail_id   = get_post_thumbnail_id( get_the_ID() );
    $thumbnail      = wp_get_attachment_image_src( $thumbnail_id, 'full' );
    // @todo: Get the proper file size for the "length" attribute 
    if ( empty( $thumbnail ) )
      return;
    $upload_dir = wp_upload_dir();
    printf( 
     '<enclosure name="featured_image" url="%s" length="%s" type="%s" />',
     $thumbnail[0], 
     filesize( path_join( $upload_dir['basedir'], $thumbnail['path'] ) ), 
     get_post_mime_type( $thumbnail_id ) 
    );
  }

  function feed_realtor_image_enclosure() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if( is_plugin_active( 'user-photo/user-photo.php' ) ){
      global $post;
      $user_photo = $this->user_photo( $post->post_author );
      if( $user_photo ){
        $upload_dir = wp_upload_dir();
        $image_type = explode( '.', $user_photo['userphoto_image_file'] );
        printf(
          '<enclosure name="realtor_image" url="%s" length="%s" type="%s" />',
          $user_photo['url'],
          filesize( path_join( $upload_dir['basedir'], 'userphoto', $user_photo['userphoto_image_file'] ) ),
          'image/' . $image_type[ count( $image_type ) - 1 ]
        );
      }
    }
  }

  function feed_post_id_append() {
    printf( '<post_id>%s</post_id>', get_the_ID() );
  }

  /************************************************************                             
     _____           _           
    | __  |___ ___ _| |___ _____ 
    |    -| .'|   | . | . |     |
    |__|__|__,|_|_|___|___|_|_|_|
                               
    Random
    
  */
  /***
    Get Random Post
    Desc: Will fetch a random post if the url /?random=1 is requested
  */
  public static function random_post(){
    global $wp;
    $wp->add_query_var('random');
    add_rewrite_rule('random/?$', 'index.php?random=1', 'top');
  }

  public static function random_template() {
    if (get_query_var('random') == 1) {
      $posts = get_posts('post_type=post&orderby=rand&numberposts=1');
      foreach($posts as $post) {
        $link = get_permalink($post);
      }
      wp_redirect( $link, 307 );
      exit;
    }
  }


  /***********************************************************                     
     _____ _         
    |     |_|___ ___ 
    | | | | |_ -|  _|
    |_|_|_|_|___|___|

    Misc

    A collection of random functions that are put here.

  */ 
  /***
    User Photo
    Get the user photo raw url without any html markup
    @params
      $user_id = int( )
      $default = str( ) ex: http://devblog.active-clients.com/wp-content/uploads/userphoto/8.jpg
        optional, value to be returned if nothing could be found.
    @return
      str( ) = url
      ex: http://devblog.active-clients.com/wp-content/uploads/userphoto/8.jpg
  */
  public static function user_photo( $user_id, $default = False ){
    global $wpdb;
    $sql = "SELECT * FROM {$wpdb->prefix}usermeta 
      WHERE user_id = '". $user_id ."' AND 
        meta_key IN ( 'userphoto_approvalstatus', 'userphoto_image_file', 'userphoto_image_width', 'userphoto_image_height' )
      ORDER BY meta_key ASC;";
    $user_photo = $wpdb->get_results( $sql  );
    if( ! empty( $user_photo ) ){
      $photo_info = array();
      foreach( $user_photo as $info ){
        $photo_info[ $info->meta_key ] = $info->meta_value;
      }
      $photo_info['url'] = get_bloginfo( 'wpurl' ) . '/wp-content/uploads/userphoto/' . $photo_info['userphoto_image_file'];
      return $photo_info;
    } else {
      if( $default ){
        return $default;
      } else {
        return False;
      }
    }
  }

  public static function truncate( $string, $length ){
    if( strlen( $string ) > $length ){
      $new_string = substr( $string, 0, $length ) . '...';
    } else {
      $new_string = $string;
    }
    return $new_string;
  }
  
  public static function truncate_by_word( $string, $length ){
    $string       = WpBooj::removeCode( $string );    
    $words        = explode( ' ', $string );
    $truncated    = '';
    $letter_count = 0;
    foreach ($words as $key => $word) {
      if( $letter_count < $length ){
        $truncated    = $truncated . $word . ' ';
        $letter_count = $letter_count + strlen ( $word );
      } else {
        $truncated = substr( $truncated, 0, -1 );
        break;
      }
    }
    if( strlen( $string ) > strlen( $truncated ) ){
      $truncated = $truncated . '...';
    }
    return $truncated;
  }

  /***
    Remove HTML, PHP, and Wordpress captions, also, truncate if desired.
    @params
      $string = string of content with potential html, php or Wordpress caption code
      $length = int, length of the return string after code stripping
  */
  public static function removeCode( $string ){
    $butterfly = strip_shortcodes( $string );
    $butterfly = strip_tags( $butterfly );
    return $butterfly;
  }
  
  /***
   Get Post Thumbnail
   @params
     $post_id       = (int)
     $size          = array( int, int )
     $default_image = (str) url of fallback image
  */
  public static function get_post_thumbnail( $post_id, $size = array( 300, 300 ), $default_image = False ){
    $thumbnail_id = get_post_thumbnail_id( $post_id );
    if( $thumbnail_id ){
      $src = wp_get_attachment_image_src( $thumbnail_id, $size );
      return $src[0];
    }
    if( $default_image ){
      return $default_image;
    } else {
      return False;
    }
  }

  /***
    Get Authors
    @params
      $order_by    = (string)(optional) field to order return by
  */
  public static function get_authors( $order_by = Null ){
    global $wpdb;
    $sql = "SELECT user_login, display_name FROM {$wpdb->prefix}users";
    if( $order_by ){
      $sql .= " ORDER BY {$order_by} ASC;";
    } else {
      $sql .= ";";
    }
    $users = $wpdb->get_results( $sql  );
    return $users;
  }
  
  /***
    Get Page Info
    Gets pagination info from the url and ships it out
    @return
      bool or int( ) page number
  */
  public static function get_page_info( ){
    if ( strpos( $_SERVER['REQUEST_URI'], 'page/') !== FALSE || strpos( $_SERVER['REQUEST_URI'], '?paged=') !== FALSE ){
      if( strpos( $_SERVER['REQUEST_URI'], 'page/') !== FALSE ){
        $page_num = explode( '/', $_SERVER['REQUEST_URI'] );
        $page_num = $page_num[2];
      } elseif ( strpos( $_SERVER['REQUEST_URI'], '?paged=') !== FALSE ) {
        $page_num = explode( '?paged=', $_SERVER['REQUEST_URI'] );
        $page_num = $page_num[1];
      }
      return $page_num;
    } else {
      return False;
    }    
  }

  /***
    Get Page Title
      A more controllable way to manage blog titles for SEO
    @params
      $delimeter = str() delimter to use when separating title items
    @return str()
  */
  public static function get_page_title( $delimeter = '|' ){
    $blog_title = get_bloginfo( 'name' );
    $blog_desc  = get_bloginfo( 'description' );
    $title      = '';
    if( is_front_page() || is_home() ){
      $title = $blog_title;
      if( ! empty( $blog_desc ) ){
        $title .= ' ' . $delimeter . ' ' . $blog_desc;
       }
       return $title;
     }
    if ( is_single() ){
      $title .= get_the_title() . ' ' . $delimeter . ' ' . $blog_title;
      return $title;
    }
   }

  public static function get_post_from_category( $category ){
    $args = array(
      'category_name'    => $category,      
      'posts_per_page'   => 1,
      'orderby'          => 'post_date',
      'offset'           => 0,
      'order'            => 'DESC',
      'post_type'        => 'post',
      'post_status'      => 'publish'

    );
    $posts = get_posts( $args );
    return $posts[0];
  }

  public static function display_author_info( $post_id, $default = True ){
    $postive_words = array( 'yes', 'true', 'yeah', 'yea', 'yep', 'show');
    $negative_words = array( 'no', 'false', 'nope', 'hide');
    $post_meta = get_post_meta( $post_id );
    if(array_key_exists( 'display_author', $post_meta )){
      $display_author = $post_meta['display_author'][0];
      if(in_array(strtolower($display_author),$postive_words)){
        return True;
      } elseif(in_array(strtolower($display_author),$negative_words)){
        return False;
      }
    }
    return $default;
  }

  public static function google_analyitics(){
    $options = get_option( 'wp-booj' );
    $codes = explode( ',', $options['WpBoojUACodes'] );
    if( $options['WpBoojEnableUATracking'] == 'on' ){
      ?>
      <script type="text/javascript">
      // WpBooj 1.9 Google Ananlytics Tracking 
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('require', 'displayfeatures');
        ga('create', 'UA-28710577-1', 'auto' ); // booj Tracker
        ga('send', 'pageview');
        <?php 
          $c = 1;
          foreach( $codes as $code ){
            $tracker_name = 'clientTracking' . $c;
            $c++;
            ?> 
            ga('create', '<?php echo trim( $code ); ?>', 'auto', {'name': '<?php echo $tracker_name;?>'} );
            ga('<?php echo $tracker_name; ?>.send', 'pageview');
            <?php
          }
        ?>
      </script>
      <?      
    }
  }

  public static function exceprt( $post ){
    if($post->post_excerpt != ''){
      $content =  $post->post_excerpt;
    } else {
      $content = $post->post_content;
    }
    return $content;
  }

}

/* ENDFILE: includes/WpBooj.php */
