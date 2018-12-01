<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Include the widget
require_once( dirname( __FILE__ ) . '/widget.php' );

//Include admin
include dirname( __FILE__ ) .'/instagram-feed-admin.php';

// Add shortcodes
add_shortcode('instagram-feed', 'display_sb_instagram_feed');
function display_sb_instagram_feed($atts, $content = null) {

	$options = get_option('sb_instagram_settings');
	// enqueue js files if ajax theme not selected
	isset($options[ 'sb_instagram_ajax_theme' ]) ? $sb_instagram_ajax_theme = trim($options['sb_instagram_ajax_theme']) : $sb_instagram_ajax_theme = '';
	( $sb_instagram_ajax_theme == 'on' || $sb_instagram_ajax_theme == 'true' || $sb_instagram_ajax_theme == true ) ? $sb_instagram_ajax_theme = true : $sb_instagram_ajax_theme = false;

	//Enqueue it to load it onto the page
	if( !$sb_instagram_ajax_theme ) wp_enqueue_script('sb_instagram_scripts');


	// enqueue css file if not loaded on the page
	wp_enqueue_style( 'sb_instagram_styles' );

	$sb_instagram_settings = get_option('sb_instagram_settings');

	/******************* SHORTCODE OPTIONS ********************/


    //Create the includes string to set as shortcode default
    $hover_include_string = '';
    if( isset($options[ 'sbi_hover_inc_username' ]) ){
        ($options[ 'sbi_hover_inc_username' ] && $options[ 'sbi_hover_inc_username' ] !== '') ? $hover_include_string .= 'username,' : $hover_include_string .= '';
    }
    //If the username option doesn't exist in the database yet (eg: on plugin update) then set it to be displayed
    if ( !array_key_exists( 'sbi_hover_inc_username', $options ) ) $hover_include_string .= 'username,';

    if( isset($options[ 'sbi_hover_inc_icon' ]) ){
        ($options[ 'sbi_hover_inc_icon' ] && $options[ 'sbi_hover_inc_icon' ] !== '') ? $hover_include_string .= 'icon,' : $hover_include_string .= '';
    }
    if ( !array_key_exists( 'sbi_hover_inc_icon', $options ) ) $hover_include_string .= 'icon,';

    if( isset($options[ 'sbi_hover_inc_date' ]) ){
        ($options[ 'sbi_hover_inc_date' ] && $options[ 'sbi_hover_inc_date' ] !== '') ? $hover_include_string .= 'date,' : $hover_include_string .= '';
    }
    if ( !array_key_exists( 'sbi_hover_inc_date', $options ) ) $hover_include_string .= 'date,';

    if( isset($options[ 'sbi_hover_inc_instagram' ]) ){
        ($options[ 'sbi_hover_inc_instagram' ] && $options[ 'sbi_hover_inc_instagram' ] !== '') ? $hover_include_string .= 'instagram,' : $hover_include_string .= '';
    }
    if ( !array_key_exists( 'sbi_hover_inc_instagram', $options ) ) $hover_include_string .= 'instagram,';

    if( isset($options[ 'sbi_hover_inc_location' ]) ){
        ($options[ 'sbi_hover_inc_location' ] && $options[ 'sbi_hover_inc_location' ] !== '') ? $hover_include_string .= 'location,' : $hover_include_string .= '';
    }
    if( isset($options[ 'sbi_hover_inc_caption' ]) ){
        ($options[ 'sbi_hover_inc_caption' ] && $options[ 'sbi_hover_inc_caption' ] !== '') ? $hover_include_string .= 'caption,' : $hover_include_string .= '';
    }
    if( isset($options[ 'sbi_hover_inc_likes' ]) ){
        ($options[ 'sbi_hover_inc_likes' ] && $options[ 'sbi_hover_inc_likes' ] !== '') ? $hover_include_string .= 'likes,' : $hover_include_string .= '';
    }
    if ( isset( $options[ 'sb_instagram_incex_one_all' ] ) ) {
    	if ( $options[ 'sb_instagram_incex_one_all' ]  == 'one' ) {
		    $options[ 'sb_instagram_include_words' ] = '';
		    $options[ 'sb_instagram_exclude_words' ] = '';
	    }
    }

    $shortcode_atts_raw = $atts;
    
    //Pass in shortcode attrbutes
    $atts = shortcode_atts(
    array(
	    'type' => isset($options[ 'sb_instagram_type' ]) ? $options[ 'sb_instagram_type' ] : '',
        'id' => isset($options[ 'sb_instagram_user_id' ]) ? $options[ 'sb_instagram_user_id' ] : '',
        'hashtag' => isset($options[ 'sb_instagram_hashtag' ]) ? $options[ 'sb_instagram_hashtag' ] : '',
        'location' => isset($options[ 'sb_instagram_location' ]) ? $options[ 'sb_instagram_location' ] : '',
        'coordinates' => isset($options[ 'sb_instagram_coordinates' ]) ? $options[ 'sb_instagram_coordinates' ] : '',
	    'single' => '',
        'width' => isset($options[ 'sb_instagram_width' ]) ? $options[ 'sb_instagram_width' ] : '',
        'widthunit' => isset($options[ 'sb_instagram_width_unit' ]) ? $options[ 'sb_instagram_width_unit' ] : '',
        'widthresp' => isset($options[ 'sb_instagram_feed_width_resp' ]) ? $options[ 'sb_instagram_feed_width_resp' ] : '',
        'height' => isset($options[ 'sb_instagram_height' ]) ? $options[ 'sb_instagram_height' ] : '',
        'heightunit' => isset($options[ 'sb_instagram_height_unit' ]) ? $options[ 'sb_instagram_height_unit' ] : '',
        'sortby' => isset($options[ 'sb_instagram_sort' ]) ? $options[ 'sb_instagram_sort' ] : '',
        'disablelightbox' => isset($options[ 'sb_instagram_disable_lightbox' ]) ? $options[ 'sb_instagram_disable_lightbox' ] : '',
        'captionlinks' => isset($options[ 'sb_instagram_captionlinks' ]) ? $options[ 'sb_instagram_captionlinks' ] : '',
        'num' => isset($options[ 'sb_instagram_num' ]) ? $options[ 'sb_instagram_num' ] : '',
        'nummobile' => isset($options[ 'sb_instagram_nummobile' ]) ? $options[ 'sb_instagram_nummobile' ] : '',
        'cols' => isset($options[ 'sb_instagram_cols' ]) ? $options[ 'sb_instagram_cols' ] : '',
        'colsmobile' => isset($options[ 'sb_instagram_colsmobile' ]) ? $options[ 'sb_instagram_colsmobile' ] : '',
		'disablemobile' => isset($options[ 'sb_instagram_disable_mobile' ]) ? $options[ 'sb_instagram_disable_mobile' ] : '',
        'imagepadding' => isset($options[ 'sb_instagram_image_padding' ]) ? $options[ 'sb_instagram_image_padding' ] : '',
        'imagepaddingunit' => isset($options[ 'sb_instagram_image_padding_unit' ]) ? $options[ 'sb_instagram_image_padding_unit' ] : '',
		'layout' => isset($options[ 'sb_instagram_layout_type' ]) ? $options[ 'sb_instagram_layout_type' ] : 'grid',
	    //Lightbox Comments
        'lightboxcomments' => isset($options[ 'sb_instagram_lightbox_comments' ]) ? $options[ 'sb_instagram_lightbox_comments' ] : '',
        'numcomments' => isset($options[ 'sb_instagram_num_comments' ]) ? $options[ 'sb_instagram_num_comments' ] : '',

	    //Photo hover styles
        'hovereffect' => isset($options[ 'sb_instagram_hover_effect' ]) ? $options[ 'sb_instagram_hover_effect' ] : '',
        'hovercolor' => isset($options[ 'sb_hover_background' ]) ? $options[ 'sb_hover_background' ] : '',
        'hovertextcolor' => isset($options[ 'sb_hover_text' ]) ? $options[ 'sb_hover_text' ] : '',
        'hoverdisplay' => $hover_include_string,

        'background' => isset($options[ 'sb_instagram_background' ]) ? $options[ 'sb_instagram_background' ] : '',
        'showbutton' => isset($options[ 'sb_instagram_show_btn' ]) ? $options[ 'sb_instagram_show_btn' ] : '',
        'buttoncolor' => isset($options[ 'sb_instagram_btn_background' ]) ? $options[ 'sb_instagram_btn_background' ] : '',
        'buttontextcolor' => isset($options[ 'sb_instagram_btn_text_color' ]) ? $options[ 'sb_instagram_btn_text_color' ] : '',
        'buttontext' => isset($options[ 'sb_instagram_btn_text' ]) ? stripslashes( esc_attr( $options[ 'sb_instagram_btn_text' ] ) ) : '',
        'imageres' => isset($options[ 'sb_instagram_image_res' ]) ? $options[ 'sb_instagram_image_res' ] : '',
        'media' => isset($options[ 'sb_instagram_media_type' ]) ? $options[ 'sb_instagram_media_type' ] : '',
        'showcaption' => isset($options[ 'sb_instagram_show_caption' ]) ? $options[ 'sb_instagram_show_caption' ] : '',
        'captionlength' => isset($options[ 'sb_instagram_caption_length' ]) ? $options[ 'sb_instagram_caption_length' ] : '',
        'captioncolor' => isset($options[ 'sb_instagram_caption_color' ]) ? $options[ 'sb_instagram_caption_color' ] : '',
        'captionsize' => isset($options[ 'sb_instagram_caption_size' ]) ? $options[ 'sb_instagram_caption_size' ] : '',
        'showlikes' => isset($options[ 'sb_instagram_show_meta' ]) ? $options[ 'sb_instagram_show_meta' ] : '',
        'likescolor' => isset($options[ 'sb_instagram_meta_color' ]) ? $options[ 'sb_instagram_meta_color' ] : '',
        'likessize' => isset($options[ 'sb_instagram_meta_size' ]) ? $options[ 'sb_instagram_meta_size' ] : '',
        'hidephotos' => isset($options[ 'sb_instagram_hide_photos' ]) ? $options[ 'sb_instagram_hide_photos' ] : '',

        'showfollow' => isset($options[ 'sb_instagram_show_follow_btn' ]) ? $options[ 'sb_instagram_show_follow_btn' ] : '',
        'followcolor' => isset($options[ 'sb_instagram_folow_btn_background' ]) ? $options[ 'sb_instagram_folow_btn_background' ] : '',
        'followtextcolor' => isset($options[ 'sb_instagram_follow_btn_text_color' ]) ? $options[ 'sb_instagram_follow_btn_text_color' ] : '',
        'followtext' => isset($options[ 'sb_instagram_follow_btn_text' ]) ? stripslashes( esc_attr( $options[ 'sb_instagram_follow_btn_text' ] ) ) : '',
        //Header
        'showheader' => isset($options[ 'sb_instagram_show_header' ]) ? $options[ 'sb_instagram_show_header' ] : '',
        'headercolor' => isset($options[ 'sb_instagram_header_color' ]) ? $options[ 'sb_instagram_header_color' ] : '',
        'headerstyle' => isset($options[ 'sb_instagram_header_style' ]) ? $options[ 'sb_instagram_header_style' ] : '',
        'showfollowers' => isset($options[ 'sb_instagram_show_followers' ]) ? $options[ 'sb_instagram_show_followers' ] : '',
        'showbio' => isset($options[ 'sb_instagram_show_bio' ]) ? $options[ 'sb_instagram_show_bio' ] : '',
        'headerprimarycolor' => isset($options[ 'sb_instagram_header_primary_color' ]) ? $options[ 'sb_instagram_header_primary_color' ] : '',
        'headersecondarycolor' => isset($options[ 'sb_instagram_header_secondary_color' ]) ? $options[ 'sb_instagram_header_secondary_color' ] : '',
	    'headersize' => isset($options[ 'sb_instagram_header_size' ]) ? $options[ 'sb_instagram_header_size' ] : '',

        'class' => '',
        'ajaxtheme' => isset($options[ 'sb_instagram_ajax_theme' ]) ? $options[ 'sb_instagram_ajax_theme' ] : '',
        'cachetime' => isset($options[ 'sb_instagram_cache_time' ]) ? $options[ 'sb_instagram_cache_time' ] : '',
        'blockusers' => isset($options[ 'sb_instagram_block_users' ]) ? $options[ 'sb_instagram_block_users' ] : '',
        'showusers' => isset($options[ 'sb_instagram_show_users' ]) ? $options[ 'sb_instagram_show_users' ] : '',
        'excludewords' => isset($options[ 'sb_instagram_exclude_words' ]) ? $options[ 'sb_instagram_exclude_words' ] : '',
        'includewords' => isset($options[ 'sb_instagram_include_words' ]) ? $options[ 'sb_instagram_include_words' ] : '',
        'maxrequests' => isset($options[ 'sb_instagram_requests_max' ]) ? $options[ 'sb_instagram_requests_max' ] : '',

        //Carousel
        'carousel' => isset($options[ 'sb_instagram_carousel' ]) ? $options[ 'sb_instagram_carousel' ] : '',
        'carouselrows' => isset($options[ 'sb_instagram_carousel_rows' ]) ? $options[ 'sb_instagram_carousel_rows' ] : '',
	    'carouselloop' => isset($options[ 'sb_instagram_carousel_loop' ]) ? $options[ 'sb_instagram_carousel_loop' ] : '',
	    'carouselarrows' => isset($options[ 'sb_instagram_carousel_arrows' ]) ? $options[ 'sb_instagram_carousel_arrows' ] : '',
        'carouselpag' => isset($options[ 'sb_instagram_carousel_pag' ]) ? $options[ 'sb_instagram_carousel_pag' ] : '',
        'carouselautoplay' => isset($options[ 'sb_instagram_carousel_autoplay' ]) ? $options[ 'sb_instagram_carousel_autoplay' ] : '',
        'carouseltime' => isset($options[ 'sb_instagram_carousel_interval' ]) ? $options[ 'sb_instagram_carousel_interval' ] : '',

        //Highlight
	    'highlighttype' => isset($options[ 'sb_instagram_highlight_type' ]) ? $options[ 'sb_instagram_highlight_type' ] : '',
	    'highlightoffset' => isset($options[ 'sb_instagram_highlight_offset' ]) ? $options[ 'sb_instagram_highlight_offset' ] : '',
	    'highlightpattern' => isset($options[ 'sb_instagram_highlight_factor' ]) ? $options[ 'sb_instagram_highlight_factor' ] : '',
	    'highlighthashtag' => isset($options[ 'sb_instagram_highlight_hashtag' ]) ? $options[ 'sb_instagram_highlight_hashtag' ] : '',

	    //WhiteList
        'whitelist' => '',
	    
	    //Load More on Scroll
        'autoscroll' => isset($options[ 'sb_instagram_autoscroll' ]) ? $options[ 'sb_instagram_autoscroll' ] : '',
        'autoscrolldistance' => isset($options[ 'sb_instagram_autoscrolldistance' ]) ? $options[ 'sb_instagram_autoscrolldistance' ] : '',

	    //Moderation Mode
        'moderationmode' => isset($options[ 'sb_instagram_moderation_mode' ]) ? $options[ 'sb_instagram_moderation_mode' ] === 'visual' : '',

	    //Permanent
        'permanent' => isset($options[ 'sb_instagram_permanent' ]) ? $options[ 'sb_instagram_permanent' ] : false,
		'accesstoken' => '',
	    'user' => isset($options[ 'sb_instagram_user' ]) ? $options[ 'sb_instagram_user' ] : false,
    ), $atts);

    /******************* VARS ********************/

    //Config
    $sb_instagram_type = trim($atts['type']);
    $sb_instagram_user_id = is_array( $atts['id'] ) ? implode( ',', $atts['id'] ) : trim($atts['id'], " ,");
	$sb_instagram_users = !empty($atts['user']) ? explode( ',', trim( $atts['user'] ) ) : false;

	// Access Token
	$at_front_string = '';
	$at_middle_string = '';
	$at_back_string = '';

	//$db_access_token = isset( $options['sb_instagram_at'] ) ? trim( $options['sb_instagram_at'] ) : '';
	$existing_shortcode_tokens = ! empty( $atts['accesstoken'] ) ? explode(',', str_replace(' ', '', $atts['accesstoken'] ) ) : '';
	$existing_shortcode_tokens = apply_filters( 'sbi_access_tokens', $existing_shortcode_tokens );

	$usable_tokens = array();
	$all_valid_tokens = array();

	// mixed feed type collect user ids potentially
	$ids_in_use_from_shortcode = array();

	if ( ! empty ( $existing_shortcode_tokens ) ) {
		foreach ( $existing_shortcode_tokens as $existing_shortcode_token ) {
			if ( ! empty( $existing_shortcode_token ) ) {
				$usable_tokens[] =  $existing_shortcode_token;
				$all_valid_tokens[] = $existing_shortcode_tokens;
			}

		}
	}
	if ( ($sb_instagram_type === 'user' || $sb_instagram_type === 'mixed' || $sb_instagram_type === 'single')
	     && $sb_instagram_users !== false
	     && ! empty ( $options[ 'connected_accounts' ] ) ) {
		$singles_users = array();
		if ( ! empty( $shortcode_atts_raw['single'] ) ) {
			$singles_array = explode( ',', str_replace( array( 'sbi_', ' ' ), '', $shortcode_atts_raw['single'] ) );
			foreach ( $singles_array as $single ) {
				$split = explode('_', $single );
				$singles_users[] = isset( $split[1] ) ? $split[1] : '';
			}
		}

		foreach ( $options[ 'connected_accounts' ] as $connected_account ) {
			if ( in_array( $connected_account['username'], $sb_instagram_users ) || in_array( $connected_account['user_id'], $singles_users ) ) {
				$usable_tokens[] = sbi_get_parts( $connected_account['access_token'] );
				$all_valid_tokens[] = sbi_get_parts( $connected_account['access_token'] );
			} elseif ( ! in_array( sbi_get_parts( $connected_account['access_token'] ), $all_valid_tokens ) && ! in_array( sbi_maybe_clean( $connected_account['access_token'] ), $all_valid_tokens ) ) {
				$all_valid_tokens[] = sbi_get_parts( $connected_account['access_token'] );
			}
			if ( $sb_instagram_type === 'mixed' ) {
				$shortcode_users = explode(',', str_replace( ' ', '', $shortcode_atts_raw['user'] ) );
				if ( in_array( $connected_account['username'], $shortcode_users ) ) {
					$ids_in_use_from_shortcode[] = $connected_account['user_id'];
				}
			}
		}

	}
	if ( empty( $usable_tokens ) && ! empty( $options[ 'connected_accounts' ] ) ) {
		$feed_id_array = is_array( $sb_instagram_user_id ) ? $sb_instagram_user_id : explode( ',', $sb_instagram_user_id );
		if ( ! empty( $feed_id_array ) && ! empty( $feed_id_array[0] ) ) {
			foreach ( $options[ 'connected_accounts' ] as $connected_account ) {
				if ( isset( $connected_account['access_token'] ) && in_array( $connected_account['user_id'], $feed_id_array, true ) ) {
					$usable_tokens[] = $connected_account['access_token'];
				} elseif ( isset( $connected_account['access_token'] ) ) {
					if ( ! in_array( sbi_get_parts( $connected_account['access_token'] ), $all_valid_tokens ) && ! in_array( sbi_maybe_clean( $connected_account['access_token'] ), $all_valid_tokens ) ) {
						$all_valid_tokens[] = sbi_get_parts( $connected_account['access_token'] );
					}
				}
			}
		} else {
			foreach ( $options[ 'connected_accounts' ] as $connected_account ) {
				if ( empty( $usable_tokens ) ) {
					$usable_tokens        = array( $connected_account['access_token'] );
					$user_for_token       = explode( '.', $connected_account['access_token'] );
					$sb_instagram_user_id = $user_for_token[0];
				}

				if ( ! in_array( sbi_get_parts( $connected_account['access_token'] ), $all_valid_tokens ) && ! in_array( sbi_maybe_clean( $connected_account['access_token'] ), $all_valid_tokens ) ) {
					$all_valid_tokens[] = sbi_get_parts( $connected_account['access_token'] );
				}
			}
		}

	} elseif ( empty ( $all_valid_tokens ) ) {

		$db_access_tokens = isset( $options['sb_instagram_at'] ) ? explode( ',', trim( $options['sb_instagram_at'] ) ) : array();
		foreach ( $db_access_tokens as $db_access_token ) {
			if ( ! empty( $db_access_token ) ) {
				$usable_tokens[]    = sbi_get_parts( $db_access_token );
				$all_valid_tokens[] = sbi_get_parts( $db_access_token );
			}
		}
	}

	$the_token_array = ! empty( $usable_tokens ) || $sb_instagram_type === 'user' ? $usable_tokens : $all_valid_tokens;
	if ( empty( $the_token_array ) && ! empty( $all_valid_tokens ) && $sb_instagram_type !== 'user' ) {
		$the_token_array = $all_valid_tokens;
	}

	if ( ! empty( $the_token_array ) ) {
		$at_front_string = '&quot;feedID&quot;: &quot;';
		$at_middle_string = '&quot;mid&quot;: &quot;';
		$at_back_string = '&quot;callback&quot;: &quot;';
		$sb_instagram_user_id = '';
		foreach ( $usable_tokens as $token ) {
			$parts = explode('.', $token );
			$sb_instagram_user_id .= $parts[0].',';
			$at_front_string .= $parts[0].',';
			$at_middle_string .= $parts[1].',';
			if ( isset( $parts[3] ) ) {
				$at_back_string .= $parts[2].'.'.$parts[3].',';
			} else {
				$at_back_string .= $parts[2].',';
			}
		}
		$sb_instagram_user_id = substr( $sb_instagram_user_id, 0, -1 );
		$at_front_string = substr( $at_front_string, 0, -1 ) . '&quot;,';
		$at_middle_string = substr( $at_middle_string, 0, -1 ) . '&quot;,';
		$at_back_string = substr( $at_back_string, 0, -1 ) . '&quot;,';
		$access_token = $the_token_array[0];
	}

    $sb_instagram_hashtag = trim(str_replace( '#', '', trim($atts['hashtag']) ), " ,"); //Remove hashtags and trailing commas
    $sb_instagram_location = trim($atts['location'], " ,");
    $sb_instagram_coordinates = trim($atts['coordinates'], " ,");
	$sb_instagram_single = trim($atts['single'], " ,");
	$sb_instagram_lightbox_comments = $atts['lightboxcomments'];
	$sb_instagram_lightbox_com_data_att = ' data-sbi-lb-comments="true"';
	if ( $sb_instagram_lightbox_comments == 'on' || $sb_instagram_lightbox_comments == 'true' ) {
		$sb_instagram_lightbox_comments = 'true';
		$sb_instagram_lightbox_com_data_att = ' data-sbi-lb-comments="true"';
	} else {
		$sb_instagram_lightbox_comments = 'false';
	}

	$sb_instagram_num_comments = max( $atts['numcomments'], 0 );

	//Container styles
    $sb_instagram_width = $atts['width'];
    $sb_instagram_width_unit = $atts['widthunit'];
    $sb_instagram_height = $atts['height'];
    $sb_instagram_height_unit = $atts['heightunit'];
    $sb_instagram_image_padding = $atts['imagepadding'];
    $sb_instagram_image_padding_unit = $atts['imagepaddingunit'];
    $sb_instagram_background = str_replace('#', '', $atts['background']);
    $sb_hover_background = $atts['hovercolor'];
    $sb_hover_text = str_replace('#', '', $atts['hovertextcolor']);

	//Layout
	$layout = $atts['layout'];

	$layout_class = '';
	if ( in_array( $layout, array( 'masonry', 'highlight' ) ) ) {
		$layout_class = ' sbi_'. $layout;
	} elseif ( $layout !== 'carousel' ) {
		$layout = 'grid';
	}

	// create a comma separated string of highlight layout options to be added to sb_instagram_js_options later
	$highlight_string = '';
	if ( $layout === 'highlight' ) {
		$highlight_type = trim( $atts['highlighttype'] );
		$highlight_offset = trim( $atts['highlightoffset'] );
		$highlight_pattern = trim( $atts['highlightpattern'] );
		$highlight_hashtag = str_replace( ',', '|', trim( str_replace( array( '#', ' '), '', $atts['highlighthashtag'] ) ) );
		$highlight_string = $highlight_type .','. $highlight_pattern .','. $highlight_offset .','. $highlight_hashtag;
	}

	// reset a lot of settings so moderation mode looks clean
	$moderation_mode = isset ( $_GET['sbi_moderation_mode'] ) ? sanitize_text_field( $_GET['sbi_moderation_mode'] ) : '';
	if ( current_user_can( 'edit_posts' )
	     && $moderation_mode === 'true' ) {
		$sb_instagram_width = '100';
		$sb_instagram_width_unit = '%';
		$sb_instagram_height = '100';
		$sb_instagram_height_unit = '%';
		$sb_instagram_image_padding = '5';
		$sb_instagram_image_padding_unit = 'px';
		$sb_instagram_background = 'fff';
		$sb_hover_background = $atts['hovercolor'];
		$sb_hover_text = str_replace('#', '', $atts['hovertextcolor']);
	}

    //Set to be 100% width on mobile?
    $sb_instagram_width_resp = $atts[ 'widthresp' ];
    ( $sb_instagram_width_resp == 'on' || $sb_instagram_width_resp == 'true' || $sb_instagram_width_resp == true ) ? $sb_instagram_width_resp = true : $sb_instagram_width_resp = false;
    if( $atts[ 'widthresp' ] == 'false' ) $sb_instagram_width_resp = false;

    //Layout options
	$sb_instagram_disable_mobile = $atts['disablemobile'];
	( $sb_instagram_disable_mobile == 'on' || $sb_instagram_disable_mobile == 'true' || $sb_instagram_disable_mobile == true ) ? $sb_instagram_disable_mobile = ' sbi_disable_mobile' : $sb_instagram_disable_mobile = '';
	if( $atts[ 'disablemobile' ] === 'false' ) $sb_instagram_disable_mobile = '';

    $sb_instagram_cols = $atts['cols'];
	if ( $sb_instagram_disable_mobile !== ' sbi_disable_mobile' && $atts['colsmobile'] !== 'same' ) {
		$sb_instagram_colsmobile = (int)( $atts['colsmobile'] ) > 0 ? (int)$atts['colsmobile'] : 'auto';
		$sb_instagram_mobilecols_class = ' sbi_mob_col_' . $sb_instagram_colsmobile;
	} else {
		$sb_instagram_colsmobile = (int)( $atts['cols'] ) > 0 ? (int)$atts['cols'] : 4;
		$sb_instagram_mobilecols_class = ' sbi_disable_mobile sbi_mob_col_' . trim( $atts['cols'] );
	}

	$sbi_carousel = $layout === 'carousel' ? 'true' : $atts['carousel'];
	if ( $sb_instagram_colsmobile === 'auto' && ( $sbi_carousel === 'true' || $sbi_carousel === 'on' || $sbi_carousel === true || $sbi_carousel === 1 || $sbi_carousel === '1' ) ) {
		$sb_instagram_colsmobile = 1;
	}

	$sb_instagram_nummobile = (int)$atts['nummobile'] > 0 && $atts['nummobile'] !== '' ? (int)$atts['nummobile'] : $atts['num'];

	$sb_instagram_styles = 'style="';
    if($sb_instagram_cols == 1) $sb_instagram_styles .= 'max-width: 640px; ';
    if ( !empty($sb_instagram_width) ) $sb_instagram_styles .= 'width:' . $sb_instagram_width . $sb_instagram_width_unit .'; ';
    if ( !empty($sb_instagram_height) && $sb_instagram_height != '0' ) $sb_instagram_styles .= 'height:' . $sb_instagram_height . $sb_instagram_height_unit .'; ';
    if ( !empty($sb_instagram_background) ) $sb_instagram_styles .= 'background-color: #' . $sb_instagram_background . '; ';
    if ( !empty($sb_instagram_image_padding) ) $sb_instagram_styles .= 'padding-bottom: ' . (2*intval($sb_instagram_image_padding)).$sb_instagram_image_padding_unit . '; ';
    $sb_instagram_styles .= '"';

    //Header
    $sb_instagram_show_header = $atts['showheader'];
    ( $sb_instagram_show_header == 'on' || $sb_instagram_show_header == 'true' || $sb_instagram_show_header == true ) ? $sb_instagram_show_header = true : $sb_instagram_show_header = false;
    if( $atts[ 'showheader' ] === 'false' ) $sb_instagram_show_header = false;

    $sb_instagram_header_style = $atts['headerstyle'];

    $sb_instagram_show_followers = $atts['showfollowers'];
    ( $sb_instagram_show_followers == 'on' || $sb_instagram_show_followers == 'true' || $sb_instagram_show_followers ) ? $sb_instagram_show_followers = 'true' : $sb_instagram_show_followers = 'false';
    if( $atts[ 'showfollowers' ] === 'false' ) $sb_instagram_show_followers = false;
    //As this is a new option in the update then set it to be true if it doesn't exist yet
    if ( !array_key_exists( 'sb_instagram_show_followers', $options ) ) $sb_instagram_show_followers = 'true';

    $sb_instagram_show_bio = $atts['showbio'];
    ( $sb_instagram_show_bio == 'on' || $sb_instagram_show_bio == 'true' || $sb_instagram_show_bio ) ? $sb_instagram_show_bio = 'true' : $sb_instagram_show_bio = 'false';
    if( $atts[ 'showbio' ] === 'false' ) $sb_instagram_show_bio = false;
    //As this is a new option in the update then set it to be true if it doesn't exist yet
    if ( !array_key_exists( 'sb_instagram_show_bio', $options ) ) $sb_instagram_show_bio = 'true';

    $sb_instagram_header_color = str_replace('#', '', $atts['headercolor']);

    $sb_instagram_header_primary_color = str_replace('#', '', $atts['headerprimarycolor']);
    $sb_instagram_header_secondary_color = str_replace('#', '', $atts['headersecondarycolor']);
	$sb_instagram_header_size_class = in_array( strtolower( $atts['headersize'] ), array( 'medium', 'large' ) ) ? ' sbi_'.strtolower( $atts['headersize'] ) : '';

	//Load More on Scroll
	$sb_instagram_autoscroll = $atts['autoscroll'];
	( $sb_instagram_autoscroll == 'true' || $sb_instagram_autoscroll == 'on' || $sb_instagram_autoscroll == 1 || $sb_instagram_autoscroll == '1' ) ? $sb_instagram_autoscroll = true : $sb_instagram_autoscroll = false;
	if( $atts[ 'autoscroll' ] === false ) $sb_instagram_autoscroll = false;
	$sbi_class_autoscroll = $sb_instagram_autoscroll ? ' sbi_autoscroll' : '';

	$sb_instagram_autoscrolldistance_data_att = '';
	if ( $sb_instagram_autoscroll ) {
		$sb_instagram_autoscrolldistance = $atts['autoscrolldistance'];
		$sb_instagram_autoscrolldistance = !empty( $sb_instagram_autoscrolldistance ) ? $sb_instagram_autoscrolldistance : '200';
		$sb_instagram_autoscrolldistance_data_att = ' data-scrolldistance="' . $sb_instagram_autoscrolldistance . '"';
	}

    //Load more button
    $sb_instagram_show_btn = $atts['showbutton'];
    ( $sb_instagram_show_btn == 'on' || $sb_instagram_show_btn == 'true' || $sb_instagram_show_btn == true ) ? $sb_instagram_show_btn = true : $sb_instagram_show_btn = false;
    if( $atts[ 'showbutton' ] === 'false' ) $sb_instagram_show_btn = false;

    $sb_instagram_btn_background = str_replace('#', '', $atts['buttoncolor']);
    $sb_instagram_btn_text_color = str_replace('#', '', $atts['buttontextcolor']);
    //Load more button styles
    $sb_instagram_button_styles = 'style="display: none; ';
    if ( !empty($sb_instagram_btn_background) ) $sb_instagram_button_styles .= 'background: #'.$sb_instagram_btn_background.'; ';
    if ( !empty($sb_instagram_btn_text_color) ) $sb_instagram_button_styles .= 'color: #'.$sb_instagram_btn_text_color.';';
    $sb_instagram_button_styles .= '"';

    //Follow button vars
    $sb_instagram_show_follow_btn = $atts['showfollow'];
    ( $sb_instagram_show_follow_btn == 'on' || $sb_instagram_show_follow_btn == 'true' || $sb_instagram_show_follow_btn == true ) ? $sb_instagram_show_follow_btn = true : $sb_instagram_show_follow_btn = false;
    if( $atts[ 'showfollow' ] === 'false' ) $sb_instagram_show_follow_btn = false;

    $sb_instagram_follow_btn_background = str_replace('#', '', $atts['followcolor']);
    $sb_instagram_follow_btn_text_color = str_replace('#', '', $atts['followtextcolor']);
    $sb_instagram_follow_btn_text = $atts['followtext'];
    //Follow button styles
    $sb_instagram_follow_btn_styles = 'style="';
    if ( !empty($sb_instagram_follow_btn_background) ) $sb_instagram_follow_btn_styles .= 'background: #'.$sb_instagram_follow_btn_background.'; ';
    if ( !empty($sb_instagram_follow_btn_text_color) ) $sb_instagram_follow_btn_styles .= 'color: #'.$sb_instagram_follow_btn_text_color.';';
    $sb_instagram_follow_btn_styles .= '"';
    //Follow button HTML
    $sb_instagram_follow_btn_classes = '';
    if( strpos($sb_instagram_follow_btn_styles, 'background') !== false ) $sb_instagram_follow_btn_classes = ' sbi_custom';
    $sb_instagram_follow_btn_html = '<div class="sbi_follow_btn'.$sb_instagram_follow_btn_classes.'"><a href="https://instagram.com/" '.$sb_instagram_follow_btn_styles.' target="_blank"><i class="fa fab fa-instagram"></i>'.stripslashes(__( $sb_instagram_follow_btn_text, 'instagram-feed' ) ).'</a></div>';

    //Text styles
    $sb_instagram_show_caption = $layout !== 'highlight' ? $atts['showcaption'] : false;
    $sb_instagram_caption_length = $atts['captionlength'];
    $sb_instagram_caption_color = str_replace('#', '', $atts['captioncolor']);
    $sb_instagram_caption_size = $atts['captionsize'];

    //Meta styles
    $sb_instagram_show_meta = $layout !== 'highlight' ? $atts['showlikes'] : false;
    $sb_instagram_meta_color = str_replace('#', '', $atts['likescolor']);
    $sb_instagram_meta_size = $atts['likessize'];

    //Lighbox
    $sb_instagram_disable_lightbox = $atts['disablelightbox'];
    ( $sb_instagram_disable_lightbox == 'on' || $sb_instagram_disable_lightbox == 'true' || $sb_instagram_disable_lightbox == true ) ? $sb_instagram_disable_lightbox = 'true' : $sb_instagram_disable_lightbox = 'false';
    if( $atts[ 'disablelightbox' ] === 'false' ) $sb_instagram_disable_lightbox = 'false';

	$sb_instagram_captionlinks = $atts['captionlinks'];
	( $sb_instagram_captionlinks == 'on' || $sb_instagram_captionlinks == 'true' || $sb_instagram_captionlinks == true ) ? $sb_instagram_captionlinks = 'true' : $sb_instagram_captionlinks = 'false';
	if( $atts[ 'captionlinks' ] === 'false' ) $sb_instagram_captionlinks = 'false';

    //Class
    !empty( $atts['class'] ) ? $sbi_class = ' ' . trim($atts['class']) : $sbi_class = '';

    //Media type
    $sb_instagram_media_type = $atts['media'];
    if( !isset($sb_instagram_media_type) || empty($sb_instagram_media_type) ) $sb_instagram_media_type = 'all';

    //Ajax theme
    $sb_instagram_ajax_theme = $atts['ajaxtheme'];
    ( $sb_instagram_ajax_theme == 'on' || $sb_instagram_ajax_theme == 'true' || $sb_instagram_ajax_theme == true ) ? $sb_instagram_ajax_theme = true : $sb_instagram_ajax_theme = false;
    if( $atts[ 'ajaxtheme' ] === 'false' ) $sb_instagram_ajax_theme = false;

    //Caching
    $sb_instagram_cache_time = trim($atts['cachetime']);
    if ( !array_key_exists( 'sb_instagram_cache_time', $options ) || $sb_instagram_cache_time == '' ) $sb_instagram_cache_time = '1';
    ($sb_instagram_cache_time == 0 || $sb_instagram_cache_time == '0') ? $sb_instagram_disable_cache = 'true' : $sb_instagram_disable_cache = 'false';

    //API requests
    $sb_instagram_requests_max = trim($atts['maxrequests']);
    if( $sb_instagram_requests_max == '0' ) $sb_instagram_requests_max = 1;
    if( empty($sb_instagram_requests_max) ) $sb_instagram_requests_max = 5;
    $sb_instagram_requests_max = min($sb_instagram_requests_max, 10);

    //Carousel
	$sbi_carousel = $layout === 'carousel' ? 'true' : $atts['carousel'];

        ( $sbi_carousel == 'true' || $sbi_carousel == 'on' || $sbi_carousel == true || $sbi_carousel == 1 || $sbi_carousel == '1' ) ? $sbi_carousel = 'true' : $sbi_carousel = 'false';
    if( $sbi_carousel === 'false' ) $sbi_carousel = 'false';

    if ( $sbi_carousel !== 'false' ) {
	    $sbi_class_autoscroll = '';
	    $sb_instagram_autoscroll = false;
    }

    $sbi_carousel_class = '';
    $sbi_carousel_options = '';
    $sb_instagram_cols_class = $sb_instagram_cols;
    if($sbi_carousel == 'true'){
        $sbi_carousel_class = 'class="sbi_carousel" ';
        $sb_instagram_show_btn = false;
        $sb_instagram_cols_class = '1';
	    if ( $sb_instagram_mobilecols_class !== ' sbi_mob_col_auto' ) {
		    $sb_instagram_mobilecols_class = '';
	    }
    }
	$sb_instagram_carousel_loop = ! empty( $atts['carouselloop'] ) && ($atts['carouselloop'] !== 'rewind') ? 'false' : 'true';
	$sb_instagram_carousel_rows = ! empty( $atts['carouselrows'] ) ? min( (int)$atts['carouselrows'], 2 ) : 1;

	$sb_instagram_carousel_arrows = $atts['carouselarrows'];
    ( $sb_instagram_carousel_arrows == 'true' || $sb_instagram_carousel_arrows == 'on' || $sb_instagram_carousel_arrows == 1 || $sb_instagram_carousel_arrows == '1' ) ? $sb_instagram_carousel_arrows = 'true' : $sb_instagram_carousel_arrows = 'false';
    if( $atts[ 'carouselarrows' ] === false ) $sb_instagram_carousel_arrows = 'false';

    $sb_instagram_carousel_pag = $atts['carouselpag'];
    ( $sb_instagram_carousel_pag == 'true' || $sb_instagram_carousel_pag == 'on' || $sb_instagram_carousel_pag == 1 || $sb_instagram_carousel_pag == '1' ) ? $sb_instagram_carousel_pag = 'true' : $sb_instagram_carousel_pag = 'false';
    if( $atts[ 'carouselpag' ] === false ) $sb_instagram_carousel_pag = 'false';

    $sb_instagram_carousel_autoplay = $atts['carouselautoplay'];
    ( $sb_instagram_carousel_autoplay == 'true' || $sb_instagram_carousel_autoplay == 'on' || $sb_instagram_carousel_autoplay == 1 || $sb_instagram_carousel_autoplay == '1' ) ? $sb_instagram_carousel_autoplay = 'true' : $sb_instagram_carousel_autoplay = 'false';
    if( $atts[ 'carouselautoplay' ] === false ) $sb_instagram_carousel_autoplay = 'false';

    $sb_instagram_carousel_interval = intval($atts['carouseltime']);

	//Moderation Mode
	$sb_instagram_moderation_mode = $atts['moderationmode'];
	( $sb_instagram_moderation_mode == 'on' || $sb_instagram_moderation_mode == 'true' || $sb_instagram_moderation_mode == true ) ? $sb_instagram_moderation_mode = true : $sb_instagram_moderation_mode = false;
	if( $atts[ 'moderationmode' ] === 'false' ) $sb_instagram_moderation_mode = false;
	if ( current_user_can( 'edit_posts' )
	     && $moderation_mode === 'true' ) {
		$sbi_carousel_class = '';
		$sbi_class_autoscroll = '';
	}

    //Filters
	$feed_is_filtered = false;
    //Exclude words
    isset($atts[ 'excludewords' ]) ? $sb_instagram_exclude_words = trim($atts['excludewords']) : $sb_instagram_exclude_words = '';

    //Explode string by commas
    // $sb_instagram_exclude_words = explode(",", trim( $sb_instagram_exclude_words ) );

    //Include words
    isset($atts[ 'includewords' ]) ? $sb_instagram_include_words = trim($atts['includewords']) : $sb_instagram_include_words = '';

	//White list
	isset($atts[ 'whitelist' ]) ? $sb_instagram_white_list = trim($atts['whitelist']) : $sb_instagram_white_list = '';

	$permanent_white_list_feed_db = false;
	if ($sb_instagram_white_list != '') {
		$permanent_white_lists = get_option( 'sb_permanent_white_lists', array() );
		if ( in_array( $sb_instagram_white_list, $permanent_white_lists, true ) ) {
			$permanent_white_list_feed_db = true;
		}
	}

	//show users
	isset($atts[ 'showusers' ]) ? $sb_instagram_show_users = trim($atts['showusers']) : $sb_instagram_show_users = '';

	//Explode string by commas
    // $sb_instagram_include_words = explode(",", trim( $sb_instagram_include_words ) );

    //Access token
    isset($sb_instagram_settings[ 'sb_instagram_at' ]) ? $sb_instagram_at = trim($sb_instagram_settings['sb_instagram_at']) : $sb_instagram_at = '';

    /* CACHING */
    //Create the transient name from the plugin settings
    $sb_instagram_include_words = $atts['includewords'];
    $sb_instagram_exclude_words = $atts['excludewords'];
    $sbi_cache_string_include = '';
    $sbi_cache_string_exclude = '';

    //Convert include words array into a string consisting of 3 chars each
    if( !empty($sb_instagram_include_words) ){
        $sb_instagram_include_words_arr = explode(',', $sb_instagram_include_words);

        foreach($sb_instagram_include_words_arr as $sbi_word){
            $sbi_include_word = str_replace(str_split(' #'), '', $sbi_word);
            $sbi_cache_string_include .= substr( str_replace('%','',urlencode( $sbi_include_word )), 0, 3);
        }

    }

    //Convert exclude words array into a string consisting of 3 chars each
    if( !empty($sb_instagram_exclude_words) ){
        $sb_instagram_exclude_words_arr = explode(',', $sb_instagram_exclude_words);

        foreach($sb_instagram_exclude_words_arr as $sbi_word){
	        $sbi_exclude_word = str_replace(str_split(' #'), '', $sbi_word);
	        $sbi_cache_string_exclude .= substr( str_replace('%','',urlencode( $sbi_exclude_word )), 0, 3);
        }

    }

    //Figure out how long the first part of the caching string should be
    $sbi_cache_string_include_length = strlen($sbi_cache_string_include);
    $sbi_cache_string_exclude_length = strlen($sbi_cache_string_exclude);
    $sbi_cache_string_length = 40 - min($sbi_cache_string_include_length + $sbi_cache_string_exclude_length, 20);

    //Create the first part of the caching string
    $sbi_transient_name = 'sbi_';

	$sbi_transient_name .= substr( $sb_instagram_white_list, 0, 3 ) . substr( $sb_instagram_show_users, 0, 3 );

	$feed_is_filtered = ($sb_instagram_white_list !== '' || $sb_instagram_show_users !== '');

	if ( $sb_instagram_media_type !== 'all' ) {
		$sbi_transient_name .= substr( $sb_instagram_media_type, 0, 1 );
	}
	$users = substr( str_replace(str_split(', '), '', $sb_instagram_user_id), 0, $sbi_cache_string_length);
	$hashtags = substr( str_replace(str_split(', #'), '', $sb_instagram_hashtag), 0, $sbi_cache_string_length);
	$coordinates = substr( preg_replace('/[^\da-z]/i', '', $sb_instagram_coordinates), 0, $sbi_cache_string_length);
	$location = substr( str_replace(str_split(', -.()'), '', $sb_instagram_location), 0, $sbi_cache_string_length);

	if ( $sb_instagram_type == 'user' ) $sbi_transient_name .= $users; //Remove commas and spaces and limit chars
    if ( $sb_instagram_type == 'hashtag' ) {
	    $full_tag = str_replace('%','',urlencode( $hashtags ));
	    $max_length = strlen( $full_tag ) < 20 ? strlen( $full_tag ) : 20;
	    $sbi_transient_name .= substr( $full_tag, 0, $max_length );
    }
	if ( $sb_instagram_type == 'coordinates' ) $sbi_transient_name .= $coordinates;
	if ( $sb_instagram_type == 'location' ) $sbi_transient_name .= $location;
	if ( $sb_instagram_type == 'single' && !empty( $shortcode_atts_raw['single'] ) ) {
		foreach (explode(',', str_replace( array( ' ','sbi_'), '', $shortcode_atts_raw['single'] )) as $single ) {
			$sbi_transient_name .= substr( $single, 10, 9 );
		}
	}
	if ( $sb_instagram_type == 'mixed' ) {
		$sb_instagram_user_id = ! empty( $shortcode_atts_raw['user'] ) ? implode(',', $ids_in_use_from_shortcode ) : '';
		$sb_instagram_hashtag = ! empty( $shortcode_atts_raw['hashtag'] ) ? $shortcode_atts_raw['hashtag'] : '';
		$sb_instagram_location = ! empty( $shortcode_atts_raw['location'] ) ? $shortcode_atts_raw['location'] : '';
		$sb_instagram_coordinates = ! empty( $shortcode_atts_raw['coordinates'] ) ? $shortcode_atts_raw['coordinates'] : '';
		$sb_instagram_single = ! empty( $shortcode_atts_raw['single'] ) ? $shortcode_atts_raw['single'] : '';

		$sbi_transient_name .= implode('', $ids_in_use_from_shortcode );
		foreach (explode(',', str_replace( array( ' '), '', $sb_instagram_hashtag )) as $hashtag ) {
			$sbi_transient_name .= substr( $hashtag, 0, 7 );
		}
		$sbi_transient_name .= str_replace( array( ',',' ', '(', ')' ), '', $sb_instagram_coordinates ) . str_replace( array( ',',' '), '', $sb_instagram_location );
		foreach (explode(',', str_replace( array( ' ','sbi_'), '', $sb_instagram_single )) as $single ) {
			$sbi_transient_name .= substr( $single, 10, 9 );
		}
	}


	//Find the length of the string so far, and then however many chars are left we can use this for filters
    $sbi_cache_string_length = strlen($sbi_transient_name);
    $sbi_cache_string_length = 44 - intval($sbi_cache_string_length);

    //Set the length of each filter string
    if( $sbi_cache_string_exclude_length < $sbi_cache_string_length/2 ){
        $sbi_cache_string_include = substr($sbi_cache_string_include, 0, $sbi_cache_string_length - $sbi_cache_string_exclude_length);
    } else {
        //Exclude string
        if( strlen($sbi_cache_string_exclude) == 0 ){
            $sbi_cache_string_include = substr($sbi_cache_string_include, 0, $sbi_cache_string_length );
        } else {
            $sbi_cache_string_include = substr($sbi_cache_string_include, 0, ($sbi_cache_string_length/2) );
        }
        //Include string
        if( strlen($sbi_cache_string_include) == 0 ){
            $sbi_cache_string_exclude = substr($sbi_cache_string_exclude, 0, $sbi_cache_string_length );
        } else {
            $sbi_cache_string_exclude = substr($sbi_cache_string_exclude, 0, ($sbi_cache_string_length/2) );
        }
    }
    //Add both parts of the caching string together and make sure it doesn't exceed 45
    $sbi_transient_name .= $sbi_cache_string_include . $sbi_cache_string_exclude;

	$sbi_transient_name = substr($sbi_transient_name, 0, 45);

	// delete_transient($sbi_transient_name);
	//Check whether the cache transient exists in the database and is available for more than one more minute
	$feed_expires = get_option( '_transient_timeout_'.$sbi_transient_name );
	$sbi_cache_exists = $feed_expires !== false && ($feed_expires - time()) > 60 ? 'true' : 'false';

    $sbiHeaderCache = 'false';
    if( $sb_instagram_type == 'user' ){
        //If it's a user then add the header cache check to the feed
        $sb_instagram_user_id_arr = explode(',', $sb_instagram_user_id);
        $sbi_header_transient_name = 'sbi_header_' . trim($sb_instagram_user_id_arr[0]);
        $sbi_header_transient_name = substr($sbi_header_transient_name, 0, 45);

	    //Check for the header cache
	    $header_expires = get_option( '_transient_timeout_'.$sbi_header_transient_name );
	    $sbi_header_cache_exists = $header_expires !== false && ($header_expires - time()) > 60 ? 'true' : 'false';
	    $sbiHeaderCache = $sbi_header_cache_exists;
    }

    if ( (isset( $options['check_api'] ) && $options['check_api'] === 'on' || $options['check_api']) && ( !isset( $options['sb_instagram_cache_time'] ) || ( isset( $options['sb_instagram_cache_time'] ) && (int)$options['sb_instagram_cache_time'] > 0 ) ) ) {
	    if ( ! get_transient( '&'.$sbi_transient_name, false ) ) {
		    $sbi_cache_exists = 'true';
		    $sbiHeaderCache = 'true';
	    }
    }

    $use_backup_json = '';
	$use_header_backup = false;
	$always_use_backup = isset( $atts['permanent'] ) ? ($atts['permanent'] === 'true') : false;
	$backups_enabled = isset( $options['sb_instagram_backup'] ) ? $options['sb_instagram_backup'] !== '' : true;
	if ( !$always_use_backup ) {
		$always_use_backup = $permanent_white_list_feed_db;
	}
	$still_using_backup = false;
	if ( $sbiHeaderCache == 'false' && $sb_instagram_type == 'user' ) {
		$still_using_backup = get_transient( '&'.$sbi_header_transient_name, false );
	}

	if ( ($sbiHeaderCache == 'false' && $still_using_backup && $moderation_mode !== 'true' && $sb_instagram_type == 'user') || ($always_use_backup && isset( $sbi_header_transient_name )) ) {
		$use_header_backup = sbi_should_use_backup_cache( $access_token, $sbi_header_transient_name, $feed_is_filtered, $always_use_backup, $sb_instagram_white_list, $backups_enabled);
		if ( $use_header_backup ) {
			$sbiHeaderCache = 'true';
			$use_backup_json = ', &quot;useBackup&quot;: &quot;header&quot;';
		}
    }

	$still_using_backup = false;
    if ( $sbi_cache_exists == 'false' ) {
	    $still_using_backup = get_transient( '&'.$sbi_transient_name, false );
    }
	if ( ($sbi_cache_exists == 'false' && $still_using_backup && $moderation_mode !== 'true') || $always_use_backup ) {
		$use_feed_backup = sbi_should_use_backup_cache( $access_token, $sbi_transient_name, $feed_is_filtered, $always_use_backup, $sb_instagram_white_list, $backups_enabled );

		if ( $use_feed_backup ) {
			$sbi_cache_exists = 'true';
			if ( $use_header_backup ) {
				$use_backup_json = ', &quot;useBackup&quot;: &quot;header,feed&quot;';
			} else {
				$use_backup_json = ', &quot;useBackup&quot;: &quot;feed&quot;';
			}
		}
	}

    /* END CACHING */

    // Moderation mode
	$sbi_moderation_link = '';
	$sbi_moderation_index = '';
	$sbi_moderation_json = '';

	if ( current_user_can( 'edit_posts' )
         && $moderation_mode ) {
    	$sbi_class_moderation_mode = ' sbi_moderation_mode';
	    $sbi_get_mod_index = isset( $_GET['sbi_moderation_index'] ) ? sanitize_text_field( substr( $_GET['sbi_moderation_index'], 0, 10 ) ) : '0';
	    $sbi_moderation_index = ', &quot;sbiModIndex&quot;: &quot;'.$sbi_get_mod_index.'&quot;';
	    $sb_instagram_cols_class = '5';
	    $atts['num'] = 50;
	    $sb_instagram_disable_cache = 'true';
	    $sb_instagram_lightbox_comments = 'false';
	    $sb_instagram_media_type = 'all';
	    $sb_instagram_show_meta = true;
	    $sb_instagram_show_btn = true;
	    $sb_instagram_show_header = true;
	    $sbiHeaderCache = false;
	    $sbi_cache_exists = false;
	    $sb_instagram_styles = 'width: 100%;';
	    $sb_instagram_cols = 5;
		$sbi_moderation_json = $always_use_backup ? ', &quot;permanent&quot;: &quot;true&quot;' : '';
		$sbi_moderation_json .= $permanent_white_list_feed_db ? ', &quot;permanentDb&quot;: &quot;true&quot;' : '';
	} elseif ( current_user_can( 'edit_posts' ) && $sb_instagram_moderation_mode ) {
	    $sbi_moderation_link = '<a href="javascript:void(0);" class="sbi_moderation_link">' . sbi_get_fa_el( 'fa-edit' ) . 'Moderate feed</a>';
	    $sbi_class_moderation_mode = '';
    } else {
	    $sbi_class_moderation_mode = '';
    }

	//White lists
	$sb_instagram_white_lists = '';
	$sb_instagram_white_list_ids = '';
	if ( isset( $atts['whitelist'] ) ) {
		$sb_instagram_white_lists = get_option( 'sb_instagram_white_lists_'.$atts['whitelist'], '' );
		$sb_instagram_white_list_ids = ! empty( $sb_instagram_white_lists ) ? implode( ', ', $sb_instagram_white_lists ) : '';
	}

	if( $sb_instagram_type == 'user' && ( empty($sb_instagram_user_id) || !isset($sb_instagram_user_id) ) ) {
		$sb_at_parts = explode( '.',$options[ 'sb_instagram_at' ]);
		$sb_instagram_user_id = $sb_at_parts[0];
	}

	// if white list feed was just updated, don't use backup cache, set max requests to 10
	if ( get_transient( 'sb_wlupdated_'.$atts['whitelist'] ) ) {
		$sb_instagram_requests_max = 10;
	}

	/** Image resolution */
	$using_custom_sizes = get_option( 'sb_instagram_using_custom_sizes' );
	$input_imageres = trim( $atts['imageres'] );
	if( $using_custom_sizes == '1' ) {
		if ( $input_imageres === 'auto' ) {
			$imageres = 'autocustom';
		} else {
			if ((int)$input_imageres > 0) {
				$imageres = (int)$input_imageres;
			} else {
				$imageres = $input_imageres != '' ? $input_imageres : 'auto';
			}
		}
	} else {
		if ((int)$input_imageres > 0) {
			$imageres = 'auto';
		} else {
			$imageres = $input_imageres != '' && $input_imageres != 'autocustom' ? $input_imageres : 'auto';
		}
	}

    //Graph API update notices
    $sbi_deprecation_notice = '';
    if ( $sb_instagram_type !== 'user' ){
        $sbi_deprecation_type = 'Hashtag';
        if ( $sb_instagram_type == 'coordinates' ) $sbi_deprecation_type = 'Coordinate';
        if ( $sb_instagram_type == 'location' ) $sbi_deprecation_type = 'Location';
        if ( $sb_instagram_type == 'single' ) $sbi_deprecation_type = 'Single Post';

        $sbi_deprecation_notice = '<div class="sbi_frontend_notice"><b>This message is only visible to admins</b><br />Some upcoming Instagram changes will affect '.$sbi_deprecation_type.' feeds. Please <a href="https://smashballoon.com/instagram-api-changes-dec-11-2018/" target="_blank">see here</a> for more information. <a class="sbi_close_notice" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i></a></div>';
    }


	/******************* CONTENT ********************/
    $sb_instagram_content = '<div id="sb_instagram" class="sbi' . $sbi_class . $sbi_class_moderation_mode . $sbi_class_autoscroll . $sb_instagram_mobilecols_class . $layout_class;
    if ( !empty($sb_instagram_height) ) $sb_instagram_content .= ' sbi_fixed_height ';
    $sb_instagram_content .= ' sbi_col_' . trim($sb_instagram_cols_class);
    if ( $sb_instagram_width_resp ) $sb_instagram_content .= ' sbi_width_resp';
    $sb_instagram_content .= '" '.$sb_instagram_styles .' data-id="' . $sb_instagram_user_id . '" data-num="' . trim($atts['num']) . '" data-res="' . $imageres . '" data-cols="' . trim($sb_instagram_cols) . '" data-options=\'{&quot;showcaption&quot;: &quot;'.$sb_instagram_show_caption.'&quot;, &quot;captionlength&quot;: &quot;'.$sb_instagram_caption_length.'&quot;,'.$at_front_string.' &quot;captioncolor&quot;: &quot;'.$sb_instagram_caption_color.'&quot;,'.$at_middle_string.' &quot;captionsize&quot;: &quot;'.$sb_instagram_caption_size.'&quot;, &quot;showlikes&quot;: &quot;'.$sb_instagram_show_meta.'&quot;, &quot;likescolor&quot;: &quot;'.$sb_instagram_meta_color.'&quot;, &quot;likessize&quot;: &quot;'.$sb_instagram_meta_size.'&quot;, &quot;sortby&quot;: &quot;'.$atts['sortby'].'&quot;, &quot;hashtag&quot;: &quot;'.$sb_instagram_hashtag.'&quot;, &quot;type&quot;: &quot;'.$sb_instagram_type.'&quot;, &quot;hovercolor&quot;: &quot;'.sbi_hextorgb($sb_hover_background).'&quot;, &quot;hovertextcolor&quot;: &quot;'.sbi_hextorgb($sb_hover_text).'&quot;, &quot;hoverdisplay&quot;: &quot;'.$atts['hoverdisplay'].'&quot;, &quot;hovereffect&quot;: &quot;'.$atts['hovereffect'].'&quot;, &quot;headercolor&quot;: &quot;'.$sb_instagram_header_color.'&quot;, &quot;headerprimarycolor&quot;: &quot;'.$sb_instagram_header_primary_color.'&quot;, &quot;headersecondarycolor&quot;: &quot;'.$sb_instagram_header_secondary_color.'&quot;, &quot;disablelightbox&quot;: &quot;'.$sb_instagram_disable_lightbox.'&quot;, &quot;captionlinks&quot;: &quot;'.$sb_instagram_captionlinks.'&quot;, &quot;disablecache&quot;: &quot;'.$sb_instagram_disable_cache.'&quot;, &quot;location&quot;: &quot;'.$sb_instagram_location.'&quot;, &quot;coordinates&quot;: &quot;'.$sb_instagram_coordinates.'&quot;, &quot;single&quot;: &quot;'.$sb_instagram_single.'&quot;,'.$at_back_string.' &quot;nummobile&quot;: &quot;'.$sb_instagram_nummobile.'&quot;, &quot;colsmobile&quot;: &quot;'.$sb_instagram_colsmobile.'&quot;,  &quot;lightboxcomments&quot;: &quot;'.$sb_instagram_lightbox_comments.'&quot;,&quot;numcomments&quot;: &quot;'.$sb_instagram_num_comments.'&quot;,&quot;maxrequests&quot;: &quot;'.$sb_instagram_requests_max.'&quot;, &quot;headerstyle&quot;: &quot;'.$sb_instagram_header_style.'&quot;, &quot;showfollowers&quot;: &quot;'.$sb_instagram_show_followers.'&quot;, &quot;showbio&quot;: &quot;'.$sb_instagram_show_bio.'&quot;, &quot;carousel&quot;: &quot;['.$sbi_carousel.', '.$sb_instagram_carousel_arrows.', '.$sb_instagram_carousel_pag.', '.$sb_instagram_carousel_autoplay.', '.$sb_instagram_carousel_interval.', '.$sb_instagram_carousel_rows.','.$sb_instagram_carousel_loop.']&quot;, &quot;highlight&quot;: &quot;'.$highlight_string.'&quot;, &quot;imagepadding&quot;: &quot;'.$sb_instagram_image_padding.'&quot;, &quot;imagepaddingunit&quot;: &quot;'.$sb_instagram_image_padding_unit.'&quot;, &quot;media&quot;: &quot;'.$sb_instagram_media_type.'&quot;, &quot;showusers&quot;: &quot;'.$sb_instagram_show_users.'&quot;, &quot;includewords&quot;: &quot;'.$sb_instagram_include_words.'&quot;, &quot;excludewords&quot;: &quot;'.$sb_instagram_exclude_words.'&quot;, &quot;sbiCacheExists&quot;: &quot;'.$sbi_cache_exists.'&quot;, &quot;sbiHeaderCache&quot;: &quot;'.$sbiHeaderCache.'&quot;'.$use_backup_json.$sbi_moderation_json.', &quot;sbiWhiteList&quot;: &quot;'.$sb_instagram_white_list.'&quot;, &quot;sbiWhiteListIds&quot;: &quot;'.$sb_instagram_white_list_ids.'&quot;'.$sbi_moderation_index.'}\''.$sb_instagram_lightbox_com_data_att.$sb_instagram_autoscrolldistance_data_att.'>';

    if( !get_option('sb_instagram_hide_notices') ) $sb_instagram_content .= $sbi_deprecation_notice;
	$sb_instagram_content .= $sbi_moderation_link;

    //Header
    if( $sb_instagram_show_header ){
    	$centered_class = $sb_instagram_header_style == 'centered' ? ' sbi_centered' : '';
        $sb_instagram_content .= '<div class="sb_instagram_header sbi_feed_type_' . $sb_instagram_type . $sb_instagram_header_size_class . $centered_class;
        if($sb_instagram_type !== 'user') $sb_instagram_content .= ' sbi_header_type_generic';
        if( $sb_instagram_header_style == 'boxed' ) $sb_instagram_content .= ' sbi_header_style_boxed';
        $sb_instagram_content .= '"';
        if( $sb_instagram_header_style == 'boxed' ) $sb_instagram_content .= ' data-follow-text="' . $sb_instagram_follow_btn_text . '"';
        $sb_instagram_content .= ' style="';
        if( $sb_instagram_header_style !== 'boxed' ) $sb_instagram_content .= 'padding: '.(intval($sb_instagram_image_padding)).$sb_instagram_image_padding_unit.' '.(2*intval($sb_instagram_image_padding)).$sb_instagram_image_padding_unit . ';';
        if( intval($sb_instagram_image_padding) < 10 && $sb_instagram_header_style !== 'boxed' ) $sb_instagram_content .= ' margin-bottom: 10px;';
        if( $sb_instagram_header_style == 'boxed' ) $sb_instagram_content .= ' background: #'.$sb_instagram_header_primary_color.';';
        $sb_instagram_content .= '"></div>';
    }

    //Images container
	$padding_style = (int)$sb_instagram_image_padding > 0 ? 'style="padding: '.$sb_instagram_image_padding . $sb_instagram_image_padding_unit . ';"' : '';
    $sb_instagram_content .= '<div id="sbi_images" '.$sbi_carousel_class . $padding_style .'>';

    //Loader
    $sb_instagram_content .= '<div class="sbi_loader"></div>';

    //Error messages
	if( empty($options[ 'sb_instagram_at' ]) && empty($access_token) ) $sb_instagram_content .= '<p>Please enter an Access Token on the Instagram Feed plugin Settings page</p>';

    if( $sb_instagram_type == 'hashtag' && (empty($sb_instagram_hashtag) || !isset($sb_instagram_hashtag) ) ) $sb_instagram_content .= '<p>Please enter a Hashtag on the Instagram plugin Settings page</p>';

    $sb_instagram_content .= '</div><div id="sbi_load" class="sbi_hidden"';
	if( $sb_instagram_show_btn ||$sb_instagram_show_follow_btn ) {
		if($sb_instagram_image_padding == 0 || !isset($sb_instagram_image_padding)) $sb_instagram_content .= ' style="padding-top: 5px"';
	}
    $sb_instagram_content .= '>';

    //Load More button
	$sb_instagram_button_classes = '';
	if ($sb_instagram_autoscroll && !$sb_instagram_show_btn) {
		$sb_instagram_button_classes = ' sbi_hide_load';
	}
    if( strpos($sb_instagram_button_styles, 'background') !== false ) $sb_instagram_button_classes = ' sbi_custom';

    if( $sb_instagram_show_btn || $sb_instagram_autoscroll ) $sb_instagram_content .= '<a class="sbi_load_btn'.$sb_instagram_button_classes.'" href="javascript:void(0);" '.$sb_instagram_button_styles.'><span class="sbi_btn_text">'.__( $atts['buttontext'], 'instagram-feed' ).'</span><div class="sbi_loader sbi_hidden"></div></a>';
    //Follow button
    if( $sb_instagram_show_follow_btn && $sb_instagram_type == 'user' ) $sb_instagram_content .= $sb_instagram_follow_btn_html;

    $sb_instagram_content .= '</div>'; //End #sbi_load
    
    $sb_instagram_content .= '</div>'; //End #sb_instagram

    //If using an ajax theme then add the JS to the bottom of the feed
    if($sb_instagram_ajax_theme){
	    $font_method = isset( $options['sbi_font_method'] ) ? $options['sbi_font_method'] : 'svg';
	    $br_adjust = isset( $options['sbi_br_adjust'] ) && ($options['sbi_br_adjust'] == 'false' || $options['sbi_br_adjust'] == '0' || $options['sbi_br_adjust'] == false) ? '"br_adjust":"false"' : '"br_adjust":"true"';
	    $highlight_ids = $layout === 'highlight' && isset( $highlight_type ) && $highlight_type === 'id' ? str_replace( array( ' ', 'sbi_' ), '', $options['sb_instagram_highlight_ids'] ) : '';

        //Hide photos
        (isset($atts[ 'hidephotos' ]) && !empty($atts[ 'hidephotos' ])) ? $sb_instagram_hide_photos = trim($atts['hidephotos']) : $sb_instagram_hide_photos = '';

        //Block users
        (isset($atts[ 'blockusers' ]) && !empty($atts[ 'blockusers' ])) ? $sb_instagram_block_users = trim($atts['blockusers']) : $sb_instagram_block_users = '';

        $sb_instagram_content .= '<script type="text/javascript">var sb_instagram_js_options = {"sb_instagram_at":"'.sbi_get_parts( $options['sb_instagram_at'] ).'", "sb_instagram_hide_photos":"'.$sb_instagram_hide_photos.'", "sb_instagram_block_users":"'.$sb_instagram_block_users.'","highlight_ids":"'.$highlight_ids.'","font_method":"'.$font_method.'",'.$br_adjust.'};</script>';
        $sb_instagram_content .= "<script type='text/javascript' src='".plugins_url( '/js/sb-instagram.js?ver='.SBIVER , __FILE__ )."'></script>";
    }

	//Return our feed HTML to display
    return $sb_instagram_content;

}

