<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function sb_instagram_menu() {
	add_menu_page(
		__( 'Instagram Feed', 'instagram-feed' ),
		__( 'Instagram Feed', 'instagram-feed' ),
		'manage_options',
		'sb-instagram-feed',
		'sb_instagram_settings_page'
	);
	add_submenu_page(
		'sb-instagram-feed',
		__( 'Settings', 'instagram-feed' ),
		__( 'Settings', 'instagram-feed' ),
		'manage_options',
		'sb-instagram-feed',
		'sb_instagram_settings_page'
	);
	add_submenu_page(
		'sb-instagram-feed',
		__( 'Customize', 'instagram-feed' ),
		__( 'Customize', 'instagram-feed' ),
		'manage_options',
		'sb-instagram-feed&tab=customize',
		'sb_instagram_settings_page'
	);
	add_submenu_page(
		'sb-instagram-feed',
		__( 'License', 'instagram-feed' ),
		__( 'License', 'instagram-feed' ),
		'manage_options',
		'sb-instagram-license',
		'sbi_license_page'
	);
}
add_action('admin_menu', 'sb_instagram_menu');

//Add Welcome page
add_action('admin_menu', 'sbi_welcome_menu');
function sbi_welcome_menu() {
	add_submenu_page(
		'sb-instagram-feed',
		__( "What's New?", 'instagram-feed' ),
		__( "What's New?", 'instagram-feed' ),
		'manage_options',
		'sbi-welcome-new',
		'sbi_welcome_screen_new_content'
	);
	add_submenu_page(
		'sb-instagram-feed',
		__( 'Getting Started', 'instagram-feed' ),
		__( 'Getting Started', 'instagram-feed' ),
		'manage_options',
		'sbi-welcome-started',
		'sbi_welcome_screen_started_content'
	);
}
function sbi_welcome_screen_new_content() {

	?>
    <div class="wrap about-wrap sbi-welcome">
		<?php sbi_welcome_header(); ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=sbi-welcome-new" class="nav-tab nav-tab-active"><?php _e("What's New?", 'instagram-feed' ); ?></a>
            <a href="?page=sbi-welcome-started" class="nav-tab"><?php _e('Getting Started', 'instagram-feed' ); ?></a>
        </h2>

        <p class="about-description"><?php
			$version_array = explode( '.', SBIVER );
			$major_version = $version_array[0] . '.' . $version_array[1];
			echo sprintf( __( "Let's take a look at what's new in version %s", 'instagram-feed' ), $major_version ); ?></p>

        <div class="changelog">
            <h3><?php _e('New Layout Options'); ?></h3>
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-layouts.png' , __FILE__ ) ?>" style="padding: 0px; background: white;">
                    <img src="<?php echo plugins_url( 'img/welcome-highlight.jpg' , __FILE__ ) ?>" style="padding: 0px; background: white; margin-top: 10px;">
                </div>

                <div class="sbi-feature-section-content">
                    <p><?php _e("We've added some awesome new layouts to allow you to showcase your Instagram content in more ways than ever before."); ?></p>

                    <h4><?php _e("Masonry Layout"); ?></h4>
                    <p><?php _e("Bored of squares? Display your posts in their uncropped portrait or landscape aspect ratios with the Masonry layout."); ?></p>
                    <h4><?php _e("Highlight Layout"); ?></h4>
                    <p><?php _e("The new Highlight layout allows you to highlight/enlarge specific posts in your feed in a number of ways:"); ?></p>
                    <ul>
                        <li><?php _e("Based on a set pattern"); ?></li>
                        <li><?php _e("Using specific post IDs"); ?></li>
                        <li><?php _e("Based on a specific hashtag in the caption"); ?></li>
                    </ul>
                    <p><?php _e("For example, you could set the plugin to highlight any posts which include the hashtag of #highlight."); ?></p>

                    <h4><?php _e("Directions"); ?></h4>
                    <p><?php _e("Use the options at <i>Customize &gt; General &gt; <b>Layout</b></i> to select a layout and reveal any associated options."); ?></p>
                    <p><?php _e("To change the settings in specific feeds use the <code>layout</code> shortcode option, Eg: <code>layout=highlight</code>"); ?></p>

                </div>
            </div>
        </div>

        <div class="changelog">
            <h3><?php _e('Smoother Loading and Hover Effects'); ?></h3>
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-transitions.jpg' , __FILE__ ) ?>" style="padding: 0px; background: white;">
                </div>

                <div class="sbi-feature-section-content">
                    <p><?php _e("Everyone likes to make a smooth entrance, and now your Instagram posts can too! We've made improvements to the way photos are loaded into the feed, adding a smooth transition to display photos subtly rather than suddenly. We've also made enhacements to other interactive elements - such as hovering over a photo or using the carousel - to create a more refined experience."); ?></p>
                </div>
            </div>
        </div>

        <div class="changelog">
            <h3><?php _e('Combine Multiple Feed Types'); ?></h3>
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-mixed-feed.png' , __FILE__ ) ?>" style="padding: 0px; background: white;">
                </div>

                <div class="sbi-feature-section-content">
                    <p><?php _e("Ever wanted to combine a User feed with a Hashtag feed? Well now you can, thanks to the new mixed feed setting."); ?></p>

                    <h4><?php _e("Directions"); ?></h4>
                    <p><?php _e('To display multiple feed types in a single feed, use <code>type=mixed</code> in your shortcode and then add each user name, hashtag, location, or single post IDs into the shortcode. For example: <code>[instagram-feed type=mixed user="smashballoon" hashtag="#awesomeplugins"]</code>. This will combine a user feed and a hashtag feed into the same feed.'); ?></p>

                </div>
            </div>
        </div>


        <div class="changelog">
            <h3><?php _e('Two-row Carousels and Infinite Looping'); ?></h3>
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-carousel.jpg' , __FILE__ ) ?>" style="padding: 0px; background: white;">
                </div>

                <div class="sbi-feature-section-content">
                    <p><?php _e("Feeling like one row in your carousel just isn't enough? Well now you can double up on carousel goodness with two rows of posts. We've also added inifinte looping so your users can keep on scrolling through your posts till their hands fall off."); ?></p>

                    <h4><?php _e("Directions"); ?></h4>
                    <p><?php _e('To find the new options, go to <i>Customize > General > Layout</i> and select "Carousel". There you can change the "Number of Rows" and the "Loop Type" settings. To use these only for a specific feed, use the <code>carouselrows=2</code> and <code>carouselloop=infinity</code> shortcode options.'); ?></p>

                </div>
            </div>
        </div>

        <div class="changelog">
            <h3><?php _e('More Header Options'); ?></h3>
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-header.png' , __FILE__ ) ?>" style="padding: 0px; background: white;">
                </div>

                <div class="sbi-feature-section-content">
                    <p><?php _e("Websites come in all shapes and sizes and so headers should too. That's why we've added some additional options to allow you to customize your feed header even further."); ?></p>

                    <h4><?php _e("Header Size"); ?></h4>
                    <p><?php _e("Now you can select a Small, Medium, or Large size for your header using the following setting: <i>Customize > General > Header > Header Size</i>, or the <code>headersize</code> shortcode option."); ?></p>
                    <h4><?php _e("Centered Header"); ?></h4>
                    <p><?php _e("We've added a Centered header style for the times when left-justified just doesn't feel right. Just use the setting at <i>Customize > General > Header > Header Style</i>, or the <code>headerstyle=centered</code> shortcode option."); ?></p>

                </div>
            </div>
        </div>

        <div class="changelog">
            <h3><?php _e('Reorganized Settings Pages'); ?></h3>
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-admin.png' , __FILE__ ) ?>" style="padding: 0px; background: white;">
                </div>

                <div class="sbi-feature-section-content">
                    <p><?php _e("Due to all the goodness we've been adding lately the settings pages were getting a little cluttered. We've spent some time cleaning things up and reorganizing the settings to make finding settings to customize your feeds even easier than ever."); ?></p>
                </div>
            </div>
        </div>

        <div class="changelog">
            <h3><?php _e("And that's not all..."); ?></h3>
            <div class="feature-section">

                <div class="sbi-feature-section-content" style="width: 96%;">
                    <p style="max-width: 100%;"><?php _e("We've made lots of other minor improvements and fixes too, such as:"); ?></p>

                    <ul>
                        <li>Filtering feeds using the include/exclude words settings is now much more performant</li>
                        <li>Improved the image size detection to ensure that the correct image size is always used</li>
                        <li>Improved caption truncation to account for multiple lines containing only single characters</li>
                    </ul>
                </div>
            </div>
        </div>

        <p class="sbi-footnote"><i class="fa fa-heart"></i><?php echo sprintf( __( "Your friends %s", 'instagram-feed' ), '@ <a href="https://smashballoon.com/" target="_blank">Smash Balloon</a>' ); ?></p>

    </div>
<?php }
function sbi_welcome_screen_started_content() { ?>
    <div class="wrap about-wrap sbi-welcome">
		<?php sbi_welcome_header(); ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=sbi-welcome-new" class="nav-tab"><?php _e("What's New?", 'instagram-feed' ); ?></a>
            <a href="?page=sbi-welcome-started" class="nav-tab nav-tab-active"><?php _e('Getting Started', 'instagram-feed' ); ?></a>
        </h2>

        <p class="about-description"><?php _e("Your first time using the plugin? Let's help you get started...", 'instagram-feed' ); ?></p>

        <div class="sbi-123">
            <div class="changelog">
                <div class="feature-section">
                    <div class="sbi-feature-section-media">
                        <img src="<?php echo plugins_url( 'img/welcome-license.png' , __FILE__ ) ?>">
                    </div>

                    <div class="sbi-feature-section-content">
                        <h3><span class="sbi-big-text">1</span><?php _e("Activate Your License Key", 'instagram-feed' ); ?></h3>
                        <p><?php echo sprintf( __( "In order to receive updates for the plugin you'll need to activate your license key by entering it %s.", 'instagram-feed' ), '<a href="admin.php?page=sb-instagram-license" target="_blank">here</a>' ); ?></p>
                    </div>
                </div>
            </div>

            <div class="changelog">
                <div class="feature-section">
                    <div class="sbi-feature-section-media">
                        <img src="<?php echo plugins_url( 'img/welcome-token.jpg' , __FILE__ ) ?>">
                    </div>
                    <div class="sbi-feature-section-content">
                        <h3><span class="sbi-big-text">2</span><?php _e("Get your Access Token", 'instagram-feed' ); ?></h3>
                        <p><?php echo sprintf( __( "We've made configuring your feed super simple. Just use the big blue button on the plugin's %s to connect your Instagram account.", 'instagram-feed' ), '<a href="admin.php?page=sb-instagram-feed&amp;tab=configure" target="_blank">' . __("Settings page") . '</a>' ); ?></p>
                    </div>
                </div>
            </div>

            <div class="changelog">
                <div class="feature-section">
                    <div class="sbi-feature-section-media">
                        <img src="<?php echo plugins_url( 'img/welcome-type.png' , __FILE__ ) ?>">
                    </div>
                    <div class="sbi-feature-section-content">
                        <h3><span class="sbi-big-text">3</span><?php _e("Select your Feed Type", 'instagram-feed' ); ?></h3>
                        <p><?php _e("Choose to display posts from a user account, hashtag, location, or coordinates. You can also choose to display single posts from an account you've connected to.", 'instagram-feed' ); ?></p>
                    </div>
                </div>
            </div>

            <div class="changelog">
                <div class="feature-section">
                    <div class="sbi-feature-section-media">
                        <img src="<?php echo plugins_url( 'img/welcome-shortcode.png' , __FILE__ ) ?>">
                    </div>
                    <div class="sbi-feature-section-content">
                        <h3><span class="sbi-big-text">4</span><?php _e("Display Your Feed", 'instagram-feed' ); ?></h3>
                        <p><?php echo sprintf( __("To display your feed simply copy and paste the %s shortcode wherever you want the feed to show up; any page, post, or widget. It really is that simple!", 'instagram-feed' ), '&nbsp;<code>[instagram-feed]</code>&nbsp;' );?></p>
                        <p><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php echo sprintf( __('Need more help? See our %s.', 'instagram-feed' ), '<a href="admin.php?page=sb-instagram-feed&amp;tab=support" target="_blank">' . __( 'Support Section', 'instagram-feed' ) . '</a>' ); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="changelog">
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-multiple.jpg' , __FILE__ ) ?>">
                </div>
                <div class="sbi-feature-section-content">
                    <h3><?php _e("Multiple Feeds", 'instagram-feed' ); ?></h3>
                    <p><?php echo sprintf( __( "You can display as many feeds on your site as you'd like. Just use our handy %s to customize each one as needed.", 'instagram-feed' ), '<a href="admin.php?page=sb-instagram-feed&amp;tab=display" target="_blank">' . __( "shortcode options", 'instagram-feed' ) . '</a>' ); ?></p>

                    <p><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp; <a href="https://smashballoon.com/display-multiple-instagram-feeds/" target="_blank"><?php _e('More help', 'instagram-feed' ); ?></a></p>
                </div>
            </div>
        </div>

        <div class="changelog">
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <img src="<?php echo plugins_url( 'img/welcome-customize.png' , __FILE__ ) ?>">
                </div>
                <div class="sbi-feature-section-content">
                    <h3><?php _e("Customize Your Feed", 'instagram-feed' ); ?></h3>
                    <p><?php _e("There are countless ways to customize your Instagram feed. Whether it be translating the text, changing layouts and colors, or using powerful custom code snippets.", 'instagram-feed' );?></p>

                    <h4><?php _e("Layout", 'instagram-feed' ); ?></h4>
                    <p><?php _e("Choose from different feed types, change the layout, and even display your content in a rotating carousel.", 'instagram-feed' ); ?></p>

                    <p><i class="fa fa-file-text-o" aria-hidden="true"></i>&nbsp; <?php _e("Find out more:", 'instagram-feed' ); ?>
                        <a href="https://smashballoon.com/creating-basic-instagram-slideshow/" target="_blank"><?php _e("Creating carousels", 'instagram-feed' ); ?></a>.
                    </p>

                    <h4><?php _e("Styling options"); ?></h4>
                    <p><?php _e("Choose which information to show or hide, customize colors and text, and style each individual part of your feed.", 'instagram-feed' ); ?> <a href="admin.php?page=sb-instagram-feed&amp;tab=customize"><?php _e("Go to the Customize page", 'instagram-feed' ); ?></a>.</p>

                    <h4><?php _e("Advanced Customizations", 'instagram-feed' ); ?></h4>
                    <p><?php _e("You can achieve some pretty advanced customizations using the plugin. Here's some examples:", 'instagram-feed' ); ?></p>

                    <p><i class="fa fa-file-text-o" aria-hidden="true"></i> <a href="https://smashballoon.com/guide-to-moderation-mode/" target="_blank"><?php _e("Moderating your feed", 'instagram-feed' ); ?></a> &nbsp;&middot;&nbsp;
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <a href="https://smashballoon.com/can-display-photos-specific-hashtag-specific-user-id/" target="_blank"><?php _e("Filtering posts by word or hashtag", 'instagram-feed' ); ?></a> &nbsp;&middot;&nbsp;
                        <i class="fa fa-file-text-o" aria-hidden="true"></i> <a href="https://smashballoon.com/make-a-shoppable-feed/" target="_blank"><?php _e('Creating a "Shoppable" feed', 'instagram-feed' ); ?></a>
                    </p>
                </div>
            </div>
        </div>

        <div class="changelog">
            <div class="feature-section">
                <div class="sbi-feature-section-media">
                    <a href='admin.php?page=sbi-top&amp;tab=support'><img src="<?php echo plugins_url( 'img/welcome-support.png' , __FILE__ ) ?>"></a>
                </div>
                <div class="sbi-feature-section-content">
                    <h3><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php _e("Need some more help?", 'instagram-feed' ); ?></h3>
                    <p><?php echo sprintf( __( "Check out our %s which includes helpful links, a tutorial video, and more.", 'instagram-feed' ), '<a href="admin.php?page=sb-instagram-feed&tab=support">'. __('Support Section', 'instagram-feed' ) . '</a>' );?></p>
                </div>
            </div>
        </div>

        <p class="sbi-footnote"><i class="fa fa-heart"></i><?php echo sprintf( __( "Your friends %s", 'instagram-feed' ), '@ <a href="https://smashballoon.com/" target="_blank">Smash Balloon</a>' ); ?></p>

    </div>
<?php }
function sbi_welcome_header(){ ?>
	<?php
	//Set an option that shows that the welcome page has been seen
	update_option( 'sbi_welcome_seen', true );
	// user has seen notice
	add_user_meta(get_current_user_id(), 'sbi_seen_welcome_'.SBI_WELCOME_VER, 'true', true);

	?>
    <div id="sbi-header">
        <a href="admin.php?page=sb-instagram-feed" class="sbi-welcome-close"><i class="fa fa-times"></i></a>
        <a href="https://smashballoon.com" class="sbi-welcome-image" title="Your friends at Smash Balloon" target="_blank">
            <img src="<?php echo plugins_url( 'img/balloon.png' , __FILE__ ) ?>" alt="Instagram Feed Pro">
        </a>
        <h1><?php _e("Welcome to Instagram Feed Pro", 'instagram-feed' ); ?></h1>
        <p class="about-text">
			<?php
			$version_array = explode( '.', SBIVER );
			$major_version = $version_array[0] . '.' . $version_array[1];
			echo sprintf( __( "Thanks for installing <b>Version %s</b> of the Instagram Feed Pro plugin! Use the tabs below to see what's new or to get started using the plugin.", 'instagram-feed' ), $major_version ); ?>
        </p>
    </div>
<?php }

add_action('admin_notices', 'sbi_welcome_page_notice');
function sbi_welcome_page_notice() {

	global $current_user;
	$user_id = $current_user->ID;

	// delete_transient( 'sbi_show_welcome_notice_transient' );
	// delete_option('sbi_welcome_'.SBI_WELCOME_VER.'_transient_set');

	if( current_user_can( 'manage_options' ) ){

		if( get_transient('sbi_show_welcome_notice_transient') || !get_option('sbi_welcome_'.SBI_WELCOME_VER.'_transient_set') ){

			// Use these to show notice again for testing
			// delete_user_meta($user_id, 'sbi_ignore_'.SBI_WELCOME_VER.'_welcome_notice');
			// delete_user_meta($user_id, 'sbi_seen_welcome_'.SBI_WELCOME_VER);

			if( get_user_meta($user_id, 'sbi_ignore_'.SBI_WELCOME_VER.'_welcome_notice') || get_user_meta($user_id, 'sbi_seen_welcome_'.SBI_WELCOME_VER) || (isset($_GET['page']) && ('sbi-welcome-new' == $_GET['page'] || 'sbi-welcome-started' == $_GET['page'])) ) return;

			_e("
                <div class='sbi_welcome_page_notice sb_instagram_notice'>
                    <a style='float:right; color: #dd3d36; text-decoration: none;' href='" .esc_url( add_query_arg( 'sbi_ignore_'.SBI_WELCOME_VER.'_welcome_notice', '0' ) ). "'><i class='fa fa-times'></i> Dismiss</a>
                    <!-- <img src='" . plugins_url( 'img/balloon.png' , __FILE__ ) . "' style='float: left; width: 40px; height: 40px; margin-right: 15px; border-radius: 5px; box-shadow: 0 0 1px 0 #BA7B7B;'> -->
                    <p><i class='fa fa-instagram'></i> We've added some great new features to the Instagram Feed plugin. <a href='".admin_url( 'admin.php?page=sbi-welcome-new' )."'>See what's new.</a></p> 
                </div>
                ");

		} else {

			//If the transient hasn't been set before then set it for 24 hours
			if( !get_option('sbi_welcome_'.SBI_WELCOME_VER.'_transient_set') ){
				set_transient( 'sbi_show_welcome_notice_transient', 'true', 86400 );
				update_option('sbi_welcome_'.SBI_WELCOME_VER.'_transient_set', true);
			}

		}

	}

}

add_action('admin_init', 'sbi_welcome_page_banner_ignore');
function sbi_welcome_page_banner_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	if ( isset($_GET['sbi_ignore_'.SBI_WELCOME_VER.'_welcome_notice']) && '0' == $_GET['sbi_ignore_'.SBI_WELCOME_VER.'_welcome_notice']) {
		add_user_meta($user_id, 'sbi_ignore_'.SBI_WELCOME_VER.'_welcome_notice', 'true', true);
	}
}

