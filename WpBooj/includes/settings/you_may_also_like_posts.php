<?php
function wpbooj_ymal_posts_cb( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( "Configure the 'You May Also Like' Posts display" ); ?></p>
    <?php
}

function wpbooj_field_ymal_orderby_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'wpbooj_ymal_orderby' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['wpbooj_custom_data'] ); ?>"
            name="wpbooj_ymal_orderby"
    >
        <option value="views" <?php echo isset( $options ) ? ( selected( $options, 'views', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'Views', 'wpbooj_options' ); ?>
        </option>
        <option value="date" <?php echo isset( $options ) ? ( selected( $options, 'date', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'Post Date', 'wpbooj_options' ); ?>
        </option>
        <option value="related" <?php echo isset( $options ) ? ( selected( $options, 'related', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'Related Score', 'wpbooj_options' ); ?>
        </option>
    </select>
    <?php
}


function wpbooj_field_ymal_order_cb( $args ) {
    // get the value of the setting we've registered with register_setting()
    $options = get_option( 'wpbooj_ymal_order' );
    // output the field
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            data-custom="<?php echo esc_attr( $args['wpbooj_custom_data'] ); ?>"
            name="wpbooj_ymal_order"
    >
        <option value="asc" <?php echo isset( $options ) ? ( selected( $options, 'asc', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'Ascending', 'wpbooj_options' ); ?>
        </option>
        <option value="desc" <?php echo isset( $options ) ? ( selected( $options, 'desc', false ) ) : ( '' ); ?>>
            <?php esc_html_e( 'Descending', 'wpbooj_options' ); ?>
        </option>
    </select>
    <?php
}