<?php
/***********************************************************                                                          
   _ _ _     _____           _    _ _    _____   _       _     
  | | | |___| __  |___ ___  |_|  |_|_|  |  _  |_| |_____|_|___ 
  | | | | . | __ -| . | . | | |   _ _   |     | . |     | |   |
  |_____|  _|_____|___|___|_| |  |_|_|  |__|__|___|_|_|_|_|_|_|
        |_|               |___|                                
  
  WpBooj :: Admin

*/

class WpBoojAdmin {
  /**
   * Holds the values to be used in the fields callbacks
   */
  private $options;

  public function __construct(){
    add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );

    add_action( 'admin_init', array( $this, 'page_init' ) );

    add_action( 'admin_head', array( $this, 'booj_branding' )          );
    add_action( 'admin_head', array( $this, 'proxy_admin_urls' )       );
    add_action( 'admin_head', array( $this, 'plugin_management' ) );

    add_action( 'show_user_profile',        array( $this, 'booj_profile_fields_admin_display' ) );
    add_action( 'edit_user_profile',        array( $this, 'booj_profile_fields_admin_display' ) );

    add_action( 'personal_options_udpate', array( $this, 'booj_profile_fields_admin_save' ) );
    add_action( 'edit_user_profile_update', array( $this, 'booj_profile_fields_admin_save' ) );

    add_action( 'admin_init', array( $this, 'remove_nag' )             );
    add_action( 'admin_head', array( $this, 'remove_nag_css' )         );
    
    add_action( 'draft_to_pending',      array( $this, 'email_draft_submission_to_admins'), 10, 1 );
    add_action( 'new_to_pending',        array( $this, 'email_draft_submission_to_admins' ) );
    add_action( 'auto-draft_to_pending', array( $this, 'email_draft_submission_to_admins' ) );
  }

  public function booj_branding(){
    ?>
    <style type="text/css">
      #footer-upgrade{
        display: none;
      }