function sbi_should_use_backup_cache( $token, $cache_name, $is_filtered, $always_use_backup = false, $white_list_id = '', $backups_enabled = true ) {

	if ( ! $backups_enabled ) {
		return false;
	}

	$expired_tokens = get_option( 'sb_expired_tokens', array() );
	$still_using_backup = get_transient( '&'.$cache_name, false );
	$backup_cache_exists = get_option( '!' . $cache_name );
	$white_list_updated = get_transient( 'sb_wlupdated_'.$white_list_id );

	if ( $always_use_backup ) {
		if ( !$backup_cache_exists || $white_list_updated ) {
			return false;
		}
		return true;
	} elseif ( $white_list_updated == 'true' ) {
		return false;
	}

	if ( in_array( sbi_maybe_clean( $token ), $expired_tokens, true ) && $backup_cache_exists ) {

		if ( !strpos( $cache_name, '_header' ) ) {
			echo '<div id="sbi_mod_error">';
				echo '<p><b>' . __( 'Error: Access Token is not valid or has expired.', 'instagram-feed' ) . ' ' . __( 'Feed will not update.', 'instagram-feed' ) . '</b><br /><span>' . __(' This error message is only visible to WordPress admins</span>', 'instagram-feed' );
				echo '<p>' . __( 'There\'s an issue with the Instagram Access Token that you are using. Please obtain a new Access Token on the plugin\'s Settings page.<br />If you continue to have an issue with your Access Token then please see <a href="https://smashballoon.com/my-instagram-access-token-keep-expiring/" target="_blank">this FAQ</a> for more information.', 'instagram-feed' );
			echo '</div>';
		}

		return true;
	} elseif ( $still_using_backup && $backup_cache_exists ) {
		return true;
	}
	return false;
}


