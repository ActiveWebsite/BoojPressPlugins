var event_app = angular.module('eventApp', ['ngMaterial']);

event_app.controller('eventCtrl', function($scope){
	$scope.progress = true;
	$scope.start = start;
	$scope.end = end;

	$scope.wtd_parse_events_week = function(){
		wtd_base_request.start = $scope.start;
		wtd_base_request.end = $scope.end;
		Parse.Cloud.run('events_week_short_v2', wtd_base_request, {
			success: function(result){
				jQuery.ajax({
					url: wtd_ajax_url,
					type: 'post',
					data: {
						action: 'wtd_build_week_events',
						data: result
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
	};

	$scope.get_next_week = function(){
		$scope.progress = true;
		$scope.start = $scope.end;
		var end_time = new Date($scope.end);
		var week = (7 * 24 * 60 * 60) * 1000; // week in milliseconds
		var end = new Date(end_time.getTime() + week);
		$scope.end = end;
		$scope.wtd_parse_events_week();
	};

	$scope.get_last_week = function(){
		$scope.progress = true;
		$scope.end = $scope.start;
		var start_time = new Date($scope.start);
		var week = (7 * 24 * 60 * 60) * 1000; // week in milliseconds
		var start = new Date(start_time.getTime() - week);
		$scope.start = start;
		$scope.wtd_parse_events_week();
	};

	angular.element(document).ready(function(){
		$scope.wtd_parse_events_week();
	});
});