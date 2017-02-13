<?php
wp_enqueue_script('jquery-ui-core');
wp_enqueue_script('jquery-ui-widget');
wp_enqueue_script('jquery-ui-position');
wp_enqueue_script('jquery');
global $wp_scripts;?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>WhatToDo Resort</title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
		<script language="javascript" type="text/javascript" src="<?php echo site_url();?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url();?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo WTD_PLUGIN_URL;?>/includes/shortcodes/tinymce/resort_shortcode.js"></script>
		<base target="_self" /><?php
		wp_print_scripts();?>
	</head>

	<body id="link">
		<form name="resort_shortcode" action="#">
			<table border="0" cellpadding="4" cellspacing="0">
				<tr>
					<td>Insert New shortcode</td>
					<td><select id="newshortcode">
							<option value="1">shortcode1</option>
							<option value="2">shortcode2</option>
							<option value="3">shortcode3</option>
						</select>
					</td>
				</tr>
			</table>
			<div>
				<div style="float: left">
					<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'resort_shortcode'); ?>" onClick="tinyMCEPopup.close();" />
				</div>

				<div style="float: right">
					<input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'resort_shortcode'); ?>" onClick="insertResortShortcode();" />
				</div>
			</div>
		</form>
	</body>
</html>