#############################

//Convert Hex to RGB
function sbi_hextorgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

function sbi_get_fa_el( $icon ) {
	$sb_instagram_settings = get_option('sb_instagram_settings');
	$font_method = isset( $sb_instagram_settings['sbi_font_method'] ) ? $sb_instagram_settings['sbi_font_method'] : 'svg';

	$elems = array(
		'fa-spinner' => array(
			'icon' => '<span class="fa fa-spinner fa-pulse"></span>',
			'svg' => '<svg class="svg-inline--fa fa-spinner fa-w-16 fa-pulse" style="max-width: 24px;" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="spinner" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M304 48c0 26.51-21.49 48-48 48s-48-21.49-48-48 21.49-48 48-48 48 21.49 48 48zm-48 368c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zm208-208c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.49-48-48-48zM96 256c0-26.51-21.49-48-48-48S0 229.49 0 256s21.49 48 48 48 48-21.49 48-48zm12.922 99.078c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.491-48-48-48zm294.156 0c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48c0-26.509-21.49-48-48-48zM108.922 60.922c-26.51 0-48 21.49-48 48s21.49 48 48 48 48-21.49 48-48-21.491-48-48-48z"></path></svg>'
		),
		'fa-instagram' => array(
			'icon' => '<i class="fa fab fa-instagram"></i>',
			'svg' => '<svg class="svg-inline--fa fa-instagram fa-w-14" style="max-width: 24px;" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>'
		),
		'fa-edit' => array(
			'icon' => '<i class="fa far fa-edit"></i>',
			'svg' => '<svg class="svg-inline--fa fa-edit fa-w-18" style="max-width: 24px;" aria-hidden="true" data-fa-processed="" data-prefix="far" data-icon="edit" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M402.3 344.9l32-32c5-5 13.7-1.5 13.7 5.7V464c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h273.5c7.1 0 10.7 8.6 5.7 13.7l-32 32c-1.5 1.5-3.5 2.3-5.7 2.3H48v352h352V350.5c0-2.1.8-4.1 2.3-5.6zm156.6-201.8L296.3 405.7l-90.4 10c-26.2 2.9-48.5-19.2-45.6-45.6l10-90.4L432.9 17.1c22.9-22.9 59.9-22.9 82.7 0l43.2 43.2c22.9 22.9 22.9 60 .1 82.8zM460.1 174L402 115.9 216.2 301.8l-7.3 65.3 65.3-7.3L460.1 174zm64.8-79.7l-43.2-43.2c-4.1-4.1-10.8-4.1-14.8 0L436 82l58.1 58.1 30.9-30.9c4-4.2 4-10.8-.1-14.9z"></path></svg>'
		)
	);

	if ( $font_method !== 'fontfile' ){
		return $elems[ $icon ]['svg'];
	}

	return $elems[ $icon ]['icon'];
}

