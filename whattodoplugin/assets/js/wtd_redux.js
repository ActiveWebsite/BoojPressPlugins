var map_menu_selector;
jQuery(document).ready(function(){
	var map_menu_helper = jQuery('.map-page').attr('id');
	
	jQuery('.wtd_resorts_selector label').click(function(){
		var resort = jQuery(this).attr('data-resort');
		var place = jQuery(this).attr('data-place');
		if (!jQuery(this).hasClass('ui-state-active')){
			jQuery('.wtd_cat[data-resort="'+resort+'"][data-place="'+place+'"]').removeClass('button-primary');
			jQuery('.options_wtd_flag[data-place="'+place+'"]').parent().hide();
			jQuery('.resort_hide[data-place="'+place+'"]').hide();
			jQuery('.resort_flag[data-place="'+place+'"]').parent().parent().parent().css('display','table-row');
			jQuery(this).parent().find('.resort_selector').removeClass('ui-state-active');
			jQuery('[data-place="'+place+'"]:not(.resort_selector)').hide();
			jQuery(this).addClass('ui-state-active');
			jQuery('.resort_show').show();
			jQuery('#'+place+'_'+resort+'_first').show();
			jQuery('.'+place+'_'+resort+'_first').show();
			jQuery('#'+place+'_'+resort+'_firsst').show();
			jQuery('#'+place+'_'+resort+'_first [data-resort]').show();
			jQuery('#'+place+'_'+resort+'_firsst [data-resort]').show();
			if (jQuery(this).hasClass('map_resort') && !map_loaded.hasOwnProperty(resort)){
				
				var section = jQuery('.map-page').attr('id');
				if (jQuery('#'+section+'_li').hasClass('active')){
					jQuery('#map_canvas_'+resort).show();
					initialize(resort);
				}else{
					jQuery('#'+section+'_li').click(function(){
						jQuery('#map_canvas_'+resort).show();
						initialize(resort);
					});
				}
				
			}else if (typeof map_loaded != 'undefined')
				if(map_loaded.hasOwnProperty(resort) && jQuery(this).hasClass('map_resort')){
					jQuery('#map_canvas_'+resort).show();
				}
		}
	});
	
	jQuery('.options_wtd_flag').parent().hide();
	jQuery('.wtd_pages input').each(function(){
		var id= jQuery(this).attr('id');
		jQuery('[data-id="'+id+'"]').click(function(){
			var val = parseInt(jQuery('#'+id).val());
			var cl = id;
			var section = jQuery('.'+cl).attr('id');
			if (val)
				jQuery('#'+section+'_li').fadeIn(200);
			else
				jQuery('#'+section+'_li').fadeOut(200);
		});
	});
		
	jQuery('.category_full .redux-container-switch label').click(function(event){
		event.preventDefault();
		var place = jQuery(this).attr('data-place');
		var term = jQuery(this).attr('data-term');
		var resort = jQuery(this).attr('data-resort');
		var val = parseInt(jQuery(this).attr('data-val'));
		redux_change(jQuery(this));
		if (!jQuery(this).hasClass('selected')){
			jQuery(this).parent().find('label').removeClass('selected');
			jQuery(this).addClass('selected');
			if (!val){
				jQuery('#'+place+'_inputs').append('<input type="hidden" id="'+place+'_'+resort+'_term_'+term+'" data-term="'+term+'" name="wtd_plugin['+place+']['+resort+']['+term+'][parent]" value="1"/>');
				jQuery('.wtd_cat[data-place="'+place+'"][data-term="'+term+'"][data-resort="'+resort+'"] i').removeClass('el-icon-check').addClass('el-icon-check-empty');
				jQuery('.wtd_scat[data-place="'+place+'"][data-parent="'+term+'"][data-resort="'+resort+'"]').removeClass('button-primary').find('i').removeClass('el-icon-check').addClass('el-icon-check-empty');
			}
			else{
				jQuery('#'+place+'_'+resort+'_term_'+term).remove();
				jQuery('.wtd_cat[data-place="'+place+'"][data-term="'+term+'"][data-resort="'+resort+'"] i').removeClass('el-icon-check-empty').addClass('el-icon-check');
				jQuery('.wtd_scat[data-place="'+place+'"][data-parent="'+term+'"][data-resort="'+resort+'"]').each(function(){
						var sterm = jQuery(this).attr('data-term');
						if (!jQuery('#'+place+'_'+resort+'_term_'+sterm).length){
							jQuery(this).addClass('button-primary').find('i').removeClass('el-icon-check-empty').addClass('el-icon-check'); 
						}
				});
			}
		}
	});
	
	jQuery('.wtd_cat').click(function(event){
		event.preventDefault();
		var place = jQuery(this).attr('data-place');
		var resort = jQuery(this).attr('data-resort');
		jQuery('.wtd_cat').removeClass('button-primary');
		jQuery(this).addClass('button-primary');
		if (!jQuery('#'+place+'_wtd_flag').parent().is(':visible'))
			jQuery('.options_wtd_flag[data-place="'+place+'"]').parent().show();
		
		var term = jQuery(this).attr('data-term');
		jQuery('.wtd_cat_container').hide();
		jQuery('.category_full[data-place="'+place+'"]').show();
		jQuery('#'+place+'_'+resort+'_parent_term_'+term).show();
		jQuery('#'+place+'_'+resort+'_parent_term_'+term+' [data-resort]').show();
	});
	
	jQuery('.wtd_scat').click(function(event){
		event.preventDefault();
		var place = jQuery(this).attr('data-place');
		var term = jQuery(this).attr('data-term');
		var parent = jQuery(this).attr('data-parent');
		var resort = jQuery(this).attr('data-resort');
		redux_change(jQuery(this));
		if (jQuery(this).hasClass('button-primary')){
			jQuery(this).find('i').removeAttr('class').addClass('el-icon-check-empty');
			jQuery('#'+place+'_inputs').append('<input type="hidden" id="'+place+'_'+resort+'_term_'+term+'" data-term="'+term+'" name="wtd_plugin['+place+']['+resort+']['+parent+'][children]['+term+']" value="1"/>');
			jQuery(this).toggleClass('button-primary');
		}else if(!jQuery('#'+place+'_'+resort+'_term_'+parent).length){
			jQuery(this).find('i').removeAttr('class').addClass('el-icon-check');
			jQuery('#'+place+'_'+resort+'_term_'+term).remove();
			jQuery(this).toggleClass('button-primary');
		}
	});
	
	jQuery('[for="activity_providers-buttonset2"]').click(function(){
			jQuery('#wtd_plugin-excluded_vendors').parent().parent().show();
			jQuery('#wtd_plugin-vendors').parent().parent().hide();
	});
	
	jQuery('[for="activity_providers-buttonset3"]').click(function(){
			jQuery('#wtd_plugin-excluded_vendors').parent().parent().hide();
			jQuery('#wtd_plugin-vendors').parent().parent().show();
	});
	
	jQuery('[for="activity_providers-buttonset1"]').click(function(){
		jQuery('#wtd_plugin-excluded_vendors').parent().parent().hide();
		jQuery('#wtd_plugin-vendors').parent().parent().hide();
	});

	jQuery(document).on('click','#4_section_group_li',function(){
        setTimeout(function() {
            if (!jQuery('[for="activity_providers-buttonset2"]').hasClass('ui-state-active')) {
                jQuery('#wtd_plugin-excluded_vendors').parent().parent().hide();
            } else {
                jQuery('#wtd_plugin-excluded_vendors').parent().parent().show();
            }
            if (!jQuery('[for="activity_providers-buttonset3"]').hasClass('ui-state-active')) {
                jQuery('#wtd_plugin-vendors').parent().parent().hide();
            } else {
                jQuery('#wtd_plugin-vendors').parent().parent().show();
            }
        },300);
	});
	
	jQuery('.resort_flag').parent().parent().parent().hide();
	
	jQuery('.wtd_page_type label').click(function(){
		if (!jQuery(this).hasClass('ui-state-active')){
			var parent = jQuery(this).parent().parent();
			var resort = parent.attr('data-resort');
			var place = parent.attr('data-place');
			parent.find('label').removeClass('ui-state-active');
			jQuery(this).addClass('ui-state-active');
			jQuery('#'+place+'_'+resort+'_page_style').val(jQuery(this).attr('data-val'));
		}
	});
	
	setTimeout(function(){
		
		jQuery('#wtd_plugin-business_category .select2-choice').bind("DOMSubtreeModified",function(){
			
			var parent = jQuery('#wtd_bscats').parent();
			if (!parent.is(':visible'))
				parent.show();
			var selected = jQuery(this).find('#select2-chosen-5').html();
			if (selected != 'All Categories'){
				jQuery('.resort_flag[data-place="business_categories_options"]').parent().parent().parent().css('display','table-row');
			}else{
				jQuery('.resort_flag[data-place="business_categories_options"]').parent().parent().parent().hide();
			}
			
		});
			
	},500);
	
	jQuery('.wtd_key_enabler label').click(function(){
		var key = jQuery(this).parent().parent().attr('data-key');
		var resort = jQuery(this).parent().parent().attr('data-resort');
		var place = jQuery(this).attr('data-place');
		var val = jQuery(this).attr('data-val');
		jQuery(this).parent().find('label').removeClass('selected');
		jQuery(this).addClass('selected');
		jQuery('#'+place+'_'+resort+'_'+key).val(val);
	});
	
	jQuery('.wtd_cat i').click(function(){
		var resort = jQuery(this).parent().attr('data-resort');
		var place = jQuery(this).parent().attr('data-place');
		var term = jQuery(this).parent().attr('data-term');
		redux_change(jQuery(this));
		if (jQuery(this).hasClass('el-icon-check')){
			jQuery('.cb-disable[data-term="'+term+'"][data-place="'+place+'"][data-resort="'+resort+'"]').click();
		}else{
			jQuery('.cb-enable[data-term="'+term+'"][data-place="'+place+'"][data-resort="'+resort+'"]').click();
		}
	});
	
	//Steps Navigators
	if (jQuery('#2_section_group_li').length > 0){
		var i = 0;
        var max = parseInt(jQuery('.redux-group-tab.wtd_general_style').attr('data-rel'));
		for ( i = 0; i < max;i++ ){
            var next_tg = i + 1
            if (i == 0) {
                 next_tg = i + 2;
            }
            var prev_tg = i - 1
            if (i == 2) {
                prev_tg = i - 2;
            }
            var next_li = jQuery('#' + (next_tg) + '_section_group_li')
            var next_text = 'Next ';
            var prev_li = jQuery('#' + (prev_tg) + '_section_group_li')
            var prev_text = 'Back ';
            if (prev_li.length) {
                jQuery('#' + i + '_section_group h3').css({'padding-bottom': '10px'});
                jQuery('#' + i + '_section_group').prepend('<a href="javascript:void(0)" data-step="#' + (prev_tg) + '_section_group_li_a" class="button button-primary wtd_step_navigator">&laquo; ' + prev_text + '</a>');
            }
            if (next_li.length) {
                jQuery('#' + i + '_section_group h3').css({'padding-bottom': '10px'});
                jQuery('#' + i + '_section_group').prepend('<a href="javascript:void(0)" data-step="#' + (next_tg) + '_section_group_li_a" class="button button-primary wtd_step_navigator">' + next_text + ' &raquo;</a>');
            }
		}
		
		jQuery(document).on('click','.wtd_step_navigator',function(){
			var step = jQuery(this).attr('data-step');

            var step_parent = jQuery(step).parent().parent().parent();
            if (step_parent.hasClass('hasSubSections')) {
                step_parent.addClass('activeChild');
                var ul = step_parent.find('ul').first();
                if (!ul.is(':visible'))
                    ul.slideToggle();
            }
			jQuery(step).click();
		});
		
		jQuery('.wtd_physical_address input[type="text"]').attr('autocomplete','off');
		
		jQuery('.select2-results').bind("DOMSubtreeModified",function(){
			jQuery(this).find('.select2-result-label').each(function(index,value){
				jQuery(this).html('merge');
			});
		});
	}
	
	jQuery('#state-text').keypress(function(event){
        var key = event.keyCode || event.charCode;
		var val = jQuery(this).val();
		if (val.length > 1 && key != 8 && key != 46)
			return false;
	});

    var rrate_parent = jQuery('#wtd_plugin-feed_update_time').parent().parent().parent().parent();
    rrate_parent.addClass('redux-info')
                .addClass('redux-info-field')
                .addClass('redux-field-info')
                .removeClass('no-border')
                .css({
                    'border-radius': '4px',
                    'color': '#5c80a1'
                });
    rrate_parent.find('.description').css({
        'color' : '#5c80a1'
    });
    rrate_parent.find('.redux_field_th').css({
        'color' : '#5c80a1',
        'width' : '90%',
        'margin-left' : '5%'
    });
    jQuery('#wtd_plugin-activities_sort_by label,#wtd_plugin-dining_sort_by label').click(function () {
        var attr = jQuery(this).attr('for');
        if (attr.indexOf('buttonset2') !== -1)
            jQuery(this).parent().parent().find('.wtd_sort_label').show();
        else
            jQuery(this).parent().parent().find('.wtd_sort_label').hide();
    });
    jQuery('#8_section_group_li_a,#9_section_group_li_a').click(function() {
        setTimeout(function () {
            jQuery('#wtd_plugin-activities_sort_by label.ui-state-active,#wtd_plugin-dining_sort_by label.ui-state-active').each(function () {
                var attr = jQuery(this).attr('for');
                if (attr.indexOf('buttonset2') !== -1)
                    jQuery(this).parent().parent().find('.wtd_sort_label').show();
                else
                    jQuery(this).parent().parent().find('.wtd_sort_label').hide();
            });
        }, 500);
    });

    jQuery(document).on('click','.wtd_shortcode_button',function(){
        var excluded_categories = "";
        jQuery('#shortcode_options_inputs input').each(function() {
            var term = jQuery(this).attr('data-term');
            excluded_categories = excluded_categories + term + ',';
        });
        excluded_categories = excluded_categories.substring(0,excluded_categories.length - 1);
        if (excluded_categories.length > 0){
            var shortcode = '[wtd_search_form exclude="'+excluded_categories+'"]';
            var tshortcode = '&lt;?php echo do_shortcode(\'[wtd_search_form exclude="'+excluded_categories+'"]\');?>';
        }else {
            var shortcode = '[wtd_search_form]';
            var tshortcode = '&lt;?php echo do_shortcode(\'[wtd_search_form]\');?>';
        }

        jQuery('#wtd_pre_post').html(shortcode);
        jQuery('#wtd_pre_theme').html(tshortcode);


    });
	
});//End of Document Ready
