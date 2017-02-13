var event_app = angular.module('eventApp', ['ngMaterial']);

event_app.controller('eventCtrl', function($scope){
	$scope.progress = true;

	$scope.wtd_parse_event = function(){
		Parse.Cloud.run('get_event_v2', wtd_base_request, {
			success: function(result){
				jQuery('#ical_wtd_data').val(result);
				jQuery.ajax({
					url: wtd_ajax_url,
					type: 'post',
					data: {
						action: 'wtd_build_event',
						data: result
					},
					success: function(data){
						jQuery('#wtd_event_sc_container').html(data);
						//$scope.content = data;
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
		$scope.wtd_parse_event();
	});
});