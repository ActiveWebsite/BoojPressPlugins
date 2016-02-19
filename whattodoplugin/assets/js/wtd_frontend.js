function thumbnavClick(url){
	var idx = images.indexOf(url);
	image_idx = idx;
	jQuery('#wtd_gallery_big img').attr('src', url);
}

function galleryNext(){
	image_idx++;
	if(image_idx >= images.length)
		image_idx = 0;
	jQuery('#wtd_gallery_big img').attr('src', images[image_idx]);
}

function galleryPrevious(){
	image_idx--;
	if(image_idx < 1)
		image_idx = images.length - 1;
	jQuery('#wtd_gallery_big img').attr('src', images[image_idx]);
}