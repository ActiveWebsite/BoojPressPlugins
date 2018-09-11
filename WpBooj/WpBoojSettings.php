<?php

require_once 'SettingsHelper.php';
/**
 * @description WpBooj options page.
 */
function wpbooj_settings_init() {
    // Register the configured sections.
    SettingsHelper::registerSections();


    // register a new field in the "wpbooj_section_developers" section, inside the "wpbooj" page
    add_settings_field(
        'wpbooj_field_popular_order', // as of WP 4.6 this value is used only internally
        // use $args' label_for to populate the id inside the callback
        __( 'Popular Order', 'wpbooj' ),
        'wpbooj_field_popular_order_cb',
        'wpbooj',
        'wpbooj_section_client_settings',
        array (
            'label_for' => 'wpbooj_field_popular_order',
            'class' => 'wpbooj_row',
            'wpbooj_custom_data' => 'custom',
        )
    );
}

/**
 * register our wpbooj_settings_init to the admin_init action hook
 */
add_action( 'admin_init', 'wpbooj_settings_init' );

/**
 * custom option and settings:
 * callback functions
 */

// developers section cb

// section callbacks can accept an $args parameter, which is an array.
// $args have the following keys defined: title, id, callback.
// the values are defined at the add_settings_section() function.
function wpbooj_section_developers_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'wpbooj' ); ?></p>
    <?php
}

// pill field cb

// field callbacks can accept an $args parameter, which is an array.
// $args is defined at the add_settings_field() function.
// wordpress has magic interaction with the following keys: label_for, class.
// the "label_for" key value is used for the "for" attribute of the <label>.
// the "class" key value is used for the "class" attribute of the <tr> containing the field.
// you can add custom key value pairs to be used inside your callbacks.
function wpbooj_field_popular_order_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'wpbooj_options' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['wpbooj_custom_data'] ); ?>"
            name="wpbooj_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
    >
        <option value="red" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'red', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'red pill', 'wpbooj' ); ?>
        </option>
        <option value="blue" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'blue', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'blue pill', 'wpbooj' ); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e( 'You take the blue pill and the story ends. You wake in your bed and you believe whatever you want to believe.', 'wpbooj' ); ?>
    </p>
    <p class="description">
        <?php esc_html_e( 'You take the red pill and you stay in Wonderland and I show you how deep the rabbit-hole goes.', 'wpbooj' ); ?>
    </p>
    <?php
}

/**
 * top level menu
 */
function wpbooj_options_page() {
    // add top level menu page
    add_menu_page(
        'WpBooj',
        'WpBooj Options',
        'manage_options',
        'wpbooj',
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
        add_settings_error( 'wpbooj_messages', 'wpbooj_message', __( 'Settings Saved', 'wpbooj' ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'wpbooj_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            // output security fields for the registered setting "wpbooj"
            settings_fields( 'wpbooj' );
            // output setting sections and their fields
            // (sections are registered for "wpbooj", each field is registered to a specific section)
            do_settings_sections( 'wpbooj' );
            // output save settings button
            submit_button( 'Save Settings' );
            ?>
        </form>
    </div>
    <?php
}