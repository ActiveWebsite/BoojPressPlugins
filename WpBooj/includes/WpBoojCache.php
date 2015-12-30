<?php
/***********************************************************                                             
	 _ _ _     _____           _    _ _    _____         _       
	| | | |___| __  |___ ___  |_|  |_|_|  |     |___ ___| |_ ___ 
	| | | | . | __ -| . | . | | |   _ _   |   --| .'|  _|   | -_|
	|_____|  _|_____|___|___|_| |  |_|_|  |_____|__,|___|_|_|___|
	      |_|               |___|                                

  WpBooj :: Cache

*/

class WpBoojCache {

  function __construct(){
		add_action( 'save_post',    array( $this, 'clear_cache_post_save' ) );
  }

	/***
		Check
		@desc   : Retrieves a cache if it exists, otherwise returns False
		@todo   : Use INSERT ON DUPLICATE KEY UPDATE once table structure is correct for this support
		@params
	*/	
	public static function check( $post_id, $cache_type ){
		global $WpBooj_options;
		if( ! isset( $WpBooj_options['use_WpBoojCache'] ) || $WpBooj_options['use_WpBoojCache'] != 'on' ){
			return False;
		}
		global $wpdb;
		$seconds_cache_can_live = 1000;
		$time_ago = 86400;
		$time_back = time() - $time_ago;
		$dt = new DateTime("@$time_back");
		$dt = $dt->format('Y-m-d H:i:s');
		$sql = "SELECT * FROM {$wpdb->prefix}WpBoojCache WHERE 
			`type` = '{$cache_type}' AND
			`post_id` = {$post_id} AND
			`last_update_ts` > '{$dt}';";
		$response = $wpdb->get_results( $sql );
		if( count( $response ) == 0 ){
			return False;
		} else {
			$loaded_cache = unserialize( $response[0]->data );
			return $loaded_cache;
		}
	}

	/***
		Store
		@desc   : Stores a cache to be pulled up quickly later.
		@todo   : Use INSERT ON DUPLICATE KEY UPDATE once table structure is correct for this support
		@params
			$post_id   : int( ) use 0 or null for non post related caches.
			$cache_type : string( ) 
			$data      : array( ) info to be stored
	*/
	public static function store( $post_id, $cache_type, $data ){
		$data = mysql_real_escape_string( serialize( $data ) ); 
		global $wpdb;
		// check if an old cache exists to overwrite
		$sql = "SELECT * FROM {$wpdb->prefix}WpBoojCache WHERE 
			`post_id` = '' AND 
			`cache_type` = '$cache_type' 
			ORDER BY `last_update_ts` 
			DESC LIMIT 1;";
		$response = $wpdb->get_results( $sql );
		if( count( $response ) > 0 ){
			$sql = "UPDATE {$wpdb->prefix}WpBoojCache SET 
				`data` = '{$data}'
				WHERE `post_id` = '$post_id' AND
				`cache_type` = '$cache_type';";
		} else {
			$sql  = "INSERT INTO {$wpdb->prefix}WpBoojCache
				( `cache_type`,`post_id`,`data` ) 
				VALUES( '$cache_type', '$post_id', '$data' );";
		}
		$wpdb->query( $sql );
	}

	public static function clear_cache( $post_id = None, $type_id = None ){
		global $wpdb;
		if( $post_id == None && $type_id == None ) { 		// remove all caches
			$sql = "TRUNCATE table {$wpdb->prefix}WpBoojCache;";
		} elseif( $post_id != None && $type_id == None ){
			$sql = "DELETE FROM {$wpdb->prefix}WpBoojCache WHERE
				`post_id` = '{$post_id}';";
		} elseif( $post_id == None && $type_id != None ){
			$sql = "DELETE FROM {$wpdb->prefix}WpBoojCache WHERE
				`type` = '{$type_id}'; ";
		} else {
			$sql = '';
		}
		$wpdb->query( $sql );
		$sql = "SELECT count(*) as c FROM {$wpdb->prefix}WpBoojCache;";
		$results = $wpdb->get_results( $sql );
		if ( $results[0]->c > 100000){
			$sql = "TRUNCATE table {$wpdb->prefix}WpBoojCache;";
			$wpdb->query( $sql );
		}
	}
	
	public static function clear_cache_post_save( $post_id ){
		WpBoojCache::clear_cache( $post_id = $post_id );
	}

}

/* End File: includes/WpBoojCache.php */
