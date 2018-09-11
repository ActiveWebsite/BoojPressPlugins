<?php

require_once 'SettingsHelper.php';
require_once 'popular_posts.php';
require_once 'you_may_also_like_posts.php';
/**
 * @description WpBooj options page.
 */
function wpbooj_settings_init() {
    // Register the configured sections and fields.
    SettingsHelper::registerSections();
}

/**
 * register our wpbooj_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'wpbooj_settings_init' );

/**
 * custom option and settings:
 * callback functions
 */


/**
 * top level menu
 */
function wpbooj_options_page() {
    // add top level menu page
    add_menu_page(
        'Booj Options',
        'Booj Options',
        'manage_options',
        'wpbooj_options',
        'wpbooj_options_page_html'
    );
}

/**
 * register our wpbooj_options_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'wpbooj_options_page' );

/**
 * top level menu:
 * callback functions
 */
function wpbooj_options_page_html() {
    // check user capabilities
//    if ( ! current_user_can( 'manage_options' ) ) {
//        return;
//    }

    // add error/update messages

    // check if the user have submitted the settings
    // wordpress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'wpbooj_messages', 'wpbooj_message', __( 'Settings Saved', 'wpbooj_options' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'wpbooj_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wpbooj"
            settings_fields( 'wpbooj_options' );
            // output setting sections and their fields
            // (sections are registered for "wpbooj", each field is registered to a specific section)
            do_settings_sections( 'wpbooj_options' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}