jQuery(document).ready(function($) {

	//Autofill the token and id
	var hash = window.location.hash,
        token = hash.substring(14),
        id = token.split('.')[0];

	if (token.length > 40) {
	    //https://api.instagram.com/v1/users/self/?access_token=' . sbi_maybe_clean( $access_token )
        $('.sbi_admin_btn').css('opacity','.5').after('<div class="spinner" style="visibility: visible; position: relative;float: left;margin-top: 15px;"></div>');
        var url = 'https://api.instagram.com/v1/users/self/?access_token=' + token;
        jQuery.ajax({
            method: "GET",
            url: url,
            success: function(data) {
                $('.sbi_admin_btn').css('opacity','1');
                $('#sbi_config').find('.spinner').remove();
                if (!$('.sbi_connected_account ').length) {
                    $('.sbi_no_accounts').remove();
                    sbSaveToken(token,true);
                } else {
                    var buttonText = 'Connect This Account';
                    // if the account is connected, offer to update in case information has changed.
                    if ($('#sbi_connected_account_'+id).length) {
                        buttonText = 'Update This Account';
                    }
                    $('#sbi_config').append('<div id="sbi_config_info" class="sb_get_token">' +
                        '<div class="sbi_config_modal">' +
                        '<img class="sbi_ca_avatar" src="'+data.data.profile_picture+'" />' +
                        '<div class="sbi_ca_username"><strong>'+data.data.username+'</strong></div>' +
                        '<p class="sbi_submit"><input type="submit" name="sbi_submit" id="sbi_connect_account" class="button button-primary" value="'+buttonText+'">' +
                        '<a href="JavaScript:void(0);" class="button button-secondary" id="sbi_switch_accounts">Switch Accounts</a></p>' +
                        '<a href="JavaScript:void(0);"><i class="sbi_modal_close fa fa-times"></i></a>' +
                        '</div>' +
                        '</div>');

                    $('#sbi_connect_account').click(function(event) {
                        event.preventDefault();
                        $('#sbi_config_info').fadeOut(200);
                        sbSaveToken(token,false);
                    });

                    sbiSwitchAccounts();
                }

            },
            error: function(data) {
                $('.sbi_admin_btn').css('opacity','1');
                $('#sbi_config').find('.spinner').remove();
                var message = typeof data.responseJSON !== 'undefined' && data.responseJSON.error_type === 'OAuthRateLimitException' ? 'This account\'s access token is currently over the rate limit. Try removing this access token from all feeds and wait an hour before reconnecting.' : 'There was an error connecting your account';

                $('#sbi_config').append('<div id="sbi_config_info" class="sb_get_token">' +
                    '<div class="sbi_config_modal">' +
                    '<p>'+message+'</p>' +
                    '<p class="sbi_submit"><a href="JavaScript:void(0);" class="button button-secondary" id="sbi_switch_accounts">Switch Accounts</a></p>' +
                    '<a href="JavaScript:void(0);"><i class="sbi_modal_close fa fa-times"></i></a>' +
                    '</div>' +
                    '</div>');

                sbiSwitchAccounts();
            }
        });

        function sbiSwitchAccounts(){
            $('#sbi_switch_accounts').on('click', function(){
                //Log user out of Instagram by hitting the logout URL in an iframe
                $('body').append('<iframe style="display: none;" src="https://www.instagram.com/accounts/logout"></iframe>');

                $(this).text('Please wait...').after('<div class="spinner" style="visibility: visible; float: none; margin: -3px 0 0 3px;"></div>');

                //Wait a couple seconds for the logout to occur, then connect a new account
                setTimeout(function(){
                    window.location.href = $('.sbi_admin_btn').attr('href');
                }, 2000);
            });

            $('.sbi_modal_close').on('click', function(){
                $('#sbi_config_info').remove();
            });
        }

        window.location.hash = '';        
    }

    function sbiAfterUpdateToken(savedToken,saveID){
	    if (saveID) {
	        sbSaveID(savedToken.user_id);
            $('.sbi_user_feed_ids_wrap').prepend(
                '<div id="sbi_user_feed_id_'+savedToken.user_id+'" class="sbi_user_feed_account_wrap">'+
                '<strong>'+savedToken.username+'</strong> <span>('+savedToken.user_id+')</span>' +
                '<input type="hidden" name="sb_instagram_user_id[]" value="'+savedToken.user_id+'">' +
                '</div>'
            );
        }
        if ($('#sbi_connected_account_'+savedToken.user_id).length) {
            if (savedToken.is_valid) {
                $('#sbi_connected_account_'+savedToken.user_id).addClass('sbi_account_updated');
            } else {
                $('#sbi_connected_account_'+savedToken.user_id).addClass('sbi_account_invalid');
            }
            $('#sbi_connected_account_'+savedToken.user_id).attr('data-accesstoken',savedToken.access_token);
            $('#sbi_connected_account_'+savedToken.user_id).find('.sbi_ca_accesstoken .sbi_ca_token').text(savedToken.access_token);
            $('#sbi_connected_account_'+savedToken.user_id).find('.sbi_tooltip code').text('[instagram-feed accesstoken="'+savedToken.access_token+'"]');
            $('#sbi_connected_account_'+savedToken.user_id).find('.sbi_ca_at_is_valid span').text('Last Tested: Now');
        } else {
	        var removeOrSaveHTML = saveID ? '<a href="JavaScript:void(0);" class="sbi_remove_from_user_feed button-primary"><i class="fa fa-minus-circle" aria-hidden="true"></i>Remove from Primary Feed</a>' : '<a href="JavaScript:void(0);" class="sbi_use_in_user_feed button-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add to Primary Feed</a>',
                statusClass = saveID ? 'sbi_account_active' : 'sbi_account_updated',
                html = '<div class="sbi_connected_account '+statusClass+'" id="sbi_connected_account_'+savedToken.user_id+'" data-accesstoken="'+savedToken.access_token+'" data-userid="'+savedToken.user_id+'" data-username="'+savedToken.username+'">'+
                '<div class="sbi_ca_info">'+

                    '<div class="sbi_ca_delete">'+
                        '<a href="JavaScript:void(0);" class="sbi_delete_account"><i class="fa fa-times"></i><span class="sbi_remove_text">Remove</span></a>'+
                    '</div>'+

                    '<div class="sbi_ca_username">'+
                        '<img class="sbi_ca_avatar" src="'+savedToken.profile_picture+'" />'+
                        '<strong>'+savedToken.username+'</strong>'+
                    '</div>'+

                    '<div class="sbi_ca_actions">'+
                        removeOrSaveHTML +
                        '<a class="sbi_ca_token_shortcode button-secondary" href="JavaScript:void(0);"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i>Add to another Feed</a>'+
                        '<p class="sbi_ca_show_token"><input type="checkbox" id="sbi_ca_show_token_'+savedToken.user_id+'" /><label for="sbi_ca_show_token_'+savedToken.user_id+'">Show Access Token</label></p>'+
                    '</div>'+

                    '<div class="sbi_ca_shortcode">'+
                        '<p>Copy and paste this shortcode into your page or widget area:<br>'+
                        '<code>[instagram-feed user="'+savedToken.username+'"]</code>'+
                        '</p>'+
                        '<p>To add multiple users in the same feed, simply separate them using commas:<br>'+
                        '<code>[instagram-feed user="'+savedToken.username+', a_second_user, a_third_user"]</code>'+
                        '<p>Click on the <a href="?page=sb-instagram-feed&tab=display" target="_blank">Display Your Feed</a> tab to learn more about shortcodes</p>'+
                    '</div>'+

                    '<div class="sbi_ca_accesstoken">' +
                    '<span class="sbi_ca_token_label">Access Token:</span><input type="text" class="sbi_ca_token" value="'+savedToken.access_token+'" readonly="readonly" onclick="this.focus();this.select()" title="To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac).">' +
                    '</div>' +

                '</div>'+
            '</div>';
            $('.sbi_connected_accounts_wrap').prepend(html);
        }
    }

    function sbSaveToken(token,saveID) {
        $('.sbi_connected_accounts_wrap').fadeTo("slow" , 0.5);
        jQuery.ajax({
            url: sbiA.ajax_url,
            type: 'post',
            data: {
                action: 'sbi_auto_save_tokens',
                access_token: token,
                just_tokens: true,
                sbi_nonce: sbiA.sbi_nonce
            },
            success: function (data) {
                var savedToken = JSON.parse(data);
                $('.sbi_connected_accounts_wrap').fadeTo("slow" , 1);
                sbiAfterUpdateToken(savedToken,saveID);
            }
        });
    }

    function sbSaveID(ID) {
        jQuery.ajax({
            url: sbiA.ajax_url,
            type: 'post',
            data: {
                action: 'sbi_auto_save_id',
                id: ID,
                just_tokens: true,
                sbi_nonce: sbiA.sbi_nonce
            },
            success: function (data) {
            }
        });
    }

    // connect accounts
    $('.sbi_manually_connect_wrap').hide();
    $('.sbi_manually_connect').click(function(event) {
        event.preventDefault();
        if ( $('.sbi_manually_connect_wrap').is(':visible') ) {
            $('.sbi_manually_connect_wrap').slideUp(200);
        } else {
            $('.sbi_manually_connect_wrap').slideDown(200);
            $('#sb_manual_at').focus();
        }
    });
    var $body = $('body');
    $body.on('click', '.sbi_remove_from_user_feed, .sbi_use_in_user_feed, .sbi_test_token, .sbi_delete_account *, .sbi_ca_token_shortcode', function (event) {
        event.preventDefault();
        var $clicked = $(event.target),
            accessToken = $clicked.closest('.sbi_connected_account').attr('data-accesstoken'),
            action = false,
            atParts = accessToken.split('.'),
            username = $clicked.closest('.sbi_connected_account').attr('data-username');

        if ($clicked.hasClass('sbi_remove_from_user_feed')) {
            $clicked.removeClass('sbi_remove_from_user_feed');
            $clicked.addClass('sbi_use_in_user_feed');
            $clicked.closest('.sbi_connected_account').removeClass('sbi_account_active');
            $clicked.html('<i class="fa fa-plus-circle" aria-hidden="true"></i>Add to Primary Feed');
            $('#sbi_user_feed_id_'+atParts[0]).remove();
        } else if ($clicked.hasClass('sbi_use_in_user_feed')) {
            $clicked.removeClass('sbi_use_in_user_feed');
            $clicked.addClass('sbi_remove_from_user_feed');
            $clicked.closest('.sbi_connected_account').removeClass('sbi_account_updated');
            $clicked.closest('.sbi_connected_account').addClass('sbi_account_active');
            $clicked.html('<i class="fa fa-minus-circle" aria-hidden="true" style="margin-right: 5px;"></i>Remove from Primary Feed');
            var name = '<strong>'+atParts[0]+'</strong>';
            if (username !== '') {
                name = '<strong>'+username+'</strong> <span>('+atParts[0]+')</span>';
            }
            $('.sbi_user_feed_ids_wrap').prepend(
                '<div id="sbi_user_feed_id_'+atParts[0]+'" class="sbi_user_feed_account_wrap">'+
                name +
                '<input type="hidden" name="sb_instagram_user_id[]" value="'+atParts[0]+'">' +
                '</div>'
            );
        } else if ($clicked.parent().hasClass('sbi_delete_account')) {
            if (window.confirm("Delete this connected account?")) {
                action = 'sbi_delete_account';
                $('#sbi_user_feed_id_' + atParts[0] + ',#sbi_connected_account_' + atParts[0]).remove();
                jQuery.ajax({
                    url: sbiA.ajax_url,
                    type: 'post',
                    data: {
                        action: action,
                        access_token: accessToken,
                        sbi_nonce: sbiA.sbi_nonce
                    },
                    success: function (data) {
                        console.log(data);
                    }
                });
            }
        } else if ($clicked.hasClass('sbi_ca_token_shortcode')) {
            jQuery(this).closest('.sbi_ca_info').find('.sbi_ca_shortcode').slideToggle(200);
        } //

    });

    $body.on('change', '.sbi_ca_show_token input[type=checkbox]', function(event) {
        jQuery(this).closest('.sbi_ca_info').find('.sbi_ca_accesstoken').slideToggle(200);
    });

    $('#sbi_manual_submit').click(function(event) {
        event.preventDefault();
        var $self = $(this);
        var accessToken = $('#sb_manual_at').val();
        if (accessToken.length < 15) {
            if (!$('.sbi_manually_connect_wrap').find('.sbi_user_id_error').length) {
                $('.sbi_manually_connect_wrap').show().prepend('<div class="sbi_user_id_error" style="display:block;">Please enter a valid access token</div>');
            }
        } else {
            $(this).attr('disabled',true);
            $(this).closest('.sbi_manually_connect_wrap').fadeOut();
            $('.sbi_connected_accounts_wrap').fadeTo("slow" , 0.5).find('.sbi_user_id_error').remove();

            jQuery.ajax({
                url: sbiA.ajax_url,
                type: 'post',
                data: {
                    action: 'sbi_test_token',
                    access_token: accessToken,
                    sbi_nonce: sbiA.sbi_nonce
                },
                success: function (data) {
                    $('.sbi_connected_accounts_wrap').fadeTo("slow" , 1);
                    $self.removeAttr('disabled');
                    if ( data.indexOf('{') > -1) {
                        var savedToken = JSON.parse(data);
                        $(this).closest('.sbi_manually_connect_wrap').fadeOut();
                        $('#sb_manual_at').val('');
                        sbiAfterUpdateToken(savedToken,false);
                    } else {
                        $('.sbi_manually_connect_wrap').show().prepend('<div class="sbi_user_id_error" style="display:block;">'+data+'</div>');
                    }

                }
            });
        }

    });

    //clear backup caches
    jQuery('#sbi_clear_backups').click(function(event) {
        jQuery('.sbi-success').remove();
        event.preventDefault();
        jQuery.ajax({
            url: sbiA.ajax_url,
            type: 'post',
            data: {
                action: 'sbi_clear_backups',
                access_token: token,
                just_tokens: true,
                sbi_nonce: sbiA.sbi_nonce
            },
            success: function (data) {
                jQuery('#sbi_clear_backups').after('<span class="sbi-success"><i class="fa fa-check-circle"></i></span>');
            }
        });
    });
	
	//Tooltips
	jQuery('#sbi_admin .sbi_tooltip_link').click(function(){
		jQuery(this).siblings('.sbi_tooltip').slideToggle();
	});

    // custom image sizes
    jQuery('#sb_instagram_using_custom_sizes').click(function(){
        var $wrap = jQuery(this).closest('td');
        if (jQuery(this).is(':checked')) {
            jQuery(this).closest('p').siblings('.sbi_extra_info').slideDown();
            $wrap.find('#sb_custom_res_settings').attr('name','sb_instagram_image_res').slideDown();
            $wrap.find('#sb_standard_res_settings').attr('name','').css('opacity',.5);
        } else {
            jQuery(this).closest('p').siblings('.sbi_extra_info').slideUp();
            $wrap.find('#sb_standard_res_settings').attr('name','sb_instagram_image_res').css('opacity',1);;
            $wrap.find('#sb_custom_res_settings').attr('name','').slideUp();
        }
    });

    //Extra Info
  function sbiToggleInfo(elem) {
    if(elem.is(':checked')) {
      elem.siblings('.sbi_extra_info').slideDown();
    } else {
      elem.siblings('.sbi_extra_info').slideUp();
    }
  }
  sbiToggleInfo(jQuery('#sbi_admin #sb_instagram_moderation_mode'));
  jQuery('#sbi_admin #sb_instagram_moderation_mode').click(function(){
    sbiToggleInfo(jQuery(this));
  });

    //Update the shortcode when input is added
    function sbiToggleIncExCode(elem,type) {
    var str = elem.val();
    elem.siblings('.sbi_incex_shortcode').find('code').text(type+'="'+str+'"');
      if(jQuery('#sb_instagram_incex_one').is(':checked')){
          elem.siblings('.sbi_incex_shortcode').show();
      }
    }
    sbiToggleIncExCode(jQuery('#sbi_admin #sb_instagram_exclude_words'), 'excludewords');
    sbiToggleIncExCode(jQuery('#sbi_admin #sb_instagram_include_words'), 'includewords');
    jQuery('#sbi_admin #sb_instagram_exclude_words, #sbi_admin #sb_instagram_include_words').keyup(function(){
        if(jQuery(this).attr('id') == 'sb_instagram_exclude_words') {
            sbiToggleIncExCode(jQuery(this), 'excludewords');
        } else {
            sbiToggleIncExCode(jQuery(this), 'includewords');
        }
    });

    //Reveal or hide the shortcode generator
    function sbiToggleShortcodeGen($el) {
        if($el.is(':checked') && $el.val() === 'one'){
            $el.closest('td').find('.sbi_incex_shortcode').slideDown();
        } else {
            $el.closest('td').find('.sbi_incex_shortcode').slideUp();
        }
    }
    jQuery('.sb_instagram_incex_one_all').click(function() {
        sbiToggleShortcodeGen(jQuery(this));
        sbiToggleIncExCode(jQuery('#sbi_admin #sb_instagram_exclude_words'), 'excludewords');
        sbiToggleIncExCode(jQuery('#sbi_admin #sb_instagram_include_words'), 'includewords');
    });
    
    function sbiToggleVisualManual($el) {
        if ($el.is(':checked') && $el.val() === 'visual'){
            $el.closest('td').find('.sbi_tooltip').slideDown();
        } else {
            $el.closest('td').find('.sbi_tooltip').slideUp();
        }
        if ($el.is(':checked') && $el.val() === 'manual'){
            $('.sbi_mod_manual_settings').slideDown();
        } else if (jQuery('#sb_instagram_moderation_mode_visual').is(':checked')) {
            $('.sbi_mod_manual_settings').slideUp();
        }
    }
    jQuery('.sb_instagram_moderation_mode').click(function() {
        sbiToggleVisualManual(jQuery(this));
    });
    jQuery('.sb_instagram_moderation_mode').each(function() {
        sbiToggleVisualManual(jQuery(this));
    });
    jQuery('.sb_instagram_mobile_layout_setting').hide();
    jQuery('.sb_instagram_mobile_layout_reveal').click(function() {
        if (jQuery(this).siblings('.sb_instagram_mobile_layout_setting').is(':visible')) {
            jQuery(this).siblings('.sb_instagram_mobile_layout_setting').slideUp();
            jQuery(this).siblings('.sb_instagram_mobile_layout_reveal').html('Show Mobile Options');
        } else {
            jQuery(this).siblings('.sb_instagram_mobile_layout_setting').slideDown();
            jQuery(this).siblings('.sb_instagram_mobile_layout_reveal').html('Hide Mobile Options');
        }
    });
    jQuery('#sbi_show_advanced').hide();
    jQuery('.sbi_show_advanced_reveal').click(function() {
        if (jQuery('#sbi_show_advanced').is(':visible')) {
            jQuery('#sbi_show_advanced').slideUp();
        } else {
            jQuery('#sbi_show_advanced').slideDown();
        }
    });

    // clear white lists
    var $sbiClearWhiteListsButton = $('#sbi_admin #sbi_clear_white_lists'),
        $sbiClearPermanentWhiteListsButton = $('#sbi_admin #sbi_clear_permanent_white_lists');

    $sbiClearWhiteListsButton.click(function(event) {
        event.preventDefault();

        jQuery('#sbi-clear-cache-success').remove();
        jQuery(this).prop("disabled",true);

        $.ajax({
            url : sbiA.ajax_url,
            type : 'post',
            data : {
                action : 'sbi_clear_white_lists'
            },
            success : function(data) {
                $sbiClearWhiteListsButton.prop('disabled',false);
                if(!data===false) {
                    $sbiClearWhiteListsButton.after('<i id="sbi-clear-cache-success" class="fa fa-check-circle sbi-success"></i>');
                    jQuery('.sbi_white_list_names_wrapper span').fadeOut();
                } else {
                    $sbiClearWhiteListsButton.after('<span>error</span>');
                }
            }
        }); // ajax call
    }); // clear_white_lists click

    $sbiClearPermanentWhiteListsButton.click(function(event) {
        event.preventDefault();

        jQuery('#sbi-clear-cache-success').remove();
        jQuery(this).prop("disabled",true);

        $.ajax({
            url : sbiA.ajax_url,
            type : 'post',
            data : {
                action : 'sbi_disable_permanent_white_lists'
            },
            success : function(data) {
                $sbiClearPermanentWhiteListsButton.prop('disabled',false);
                $sbiClearPermanentWhiteListsButton.after('<i id="sbi-clear-cache-success" class="fa fa-check-circle sbi-success"></i>');
                jQuery('.sbi_white_list_perm span').fadeOut();
            }
        }); // ajax call
    }); // clear_permanent_white_lists click

    // clear white lists
    var $sbiClearCommentCacheButton = $('#sbi_admin #sbi_clear_comment_cache');

    $sbiClearCommentCacheButton.click(function(event) {
        event.preventDefault();

        jQuery('#sbi-clear-cache-success').remove();
        jQuery(this).prop("disabled",true);

        $.ajax({
            url : sbiA.ajax_url,
            type : 'post',
            data : {
                action : 'sbi_clear_comment_cache'
            },
            success : function(data) {
                $sbiClearCommentCacheButton.prop('disabled',false);
                if(!data===false) {
                    $sbiClearCommentCacheButton.after('<i id="sbi-clear-cache-success" class="fa fa-check-circle sbi-success"></i>');
                } else {
                    $sbiClearCommentCacheButton.after('<span>error</span>');
                }
            }
        }); // ajax call
    }); // clear_comment_cache click

  jQuery('#sbi_admin th label, #sbi_admin .sb_instagram_layout_setting label').click(function(){
    var $el = jQuery(this).parent();
    // if( $el.parent().hasClass('sb_instagram_layout_setting' ) ) $el = $el.parent();

    var $sbi_shortcode = $el.find('.sbi_shortcode');
    if($sbi_shortcode.is(':visible')){
      $el.find('.sbi_shortcode').css('display','none');
    } else {
      $el.find('.sbi_shortcode').css('display','block');
    }  
  });

  //Single post directions
  jQuery('#sbi_admin .sbi_single_directions .sbi_one, #sbi_admin .sbi_single_directions .sbi_two .sbi_click_area').click(function(){
    jQuery(this).closest('.sbi_row').find('.sbi_tooltip').slideToggle();
  });

  //Shortcode label on hover
  jQuery('#sbi_admin th, #sbi_admin .sb_instagram_layout_setting label').hover(function(){
    var $el = $el_title = jQuery(this);
    if( $el.parent().hasClass('sb_instagram_layout_setting' ) ) $el = $el.parent();

    if( $el.find('.sbi_shortcode').length > 0 ){
      $el.find('label').append('<code class="sbi_shortcode_symbol">[]</code>');
    }
  }, function(){
    jQuery(this).find('.sbi_shortcode_symbol').remove();
  });

  jQuery('#sbi_admin label').hover(function(){
    if( jQuery(this).siblings('.sbi_shortcode').length > 0 ){
      jQuery(this).attr('title', 'Click for shortcode option');
    }
   }, function(){});

  //Add the color picker
	if( jQuery('.sbi_colorpick').length > 0 ) jQuery('.sbi_colorpick').wpColorPicker();

  //Mobile width
  var sb_instagram_feed_width = jQuery('#sbi_admin #sb_instagram_width').val(),
      sb_instagram_width_unit = jQuery('#sbi_admin #sb_instagram_width_unit').val(),
      $sb_instagram_width_options = jQuery('#sbi_admin #sb_instagram_width_options');

  if (typeof sb_instagram_feed_width !== 'undefined') {

    //Show initially if a width is set
    if( (sb_instagram_feed_width.length > 1 && sb_instagram_width_unit == 'px') || (sb_instagram_feed_width !== '100' && sb_instagram_width_unit == '%') ) $sb_instagram_width_options.show();

    jQuery('#sbi_admin #sb_instagram_width, #sbi_admin #sb_instagram_width_unit').change(function(){
      sb_instagram_feed_width = jQuery('#sbi_admin #sb_instagram_width').val();
      sb_instagram_width_unit = jQuery('#sbi_admin #sb_instagram_width_unit').val();

      if( sb_instagram_feed_width.length < 2 || (sb_instagram_feed_width == '100' && sb_instagram_width_unit == '%') ) {
        $sb_instagram_width_options.slideUp();      
      } else {
        $sb_instagram_width_options.slideDown();
      }
    });

  }

  //Hide the location coordinates initially
  jQuery('#sbi_loc_radio_coordinates_opts').hide();

  var sbi_loc_type = 'id';
  //Toggle location id/coordinates options
  jQuery('#sbi_loc_radio_id, #sbi_loc_radio_coordinates').change(function(){
    if( jQuery('#sbi_loc_radio_id').is(':checked') ){
      jQuery('#sbi_loc_radio_id_opts').show();
      jQuery('#sbi_loc_radio_coordinates_opts').hide();
      sbi_loc_type = 'id';
    } else {
      jQuery('#sbi_loc_radio_coordinates_opts').show();
      jQuery('#sbi_loc_radio_id_opts').hide();
      sbi_loc_type = 'coordinates';
    }
  });

	//Add new location
	var sbiCoordinatesShow = false,
      $sb_instagram_coordinates_options = jQuery('#sb_instagram_coordinates_options');
  jQuery('#sb_instagram_new_coordinates').on('click', function(){
      if( sbiCoordinatesShow ){
          $sb_instagram_coordinates_options.hide();
          sbiCoordinatesShow = false;
      } else {
          $sb_instagram_coordinates_options.show();
          sbiCoordinatesShow = true;
      }
      
  });

  var $sb_instagram_coordinates = jQuery('#sb_instagram_coordinates'),
      sbi_coordinates = $sb_instagram_coordinates.val();
  $sb_instagram_coordinates.blur(function() {
      sbi_coordinates = $sb_instagram_coordinates.val();
  });

  jQuery('#sb_instagram_add_location').on('click', function(){
      if( sbi_coordinates.length > 0 ) sbi_coordinates = sbi_coordinates + ',';

      sbi_coordinates = sbi_coordinates + '(' + jQuery('#sb_instagram_lat').val() + ',' + jQuery('#sb_instagram_long').val() + ',' + jQuery('#sb_instagram_dist').val() + ')';
      $sb_instagram_coordinates.val( sbi_coordinates );

      //Clear fields
      jQuery('#sb_instagram_long').val('');
      jQuery('#sb_instagram_lat').val('');
      jQuery('#sb_instagram_loc_id').val('');
  });

  //Scroll to hash for quick links
  jQuery('#sbi_admin a').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : this.hash.slice(1);
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top
        }, 500);
        return false;
      }
    }
  });

  //Boxed header options
  var sb_instagram_header_style = $('#sb_instagram_header_style').val(),
    $sb_instagram_header_style_boxed_options = $('#sb_instagram_header_style_boxed_options');

  //Should we show anything initially?
    if(sb_instagram_header_style == 'boxed'){
        $sb_instagram_header_style_boxed_options.show();
    } else {
        $sb_instagram_header_style_boxed_options.hide();
    }

  //When page type is changed show the relevant item
  $('#sb_instagram_header_style').change(function(){
    sb_instagram_header_style = $('#sb_instagram_header_style').val();

    if( sb_instagram_header_style == 'boxed' ) {
      $sb_instagram_header_style_boxed_options.fadeIn();
    } else {
      $sb_instagram_header_style_boxed_options.fadeOut();
    }
  });

    //Support tab show video
    jQuery('#sbi-play-support-video').on('click', function(e){
        e.preventDefault();
        jQuery('#sbi-support-video').show().attr('src', jQuery('#sbi-support-video').attr('src')+'&amp;autoplay=1' );
    });

    function sbiUpdateLayoutTypeOptionsDisplay() {
        setTimeout(function(){
            jQuery('.sb_instagram_layout_settings').hide();
            jQuery('.sb_instagram_layout_settings.sbi_layout_type_'+jQuery('.sb_layout_type:checked').val()).show();
        }, 1);
    }
    sbiUpdateLayoutTypeOptionsDisplay();
    jQuery('.sb_layout_type').change(sbiUpdateLayoutTypeOptionsDisplay);

    function sbiUpdateHighlightOptionsDisplay() {
        jQuery('.sb_instagram_highlight_sub_options').hide();
        var selected = jQuery('#sb_instagram_highlight_type').val();

        if (selected === 'pattern') {
            jQuery('.sb_instagram_highlight_pattern').show();
        } else if (selected === 'id') {
            jQuery('.sb_instagram_highlight_ids').show();
        } else {
            jQuery('.sb_instagram_highlight_hashtag').show();
        }

    }
    sbiUpdateHighlightOptionsDisplay();
    jQuery('#sb_instagram_highlight_type').change(sbiUpdateHighlightOptionsDisplay);

    //Open/close the expandable option sections
    jQuery('.sbi-expandable-options').hide();
    jQuery('.sbi-expand-button a').on('click', function(e){
        e.preventDefault();
        var $self = jQuery(this);
        $self.parent().next('.sbi-expandable-options').toggle();
        if( $self.text().indexOf('Show') !== -1 ){
            $self.text( $self.text().replace('Show', 'Hide') );
        } else {
            $self.text( $self.text().replace('Hide', 'Show') );
        }
    });

    //Selecting a post layout
    jQuery('.sbi_layout_cell').click(function(){
        var $self = jQuery(this);
        $('.sb_layout_type').trigger('change');
        $self.addClass('sbi_layout_selected').find('.sb_layout_type').attr('checked', 'checked');
        $self.siblings().removeClass('sbi_layout_selected');
    });

});