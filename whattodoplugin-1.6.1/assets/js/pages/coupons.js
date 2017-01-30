var coupons_app = angular.module('couponsApp', ['ngMaterial']);

coupons_app.controller('couponsCtrl', function($scope){
	$scope.progress = true;
	jQuery(document).on('click', '#wtd_parse_next', function(e){
		e.preventDefault();
		wtd_parse_page = wtd_parse_page + 1;
		wtd_base_request.page = wtd_parse_page;
		$scope.wtd_get_results();
	});

	jQuery(document).on('click', '#wtd_parse_prev', function(e){
		e.preventDefault();
		wtd_parse_page = wtd_parse_page - 1;
		wtd_base_request.page = wtd_parse_page;
		$scope.wtd_get_results();
	});

	$scope.wtd_get_results = function(){
		Parse.Cloud.run('coupons_list_v2', wtd_base_request, {
			success: function(result){
				jQuery.ajax({
					url: wtd_ajax_url,
					type: 'post',
					data: {
						action: 'wtd_build_coupons_list',
						data: result,
						page: wtd_parse_page
					},
					success: function(data){
						jQuery('#wtd_coupon_sc_container').html(data);
						$scope.progress = false;
						$scope.$apply();
					}
				});
			},
			error: function(error){
				console.log(error);
			}
		});
	};

	angular.element(document).ready(function(){
		$scope.wtd_get_results();
	});
});