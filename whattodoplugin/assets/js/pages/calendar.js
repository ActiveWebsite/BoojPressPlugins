var calendar_app = angular.module('calendarApp', ['ngMaterial']);

calendar_app.controller('calendarCtrl', function($scope, $mdDialog, $anchorScroll){
	$scope.progress = true;
	$scope.week = (7 * 24 * 60 * 60) * 1000; // one week in milliseconds
	$scope.start = wtd_start_date;
	$scope.end = wtd_end_date;

	$scope.wtd_get_month = function(){
		base_request.start = $scope.start;
		base_request.end = $scope.end;
		Parse.Cloud.run('events_calendar_short_v2', base_request, {
			success: function(result){
				var time = new Date($scope.end.getTime() - ($scope.week * 2));
				var month = time.getMonth();
				month++;
				jQuery.ajax({
					url: wtd_ajax_url,
					type: 'post',
					dataType: 'json',
					data: {
						action: 'wtd_build_calendar',
						data: result,
						start: $scope.start.getTime(),
						end: $scope.end.getTime(),
						year: time.getFullYear(),
						month: month
					},
					success: function(data){
						jQuery('#dates').html(data.html);
						jQuery('#current_month').text(data.current_month);
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

	showDateDialog = function(ev, timestamp){
		$anchorScroll(0);
		jQuery.ajax({
			type: 'POST',
			url: wtd_ajax_url,
			data: {
				action: 'get_date_dialog',
				timestamp: timestamp,
				res_id: res_id
			},
			success: function(data){
				$mdDialog.show({
					template: data,
					clickOutsideToClose: true
				});
			}
		});
	};

	hideDialog = function(){
		$mdDialog.hide();
	};

	$scope.get_next_month = function(){
		$scope.progress = true;
		var next_month_start = $scope.start.getTime() + ($scope.week * 4);
		$scope.start = new Date(next_month_start)
		var end = new Date($scope.end.getTime() + ($scope.week * 4));
		$scope.end = end;
		$scope.wtd_get_month();
	};

	$scope.get_last_month = function(){
		$scope.progress = true;
		var previous_month_start = new Date($scope.start.getTime() - ($scope.week * 4));
		var end = new Date($scope.end.getTime() - ($scope.week * 4));
		$scope.end = end;
		$scope.start = previous_month_start;
		$scope.wtd_get_month();
	};

	angular.element(document).ready(function () {
		$scope.wtd_get_month();
	});
});