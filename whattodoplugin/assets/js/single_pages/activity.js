var activity_app = angular.module('activityApp', ['ngMaterial']);

activity_app.controller('activityCtrl', function($scope){
	$scope.progress = true;

	$scope.wtd_parse_activity = function(){
		Parse.Cloud.run('get_activity_v2', wtd_base_request, {
			success: function(result){
				jQuery.ajax({
					url: wtd_ajax_url,
					type: 'post',
					data: {
						action: 'wtd_build_activity',
						data: result
					},
					success: function(data){
						jQuery('#wtd_parse_content').html(data);
						$scope.progress = false;
						$scope.$apply();
					}
				});
			},
			error: function(error){

			}
		});
	};

	angular.element(document).ready(function(){
		$scope.wtd_parse_activity();
	});
});

var wtd_direction_link;
var visitor_lat;
var visitor_lng;
jQuery(document).on('click','.wtd_direction_link', function(e){
	var href = jQuery(this).attr('href');
	if(href.indexOf('%currlocation%') !== -1){
		e.preventDefault();
		wtd_direction_link = jQuery(this);
		r = confirm('We need to locate your position first.');
		if(r)
			wtd_locate_visitor();
	}
});
function wtd_show_directions(position){
	alert('Please click again on the link you wish.');
	var user_location = position.coords.latitude + ',' + position.coords.longitude;
	jQuery('.wtd_direction_link').each(function(){
		var href = jQuery(this).attr('href');
		href = href.replace('%currlocation%', user_location);
		jQuery(this).attr('href', href);
	});
}
function wtd_locate_visitor(){
	if(navigator.geolocation)
		navigator.geolocation.getCurrentPosition(wtd_show_directions);
	else
		alert("Geolocation is not supported by this browser.");
}