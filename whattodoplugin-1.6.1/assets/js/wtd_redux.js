var wtd_app = angular.module('wtdPluginAdmin', ['ngMaterial']);
wtd_app.controller('categoryExclusion', ['$scope', function($scope){
	$scope.getSubcategories = function(cat_id){
		jQuery('#'+cat_id+'_filter_enabled').addClass('selected');
		jQuery('#'+cat_id+'_filter_disabled').removeClass('selected');
		Parse.Cloud.run('get_subcategory_list_v2', {
				parent_id: cat_id,
				token: token
			}, {
				success: function(result){
					jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: {
							action: 'enable_parent_category_filter',
							cat_id: cat_id
						}
					});
					showSubcategoryList(cat_id, result);
				},
				error: function(error){
					console.log(error);
				}
			}
		);
	};
}]);
function showSubcategoryList(cat_parent_id, result){
	var response = JSON.parse(result);
	var html = '';
	for(var i = 0; i < response.length; i++){
		var sub_cat = response[i];
		var selected = '';
		if(typeof excluded_cats != 'undefined' && excluded_cats != null){
			if(excluded_cats.indexOf(sub_cat.objectId) > -1)
				selected = ' checked ';
		}
		html += '<div flex="33"><input type="checkbox" name="excluded_cats[]" id="excluded_cats[]" onchange="saveExcludedCats();" value="' + sub_cat.objectId + '" '+selected+' />' + sub_cat.name + '</div>';
	}
	jQuery('#' + cat_parent_id + '_children').html(html);
}
function saveExcludedCats(){
	var cats = jQuery('input[type="checkbox"], input[name="excluded_cats"]').serialize();
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl + '?' + cats + '&action=save_excluded_cats',
		success: function(){
		}
	});
}
function disableParentCategoryFilter(cat_id){
	jQuery('#'+cat_id+'_filter_enabled').removeClass('selected');
	jQuery('#'+cat_id+'_filter_disabled').addClass('selected');
	jQuery.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
			action: 'disable_parent_category_filter',
			cat_id: cat_id
		},
		success: function(){
			jQuery('#' + cat_id + '_children').html('');
		}
	});
}
wtd_app.controller('activitiesOptionsController', function($scope){
	$scope.resorts = angular.toJson(resorts);
	$scope.resorts_with_exclusions = new Array();
	$scope.resort_cat_exclusions = new Array();
	$scope.pushExclusionResort = function(res_id){
		$scope.resorts_with_exclusions.push(res_id);
	};
	$scope.pushExclusionResortCat = function(res_id, cat_id){
		$scope.resort_cat_exclusions[res_id].push(cat_id);
	};
	$scope.showResort = function(res_id){
		if($scope.resorts_with_exclusions.indexOf(res_id) > -1){
			jQuery('.resort_selector[data-resort="' + res_id + '"][data-place="activities_options"]').addClass('ui-state-active');
			return true;
		}else{
			return false;
		}
	};
});