//Allows shortcodes in theme
add_filter('widget_text', 'do_shortcode');

function sbi_cache_photos() {
    $sb_instagram_settings = get_option('sb_instagram_settings');

    //If the caching time doesn't exist in the database then set it to be 1 hour
    ( !array_key_exists( 'sb_instagram_cache_time', $sb_instagram_settings ) ) ? $sb_instagram_cache_time = 1 : $sb_instagram_cache_time = $sb_instagram_settings['sb_instagram_cache_time'];
    ( !array_key_exists( 'sb_instagram_cache_time_unit', $sb_instagram_settings ) ) ? $sb_instagram_cache_time_unit = 'minutes' : $sb_instagram_cache_time_unit = $sb_instagram_settings['sb_instagram_cache_time_unit'];

    //Calculate the cache time in seconds
    if($sb_instagram_cache_time_unit == 'minutes') $sb_instagram_cache_time_unit = 60;
    if($sb_instagram_cache_time_unit == 'hours') $sb_instagram_cache_time_unit = 60*60;
    if($sb_instagram_cache_time_unit == 'days') $sb_instagram_cache_time_unit = 60*60*24;
    $cache_seconds = intval($sb_instagram_cache_time) * intval($sb_instagram_cache_time_unit);

    $transient_name = $_POST['transientName'];
	if ( is_array( $transient_name ) ) {
		$transient_name = isset( $transient_name['feed'] ) ? sanitize_text_field( $transient_name['feed'] ) : 'sbi_other';
	}

	if ( strpos( $_POST['photos'], "%7B%22" ) === 0
		&& ( strpos( "%22standard_resolution%22", $_POST['photos'] ) && strpos( "%22https://scontent.cdninstagram.com", $_POST['photos'] ) || ! strpos( "%22standard_resolution%22", $_POST['photos'] ) ) ) {

		$stripped_json_string = wp_strip_all_tags( $_POST['photos'] );
		set_transient( $transient_name, $stripped_json_string, $cache_seconds );

		$backups_enabled = isset( $sb_instagram_settings['sb_instagram_backup'] ) ? $sb_instagram_settings['sb_instagram_backup'] !== '' : true;

		if ( $backups_enabled ) {
			if ( strlen( $stripped_json_string ) > 1999 && strpos( $transient_name, 'sbi_header_' ) !== 0 ) {
				update_option( '!'.$transient_name, $stripped_json_string, false );
			} elseif ( strpos( $transient_name, 'sbi_header_' ) === 0 ) {
				update_option( '!'.$transient_name, $stripped_json_string, false  );
			}
		}

	}

	if ( strlen( $stripped_json_string ) < 2000 && strpos( $transient_name, 'sbi_header_' ) !== 0 && get_option( '!'.$transient_name ) ) {
		echo 'too much filtering';
	}

	die();

}
add_action('wp_ajax_cache_photos', 'sbi_cache_photos');
add_action('wp_ajax_nopriv_cache_photos', 'sbi_cache_photos');

