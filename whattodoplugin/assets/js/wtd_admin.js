jQuery(document).ready(function(){
	
	jQuery('#enable_wtd_page').change(function(){
		
		if (jQuery(this).is(':checked')){
			jQuery("#wtd_metabox_content").show();
		}else{
			jQuery("#wtd_metabox_content").hide();
		}
		
	});
	
	
	jQuery('.wtd_multi_select').select2({
    allowClear: true
	});
	
	jQuery('#wtd_providers_type').change(function(){
		var val = jQuery(this).val();
		jQuery('.wtd_aprovider_option').hide();
		jQuery('.wtd_aprovider_option[data-opt="'+val+'"]').show();
	});
	
	jQuery('.wtd_cat').click(function(event){
		event.preventDefault();
		jQuery('.wtd_cat').removeClass('button-primary');
		jQuery(this).addClass('button-primary');
		if (!jQuery('#wtd_metabox_content .child_container').is(':visible'))
			jQuery('#wtd_metabox_content .child_container').show();
		jQuery('.wtd_children').hide();
		var term = jQuery(this).attr('data-term');
		jQuery('#wtd_children_'+term).show();
	});
	
	
	
	jQuery('.wtd_admin .wtd_toggle').click(function(){
		if (jQuery(this).hasClass('button-primary')){
			jQuery(this).find('i').removeAttr('class').addClass('el-icon-check-empty');
		}else{
			jQuery(this).find('i').removeAttr('class').addClass('el-icon-check');
		}
		jQuery(this).toggleClass('button-primary');
	});
	
	jQuery('#wtd_metabox_content .wtd_scat').click(function(event){
		var place = jQuery(this).attr('data-place');
		var parent = jQuery(this).attr('data-parent');
		if (!jQuery('#wtd_metabox_content .wtd_cat_disabler[data-term="'+parent+'"]').hasClass('button-primary') && jQuery('#wtd_metabox_content .wtd_cat_disabler[data-term="'+parent+'"]').length > 0){
			jQuery(this).find('i').removeAttr('class').addClass('el-icon-check-empty');
			jQuery(this).removeClass('button-primary');
		}else{
			var cat = jQuery(this).attr('data-term');
			if (!jQuery(this).hasClass('button-primary')){
				if (jQuery('#'+place+'_inputs').length > 0){
					var resort = jQuery(this).attr('data-resort');
					jQuery('#'+place+'_inputs').append('<input type="hidden" id="wtd_page_category_'+cat+'" name="wtd_plugin['+place+']['+resort+']['+parent+'][children]['+cat+']" value="1" />')
				}
				else
					jQuery('#wtd_no_categories').append('<input type="hidden" id="wtd_page_category_'+cat+'" name="wtd_page_options[excluded_categories][]" value="'+cat+'" />');
			}else{
				jQuery('#wtd_page_category_'+cat).remove();
			}
		}
	});
	
	jQuery('#wtd_metabox_content .wtd_cat_disabler').click(function(){
		var cat = jQuery(this).attr('data-term');
		var place = jQuery(this).attr('data-place');
		if (!jQuery(this).hasClass('button-primary')){
			jQuery(this).find('span').html('Disabled');
			if (jQuery('#'+place+'_inputs').length > 0){
				var resort = jQuery(this).attr('data-resort');
				jQuery('#'+place+'_inputs').append('<input type="hidden" id="wtd_page_category_'+cat+'" name="wtd_plugin['+place+']['+resort+']['+cat+'][parent]" value="1" />')
			}
			else
				jQuery('#wtd_no_categories').append('<input type="hidden" id="wtd_page_category_'+cat+'" name="wtd_page_options[excluded_categories][]" value="'+cat+'" />');
			jQuery('#wtd_metabox_content #wtd_children_'+cat+' .wtd_scat').removeClass('button-primary').find('i').removeClass('el-icon-check').addClass('el-icon-check-empty');
		}else{
			jQuery(this).find('span').html('Enabled');
			jQuery('#wtd_page_category_'+cat).remove();
			jQuery('#wtd_metabox_content #wtd_children_'+cat+' .wtd_scat').each(function(){
				
				var cat = jQuery(this).attr('data-term');
				if (!jQuery('#wtd_page_category_'+cat).length)
					jQuery(this).addClass('button-primary').find('i').removeClass('el-icon-check-empty').addClass('el-icon-check');
			});
		}
	});
	
});//End Of Document ready
