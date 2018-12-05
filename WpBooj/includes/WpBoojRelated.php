<?php
/***********************************************************                                                          
	 _ _ _     _____           _    _ _    _____     _     _         _ 
	| | | |___| __  |___ ___  |_|  |_|_|  | __  |___| |___| |_ ___ _| |
	| | | | . | __ -| . | . | | |   _ _   |    -| -_| | .'|  _| -_| . |
	|_____|  _|_____|___|___|_| |  |_|_|  |__|__|___|_|__,|_| |___|___|
	      |_|               |___|                                      
	  
  WpBooj :: Related

	Basic Usage on Frontend:

	$post_id = get_the_ID();
	foreach( $WpBoojRelated::get( $post_id ) as $related ){
	  echo $related->ID;
	  echo $related->post_title;
	  if ( has_post_thumbnail( $related->ID ) ){
	    echo get_the_post_thumbnail( $related->ID );
	  } else {
	    echo 'no image avail';
	  }
	}
*/

class WpBoojRelated {
    /**
     * @description Method is entry point to get related posts.  Mostly called in theme's single.php.
     * @param $post_id | integer|string | The post id.  Should be int but can come in as string.
     * @param int | $count | The number of related posts to retrieve.
     * @return array|bool|mixed
     */
	public static function get($post_id, $count = 4){
		$related_cache = WpBoojCache::check( $post_id = $post_id, $type = 'WpBoojRelated' );		

		if( $related_cache ){ return $related_cache; }

		global $wpdb;
		// Get the cat and tag ids from the given $post_id
		$tags  = wp_get_post_tags( $post_id, array('fields' => 'ids') );

		$cats  = get_the_category( $post_id );
		$catIds = array();
		foreach ( $cats as $key => $cat) { $catIds[] = $cat->term_id; }

        $full_search = implode(array_merge($tags, $catIds), ',');

		// Get the term_taxonomy_id from the term_ids
		$query = "SELECT `term_taxonomy_id` FROM `{$wpdb->prefix}term_taxonomy` WHERE `term_id` IN ({$full_search});";
		$rows  = $wpdb->get_results( $query, ARRAY_N );
		$termIds = array_map((function ($item) { return (integer)$item[0]; }), $rows);

        $rows = self::getRelatedPosts($post_id, $termIds);

        // Get more posts if we don't have 4.
        if(count($rows) < $count) $rows = self::getMoreRelatedPosts($rows, $count);

		$relatedPosts = array();

		foreach( $rows as $key => $row )
		{
            $datePenalty = round( ( time() - strtotime( $row->post_date ) ) / 86400, 0 );
            $relatedPosts[ $row->ID ]['post']   = $row;
            $relatedPosts[ $row->ID ]['points'] = $relatedPosts[$row->ID]['points'] - $datePenalty;
		}

		$posts = self::getFinalPosts($relatedPosts, $count);

		// store a cached version if we found content
		if( count($posts) === $count ) WpBoojCache::store( $post_id = $post_id, $post_type = 'WpBoojRelated', $posts );

		return $posts;
	}


    /**
     * @description Method gets related posts from term ids and the post.
     * @param integer | $post | The post ID.
     * @param array | $termIds | The term ids associated with the post.
     * @return array|null|object
     */
    private static function getRelatedPosts($post, $termIds)
    {
        global $wpdb;
        $terms = implode($termIds, ",");

        $query = "SELECT DISTINCT( object_id ), COUNT(*) AS count, `p`.`post_date` , `p`.`ID`
			FROM `{$wpdb->prefix}term_relationships` t
			JOIN wp_posts p on t.object_id = p.ID 
			JOIN wp_postmeta pm on p.ID = pm.post_id and pm.meta_key = 'views'
			WHERE `term_taxonomy_id` IN({$terms})
				AND `object_id` != {$post}
				AND p.post_status = \"publish\"
				AND p.post_type   = \"post\"
			GROUP BY 1
			ORDER BY 2 DESC
			LIMIT 50";

        return $wpdb->get_results($query);
    }