add_action( 'admin_init', 'sbi_welcome_screen_do_activation_redirect' );
function sbi_welcome_screen_do_activation_redirect() {

	// Delete settings for testing
	// delete_user_meta(get_current_user_id(), 'sbi_seen_welcome_'.SBI_WELCOME_VER);
	// delete_option( 'sbi_ver' );

	// Check whether a 30-second transient has been set by the activation function. If it has then potentially redirect to the Getting Started page.
	if ( get_transient( '_sbi_activation_redirect' ) ){

		// Delete the redirect transient
		delete_transient( '_sbi_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		$sbi_ver = get_option( 'sbi_ver' );
		if ( ! $sbi_ver ) {
			update_option( 'sbi_ver', SBIVER );
			sb_instagram_clear_page_caches();
			wp_safe_redirect( admin_url( 'admin.php?page=sbi-welcome-started' ) );

			exit;
		}
	} else {

		if ( isset($_GET['page']) && 'sb-instagram-feed' == $_GET['page'] && !get_user_meta(get_current_user_id(), 'sbi_seen_welcome_'.SBI_WELCOME_VER) )  {
			wp_safe_redirect( admin_url( 'admin.php?page=sbi-welcome-new' ) );
			exit;
		}

	}

}


function sbi_register_option() {
	// creates our settings in the options table
	register_setting('sbi_license', 'sbi_license_key', 'sbi_sanitize_license' );
}
add_action('admin_init', 'sbi_register_option');

function sbi_sanitize_license( $new ) {
	$old = get_option( 'sbi_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'sbi_license_status' ); // new license has been entered, so must reactivate
	}
	return $new;
}

function sbi_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['sbi_license_activate'] ) ) {

		// run a quick security check
		if( ! check_admin_referer( 'sbi_nonce', 'sbi_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$sbi_license = trim( get_option( 'sbi_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'activate_license',
			'license'   => $sbi_license,
			'item_name' => urlencode( SBI_PLUGIN_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, SBI_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$sbi_license_data = json_decode( wp_remote_retrieve_body( $response ) );

		//store the license data in an option
		update_option( 'sbi_license_data', $sbi_license_data );

		// $license_data->license will be either "valid" or "invalid"

		update_option( 'sbi_license_status', $sbi_license_data->license );

	}
}
add_action('admin_init', 'sbi_activate_license');

function sbi_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['sbi_license_deactivate'] ) ) {

		// run a quick security check
		if( ! check_admin_referer( 'sbi_nonce', 'sbi_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$sbi_license= trim( get_option( 'sbi_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license'   => $sbi_license,
			'item_name' => urlencode( SBI_PLUGIN_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, SBI_STORE_URL ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$sbi_license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $sbi_license_data->license == 'deactivated' )
			delete_option( 'sbi_license_status' );

	}
}
add_action('admin_init', 'sbi_deactivate_license');


//License page
function sbi_license_page() {
	$sbi_license    = trim( get_option( 'sbi_license_key' ) );
	$sbi_status     = get_option( 'sbi_license_status' );
	?>

    <div id="sbi_admin" class="wrap">

        <div id="header">
            <h1><?php _e('Instagram Feed Pro', 'instagram-feed' ); ?></h1>
        </div>

		<?php sbi_expiration_notice(); ?>

        <form name="form1" method="post" action="options.php">

            <h2 class="nav-tab-wrapper">
                <a href="?page=sb-instagram-feed&amp;tab=configure" class="nav-tab"><?php _e('1. Configure', 'instagram-feed' ); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=customize" class="nav-tab"><?php _e('2. Customize', 'instagram-feed' ); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=display" class="nav-tab"><?php _e('3. Display Your Feed', 'instagram-feed' ); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=support" class="nav-tab"><?php _e('Support', 'instagram-feed' ); ?></a>
                <a href="?page=sb-instagram-license" class="nav-tab nav-tab-active"><?php _e('License', 'instagram-feed' ); ?></a>
            </h2>

			<?php settings_fields('sbi_license'); ?>

			<?php
			// data to send in our API request
			$sbi_api_params = array(
				'edd_action'=> 'check_license',
				'license'   => $sbi_license,
				'item_name' => urlencode( SBI_PLUGIN_NAME ) // the name of our product in EDD
			);

			// Call the custom API.
			$sbi_response = wp_remote_get( add_query_arg( $sbi_api_params, SBI_STORE_URL ), array( 'timeout' => 60, 'sslverify' => false ) );

			// decode the license data
			$sbi_license_data = (array) json_decode( wp_remote_retrieve_body( $sbi_response ) );

			//Store license data in db unless the data comes back empty as wasn't able to connect to our website to get it
			if( !empty($sbi_license_data) ) update_option( 'sbi_license_data', $sbi_license_data );

			?>

            <table class="form-table">
                <tbody>
                <h3><?php _e('License', 'instagram-feed' ); ?></h3>

                <tr valign="top">
                    <th scope="row" valign="top">
						<?php _e('Enter your license key', 'instagram-feed' ); ?>
                    </th>
                    <td>
                        <input id="sbi_license_key" name="sbi_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $sbi_license ); ?>" />

						<?php if( false !== $sbi_license ) { ?>

							<?php if( $sbi_status !== false && $sbi_status == 'valid' ) { ?>
								<?php wp_nonce_field( 'sbi_nonce', 'sbi_nonce' ); ?>
                                <input type="submit" class="button-secondary" name="sbi_license_deactivate" value="<?php _e('Deactivate License', 'instagram-feed' ); ?>"/>

								<?php if($sbi_license_data['license'] == 'expired'){ ?>
                                    <span class="sbi_license_status" style="color:red;"><?php _e('Expired', 'instagram-feed' ); ?></span>
								<?php } else { ?>
                                    <span class="sbi_license_status" style="color:green;"><?php _e('Active', 'instagram-feed' ); ?></span>
								<?php } ?>

							<?php } else {
								wp_nonce_field( 'sbi_nonce', 'sbi_nonce' ); ?>
                                <input type="submit" class="button-secondary" name="sbi_license_activate" value="<?php _e('Activate License', 'instagram-feed' ); ?>"/>

								<?php if($sbi_license_data['license'] == 'expired'){ ?>
                                    <span class="sbi_license_status" style="color:red;"><?php _e('Expired', 'instagram-feed' ); ?></span>
								<?php } else { ?>
                                    <span class="sbi_license_status" style="color:red;"><?php _e('Inactive', 'instagram-feed' ); ?></span>
								<?php } ?>

							<?php } ?>
						<?php } ?>

                        <br />
                        <i style="color: #666; font-size: 11px;"><?php _e('The license key you received when purchasing the plugin.', 'instagram-feed' ); ?></i>
						<?php global $sbi_download_id; ?>
                        <p style="font-size: 13px;">
                            <a href='https://smashballoon.com/checkout/?edd_license_key=<?php echo trim($sbi_license) ?>&amp;download_id=<?php echo $sbi_download_id ?>' target='_blank'><?php _e("Renew your license", 'instagram-feed' ); ?></a>
                            &nbsp;&nbsp;&nbsp;&middot;
                            <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("Upgrade your license", 'instagram-feed' ); ?></a>
                            <span class="sbi_tooltip">
                                    <?php _e("You can upgrade your license in two ways:", 'instagram-feed'); ?><br />
                                    &bull;&nbsp; <?php echo sprintf( __( "Log into %s and click on the 'Upgrade my License' tab", 'instagram-feed' ), '<a href="https://smashballoon.com/account" target="_blank">' . __('your Account', 'instagram-feed' ) . '</a>'); ?><br />
                                    &bull;&nbsp; <a href='https://smashballoon.com/contact/' target='_blank'><?php _e( 'Contact us directly', 'instagram-feed' ); ?></a>
                                </span>

                        </p>


                    </td>
                </tr>

                </tbody>
            </table>
			<?php submit_button(); ?>

        </form>

    </div>

	<?php
} //End License page

function sb_instagram_settings_page() {

	$sbi_welcome_seen = get_option( 'sbi_welcome_seen' );
	if( $sbi_welcome_seen == false ){ ?>
        <p class="sbi-page-loading"><?php _e("Loading...", 'instagram-feed'); ?></p>
        <script>window.location = "<?php echo admin_url( 'admin.php?page=sbi-welcome-new' ); ?>";</script>
	<?php }

	//Hidden fields
	$sb_instagram_settings_hidden_field = 'sb_instagram_settings_hidden_field';
	$sb_instagram_configure_hidden_field = 'sb_instagram_configure_hidden_field';
	$sb_instagram_customize_hidden_field = 'sb_instagram_customize_hidden_field';
	$sb_instagram_customize_posts_hidden_field = 'sb_instagram_customize_posts_hidden_field';
	$sb_instagram_customize_moderation_hidden_field = 'sb_instagram_customize_moderation_hidden_field';
	$sb_instagram_customize_advanced_hidden_field = 'sb_instagram_customize_advanced_hidden_field';

	//Declare defaults
	$sb_instagram_settings_defaults = array(
		'sb_instagram_at'                   => '',
		'sb_instagram_type'                 => 'user',
		'sb_instagram_user_id'              => '',
		'sb_instagram_hashtag'              => '',
		'sb_instagram_type_self_likes'      => '',
		'sb_instagram_location'             => '',
		'sb_instagram_coordinates'          => '',
		'sb_instagram_preserve_settings'    => '',
		'sb_instagram_ajax_theme'           => false,
		'sb_instagram_cache_time'           => '1',
		'sb_instagram_cache_time_unit'      => 'hours',

		'sb_instagram_width'                => '100',
		'sb_instagram_width_unit'           => '%',
		'sb_instagram_feed_width_resp'      => false,
		'sb_instagram_height'               => '',
		'sb_instagram_num'                  => '20',
		'sb_instagram_nummobile'            => '',
		'sb_instagram_height_unit'          => '',
		'sb_instagram_cols'                 => '4',
		'sb_instagram_colsmobile'           => 'auto',
		'sb_instagram_image_padding'        => '5',
		'sb_instagram_image_padding_unit'   => 'px',

		//Layout Type
		'sb_instagram_layout_type'          => 'grid',
		'sb_instagram_highlight_type'       => 'pattern',
		'sb_instagram_highlight_offset'     => 0,
		'sb_instagram_highlight_factor'     => 6,
		'sb_instagram_highlight_ids'        => '',
		'sb_instagram_highlight_hashtag'    => '',

		//Hover style
		'sb_hover_background'               => '',
		'sb_hover_text'                     => '',
		'sbi_hover_inc_username'            => true,
		'sbi_hover_inc_icon'                => true,
		'sbi_hover_inc_date'                => true,
		'sbi_hover_inc_instagram'           => true,
		'sbi_hover_inc_location'            => false,
		'sbi_hover_inc_caption'             => false,
		'sbi_hover_inc_likes'               => false,
		// 'sb_instagram_hover_text_size'      => '',

		'sb_instagram_sort'                 => 'none',
		'sb_instagram_disable_lightbox'     => false,
		'sb_instagram_captionlinks'         => false,
		'sb_instagram_background'           => '',
		'sb_instagram_show_btn'             => true,
		'sb_instagram_btn_background'       => '',
		'sb_instagram_btn_text_color'       => '',
		'sb_instagram_btn_text'             => __( 'Load More', 'instagram-feed' ),
		'sb_instagram_image_res'            => 'auto',
		'sb_instagram_media_type'           => 'all',
		'sb_instagram_moderation_mode'      => 'manual',
		'sb_instagram_hide_photos'          => '',
		'sb_instagram_block_users'          => '',
		'sb_instagram_ex_apply_to'          => 'all',
		'sb_instagram_inc_apply_to'         => 'all',
		'sb_instagram_show_users'           => '',
		'sb_instagram_exclude_words'        => '',
		'sb_instagram_include_words'        => '',

		//Text
		'sb_instagram_show_caption'         => true,
		'sb_instagram_caption_length'       => '50',
		'sb_instagram_caption_color'        => '',
		'sb_instagram_caption_size'         => '13',

		//lightbox comments
		'sb_instagram_lightbox_comments'    => true,
		'sb_instagram_num_comments'         => '20',

		//Meta
		'sb_instagram_show_meta'            => true,
		'sb_instagram_meta_color'           => '',
		'sb_instagram_meta_size'            => '13',
		//Header
		'sb_instagram_show_header'          => true,
		'sb_instagram_header_color'         => '',
		'sb_instagram_header_style'         => 'standard',
		'sb_instagram_show_followers'       => true,
		'sb_instagram_show_bio'             => true,
		'sb_instagram_header_primary_color'  => '517fa4',
		'sb_instagram_header_secondary_color'  => 'eeeeee',
		'sb_instagram_header_size'  => 'small',


		//Follow button
		'sb_instagram_show_follow_btn'      => true,
		'sb_instagram_folow_btn_background' => '',
		'sb_instagram_follow_btn_text_color' => '',
		'sb_instagram_follow_btn_text'      => __( 'Follow on Instagram', 'instagram-feed' ),

		//Autoscroll
		'sb_instagram_autoscroll' => false,
		'sb_instagram_autoscrolldistance' => 200,

		//Misc
		'sb_instagram_custom_css'           => '',
		'sb_instagram_custom_js'            => '',
		'sb_instagram_requests_max'         => '5',
		'sb_instagram_cron'                 => 'unset',
		'sb_instagram_disable_font'         => false,
		'check_api'         => true,
		'sb_instagram_backup' => true,
		'enqueue_js_in_head' => false,
		'enqueue_css_in_shortcode' => false,
		'sb_instagram_disable_mob_swipe' => false,
		'sbi_font_method' => 'svg',
		'sbi_br_adjust' => true,


		//Carousel
		'sb_instagram_carousel'             => false,
		'sb_instagram_carousel_rows'        => 1,
		'sb_instagram_carousel_loop'        => 'rewind',
		'sb_instagram_carousel_arrows'      => false,
		'sb_instagram_carousel_pag'         => true,
		'sb_instagram_carousel_autoplay'    => false,
		'sb_instagram_carousel_interval'    => '5000'

	);
	//Save defaults in an array
	$options = wp_parse_args(get_option('sb_instagram_settings'), $sb_instagram_settings_defaults);
	update_option( 'sb_instagram_settings', $options );
	if ( isset( $_POST['sbi_just_saved'] )) {
		echo '<input id="sbi_just_saved" type="hidden" name="sbi_just_saved" value="1">';
	}
	//Set the page variables
	$sb_instagram_at = $options[ 'sb_instagram_at' ];
	$sb_instagram_type = $options[ 'sb_instagram_type' ];
	$sb_instagram_user_id = $options[ 'sb_instagram_user_id' ];
	$sb_instagram_hashtag = $options[ 'sb_instagram_hashtag' ];
	$sb_instagram_type_self_likes = $options[ 'sb_instagram_type_self_likes' ];
	$sb_instagram_location = $options[ 'sb_instagram_location' ];
	$sb_instagram_coordinates = $options[ 'sb_instagram_coordinates' ];
	$sb_instagram_preserve_settings = $options[ 'sb_instagram_preserve_settings' ];
	$sb_instagram_ajax_theme = $options[ 'sb_instagram_ajax_theme' ];
	$sb_instagram_cache_time = $options[ 'sb_instagram_cache_time' ];
	$sb_instagram_cache_time_unit = $options[ 'sb_instagram_cache_time_unit' ];

	$sb_instagram_width = $options[ 'sb_instagram_width' ];
	$sb_instagram_width_unit = $options[ 'sb_instagram_width_unit' ];
	$sb_instagram_feed_width_resp = $options[ 'sb_instagram_feed_width_resp' ];
	$sb_instagram_height = $options[ 'sb_instagram_height' ];
	$sb_instagram_height_unit = $options[ 'sb_instagram_height_unit' ];
	$sb_instagram_num = $options[ 'sb_instagram_num' ];
	$sb_instagram_nummobile = $options[ 'sb_instagram_nummobile' ];
	$sb_instagram_cols = $options[ 'sb_instagram_cols' ];
	$sb_instagram_colsmobile = $options[ 'sb_instagram_colsmobile' ];

	$sb_instagram_disable_mobile = isset( $options[ 'sb_instagram_disable_mobile' ] ) && ( $options[ 'sb_instagram_disable_mobile' ] == 'on' || $options[ 'sb_instagram_disable_mobile' ] == true ) ? true : false;
	$sb_instagram_image_padding = $options[ 'sb_instagram_image_padding' ];
	$sb_instagram_image_padding_unit = $options[ 'sb_instagram_image_padding_unit' ];

	//Layout Type
	$sb_instagram_layout_type = $options[ 'sb_instagram_layout_type' ];
	$sb_instagram_highlight_type = $options[ 'sb_instagram_highlight_type' ];
	$sb_instagram_highlight_offset = $options[ 'sb_instagram_highlight_offset' ];
	$sb_instagram_highlight_factor = $options[ 'sb_instagram_highlight_factor' ];
	$sb_instagram_highlight_ids = $options[ 'sb_instagram_highlight_ids' ];
	$sb_instagram_highlight_hashtag = $options[ 'sb_instagram_highlight_hashtag' ];

	//Lightbox Comments
	$sb_instagram_lightbox_comments = $options[ 'sb_instagram_lightbox_comments' ];
	$sb_instagram_num_comments = $options[ 'sb_instagram_num_comments' ];

	//Photo hover style
	$sb_hover_background = $options[ 'sb_hover_background' ];
	$sb_hover_text = $options[ 'sb_hover_text' ];
	$sbi_hover_inc_username = $options[ 'sbi_hover_inc_username' ];
	$sbi_hover_inc_icon = $options[ 'sbi_hover_inc_icon' ];
	$sbi_hover_inc_date = $options[ 'sbi_hover_inc_date' ];
	$sbi_hover_inc_instagram = $options[ 'sbi_hover_inc_instagram' ];
	$sbi_hover_inc_location = $options[ 'sbi_hover_inc_location' ];
	$sbi_hover_inc_caption = $options[ 'sbi_hover_inc_caption' ];
	$sbi_hover_inc_likes = $options[ 'sbi_hover_inc_likes' ];

	$sb_instagram_sort = $options[ 'sb_instagram_sort' ];
	$sb_instagram_disable_lightbox = $options[ 'sb_instagram_disable_lightbox' ];
	$sb_instagram_captionlinks = $options[ 'sb_instagram_captionlinks' ];
	$sb_instagram_background = $options[ 'sb_instagram_background' ];
	$sb_instagram_show_btn = $options[ 'sb_instagram_show_btn' ];
	$sb_instagram_btn_background = $options[ 'sb_instagram_btn_background' ];
	$sb_instagram_btn_text_color = $options[ 'sb_instagram_btn_text_color' ];
	$sb_instagram_btn_text = $options[ 'sb_instagram_btn_text' ];
	$sb_instagram_image_res = $options[ 'sb_instagram_image_res' ];
	$sb_instagram_media_type = $options[ 'sb_instagram_media_type' ];
	$sb_instagram_moderation_mode = $options[ 'sb_instagram_moderation_mode' ];
	$sb_instagram_hide_photos = $options[ 'sb_instagram_hide_photos' ];
	$sb_instagram_block_users = $options[ 'sb_instagram_block_users' ];
	$sb_instagram_ex_apply_to = $options[ 'sb_instagram_ex_apply_to' ];
	$sb_instagram_inc_apply_to = $options[ 'sb_instagram_inc_apply_to' ];
	$sb_instagram_show_users = $options[ 'sb_instagram_show_users' ];
	$sb_instagram_exclude_words = $options[ 'sb_instagram_exclude_words' ];
	$sb_instagram_include_words = $options[ 'sb_instagram_include_words' ];

	//Text
	$sb_instagram_show_caption = $options[ 'sb_instagram_show_caption' ];
	$sb_instagram_caption_length = $options[ 'sb_instagram_caption_length' ];
	$sb_instagram_caption_color = $options[ 'sb_instagram_caption_color' ];
	$sb_instagram_caption_size = $options[ 'sb_instagram_caption_size' ];
	//Meta
	$sb_instagram_show_meta = $options[ 'sb_instagram_show_meta' ];
	$sb_instagram_meta_color = $options[ 'sb_instagram_meta_color' ];
	$sb_instagram_meta_size = $options[ 'sb_instagram_meta_size' ];
	//Header
	$sb_instagram_show_header = $options[ 'sb_instagram_show_header' ];
	$sb_instagram_header_color = $options[ 'sb_instagram_header_color' ];
	$sb_instagram_header_style = $options[ 'sb_instagram_header_style' ];
	$sb_instagram_show_followers = $options[ 'sb_instagram_show_followers' ];
	$sb_instagram_show_bio = $options[ 'sb_instagram_show_bio' ];
	$sb_instagram_header_primary_color = $options[ 'sb_instagram_header_primary_color' ];
	$sb_instagram_header_secondary_color = $options[ 'sb_instagram_header_secondary_color' ];
	$sb_instagram_header_size = $options[ 'sb_instagram_header_size' ];

	//Follow button
	$sb_instagram_show_follow_btn = $options[ 'sb_instagram_show_follow_btn' ];
	$sb_instagram_folow_btn_background = $options[ 'sb_instagram_folow_btn_background' ];
	$sb_instagram_follow_btn_text_color = $options[ 'sb_instagram_follow_btn_text_color' ];
	$sb_instagram_follow_btn_text = $options[ 'sb_instagram_follow_btn_text' ];

	//Autoscroll
	$sb_instagram_autoscroll = $options[ 'sb_instagram_autoscroll' ];
	$sb_instagram_autoscrolldistance = $options[ 'sb_instagram_autoscrolldistance' ];

	//Misc
	$sb_instagram_custom_css = $options[ 'sb_instagram_custom_css' ];
	$sb_instagram_custom_js = $options[ 'sb_instagram_custom_js' ];
	$sb_instagram_requests_max = $options[ 'sb_instagram_requests_max' ];
	$sb_instagram_cron = $options[ 'sb_instagram_cron' ];
	$sb_instagram_disable_font = $options[ 'sb_instagram_disable_font' ];
	$check_api = $options[ 'check_api' ];
	$sb_instagram_backup = $options[ 'sb_instagram_backup' ];
	$enqueue_js_in_head = $options[ 'enqueue_js_in_head' ];
	$enqueue_css_in_shortcode = $options[ 'enqueue_css_in_shortcode' ];
	$sb_instagram_disable_mob_swipe = $options[ 'sb_instagram_disable_mob_swipe' ];
	$sbi_font_method = $options[ 'sbi_font_method' ];
	$sbi_br_adjust = $options[ 'sbi_br_adjust' ];

	//Carousel
	$sb_instagram_carousel = $options[ 'sb_instagram_carousel' ];
	$sb_instagram_carousel_rows = $options[ 'sb_instagram_carousel_rows' ];
	$sb_instagram_carousel_loop = $options[ 'sb_instagram_carousel_loop' ];
	$sb_instagram_carousel_arrows = $options[ 'sb_instagram_carousel_arrows' ];
	$sb_instagram_carousel_pag = $options[ 'sb_instagram_carousel_pag' ];
	$sb_instagram_carousel_autoplay = $options[ 'sb_instagram_carousel_autoplay' ];
	$sb_instagram_carousel_interval = $options[ 'sb_instagram_carousel_interval' ];


	//Check nonce before saving data
	if ( ! isset( $_POST['sb_instagram_pro_settings_nonce'] ) || ! wp_verify_nonce( $_POST['sb_instagram_pro_settings_nonce'], 'sb_instagram_pro_saving_settings' ) ) {
		//Nonce did not verify
	} else {

		// See if the user has posted us some information. If they did, this hidden field will be set to 'Y'.
		if( isset($_POST[ $sb_instagram_settings_hidden_field ]) && $_POST[ $sb_instagram_settings_hidden_field ] == 'Y' ) {

			if( isset($_POST[ $sb_instagram_configure_hidden_field ]) && $_POST[ $sb_instagram_configure_hidden_field ] == 'Y' ) {
				if (isset($_POST[ 'sb_instagram_at' ]) ) $sb_instagram_at = sanitize_text_field( $_POST[ 'sb_instagram_at' ] );
				if (isset($_POST[ 'sb_instagram_type' ]) ) $sb_instagram_type = $_POST[ 'sb_instagram_type' ];

				$sb_instagram_user_id = array();
				if ( isset( $_POST[ 'sb_instagram_user_id' ] )) {
					if ( is_array( $_POST[ 'sb_instagram_user_id' ] ) ) {
						foreach( $_POST[ 'sb_instagram_user_id' ] as $user_id ) {
							$sb_instagram_user_id[] = sanitize_text_field( $user_id );
						}
					} else {
						$sb_instagram_user_id[] = sanitize_text_field( $_POST[ 'sb_instagram_user_id' ] );
					}
				}

				if (isset($_POST[ 'sb_instagram_hashtag' ]) ) $sb_instagram_hashtag = sanitize_text_field( $_POST[ 'sb_instagram_hashtag' ] );
				if (isset($_POST[ 'sb_instagram_type_self_likes' ]) ) $sb_instagram_type_self_likes = $_POST[ 'sb_instagram_type_self_likes' ];
				if (isset($_POST[ 'sb_instagram_location' ]) ) $sb_instagram_location = sanitize_text_field( $_POST[ 'sb_instagram_location' ] );
				if (isset($_POST[ 'sb_instagram_coordinates' ]) ) $sb_instagram_coordinates = sanitize_text_field( $_POST[ 'sb_instagram_coordinates' ] );

				isset($_POST[ 'sb_instagram_preserve_settings' ]) ? $sb_instagram_preserve_settings = $_POST[ 'sb_instagram_preserve_settings' ] : $sb_instagram_preserve_settings = '';
				if (isset($_POST[ 'sb_instagram_cache_time' ]) ) $sb_instagram_cache_time = sanitize_text_field( $_POST[ 'sb_instagram_cache_time' ] );
				isset($_POST[ 'sb_instagram_cache_time_unit' ]) ? $sb_instagram_cache_time_unit = $_POST[ 'sb_instagram_cache_time_unit' ] : $sb_instagram_cache_time_unit = '';

				$options[ 'sb_instagram_at' ] = $sb_instagram_at;
				$options[ 'sb_instagram_type' ] = $sb_instagram_type;
				$options[ 'sb_instagram_user_id' ] = $sb_instagram_user_id;
				$options[ 'sb_instagram_hashtag' ] = $sb_instagram_hashtag;
				$options[ 'sb_instagram_type_self_likes' ] = $sb_instagram_type_self_likes;
				$options[ 'sb_instagram_location' ] = $sb_instagram_location;
				$options[ 'sb_instagram_coordinates' ] = $sb_instagram_coordinates;

				$options[ 'sb_instagram_preserve_settings' ] = $sb_instagram_preserve_settings;
				$options[ 'sb_instagram_cache_time' ] = $sb_instagram_cache_time;
				$options[ 'sb_instagram_cache_time_unit' ] = $sb_instagram_cache_time_unit;

				//Delete all SBI transients
				global $wpdb;
				$table_name = $wpdb->prefix . "options";
				$wpdb->query( "
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_sbi\_%')
                    " );
				$wpdb->query( "
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_timeout\_sbi\_%')
                    " );

			} //End config tab post

			if( isset($_POST[ $sb_instagram_customize_hidden_field ]) && $_POST[ $sb_instagram_customize_hidden_field ] == 'Y' ) {
				//CUSTOMIZE - GENERAL
				//General
				if (isset($_POST[ 'sb_instagram_width' ]) ) $sb_instagram_width = sanitize_text_field( $_POST[ 'sb_instagram_width' ] );
				if (isset($_POST[ 'sb_instagram_width_unit' ]) ) $sb_instagram_width_unit = $_POST[ 'sb_instagram_width_unit' ];
				(isset($_POST[ 'sb_instagram_feed_width_resp' ]) ) ? $sb_instagram_feed_width_resp = $_POST[ 'sb_instagram_feed_width_resp' ] : $sb_instagram_feed_width_resp = '';
				if (isset($_POST[ 'sb_instagram_height' ]) ) $sb_instagram_height = sanitize_text_field( $_POST[ 'sb_instagram_height' ] );
				if (isset($_POST[ 'sb_instagram_height_unit' ]) ) $sb_instagram_height_unit = $_POST[ 'sb_instagram_height_unit' ];
				if (isset($_POST[ 'sb_instagram_background' ]) ) $sb_instagram_background = $_POST[ 'sb_instagram_background' ];

				//Layout Type
				if (isset($_POST[ 'sb_instagram_layout_type' ]) ) $sb_instagram_layout_type = $_POST[ 'sb_instagram_layout_type' ];
				if (isset($_POST[ 'sb_instagram_highlight_type' ]) ) $sb_instagram_highlight_type = $_POST[ 'sb_instagram_highlight_type' ];
				if (isset($_POST[ 'sb_instagram_highlight_offset' ]) ) $sb_instagram_highlight_offset = $_POST[ 'sb_instagram_highlight_offset' ];
				if (isset($_POST[ 'sb_instagram_highlight_factor' ]) ) $sb_instagram_highlight_factor = $_POST[ 'sb_instagram_highlight_factor' ];
				if (isset($_POST[ 'sb_instagram_highlight_ids' ]) ) $sb_instagram_highlight_ids = $_POST[ 'sb_instagram_highlight_ids' ];
				if (isset($_POST[ 'sb_instagram_highlight_hashtag' ]) ) $sb_instagram_highlight_hashtag = $_POST[ 'sb_instagram_highlight_hashtag' ];

				//Carousel
				isset($_POST[ 'sb_instagram_carousel' ]) ? $sb_instagram_carousel = $_POST[ 'sb_instagram_carousel' ] : $sb_instagram_carousel = '';
				isset($_POST[ 'sb_instagram_carousel_rows' ]) ? $sb_instagram_carousel_rows = $_POST[ 'sb_instagram_carousel_rows' ] : $sb_instagram_carousel_rows = 1;
				isset($_POST[ 'sb_instagram_carousel_loop' ]) ? $sb_instagram_carousel_loop = $_POST[ 'sb_instagram_carousel_loop' ] : $sb_instagram_carousel_loop = 'rewind';
				isset($_POST[ 'sb_instagram_carousel_arrows' ]) ? $sb_instagram_carousel_arrows = $_POST[ 'sb_instagram_carousel_arrows' ] : $sb_instagram_carousel_arrows = '';
				isset($_POST[ 'sb_instagram_carousel_pag' ]) ? $sb_instagram_carousel_pag = $_POST[ 'sb_instagram_carousel_pag' ] : $sb_instagram_carousel_pag = '';
				isset($_POST[ 'sb_instagram_carousel_autoplay' ]) ? $sb_instagram_carousel_autoplay = $_POST[ 'sb_instagram_carousel_autoplay' ] : $sb_instagram_carousel_autoplay = '';
				if (isset($_POST[ 'sb_instagram_carousel_interval' ]) ) $sb_instagram_carousel_interval = sanitize_text_field( $_POST[ 'sb_instagram_carousel_interval' ] );

				//Num/cols
				if (isset($_POST[ 'sb_instagram_num' ]) ) $sb_instagram_num = sanitize_text_field( $_POST[ 'sb_instagram_num' ] );
				if (isset($_POST[ 'sb_instagram_nummobile' ]) ) $sb_instagram_nummobile = sanitize_text_field( $_POST[ 'sb_instagram_nummobile' ] );
				if (isset($_POST[ 'sb_instagram_cols' ]) ) $sb_instagram_cols = sanitize_text_field( $_POST[ 'sb_instagram_cols' ] );
				if (isset($_POST[ 'sb_instagram_colsmobile' ]) ) $sb_instagram_colsmobile = sanitize_text_field( $_POST[ 'sb_instagram_colsmobile' ] );
				if (isset($_POST[ 'sb_instagram_colsmobile' ]) ) $options[ 'sb_instagram_disable_mobile' ] = false;
				if (isset($_POST[ 'sb_instagram_image_padding' ]) ) $sb_instagram_image_padding = sanitize_text_field( $_POST[ 'sb_instagram_image_padding' ] );
				if (isset($_POST[ 'sb_instagram_image_padding_unit' ]) ) $sb_instagram_image_padding_unit = $_POST[ 'sb_instagram_image_padding_unit' ];

				//Header
				isset($_POST[ 'sb_instagram_show_header' ]) ? $sb_instagram_show_header = $_POST[ 'sb_instagram_show_header' ] : $sb_instagram_show_header = '';
				if (isset($_POST[ 'sb_instagram_header_color' ]) ) $sb_instagram_header_color = $_POST[ 'sb_instagram_header_color' ];
				if (isset($_POST[ 'sb_instagram_header_style' ]) ) $sb_instagram_header_style = $_POST[ 'sb_instagram_header_style' ];
				isset($_POST[ 'sb_instagram_show_followers' ]) ? $sb_instagram_show_followers = $_POST[ 'sb_instagram_show_followers' ] : $sb_instagram_show_followers = '';
				isset($_POST[ 'sb_instagram_show_bio' ]) ? $sb_instagram_show_bio = $_POST[ 'sb_instagram_show_bio' ] : $sb_instagram_show_bio = '';
				if (isset($_POST[ 'sb_instagram_header_primary_color' ]) ) $sb_instagram_header_primary_color = $_POST[ 'sb_instagram_header_primary_color' ];
				if (isset($_POST[ 'sb_instagram_header_secondary_color' ]) ) $sb_instagram_header_secondary_color = $_POST[ 'sb_instagram_header_secondary_color' ];
				if (isset($_POST[ 'sb_instagram_header_size' ]) ) $sb_instagram_header_size = $_POST[ 'sb_instagram_header_size' ];

				//Load More button
				isset($_POST[ 'sb_instagram_show_btn' ]) ? $sb_instagram_show_btn = $_POST[ 'sb_instagram_show_btn' ] : $sb_instagram_show_btn = '';
				if (isset($_POST[ 'sb_instagram_btn_background' ]) ) $sb_instagram_btn_background = $_POST[ 'sb_instagram_btn_background' ];
				if (isset($_POST[ 'sb_instagram_btn_text_color' ]) ) $sb_instagram_btn_text_color = $_POST[ 'sb_instagram_btn_text_color' ];
				if (isset($_POST[ 'sb_instagram_btn_text' ]) ) $sb_instagram_btn_text = sanitize_text_field( $_POST[ 'sb_instagram_btn_text' ] );
				//AutoScroll
				isset($_POST[ 'sb_instagram_autoscroll' ]) ? $sb_instagram_autoscroll = $_POST[ 'sb_instagram_autoscroll' ] : $sb_instagram_autoscroll = '';
				if (isset($_POST[ 'sb_instagram_autoscrolldistance' ]) ) $sb_instagram_autoscrolldistance = sanitize_text_field( $_POST[ 'sb_instagram_autoscrolldistance' ] );

				//Follow button
				isset($_POST[ 'sb_instagram_show_follow_btn' ]) ? $sb_instagram_show_follow_btn = $_POST[ 'sb_instagram_show_follow_btn' ] : $sb_instagram_show_follow_btn = '';
				if (isset($_POST[ 'sb_instagram_folow_btn_background' ]) ) $sb_instagram_folow_btn_background = $_POST[ 'sb_instagram_folow_btn_background' ];
				if (isset($_POST[ 'sb_instagram_follow_btn_text_color' ]) ) $sb_instagram_follow_btn_text_color = $_POST[ 'sb_instagram_follow_btn_text_color' ];
				if (isset($_POST[ 'sb_instagram_follow_btn_text' ]) ) $sb_instagram_follow_btn_text = sanitize_text_field( $_POST[ 'sb_instagram_follow_btn_text' ] );

				//General
				$options[ 'sb_instagram_width' ] = $sb_instagram_width;
				$options[ 'sb_instagram_width_unit' ] = $sb_instagram_width_unit;
				$options[ 'sb_instagram_feed_width_resp' ] = $sb_instagram_feed_width_resp;
				$options[ 'sb_instagram_height' ] = $sb_instagram_height;
				$options[ 'sb_instagram_height_unit' ] = $sb_instagram_height_unit;
				$options[ 'sb_instagram_background' ] = $sb_instagram_background;
				//Layout
				$options[ 'sb_instagram_layout_type' ] = $sb_instagram_layout_type;
				$options[ 'sb_instagram_highlight_type' ] = $sb_instagram_highlight_type;
				$options[ 'sb_instagram_highlight_offset' ] = $sb_instagram_highlight_offset;
				$options[ 'sb_instagram_highlight_factor' ] = $sb_instagram_highlight_factor;
				$options[ 'sb_instagram_highlight_ids' ] = $sb_instagram_highlight_ids;
				$options[ 'sb_instagram_highlight_hashtag' ] = $sb_instagram_highlight_hashtag;
				//Carousel
				$options[ 'sb_instagram_carousel' ] = $sb_instagram_carousel;
				$options[ 'sb_instagram_carousel_arrows' ] = $sb_instagram_carousel_arrows;
				$options[ 'sb_instagram_carousel_pag' ] = $sb_instagram_carousel_pag;
				$options[ 'sb_instagram_carousel_autoplay' ] = $sb_instagram_carousel_autoplay;
				$options[ 'sb_instagram_carousel_interval' ] = $sb_instagram_carousel_interval;
				$options[ 'sb_instagram_carousel_rows' ] = $sb_instagram_carousel_rows;
				$options[ 'sb_instagram_carousel_loop' ] = $sb_instagram_carousel_loop;
				//Num/cols
				$options[ 'sb_instagram_num' ] = $sb_instagram_num;
				$options[ 'sb_instagram_nummobile' ] = $sb_instagram_nummobile;
				$options[ 'sb_instagram_cols' ] = $sb_instagram_cols;
				$options[ 'sb_instagram_colsmobile' ] = $sb_instagram_colsmobile;
				$options[ 'sb_instagram_image_padding' ] = $sb_instagram_image_padding;
				$options[ 'sb_instagram_image_padding_unit' ] = $sb_instagram_image_padding_unit;
				//Header
				$options[ 'sb_instagram_show_header' ] = $sb_instagram_show_header;
				$options[ 'sb_instagram_header_color' ] = $sb_instagram_header_color;
				$options[ 'sb_instagram_header_style' ] = $sb_instagram_header_style;
				$options[ 'sb_instagram_show_followers' ] = $sb_instagram_show_followers;
				$options[ 'sb_instagram_show_bio' ] = $sb_instagram_show_bio;
				$options[ 'sb_instagram_header_primary_color' ] = $sb_instagram_header_primary_color;
				$options[ 'sb_instagram_header_secondary_color' ] = $sb_instagram_header_secondary_color;
				$options[ 'sb_instagram_header_size' ] = $sb_instagram_header_size;
				//Load More button
				$options[ 'sb_instagram_show_btn' ] = $sb_instagram_show_btn;
				$options[ 'sb_instagram_btn_background' ] = $sb_instagram_btn_background;
				$options[ 'sb_instagram_btn_text_color' ] = $sb_instagram_btn_text_color;
				$options[ 'sb_instagram_btn_text' ] = $sb_instagram_btn_text;
				//AutoScroll
				$options[ 'sb_instagram_autoscroll' ] = $sb_instagram_autoscroll;
				$options[ 'sb_instagram_autoscrolldistance' ] = $sb_instagram_autoscrolldistance;
				//Follow button
				$options[ 'sb_instagram_show_follow_btn' ] = $sb_instagram_show_follow_btn;
				$options[ 'sb_instagram_moderation_mode' ] = $sb_instagram_moderation_mode;
				$options[ 'sb_instagram_folow_btn_background' ] = $sb_instagram_folow_btn_background;
				$options[ 'sb_instagram_follow_btn_text_color' ] = $sb_instagram_follow_btn_text_color;
				$options[ 'sb_instagram_follow_btn_text' ] = $sb_instagram_follow_btn_text;

			}

			if( isset($_POST[ $sb_instagram_customize_posts_hidden_field ]) && $_POST[ $sb_instagram_customize_posts_hidden_field ] == 'Y' ) {


				//CUSTOMIZE - POSTS
				//Photos
				if (isset($_POST[ 'sb_instagram_sort' ]) ) $sb_instagram_sort = $_POST[ 'sb_instagram_sort' ];
				if (isset($_POST[ 'sb_instagram_image_res' ]) ) $sb_instagram_image_res = $_POST[ 'sb_instagram_image_res' ];
				if (isset($_POST[ 'sb_instagram_media_type' ]) ) $sb_instagram_media_type = $_POST[ 'sb_instagram_media_type' ];
				(isset($_POST[ 'sb_instagram_disable_lightbox' ]) ) ? $sb_instagram_disable_lightbox = $_POST[ 'sb_instagram_disable_lightbox' ] : $sb_instagram_disable_lightbox = '';
				(isset($_POST[ 'sb_instagram_captionlinks' ]) ) ? $sb_instagram_captionlinks = $_POST[ 'sb_instagram_captionlinks' ] : $sb_instagram_captionlinks = '';

				//Photo hover style
				if (isset($_POST[ 'sb_hover_background' ]) ) $sb_hover_background = $_POST[ 'sb_hover_background' ];
				(isset($_POST[ 'sb_hover_text' ]) && !empty($_POST[ 'sb_hover_text' ]) ) ? $sb_hover_text = $_POST[ 'sb_hover_text' ] : $sb_hover_text = '#fff';
				(isset($_POST[ 'sbi_hover_inc_username' ]) ) ? $sbi_hover_inc_username = $_POST[ 'sbi_hover_inc_username' ] : $sbi_hover_inc_username = '';
				(isset($_POST[ 'sbi_hover_inc_icon' ]) ) ? $sbi_hover_inc_icon = $_POST[ 'sbi_hover_inc_icon' ] : $sbi_hover_inc_icon = '';
				(isset($_POST[ 'sbi_hover_inc_date' ]) ) ? $sbi_hover_inc_date = $_POST[ 'sbi_hover_inc_date' ] : $sbi_hover_inc_date = '';
				(isset($_POST[ 'sbi_hover_inc_instagram' ]) ) ? $sbi_hover_inc_instagram = $_POST[ 'sbi_hover_inc_instagram' ] : $sbi_hover_inc_instagram = '';
				(isset($_POST[ 'sbi_hover_inc_location' ]) ) ? $sbi_hover_inc_location = $_POST[ 'sbi_hover_inc_location' ] : $sbi_hover_inc_location = '';
				(isset($_POST[ 'sbi_hover_inc_caption' ]) ) ? $sbi_hover_inc_caption = $_POST[ 'sbi_hover_inc_caption' ] : $sbi_hover_inc_caption = '';
				(isset($_POST[ 'sbi_hover_inc_likes' ]) ) ? $sbi_hover_inc_likes = $_POST[ 'sbi_hover_inc_likes' ] : $sbi_hover_inc_likes = '';

				//Text
				isset($_POST[ 'sb_instagram_show_caption' ]) ? $sb_instagram_show_caption = $_POST[ 'sb_instagram_show_caption' ] : $sb_instagram_show_caption = '';
				if (isset($_POST[ 'sb_instagram_caption_length' ]) ) $sb_instagram_caption_length = sanitize_text_field( $_POST[ 'sb_instagram_caption_length' ] );
				if (isset($_POST[ 'sb_instagram_caption_color' ]) ) $sb_instagram_caption_color = $_POST[ 'sb_instagram_caption_color' ];
				if (isset($_POST[ 'sb_instagram_caption_size' ]) ) $sb_instagram_caption_size = $_POST[ 'sb_instagram_caption_size' ];

				//Likes & Comments Icons (meta)
				isset($_POST[ 'sb_instagram_show_meta' ]) ? $sb_instagram_show_meta = $_POST[ 'sb_instagram_show_meta' ] : $sb_instagram_show_meta = '';
				if (isset($_POST[ 'sb_instagram_meta_color' ]) ) $sb_instagram_meta_color = $_POST[ 'sb_instagram_meta_color' ];
				if (isset($_POST[ 'sb_instagram_meta_size' ]) ) $sb_instagram_meta_size = $_POST[ 'sb_instagram_meta_size' ];

				//Lightbox comments
				(isset($_POST[ 'sb_instagram_lightbox_comments' ]) ) ? $sb_instagram_lightbox_comments = $_POST[ 'sb_instagram_lightbox_comments' ] : $sb_instagram_lightbox_comments = '';
				if(isset($_POST[ 'sb_instagram_num_comments' ]) ) $sb_instagram_num_comments = sanitize_text_field( $_POST[ 'sb_instagram_num_comments' ] );

				//Photos
				$options[ 'sb_instagram_sort' ] = $sb_instagram_sort;
				$options[ 'sb_instagram_image_res' ] = $sb_instagram_image_res;
				$options[ 'sb_instagram_media_type' ] = $sb_instagram_media_type;
				$options[ 'sb_instagram_disable_lightbox' ] = $sb_instagram_disable_lightbox;
				$options[ 'sb_instagram_captionlinks' ] = $sb_instagram_captionlinks;
				//Photo hover style
				$options[ 'sb_hover_background' ] = $sb_hover_background;
				$options[ 'sb_hover_text' ] = $sb_hover_text;
				$options[ 'sbi_hover_inc_username' ] = $sbi_hover_inc_username;
				$options[ 'sbi_hover_inc_icon' ] = $sbi_hover_inc_icon;
				$options[ 'sbi_hover_inc_date' ] = $sbi_hover_inc_date;
				$options[ 'sbi_hover_inc_instagram' ] = $sbi_hover_inc_instagram;
				$options[ 'sbi_hover_inc_location' ] = $sbi_hover_inc_location;
				$options[ 'sbi_hover_inc_caption' ] = $sbi_hover_inc_caption;
				$options[ 'sbi_hover_inc_likes' ] = $sbi_hover_inc_likes;
				//Text
				$options[ 'sb_instagram_show_caption' ] = $sb_instagram_show_caption;
				$options[ 'sb_instagram_caption_length' ] = $sb_instagram_caption_length;
				$options[ 'sb_instagram_caption_color' ] = $sb_instagram_caption_color;
				$options[ 'sb_instagram_caption_size' ] = $sb_instagram_caption_size;
				//Meta
				$options[ 'sb_instagram_show_meta' ] = $sb_instagram_show_meta;
				$options[ 'sb_instagram_meta_color' ] = $sb_instagram_meta_color;
				$options[ 'sb_instagram_meta_size' ] = $sb_instagram_meta_size;
				//Lightbox Comments
				$options[ 'sb_instagram_lightbox_comments' ] = $sb_instagram_lightbox_comments;
				$options[ 'sb_instagram_num_comments' ] = $sb_instagram_num_comments;

			}

			if( isset($_POST[ $sb_instagram_customize_moderation_hidden_field ]) && $_POST[ $sb_instagram_customize_moderation_hidden_field ] == 'Y' ) {

				//CUSTOMIZE - MODERATION
				//Filtering
				if ($sb_instagram_ex_apply_to === 'all') {
					if (isset($_POST[ 'sb_instagram_exclude_words' ]) ) $sb_instagram_exclude_words = sanitize_text_field( $_POST[ 'sb_instagram_exclude_words' ] );
				} else {
					$sb_instagram_exclude_words = '';
				}
				if ($sb_instagram_inc_apply_to === 'all') {
					if (isset($_POST[ 'sb_instagram_include_words' ]) ) $sb_instagram_include_words = sanitize_text_field( $_POST[ 'sb_instagram_include_words' ] );
				} else {
					$sb_instagram_include_words = '';
				}
				if (isset($_POST[ 'sb_instagram_ex_apply_to' ]) ) $sb_instagram_ex_apply_to = $_POST[ 'sb_instagram_ex_apply_to' ];
				if (isset($_POST[ 'sb_instagram_inc_apply_to' ]) ) $sb_instagram_inc_apply_to = $_POST[ 'sb_instagram_inc_apply_to' ];

				//Moderation
				isset($_POST[ 'sb_instagram_moderation_mode' ]) ? $sb_instagram_moderation_mode = $_POST[ 'sb_instagram_moderation_mode' ] : $sb_instagram_moderation_mode = 'visual';
				if (isset($_POST[ 'sb_instagram_hide_photos' ]) ) $sb_instagram_hide_photos = $_POST[ 'sb_instagram_hide_photos' ];
				if (isset($_POST[ 'sb_instagram_block_users' ]) ) $sb_instagram_block_users = $_POST[ 'sb_instagram_block_users' ];
				if (isset($_POST[ 'sb_instagram_show_users' ]) ) $sb_instagram_show_users = sanitize_text_field( $_POST[ 'sb_instagram_show_users' ] );

				//Filtering
				$options[ 'sb_instagram_exclude_words' ] = $sb_instagram_exclude_words;
				$options[ 'sb_instagram_include_words' ] = $sb_instagram_include_words;
				$options[ 'sb_instagram_ex_apply_to' ] = $sb_instagram_ex_apply_to;
				$options[ 'sb_instagram_inc_apply_to' ] = $sb_instagram_inc_apply_to;
				//Moderation
                $options[ 'sb_instagram_moderation_mode' ] = $sb_instagram_moderation_mode;
				$options[ 'sb_instagram_hide_photos' ] = $sb_instagram_hide_photos;
				$options[ 'sb_instagram_block_users' ] = $sb_instagram_block_users;
				$options[ 'sb_instagram_show_users' ] = $sb_instagram_show_users;

			}

			if( isset($_POST[ $sb_instagram_customize_advanced_hidden_field ]) && $_POST[ $sb_instagram_customize_advanced_hidden_field ] == 'Y' ) {

				//CUSTOMIZE - ADVANCED
				if (isset($_POST[ 'sb_instagram_custom_css' ]) ) $sb_instagram_custom_css = $_POST[ 'sb_instagram_custom_css' ];
				if (isset($_POST[ 'sb_instagram_custom_js' ]) ) $sb_instagram_custom_js = $_POST[ 'sb_instagram_custom_js' ];
				//Misc
				isset($_POST[ 'sb_instagram_ajax_theme' ]) ? $sb_instagram_ajax_theme = $_POST[ 'sb_instagram_ajax_theme' ] : $sb_instagram_ajax_theme = '';
				if (isset($_POST[ 'sb_instagram_requests_max' ]) ) $sb_instagram_requests_max = $_POST[ 'sb_instagram_requests_max' ];
				if (isset($_POST[ 'sb_instagram_cron' ]) ) $sb_instagram_cron = $_POST[ 'sb_instagram_cron' ];
				isset($_POST[ 'sb_instagram_disable_font' ]) ? $sb_instagram_disable_font = $_POST[ 'sb_instagram_disable_font' ] : $sb_instagram_disable_font = '';
				isset($_POST[ 'check_api' ]) ? $check_api = $_POST[ 'check_api' ] : $check_api = '';
				isset($_POST[ 'sb_instagram_backup' ]) ? $sb_instagram_backup = $_POST[ 'sb_instagram_backup' ] : $sb_instagram_backup = '';
				isset($_POST[ 'enqueue_css_in_shortcode' ]) ? $enqueue_css_in_shortcode = $_POST[ 'enqueue_css_in_shortcode' ] : $enqueue_css_in_shortcode = '';
				isset($_POST[ 'enqueue_js_in_head' ]) ? $enqueue_js_in_head = $_POST[ 'enqueue_js_in_head' ] : $enqueue_js_in_head = '';
				isset($_POST[ 'sb_instagram_disable_mob_swipe' ]) ? $sb_instagram_disable_mob_swipe = $_POST[ 'sb_instagram_disable_mob_swipe' ] : $sb_instagram_disable_mob_swipe = '';
				isset($_POST[ 'sbi_font_method' ]) ? $sbi_font_method = $_POST[ 'sbi_font_method' ] : $sbi_font_method = '';
				isset($_POST[ 'sbi_br_adjust' ]) ? $sbi_br_adjust = $_POST[ 'sbi_br_adjust' ] : $sbi_br_adjust = '';

				//Advanced
				$options[ 'sb_instagram_custom_css' ] = $sb_instagram_custom_css;
				$options[ 'sb_instagram_custom_js' ] = $sb_instagram_custom_js;
				//Misc
				$options[ 'sb_instagram_ajax_theme' ] = $sb_instagram_ajax_theme;
				$options[ 'sb_instagram_requests_max' ] = $sb_instagram_requests_max;
				$options[ 'sb_instagram_cron' ] = $sb_instagram_cron;
				$options[ 'sb_instagram_disable_font' ] = $sb_instagram_disable_font;
				$options[ 'check_api' ] = $check_api;
				$options['sb_instagram_backup'] = $sb_instagram_backup;
				$options['enqueue_css_in_shortcode'] = $enqueue_css_in_shortcode;
				$options['enqueue_js_in_head'] = $enqueue_js_in_head;
				$options['sb_instagram_disable_mob_swipe'] = $sb_instagram_disable_mob_swipe;
				$options['sbi_font_method'] = $sbi_font_method;
				$options['sbi_br_adjust'] = $sbi_br_adjust;

				//Delete all SBI transients
				global $wpdb;
				$table_name = $wpdb->prefix . "options";
				$wpdb->query( "
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_sbi\_%')
                    " );
				$wpdb->query( "
                    DELETE
                    FROM $table_name
                    WHERE `option_name` LIKE ('%\_transient\_timeout\_sbi\_%')
                    " );
				$wpdb->query( "
			        DELETE
			        FROM $table_name
			        WHERE `option_name` LIKE ('%\_transient\_&sbi\_%')
			        " );
				$wpdb->query( "
			        DELETE
			        FROM $table_name
			        WHERE `option_name` LIKE ('%\_transient\_timeout\_&sbi\_%')
			        " );

				if( $sb_instagram_cron == 'no' ) wp_clear_scheduled_hook('sb_instagram_cron_job');

				//Run cron when Misc settings are saved
				if( $sb_instagram_cron == 'yes' ){
					//Clear the existing cron event
					wp_clear_scheduled_hook('sb_instagram_cron_job');

					$sb_instagram_cache_time = $options[ 'sb_instagram_cache_time' ];
					$sb_instagram_cache_time_unit = $options[ 'sb_instagram_cache_time_unit' ];

					//Set the event schedule based on what the caching time is set to
					$sb_instagram_cron_schedule = 'hourly';
					if( $sb_instagram_cache_time_unit == 'hours' && $sb_instagram_cache_time > 5 ) $sb_instagram_cron_schedule = 'twicedaily';
					if( $sb_instagram_cache_time_unit == 'days' ) $sb_instagram_cron_schedule = 'daily';

					wp_schedule_event(time(), $sb_instagram_cron_schedule, 'sb_instagram_cron_job');

					sb_instagram_clear_page_caches();
				}

			} //End customize tab post requests


			//Save the settings to the settings array
			update_option( 'sb_instagram_settings', $options );
			$sb_instagram_using_custom_sizes = get_option( 'sb_instagram_using_custom_sizes');
			if ( isset( $_POST['sb_instagram_using_custom_sizes'] ) ) {
				$sb_instagram_using_custom_sizes = (int)$_POST['sb_instagram_using_custom_sizes'];
			} elseif( isset( $_GET[ 'tab' ] ) && $_GET[ 'tab' ] === 'customize' ) {
				$sb_instagram_using_custom_sizes = false;
			}
			update_option( 'sb_instagram_using_custom_sizes', $sb_instagram_using_custom_sizes );

			?>
            <div class="updated"><p><strong><?php _e('Settings saved.', 'instagram-feed' ); ?></strong></p></div>
		<?php } ?>

	<?php } //End nonce check ?>


    <div id="sbi_admin" class="wrap">

        <div id="header">
            <h1><?php _e('Instagram Feed Pro', 'instagram-feed' ); ?></h1>
        </div>

		<?php sbi_expiration_notice(); ?>

        <form name="form1" method="post" action="">
            <input type="hidden" name="<?php echo $sb_instagram_settings_hidden_field; ?>" value="Y">
			<?php wp_nonce_field( 'sb_instagram_pro_saving_settings', 'sb_instagram_pro_settings_nonce' ); ?>

			<?php $sbi_active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'configure'; ?>
            <h2 class="nav-tab-wrapper">
                <a href="?page=sb-instagram-feed&amp;tab=configure" class="nav-tab <?php echo $sbi_active_tab == 'configure' ? 'nav-tab-active' : ''; ?>"><?php _e('1. Configure', 'instagram-feed' ); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=customize" class="nav-tab <?php echo strpos($sbi_active_tab, 'customize') !== false ? 'nav-tab-active' : ''; ?>"><?php _e('2. Customize', 'instagram-feed' ); ?></a>

                <a href="?page=sb-instagram-feed&amp;tab=display" class="nav-tab <?php echo $sbi_active_tab == 'display' ? 'nav-tab-active' : ''; ?>"><?php _e('3. Display Your Feed', 'instagram-feed' ); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=support" class="nav-tab <?php echo $sbi_active_tab == 'support' ? 'nav-tab-active' : ''; ?>"><?php _e('Support', 'instagram-feed' ); ?></a>
                <a href="?page=sb-instagram-license" class="nav-tab"><?php _e('License', 'instagram-feed' ); ?></a>
            </h2>

			<?php if( $sbi_active_tab == 'configure' ) { //Start Configure tab ?>
            <input type="hidden" name="<?php echo $sb_instagram_configure_hidden_field; ?>" value="Y">

            <table class="form-table">
                <tbody>
                <h3><?php _e('Configure', 'instagram-feed' ); ?></h3>

                <div id="sbi_config">
                    <a href="https://instagram.com/oauth/authorize/?client_id=3a81a9fa2a064751b8c31385b91cc25c&scope=basic+public_content&redirect_uri=https://api.smashballoon.com/instagram-plugin-token.php?return_uri=<?php echo admin_url('admin.php?page=sb-instagram-feed'); ?>&response_type=token&state=<?php echo admin_url('admin.php?page-sb-instagram-feed'); ?>" class="sbi_admin_btn"><i class="fa fa-user-plus" aria-hidden="true" style="font-size: 20px;"></i>&nbsp; <?php _e('Connect an Instagram Account', 'instagram-feed' ); ?></a>
                    <a href="https://smashballoon.com/instagram-feed/token/" target="_blank" style="position: relative; top: 14px; left: 15px;"><?php _e('Button not working?', 'instagram-feed'); ?></a>
                </div>

                <!-- Old Access Token -->
                <input name="sb_instagram_at" id="sb_instagram_at" type="hidden" value="<?php echo esc_attr( $sb_instagram_at ); ?>" size="80" maxlength="100" placeholder="Click button above to get your Access Token" />

				<?php

				$returned_data = sbi_get_connected_accounts_data( $sb_instagram_at );
				$connected_accounts = $returned_data['connected_accounts'];
				$user_feeds_returned = isset(  $returned_data['user_ids'] ) ? $returned_data['user_ids'] : false;
				if ( $user_feeds_returned ) {
					$user_feed_ids = $user_feeds_returned;
				} else {
					$user_feed_ids = ! is_array( $sb_instagram_user_id ) ? explode( ',', $sb_instagram_user_id ) : $sb_instagram_user_id;
				}
				$expired_tokens = get_option( 'sb_expired_tokens', array() );
				?>

                <tr valign="top">
                    <th scope="row"><label><?php _e( 'Instagram Accounts', 'instagram-feed' ); ?></label><span style="font-weight:normal; font-style:italic; font-size: 12px; display: block;"><?php _e('Use the button above to connect an Instagram account', 'instagram-feed'); ?></span></th>
                    <td class="sbi_connected_accounts_wrap">
						<?php if ( empty( $connected_accounts ) ) : ?>
                            <p class="sbi_no_accounts"><?php _e( 'No Instagram accounts connected. Click the button above to connect an account.', 'instagram-feed' ); ?></p><br />
						<?php else:  ?>
							<?php foreach ( $connected_accounts as $account ) :
								$username = $account['username'] ? $account['username'] : $account['user_id'];
								$profile_picture = $account['profile_picture'] ? '<img class="sbi_ca_avatar" src="'.$account['profile_picture'].'" />' : ''; //Could add placeholder avatar image
								$access_token_expired = (in_array(  $account['access_token'], $expired_tokens, true ) || in_array( sbi_maybe_clean( $account['access_token'] ), $expired_tokens, true ));
								$is_invalid_class = ! $account['is_valid'] || $access_token_expired ? ' sbi_account_invalid' : '';
								$in_user_feed = in_array( $account['user_id'], $user_feed_ids, true );
								?>
                                <div class="sbi_connected_account<?php echo $is_invalid_class; ?><?php if ( $in_user_feed ) echo ' sbi_account_active' ?>" id="sbi_connected_account_<?php esc_attr_e( $account['user_id'] ); ?>" data-accesstoken="<?php esc_attr_e( $account['access_token'] ); ?>" data-userid="<?php esc_attr_e( $account['user_id'] ); ?>" data-username="<?php esc_attr_e( $account['username'] ); ?>">

                                    <div class="sbi_ca_alert">
                                        <span><?php _e( 'The Access Token for this account is expired or invalid. Click the button above to attempt to renew it.', 'instagram-feed' ) ?></span>
                                    </div>
                                    <div class="sbi_ca_info">

                                        <div class="sbi_ca_delete">
                                            <a href="JavaScript:void(0);" class="sbi_delete_account"><i class="fa fa-times"></i><span class="sbi_remove_text"><?php _e( 'Remove', 'instagram-feed' ); ?></span></a>
                                        </div>

                                        <div class="sbi_ca_username">
											<?php echo $profile_picture; ?>
                                            <strong><?php echo $username; ?></strong>
                                        </div>

                                        <div class="sbi_ca_actions">
											<?php if ( ! $in_user_feed ) : ?>
                                                <a href="JavaScript:void(0);" class="sbi_use_in_user_feed button-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i><?php _e( 'Add to Primary Feed', 'instagram-feed' ); ?></a>
											<?php else : ?>
                                                <a href="JavaScript:void(0);" class="sbi_remove_from_user_feed button-primary"><i class="fa fa-minus-circle" aria-hidden="true"></i><?php _e( 'Remove from Primary Feed', 'instagram-feed' ); ?></a>
											<?php endif; ?>
                                            <a class="sbi_ca_token_shortcode button-secondary" href="JavaScript:void(0);"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><?php _e( 'Add to another Feed', 'instagram-feed' ); ?></a>
                                            <p class="sbi_ca_show_token"><input type="checkbox" id="sbi_ca_show_token_<?php esc_attr_e( $account['user_id'] ); ?>" /><label for="sbi_ca_show_token_<?php esc_attr_e( $account['user_id'] ); ?>"><?php _e('Show Access Token', 'instagram-feed'); ?></label></p>

                                        </div>

                                        <div class="sbi_ca_shortcode">

                                            <p><?php _e('Copy and paste this shortcode into your page or widget area', 'instagram-feed'); ?>:<br>
												<?php if ( !empty( $account['username'] ) ) : ?>
                                                    <code>[instagram-feed user="<?php echo $account['username']; ?>"]</code>
												<?php else : ?>
                                                    <code>[instagram-feed accesstoken="<?php echo $account['access_token']; ?>"]</code>
												<?php endif; ?>
                                            </p>

                                            <p><?php _e('To add multiple users in the same feed, simply separate them using commas', 'instagram-feed'); ?>:<br>
												<?php if ( !empty( $account['username'] ) ) : ?>
                                                    <code>[instagram-feed user="<?php echo $account['username']; ?>, a_second_user, a_third_user"]</code>
												<?php else : ?>
                                                    <code>[instagram-feed accesstoken="<?php echo $account['access_token']; ?>, another_access_token"]</code>
												<?php endif; ?>

                                            <p><?php echo sprintf( __('Click on the %s tab to learn more about shortcodes', 'instagram-feed'), '<a href="?page=sb-instagram-feed&tab=display" target="_blank">'. __( 'Display Your Feed', 'instagram-feed' ) . '</a>' ); ?></p>
                                        </div>

                                        <div class="sbi_ca_accesstoken">
                                            <span class="sbi_ca_token_label"><?php _e('Access Token', 'instagram-feed');?>:</span><input type="text" class="sbi_ca_token" value="<?php echo $account['access_token']; ?>" readonly="readonly" onclick="this.focus();this.select()" title="<?php _e('To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac).', 'instagram-feed');?>">
                                        </div>

                                    </div>

                                </div>

							<?php endforeach;  ?>
						<?php endif; ?>
                        <a href="JavaScript:void(0);" class="sbi_manually_connect button-secondary"><?php _e( 'Manually Connect an Account', 'instagram-feed' ); ?></a>
                        <div class="sbi_manually_connect_wrap">
                            <input name="sb_manual_at" id="sb_manual_at" type="text" value="" style="margin-top: 4px; padding: 5px 9px; margin-left: 0px;" size="64" maxlength="100" placeholder="Enter a valid Instagram Access Token" />
                            <p class="sbi_submit" style="display: inline-block;"><input type="sbi_submit" name="submit" id="sbi_manual_submit" class="button button-primary" style="text-align: center; padding: 0;" value="<?php _e('Connect This Account', 'instagram-feed' );?>"></p>
                        </div>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Show Photos From', 'instagram-feed'); ?>:</label><code class="sbi_shortcode"> type
                            Eg: type=user user=smashballoon
                            Eg: type=hashtag hashtag="dogs"
                            Eg: type=location location=213456451
                            Eg: type=coordinates coordinates="(25.76,-80.19,500)"</code></th>
                    <td>
                        <div class="sbi_row">
                            <div class="sbi_col sbi_one">
                                <input type="radio" name="sb_instagram_type" id="sb_instagram_type_user" value="user" <?php if($sb_instagram_type == "user") echo "checked"; ?> />
                                <label class="sbi_radio_label" for="sb_instagram_type_user"><?php _e( 'User Account', 'instagram-feed' ); ?>:</label>
                            </div>
                            <div class="sbi_col sbi_two">
                                <div class="sbi_user_feed_ids_wrap">
									<?php foreach ( $user_feed_ids as $feed_id ) : if ( $feed_id !== '' ) :?>
                                        <div id="sbi_user_feed_id_<?php echo $feed_id; ?>" class="sbi_user_feed_account_wrap">

											<?php if ( isset( $connected_accounts[ $feed_id ] ) && ! empty( $connected_accounts[ $feed_id ]['username'] ) ) : ?>
                                                <strong><?php echo $connected_accounts[ $feed_id ]['username']; ?></strong> <span>(<?php echo $feed_id; ?>)</span>
                                                <input name="sb_instagram_user_id[]" id="sb_instagram_user_id" type="hidden" value="<?php esc_attr_e( $feed_id ); ?>" />
											<?php elseif ( isset( $connected_accounts[ $feed_id ] ) && ! empty( $connected_accounts[ $feed_id ]['access_token'] ) ) : ?>
                                                <strong><?php echo $feed_id; ?></strong>
                                                <input name="sb_instagram_user_id[]" id="sb_instagram_user_id" type="hidden" value="<?php esc_attr_e( $feed_id ); ?>" />
											<?php endif; ?>

                                        </div>
									<?php endif; endforeach; ?>
                                </div>

								<?php if ( empty( $user_feed_ids ) ) : ?>
                                    <p class="sbi_no_accounts" style="margin-top: -3px; margin-right: 10px;"><?php _e('Connect a user account above', 'instagram-feed' );?></p>
								<?php endif; ?>

                                <a class="sbi_tooltip_link" href="JavaScript:void(0);" style="margin: 0 0 10px 0; display: inline-block; height: 19px;"><?php _e("How to display User feeds", 'instagram-feed'); ?></a>
                                <div class="sbi_tooltip">
                                    <p><?php _e("In order to display posts from a User account, first connect an account using the button above.", 'instagram-feed' ); ?></p>
                                    <p style="padding-top:8px;">
                                        <b><?php _e("Displaying Posts from Other Instagram Accounts", 'instagram-feed' ); ?></b><br />
										<?php _e("Due to recent changes in the Instagram API it is no longer possible to display photos from other Instagram accounts which you do not have access to. You can only display the user feed of an account which you connect above. You can connect as many account as you like by logging in using the button above, or manually copy/pasting an Access Token by selecting the 'Manually Connect an Account' option.", 'instagram-feed' ); ?>
                                    </p>
                                    <p style="padding-top:10px;"><b><?php _e("Multiple Acounts", 'instagram-feed' ); ?></b><br />
										<?php _e("It is only possible to display feeds from Instagram accounts which you own. In order to display feeds from multiple accounts, first connect them above and then use the buttons to add the account either to your primary feed or to another feed on your site.", 'instagram-feed'); ?>
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="sbi_row">
                            <div class="sbi_col sbi_one">
                                <input type="radio" name="sb_instagram_type" id="sb_instagram_type_hashtag" value="hashtag" <?php if($sb_instagram_type == "hashtag") echo "checked"; ?> />
                                <label class="sbi_radio_label" for="sb_instagram_type_hashtag">Hashtag:</label>
                            </div>
                            <div class="sbi_col sbi_two">
                                <input name="sb_instagram_hashtag" id="sb_instagram_hashtag" type="text" value="<?php esc_attr_e( $sb_instagram_hashtag ); ?>" size="45" placeholder="Eg: balloon" />
                                &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                <p class="sbi_tooltip"><?php _e("Display photos from a specific hashtag instead of from a user. Separate multiple hashtags using commas. &nbsp;<b>Note:</b> To display a hashtag feed, you'll still need to connect an Instagram account above in order to access the Instagram API.", 'instagram-feed'); ?></p>
                            </div>
                        </div>

                        <div class="sbi_deprecated">
                            <div class="sbi_row sbi_single_directions">
                                <div class="sbi_col sbi_one">
                                    <input type="radio" name="sb_instagram_type" disabled />
                                    <label class="sbi_radio_label">Single Posts:</label>
                                </div>
                                <div class="sbi_col sbi_two" style="position: relative;">
                                    <input type="text" size="45" disabled />
                                    <div class="sbi_click_area"></div>
                                    &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("Directions", 'instagram-feed'); ?></a>
                                    <p class="sbi_tooltip"><strong><?php _e('Please note that you can only display posts from the account you retrieved your access token with.', 'instagram-feed'); ?></strong><br><br>
    									<?php echo sprintf( __('You can display a feed comprised of specific single posts by using the %s shortcode setting. To use this, first set the feed %s to be %s, then paste the ID of the post(s) into the %s shortcode setting, like so: %s You can find the post ID by clicking on a photo in your feed (while logged in as a site administrator) and then clicking the %s link in the popup lightbox. This will display the ID of the post (%s). Separate multiple IDs by using commas.', 'instagram-feed'), '<code>single</code>',"type", "single", '<code>single</code>', '<br /><br /><code>[instagram-feed type="single" single="sbi_1349591022052854916_10145706"]</code><br /><br />', '"' . __( 'Hide Photo', 'instagram-feed' ) . '"', '<a href="https://smashballoon.com/wp-content/uploads/2015/01/hide-photo-link.jpg" target="_blank">' . __( 'screenshot', 'instagram-feed' ) . '</a>' ); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="sbi_row">
                                <div class="sbi_col sbi_one">
                                    <input type="radio" name="sb_instagram_type" id="sb_instagram_type_location" value="location" <?php if($sb_instagram_type == "location") echo "checked"; ?> />
                                    <label class="sbi_radio_label" for="sb_instagram_type_location">Location ID:</label>
                                </div>
                                <div class="sbi_col sbi_two">
                                    <input name="sb_instagram_location" id="sb_instagram_location" type="text" value="<?php esc_attr_e( $sb_instagram_location ); ?>" size="45" placeholder="Eg: 213456451" />
                                    &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                    <p class="sbi_tooltip"><?php echo sprintf( __("Display photos from a specific location ID. You can find the ID of a location in the URL of the location on Instagram. For example, the ID for %s would be %s.", 'instagram-feed' ), '<a href="https://instagram.com/explore/locations/251659598/" target="_blank">' . __( 'this location', 'instagram-feed' ) . '</a>', '<b>251659598</b>' ); ?></p>
                                </div>
                            </div>
                            <div class="sbi_row">
                                <div class="sbi_col sbi_one">
                                    <input type="radio" name="sb_instagram_type" id="sb_instagram_type_coordinates" value="coordinates" <?php if($sb_instagram_type == "coordinates") echo "checked"; ?> />
                                    <label class="sbi_radio_label" for="sb_instagram_type_coordinates"><?php _e('Coordinates', 'instagram-feed');?>:</label>
                                </div>
                                <div class="sbi_col sbi_two">
                                    <input name="sb_instagram_coordinates" id="sb_instagram_coordinates" type="text" value="<?php esc_attr_e( $sb_instagram_coordinates ); ?>" size="45" placeholder="Eg: (51.507351,-0.127758,1000)" />
                                    &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                    <p class="sbi_tooltip">
    									<?php echo sprintf( __("Display photos from specific location coordinates. Enter coordinates into this field using the following format: %s. For help adding coordinates just click the %s button below. You can add multiple coordinates by separating them with commas: %s.", 'instagram-feed'), '<code>' . __( '(latitude,longitude,distance)', 'instagram-feed' ) . '</code>', "<b>'". __( 'Add coordinates helper', 'instagram-feed' ) . "'</b>", '<code>' . __( '(latitude,longitude,distance)', 'instagram-feed' ) . ',' . __( '(latitude,longitude,distance)', 'instagram-feed' ) . '</code>' ); ?>
                                    </p>
                                    <br /><a href="javascript:void(0);" class="button button-secondary" id="sb_instagram_new_coordinates"><b>+</b> <?php _e('Add coordinates helper', 'instagram-feed'); ?></a>
                                    <div id="sb_instagram_coordinates_options">

                                        <div class="sbi_row">
                                            <div class="sbi_col sbi_one"><label for="sb_instagram_lat"><?php _e('Latitude', 'instagram-feed'); ?>:</label></div>
                                            <input name="sb_instagram_lat" id="sb_instagram_lat" type="text" size="20" placeholder="Eg: 51.507346" />
                                            &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                            <p class="sbi_tooltip">
    											<?php echo sprintf( __("The %s coordinate of your location. You can use %s to find the coordinates of any location.", 'instagram-feed'), '<strong>' . __( 'latitude', 'instagram-feed' ) . '</strong>', '<a href="http://www.latlong.net/" target="_blank">' . __( 'this website', 'instagram-feed' ) . '</a>' ); ?>
                                            </p>
                                        </div>
                                        <div class="sbi_row">
                                            <div class="sbi_col sbi_one"><label for="sb_instagram_long"><?php _e('Longitude', 'instagram-feed'); ?>:</label></div>
                                            <input name="sb_instagram_long" id="sb_instagram_long" type="text" size="20" placeholder="Eg: -0.127761" />
                                            &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                            <p class="sbi_tooltip">
    											<?php echo sprintf( __("The %s coordinate of your location. You can use %s to find the coordinates of any location.", 'instagram-feed'), '<strong>' . __( 'longitude', 'instagram-feed' ) . '</strong>', '<a href="http://www.latlong.net/" target="_blank">' . __( 'this website', 'instagram-feed' ) . '</a>' ); ?>
                                            </p>
                                        </div>
                                        <div class="sbi_row">
                                            <div class="sbi_col sbi_one"><label for="sb_instagram_dist"><?php _e('Distance', 'instagram-feed'); ?>:</label></div>
                                            <input name="sb_instagram_dist" id="sb_instagram_dist" type="text" size="6" placeholder="Eg: 2000" value="1000" /><span><?php _e('meters', 'instagram-feed');?></span>
                                            &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                            <p class="sbi_tooltip"><?php _e("The distance (in meters) from your coordinates that you'd like to display photos from. Specifying 2000 meters would only show photos from within a 2000 meter radius of your location (1600 meters = 1 mile). The maximum value is 5000.", 'instagram-feed'); ?></p>
                                        </div>
                                        <!-- </div> -->

                                        <div class="sbi_row">
                                            <a href="javascript:void(0);" class="button button-primary" id="sb_instagram_add_location" style="margin-top: 7px;"><?php _e('Add coordinates', 'instagram-feed'); ?></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <p class="sbi_deprecated_note"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> These feeds types will be deprecated soon due to Instagram platform changes. <a href="https://smashballoon.com/instagram-api-changes-dec-11-2018/" target="_blank">See here</a> for more info.</p>
                        </div> <!-- end .sbi_deprecated -->

                        <div class="sbi_row">
                            <span class="sbi_note" style="margin: 10px 0 0 0; display: block;"><?php _e('Separate multiple hashtags or locations by using commas', 'instagram-feed'); ?></span>
                        </div>
                        <div class="sbi_row">
                            <br>
                            <a class="sbi_tooltip_link" href="JavaScript:void(0);" style="margin-left: 0;"><i class="fa fa-question-circle" aria-hidden="true" style="margin-right: 6px;"></i><?php _e('Combine multiple feed types into a single feed', 'instagram-feed'); ?></a>
                            <p class="sbi_tooltip">
								<?php echo sprintf( __('To display multiple feed types in a single feed, use %s in your shortcode and then add each user name, hashtag, location, or single post of each feed into the shortcode, like so: %s. This will combine a user feed and a hashtag feed into the same feed.', 'instagram-feed'), 'type="mixed"', '<code>[instagram-feed type="mixed" user="smashballoon" hashtag="#awesomeplugins"]</code>' ); ?>
                            </p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th class="bump-left"><label class="bump-left"><?php _e("Preserve settings when plugin is removed", 'instagram-feed'); ?></label></th>
                    <td>
                        <input name="sb_instagram_preserve_settings" type="checkbox" id="sb_instagram_preserve_settings" <?php if($sb_instagram_preserve_settings == true) echo "checked"; ?> />
                        <label for="sb_instagram_preserve_settings"><?php _e('Yes'); ?></label>
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e('When removing the plugin your settings are automatically erased. Checking this box will prevent any settings from being deleted. This means that you can uninstall and reinstall the plugin without losing your settings.', 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Check for new posts every', 'instagram-feed'); ?></label></th>
                    <td>
                        <input name="sb_instagram_cache_time" type="text" value="<?php esc_attr_e( $sb_instagram_cache_time ); ?>" size="4" />
                        <select name="sb_instagram_cache_time_unit">
                            <option value="minutes" <?php if($sb_instagram_cache_time_unit == "minutes") echo 'selected="selected"' ?> ><?php _e('Minutes', 'instagram-feed'); ?></option>
                            <option value="hours" <?php if($sb_instagram_cache_time_unit == "hours") echo 'selected="selected"' ?> ><?php _e('Hours', 'instagram-feed'); ?></option>
                            <option value="days" <?php if($sb_instagram_cache_time_unit == "days") echo 'selected="selected"' ?> ><?php _e('Days', 'instagram-feed'); ?></option>
                        </select>
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e('Your Instagram posts are temporarily cached by the plugin in your WordPress database. You can choose how long the posts should be cached for. If you set the time to 1 hour then the plugin will clear the cache after that length of time and check Instagram for posts again.', 'instagram-feed'); ?></p>
                    </td>
                </tr>

                </tbody>
            </table>

			<?php submit_button(); ?>
        </form>

        <p><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp; <?php echo sprintf( __('Next Step: %s', 'instagram-feed'), '<a href="?page=sb-instagram-feed&tab=customize">' . __('Customize your Feed', 'instagram-feed' ) . '</a>' ); ?></p>
        <p><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php echo sprintf( __('Need help setting up the plugin? Check out our %s', 'instagram-feed'), '<a href="https://smashballoon.com/instagram-feed/docs/" target="_blank">' . __('setup directions', 'instagram-feed' ) . '</a>' ); ?></p>


	<?php } // End Configure tab ?>



		<?php if( strpos($sbi_active_tab, 'customize') !== false ) { //Show Customize sub tabs ?>

            <h2 class="nav-tab-wrapper sbi-subtabs">
                <a href="?page=sb-instagram-feed&amp;tab=customize" class="nav-tab <?php echo $sbi_active_tab == 'customize' ? 'nav-tab-active' : ''; ?>"><?php _e('General'); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=customize-posts" class="nav-tab <?php echo $sbi_active_tab == 'customize-posts' ? 'nav-tab-active' : ''; ?>"><?php _e('Posts'); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=customize-moderation" class="nav-tab <?php echo $sbi_active_tab == 'customize-moderation' ? 'nav-tab-active' : ''; ?>"><?php _e('Moderation'); ?></a>
                <a href="?page=sb-instagram-feed&amp;tab=customize-advanced" class="nav-tab <?php echo $sbi_active_tab == 'customize-advanced' ? 'nav-tab-active' : ''; ?>"><?php _e('Advanced'); ?></a>
            </h2>

		<?php } ?>

		<?php if( $sbi_active_tab == 'customize' ) { //Start General tab ?>

            <p class="sb_instagram_contents_links" id="general">
                <span><?php _e('Jump to:', 'instagram-feed'); ?> </span>
                <a href="#general"><?php _e('General', 'instagram-feed'); ?></a>
                <a href="#layout"><?php _e('Layout', 'instagram-feed'); ?></a>
                <a href="#headeroptions"><?php _e('Header', 'instagram-feed'); ?></a>
                <a href="#loadmore"><?php _e("'Load More' Button", 'instagram-feed'); ?></a>
                <a href="#follow"><?php _e("'Follow' Button", 'instagram-feed'); ?></a>
            </p>

            <input type="hidden" name="<?php echo $sb_instagram_customize_hidden_field; ?>" value="Y">

            <h3><?php _e('General', 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Width of Feed', 'instagram-feed'); ?></label><code class="sbi_shortcode"> width  widthunit
                            Eg: width=50 widthunit=%</code></th>
                    <td>
                        <input name="sb_instagram_width" type="text" value="<?php esc_attr_e( $sb_instagram_width ); ?>" id="sb_instagram_width" size="4" />
                        <select name="sb_instagram_width_unit" id="sb_instagram_width_unit">
                            <option value="px" <?php if($sb_instagram_width_unit == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                            <option value="%" <?php if($sb_instagram_width_unit == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                        </select>
                        <div id="sb_instagram_width_options">
                            <input name="sb_instagram_feed_width_resp" type="checkbox" id="sb_instagram_feed_width_resp" <?php if($sb_instagram_feed_width_resp == true) echo "checked"; ?> /><label for="sb_instagram_feed_width_resp"><?php _e('Set to be 100% width on mobile?'); ?></label>
                            <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                            <p class="sbi_tooltip"><?php _e("If you set a width on the feed then this will be used on mobile as well as desktop. Check this setting to set the feed width to be 100% on mobile so that it is responsive.", 'instagram-feed'); ?></p>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Height of Feed', 'instagram-feed'); ?></label><code class="sbi_shortcode"> height  heightunit
                            Eg: height=500 heightunit=px</code></th>
                    <td>
                        <input name="sb_instagram_height" type="text" value="<?php esc_attr_e( $sb_instagram_height ); ?>" size="4" />
                        <select name="sb_instagram_height_unit">
                            <option value="px" <?php if($sb_instagram_height_unit == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                            <option value="%" <?php if($sb_instagram_height_unit == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Background Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> background
                            Eg: background=d89531</code></th>
                    <td>
                        <input name="sb_instagram_background" type="text" value="<?php esc_attr_e( $sb_instagram_background ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                </tbody>
            </table>

            <hr id="layout" />
            <h3><?php _e('Layout', 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
				<?php

				$sbi_options = get_option( 'sb_instagram_settings' );

				$selected_type = isset( $sb_instagram_layout_type ) ? $sb_instagram_layout_type : 'grid';

				// fix for updating from previous version
				if ( ! empty( $sbi_options['sb_instagram_carousel'] ) ) {
					$selected_type = 'carousel';
					$sbi_options['sb_instagram_layout_type'] = 'carousel';
					$sbi_options['sb_instagram_carousel'] = false;
					update_option( 'sb_instagram_settings', $sbi_options );
				}

				$layout_types = array(
					'grid' => __( 'Grid', 'instagram-feed' ),
					'carousel' => __( 'Carousel', 'instagram-feed' ),
					'masonry' => __( 'Masonry', 'instagram-feed' ),
					'highlight' => __( 'Highlight', 'instagram-feed' )
				);
				$layout_images = array(
					'grid' => plugins_url( 'img/grid.png' , __FILE__ ),
					'carousel' => plugins_url( 'img/carousel.png' , __FILE__ ),
					'masonry' => plugins_url( 'img/masonry.png' , __FILE__ ),
					'highlight' => plugins_url( 'img/highlight.png' , __FILE__ )
				);
				?>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Layout Type', 'instagram-feed'); ?></label><code class="sbi_shortcode"> layout
                            Eg: layout=grid
                            Eg: layout=carousel
                            Eg: layout=masonry
                            Eg: layout=highlight</code></th>
                    <td>
						<?php foreach( $layout_types as $layout_type => $label ) : ?>
                            <div class="sbi_layout_cell <?php if($selected_type === $layout_type) echo "sbi_layout_selected"; ?>">
                                <input class="sb_layout_type" id="sb_layout_type_<?php esc_attr_e( $layout_type ); ?>" name="sb_instagram_layout_type" type="radio" value="<?php esc_attr_e( $layout_type ); ?>" <?php if ( $selected_type === $layout_type ) echo 'checked'; ?>/><label for="sb_layout_type_<?php esc_attr_e( $layout_type ); ?>"><span class="sbi_label"><?php echo esc_html( $label ); ?></span><img src="<?php echo $layout_images[ $layout_type ]; ?>" /></label>
                            </div>
						<?php endforeach; ?>
                        <div class="sb_layout_options_wrap">
                            <div class="sb_instagram_layout_settings sbi_layout_type_grid">
                                <i class="fa fa-info-circle" aria-hidden="true" style="margin-right: 8px;"></i><span class="sbi_note" style="margin-left: 0;"><?php _e('A uniform grid of square-cropped images.'); ?></span>
                            </div>
                            <div class="sb_instagram_layout_settings sbi_layout_type_masonry">
                                <i class="fa fa-info-circle" aria-hidden="true" style="margin-right: 8px;"></i><span class="sbi_note" style="margin-left: 0;"><?php _e('Images in their original aspect ratios with no vertical space between posts.'); ?></span>
                            </div>
                            <div class="sb_instagram_layout_settings sbi_layout_type_carousel">
                                <div class="sb_instagram_layout_setting">
                                    <i class="fa fa-info-circle" aria-hidden="true" style="margin-right: 8px;"></i><span class="sbi_note" style="margin-left: 0;"><?php _e('Posts are displayed in a slideshow carousel.', 'instagram-feed'); ?></span>
                                </div>
                                <div class="sb_instagram_layout_setting">

                                    <label><?php _e('Number of Rows', 'instagram-feed'); ?></label><code class="sbi_shortcode"> carouselrows
                                        Eg: carouselrows=2</code>
                                    <br />
                                    <span class="sbi_note" style="margin: -5px 0 -10px 0; display: block;">Use the "Number of Columns" setting below this section to set how many posts are visible in the carousel at a given time.</span>
                                    <br />
                                    <select name="sb_instagram_carousel_rows" id="sb_instagram_carousel_rows">
                                        <option value="1" <?php if($sb_instagram_carousel_rows == "1") echo 'selected="selected"' ?> >1</option>
                                        <option value="2" <?php if($sb_instagram_carousel_rows == "2") echo 'selected="selected"' ?> >2</option>
                                    </select>
                                </div>
                                <div class="sb_instagram_layout_setting">
                                    <label><?php _e('Loop Type', 'instagram-feed'); ?></label><code class="sbi_shortcode"> carouselloop
                                        Eg: carouselloop=rewind
                                        carouselloop=infinity</code>
                                    <br />
                                    <select name="sb_instagram_carousel_loop" id="sb_instagram_carousel_loop">
                                        <option value="rewind" <?php if($sb_instagram_carousel_loop == "rewind") echo 'selected="selected"' ?> ><?php _e( 'Rewind', 'instagram-feed'); ?></option>
                                        <option value="infinity" <?php if($sb_instagram_carousel_loop == "infinity") echo 'selected="selected"' ?> ><?php _e( 'Infinity', 'instagram-feed'); ?></option>
                                    </select>
                                </div>
                                <div class="sb_instagram_layout_setting">
                                    <input type="checkbox" name="sb_instagram_carousel_arrows" id="sb_instagram_carousel_arrows" <?php if($sb_instagram_carousel_arrows == true) echo 'checked="checked"' ?> />
                                    <label><?php _e("Show Navigation Arrows", 'instagram-feed'); ?></label><code class="sbi_shortcode"> carouselarrows
                                        Eg: carouselarrows=true</code>
                                </div>
                                <div class="sb_instagram_layout_setting">
                                    <input type="checkbox" name="sb_instagram_carousel_pag" id="sb_instagram_carousel_pag" <?php if($sb_instagram_carousel_pag == true) echo 'checked="checked"' ?> />
                                    <label><?php _e("Show Pagination", 'instagram-feed'); ?></label><code class="sbi_shortcode"> carouselpag
                                        Eg: carouselpag=true</code>
                                </div>
                                <div class="sb_instagram_layout_setting">
                                    <input type="checkbox" name="sb_instagram_carousel_autoplay" id="sb_instagram_carousel_autoplay" <?php if($sb_instagram_carousel_autoplay == true) echo 'checked="checked"' ?> />
                                    <label><?php _e("Enable Autoplay", 'instagram-feed'); ?></label><code class="sbi_shortcode"> carouselautoplay
                                        Eg: carouselautoplay=true</code>
                                </div>
                                <div class="sb_instagram_layout_setting">
                                    <label><?php _e("Interval Time", 'instagram-feed'); ?></label><code class="sbi_shortcode"> carouseltime
                                        Eg: carouseltime=8000</code>
                                    <br />
                                    <input name="sb_instagram_carousel_interval" type="text" value="<?php esc_attr_e( $sb_instagram_carousel_interval ); ?>" size="6" /><?php _e("miliseconds", 'instagram-feed'); ?>
                                </div>
                            </div>

                            <div class="sb_instagram_layout_settings sbi_layout_type_highlight">
                                <div class="sb_instagram_layout_setting">
                                    <i class="fa fa-info-circle" aria-hidden="true" style="margin-right: 8px;"></i><span class="sbi_note" style="margin-left: 0;"><?php _e('Masonry style, square-cropped, image only (no captions or likes/comments below image). "Highlighted" posts are twice as large.', 'instagram-feed'); ?></span>
                                </div>
                                <div class="sb_instagram_layout_setting">
                                    <label><?php _e('Highlighting Type', 'instagram-feed'); ?></label><code class="sbi_shortcode"> highlighttype
                                        Eg: highlighttype=pattern</code>
                                    <br />
                                    <select name="sb_instagram_highlight_type" id="sb_instagram_highlight_type">
                                        <option value="pattern" <?php if($sb_instagram_highlight_type == "pattern") echo 'selected="selected"' ?> ><?php _e( 'Pattern', 'instagram-feed'); ?></option>
                                        <option value="id" <?php if($sb_instagram_highlight_type == "id") echo 'selected="selected"' ?> ><?php _e( 'Post ID', 'instagram-feed'); ?></option>
                                        <option value="hashtag" <?php if($sb_instagram_highlight_type == "hashtag") echo 'selected="selected"' ?> ><?php _e( 'Hashtag', 'instagram-feed'); ?></option>
                                    </select>
                                </div>
                                <div class="sb_instagram_highlight_sub_options sb_instagram_highlight_pattern sb_instagram_layout_setting">
                                    <label><?php _e('Offset', 'instagram-feed'); ?></label><code class="sbi_shortcode"> highlightoffset
                                        Eg: highlightoffset=2</code>
                                    <br />
                                    <input name="sb_instagram_highlight_offset" type="number" min="0" value="<?php esc_attr_e( $sb_instagram_highlight_offset ); ?>" style="width: 50px;" />
                                </div>
                                <div class="sb_instagram_highlight_sub_options sb_instagram_highlight_pattern sb_instagram_layout_setting">
                                    <label><?php _e('Pattern', 'instagram-feed'); ?></label><code class="sbi_shortcode"> highlightpattern
                                        Eg: highlightpattern=3</code>
                                    <br />
                                    <span><?php _e( 'Highlight every', 'instagram-feed' ); ?></span><input name="sb_instagram_highlight_factor" type="number" min="2" value="<?php esc_attr_e( $sb_instagram_highlight_factor ); ?>" style="width: 50px;" /><span><?php _e( 'posts', 'instagram-feed' ); ?></span>
                                </div>
                                <div class="sb_instagram_highlight_sub_options sb_instagram_highlight_hashtag sb_instagram_layout_setting">
                                    <label><?php _e("Highlight Posts with these Hashtags", 'instagram-feed'); ?></label>
                                    <input name="sb_instagram_highlight_hashtag" id="sb_instagram_highlight_hashtag" type="text" size="40" value="<?php esc_attr_e( stripslashes( $sb_instagram_highlight_hashtag ) ); ?>" />&nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                    <br />
                                    <span class="sbi_note" style="margin-left: 0;"><?php _e('Separate multiple hashtags using commas', 'instagram-feed'); ?></span>


                                    <p class="sbi_tooltip"><?php _e("You can use this setting to highlight posts by a hashtag. Use a specified hashtag in your posts and they will be automatically highlighted in your feed.", 'instagram-feed'); ?></p>
                                </div>
                                <div class="sb_instagram_highlight_sub_options sb_instagram_highlight_ids sb_instagram_layout_setting">
                                    <label><?php _e("Highlight Posts by ID", 'instagram-feed'); ?></label>
                                    <textarea name="sb_instagram_highlight_ids" id="sb_instagram_highlight_ids" style="width: 100%;" rows="3"><?php esc_attr_e( stripslashes( $sb_instagram_highlight_ids ) ); ?></textarea>
                                    <br />
                                    <span class="sbi_note" style="margin-left: 0;"><?php _e('Separate IDs using commas', 'instagram-feed'); ?></span>

                                    &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                    <p class="sbi_tooltip"><?php _e("You can use this setting to highlight posts by their ID. Enable and use \"moderation mode\", check the box to show post IDs underneath posts, then copy and paste IDs into this text box.", 'instagram-feed'); ?></p>
                                </div>
                            </div>

                        </div>
                    </td>
                </tr>


                <tr valign="top">
                    <th scope="row"><label><?php _e('Number of Photos', 'instagram-feed'); ?></label><code class="sbi_shortcode"> num
                            Eg: num=6</code></th>
                    <td>
                        <input name="sb_instagram_num" type="text" value="<?php esc_attr_e( $sb_instagram_num ); ?>" size="4" />
                        <span class="sbi_note"><?php _e('Number of photos to show initially', 'instagram-feed'); ?></span>
                        &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("This is the number of photos which will be displayed initially and also the number which will be loaded in when you click on the 'Load More' button in your feed. For optimal performance it is recommended not to set this higher than 50.", 'instagram-feed'); ?></p>
                        <br>
                        <a href="javascript:void(0);" class="sb_instagram_mobile_layout_reveal button-secondary"><?php _e( 'Show Mobile Options', 'instagram-feed' ); ?></a>
                        <br>
                        <div class="sb_instagram_mobile_layout_setting">
                            <p style="font-weight: bold; padding-bottom: 5px;"><?php _e('Number of Photos on Mobile', 'instagram-feed');?></p>
                            <input name="sb_instagram_nummobile" type="number" value="<?php esc_attr_e( $sb_instagram_nummobile ); ?>" min="0" max="100" style="width: 50px;" />
                            <span class="sbi_note"><?php _e('Leave blank to use the same as above', 'instagram-feed'); ?></span>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Number of Columns', 'instagram-feed'); ?></label><code class="sbi_shortcode"> cols
                            Eg: cols=3</code></th>
                    <td>
                        <select name="sb_instagram_cols">
                            <option value="1" <?php if($sb_instagram_cols == "1") echo 'selected="selected"' ?> ><?php _e('1'); ?></option>
                            <option value="2" <?php if($sb_instagram_cols == "2") echo 'selected="selected"' ?> ><?php _e('2'); ?></option>
                            <option value="3" <?php if($sb_instagram_cols == "3") echo 'selected="selected"' ?> ><?php _e('3'); ?></option>
                            <option value="4" <?php if($sb_instagram_cols == "4") echo 'selected="selected"' ?> ><?php _e('4'); ?></option>
                            <option value="5" <?php if($sb_instagram_cols == "5") echo 'selected="selected"' ?> ><?php _e('5'); ?></option>
                            <option value="6" <?php if($sb_instagram_cols == "6") echo 'selected="selected"' ?> ><?php _e('6'); ?></option>
                            <option value="7" <?php if($sb_instagram_cols == "7") echo 'selected="selected"' ?> ><?php _e('7'); ?></option>
                            <option value="8" <?php if($sb_instagram_cols == "8") echo 'selected="selected"' ?> ><?php _e('8'); ?></option>
                            <option value="9" <?php if($sb_instagram_cols == "9") echo 'selected="selected"' ?> ><?php _e('9'); ?></option>
                            <option value="10" <?php if($sb_instagram_cols == "10") echo 'selected="selected"' ?> ><?php _e('10'); ?></option>
                        </select>
                        <br>
                        <a href="javascript:void(0);" class="sb_instagram_mobile_layout_reveal button-secondary"><?php _e( 'Show Mobile Options', 'instagram-feed' ); ?></a>
                        <br>
                        <div class="sb_instagram_mobile_layout_setting">

                            <p style="font-weight: bold; padding-bottom: 5px;"><?php _e('Number of Columns on Mobile', 'instagram-feed' );?></p>
                            <select name="sb_instagram_colsmobile">
                                <option value="auto" <?php if($sb_instagram_colsmobile == "auto") echo 'selected="selected"' ?> ><?php _e('Auto', 'instagram-feed'); ?></option>
                                <option value="same" <?php if($sb_instagram_colsmobile == "same") echo 'selected="selected"' ?> ><?php _e('Same as desktop', 'instagram-feed'); ?></option>
                                <option value="1" <?php if($sb_instagram_colsmobile == "1") echo 'selected="selected"' ?> ><?php _e('1'); ?></option>
                                <option value="2" <?php if($sb_instagram_colsmobile == "2") echo 'selected="selected"' ?> ><?php _e('2'); ?></option>
                                <option value="3" <?php if($sb_instagram_colsmobile == "3") echo 'selected="selected"' ?> ><?php _e('3'); ?></option>
                                <option value="4" <?php if($sb_instagram_colsmobile == "4") echo 'selected="selected"' ?> ><?php _e('4'); ?></option>
                                <option value="5" <?php if($sb_instagram_colsmobile == "5") echo 'selected="selected"' ?> ><?php _e('5'); ?></option>
                                <option value="6" <?php if($sb_instagram_colsmobile == "6") echo 'selected="selected"' ?> ><?php _e('6'); ?></option>
                                <option value="7" <?php if($sb_instagram_colsmobile == "7") echo 'selected="selected"' ?> ><?php _e('7'); ?></option>
                            </select>
                            &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What does \"Auto\" mean?", 'instagram-feed'); ?></a>
                            <p class="sbi_tooltip" style="padding: 10px 0 0 0;"><?php _e("This means that the plugin will automatically calculate how many columns to use for mobile based on the screen size and number of columns selected above. For example, a feed which is set to use 4 columns will show 2 columns for screen sizes less than 640 pixels and 1 column for screen sizes less than 480 pixels.", 'instagram-feed'); ?></p>
                        </div>
						<?php if($sb_instagram_disable_mobile == true) $sb_instagram_colsmobile = 'same'; ?>

                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Padding around Images', 'instagram-feed'); ?></label><code class="sbi_shortcode"> imagepadding  imagepaddingunit</code></th>
                    <td>
                        <input name="sb_instagram_image_padding" type="text" value="<?php esc_attr_e( $sb_instagram_image_padding ); ?>" size="4" />
                        <select name="sb_instagram_image_padding_unit">
                            <option value="px" <?php if($sb_instagram_image_padding_unit == "px") echo 'selected="selected"' ?> ><?php _e('px'); ?></option>
                            <option value="%" <?php if($sb_instagram_image_padding_unit == "%") echo 'selected="selected"' ?> ><?php _e('%'); ?></option>
                        </select>
                    </td>
                </tr>

                </tbody>
            </table>
			<?php submit_button(); ?>

            <hr id="headeroptions" />
            <h3><?php _e("Header", 'instagram-feed'); ?></h3>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Show Feed Header", 'instagram-feed'); ?></label><code class="sbi_shortcode"> showheader
                            Eg: showheader=false</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_show_header" id="sb_instagram_show_header" <?php if($sb_instagram_show_header == true) echo 'checked="checked"' ?> />
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="submit sbi-expand-button">
                <a href="javascript:void(0);" class="button">Show Customization Options</a>
            </p>

            <table class="form-table sbi-expandable-options">
                <tbody>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Header Style', 'instagram-feed'); ?></label><code class="sbi_shortcode"> headerstyle
                            Eg: headerstyle=boxed</code></th>
                    <td>
                        <select name="sb_instagram_header_style" id="sb_instagram_header_style" style="float: left;">
                            <option value="standard" <?php if($sb_instagram_header_style == "standard") echo 'selected="selected"' ?> ><?php _e('Standard', 'instagram-feed'); ?></option>
                            <option value="boxed" <?php if($sb_instagram_header_style == "boxed") echo 'selected="selected"' ?> ><?php _e('Boxed', 'instagram-feed'); ?></option>
                            <option value="centered" <?php if($sb_instagram_header_style == "centered") echo 'selected="selected"' ?> ><?php _e('Centered', 'instagram-feed'); ?></option>
                        </select>
                        <div id="sb_instagram_header_style_boxed_options">
                            <p><?php _e('Please select 2 background colors for your Boxed header:', 'instagram-feed'); ?></p>
                            <div class="sbi_row">
                                <div class="sbi_col sbi_one">
                                    <label><?php _e('Primary Color', 'instagram-feed'); ?></label>
                                </div>
                                <div class="sbi_col sbi_two">
                                    <input name="sb_instagram_header_primary_color" type="text" value="<?php esc_attr_e( $sb_instagram_header_primary_color ); ?>" class="sbi_colorpick" />
                                </div>
                            </div>

                            <div class="sbi_row">
                                <div class="sbi_col sbi_one">
                                    <label><?php _e('Secondary Color', 'instagram-feed'); ?></label>
                                </div>
                                <div class="sbi_col sbi_two">
                                    <input name="sb_instagram_header_secondary_color" type="text" value="<?php esc_attr_e( $sb_instagram_header_secondary_color ); ?>" class="sbi_colorpick" />
                                </div>
                            </div>
                            <p style="margin-top: 10px;"><?php _e("Don't forget to set your text color below.", 'instagram-feed'); ?></p>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Header Size', 'instagram-feed'); ?></label><code class="sbi_shortcode"> headersize
                            Eg: headersize=medium</code></th>
                    <td>
                        <select name="sb_instagram_header_size" id="sb_instagram_header_size" style="float: left;">
                            <option value="small" <?php if($sb_instagram_header_size == "small") echo 'selected="selected"' ?> ><?php _e('Small', 'instagram-feed'); ?></option>
                            <option value="medium" <?php if($sb_instagram_header_size == "medium") echo 'selected="selected"' ?> ><?php _e('Medium', 'instagram-feed'); ?></option>
                            <option value="large" <?php if($sb_instagram_header_size == "large") echo 'selected="selected"' ?> ><?php _e('Large', 'instagram-feed'); ?></option>
                        </select>
                    </td>
                </tr>

                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Show Number of Followers", 'instagram-feed'); ?></label><code class="sbi_shortcode"> showfollowers
                            Eg: showfollowers=false</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_show_followers" id="sb_instagram_show_followers" <?php if($sb_instagram_show_followers == true) echo 'checked="checked"' ?> />
                        <span class="sbi_note"><?php _e("This only applies when displaying photos from a User ID", 'instagram-feed'); ?></span>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Show Bio Text", 'instagram-feed'); ?></label><code class="sbi_shortcode"> showbio
                            Eg: showbio=false</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_show_bio" id="sb_instagram_show_bio" <?php if($sb_instagram_show_bio == true) echo 'checked="checked"' ?> />
                        <span class="sbi_note"><?php _e("This only applies when displaying photos from a User ID", 'instagram-feed'); ?></span>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Header Text Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> headercolor
                            Eg: headercolor=fff</code></th>
                    <td>
                        <input name="sb_instagram_header_color" type="text" value="<?php esc_attr_e( $sb_instagram_header_color ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                </tbody>
            </table>


            <hr id="loadmore" />
            <h3><?php _e("'Load More' Button", 'instagram-feed'); ?></h3>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Show the 'Load More' button", 'instagram-feed'); ?></label><code class="sbi_shortcode"> showbutton
                            Eg: showbutton=false</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_show_btn" id="sb_instagram_show_btn" <?php if($sb_instagram_show_btn == true) echo 'checked="checked"' ?> />
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="submit sbi-expand-button">
                <a href="javascript:void(0);" class="button">Show Customization Options</a>
            </p>

            <table class="form-table sbi-expandable-options">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Button Background Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> buttoncolor
                            Eg: buttoncolor=8224e3</code></th>
                    <td>
                        <input name="sb_instagram_btn_background" type="text" value="<?php esc_attr_e( $sb_instagram_btn_background ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Button Text Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> buttontextcolor
                            Eg: buttontextcolor=eeee22</code></th>
                    <td>
                        <input name="sb_instagram_btn_text_color" type="text" value="<?php esc_attr_e( $sb_instagram_btn_text_color ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Button Text', 'instagram-feed'); ?></label><code class="sbi_shortcode"> buttontext
                            Eg: buttontext="Show more.."</code></th>
                    <td>
                        <input name="sb_instagram_btn_text" type="text" value="<?php echo stripslashes( esc_attr( $sb_instagram_btn_text ) ); ?>" size="30" />
                    </td>
                </tr>
                <tr valign="top">
                    <th class="bump-left"><label class="bump-left"><?php _e("Autoload more posts on scroll", 'instagram-feed'); ?></label><code class="sbi_shortcode"> autoscroll
                            Eg: autoscroll=true</code></th>
                    <td>
                        <input name="sb_instagram_autoscroll" type="checkbox" id="sb_instagram_autoscroll" <?php if($sb_instagram_autoscroll == true) echo "checked"; ?> />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What is this?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e('This will make every Instagram feed load more posts as the user gets to the bottom of the feed. To enable this on only a specific feed use the autoscroll=true shortcode option.', 'instagram-feed'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Scroll Trigger Distance', 'instagram-feed'); ?></label><code class="sbi_shortcode"> autoscrolldistance
                            Eg: autoscrolldistance=200</code></th>
                    <td>
                        <input name="sb_instagram_autoscrolldistance" type="text" value="<?php echo stripslashes( esc_attr( $sb_instagram_autoscrolldistance ) ); ?>" size="30" />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What is this?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e('This is the distance in pixels from the bottom of the page the user must scroll to to trigger the loading of more posts.', 'instagram-feed'); ?></p>
                    </td>
                </tr>


                </tbody>
            </table>

            <hr id="follow" />
            <h3><?php _e("'Follow' Button", 'instagram-feed'); ?></h3>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Show the Follow button", 'instagram-feed'); ?></label><code class="sbi_shortcode"> showfollow
                            Eg: showfollow=true</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_show_follow_btn" id="sb_instagram_show_follow_btn" <?php if($sb_instagram_show_follow_btn == true) echo 'checked="checked"' ?> />
                    </td>
                </tr>
                </tbody>
            </table>

            <p class="submit sbi-expand-button">
                <a href="javascript:void(0);" class="button">Show Customization Options</a>
            </p>

            <table class="form-table sbi-expandable-options">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Button Background Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> followcolor
                            Eg: followcolor=28a1bf</code></th>
                    <td>
                        <input name="sb_instagram_folow_btn_background" type="text" value="<?php esc_attr_e( $sb_instagram_folow_btn_background ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Button Text Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> followtextcolor
                            Eg: followtextcolor=000</code></th>
                    <td>
                        <input name="sb_instagram_follow_btn_text_color" type="text" value="<?php esc_attr_e( $sb_instagram_follow_btn_text_color ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Button Text', 'instagram-feed'); ?></label><code class="sbi_shortcode"> followtext
                            Eg: followtext="Follow me"</code></th>
                    <td>
                        <input name="sb_instagram_follow_btn_text" type="text" value="<?php echo stripslashes( esc_attr( $sb_instagram_follow_btn_text ) ); ?>" size="30" />
                    </td>
                </tr>
                </tbody>
            </table>

			<?php submit_button(); ?>


		<?php } //End Customize General tab ?>

		<?php if( $sbi_active_tab == 'customize-posts' ) { //Start Customize Posts tab ?>

            <p class="sb_instagram_contents_links" id="general">
                <span><?php _e('Jump to:', 'instagram-feed'); ?> </span>
                <a href="#photos"><?php _e('Photos', 'instagram-feed'); ?></a>
                <a href="#hover"><?php _e('Photo Hover Style', 'instagram-feed'); ?></a>
                <a href="#caption"><?php _e('Caption', 'instagram-feed'); ?></a>
                <a href="#likes"><?php _e('Likes &amp; Comments Icons', 'instagram-feed'); ?></a>
                <a href="#comments"><?php _e('Lightbox Comments', 'instagram-feed'); ?></a>
            </p>

            <input type="hidden" name="<?php echo $sb_instagram_customize_posts_hidden_field; ?>" value="Y">

            <hr id="photos" />
            <h3><?php _e('Photos', 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Sort Photos By', 'instagram-feed'); ?></label><code class="sbi_shortcode"> sortby
                            Eg: sortby=random</code></th>
                    <td>
                        <select name="sb_instagram_sort">
                            <option value="none" <?php if($sb_instagram_sort == "none") echo 'selected="selected"' ?> ><?php _e('Newest to oldest', 'instagram-feed'); ?></option>
                            <option value="random" <?php if($sb_instagram_sort == "random") echo 'selected="selected"' ?> ><?php _e('Random', 'instagram-feed'); ?></option>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Image Resolution', 'instagram-feed'); ?></label><code class="sbi_shortcode"> imageres
                            Eg: imageres=thumb</code></th>
                    <td>
						<?php
						$sb_instagram_using_custom_sizes = get_option( 'sb_instagram_using_custom_sizes' );
						$sb_standard_res_name = 'sb_instagram_image_res';
						$sb_standard_res_class = '';
						$sb_custom_res_name = '';
						$sb_custom_res_class = ' style="display:none;"';
						if ( $sb_instagram_using_custom_sizes == 1 ) {
							$sb_custom_res_name = 'sb_instagram_image_res';
							$sb_standard_res_name = '';
							$sb_custom_res_class = '';
							$sb_standard_res_class = ' style="opacity:.5"';
						}

						?>
                        <select id="sb_standard_res_settings" name="<?php echo $sb_standard_res_name; ?>"<?php echo $sb_standard_res_class; ?>>
                            <option value="auto" <?php if($sb_instagram_image_res == "auto") echo 'selected="selected"' ?> ><?php _e('Auto-detect (recommended)', 'instagram-feed'); ?></option>
                            <option value="thumb" <?php if($sb_instagram_image_res == "thumb") echo 'selected="selected"' ?> ><?php _e('Thumbnail (150x150)', 'instagram-feed'); ?></option>
                            <option value="medium" <?php if($sb_instagram_image_res == "medium") echo 'selected="selected"' ?> ><?php _e('Medium (306x306)', 'instagram-feed'); ?></option>
                            <option value="full" <?php if($sb_instagram_image_res == "full") echo 'selected="selected"' ?> ><?php _e('Full size (640x640)', 'instagram-feed'); ?></option>
                        </select>

                        &nbsp<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What does Auto-detect mean?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("Auto-detect means that the plugin automatically sets the image resolution based on the size of your feed.", 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Media Type to Display', 'instagram-feed'); ?></label><code class="sbi_shortcode"> media
                            Eg: media=photos
                            media=videos
                            media=all</code></th>
                    <td>
                        <select name="sb_instagram_media_type">
                            <option value="all" <?php if($sb_instagram_media_type == "all") echo 'selected="selected"' ?> ><?php _e('All', 'instagram-feed'); ?></option>
                            <option value="photos" <?php if($sb_instagram_media_type == "photos") echo 'selected="selected"' ?> ><?php _e('Photos only', 'instagram-feed'); ?></option>
                            <option value="videos" <?php if($sb_instagram_media_type == "videos") echo 'selected="selected"' ?> ><?php _e('Videos only', 'instagram-feed'); ?></option>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e("Disable Pop-up Lightbox", 'instagram-feed'); ?></label><code class="sbi_shortcode"> disablelightbox
                            Eg: disablelightbox=true</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_disable_lightbox" id="sb_instagram_disable_lightbox" <?php if($sb_instagram_disable_lightbox == true) echo 'checked="checked"' ?> />
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e("Link Posts to URL in Caption (Shoppable feed)", 'instagram-feed'); ?></label><code class="sbi_shortcode"> captionlinks
                            Eg: captionlinks=true</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_captionlinks" id="sb_instagram_captionlinks" <?php if($sb_instagram_captionlinks == true) echo 'checked="checked"' ?> />
                        &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What will this do?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php echo sprintf( __("Checking this box will change the link for each post to any url included in the caption for that Instagram post. The lightbox will be disabled. Visit %s to learn how this works.", 'instagram-feed'), '<a href="https://smashballoon.com/make-a-shoppable-feed">'. __( 'this link', 'instagram-feed' ) . '</a>' ); ?></p>
                    </td>
                </tr>
                </tbody>
            </table>

            <hr id="hover" />
            <h3><?php _e('Photo Hover Style', 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Hover Background Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> hovercolor
                            Eg: hovercolor=1e73be</code></th>
                    <td>
                        <input name="sb_hover_background" type="text" value="<?php esc_attr_e( $sb_hover_background ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Hover Text Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> hovertextcolor
                            Eg: hovertextcolor=fff</code></th>
                    <td>
                        <input name="sb_hover_text" type="text" value="<?php esc_attr_e( $sb_hover_text ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Information to display', 'instagram-feed'); ?></label><code class="sbi_shortcode"> hoverdisplay
                            Eg: hoverdisplay='username,date'

                            Options: username, date, instagram, location, caption, likes</code></th>
                    <td>
                        <div>
                            <input name="sbi_hover_inc_username" type="checkbox" id="sbi_hover_inc_username" <?php if($sbi_hover_inc_username == true) echo "checked"; ?> />
                            <label for="sbi_hover_inc_username"><?php _e('Username', 'instagram-feed'); ?></label>
                        </div>
                        <div>
                            <input name="sbi_hover_inc_date" type="checkbox" id="sbi_hover_inc_date" <?php if($sbi_hover_inc_date == true) echo "checked"; ?> />
                            <label for="sbi_hover_inc_date"><?php _e('Date', 'instagram-feed'); ?></label>
                        </div>
                        <div>
                            <input name="sbi_hover_inc_instagram" type="checkbox" id="sbi_hover_inc_instagram" <?php if($sbi_hover_inc_instagram == true) echo "checked"; ?> />
                            <label for="sbi_hover_inc_instagram"><?php _e('Instagram Icon/Link', 'instagram-feed'); ?></label>
                        </div>
                        <div>
                            <input name="sbi_hover_inc_location" type="checkbox" id="sbi_hover_inc_location" <?php if($sbi_hover_inc_location == true) echo "checked"; ?> />
                            <label for="sbi_hover_inc_location"><?php _e('Location', 'instagram-feed'); ?></label>
                        </div>
                        <div>
                            <input name="sbi_hover_inc_caption" type="checkbox" id="sbi_hover_inc_caption" <?php if($sbi_hover_inc_caption == true) echo "checked"; ?> />
                            <label for="sbi_hover_inc_caption"><?php _e('Caption', 'instagram-feed'); ?></label>
                        </div>
                        <div>
                            <input name="sbi_hover_inc_likes" type="checkbox" id="sbi_hover_inc_likes" <?php if($sbi_hover_inc_likes == true) echo "checked"; ?> />
                            <label for="sbi_hover_inc_likes"><?php _e('Like/Comment Icons', 'instagram-feed'); ?></label>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>

			<?php submit_button(); ?>

            <hr id="caption" />
            <h3><?php _e("Caption", 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Show Caption", 'instagram-feed'); ?></label><code class="sbi_shortcode"> showcaption
                            Eg: showcaption=false</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_show_caption" id="sb_instagram_show_caption" <?php if($sb_instagram_show_caption == true) echo 'checked="checked"' ?> />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Maximum Text Length", 'instagram-feed'); ?></label><code class="sbi_shortcode"> captionlength
                            Eg: captionlength=20</code></th>
                    <td>
                        <input name="sb_instagram_caption_length" id="sb_instagram_caption_length" type="text" value="<?php esc_attr_e( $sb_instagram_caption_length ); ?>" size="4" />Characters
                        &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("The number of characters of text to display in the caption. An elipsis link will be added to allow the user to reveal more text if desired.", 'instagram-feed'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Text Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> captioncolor
                            Eg: captioncolor=dd3333</code></th>
                    <td>
                        <input name="sb_instagram_caption_color" type="text" value="<?php esc_attr_e( $sb_instagram_caption_color ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Text Size', 'instagram-feed'); ?></label><code class="sbi_shortcode"> captionsize
                            Eg: captionsize=12</code></th>
                    <td>
                        <select name="sb_instagram_caption_size" style="width: 180px;">
                            <option value="inherit" <?php if($sb_instagram_caption_size == "inherit") echo 'selected="selected"' ?> ><?php _e('Inherit from theme', 'instagram-feed'); ?></option>
                            <option value="10" <?php if($sb_instagram_caption_size == "10") echo 'selected="selected"' ?> ><?php _e('10px'); ?></option>
                            <option value="11" <?php if($sb_instagram_caption_size == "11") echo 'selected="selected"' ?> ><?php _e('11px'); ?></option>
                            <option value="12" <?php if($sb_instagram_caption_size == "12") echo 'selected="selected"' ?> ><?php _e('12px'); ?></option>
                            <option value="13" <?php if($sb_instagram_caption_size == "13") echo 'selected="selected"' ?> ><?php _e('13px'); ?></option>
                            <option value="14" <?php if($sb_instagram_caption_size == "14") echo 'selected="selected"' ?> ><?php _e('14px'); ?></option>
                            <option value="16" <?php if($sb_instagram_caption_size == "16") echo 'selected="selected"' ?> ><?php _e('16px'); ?></option>
                            <option value="18" <?php if($sb_instagram_caption_size == "18") echo 'selected="selected"' ?> ><?php _e('18px'); ?></option>
                            <option value="20" <?php if($sb_instagram_caption_size == "20") echo 'selected="selected"' ?> ><?php _e('20px'); ?></option>
                            <option value="24" <?php if($sb_instagram_caption_size == "24") echo 'selected="selected"' ?> ><?php _e('24px'); ?></option>
                            <option value="28" <?php if($sb_instagram_caption_size == "28") echo 'selected="selected"' ?> ><?php _e('28px'); ?></option>
                            <option value="32" <?php if($sb_instagram_caption_size == "32") echo 'selected="selected"' ?> ><?php _e('32px'); ?></option>
                            <option value="36" <?php if($sb_instagram_caption_size == "36") echo 'selected="selected"' ?> ><?php _e('36px'); ?></option>
                            <option value="40" <?php if($sb_instagram_caption_size == "40") echo 'selected="selected"' ?> ><?php _e('40px'); ?></option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>

            <hr id="likes" />
            <h3><?php _e("Likes &amp; Comments Icons", 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e("Show Icons", 'instagram-feed'); ?></label><code class="sbi_shortcode"> showlikes
                            Eg: showlikes=false</code></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_show_meta" id="sb_instagram_show_meta" <?php if($sb_instagram_show_meta == true) echo 'checked="checked"' ?> />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Icon Color', 'instagram-feed'); ?></label><code class="sbi_shortcode"> likescolor
                            Eg: likescolor=fff</code></th>
                    <td>
                        <input name="sb_instagram_meta_color" type="text" value="<?php esc_attr_e( $sb_instagram_meta_color ); ?>" class="sbi_colorpick" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Icon Size', 'instagram-feed'); ?></label><code class="sbi_shortcode"> likessize
                            Eg: likessize=14</code></th>
                    <td>
                        <select name="sb_instagram_meta_size" style="width: 180px;">
                            <option value="inherit" <?php if($sb_instagram_meta_size == "inherit") echo 'selected="selected"' ?> ><?php _e('Inherit from theme', 'instagram-feed'); ?></option>
                            <option value="10" <?php if($sb_instagram_meta_size == "10") echo 'selected="selected"' ?> ><?php _e('10px'); ?></option>
                            <option value="11" <?php if($sb_instagram_meta_size == "11") echo 'selected="selected"' ?> ><?php _e('11px'); ?></option>
                            <option value="12" <?php if($sb_instagram_meta_size == "12") echo 'selected="selected"' ?> ><?php _e('12px'); ?></option>
                            <option value="13" <?php if($sb_instagram_meta_size == "13") echo 'selected="selected"' ?> ><?php _e('13px'); ?></option>
                            <option value="14" <?php if($sb_instagram_meta_size == "14") echo 'selected="selected"' ?> ><?php _e('14px'); ?></option>
                            <option value="16" <?php if($sb_instagram_meta_size == "16") echo 'selected="selected"' ?> ><?php _e('16px'); ?></option>
                            <option value="18" <?php if($sb_instagram_meta_size == "18") echo 'selected="selected"' ?> ><?php _e('18px'); ?></option>
                            <option value="20" <?php if($sb_instagram_meta_size == "20") echo 'selected="selected"' ?> ><?php _e('20px'); ?></option>
                            <option value="24" <?php if($sb_instagram_meta_size == "24") echo 'selected="selected"' ?> ><?php _e('24px'); ?></option>
                            <option value="28" <?php if($sb_instagram_meta_size == "28") echo 'selected="selected"' ?> ><?php _e('28px'); ?></option>
                            <option value="32" <?php if($sb_instagram_meta_size == "32") echo 'selected="selected"' ?> ><?php _e('32px'); ?></option>
                            <option value="36" <?php if($sb_instagram_meta_size == "36") echo 'selected="selected"' ?> ><?php _e('36px'); ?></option>
                            <option value="40" <?php if($sb_instagram_meta_size == "40") echo 'selected="selected"' ?> ><?php _e('40px'); ?></option>
                        </select>
                    </td>
                </tr>
                </tbody>
            </table>

            <hr id="comments" />
            <h3><?php _e('Lightbox Comments', 'instagram-feed'); ?></h3>
            <p style="margin: -10px 0 0 0; font-style: italic; font-size: 12px;"><?php _e('Comments available for user feeds only', 'instagram-feed'); ?></p>

            <table class="form-table">
                <tbody>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Show Comments in Lightbox', 'instagram-feed'); ?></label><code class="sbi_shortcode"> lightboxcomments
                            Eg: lightboxcomments="true"</code></th>
                    <td style="padding: 5px 10px 0 10px;">
                        <input type="checkbox" name="sb_instagram_lightbox_comments" id="sb_instagram_lightbox_comments" <?php if($sb_instagram_lightbox_comments == true) echo 'checked="checked"' ?> style="margin-right: 15px;" />
                        <input id="sbi_clear_comment_cache" class="button-secondary" style="margin-top: -5px;" type="submit" value="<?php esc_attr_e( 'Clear Comment Cache' ); ?>" />
                        &nbsp<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("This will remove the cached comments saved in the database", 'instagram-feed'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Number of Comments', 'instagram-feed'); ?></label><code class="sbi_shortcode"> numcomments
                            Eg: numcomments="10"</code></th>
                    <td>
                        <input name="sb_instagram_num_comments" type="text" value="<?php esc_attr_e( $sb_instagram_num_comments ); ?>" size="4" />
                        <span class="sbi_note"><?php _e('Max number of latest comments.', 'instagram-feed'); ?></span>
                        &nbsp<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("This is the maximum number of comments that will be shown in the lightbox. If there are more comments available than the number set, only the latest comments will be shown", 'instagram-feed'); ?></p>
                    </td>
                </tr>

                </tbody>
            </table>

			<?php submit_button(); ?>

		<?php } //End Customize Posts tab ?>

		<?php if( $sbi_active_tab == 'customize-moderation' ) { //Start Customize Moderation tab ?>

            <p class="sb_instagram_contents_links" id="general">
                <span><?php _e('Jump to:', 'instagram-feed'); ?> </span>
                <a href="#filtering"><?php _e('Post Filtering', 'instagram-feed'); ?></a>
                <a href="#moderation"><?php _e('Moderation', 'instagram-feed'); ?></a>
            </p>

            <input type="hidden" name="<?php echo $sb_instagram_customize_moderation_hidden_field; ?>" value="Y">

            <hr id="filtering" />
            <h3><?php _e('Post Filtering', 'instagram-feed'); ?></h3>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Remove photos containing these words or hashtags', 'instagram-feed'); ?></label><code class="sbi_shortcode"> excludewords
                            Eg: excludewords="naughty, words"</code></th>
                    <td>
                        <div class="sb_instagram_apply_labels">
                            <p>Apply to:</p>
                            <input name="sb_instagram_ex_apply_to" id="sb_instagram_ex_all" class="sb_instagram_incex_one_all" type="radio" value="all" <?php if ( $sb_instagram_ex_apply_to == 'all' ) echo 'checked'; ?>/><label for="sb_instagram_ex_all">All feeds</label>
                            <input name="sb_instagram_ex_apply_to" id="sb_instagram_ex_one" class="sb_instagram_incex_one_all" type="radio" value="one" <?php if ( $sb_instagram_ex_apply_to == 'one' ) echo 'checked'; ?>/><label for="sb_instagram_ex_one">One feed</label>
                        </div>

                        <input name="sb_instagram_exclude_words" id="sb_instagram_exclude_words" type="text" style="width: 70%;" value="<?php esc_attr_e( stripslashes($sb_instagram_exclude_words) ); ?>" />
                        <p class="sbi_extra_info sbi_incex_shortcode" <?php if ( $sb_instagram_ex_apply_to == 'one' ) echo 'style="display:block;"'; ?>><?php echo sprintf( __('Add this to the shortcode for your feed %s', 'instagram-feed'), '<code></code>' ); ?></p>

                        <br />
                        <span class="sbi_note" style="margin-left: 0;"><?php _e('Separate words/hashtags using commas', 'instagram-feed'); ?></span>

                        &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("You can use this setting to remove photos which contain certain words or hashtags in the caption. Separate multiple words or hashtags using commas.", 'instagram-feed'); ?></p>

                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Show photos containing these words or hashtags', 'instagram-feed'); ?></label><code class="sbi_shortcode"> includewords
                            Eg: includewords="sunshine"</code></th>
                    <td>
                        <div class="sb_instagram_apply_labels">
                            <p>Apply to:</p>
                            <input name="sb_instagram_inc_apply_to" id="sb_instagram_inc_all" class="sb_instagram_incex_one_all" type="radio" value="all" <?php if ( $sb_instagram_inc_apply_to == 'all' ) echo 'checked'; ?>/><label for="sb_instagram_inc_all">All feeds</label>
                            <input name="sb_instagram_inc_apply_to" id="sb_instagram_inc_one" class="sb_instagram_incex_one_all" type="radio" value="one" <?php if ( $sb_instagram_inc_apply_to == 'one' ) echo 'checked'; ?>/><label for="sb_instagram_inc_one">One feed</label>
                        </div>

                        <input name="sb_instagram_include_words" id="sb_instagram_include_words" type="text" style="width: 70%;" value="<?php esc_attr_e( stripslashes($sb_instagram_include_words) ); ?>" />
                        <p class="sbi_extra_info sbi_incex_shortcode" <?php if ( $sb_instagram_ex_apply_to == 'one' ) echo 'style="display:block;"'; ?>><?php echo sprintf( __('Add this to the shortcode for your feed %s', 'instagram-feed'), '<code></code>' ); ?></p>

                        <br />
                        <span class="sbi_note" style="margin-left: 0;"><?php _e('Separate words/hashtags using commas', 'instagram-feed'); ?></span>

                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php echo sprintf( __("You can use this setting to only show photos which contain certain words or hashtags in the caption. For example, adding %s will show any photos which contain either the word sheep, cow, or dog. Separate multiple words or hashtags using commas.", 'instagram-feed'), '<code>' . __( 'sheep, cow, dog', 'instagram-feed' ) . '</code>' ); ?></p>

                    </td>
                </tr>
                </tbody>
            </table>

            <hr id="moderation" />
            <h3><?php _e('Moderation', 'instagram-feed'); ?></h3>
            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Moderation Type', 'instagram-feed'); ?></label></th>
                    <td>
                        <input name="sb_instagram_moderation_mode" id="sb_instagram_moderation_mode_visual" class="sb_instagram_moderation_mode" type="radio" value="visual" <?php if ( $sb_instagram_moderation_mode === 'visual' ) echo 'checked'; ?> style="margin-top: 0;" /><label for="sb_instagram_moderation_mode_visual">Visual</label>
                        <input name="sb_instagram_moderation_mode" id="sb_instagram_moderation_mode_manual" class="sb_instagram_moderation_mode" type="radio" value="manual" <?php if ( $sb_instagram_moderation_mode === 'manual' ) echo 'checked'; ?> style="margin-top: 0; margin-left: 10px;"/><label for="sb_instagram_moderation_mode_manual">Manual</label>

                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><b><?php _e('Visual Moderation Mode', 'instagram-feed' ); ?></b><br /><?php echo sprintf( __("This adds a button to each feed that will allow you to hide posts, block users, and create white lists from the front end using a visual interface. Visit %s for details", 'instagram-feed'), '<a href="https://smashballoon.com/guide-to-moderation-mode/" target="_blank">' . __('this page', 'instagram-feed' ) . '</a>' ); ?></p>


                        <div class="sbi_mod_manual_settings">

                            <div class="sbi_row">
                                <label><?php _e('Hide specific photos', 'instagram-feed'); ?></label>
                                <textarea name="sb_instagram_hide_photos" id="sb_instagram_hide_photos" style="width: 100%;" rows="3"><?php esc_attr_e( stripslashes($sb_instagram_hide_photos) ); ?></textarea>
                                <br />
                                <span class="sbi_note" style="margin-left: 0;"><?php _e('Separate IDs using commas', 'instagram-feed'); ?></span>

                                &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                <p class="sbi_tooltip"><?php _e("You can use this setting to hide specific photos in your feed. Just click the 'Hide Photo' link in the photo pop-up in your feed to get the ID of the photo, then copy and paste it into this text box.", 'instagram-feed'); ?></p>
                            </div>

                            <div class="sbi_row">
                                <label><?php _e('Block users', 'instagram-feed'); ?></label>
                                <input name="sb_instagram_block_users" id="sb_instagram_block_users" type="text" style="width: 100%;" value="<?php esc_attr_e( stripslashes($sb_instagram_block_users) ); ?>" />

                                <br />
                                <span class="sbi_note" style="margin-left: 0;"><?php _e('Separate usernames using commas', 'instagram-feed'); ?></span>

                                &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                                <p class="sbi_tooltip"><?php _e("You can use this setting to block photos from certain users in your feed. Just enter the usernames here which you want to block. Separate multiple usernames using commas.", 'instagram-feed'); ?></p>
                            </div>

                        </div>

                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Only show posts by these users', 'instagram-feed'); ?></label></th>
                    <td>

                        <input name="sb_instagram_show_users" id="sb_instagram_show_users" type="text" style="width: 70%;" value="<?php esc_attr_e( stripslashes($sb_instagram_show_users) ); ?>" />

                        <br />
                        <span class="sbi_note" style="margin-left: 0;"><?php _e('Separate usernames using commas', 'instagram-feed'); ?></span>

                        &nbsp<a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("You can use this setting to show photos only from certain users in your feed. Just enter the usernames here which you want to show. Separate multiple usernames using commas.", 'instagram-feed'); ?></p>

                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('White lists', 'instagram-feed'); ?></label></th>
                    <td>
                        <div class="sbi_white_list_names_wrapper">
							<?php
							$sbi_current_white_names = get_option( 'sb_instagram_white_list_names', array() );

							if( empty($sbi_current_white_names) ){
								_e("No white lists currently created", 'instagram-feed');
							} else {
								$sbi_white_size = count( $sbi_current_white_names );
								$sbi_i = 1;
								echo 'IDs: ';
								foreach ( $sbi_current_white_names as $white ) {
									if( $sbi_i !== $sbi_white_size ) {
										echo '<span>'.$white.', </span>';
									} else {
										echo '<span>'.$white.'</span>';
									}
									$sbi_i++;
								}
								echo '<br />';
							}
							?>
                        </div>

                        <input id="sbi_clear_white_lists" class="button-secondary" type="submit" value="<?php esc_attr_e( 'Clear White Lists' ); ?>" />
                        &nbsp;<a class="sbi_tooltip_link" href="JavaScript:void(0);" style="display: inline-block; margin-top: 5px;"><?php _e("What is this?", 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("This will remove all of the white lists from the database", 'instagram-feed'); ?></p>

						<?php
						$permanent_white_lists = get_option( 'sb_permanent_white_lists', array() );
						if ( ! empty( $permanent_white_lists ) &&  ! empty( $sbi_current_white_names ) ) {
							$sbi_white_size = count( $permanent_white_lists );
							$sbi_i = 1;
							echo '<div class="sbi_white_list_names_wrapper sbi_white_list_perm">';
							echo 'Permanent: ';
							foreach ( $permanent_white_lists as $white ) {
								if( $sbi_i !== $sbi_white_size ) {
									echo '<span>'.$white.', </span>';
								} else {
									echo '<span style="margin-right: 10px;">'.$white.'</span>';
								}
								$sbi_i++;
							}
							echo '<input id="sbi_clear_permanent_white_lists" class="button-secondary" type="submit" value="' . esc_attr__( 'Disable Permanent White Lists' ) . '" style="vertical-align: middle;"/>';
							echo '</div>';
						}
						?>
                    </td>
                </tr>

                </tbody>
            </table>

			<?php submit_button(); ?>

		<?php } //End Customize Moderation tab ?>

		<?php if( $sbi_active_tab == 'customize-advanced' ) { //Start Customize Advanced tab ?>

            <p class="sb_instagram_contents_links" id="general">
                <span><?php _e('Jump to:', 'instagram-feed'); ?> </span>
                <a href="#snippets"><?php _e('Custom Code', 'instagram-feed'); ?></a>
                <a href="#misc"><?php _e('Misc', 'instagram-feed'); ?></a>
            </p>

            <input type="hidden" name="<?php echo $sb_instagram_customize_advanced_hidden_field; ?>" value="Y">

            <hr id="snippets" />
            <h3><?php _e('Custom Code Snippets', 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
                <tr valign="top">
                    <td style="padding-bottom: 0;">
                        <strong style="font-size: 15px;"><?php _e( 'Custom CSS', 'instagram-feed' ); ?></strong><br />
						<?php _e( 'Enter your own custom CSS in the box below', 'instagram-feed' ); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <textarea name="sb_instagram_custom_css" id="sb_instagram_custom_css" style="width: 70%;" rows="7"><?php esc_attr_e( stripslashes($sb_instagram_custom_css) ); ?></textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <td style="padding-bottom: 0;">
                        <strong style="font-size: 15px;"><?php _e('Custom JavaScript', 'instagram-feed'); ?></strong><br />
						<?php _e( 'Enter your own custom JavaScript/jQuery in the box below', 'instagram-feed' ); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <td>
                        <textarea name="sb_instagram_custom_js" id="sb_instagram_custom_js" style="width: 70%;" rows="7"><?php esc_attr_e( stripslashes($sb_instagram_custom_js) ); ?></textarea>
                        <br /><span class="sbi_note" style="margin: 5px 0 0 2px; display: block;"><b><?php _e('Note:', 'instagram-feed'); ?></b> <?php _e('Custom JavaScript reruns every time more posts are loaded into the feed', 'instagram-feed'); ?></span>
                    </td>
                </tr>
                </tbody>
            </table>

			<?php submit_button(); ?>

            <hr id="misc" />
            <h3><?php _e('Misc', 'instagram-feed'); ?></h3>

            <table class="form-table">
                <tbody>
                <tr>
                    <th class="bump-left"><label class="bump-left"><?php _e("Are you using an Ajax powered theme?", 'instagram-feed'); ?></label><code class="sbi_shortcode"> ajaxtheme
                            Eg: ajaxtheme=true</code></th>
                    <td>
                        <input name="sb_instagram_ajax_theme" type="checkbox" id="sb_instagram_ajax_theme" <?php if($sb_instagram_ajax_theme == true) echo "checked"; ?> />
                        <label for="sb_instagram_ajax_theme"><?php _e('Yes', 'instagram-feed'); ?></label>
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("When navigating your site, if your theme uses Ajax to load content into your pages (meaning your page doesn't refresh) then check this setting. If you're not sure then it's best to leave this setting unchecked while checking with your theme author, otherwise checking it may cause a problem.", 'instagram-feed'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Max concurrent API requests', 'instagram-feed'); ?></label><code class="sbi_shortcode"> maxrequests
                            Eg: maxrequests=2</code></th>
                    <td>
                        <input name="sb_instagram_requests_max" type="number" min="1" max="10" value="<?php esc_attr_e( $sb_instagram_requests_max ); ?>" />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("Change the number of maximum concurrent API requests. This is not recommended unless directed by a member of the support team.", 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr>
                    <th class="bump-left">
                        <label for="sb_instagram_cron" class="bump-left"><?php _e("Force cache to clear on interval", 'instagram-feed'); ?></label>
                    </th>
                    <td>
                        <select name="sb_instagram_cron">
                            <option value="unset" <?php if($sb_instagram_cron == "unset") echo 'selected="selected"' ?> ><?php _e(' - '); ?></option>
                            <option value="yes" <?php if($sb_instagram_cron == "yes") echo 'selected="selected"' ?> ><?php _e('Yes', 'instagram-feed'); ?></option>
                            <option value="no" <?php if($sb_instagram_cron == "no") echo 'selected="selected"' ?> ><?php _e('No', 'instagram-feed'); ?></option>
                        </select>

                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("If you're experiencing an issue with the plugin not auto-updating then you can set this to 'Yes' to run a scheduled event behind the scenes which forces the plugin cache to clear on a regular basis and retrieve new data from Instagram.", 'instagram-feed'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label><?php _e('Cache error API recheck', 'instagram-feed'); ?></label></th>
                    <td>
                        <input type="checkbox" name="check_api" id="sb_instagram_check_api" <?php if($check_api == true) echo 'checked="checked"' ?> />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("If your site uses caching, minification, or JavaScript concatenation, this option can help prevent missing cache problems with the feed.", 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th><label><?php _e("Enable Backup/Permanent caching", 'instagram-feed'); ?></label></th>
                    <td class="sbi-customize-tab-opt">
                        <input name="sb_instagram_backup" type="checkbox" id="sb_instagram_backup" <?php if($sb_instagram_backup == true) echo "checked"; ?> />
                        <input id="sbi_clear_backups" class="button-secondary" type="submit" value="<?php esc_attr_e( 'Clear Backup/Permanent Caches' ); ?>" />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e('Every feed will save a duplicate version of itself in the database to be used if the normal cache is not available.', 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Enqueue JS file in head', 'instagram-feed'); ?></label></th>
                    <td>
                        <input type="checkbox" name="enqueue_js_in_head" id="sb_instagram_enqueue_js_in_head" <?php if($enqueue_js_in_head == true) echo 'checked="checked"' ?> />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("Check this box if you'd like to enqueue the JavaScript file for the plugin in the head instead of the footer.", 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e('Enqueue CSS file with shortcode', 'instagram-feed'); ?></label></th>
                    <td>
                        <input type="checkbox" name="enqueue_css_in_shortcode" id="sb_instagram_enqueue_css_in_shortcode" <?php if($enqueue_css_in_shortcode == true) echo 'checked="checked"' ?> />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("Check this box if you'd like to only include the CSS file for the plugin when the feed is on the page.", 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label for="sb_instagram_disable_mob_swipe"><?php _e('Disable Mobile Swipe Code', 'instagram-feed'); ?></label></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_disable_mob_swipe" id="sb_instagram_disable_mob_swipe" <?php if($sb_instagram_disable_mob_swipe == true) echo 'checked="checked"' ?> />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("Check this box if you'd like to disable jQuery mobile in the JavaScript file. This will fix issues with jQuery versions 2.x and later.", 'instagram-feed'); ?></p>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row"><label><?php _e("Disable icon font", 'instagram-feed'); ?></label></th>
                    <td>
                        <input type="checkbox" name="sb_instagram_disable_font" id="sb_instagram_disable_font" <?php if($sb_instagram_disable_font == true) echo 'checked="checked"' ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="sbi_font_method"><?php _e("Icon Method", 'instagram-feed'); ?></label></th>
                    <td>
                        <select name="sbi_font_method" id="sbi_font_method" class="default-text">
                            <option value="svg" id="sbi-font_method" class="default-text" <?php if($sbi_font_method == 'svg') echo 'selected="selected"' ?>>SVG</option>
                            <option value="fontfile" id="sbi-font_method" class="default-text" <?php if($sbi_font_method == 'fontfile') echo 'selected="selected"' ?>><?php _e("Font File", 'instagram-feed'); ?></option>
                        </select>
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php _e("This plugin uses SVGs for all icons in the feed. Use this setting to switch to font icons.", 'instagram-feed'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="sbi_br_adjust"><?php _e("Caption Line-Break Limit", 'instagram-feed'); ?></label></th>
                    <td>
                        <input type="checkbox" name="sbi_br_adjust" id="sbi_br_adjust" <?php if($sbi_br_adjust == true) echo 'checked="checked"' ?> />
                        <a class="sbi_tooltip_link" href="JavaScript:void(0);"><?php _e('What does this mean?', 'instagram-feed'); ?></a>
                        <p class="sbi_tooltip"><?php echo sprintf( __( "Character Limits for captions are adjusted for use of new line or %s html. Disable this setting to always use the true character limit.", 'instagram-feed' ), '&lt;br>' ); ?></p>
                    </td>
                </tr>
                </tbody>
            </table>
			<?php submit_button(); ?>

		<?php } //End Customize Advanced tab ?>

        </form>


		<?php //Show Customize page footer
		if( strpos($sbi_active_tab, 'customize') !== false ) { ?>
            <!-- <p><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>&nbsp; <?php _e('Next Step:', 'instagram-feed'); ?> <a href="?page=sb-instagram-feed&tab=display"><?php _e('Display your Feed', 'instagram-feed'); ?></a></p> -->
            <p><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php echo sprintf( __('Need help setting up the plugin? Check out our %s', 'instagram-feed'), '<a href="https://smashballoon.com/instagram-feed/docs/" target="_blank">' . __( 'setup directions', 'instagram-feed' ) . '</a>' ); ?></p>
		<?php } ?>


		<?php if( $sbi_active_tab == 'display' ) { //Start Configure tab ?>

            <h3><?php _e('Display your Feed', 'instagram-feed'); ?></h3>
            <p><?php _e("Copy and paste the following shortcode directly into the page, post or widget where you'd like the feed to show up:", 'instagram-feed'); ?></p>
            <input type="text" value="[instagram-feed]" size="16" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select()" title="<?php _e('To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac).', 'instagram-feed'); ?>" />

            <h3 style="padding-top: 10px;"><?php _e( 'Multiple Feeds', 'custom-twitter-feed' ); ?></h3>
            <p><?php _e("If you'd like to display multiple feeds then you can set different settings directly in the shortcode like so:", 'instagram-feed'); ?>
                <code>[instagram-feed num=9 cols=3]</code></p>
            <p>You can display as many different feeds as you like, on either the same page or on different pages, by just using the shortcode options below. For example:<br />
                <code>[instagram-feed]</code><br />
                <code>[instagram-feed num=4 cols=4 showfollow=false]</code><br />
                <code>[instagram-feed user=smashballoon]</code><br />
            </p>
            <p><?php _e("See the table below for a full list of available shortcode options:", 'instagram-feed'); ?></p>

            <table class="sbi_shortcode_table">
                <tbody>
                <tr valign="top">
                    <th scope="row"><?php _e('Shortcode option', 'instagram-feed'); ?></th>
                    <th scope="row"><?php _e('Description', 'instagram-feed'); ?></th>
                    <th scope="row"><?php _e('Example', 'instagram-feed'); ?></th>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Configure Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>type</td>
                    <td><?php _e("Display photos from a connected User Account", 'instagram-feed'); ?> (user)<br /><?php _e("Display posts from a Hashtag", 'instagram-feed'); ?> (hashtag)<br /><?php _e("Display posts from a Location", 'instagram-feed'); ?> (location)<br /><?php _e("Display posts from Coordinates", 'instagram-feed'); ?> (coordinates)<br /><?php _e("Display post(s) by Post ID", 'instagram-feed'); ?> (single)<br /><?php _e("Display a mix of feed types", 'instagram-feed'); ?> (mixed)</td>
                    <td><code>[instagram-feed type=user]</code><br /><code>[instagram-feed type=hashtag]</code><br/><code>[instagram-feed type=location]</code><br /><code>[instagram-feed type=coordinates]</code><br /><code>[instagram-feed type=single]</code></td>
                </tr>
                <tr>
                    <td>user</td>
                    <td><?php _e('Your Instagram user name for the account. This must be a user name from one of your connected accounts.', 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed user="smashballoon"]</code></td>
                </tr>
                <tr>
                    <td>hashtag</td>
                    <td><?php _e('Any hashtag. Separate multiple IDs by commas.', 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed hashtag="#awesome"]</code></td>
                </tr>
                <tr>
                    <td>location</td>
                    <td><?php _e('The ID of the location. Separate multiple IDs by commas.', 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed location="213456451"]</code></td>
                </tr>
                <tr>
                    <td>coordinates</td>
                    <td><?php _e('The coordinates to display photos from. Separate multiple sets of coordinates by commas.', 'instagram-feed'); ?><br /><?php echo sprintf( __( 'The format is %s.', 'instagram-feed' ), __( '(latitude,longitude,distance)', 'instagram-feed' ) ); ?></td>
                    <td><code>[instagram-feed coordinates="(25.76,-80.19,500)"]</code></td>
                </tr>
                <tr>
                    <td>single</td>
                    <td><?php _e('The id of the single post you would like to show. Separate multiple ids by comma', 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed single="1334423402283195360_13460080"]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Customize Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>width</td>
                    <td><?php _e("The width of your feed. Any number.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed width=50]</code></td>
                </tr>
                <tr>
                    <td>widthunit</td>
                    <td><?php _e("The unit of the width. 'px' or '%'", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed widthunit=%]</code></td>
                </tr>
                <tr>
                    <td>height</td>
                    <td><?php _e("The height of your feed. Any number.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed height=250]</code></td>
                </tr>
                <tr>
                    <td>heightunit</td>
                    <td><?php _e("The unit of the height. 'px' or '%'", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed heightunit=px]</code></td>
                </tr>
                <tr>
                    <td>background</td>
                    <td><?php _e("The background color of the feed. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed background=#ffff00]</code></td>
                </tr>


                <tr class="sbi_table_header"><td colspan=3><?php _e("Layout Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>layout</td>
                    <td><?php _e("How posts are arranged visually in the feed.", 'instagram-feed' ); ?> 'grid', 'carousel', 'masonry', or 'highlight'</td>
                    <td><code>[instagram-feed layout=grid]</code></td>
                </tr>
                <tr>
                    <td>num</td>
                    <td><?php _e("The number of photos to display initially. Maximum is 33.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed num=10]</code></td>
                </tr>
                <tr>
                    <td>nummobile</td>
                    <td><?php _e("The number of photos to display initially for mobile screens (smaller than 480 pixels).", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed nummobile=6]</code></td>
                </tr>
                <tr>
                    <td>cols</td>
                    <td><?php _e("The number of columns in your feed. 1 - 10.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed cols=5]</code></td>
                </tr>
                <tr>
                    <td>colsmobile</td>
                    <td><?php _e("The number of columns in your feed for mobile screens (smaller than 480 pixels).", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed colsmobile=2]</code></td>
                </tr>
                <tr>
                    <td>imagepadding</td>
                    <td><?php _e("The spacing around your photos", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed imagepadding=10]</code></td>
                </tr>
                <tr>
                    <td>imagepaddingunit</td>
                    <td><?php _e("The unit of the padding. 'px' or '%'", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed imagepaddingunit=px]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Carousel Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>carouselrows</td>
                    <td><?php _e("Choose 1 or 2 rows of posts in the carousel", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed carouselrows=1]</code></td>
                </tr>
                <tr>
                    <td>carouselloop</td>
                    <td><?php _e("Infinitely loop through posts or rewind", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed carouselloop=rewind]</code></td>
                </tr>
                <tr>
                    <td>carouselarrows</td>
                    <td><?php _e("Display directional arrows on the carousel", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed carouselarrows=true]</code></td>
                </tr>
                <tr>
                    <td>carouselpag</td>
                    <td><?php _e("Display pagination links below the carousel", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed carouselpag=true]</code></td>
                </tr>
                <tr>
                    <td>carouselautoplay</td>
                    <td><?php _e("Make the carousel autoplay", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed carouselautoplay=true]</code></td>
                </tr>
                <tr>
                    <td>carouseltime</td>
                    <td><?php _e("The interval time between slides for autoplay. Time in miliseconds.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed carouseltime=8000]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Highlight Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>highlighttype</td>
                    <td><?php _e("Choose from 3 different ways of highlighting posts.", 'instagram-feed'); ?> 'pattern', 'hashtag', 'id'.</td>
                    <td><code>[instagram-feed highlighttype=hashtag]</code></td>
                </tr>
                <tr>
                    <td>highlightpattern</td>
                    <td><?php _e("How often a post is highlighted.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed highlightpattern=7]</code></td>
                </tr>
                <tr>
                    <td>highlightoffset</td>
                    <td><?php _e("When to start the highlight pattern.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed highlightoffset=3]</code></td>
                </tr>
                <tr>
                    <td>highlighthashtag</td>
                    <td><?php _e("Highlight posts with these hashtags.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed highlighthashtag=best]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Photos Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>sortby</td>
                    <td><?php _e("Sort the posts by Newest to Oldest (none) or Random (random)", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed sortby=random]</code></td>
                </tr>
                <tr>
                    <td>imageres</td>
                    <td><?php _e("The resolution/size of the photos.", 'instagram-feed'); ?> 'auto', full', 'medium' or 'thumb'.</td>
                    <td><code>[instagram-feed imageres=full]</code></td>
                </tr>
                <tr>
                    <td>media</td>
                    <td><?php _e("Display all media, only photos, or only videos", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed media=photos]</code></td>
                </tr>
                <tr>
                    <td>disablelightbox</td>
                    <td><?php _e("Whether to disable the photo Lightbox. It is enabled by default.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed disablelightbox=true]</code></td>
                </tr>
                <tr>
                    <td>captionlinks</td>
                    <td><?php _e("Whether to use urls in captions for the photo's link instead of linking to instagram.com.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed captionlinks=true]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Lightbox Comments Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>lightboxcomments</td>
                    <td><?php _e("Whether to show comments in the lightbox for this feed.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed lightboxcomments=true]</code></td>
                </tr>
                <tr>
                    <td>numcomments</td>
                    <td><?php _e("Number of comments to show starting from the most recent.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed numcomments=10]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Photos Hover Style Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>hovercolor</td>
                    <td><?php _e("The background color when hovering over a photo. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed hovercolor=#ff0000]</code></td>
                </tr>
                <tr>
                    <td>hovertextcolor</td>
                    <td><?php _e("The text/icon color when hovering over a photo. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed hovertextcolor=#fff]</code></td>
                </tr>
                <tr>
                    <td>hoverdisplay</td>
                    <td><?php _e("The info to display when hovering over the photo. Available options:", 'instagram-feed'); ?><br />username, date, instagram, location, caption, likes</td>
                    <td><code>[instagram-feed hoverdisplay="date, location, likes"]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Header Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>showheader</td>
                    <td><?php _e("Whether to show the feed Header.", 'instagram-feed'); ?> 'true' or 'false'.</td>
                    <td><code>[instagram-feed showheader=false]</code></td>
                </tr>
                <tr>
                    <td>headerstyle</td>
                    <td><?php _e("Which header style to use. Choose from standard, boxed, or centered.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed headerstyle=boxed]</code></td>
                </tr>
                <tr>
                    <td>headersize</td>
                    <td><?php _e("Size of the header. Choose from small, medium, or large.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed headersize=medium]</code></td>
                </tr>
                <tr>
                    <td>headerprimarycolor</td>
                    <td><?php _e("The primary color to use for the <b>boxed</b> header. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed headerprimarycolor=#333]</code></td>
                </tr>
                <tr>
                    <td>headersecondarycolor</td>
                    <td><?php _e("The secondary color to use for the <b>boxed</b> header. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed headersecondarycolor=#ccc]</code></td>
                </tr>
                <tr>
                    <td>showfollowers</td>
                    <td><?php _e("Display the number of followers in the header", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed showfollowers=true]</code></td>
                </tr>
                <tr>
                    <td>showbio</td>
                    <td><?php _e("Display the bio in the header", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed showbio=true]</code></td>
                </tr>
                <tr>
                    <td>headercolor</td>
                    <td><?php _e("The color of the Header text. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed headercolor=#333]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Caption Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>showcaption</td>
                    <td><?php _e("Whether to show the photo caption. 'true' or 'false'.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed showcaption=false]</code></td>
                </tr>
                <tr>
                    <td>captionlength</td>
                    <td><?php _e("The number of characters of the caption to display", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed captionlength=50]</code></td>
                </tr>
                <tr>
                    <td>captioncolor</td>
                    <td><?php _e("The text color of the caption. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed captioncolor=#000]</code></td>
                </tr>
                <tr>
                    <td>captionsize</td>
                    <td><?php _e("The size of the caption text. Any number.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed captionsize=24]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Likes &amp; Comments Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>showlikes</td>
                    <td><?php _e("Whether to show the Likes &amp; Comments. 'true' or 'false'.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed showlikes=false]</code></td>
                </tr>
                <tr>
                    <td>likescolor</td>
                    <td><?php _e("The color of the Likes &amp; Comments. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed likescolor=#FF0000]</code></td>
                </tr>
                <tr>
                    <td>likessize</td>
                    <td><?php _e("The size of the Likes &amp; Comments. Any number.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed likessize=14]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("'Load More' Button Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>showbutton</td>
                    <td><?php _e("Whether to show the 'Load More' button.", 'instagram-feed'); ?> 'true' or 'false'.</td>
                    <td><code>[instagram-feed showbutton=false]</code></td>
                </tr>
                <tr>
                    <td>buttoncolor</td>
                    <td><?php _e("The background color of the button. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed buttoncolor=#000]</code></td>
                </tr>
                <tr>
                    <td>buttontextcolor</td>
                    <td><?php _e("The text color of the button. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed buttontextcolor=#fff]</code></td>
                </tr>
                <tr>
                    <td>buttontext</td>
                    <td><?php _e("The text used for the button.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed buttontext="Load More Photos"]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("'Follow' Button Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>showfollow</td>
                    <td><?php _e("Whether to show the Instagram 'Follow' button.", 'instagram-feed'); ?> 'true' or 'false'.</td>
                    <td><code>[instagram-feed showfollow=true]</code></td>
                </tr>
                <tr>
                    <td>followcolor</td>
                    <td><?php _e("The background color of the button. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed followcolor=#ff0000]</code></td>
                </tr>
                <tr>
                    <td>followtextcolor</td>
                    <td><?php _e("The text color of the button. Any hex color code.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed followtextcolor=#fff]</code></td>
                </tr>
                <tr>
                    <td>followtext</td>
                    <td><?php _e("The text used for the button.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed followtext="Follow me"]</code></td>
                </tr>
                <tr class="sbi_table_header"><td colspan=3><?php _e("Auto Load More on Scroll", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>autoscroll</td>
                    <td><?php _e("Load more posts automatically as the user scrolls down the page.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed autoscroll=true]</code></td>
                </tr>
                <tr>
                    <td>autoscrolldistance</td>
                    <td><?php _e("Distance before the end of feed or page that triggers the loading of more posts.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed autoscrolldistance=200]</code></td>
                </tr>
                <tr class="sbi_table_header"><td colspan=3><?php _e("Post Filtering Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>excludewords</td>
                    <td><?php _e("Remove posts which contain certain words or hashtags in the caption.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed excludewords="bad, words"]</code></td>
                </tr>
                <tr>
                    <td>includewords</td>
                    <td><?php _e("Only display posts which contain certain words or hashtags in the caption.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed includewords="sunshine"]</code></td>
                </tr>
                <tr>
                    <td>showusers</td>
                    <td><?php _e("Only display posts from this user. Separate multiple users with a comma", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed showusers="smashballoon,taylorswift"]</code></td>
                </tr>
                <tr>
                    <td>whitelist</td>
                    <td><?php _e("Only display posts that match one of the post ids in this \"whitelist\"", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed whitelist="2"]</code></td>
                </tr>

                <tr class="sbi_table_header"><td colspan=3><?php _e("Misc Options", 'instagram-feed'); ?></td></tr>
                <tr>
                    <td>permanent</td>
                    <td><?php _e("Feed will never look for new posts from Instagram.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed permanent="true"]</code></td>
                </tr>
                <tr>
                    <td>maxrequests</td>
                    <td><?php _e("Change the number of maximum concurrent API requests.", 'instagram-feed'); ?><br /><?php _e("This is not recommended unless directed by a member of the support team.", 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed maxrequests="2"]</code></td>
                </tr>
                <tr>
                    <td>accesstoken</td>
                    <td><?php _e('A Valid Instagram Access Token. Separate multiple using commas. This is only necessary if you do not have the account connected on the "Configure" tab.', 'instagram-feed'); ?></td>
                    <td><code>[instagram-feed accesstoken="XXXXXXXXXX"]</code></td>
                </tr>

                </tbody>
            </table>

            <p><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php echo sprintf( __('Need help setting up the plugin? Check out our %s', 'instagram-feed'), '<a href="https://smashballoon.com/instagram-feed/docs/" target="_blank">' . __('setup directions', 'instagram-feed' ) . '</a>' ); ?></p>

		<?php } //End Display tab ?>


		<?php if( $sbi_active_tab == 'support' ) { //Start Support tab ?>
            <div class="sbi_support">

                <br />
                <h3 style="padding-bottom: 10px;">Need help?</h3>

                <p>
                    <span class="sbi-support-title"><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <a href="https://smashballoon.com/instagram-feed/docs/" target="_blank"><?php _e('Setup Directions', 'instagram-feed'); ?></a></span>
					<?php _e('A step-by-step guide on how to setup and use the plugin.', 'instagram-feed'); ?>
                </p>

                <p>
                    <span class="sbi-support-title"><i class="fa fa-youtube-play" aria-hidden="true"></i>&nbsp; <a href="https://www.youtube.com/embed/q6ZXVU4g970" target="_blank" id="sbi-play-support-video"><?php _e('Watch a Video', 'instagram-feed'); ?></a></span>
					<?php _e('How to setup, use, and customize the plugin.', 'instagram-feed'); ?>

                    <iframe id="sbi-support-video" src="//www.youtube.com/embed/q6ZXVU4g970?theme=light&amp;showinfo=0&amp;controls=2&amp;rel=0" width="960" height="540" frameborder="0" allowfullscreen="allowfullscreen" allow="autoplay; encrypted-media"></iframe>
                </p>

                <p>
                    <span class="sbi-support-title"><i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp; <a href="https://smashballoon.com/instagram-feed/support/faq/" target="_blank"><?php _e('FAQs and Docs', 'instagram-feed'); ?></a></span>
					<?php _e('View our expansive library of FAQs and documentation to help solve your problem as quickly as possible.', 'instagram-feed'); ?>
                </p>

                <div class="sbi-support-faqs">

                    <ul>
                        <li><b>FAQs</b></li>
                        <li>&bull;&nbsp; <a href="https://smashballoon.com/my-instagram-access-token-keep-expiring/" target="_blank"><?php _e( 'My Access Token Keeps Expiring', 'instagram-feed' ); ?></a></li>
                        <li>&bull;&nbsp; <a href="https://smashballoon.com/my-photos-wont-load/" target="_blank"><?php _e('My Instagram Feed Won\'t Load', 'instagram-feed'); ?></a></li>
                        <li>&bull;&nbsp; <a href="https://smashballoon.com/can-display-photos-specific-hashtag-specific-user-id/" target="_blank"><?php _e( 'Filter a User Feed by Hashtag', 'instagram-feed'); ?></a></li>
                        <li style="margin-top: 8px; font-size: 12px;"><a href="https://smashballoon.com/instagram-feed/support/faq/" target="_blank"><?php _e('See All', 'instagram-feed'); ?><i class="fa fa-chevron-right" aria-hidden="true"></i></a></li>
                    </ul>

                    <ul>
                        <li><b>Documentation</b></li>
                        <li>&bull;&nbsp; <a href="https://smashballoon.com/instagram-feed/docs/" target="_blank"><?php _e('Installation and Configuration', 'instagram-feed'); ?></a></li>
                        <li>&bull;&nbsp; <a href="https://smashballoon.com/display-multiple-instagram-feeds/" target="_blank"><?php _e('Displaying multiple feeds', 'instagram-feed'); ?></a></li>
                        <li>&bull;&nbsp; <a href="https://smashballoon.com/instagram-feed-faq/customization/" target="_blank"><?php _e('Customizing your Feed', 'instagram-feed'); ?></a></li>
                    </ul>
                </div>

                <p>
                    <span class="sbi-support-title"><i class="fa fa-rocket" aria-hidden="true"></i>&nbsp; <a href="admin.php?page=sbi-welcome-new"><?php _e('Welcome Page', 'instagram-feed'); ?></a></span>
					<?php _e("View the plugin welcome page to see what's new in the latest update.", 'instagram-feed'); ?>
                </p>

                <p>
                    <span class="sbi-support-title"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; <a href="https://smashballoon.com/instagram-feed/support/" target="_blank"><?php _e('Request Support', 'instagram-feed'); ?></a></span>
					<?php _e('Still need help? Submit a ticket and one of our support experts will get back to you as soon as possible.', 'instagram-feed'); ?><br /><b><?php _e('Important:', 'instagram-feed'); ?></b> <?php echo sprintf( __('Please include your %s below with all support requests.', 'instagram-feed'), '<b>' . __('System Info', 'instagram-feed' ) . '</b>'); ?>
                </p>
            </div>

            <hr />

            <h3><?php _e('System Info', 'instagram-feed'); ?> &nbsp; <i style="color: #666; font-size: 11px; font-weight: normal;"><?php _e( 'Click the text below to select all', 'instagram-feed' ); ?></i></h3>


			<?php $sbi_options = get_option('sb_instagram_settings'); ?>
            <textarea readonly="readonly" onclick="this.focus();this.select()" title="To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac)." style="width: 100%; max-width: 960px; height: 500px; white-space: pre; font-family: Menlo,Monaco,monospace;">
## SITE/SERVER INFO: ##
Site URL:                 <?php echo site_url() . "\n"; ?>
Home URL:                 <?php echo home_url() . "\n"; ?>
WordPress Version:        <?php echo get_bloginfo( 'version' ) . "\n"; ?>
PHP Version:              <?php echo PHP_VERSION . "\n"; ?>
Web Server Info:          <?php echo $_SERVER['SERVER_SOFTWARE'] . "\n"; ?>

## ACTIVE PLUGINS: ##
<?php
$plugins = get_plugins();
$active_plugins = get_option( 'active_plugins', array() );

foreach ( $plugins as $plugin_path => $plugin ) {
	// If the plugin isn't active, don't show it.
	if ( ! in_array( $plugin_path, $active_plugins ) )
		continue;

	echo $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
}
?>

## PLUGIN SETTINGS: ##
sb_instagram_license => <?php echo get_option( 'sbi_license_key' ) . "\n"; ?>
sb_instagram_license_type => <?php echo SBI_PLUGIN_NAME . "\n"; ?>
<?php
foreach( $sbi_options as $key => $val ) {
	if ( is_array( $val ) ) {
		foreach ( $val as $item ) {
			if ( is_array( $item ) ) {
				foreach ( $item as $key2 => $val2 ) {
					echo "$key2 => $val2\n";
				}
			} else {
				echo "$key => $item\n";
			}
		}
	} else {
		echo "$key => $val\n";
	}
}
?>

## LISTS AND CACHES: ##
<?php
$sbi_current_white_names = get_option( 'sb_instagram_white_list_names', array() );

if( empty( $sbi_current_white_names ) ){
	_e("No white lists currently created", 'instagram-feed');
} else {
	$sbi_white_size = count( $sbi_current_white_names );
	$sbi_i = 1;
	echo 'IDs: ';
	foreach ( $sbi_current_white_names as $white ) {
		if( $sbi_i !== $sbi_white_size ) {
			echo $white.', ';
		} else {
			echo $white;
		}
		$sbi_i++;
	}
}
echo "\n";

if ( isset( $sbi_current_white_names[0] ) ) {
	$sb_instagram_white_lists = get_option( 'sb_instagram_white_lists_'.$sbi_current_white_names[0] , '' );
	$sb_instagram_white_list_ids = ! empty( $sb_instagram_white_lists ) ? implode( ', ', $sb_instagram_white_lists ) : '';
	echo 'White list ' . $sbi_current_white_names[0] . ': ' .$sb_instagram_white_list_ids . "\n";
}

global $wpdb;
$table_name = esc_sql( $wpdb->prefix . "options" );
$result = $wpdb->get_results( "
SELECT *
FROM $table_name
WHERE `option_name` LIKE ('%\_transient\_sbi\_%')
LIMIT 1;
", ARRAY_A );
if ( is_array($result) && count($result) > 0 ) {
	echo 'Most recent cache: ' . substr( $result[0]['option_value'], 0, 100 ) . "\n";
} else {
	echo 'No feed caches found' . "\n";
}

$con_accounts = isset( $sbi_options['connected_accounts'] ) ? $sbi_options['connected_accounts'] : array();
$first_at = '';
$i = 0;
if ( ! empty( $con_accounts ) ) {
	foreach ( $con_accounts as $account ) {
		if ( $i == 0 ) {
			$first_at = $account['access_token'];
			$i++;
		}
	}

}

$url = ! empty( $first_at ) ? 'https://api.instagram.com/v1/users/self/?access_token=' . sbi_maybe_clean( $first_at ) : 'no_at';
if ( $url !== 'no_at' ) {
	$args = array(
		'timeout' => 60,
		'sslverify' => false
	);
	$result = wp_remote_get( $url, $args );

	if ( ! is_wp_error( $result ) ) {
		$data = json_decode( $result['body'] );

		if ( isset( $data->data->id ) ) {
			echo 'id: ' . $data->data->id . "\n";
			echo 'username: ' . $data->data->username . "\n";
			echo 'posts: ' . $data->data->counts->media . "\n";

		} else {
			echo 'No id returned' . "\n";
			echo 'code: ' . $data->meta->code . "\n";
			if ( isset( $data->meta->error_message ) ) {
				echo 'error_message: ' . $data->meta->error_message . "\n";
			}
		}
	} else {
		var_export( $result );
	}


} else {
	echo 'No Access Token';
}?>

## Invalid Tokens: ##
<?php
// $sb_expired_tokens = get_option( 'sb_expired_tokens' );
// if (is_array($sb_expired_tokens)){
//     $sb_expired_tokens = array_unique($sb_expired_tokens);
// }
// var_export($sb_expired_tokens);
?>
        </textarea>


			<?php
		} //End Support tab
		?>

        <div class="sbi_quickstart">
            <h3><i class="fa fa-rocket" aria-hidden="true"></i>&nbsp; Display your feed</h3>
            <p>Copy and paste this shortcode directly into the page, post or widget where you'd like to display the feed:        <input type="text" value="[instagram-feed]" size="15" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select()" title="To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac)."></p>
            <p>Find out how to display <a href="?page=sb-instagram-feed&amp;tab=display">multiple feeds</a>.</p>
        </div>

        <hr />

        <p><i class="fa fa-facebook-square" aria-hidden="true" style="color: #3B5998; font-size: 23px; margin-right: 1px;"></i>&nbsp; <span style="display: inline-block; top: -3px; position: relative;">Want to display Facebook posts? Check out our <a href="https://wordpress.org/plugins/custom-facebook-feed/" target="_blank">Custom Facebook Feed</a> plugin</span></p>

        <p><i class="fa fa-twitter-square" aria-hidden="true" style="color: #00aced; font-size: 23px; margin-right: 1px;"></i>&nbsp; <span style="display: inline-block; top: -3px; position: relative;">Got Tweets? Check out our <a href="https://wordpress.org/plugins/custom-twitter-feeds/" target="_blank">Custom Twitter Feeds</a> plugin</span></p>

    </div> <!-- end #sbi_admin -->

<?php } //End Settings page

function sb_instagram_admin_style() {
	wp_register_style( 'sb_instagram_admin_css', plugin_dir_url( __FILE__ ) . 'css/sb-instagram-admin.css', false, SBIVER );
	wp_enqueue_style( 'sb_instagram_font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
	wp_enqueue_style( 'sb_instagram_admin_css' );
	wp_enqueue_style( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'sb_instagram_admin_style' );

function sb_instagram_admin_scripts() {
	wp_enqueue_script( 'sb_instagram_admin_js', plugin_dir_url( __FILE__ ) . 'js/sb-instagram-admin.js', false, SBIVER );
	wp_localize_script( 'sb_instagram_admin_js', 'sbiA', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'sbi_nonce' => wp_create_nonce( 'sbi_nonce' )
		)
	);
	if( !wp_script_is('jquery-ui-draggable') ) {
		wp_enqueue_script(
			array(
				'jquery',
				'jquery-ui-core',
				'jquery-ui-draggable'
			)
		);
	}
	wp_enqueue_script(
		array(
			'hoverIntent',
			'wp-color-picker'
		)
	);
}
add_action( 'admin_enqueue_scripts', 'sb_instagram_admin_scripts' );

// Add a Settings link to the plugin on the Plugins page
$sbi_plugin_file = 'instagram-feed-pro/instagram-feed.php';
add_filter( "plugin_action_links_{$sbi_plugin_file}", 'sbi_add_settings_link', 10, 2 );

//modify the link by unshifting the array
function sbi_add_settings_link( $links, $file ) {
	$sbi_settings_link = '<a href="' . admin_url( 'admin.php?page=sb-instagram-feed' ) . '">' . __( 'Settings', 'sb-instagram-feed' ) . '</a>';
	array_unshift( $links, $sbi_settings_link );

	return $links;
}

/**
 * Called via ajax to automatically save access token and access token secret
 * retrieved with the big blue button
 */
function sbi_auto_save_tokens() {
	$nonce = $_POST['sbi_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}

	if ( current_user_can( 'edit_posts' ) ) {
		wp_cache_delete ( 'alloptions', 'options' );

		$options = get_option( 'sb_instagram_settings', array() );
		$new_access_token = isset( $_POST['access_token'] ) ? sanitize_text_field( $_POST['access_token'] ) : false;
		$split_token = $new_access_token ? explode( '.', $new_access_token ) : array();
		$new_user_id = isset( $split_token[0] ) ? $split_token[0] : '';

		$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();
		$test_connection_data = sbi_account_data_for_token( $new_access_token );

		$connected_accounts[ $new_user_id ] = array(
			'access_token' => sbi_get_parts( $new_access_token ),
			'user_id' => $test_connection_data['id'],
			'username' => $test_connection_data['username'],
			'is_valid' => $test_connection_data['is_valid'],
			'last_checked' => $test_connection_data['last_checked'],
			'profile_picture' => $test_connection_data['profile_picture']
		);

		$options['connected_accounts'] = $connected_accounts;

		update_option( 'sb_instagram_settings', $options );

		echo json_encode( $connected_accounts[ $new_user_id ] );
	}
	die();
}
add_action( 'wp_ajax_sbi_auto_save_tokens', 'sbi_auto_save_tokens' );

function sbi_auto_save_id() {
	$nonce = $_POST['sbi_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}
	if ( current_user_can( 'edit_posts' ) && isset( $_POST['id'] ) ) {
		$options = get_option( 'sb_instagram_settings', array() );

		$options['sb_instagram_user_id'] = array( sanitize_text_field( $_POST['id'] ) );

		update_option( 'sb_instagram_settings', $options );
	}
	die();
}
add_action( 'wp_ajax_sbi_auto_save_id', 'sbi_auto_save_id' );

function sbi_test_token() {
	$access_token = isset( $_POST['access_token'] ) ? sanitize_text_field( $_POST['access_token'] ) : false;
	$options = get_option( 'sb_instagram_settings', array() );
	$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();

	if ( $access_token ) {
		wp_cache_delete ( 'alloptions', 'options' );

		$split_token = explode( '.', $access_token );
		$new_user_id = isset( $split_token[0] ) ? $split_token[0] : '';

		$test_connection_data = sbi_account_data_for_token( $access_token );

		if ( isset( $test_connection_data['error_message'] ) ) {
			echo $test_connection_data['error_message'];
		} elseif ( $test_connection_data !== false ) {
			$username = $test_connection_data['username'] ? $test_connection_data['username'] : $connected_accounts[ $new_user_id ]['username'];
			$user_id = $test_connection_data['id'] ? $test_connection_data['id'] : $connected_accounts[ $new_user_id ]['user_id'];
			$profile_picture = $test_connection_data['profile_picture'] ? $test_connection_data['profile_picture'] : $connected_accounts[ $new_user_id ]['profile_picture'];

			$connected_accounts[ $new_user_id ] = array(
				'access_token' => sbi_get_parts( $access_token ),
				'user_id' => $user_id,
				'username' => $username,
				'is_valid' => $test_connection_data['is_valid'],
				'last_checked' => $test_connection_data['last_checked'],
				'profile_picture' => $profile_picture
			);

			$options['connected_accounts'] = $connected_accounts;

			update_option( 'sb_instagram_settings', $options );

			echo json_encode( $connected_accounts[ $new_user_id ] );
		} else {
			echo 'A successful connection could not be made. Please make sure your Access Token is valid.';
		}

	}

	die();
}
add_action( 'wp_ajax_sbi_test_token', 'sbi_test_token' );

function sbi_delete_account() {
	$nonce = $_POST['sbi_nonce'];

	if ( ! wp_verify_nonce( $nonce, 'sbi_nonce' ) ) {
		die ( 'You did not do this the right way!' );
	}
	$access_token = isset( $_POST['access_token'] ) ? sanitize_text_field( $_POST['access_token'] ) : false;
	$options = get_option( 'sb_instagram_settings', array() );
	$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();

	if ( $access_token ) {
		wp_cache_delete ( 'alloptions', 'options' );

		$split_token = explode( '.', $access_token );
		$new_user_id = isset( $split_token[0] ) ? $split_token[0] : '';

		unset( $connected_accounts[ $new_user_id ] );

		$options['connected_accounts'] = $connected_accounts;

		update_option( 'sb_instagram_settings', $options );

	}

	die();
}
add_action( 'wp_ajax_sbi_delete_account', 'sbi_delete_account' );

function sbi_account_data_for_token( $access_token ) {
	$return = array(
		'id' => false,
		'username' => false,
		'is_valid' => false,
		'last_checked' => time()
	);
	$url = 'https://api.instagram.com/v1/users/self/?access_token=' . sbi_maybe_clean( $access_token );
	$args = array(
		'timeout' => 60,
		'sslverify' => false
	);
	$result = wp_remote_get( $url, $args );

	if ( ! is_wp_error( $result ) ) {
		$data = json_decode( $result['body'] );
	} else {
		$data = array();
	}

	if ( isset( $data->data->id ) ) {
		$return['id'] = $data->data->id;
		$return['username'] = $data->data->username;
		$return['is_valid'] = true;
		$return['profile_picture'] = $data->data->profile_picture;

	} elseif ( isset( $data->error_type ) && $data->error_type === 'OAuthRateLimitException' ) {
		$return['error_message'] = 'This account\'s access token is currently over the rate limit. Try removing this access token from all feeds and wait an hour before reconnecting.';
	} else {
		$return = false;

	}

	return $return;
}

function sbi_get_connected_accounts_data( $sb_instagram_at ) {
	$sbi_options = get_option( 'sb_instagram_settings' );
	$return = array();
	$return['connected_accounts'] = isset( $sbi_options['connected_accounts'] ) ? $sbi_options['connected_accounts'] : array();

	if ( empty( $connected_accounts ) && ! empty( $sb_instagram_at ) ) {
		$tokens = explode(',', $sb_instagram_at );
		$user_ids = array();

		foreach ( $tokens as $token ) {
			$account = sbi_account_data_for_token( $token );
			if ( isset( $account['is_valid'] ) ) {
				$split = explode( '.', $token );
				$return['connected_accounts'][ $split[0] ] = array(
					'access_token' => sbi_get_parts( $token ),
					'user_id' => $split[0],
					'username' => '',
					'is_valid' => true,
					'last_checked' => time(),
					'profile_picture' => ''
				);
				$user_ids[] = $split[0];
			}

		}

		$sbi_options['connected_accounts'] = $return['connected_accounts'];
		$sbi_options['sb_instagram_at'] = '';
		$sbi_options['sb_instagram_user_id'] = $user_ids;

		$return['user_ids'] = $user_ids;

		update_option( 'sb_instagram_settings', $sbi_options );
	}

	return $return;
}

function sbi_expiration_notice(){

	//If the user is re-checking the license key then use the API below to recheck it
	( isset( $_GET['sbichecklicense'] ) ) ? $sbi_check_license = true : $sbi_check_license = false;

	$sbi_license = trim( get_option( 'sbi_license_key' ) );

	//If there's no license key then don't do anything
	if( empty($sbi_license) || !isset($sbi_license) && !$sbi_check_license ) return;

	//Is there already license data in the db?
	if( get_option( 'sbi_license_data' ) && !$sbi_check_license ){
		//Yes
		//Get license data from the db and convert the object to an array
		$sbi_license_data = (array) get_option( 'sbi_license_data' );
	} else {
		//No
		// data to send in our API request
		$sbi_api_params = array(
			'edd_action'=> 'check_license',
			'license'   => $sbi_license,
			'item_name' => urlencode( SBI_PLUGIN_NAME ) // the name of our product in EDD
		);

		// Call the custom API.
		$sbi_response = wp_remote_get( add_query_arg( $sbi_api_params, SBI_STORE_URL ), array( 'timeout' => 60, 'sslverify' => false ) );

		// decode the license data
		$sbi_license_data = (array) json_decode( wp_remote_retrieve_body( $sbi_response ) );

		//Store license data in db
		update_option( 'sbi_license_data', $sbi_license_data );
	}

	//Number of days until license expires
	$sbi_date1 = isset( $sbi_license_data['expires'] ) ? $sbi_license_data['expires'] : $sbi_date1 = '2036-12-31 23:59:59'; //If expires param isn't set yet then set it to be a date to avoid PHP notice
	if( $sbi_date1 == 'lifetime' ) $sbi_date1 = '2036-12-31 23:59:59';
	$sbi_date2 = date('Y-m-d');
	$sbi_interval = round(abs(strtotime($sbi_date2)-strtotime($sbi_date1))/86400);

	//Is license expired?
	( $sbi_interval == 0 || strtotime($sbi_date1) < strtotime($sbi_date2) ) ? $sbi_license_expired = true : $sbi_license_expired = false;

	//If expired date is returned as 1970 (or any other 20th century year) then it means that the correct expired date was not returned and so don't show the renewal notice
	if( $sbi_date1[0] == '1' ) $sbi_license_expired = false;

	//If there's no expired date then don't show the expired notification
	if( empty($sbi_date1) || !isset($sbi_date1) ) $sbi_license_expired = false;

	//Is license missing - ie. on very first check
	if( isset($sbi_license_data['error']) ){
		if( $sbi_license_data['error'] == 'missing' ) $sbi_license_expired = false;
	}

	//If license expires in less than 30 days and it isn't currently expired then show the expire countdown instead of the expiration notice
	if($sbi_interval < 30 && !$sbi_license_expired){
		$sbi_expire_countdown = true;
	} else {
		$sbi_expire_countdown = false;
	}

	global $sbi_download_id;

	//Is the license expired?
	if( ($sbi_license_expired || $sbi_expire_countdown) || $sbi_check_license ) {

		//If expire countdown then add the countdown class to the notice box
		if($sbi_expire_countdown){
			$sbi_expired_box_classes = "sbi-license-expired sbi-license-countdown";
			$sbi_expired_box_msg = "Hey ".$sbi_license_data["customer_name"].", your Instagram Feed Pro license key expires in " . $sbi_interval . " days.";
		} else {
			$sbi_expired_box_classes = "sbi-license-expired";
			$sbi_expired_box_msg = "Hey ".$sbi_license_data["customer_name"].", your Instagram Feed Pro license key has expired.";
		}

		//Create the re-check link using the existing query string in the URL
		$sbi_url = '?' . $_SERVER["QUERY_STRING"];
		//Determine the separator
		( !empty($sbi_url) && $sbi_url != '' ) ? $separator = '&' : $separator = '';
		//Add the param to check license if it doesn't already exist in URL
		if( strpos($sbi_url, 'sbichecklicense') === false ) $sbi_url .= $separator . "sbichecklicense=true";

		//Create the notice message
		$sbi_expired_box_msg .= " Click <a href='https://smashballoon.com/checkout/?edd_license_key=".$sbi_license."&download_id=".$sbi_download_id."' target='_blank'>here</a> to renew your license. <a href='javascript:void(0);' id='sbi-why-renew-show' onclick='sbiShowReasons()'>Why renew?</a><a href='javascript:void(0);' id='sbi-why-renew-hide' onclick='sbiHideReasons()' style='display: none;'>Hide text</a> <a href='".$sbi_url."' class='sbi-button'>Re-check License</a></p>
            <div id='sbi-why-renew' style='display: none;'>
                <h4>Customer Support</h4>
                <p>Without a valid license key you will no longer be able to receive updates or support for the Instagram Feed plugin. A renewed license key grants you access to our top-notch, quick and effective support for another full year.</p>

                <h4>Maintenance Upates</h4>
                <p>With both WordPress and the Instagram API being updated on a regular basis we stay on top of the latest changes and provide frequent updates to keep pace.</p>

                <h4>New Feature Updates</h4>
                <p>We're continually adding new features to the plugin, based on both customer suggestions and our own ideas for ways to make it better, more useful, more customizable, more robust and just more awesome! Renew your license to prevent from missing out on any of the new features added in the future.</p>
            </div>";

		if( $sbi_check_license && !$sbi_license_expired && !$sbi_expire_countdown ){
			$sbi_expired_box_classes = "sbi-license-expired sbi-license-valid";
			$sbi_expired_box_msg = "Thanks ".$sbi_license_data["customer_name"].", your Instagram Feed Pro license key is valid.";
		}

		_e("
        <div class='".$sbi_expired_box_classes."'>
            <p>".$sbi_expired_box_msg." 
        </div>
        <script type='text/javascript'>
        function sbiShowReasons() {
            document.getElementById('sbi-why-renew').style.display = 'block';
            document.getElementById('sbi-why-renew-show').style.display = 'none';
            document.getElementById('sbi-why-renew-hide').style.display = 'inline';
        }
        function sbiHideReasons() {
            document.getElementById('sbi-why-renew').style.display = 'none';
            document.getElementById('sbi-why-renew-show').style.display = 'inline';
            document.getElementById('sbi-why-renew-hide').style.display = 'none';
        }
        </script>
        ");
	}

}


/* Display a license expired notice that can be dismissed */
add_action('admin_notices', 'sbi_renew_license_notice');
function sbi_renew_license_notice() {

	//Show this notice on every page apart from the Instagram Feed settings pages
	isset($_GET['page'])? $sbi_check_page = $_GET['page'] : $sbi_check_page = '';
	if ( $sbi_check_page !== 'sb-instagram-feed' && $sbi_check_page !== 'sb-instagram-license' ) {

		//If the user is re-checking the license key then use the API below to recheck it
		( isset( $_GET['sbichecklicense'] ) ) ? $sbi_check_license = true : $sbi_check_license = false;

		$sbi_license = trim( get_option( 'sbi_license_key' ) );

		global $current_user;
		$user_id = $current_user->ID;

		// Use this to show notice again
		//delete_user_meta($user_id, 'sbi_ignore_notice');

		/* Check that the license exists and the user hasn't already clicked to ignore the message */
		if( empty($sbi_license) || !isset($sbi_license) || get_user_meta($user_id, 'sbi_ignore_notice') && !$sbi_check_license ) return;

		//Is there already license data in the db?
		if( get_option( 'sbi_license_data' ) && !$sbi_check_license ){
			//Yes
			//Get license data from the db and convert the object to an array
			$sbi_license_data = (array) get_option( 'sbi_license_data' );
		} else {
			//No
			// data to send in our API request
			$sbi_api_params = array(
				'edd_action'=> 'check_license',
				'license'   => $sbi_license,
				'item_name' => urlencode( SBI_PLUGIN_NAME ) // the name of our product in EDD
			);

			// Call the custom API.
			$sbi_response = wp_remote_get( add_query_arg( $sbi_api_params, SBI_STORE_URL ), array( 'timeout' => 60, 'sslverify' => false ) );

			// decode the license data
			$sbi_license_data = (array) json_decode( wp_remote_retrieve_body( $sbi_response ) );

			//Store license data in db
			update_option( 'sbi_license_data', $sbi_license_data );

		}

		//Number of days until license expires
		$sbi_date1 = $sbi_license_data['expires'];
		if( $sbi_date1 == 'lifetime' ) $sbi_date1 = '2036-12-31 23:59:59';
		$sbi_date2 = date('Y-m-d');
		$sbi_interval = round(abs(strtotime($sbi_date2)-strtotime($sbi_date1))/86400);

		//Is license expired?
		( $sbi_interval == 0 || strtotime($sbi_date1) < strtotime($sbi_date2) ) ? $sbi_license_expired = true : $sbi_license_expired = false;

		//If expired date is returned as 1970 (or any other 20th century year) then it means that the correct expired date was not returned and so don't show the renewal notice
		if( $sbi_date1[0] == '1' ) $sbi_license_expired = false;

		//If there's no expired date then don't show the expired notification
		if( empty($sbi_date1) || !isset($sbi_date1) ) $sbi_license_expired = false;

		//Is license missing - ie. on very first check
		if( isset($sbi_license_data['error']) ){
			if( $sbi_license_data['error'] == 'missing' ) $sbi_license_expired = false;
		}

		//If license expires in less than 30 days and it isn't currently expired then show the expire countdown instead of the expiration notice
		if($sbi_interval < 30 && !$sbi_license_expired){
			$sbi_expire_countdown = true;
		} else {
			$sbi_expire_countdown = false;
		}


		//Is the license expired?
		if( ($sbi_license_expired || $sbi_expire_countdown) || $sbi_check_license ) {

			global $sbi_download_id;

			//If expire countdown then add the countdown class to the notice box
			if($sbi_expire_countdown){
				$sbi_expired_box_classes = "sbi-license-expired sbi-license-countdown";
				$sbi_expired_box_msg = "Hey ".$sbi_license_data["customer_name"].", your Instagram Feed Pro license key expires in " . $sbi_interval . " days.";
			} else {
				$sbi_expired_box_classes = "sbi-license-expired";
				$sbi_expired_box_msg = "Hey ".$sbi_license_data["customer_name"].", your Instagram Feed Pro license key has expired.";
			}

			//Create the re-check link using the existing query string in the URL
			$sbi_url = '?' . $_SERVER["QUERY_STRING"];
			//Determine the separator
			( !empty($sbi_url) && $sbi_url != '' ) ? $separator = '&' : $separator = '';
			//Add the param to check license if it doesn't already exist in URL
			if( strpos($sbi_url, 'sbichecklicense') === false ) $sbi_url .= $separator . "sbichecklicense=true";

			//Create the notice message
			$sbi_expired_box_msg .= " Click <a href='https://smashballoon.com/checkout/?edd_license_key=".$sbi_license."&download_id=".$sbi_download_id."' target='_blank'>here</a> to renew your license. <a href='javascript:void(0);' id='sbi-why-renew-show' onclick='sbiShowReasons()'>Why renew?</a><a href='javascript:void(0);' id='sbi-why-renew-hide' onclick='sbiHideReasons()' style='display: none;'>Hide text</a> <a href='".$sbi_url."' class='sbi-button'>Re-check License</a></p>
                <div id='sbi-why-renew' style='display: none;'>
                    <h4>Customer Support</h4>
                    <p>Without a valid license key you will no longer be able to receive updates or support for the Instagram Feed plugin. A renewed license key grants you access to our top-notch, quick and effective support for another full year.</p>

                    <h4>Maintenance Upates</h4>
                    <p>With both WordPress and the Instagram API being updated on a regular basis we stay on top of the latest changes and provide frequent updates to keep pace.</p>

                    <h4>New Feature Updates</h4>
                    <p>We're continually adding new features to the plugin, based on both customer suggestions and our own ideas for ways to make it better, more useful, more customizable, more robust and just more awesome! Renew your license to prevent from missing out on any of the new features added in the future.</p>
                </div>";

			if( $sbi_check_license && !$sbi_license_expired && !$sbi_expire_countdown ){
				$sbi_expired_box_classes = "sbi-license-expired sbi-license-valid";
				$sbi_expired_box_msg = "Thanks ".$sbi_license_data["customer_name"].", your Instagram Feed Pro license key is valid.";
			}

			_e("
            <div class='".$sbi_expired_box_classes."'>
                <a style='float:right; color: #dd3d36; text-decoration: none;' href='" .esc_url( add_query_arg( 'sbi_nag_ignore', '0' ) ). "'>Dismiss</a>
                <p>".$sbi_expired_box_msg." 
            </div>
            <script type='text/javascript'>
            function sbiShowReasons() {
                document.getElementById('sbi-why-renew').style.display = 'block';
                document.getElementById('sbi-why-renew-show').style.display = 'none';
                document.getElementById('sbi-why-renew-hide').style.display = 'inline';
            }
            function sbiHideReasons() {
                document.getElementById('sbi-why-renew').style.display = 'none';
                document.getElementById('sbi-why-renew-show').style.display = 'inline';
                document.getElementById('sbi-why-renew-hide').style.display = 'none';
            }
            </script>
            ");
		}

	}
}
add_action('admin_init', 'sbi_nag_ignore');
function sbi_nag_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	if ( isset($_GET['sbi_nag_ignore']) && '0' == $_GET['sbi_nag_ignore'] ) {
		add_user_meta($user_id, 'sbi_ignore_notice', 'true', true);
	}
}

function sb_instagram_clear_page_caches() {
	if ( isset( $GLOBALS['wp_fastest_cache'] ) && method_exists( $GLOBALS['wp_fastest_cache'], 'deleteCache' ) ){
		/* Clear WP fastest cache*/
		$GLOBALS['wp_fastest_cache']->deleteCache();
	}

	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
	}

	if ( class_exists('W3_Plugin_TotalCacheAdmin') ) {
		$plugin_totalcacheadmin = & w3_instance('W3_Plugin_TotalCacheAdmin');

		$plugin_totalcacheadmin->flush_all();
	}

	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}

	if ( class_exists( 'autoptimizeCache' ) ) {
		/* Clear autoptimize */
		autoptimizeCache::clearall();
	}
}
//Cron job to clear transients
add_action('sb_instagram_cron_job', 'sb_instagram_cron_clear_cache');
function sb_instagram_cron_clear_cache() {
	//Delete all transients
	global $wpdb;
	$table_name = $wpdb->prefix . "options";
	$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_sbi\_%')
        " );
	$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_timeout\_sbi\_%')
        " );
	$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_&sbi\_%')
        " );
	$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%\_transient\_timeout\_&sbi\_%')
        " );

	sb_instagram_clear_page_caches();
}

//New API deprecation notice
add_action('admin_notices', 'sbi_important_notice');
function sbi_important_notice() {

    global $current_user;
    $user_id = $current_user->ID;

    if( current_user_can( 'manage_options' ) ){

        // Use these to show notice again for testing
        // delete_option('sbi_seen_important_notice');

        if( get_option('sbi_seen_important_notice') ) return;

        _e("<div class='sbi_important_notice sb_instagram_notice'>
            <a style='float:right; color: #dd3d36; text-decoration: none;' href='" .esc_url( add_query_arg( 'sbi_ignore_important_notice', '0' ) ). "'><i class='fa fa-times'></i> Dismiss</a>
            <p><i class='fa fa-instagram'></i> &nbsp;<b>Important:</b> Upcoming changes in the Instagram platform will disrupt Location feeds, Single Post feeds, and Hashtag feeds. Please <a href='https://smashballoon.com/instagram-api-changes-dec-11-2018/' target='_blank'>see here</a> for more information.</p> 
        </div>");
    }
}
add_action('admin_init', 'sbi_important_notice_ignore');
function sbi_important_notice_ignore() {
    if ( isset($_GET['sbi_ignore_important_notice']) && '0' == $_GET['sbi_ignore_important_notice']) {
        update_option('sbi_seen_important_notice', true);
    }
}


?>