<?php

class wtd_plugin_update {

	private $slug; // plugin slug
	private $pluginData; // plugin data
	private $username; // GitHub username
	private $repo; // GitHub repo name
	private $pluginFile; // __FILE__ of our plugin
	private $githubAPIResult; // holds data from GitHub
	private $accessToken; // GitHub private repo token
	public $wasActive;

	function __construct(){
		add_filter("pre_set_site_transient_update_plugins", array($this, "setTransitent"));
		add_filter("plugins_api", array($this, "setPluginInfo"), 10, 3);
		add_filter("upgrader_pre_install", array($this, "preInstall"), 10, 3);
		add_filter("upgrader_post_install", array($this, "postInstall"), 10, 3);
		$this->pluginFile = WTD_PLUGIN_FILE;
		//DO NOT SYNC THE BELOW LINES - PRODUCTION REPOSITORY
		$this->repo = 'whattodoplugin';
		$this->username = 'whattodoinfo';
		//$this->accessToken = '0cf0ece1a93689f06f5f9ec5d61343a4e2220344';  // Production Plugin Token
		$this->accessToken = '3464b502aa0a87e2282f72de9a237ea29a407609'; //New Correct Access Token
        add_action('admin_head', array($this, 'admin_head'));
    }

	// Get information regarding our plugin from WordPress
	private function initPluginData() {
		$this->slug = plugin_basename($this->pluginFile);
		$this->pluginData = get_plugin_data($this->pluginFile);
		$this->wasActive = is_plugin_active($this->slug);
	}

	// Get information regarding our plugin from GitHub
	private function getRepoReleaseInfo() {
		// Only do this once
		if(!empty($this->githubAPIResult))
			return;
		// Query the GitHub API
		$url = "https://api.github.com/repos/{$this->username}/{$this->repo}/releases";
		// We need the access token for private repos
		if(!empty($this->accessToken))
			$url = add_query_arg(array("access_token" => $this->accessToken), $url);
		// Get the results
		$this->githubAPIResult = wp_remote_retrieve_body(wp_remote_get($url));
		if(!empty($this->githubAPIResult))
			$this->githubAPIResult = @json_decode($this->githubAPIResult);
		// Use only the latest release
		if(is_array($this->githubAPIResult))
			$this->githubAPIResult = $this->githubAPIResult[0];
	}

	// Push in plugin version information to get the update notification
	public function setTransitent($transient){
		// If we have checked the plugin data before, don't re-check
		if(empty($transient->checked))
			return $transient;
		// Get plugin & GitHub release information
		$this->initPluginData();
		$this->getRepoReleaseInfo();
		// Check the versions if we need to do an update
		$doUpdate = version_compare($this->githubAPIResult->tag_name, $transient->checked[$this->slug]);
		// Update the transient to include our updated plugin data
		if($doUpdate == 1){
			$package = $this->githubAPIResult->zipball_url;
			// Include the access token for private GitHub repos
			if(!empty($this->accessToken))
				$package = add_query_arg(array("access_token" => $this->accessToken), $package);
			$obj = new stdClass();
			$obj->slug = $this->slug;
			$obj->new_version = $this->githubAPIResult->tag_name;
			$obj->url = $this->pluginData["PluginURI"];
			$obj->package = $package;
			$transient->response[$this->slug] = $obj;
		}
		return $transient;
	}

