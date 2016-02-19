var overview_app = angular.module('overviewApp', ['ngMaterial']);

overview_app.controller('overviewCtrl', function($scope){

	angular.element(document).ready(function(){
		// fire up the masonry grid after the page is loaded
		var grid = jQuery('.grid').masonry({
			// options
			itemSelector: '.masonry-entry',
			columnWidth: '.masonry-column-width',
			percentPosition: true,
			gutter: 20
		});
		// layout Masonry after each image loads
		grid.imagesLoaded().progress( function() {
			grid.masonry('layout');
		});
	});
});