    /**
     * @description Method gets related posts from term ids and the post.
     * @param $posts | array | The related posts already pulled.
     * @param $count | integer | The number of posts we need.
     * @return array|null|object
     */
    private static function getMoreRelatedPosts($posts, $count)
    {
        global $wpdb;

        $ids = implode(self::getPostIdsFromArray($posts), ",");
        $postsNeeded = $count - count($posts);

        $query = "SELECT ID, 0, `post_date` as `count` FROM `{$wpdb->prefix}posts` 
				    WHERE `post_status` = 'publish'  
                    AND `post_type` = 'post'";

        if(!empty($ids)) $query .= " AND `ID` NOT IN({$ids})";

        $query .= "ORDER BY `post_date` DESC LIMIT {$postsNeeded}";

        $result = $wpdb->get_results($query);

        // Merge the arrays.
        return array_merge($posts, $result);
    }


    /**
     * @description Method orders final posts by system setting and gets posts object.
     * @param array | $posts | The posts to sort.
     * @param integer | $count | The number of posts to return.
     * @return array
     */
    private static function getFinalPosts($posts, $count)
    {
        self::orderRelatedPosts($posts);

        $out = array();

        // Loop through and get the actual post objects for display.
        foreach ($posts as $id => $post) { $out[] = get_post( $id ); }

        return array_slice($out, 0, $count);
    }


    /**
     * @description Method gets Booj settings and delegates ordering posts.
     * @param $posts | array | The array of posts to order.
     * @return array|bool | Sorted array of posts.
     */
    private static function orderRelatedPosts(&$posts)
    {
        $sortBy = get_option('wpbooj_ymal_orderby');
        $sortOrder = get_option('wpbooj_ymal_order');

        // Set sort order if it is null.
        if(is_null($sortOrder)) $sortOrder = "desc";

        switch ($sortBy)
        {
            case 'views':
                // Do views logic here.
                return self::sortPostsByViews($posts, $sortOrder);
                break;
            case 'date':
                // Do date logic here.
                return self::sortPostsByDate($posts, $sortOrder);
                break;
            case 'related':
            default:
                // DO old logic here.
                return self::sortPostsByScore($posts, $sortOrder);
                break;
        }
    }


    /**
     * @description Method sorts posts array by date.
     * @param $posts | array | The posts to sort.
     * @param $order | string | The order to sort by (ASC, DESC)
     * @return bool|array | false or an array of sorted posts.
     */
    private static function sortPostsByDate(&$posts, $order)
    {
        if($order === 'asc')
        {
            return uasort($posts, function($a, $b) {
                return ($a['post']->post_date < $b['post']->post_date) ? -1 : 1;
            });
        }

        return uasort($posts, function($a, $b) {
            return ($a['post']->post_date > $b['post']->post_date) ? -1 : 1;
        });
    }


    /**
     * @description Method sorts posts array by views.
     * @param $posts | array | The posts to sort.
     * @param $order | string | The order to sort by (ASC, DESC)
     * @return bool|array | false or an array of sorted posts.
     */
    private static function sortPostsByViews(&$posts, $order)
    {
        if($order === 'asc')
        {
            return uasort($posts, function($a, $b) {
                return ($a['post']->views < $b['post']->views) ? -1 : 1;
            });
        }

        return uasort($posts, function($a, $b) {
            return ($a['post']->views > $b['post']->views) ? -1 : 1;
        });
    }


    /**
     * @description Method sorts posts array by views.
     * @param $posts | array | The posts to sort.
     * @param $order | string | The order to sort by (ASC, DESC)
     * @return bool|array | false or an array of sorted posts.
     */
    private static function sortPostsByScore(&$posts, $order)
    {
        if($order === 'asc')
        {
            return uasort($posts, function($a, $b) {
                return ($a['points'] < $b['points']) ? -1 : 1;
            });
        }

        return uasort($posts, function($a, $b) {
            return ($a['points'] > $b['points']) ? -1 : 1;
        });
    }


    /**
     * @description Method gets post ids from array of posts.
     * @param $posts | array | The array of post objects.
     * @return array | Array of post ids.
     */
    private static function getPostIdsFromArray($posts)
    {
        return array_map((function ($post) { return $post->ID; }), $posts);
    }
}