	// Push in plugin version information to display in the details lightbox
	public function setPluginInfo($false, $action, $response){
		// Get plugin & GitHub release information
		$this->initPluginData();
		$this->getRepoReleaseInfo();
		// If nothing is found, do nothing
		if(empty($response->slug) || $response->slug != $this->slug)
			return $false;
		// Add our plugin information
		$response->last_updated = $this->githubAPIResult->published_at;
		$response->slug = $this->slug;
		$response->plugin_name  = $this->pluginData["Name"];
		$response->name  = $this->pluginData["Name"];
		$response->version = $this->githubAPIResult->tag_name;
		$response->author = $this->pluginData["AuthorName"];
		$response->homepage = $this->pluginData["PluginURI"];
		// This is our release download zip file
		$downloadLink = $this->githubAPIResult->zipball_url;
		// Include the access token for private GitHub repos
		if(!empty($this->accessToken))
			$downloadLink = add_query_arg(array("access_token" => $this->accessToken), $downloadLink);
		$response->download_link = $downloadLink;
		// We're going to parse the GitHub markdown release notes, include the parser
		require_once(plugin_dir_path(__FILE__) . "Parsedown.php");
		// Create tabs in the lightbox
		$response->sections = array(
			'description' => $this->pluginData["Description"],
			'changelog' => class_exists("Parsedown") ? Parsedown::instance()->parse($this->githubAPIResult->body) : $this->githubAPIResult->body
		);
		// Gets the required version of WP if available
		$matches = null;
		preg_match("/requires:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches);
		if(!empty($matches)){
			if(is_array( $matches)){
				if(count($matches) > 1)
					$response->requires = $matches[1]; 
			}
		}
		// Gets the tested version of WP if available
		$matches = null;
		preg_match("/tested:\s([\d\.]+)/i", $this->githubAPIResult->body, $matches);
		if(!empty($matches)){
			if(is_array($matches)){
				if(count($matches) > 1)
					$response->tested = $matches[1];
			}
		}
		return $response;
	}

	/**
	 * Perform check before installation starts.
	 *
	 * @param  boolean $true
	 * @param  array   $args
	 * @return null
	 */
	public function preInstall($true, $args)
	{
		// Get plugin information
		$this->initPluginData();
	}

	// Perform additional actions to successfully install our plugin
	public function postInstall($true, $hook_extra, $result){
		$this->cleanupOldVersions();
		// Since we are hosted in GitHub, our plugin folder would have a dirname of
		// reponame-tagname change it to our original one:
        global $wp_filesystem;
        $plugin_path = WP_PLUGIN_DIR.DIRECTORY_SEPARATOR.dirname($this->slug);
        $wp_filesystem->move($result['destination'], $plugin_path);
        $result['destination'] = $plugin_path;
        // Re-activate plugin if needed
        if($this->wasActive)
            activate_plugin($this->slug);
        return $result;
	}

    public function notice(){
        $message = '<p>Due to your server\'s low file permissions, <strong>WTD Plug-in</strong> might deactivate on update.</p>
            <p>If so, after the update routine, please go to <a href="'.admin_url('plugins.php').'">Plug-ins</a> and re-activate it</p>';
        echo '<div class="error">'.$message.'</div>';
    }

    public function admin_head(){
        $updates = get_option('_site_transient_update_plugins');
        if(!empty($updates->response)){
	        foreach($updates->response as $slug => $plugin){
		        if(substr_count($slug, 'wtdplugin.php') && $plugin->new_version != WTD_VERSION){
			        if(!is_writable(dirname(WTD_PLUGIN_PATH)))
				        add_action('admin_notices', array($this, 'notice'));
			        break;
		        }
	        }
        }
    }

	public function cleanupOldVersions(){
		global $wpdb;
		if(get_option('wtd_db_version') != '1.0'){
			$wtd_pages = get_option(wtd_pages);
			//Delete Activities Page
			$args = array('post_type' => 'wtd_activity');
			$query = new WP_Query($args);
			if($query->found_posts){
				while($query->found_posts){
					foreach($query->posts as $post){
						wp_delete_post($post->ID, true);
					}
					$query = new WP_Query($args);
				}
			}
			//Delete Events Page
			$args = array('post_type' => 'wtd_event');
			$query = new WP_Query($args);
			if($query->found_posts){
				while($query->found_posts){
					foreach($query->posts as $post){
						wp_delete_post($post->ID, true);
					}
					$query = new WP_Query($args);
				}
			}
			//Delete Specials Page
			$args = array('post_type' => 'wtd_special');
			$query = new WP_Query($args);
			if($query->found_posts){
				while($query->found_posts){
					foreach($query->posts as $post){
						wp_delete_post($post->ID, true);
					}
					$query = new WP_Query($args);
				}
			}
			//Delete Coupons Page
			$args = array('post_type' => 'wtd_coupon');
			$query = new WP_Query($args);
			if($query->found_posts){
				while($query->found_posts){
					foreach($query->posts as $post){
						wp_delete_post($post->ID, true);
					}
					$query = new WP_Query($args);
				}
			}
			//Delete Pages
			$args = array(
				'post_type' => 'page',
				'meta_query' => array(
					array(
						'key' => 'wtd_page',
						'value' => array(
							'activities_page',
							'calendar_page',
							'dining_page',
							'specials_page',
							'map_page',
							'coupons_page',
							'search_page',
							'week_page',
							'weekspecials_page'),
						'compare' => 'IN')));
			$query = new WP_Query($args);
			if($query->found_posts){
				while($query->found_posts){
					foreach($query->posts as $post){
						wp_delete_post($post->ID, true);
					}
					$query = new WP_Query($args);
				}
			}
			//Delete Overview Page
			if(!empty($wtd_pages['overview-page']))
				wp_delete_post($wtd_pages['overview-page'], true);
			$query = "DROP TABLE IF EXISTS wp_wtd_meta";
			$wpdb->query($query);
			//Delete options
			delete_option('wtd_plugin');
			delete_option('wtd_pages');
			delete_option('wtd_plugin-transients');
			delete_option('wtd_feed');
			delete_option('wtd_nav_options');
			delete_option('wtd_syncing');
			delete_option('wtd_reseting');
			delete_option('wtd_updating');
			delete_option('wtd_terms_synced');
			delete_option('wtd_categories');
			delete_option('wtd_category_children');
			delete_option('wtd_resort_children');
			delete_option('wtd_location_children');
			delete_option('wtd_client_details');
			delete_option('wtd_excluded_parent_cats');
			delete_option('wtd_excluded_cats');
			delete_option('wtd_excluded_categories');
			delete_option('wtd_api_active');
			delete_option('wtd_mapped_categories');
			update_option('wtd_db_version','1.0');
		}
	}
}?>
