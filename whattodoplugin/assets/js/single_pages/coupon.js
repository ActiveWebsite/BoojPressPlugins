var coupon_app = angular.module('couponApp', ['ngMaterial']);

coupon_app.controller('couponCtrl', function($scope){
	$scope.progress = true;
	$scope.coupon_id = null;

	$scope.wtd_parse_coupon = function(){
		Parse.Cloud.run('get_coupon_v2', wtd_base_request, {
			success: function(result){
				jQuery.ajax({
					url: wtd_ajax_url,
					type: 'post',
					data: {
						action: 'wtd_build_coupon',
						data: result
					},
					success: function(data){
						var response = JSON.parse(data);
						jQuery('#wtd_parse_content').html(response.content);
						$scope.coupon_id = response.coupon_id;
						$scope.encrypted_coupon = response.data;
						$scope.progress = false;
						$scope.$apply();
					}
				});
			},
			error: function(error){
				jQuery('#wtd_parse_content').html(error.responseText);
				$scope.progress = false;
				$scope.$apply();
			}
		});
	}

	sendEmail = function(){
		var email = prompt('Please enter an e-mail address.');
		if(email){
			jQuery.ajax({
				type: 'post',
				url: wtd_ajax_url,
				data: {
					email: email,
					action: 'wtd_mail_coupon',
					coupon: $scope.encrypted_coupon
				},
				success: function(data){
					alert('Your e-mail has been queued. In the next hour, the e-mail '+email+' will receive the coupon.')
				}
			});
		}
	};

	angular.element(document).ready(function(){
		$scope.wtd_parse_coupon();
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