function sbi_set_expired_token() {
	$access_token = isset( $_POST['access_token'] ) ? sanitize_text_field( $_POST['access_token'] ) : false;

	if ( $access_token !== false ) {
		$expired_tokens = get_option( 'sb_expired_tokens', array() );
		if (! in_array( sbi_maybe_clean( $access_token ), $expired_tokens, true ) ) {
			$expired_tokens[] = sbi_maybe_clean( $access_token );
		}

		update_option( 'sb_expired_tokens', $expired_tokens, false );
	}

	die();
}
add_action('wp_ajax_sbi_set_expired_token', 'sbi_set_expired_token');
add_action('wp_ajax_nopriv_sbi_set_expired_token', 'sbi_set_expired_token');

function sbi_set_use_backup() {
	$sb_instagram_settings = get_option('sb_instagram_settings');
	$backups_enabled = isset( $sb_instagram_settings['sb_instagram_backup'] ) ? $sb_instagram_settings['sb_instagram_backup'] !== '' : true;
	$context = isset( $_POST['context'] ) ? sanitize_text_field( $_POST['context'] ) : 'use_backup';

	if ( $backups_enabled ) {
		$transient_name = $_POST['transientName'];

		if ( is_array( $transient_name ) ) {
			$transient_name = isset( $transient_name['feed'] ) ? sanitize_text_field( $transient_name['feed'] ) : 'sbi_other';
		}
		$backup_exists = get_option( '!' . $transient_name, false );

		if ( ! get_transient( '&' . $transient_name ) && $backup_exists !== false ) {
			set_transient( '&' . $transient_name, $context, 86400 );
		}

	}

	die();
}
add_action('wp_ajax_sbi_set_use_backup', 'sbi_set_use_backup');
add_action('wp_ajax_nopriv_sbi_set_use_backup', 'sbi_set_use_backup');

