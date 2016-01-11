WpBooj  v1.9.4
=======

This is a plugin for Wordpress. Primarily Wordpress 3+

- Resolves Apache Proxy url issues which arise in the Wordpress Admin links, when enabled our blogs can exist at client.com/blog/
- Removes Wordpress update nag screen for all users, though this needs updating with newer versions of wordpress
- Allows for the author meta option of "agent_bio_url" available to templates by "get_the_author_meta( 'agent_bio_url', $user->ID )"

Front End Developer Tools
There are a handful of commonly needed functions available to front end developers.

Popular Content
- NOTE: Many of these functions require the WP Post Views plugin installed to work properly.
- WpBooj::get_top_content_creators( $num_creators =  int(), $blacklisted_ids = array() )

Related Content
- Note: Usage of Related Content Module must be enabled in the Wordpress Admin - WpBooj Settings
- Below is an example usage of how to use the Related Content Module
```
<div id="related" class="clearfix">
	<h3>You may also like:</h3>
	<?php
	$i = 0;
	foreach( WpBoojRelated::get( $post->ID, 2 ) as $related_post ){
		if( $i % 2 == 0){ $classes = 'related-right'; } else { $classes = 'related-left'; }
		$i++;
		?>
		<div class="floatLeft <?php echo $classes ?>">
			<a href="<? echo get_permalink( $related_post->ID ); ?>"><h4><? echo WpBooj::truncate( $related_post->post_title, 30 ); ?></h4></a>
			<?
			if( has_post_thumbnail( $related_post->ID ) ){
				 $feat_image = get_the_post_thumbnail($related_post->ID, array( 100, 100 ) );
			} else {
			 $feat_image = '<img src="http://placehold.it/100x100">';
			}
			?>
			<? echo $feat_image; ?>
			<? echo WpBooj::truncate( WpBooj::removeCode( $related_post->post_content ), 199 ); ?>
		</div>
		<?
	}
	?>
</div>
```