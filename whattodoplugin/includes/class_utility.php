<?php

class wtdUtility{



	function __construct(){

	}

	function displayVideo($videos){
		if(!empty($videos)){
			$wtd_video_id = wtd_video_id_generator($videos[0]); ?>
			<div id="wtd_video_holder">
				<div id="wtd_video_player"></div>
			</div>
			<script>
				jQuery('.wtd_single_listing_sc_image').hide();
				// Load Iframe API
				var tag = document.createElement('script');
				tag.src = "https://www.youtube.com/iframe_api";
				var firstScriptTag = document.getElementsByTagName('script')[0];
				firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
				//Generate iFrame
				var player;
				function onYouTubeIframeAPIReady(){
					player = new YT.Player('wtd_video_player', {
						height: '390',
						width: '640',
						videoId: '<?php echo $wtd_video_id;?>',
						events: {
							'onReady': wtd_player_onPlayerReady,
							'onStateChange': wtd_player_onStateChange
						}
					});
				}
				// 4. The API will call this function when the video player is ready.
				var WtdReadyCounter = 0;
				function wtd_player_onPlayerReady(event){
					event.target.playVideo();
					player.mute();
					jQuery('#wtd_video_player').hover(function(){
						player.unMute();
					}, function(){
						player.mute();
					});
				}

				function wtd_player_onStateChange(state){
					if(WtdReadyCounter > 2)
						jQuery('#wtd_video_player').off('hover')
					else
						WtdReadyCounter = WtdReadyCounter + 1;
				}
			</script><?php
		}
	}

	function displayGallery($images){
		if(!empty($images)){?>
			<script type="text/javascript">
				var images = <?php echo json_encode($images);?>;
				var image_idx = 0;
			</script>
			<div id="wtd_gallery" layout="column">
				<div layout="column" layout-align="end end">
					<div id="wtd_gallery_prevnext" flex>
						<a href="javascript:void(0);" onclick="galleryPrevious();" id="wtd_gallery_prev">&lt; Previous</a> |
						<a href="javascript:void(0);" onclick="galleryNext();" id="wtd_gallery_next">Next &gt;</a>
					</div>
				</div>
				<div id="wtd_gallery_big" layout="row" layout-align="center center" layout-padding><?php
					echo '<img src="'.$images[0].'" onclick="galleryNext();"/>';?>
				</div>
				<div id="wtd_gallery_nav" layout="row" layout-align="center center" layout-wrap><?php
					foreach($images as $image){
						echo '<div onclick="thumbnavClick(\''.$image.'\');" layout-margin><img src="'.$image.'"/></div>';
					}?>
				</div>
			</div><?php
		}
	}
}?>