function sbi_encode_uri( $uri )
{
	$unescaped = array(
		'%2D'=>'-','%5F'=>'_','%2E'=>'.','%21'=>'!', '%7E'=>'~',
		'%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'
	);
	$reserved = array(
		'%3B'=>';','%2C'=>',','%2F'=>'/','%3F'=>'?','%3A'=>':',
		'%40'=>'@','%26'=>'&','%3D'=>'=','%2B'=>'+','%24'=>'$'
	);
	$score = array(
		'%23'=>'#'
	);

	return strtr( rawurlencode( $uri ), array_merge( $reserved,$unescaped,$score ) );
}

function sbi_get_cache() {
	$options = get_option( 'sb_instagram_settings' );

	$transient_names = json_decode(str_replace( array( '\"', "\\'" ), array( '"', "'" ), sanitize_text_field( $_POST['transientName'] ) ), true);
	$header_cache_data_transient_data = get_transient( $transient_names['header'] );
	$should_use_backup_header = isset( $_POST['useBackupHeader'] ) && sanitize_text_field( $_POST['useBackupHeader'] ) == 'true' ? true : false;
	$should_use_backup_feed = isset( $_POST['useBackupFeed'] ) && sanitize_text_field( $_POST['useBackupFeed'] ) == 'true' ? true : false;
	$feed_cache_transient_data = get_transient( $transient_names['feed'] );
	$warning_message_data = '';

	if ( ! empty( $feed_cache_transient_data ) ) {
		$feed_cache_data = $feed_cache_transient_data;
	} elseif ( ! isset( $options['check_api'] ) || $options['check_api'] === 'on' || $options['check_api'] === true ) {
		$feed_cache_data = '{%22error%22:%22tryfetch%22}';
	} else {
		$feed_cache_data = '{%22error%22:%22nocache%22}';
	}

	if ( $transient_names['comments'] === 'need' ) {
		$comment_cache_data = get_transient( 'sbinst_comment_cache' );
		$comment_cache_data = ! empty( $comment_cache_data ) ? sbi_encode_uri( $comment_cache_data ) : '{%22error%22:%22nocache%22}';
	} else {
		$comment_cache_data = '{%22error%22:%22nocache%22}';
	}

	// maybe use backup cache
	$still_using_backup = get_transient( '&'.$transient_names['feed'], false );
	$doing_tryfetch = (isset( $options['check_api'] ) && $options['check_api'] === 'on' || $options['check_api']);
	if ( ! empty( $header_cache_data_transient_data ) ) {
		$header_cache_data = $header_cache_data_transient_data;
	} elseif ( $doing_tryfetch ) {
		$header_cache_data = '{%22error%22:%22tryfetch%22}';
	} elseif ( empty( $header_cache_data_transient_data ) || $still_using_backup ) {
		$backup_header_cache = get_option( '!' . $transient_names['header'] );
		$header_cache_data = ! empty( $backup_header_cache ) ? $backup_header_cache : '{%22error%22:%22nocache%22}';
		if ( $still_using_backup === 'falsecache' ) {
			$warning_message_data = ',%22warning%22:{%22warning%22:%22falsecache%22}';
		}
	} else {
		$header_cache_data = ! empty( $header_cache_data ) ? $header_cache_data : '{%22error%22:%22nocache%22}';
	}

	// maybe use backup cache
	if ( (empty( $feed_cache_transient_data ) && $should_use_backup_feed) || $still_using_backup ) {
		$backup_feed_cache = get_option( '!' . $transient_names['feed'] );
		$feed_cache_data = ! empty( $backup_feed_cache ) ? $backup_feed_cache : $feed_cache_data;
		if ( $still_using_backup === 'falsecache' ) {
			$warning_message_data = ',%22warning%22:{%22warning%22:%22falsecache%22}';
		}
	}

	$data = '{%22header%22:' . $header_cache_data .',%22feed%22:' . $feed_cache_data . ',%22comments%22:' . $comment_cache_data . $warning_message_data . '}';

	echo $data;

    die();
}
add_action('wp_ajax_get_cache', 'sbi_get_cache');
add_action('wp_ajax_nopriv_get_cache', 'sbi_get_cache');

