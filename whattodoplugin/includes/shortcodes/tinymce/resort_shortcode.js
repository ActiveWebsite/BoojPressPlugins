
function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertResortShortcode() {
	var tagtext;
	var shortcode = jQuery('#newshortcode').val();

	tagtext = "[wtdResort id=" + shortcode + "]";

	if(window.tinyMCE) {
		window.tinyMCE.execInstanceCommand(window.tinyMCE.activeEditor.id, 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML.
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches.
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
