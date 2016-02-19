(function() {
	tinymce.create('tinymce.plugins.resort_shortcode', {
		init: function(ed, url) {

			ed.addCommand('mce_resort_shortcode', function() {
				ed.windowManager.open({
					// call content via admin-ajax, no need to know the full plugin path
					file: ajaxurl + '?action=resort_shortcode_tinymce',
					width: 500 + ed.getLang('resort_shortcode.delta_width', 0),
					height: 210 + ed.getLang('resort_shortcode.delta_height', 0),
					inline: 1
				}, {
					plugin_url: url // Plugin absolute URL
				});
			});

			// Register example button
			ed.addButton('resort_shortcode', {
				title: 'WhatToDo Resort Shortcode',
				cmd: 'mce_resort_shortcode',
				image: url + '/../../../assets/img/wtd_magnifying_glass_20px.png'
			});
		},
		getInfo: function() {
			return {
				longname: 'resort_shortcode',
				author: 'WhatToDo',
				authorurl: 'http://whattodo.com/',
				infourl: 'http://sales.whattodo.info/',
				version: "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('resort_shortcode', tinymce.plugins.resort_shortcode);
})();