function sbi_get_mod_mode_block_users( $post_block_users ) {
	$remove_users = array();

	if ( is_array( $post_block_users ) ) {
		foreach ( $post_block_users as $user ) {
			$remove_users[] = sanitize_text_field( $user );
		}
	}

	return $remove_users;
}

function sbi_update_mod_mode_settings() {
	if ( current_user_can( 'edit_posts' ) ) {
		$sb_instagram_settings = get_option( 'sb_instagram_settings' );
		$remove_ids = array();

		// append new id to remove id list if unique
		foreach ( $_POST['ids'] as $id ) {
			$remove_ids[] = sanitize_text_field( $id );
		}

		// get the array of blocked users
		$remove_users = sbi_get_mod_mode_block_users( $_POST['blocked_users'] );

		// save the new setting as string
		$sb_instagram_settings['sb_instagram_hide_photos'] = implode( ', ', $remove_ids );
		$sb_instagram_settings['sb_instagram_block_users'] = implode( ', ', $remove_users );

		update_option( 'sb_instagram_settings', $sb_instagram_settings );
	}
	die();
}
add_action('wp_ajax_sbi_update_mod_mode_settings', 'sbi_update_mod_mode_settings');

function sbi_update_mod_mode_white_list() {
	if ( current_user_can( 'edit_posts' ) ) {
		$white_index = sanitize_text_field( $_POST['db_index'] );
		$permanent = isset( $_POST['permanent'] ) && $_POST['permanent'] == 'true' ? true : false;
		$current_white_names = get_option( 'sb_instagram_white_list_names', array() );

		if ( $white_index == '' ) {
			$new_index = count( $current_white_names ) + 1;

			while ( in_array( $new_index, $current_white_names ) ) {
				$new_index++;
			}
			$white_index = (string)$new_index;

			// user doesn't know the new name so echo it out here and add a message
			echo $white_index;
		}

		$white_list_name = 'sb_instagram_white_lists_'.$white_index;
		$white_ids = array();

		// append new id to remove id list if unique
		if ( isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {

			foreach ( $_POST['ids'] as $id ) {
				$white_ids[] = sanitize_text_field( $id );
			}

			update_option( $white_list_name, $white_ids, false  );
		}

		// update white list names
		if ( ! in_array( $white_index, $current_white_names ) ) {
			$current_white_names[] = $white_index;
			update_option( 'sb_instagram_white_list_names', $current_white_names, false  );
		}

		$sb_instagram_settings = get_option( 'sb_instagram_settings', array() );

		if ( isset( $_POST['blocked_users'] ) ) {
			$remove_users = sbi_get_mod_mode_block_users( $_POST['blocked_users'] );
		} else {
			$remove_users = array();
		}

		$sb_instagram_settings['sb_instagram_block_users'] = implode( ', ', $remove_users );
		update_option( 'sb_instagram_settings', $sb_instagram_settings );

		$permanent_white_lists = get_option( 'sb_permanent_white_lists', array() );

		if ( $permanent ) {
			if ( ! in_array( $white_index, $permanent_white_lists, true ) ) {
				$permanent_white_lists[] = $white_index;
			}
			update_option( 'sb_permanent_white_lists', $permanent_white_lists, false  );
		} else {
			if ( in_array( $white_index, $permanent_white_lists, true ) ) {
				$update_wl = array();
				foreach ( $permanent_white_lists as $wl ) {
					if ( $wl !== $white_index ) {
						$update_wl[] = $wl;
					}
				}
				update_option( 'sb_permanent_white_lists', $update_wl, false  );
			}
		}

		sb_instagram_cron_clear_cache();

		set_transient( 'sb_wlupdated_'.$white_index, 'true', 3600 );
	}

	die();

}
add_action('wp_ajax_sbi_update_mod_mode_white_list', 'sbi_update_mod_mode_white_list');

function sbi_clear_white_lists() {
	global $wpdb;
	$table_name = $wpdb->prefix . "options";
	$result = $wpdb->query("
    DELETE
    FROM $table_name
    WHERE `option_name` LIKE ('%sb_instagram_white_lists_%')
    ");
	$result = $wpdb->query("
    DELETE
    FROM $table_name
    WHERE `option_name` LIKE ('%sb_wlupdated_%')
    ");
	delete_option( 'sb_instagram_white_list_names' );
	delete_option( 'sb_permanent_white_lists' );
	return $result;

	die();
}
add_action( 'wp_ajax_sbi_clear_white_lists', 'sbi_clear_white_lists' );

function sbi_disable_permanent_white_lists() {
	delete_option( 'sb_permanent_white_lists' );
	die();
}
add_action( 'wp_ajax_sbi_disable_permanent_white_lists', 'sbi_disable_permanent_white_lists' );

function sbi_clear_comment_cache() {

	if ( delete_transient( 'sbinst_comment_cache' ) ) {
		return true;
	} elseif ( ! get_transient( 'sbinst_comment_cache' ) ) {
		return true;
	}

	die();
}
add_action( 'wp_ajax_sbi_clear_comment_cache', 'sbi_clear_comment_cache' );

function sbi_maybe_clean( $maybe_dirty ) {
	if ( substr_count ( $maybe_dirty , '.' ) < 3 ) {
		return $maybe_dirty;
	}

	$parts = explode( '.', trim( $maybe_dirty ) );
	$last_part = $parts[2] . $parts[3];
	$cleaned = $parts[0] . '.' . base64_decode( $parts[1] ) . '.' . base64_decode( $last_part );

	return $cleaned;
}
function sbi_get_parts( $whole ) {
	if ( substr_count ( $whole , '.' ) !== 2 ) {
		return $whole;
	}

	$parts = explode( '.', trim( $whole ) );
	$return = $parts[0] . '.' . base64_encode( $parts[1] ). '.' . base64_encode( $parts[2] );

	return substr( $return, 0, 40 ) . '.' . substr( $return, 40, 100 );
}

//sbi_clear_backups
function sbi_clear_backups() {
	if ( current_user_can( 'edit_posts' ) ) {
		//Delete all transients
		global $wpdb;
		$table_name = $wpdb->prefix . "options";
		$wpdb->query( "
        DELETE
        FROM $table_name
        WHERE `option_name` LIKE ('%!sbi\_%')
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
	}
	die();
}
add_action( 'wp_ajax_sbi_clear_backups', 'sbi_clear_backups' );

function sbi_update_comment_cache() {

	$post_id = str_replace( 'sbi_', '', sanitize_text_field( $_POST['post_id'] ) );
	$comments_arr = isset( $_POST['comments'] ) ? $_POST['comments'] : array();

	$comments_count = sanitize_text_field( $_POST['total_comments'] );

	$sanitized_comments_arr = array();

	foreach ( $comments_arr as $comment ) {
		$sanitized_single_comment_arr = array();

		foreach ( $comment as $comment_prop_key => $comment_prop_value ) {
			$sanitized_single_comment_arr[$comment_prop_key] = sanitize_text_field( $comment_prop_value );
		}

		$sanitized_comments_arr[] = $sanitized_single_comment_arr;
	}

	$comment_cache = json_decode( get_transient( 'sbinst_comment_cache', array() ), $assoc = true );

	if ( ! isset( $comment_cache[$post_id] ) && count( $comment_cache ) >= 200 ) {
		array_shift( $comment_cache );
	}

	$comment_cache[$post_id] = array( $sanitized_comments_arr, time() + (15 * 60), $comments_count );

	set_transient( 'sbinst_comment_cache', json_encode( $comment_cache ), 0 );

	die();
}
add_action( 'wp_ajax_sbi_update_comment_cache', 'sbi_update_comment_cache' );
add_action( 'wp_ajax_nopriv_sbi_update_comment_cache', 'sbi_update_comment_cache' );

function sbi_cancel_custom_image_sizing() {
	echo 'Custom Image Sizes No Longer Available';
	delete_option( 'sb_instagram_using_custom_sizes' );
	die();
}
add_action( 'wp_ajax_sbi_cancel_custom_image_sizing', 'sbi_cancel_custom_image_sizing' );
add_action( 'wp_ajax_nopriv_sbi_cancel_custom_image_sizing', 'sbi_cancel_custom_image_sizing' );

function sbi_get_comment_cache() {

	$comment_cache = get_transient( 'sbinst_comment_cache', false );

	if ( $comment_cache ) {
		echo $comment_cache;
	} else {
		echo '{}';
	}

	die();
}
add_action( 'wp_ajax_sbi_get_comment_cache', 'sbi_get_comment_cache' );
add_action( 'wp_ajax_nopriv_sbi_get_comment_cache', 'sbi_get_comment_cache' );


//Enqueue scripts
add_action( 'wp_enqueue_scripts', 'sb_instagram_scripts_enqueue' );
function sb_instagram_scripts_enqueue() {
    //Register the script to make it available

    //Options to pass to JS file
    $sb_instagram_settings = get_option('sb_instagram_settings');

	if ( isset( $sb_instagram_settings['enqueue_js_in_head'] ) && $sb_instagram_settings['enqueue_js_in_head'] ) {
		wp_enqueue_script( 'sb_instagram_scripts', plugins_url( '/js/sb-instagram.js' , __FILE__ ), array('jquery'), SBIVER, false );
	} else {
		wp_register_script( 'sb_instagram_scripts', plugins_url( '/js/sb-instagram.js' , __FILE__ ), array('jquery'), SBIVER, true );
	}

	if ( isset( $sb_instagram_settings['enqueue_css_in_shortcode'] ) && $sb_instagram_settings['enqueue_css_in_shortcode'] ) {
		wp_register_style( 'sb_instagram_styles', plugins_url('/css/sb-instagram.css', __FILE__), array(), SBIVER );
	} else {
		wp_enqueue_style( 'sb_instagram_styles', plugins_url('/css/sb-instagram.css', __FILE__), array(), SBIVER );
	}

	$font_method = isset( $sb_instagram_settings['sbi_font_method'] ) ? $sb_instagram_settings['sbi_font_method'] : 'svg';
	$disable_font_awesome = isset($sb_instagram_settings['sb_instagram_disable_font']) ? $sb_instagram_settings['sb_instagram_disable_font'] : false;

	if ( $font_method === 'fontfile' && ! $disable_font_awesome ) {
		wp_enqueue_style( 'sb-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	}

	//Hide photos
    isset($sb_instagram_settings[ 'sb_instagram_hide_photos' ]) ? $sb_instagram_hide_photos = trim($sb_instagram_settings['sb_instagram_hide_photos']) : $sb_instagram_hide_photos = '';

    //Block users
    isset($sb_instagram_settings[ 'sb_instagram_block_users' ]) ? $sb_instagram_block_users = trim($sb_instagram_settings['sb_instagram_block_users']) : $sb_instagram_block_users = '';

    //Access token
    isset($sb_instagram_settings[ 'sb_instagram_at' ]) ? $sb_instagram_at = trim($sb_instagram_settings['sb_instagram_at']) : $sb_instagram_at = '';
	$br_adjust = isset( $sb_instagram_settings['sbi_br_adjust'] ) && ($sb_instagram_settings['sbi_br_adjust'] == 'false' || $sb_instagram_settings['sbi_br_adjust'] == '0' || $sb_instagram_settings['sbi_br_adjust'] == false) ? false : true;
	$highlight_ids = isset( $sb_instagram_settings['sb_instagram_highlight_ids'] ) ? str_replace( array( ' ', 'sbi_' ), '', $sb_instagram_settings['sb_instagram_highlight_ids'] ) : '';

	$data = array(
        'sb_instagram_at' => sbi_get_parts( $sb_instagram_at ),
        'sb_instagram_hide_photos' => $sb_instagram_hide_photos,
        'sb_instagram_block_users' => $sb_instagram_block_users,
        'highlight_ids' => $highlight_ids,
        'font_method' => $font_method,
		'br_adjust' => $br_adjust
	);

	if (isset($sb_instagram_settings[ 'sb_instagram_disable_mob_swipe' ]) && $sb_instagram_settings[ 'sb_instagram_disable_mob_swipe' ]) {
		$data['no_mob_swipe'] = true;
	}

    //Pass option to JS file
    wp_localize_script('sb_instagram_scripts', 'sb_instagram_js_options', $data);

	$locale = get_locale();
	$translation_array = array(
		'Share' => __( 'Share', 'instagram-feed' ),
		'DATE_FORMAT' => isset( $locale ) ? str_replace( '_', '-', $locale ) : 'en-US',
		'Jan' => date_i18n( 'M', 1515974400 ),
		'Feb' => date_i18n( 'M', 1518652800 ),
		'Mar' => date_i18n( 'M', 1521072000 ),
		'Apr' => date_i18n( 'M', 1523750400 ),
		'May' => date_i18n( 'M', 1526342400 ),
		'Jun' => date_i18n( 'M', 1529020800 ),
		'Jul' => date_i18n( 'M', 1531612800 ),
		'Aug' => date_i18n( 'M', 1534291200 ),
		'Sep' => date_i18n( 'M', 1536969600 ),
		'Oct' => date_i18n( 'M', 1539561600 ),
		'Nov' => date_i18n( 'M', 1542240000 ),
		'Dec' => date_i18n( 'M', 1544832000 ),
	);

	wp_localize_script( 'sb_instagram_scripts', 'sbiTranslations', $translation_array );
}

if ( ! function_exists( 'sb_remove_style_version' ) ) {
	function sb_remove_style_version( $src, $handle ){

		if ( $handle === 'sb-font-awesome' ) {
			$parts = explode( '?ver', $src );
			return $parts[0];
		} else {
			return $src;
		}

	}
	add_filter( 'style_loader_src', 'sb_remove_style_version', 15, 2 );
}

if ( ! function_exists( 'sb_remove_script_version' ) ) {
	function sb_remove_script_version( $src, $handle ){

		if ( $handle === 'sb-font-awesome-scripts' ) {
			$parts = explode( '?ver', $src );
			return $parts[0];
		} else {
			return $src;
		}

	}
	add_filter( 'script_loader_src', 'sb_remove_script_version', 15, 2 );
}

//Dismiss frontend notices
function sbi_dismiss_frontend_notices() {
    update_option( 'sb_instagram_hide_notices', true );
    die();
}
add_action( 'wp_ajax_sbi_dismiss_frontend_notices', 'sbi_dismiss_frontend_notices' );
add_action( 'wp_ajax_nopriv_sbi_dismiss_frontend_notices', 'sbi_dismiss_frontend_notices' );

// Load plugin textdomain
add_action( 'init', 'sb_instagram_load_textdomain' );
function sb_instagram_load_textdomain() {
	load_plugin_textdomain('instagram-feed', false, basename( dirname(__FILE__) ) . '/languages');
}

//Custom CSS
add_action( 'wp_head', 'sb_instagram_custom_css' );
function sb_instagram_custom_css() {
    $options = get_option('sb_instagram_settings');

    isset($options[ 'sb_instagram_custom_css' ]) ? $sb_instagram_custom_css = trim($options['sb_instagram_custom_css']) : $sb_instagram_custom_css = '';

    //Show CSS if an admin (so can see Hide Photos link), if including Custom CSS or if hiding some photos
    ( current_user_can( 'edit_posts' ) || !empty($sb_instagram_custom_css) || !empty($sb_instagram_hide_photos) ) ? $sbi_show_css = true : $sbi_show_css = false;

    if( $sbi_show_css ) echo '<!-- Instagram Feed CSS -->';
    if( $sbi_show_css ) echo "\r\n";
    if( $sbi_show_css ) echo '<style type="text/css">';

    if( !empty($sb_instagram_custom_css) ){
        echo "\r\n";
        echo stripslashes($sb_instagram_custom_css);
    }

    if( current_user_can( 'edit_posts' ) ){
        echo "\r\n";
        echo "#sbi_mod_link, #sbi_mod_error{ display: block !important; }";
    }

    if( $sbi_show_css ) echo "\r\n";
    if( $sbi_show_css ) echo '</style>';
    if( $sbi_show_css ) echo "\r\n";
}

//Custom JS
add_action( 'wp_footer', 'sb_instagram_custom_js' );
function sb_instagram_custom_js() {
    $options = get_option('sb_instagram_settings');
    isset($options[ 'sb_instagram_custom_js' ]) ? $sb_instagram_custom_js = trim($options['sb_instagram_custom_js']) : $sb_instagram_custom_js = '';

    echo '<!-- Instagram Feed JS -->';
    echo "\r\n";
    echo '<script type="text/javascript">';
    echo "\r\n";
    echo 'var sbiajaxurl = "' . admin_url('admin-ajax.php') . '";';

    if( !empty($sb_instagram_custom_js) ) echo "\r\n";
    if( !empty($sb_instagram_custom_js) ) echo "jQuery( document ).ready(function($) {";
    if( !empty($sb_instagram_custom_js) ) echo "\r\n";
    if( !empty($sb_instagram_custom_js) ) echo "window.sbi_custom_js = function(){";
    if( !empty($sb_instagram_custom_js) ) echo "\r\n";
    if( !empty($sb_instagram_custom_js) ) echo stripslashes($sb_instagram_custom_js);
    if( !empty($sb_instagram_custom_js) ) echo "\r\n";
    if( !empty($sb_instagram_custom_js) ) echo "}";
    if( !empty($sb_instagram_custom_js) ) echo "\r\n";
    if( !empty($sb_instagram_custom_js) ) echo "});";

    echo "\r\n";
    echo '</script>';
    echo "\r\n";

}
?>