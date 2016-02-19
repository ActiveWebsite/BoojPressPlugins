var special_app = angular.module('specialApp', ['ngMaterial']);

special_app.controller('specialCtrl', function($scope){
	$scope.progress = true;

	$scope.wtd_parse_special = function(){
		Parse.Cloud.run('get_special_v2', wtd_base_request, {
			success: function (result) {
				jQuery('#ical_wtd_data').val(result);
				jQuery.ajax({
					url: wtd_ajax_url,
					type: 'post',
					data: {
						action: 'wtd_build_special',
						data: result
					},
					success: function(data){
						jQuery('#wtd_event_sc_container').html(data);
						$scope.progress = false;
						$scope.$apply();
					}
				});
			},
			error: function(error){
				window.location.assign(return_page);
			}
		});
	}

	angular.element(document).ready(function(){
		$scope.wtd_parse_special();
	});
});