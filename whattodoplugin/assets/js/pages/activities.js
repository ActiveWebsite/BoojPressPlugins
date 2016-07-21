var activities_app = angular.module('activitiesApp', ['ngMaterial']);

activities_app.controller('activitiesCtrl', function($scope){
	$scope.progress = true;

	jQuery(document).on('click', '#wtd_parse_next', function(e){
		e.preventDefault();
		wtd_parse_page = wtd_parse_page + 1;
		wtd_base_request.page = wtd_parse_page;
		$scope.wtd_get_results(cur_category);
	});

	jQuery(document).on('click', '#wtd_parse_prev', function(e){
		e.preventDefault();
		wtd_parse_page = wtd_parse_page - 1;
		wtd_base_request.page = wtd_parse_page;
		$scope.wtd_get_results(cur_category);
	});

	$scope.wtd_get_results = function(){
		//wtd_base_request.cat_id = wtd_categories[cat_id];
		if(subcat_id == ''){
			Parse.Cloud.run('parent_category_list_v2', wtd_base_request, {
				success: function(result){
					jQuery.ajax({
						url: wtd_ajax_url,
						type: 'post',
						data: {
							action: 'wtd_build_activities_list',
							data: result,
							page: wtd_parse_page,
							term_id: cat_id
						},
						success: function(data){
							jQuery('#wtd_listing_sc_container').html(data);
							$scope.progress = false;
							$scope.$apply();
						}
					});
				},
				error: function(error){
					console.log(error);
				}
			});
		}else{
			Parse.Cloud.run('category_list_v2', wtd_base_request, {
				success: function(result){
					jQuery.ajax({
						url: wtd_ajax_url,
						type: 'post',
						data: {
							action: 'wtd_build_activities_list',
							data: result,
							page: wtd_parse_page
						},
						success: function(data){
							jQuery('#wtd_listing_sc_container').html(data);
							$scope.progress = false;
							$scope.$apply();
						}
					});
				},
				error: function(error){
					console.log(error);
				}
			});
		}
	}

	angular.element(document).ready(function(){
		$scope.wtd_get_results();
	});
});