/*      #wpfooter{
        background-image: url('<?php print get_site_url(); ?>/wp-content/plugins/WpBooj/enterprise_logo.jpg');
        background-repeat: no-repeat;
        background-position: right;
      }*/
    </style>
    <?php
  }

  /***********************************************************                                                          
     _____   _       _        _____     _   _   _             
    |  _  |_| |_____|_|___   |   __|___| |_| |_|_|___ ___ ___ 
    |     | . |     | |   |  |__   | -_|  _|  _| |   | . |_ -|
    |__|__|___|_|_|_|_|_|_|  |_____|___|_| |_| |_|_|_|_  |___|
                                                     |___|    
    Admin Settings
  */

  /**
   * Add options page
   */
  public function add_plugin_page(){
      // This page will be under "Settings"
      add_options_page(
          'WpBooj', 
          'WpBooj', 
          'manage_options', 
          'wp-booj-admin', 
          array( $this, 'create_admin_page' )
      );
  }

  /**
   * Options page callback
   */
  public function create_admin_page(){
    // Set class property
    $this->options = get_option( 'wp-booj' );
    ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h2>WpBooj Settings</h2>           
      <form method="post" action="options.php">
        <?php
          // This prints out all hidden setting fields
          settings_fields( 'wp-booj' );   
          do_settings_sections( 'wp-booj-admin' );
          submit_button(); 
        ?>
      </form>
    </div>
    <?php
  }

  /**
   * Register and add settings
   */
  function page_init(){        
    register_setting(
      'wp-booj', // Option group
      'wp-booj', // Option name
      array( $this, 'sanitize' ) // Sanitize
    );

    add_settings_section(
      'setting_section_id', // ID
      'General Settings', // related_posts
      array( $this, 'print_section_info' ), // Callback
      'wp-booj-admin' // Page
    );  

    add_settings_field(
      'proxy_admin_urls', // ID
      'Proxy Admin Urls', // related_posts 
      array( $this, 'proxy_admin_urls_callback' ), // Callback
      'wp-booj-admin', // Page
      'setting_section_id' // Section           
    );      

    add_settings_field(
      'related_posts', 
      'Use Related Posts', 
      array( $this, 'related_posts_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    );

    add_settings_field(
      'relative_urls', 
      'Use Relative Urls', 
      array( $this, 'relative_urls_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    ); 

    add_settings_field(
      'disable_plugin_management', 
      'Disable Plugin Management', 
      array( $this, 'disable_plugin_management_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    );

    add_settings_field(
      'use_WpBoojCache', 
      'Enable WpBoojCache', 
      array( $this, 'use_WpBoojCache_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    );

    add_settings_field(
      'use_WpBoojDebug',
      'Enable Debugger',
      array( $this, 'use_WpBoojDebug_callback' ),
      'wp-booj-admin',
      'setting_section_id'
    );

    add_settings_field(
      'use_WpBoojDraftMailer', 
      'Enable WpBooj Draft Emailer', 
      array( $this, 'use_WpBoojDraftMailer_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    );
    
    add_settings_field(
      'WpBoojDraftMailerEmails', 
      'Email addresses to notify when a non admin saves a draft', 
      array( $this, 'WpBoojDraftMailerEmails_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    );

    add_settings_field(
      'WpBoojEnableUATracking', 
      'Enable Google Analyitics Tracking', 
      array( $this, 'WpBoojEnableUATracking_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    );

    add_settings_field(
      'WpBoojUACodes', 
      'Google Tracking Codes', 
      array( $this, 'WpBoojUACodes_callback' ), 
      'wp-booj-admin', 
      'setting_section_id'
    );

  }

  /**
   * Sanitize each setting field as needed
   *
   * @param array $input Contains all settings fields as array keys
   */
  function sanitize( $input ){
    $new_input = array();
    if( isset( $input['proxy_admin_urls'] ) )
      $new_input['proxy_admin_urls'] = $input['proxy_admin_urls'] ;

    if( isset( $input['related_posts'] ) )
      $new_input['related_posts'] = $input['related_posts'];

    if( isset( $input['relative_urls'] ) )
      $new_input['relative_urls'] = $input['relative_urls'];

    if( isset( $input['disable_plugin_management'] ) )
      $new_input['disable_plugin_management'] = $input['disable_plugin_management'];

    if( isset( $input['use_WpBoojCache'] ) )
      $new_input['use_WpBoojCache'] = $input['use_WpBoojCache'];
    
    if( isset( $input['use_WpBoojDebug'] ) )
      $new_input['use_WpBoojDebug'] = $input['use_WpBoojDebug'];

    if( isset( $input['use_WpBoojDraftMailer'] ) )
      $new_input['use_WpBoojDraftMailer'] = $input['use_WpBoojDraftMailer'];

    if( isset( $input['WpBoojDraftMailerEmails'] ) )
      $new_input['WpBoojDraftMailerEmails'] = $input['WpBoojDraftMailerEmails'];

    if( isset( $input['WpBoojEnableUATracking'] ) )
      $new_input['WpBoojEnableUATracking'] = $input['WpBoojEnableUATracking'];

    if( isset( $input['WpBoojUACodes'] ) )
      $new_input['WpBoojUACodes'] = $input['WpBoojUACodes'];    

    return $new_input;
  }

  /** 
   * Print the Section text
   */
  function print_section_info(){
    print "If you don't understand these options, you will want to leave them as they are!";
  }

  /** 
   * Get the settings option array and print one of its values
   */
  function proxy_admin_urls_callback(){
    ?>
    <input type="checkbox" name="wp-booj[proxy_admin_urls]" <?php if( $this->options['proxy_admin_urls'] == 'on' ){ echo 'checked="checked"'; } ?> />        
    <?php
  }

  function related_posts_callback(){
    ?>
    <input type="checkbox" name="wp-booj[related_posts]" <?php if( $this->options['related_posts'] == 'on' ){ echo 'checked="checked"'; } ?> />        
    <?php
  }

  function relative_urls_callback(){
    ?>
    <input type="checkbox" name="wp-booj[relative_urls]" <?php if( $this->options['relative_urls'] == 'on' ){ echo 'checked="checked"'; } ?> />        
    <?php
  }

  function disable_plugin_management_callback(){
    ?>
    <input type="checkbox" name="wp-booj[disable_plugin_management]" <?php if( $this->options['disable_plugin_management'] == 'on' ){ echo 'checked="checked"'; } ?> />        
    <?php
  }

  function use_WpBoojCache_callback(){
    ?>
    <input type="checkbox" name="wp-booj[use_WpBoojCache]" <?php if( $this->options['use_WpBoojCache'] == 'on' ){ echo 'checked="checked"'; } ?> />        
    <?php
  }

  function use_WpBoojDebug_callback(){
    ?>
    <input type="checkbox" name="wp-booj[use_WpBoojDebug]" <?php if( $this->options['use_WpBoojDebug'] == 'on' ){ echo 'checked="checked"'; } ?> />        
    <?php
  }

  function use_WpBoojDraftMailer_callback(){
    ?>
    <input type="checkbox" name="wp-booj[use_WpBoojDraftMailer]" <?php if( $this->options['use_WpBoojDraftMailer'] == 'on' ){ echo 'checked="checked"'; } ?> />
    <?php
  }

  function WpBoojDraftMailerEmails_callback(){
    ?>
    <input type="text" name="wp-booj[WpBoojDraftMailerEmails]" value="<?php echo $this->options['WpBoojDraftMailerEmails']; ?>" />
    <?php
  }

  function WpBoojEnableUATracking_callback(){
    ?>
    <input type="checkbox" name="wp-booj[WpBoojEnableUATracking]" <?php if( $this->options['WpBoojEnableUATracking'] == 'on' ){ echo 'checked="checked"'; } ?> />    
    <?php
  }

  function WpBoojUACodes_callback(){
    ?>
    <input name="wp-booj[WpBoojUACodes]" value="<?php echo $this->options['WpBoojUACodes']; ?>" />    
    <?php
  }  

  /***********************************************************
     _____     _   _              _____     _       
    |  _  |_ _| |_| |_ ___ ___   |     |___| |_ ___ 
    |     | | |  _|   | . |  _|  | | | | -_|  _| .'|
    |__|__|___|_| |_|_|___|_|    |_|_|_|___|_| |__,|

    Author Meta 

    Add and display extra meta data for authors

  */

  public function booj_profile_fields_admin_display( $user ) { 
    ?>
    <h3>Enterprise Network Information</h3>
    <table class="form-table">
      <tr>
        <th><label for="twitter">Agent Bio Url</label></th>
        <td>
          <input type="text" name="agent_bio_url" id="agent_bio_url" value="<?php echo esc_attr( get_the_author_meta( 'agent_bio_url', $user->ID ) ); ?>" class="regular-text" /><br />
          <span class="description">Please enter your agent bio page web address. (ex: http://www.clarkhawaii.com/our_agents/info/leslie-m-agorastos )</span>
        </td>
      </tr>
    </table>
    <?php 
  }

  function booj_profile_fields_admin_save( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
      return false;
    update_usermeta( $user_id, 'agent_bio_url', $_POST['agent_bio_url'] );
  }



  /***********************************************************
     _____  
    |  |  |___| |___ 
    |  |  |  _| |_ -|
    |_____|_| |_|___|
  
    Urls

    This updates bad urls for the admin because of our Apache Proxy

  */

  function proxy_admin_urls(){
    // Update the HTTP_HOST because wordpress bases urls off of this
    // We're removing 7 characters, 'http://' so the site_url MUST BE ex: http://www.clarkhawaii.com/
    // @todo: Make this more robust for the above reason!
    $options = get_option( 'wp-booj' );
    if( $options['proxy_admin_urls'] == 'on' ){
      if( substr( get_site_url(), 0, 7 ) == 'http://'){
        $_SERVER['HTTP_HOST'] = substr( get_site_url(), 7 );
      } else {
        $_SERVER['HTTP_HOST'] = get_site_url() ;        
      }
      // This updates the remote_addr because of the proxy this would normally get lost
      if ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $_SERVER['REMOTE_ADDR'] = trim($ips[0]);
      } elseif ( isset($_SERVER['HTTP_X_REAL_IP']) && !empty($_SERVER['HTTP_X_REAL_IP']) ) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_X_REAL_IP'];
      } elseif ( isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) ) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CLIENT_IP'];
      }

      // Update the links we may have missed with this
      // we catch all urls that start with "/" and put /blog/ ahead
      ?>
      <script type="text/javascript">
        uri_segment = '<?php echo WpBoojFindURISegment(); ?>';
        uri_len     = uri_segment.length + 1;
        jQuery(document).ready( function() {
          jQuery('a').each( function(){
            link = jQuery(this).attr('href');
            if( link && link.length && link.substring( 0, 1 ) == '/' && link.substring( 0, uri_len ) != '/' +  uri_segment ){
              jQuery(this).attr('href', '/' + uri_segment + link );
            }
          });
          jQuery('form').each( function(){
            action = jQuery(this).attr('action');
            if( action && action.length && action.substring( 0, 1 ) == '/' && action.substring( 0, uri_len ) != '/' + uri_segment ){
              jQuery(this).attr('action', '/' + uri_segment + action );
            }
          });
        });
      </script>
      <?php
    }
  }



  /***********************************************************                      
     _____            _____                     
    |   | |___ ___   |   __|___ ___ ___ ___ ___ 
    | | | | .'| . |  |__   |  _|  _| -_| -_|   |
    |_|___|__,|_  |  |_____|___|_| |___|___|_|_|
              |___|                             

    Nag Screens

    This removes the "Update Wordpress" nag screen from the Admin 

  */

  function remove_nag() {
    remove_action('admin_notices', 'update_nag', 3);
  }

  function remove_nag_css(){
    ?>
    <style type="text/css">
      /* heres the css */
      #wp-admin-bar-updates{ display: none; }
      #menu-dashboard ul li a .update-count{ display: none; }
      .plugin-count{ display: none !important; }
    </style>
    <?php
  }

  function plugin_management(){
    $options = get_option( 'wp-booj' );
    if( $options['disable_plugin_management'] == 'on' ){
      $user = wp_get_current_user();

      if( $user->data->user_login != 'booj' &&  $user->data->user_login != 'admin' ){
        ?>
        <style type="text/css">
          #menu-links, #menu-plugins, #menu-settings, 
          #menu-tools, #menu-appearance, #toplevel_page_itsec,
          .toplevel_page_amazon-web-services 
          { display: none;}          
        </style>
        <?php
      }
    }
  }

  function email_draft_submission_to_admins( $post_id ){
    $options = get_option( 'wp-booj' );
    $post = get_post( $post_id );
    if( $options['use_WpBoojDraftMailer'] == 'on' && $options['WpBoojDraftMailerEmails'] != '' ){
      if( strpos( $options['WpBoojDraftMailerEmails'], ',' ) !== false) {
        $emails = explode( ',', $options['WpBoojDraftMailerEmails'] );
      } else {
        $emails = $options['WpBoojDraftMailerEmails'];
      }

      $post = get_post( $post_id );
      $post_title = get_the_title( $post_id );
      $post_url = get_permalink( $post_id );

      $preview_url = site_url() . '/?p=' . $post->ID . '&preview=true';
      $admin_url   = site_url() . '/wp-admin/post.php?post=' . $post->ID . '&action=edit';

      $subject = 'Blog Draft Has Been Submitted - ' . WpBooj::truncate_by_word( $post_title, 50 );
      $message  = "New post Pending review:\n\n";
      $message .= $post_title . "\n";
      $message .= 'By '. get_the_author_meta( 'display_name', $post->post_author ) . "\n";
      $message .= 'Preview Url: '. $preview_url ."\n";
      $message .= 'Admin Url:   '. $admin_url ."\n";
      // Send email to admin.
      wp_mail( $emails, $subject, $message );
    }
  }

}

?>
