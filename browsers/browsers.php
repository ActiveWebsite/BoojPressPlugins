<?php

/* 
Plugin Name: Conditional Stylesheets and Body Classes
Plugin URI: http://qstudio.us/plugins/
Description: Add conditional browser stylesheets and body class declarations
Version: 0.4.7
Author: Q Studio
Author URI: https://qstudio.us/
License: GPL2
Text Domain: q-browsers
Class: Q_Browsers
Instance: $q_browsers
*/

// quick check :) ##
defined( 'ABSPATH' ) OR exit;

// define constants ##
define( 'Q_BROWSERS_VERSION', '0.4.7' ); // version ##
define( 'Q_BROWSERS_PATH', dirname(__FILE__) );

if ( !class_exists( "Q_Browsers" ) ) {
    
    // instatiate plugin via WP init ##
    add_action( 'wp_enqueue_scripts', array ( 'Q_Browsers', 'init' ), 1 );
    
    class Q_Browsers {
    
        // variables ##
        public $comment_log = array();
        public $useragent;
        
        
        /**
        * Creates a new instance.
        *
        * @wp-hook init
        * @see    __construct()
        * @return void
        */
        public static function init() {
            new self;
        }
    
        
        /**
        * Class contructor
	    *
	    * @since   0.2
	    **/
	    public function __construct() {
            
            // activation ##
            register_activation_hook( __FILE__, array ( $this, 'register_activation_hook' ) );
            
            // deactivation ##
            register_deactivation_hook( __FILE__, array ( $this, 'register_deactivation_hook' ) );
            
            // uninstall ##
            // TODO ##
            
            // load in mobile detect class ##
            if ( !class_exists('Mobile_Detect') ) {
                include( Q_BROWSERS_PATH . '/library/mobile_detect.php');	
            }

            // instatiate class ##
            $this->detect = new Mobile_Detect();
            $this->detect->setDetectionType('extended'); // extended search ##
            
            // grab user agent ##
            $this->useragent = $_SERVER['HTTP_USER_AGENT'] ? $_SERVER['HTTP_USER_AGENT'] : false;
            
            if ( is_admin() ) {
                
                // text-domain ##
                add_action ( 'plugins_loaded', array ( $this, 'load_plugin_textdomain' ), 1 );
                
                // plugin URL ##
                $this->plugin_URL = WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__));
                $this->plugin_dir_path = plugin_dir_url(__FILE__);
                
            } else {

                // conditional stylesheets for browser tweaks ##
                add_action( 'wp_enqueue_scripts', array ( $this, 'enqueue_scripts_conditional' ), 10000000 ); // load them late ##

                // browser body_class ##
                add_filter( 'body_class', array ( $this, 'body_classes' ), 1 );
                
                // comments ##
                add_action( 'wp_footer', array ( $this, 'comments' ), 1000 );
                
            }
                
        }
        
        
        /*
         * plugin activation 
         * 
         * @since   0.2
         */
        public function register_activation_hook() {
            
            $q_browsers = array( 
                'configured'    => true 
                ,'version'      => Q_BROWSERS_VERSION
            );
            
            // init running, so update configuration flag ##
            add_option( 'q-browsers', $q_browsers, '', true );
            
        }

        
        /* 
         * plugin deactivation 
         * 
         * @since   0.2
         */
        public function register_deactivation_hook() {
            
            // deconfigure plugin ##
            delete_option('q-browsers');
            
        }

        
        /*
         * Load Plugin Text Domain ##
         * 
         * @since   0.1
         */
        public function load_plugin_textdomain() {
            
            load_plugin_textdomain( 'q-browsers', false, basename( dirname( __FILE__ ) ) . '/languages' );
            
        }
        
        
        /*
         * Add conditional Stylesheets  - if found
         * 
         * example file name /theme/browsers-firefox.css
         *  $check = array (
         *      1 => $browser_type, // browser ##
         *      2 => $browser_agent.'-'.$browser_type // client-browser ##
         * );
         * 
         * @since    0.2
         */
        public function enqueue_scripts_conditional() {

            // grab list of browsers ##
            $browser = $this->browsers();

            // array to check ##
            $check = array (
                1 => $browser['type'], // browser ##
                2 => $browser['type'].'-'.$browser['version'], // client-version ##
                3 => $browser['agent'].'-'.$browser['type'] // client-browser ##
            );

            // set prefix & suffix ##
            $check_prefix = 'browsers';
            $check_suffix = '.css';

            // get the theme path & URL ##
            $theme_path = get_stylesheet_directory();
            $theme_url = get_stylesheet_directory_uri();
            
            // allow for resources to be in the theme root or follow the Q structure ( /library/css/ )
            $theme_structure = array(
                'root'      => ''
                ,'q'        => 'library/css/'
            );
            
            // loop array ##
            foreach ( $check as $b => $v ) {

                // compile file name ##
                $load = ''; // empty variable ##
                $check_this = $check_prefix.'-'.$check[$b].$check_suffix;
                
                // allow for variable file structure in theme folders ##
                foreach ( $theme_structure as $structure ) {
                
                    if ( file_exists( "{$theme_path}/{$structure}{$check_this}" ) ) { // parent first ##

                        $this->comment_log[] = 'Found: '.$theme_url.'/'.$structure.$check_this.' | handle: '.$check_prefix.'-'.$check[$b];

                        $load = "{$theme_url}/{$structure}{$check_this}";
                        wp_register_style( $check_prefix.'-'.$check[$b], $load, '', '0.1', 'all' );
                        wp_enqueue_style( $check_prefix.'-'.$check[$b] );

                    } else {

                        $this->comment_log[] = 'Not Found: '.$theme_url.'/'.$structure.$check_this;

                    }
                
                } // structure ##

            } // loop ##

        }
        
        
        /*
         * Check which browser is being used         * 
         * 
         * @since 0.1
         */
        public function browsers(){

            // browser & version ##
            $client_version = '';
            if (stristr($this->useragent,"firefox")) {
                $client_type = "firefox"; // pretty browser name ##
            } elseif ( preg_match( '/Chrome/', $this->useragent ) ) { 	
                $client_type = "chrome"; 
                // get version ##
                if ( preg_match( "#Chrome/(.+?)\.#", $this->useragent, $match ) ) {
                    $client_version = $match[1];
                }
            } elseif (stristr($this->useragent,"safari")) {
                $client_type = "safari";
            } elseif (stristr($this->useragent,"opera")) {
                $client_type = "opera";
            } elseif (stristr($this->useragent,"msie")) {
                $client_type = "msie";
            /*
            } elseif (stristr($this->useragent,"msie 6")) {
                $client_type = "msie";
                $client_version = '6';
            } elseif (stristr($this->useragent,"msie 7")) {
                $client_type = "msie";
                $client_version = '7';
            } elseif (stristr($this->useragent,"msie 8")) {
                $client_type = "msie";
                $client_version = '8';
            } elseif (stristr($this->useragent,"msie 9")) {
                $client_type = "msie";
                $client_version = '9';
            } elseif (stristr($this->useragent,"msie 10")) {
                $client_type = "msie";
                $client_version = '10';
             */
            } else {
                $client_type = "other";
            }

            // version ##
            if ( $client_type == "msie" && preg_match( '#MSIE ([0-9]{1,2}\.[0-9]{0,2});#si', $this->useragent, $m ) ) {

                $client_version = $m[1];

            } elseif ( !$client_version && preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $this->useragent, $matches )) { 

                $client_version = $matches[1]; 

            } 

            // client OS ( linux, mac, windows )
            if ( stristr( $this->useragent, "windows" ) ) {
                $client_agent = 'windows'; // windows ##
            } elseif ( stristr( $this->useragent, "linux" ) ) {
                $client_agent = 'linux'; // linux ##
            } elseif ( stristr( $this->useragent, "macintosh" ) ) {
                $client_agent = 'mac'; // linux ##
            } else {
                $client_agent = 'other'; // what are you using? ##    
            }

            return array(
                'type'      => $client_type,
                'agent'     => $client_agent,
                'version'   => intval($client_version),
                'version_verbose'   => ($client_version)
            );

        }
        
        
        // let's add our borrowed is__() functions ##
        // src: http://scott.ee/journal/mobble/ ##

        /***************************************************************
        * Function is_iphone
        * Detect the iPhone
        ***************************************************************/
        public function is_iphone() {
            return($this->detect->isIphone());
        }

        /***************************************************************
        * Function is_ipad
        * Detect the iPad
        ***************************************************************/
        public function is_ipad() {
            return($this->detect->isIpad());
        }

        /***************************************************************
        * Function is_ipod
        * Detect the iPod, most likely the iPod touch
        ***************************************************************/
        public function is_ipod() {
            return($this->detect->is('iPod'));
        }

        /***************************************************************
        * Function is_android
        * Detect an android device.
        ***************************************************************/
        public function is_android() {
            return($this->detect->isAndroidOS());
        }

        /***************************************************************
        * Function is_blackberry
        * Detect a blackberry device 
        ***************************************************************/
        public function is_blackberry() {
            return($this->detect->isBlackBerry());
        }

        /***************************************************************
        * Function is_opera_mobile
        * Detect both Opera Mini and hopfully Opera Mobile as well
        ***************************************************************/
        public function is_opera_mobile() {
            return($this->detect->isOpera());
        }

        /***************************************************************
        * Function is_palm - to be phased out as not using new detect library?
        * Detect a webOS device such as Pre and Pixi
        ***************************************************************/
        public function is_palm() {
            _deprecated_function('is_palm', '1.2', 'is_webos');
            return($this->detect->is('webOS'));
        }

        /***************************************************************
        * Function is_webos
        * Detect a webOS device such as Pre and Pixi
        ***************************************************************/
        public function is_webos() {
            return($this->detect->is('webOS'));
        }

        /***************************************************************
        * Function is_symbian
        * Detect a symbian device, most likely a nokia smartphone
        ***************************************************************/
        public function is_symbian() {
            return($this->detect->is('Symbian'));
        }

        /***************************************************************
        * Function is_windows_mobile
        * Detect a windows smartphone
        ***************************************************************/
        public function is_windows_mobile() {
            return($this->detect->is('WindowsMobileOS') || $this->detect->is('WindowsPhoneOS'));
        }

        /***************************************************************
        * Function is_lg
        * Detect an LG phone
        ***************************************************************/
        public function is_lg() {
            _deprecated_function('is_lg', '1.2');
            return(preg_match('/LG/i', $this->useragent));
        }

        /***************************************************************
        * Function is_motorola
        * Detect a Motorola phone
        ***************************************************************/
        public function is_motorola() {
            return($this->detect->is('Motorola'));
        }

        /***************************************************************
        * Function is_nokia
        * Detect a Nokia phone
        ***************************************************************/

        public function is_nokia() {
            _deprecated_function('is_nokia', '1.2');
            return(preg_match('/Series60/i', $this->useragent) || preg_match('/Symbian/i', $this->useragent) || preg_match('/Nokia/i', $this->useragent));
        }

        /***************************************************************
        * Function is_samsung
        * Detect a Samsung phone
        ***************************************************************/
        public function is_samsung() {
            return($this->detect->is('Samsung'));
        }

        /***************************************************************
        * Function is_samsung_galaxy_tab
        * Detect the Galaxy tab
        ***************************************************************/
        public function is_samsung_galaxy_tab() {
            _deprecated_function('is_samsung_galaxy_tab', '1.2', 'is_samsung_tablet');
            return is_samsung_tablet();
        }

        /***************************************************************
        * Function is_samsung_tablet
        * Detect the Galaxy tab
        ***************************************************************/
        public function is_samsung_tablet() {
            return($this->detect->is('SamsungTablet'));
        }

        /***************************************************************
        * Function is_kindle
        * Detect an Amazon kindle
        ***************************************************************/
        public function is_kindle() {
            return($this->detect->is('Kindle'));
        }

        /***************************************************************
        * Function is_sony_ericsson
        * Detect a Sony Ericsson
        ***************************************************************/
        public function is_sony_ericsson() {
            return($this->detect->is('Sony'));
        }

        /***************************************************************
        * Function is_nintendo
        * Detect a Nintendo DS or DSi
        ***************************************************************/
        public function is_nintendo() {
            return(preg_match('/Nintendo DSi/i', $this->useragent) || preg_match('/Nintendo DS/i', $this->useragent));
        }


        /***************************************************************
        * Function is_smartphone
        * Grade of phone A = Smartphone - currently testing this
        ***************************************************************/
        public function is_smartphone() {
            $grade = $this->detect->mobileGrade();
            if ($grade == 'A' || $grade == 'B') {
                return true;
            } else {
                return false;
            }
        }

        /***************************************************************
        * Function is_handheld
        * Wrapper function for detecting ANY handheld device
        ***************************************************************/
        public function is_handheld() {
            return( $this->is_mobile() || $this->is_iphone() || $this->is_ipad() || $this->is_ipod() || $this->is_android() || $this->is_blackberry() || $this->is_opera_mobile() || $this->is_webos() || $this->is_symbian() || $this->is_windows_mobile() || $this->is_motorola() || $this->is_samsung() || $this->is_samsung_tablet() || $this->is_sony_ericsson() || $this->is_nintendo());
        }

        /***************************************************************
        * Function is_mobile
        * For detecting ANY mobile phone device
        ***************************************************************/
        public function is_mobile() {
            if ( $this->is_tablet() ) return false;
            return ($this->detect->isMobile());
        }

        /***************************************************************
        * Function is_ios
        * For detecting ANY iOS/Apple device
        ***************************************************************/
        public function is_ios() {
            return($this->detect->isiOS());
        }

        /***************************************************************
        * Function is_tablet
        * For detecting tablet devices (needs work)
        ***************************************************************/
        public function is_tablet() {
            return($this->detect->isTablet());
        }

        /***************************************************************
        * Function is_desktop
        * For detecting desktop devices (needs work)
        ***************************************************************/
        public function is_desktop() {
            return( !$this->detect->is_handheld() );
        }


        /***************************************************************
        * Function is_touch
        * Wrapper function for detecting ANY touchscreen device
        ***************************************************************/
        public function is_touch() {
            if ( defined( Q_RESPONSIVE_FORCE_TOUCH ) && Q_RESPONSIVE_FORCE_TOUCH === true ) { return true; }
            return( $this->is_mobile() || $this->is_iphone() || $this->is_ipad() || $this->is_ipod() || $this->is_android() || $this->is_blackberry() || $this->is_opera_mobile() || $this->is_webos() || $this->is_symbian() || $this->is_windows_mobile() || $this->is_motorola() || $this->is_samsung() || $this->is_samsung_tablet() || $this->is_sony_ericsson() || $this->is_nintendo() || $this->is_tablet() || $this->is_ios() );
        }
        
        
        /**
         * Add browser classes to html body tag
         * 
         * @since 0.1
         */
        public function body_classes( $classes ) {
            
            // grab the post object ##
            global $post;
            
             // add post type
            if ( $post && is_object($post) ) $classes[] = 'posttype-'.$post->post_type; // posttype-type ##
            
            // grab list of browsers ##
            $browser = $this->browsers();
            
            // add browser, version and OS body tags ##
            $classes[] = 'browsers-'.$browser['type']; // client ##
            $classes[] = 'browsers-'.$browser['type'].'-'.$browser['version']; // client-version ##
            $classes[] = 'browsers-'.$browser['agent'].'-'.$browser['type']; // OS-client ##
            
            // add mobile / tablet classes ##
            global $is_lynx, $is_gecko;
            #global $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome;

            // top level
            if ( $this->is_handheld() ) { $classes[] = "browsers-handheld"; };
            if ( $this->is_mobile() ) { $classes[] = "browsers-mobile"; };
            if ( $this->is_ios() ) { $classes[] = "browsers-ios"; };
            if ( $this->is_tablet() ) { $classes[] = "browsers-tablet"; };

            // specific 
            if ( $this->is_iphone() ) { $classes[] = "browsers-iphone"; };
            if ( $this->is_ipad() ) { $classes[] = "browsers-ipad"; };
            if ( $this->is_ipod() ) { $classes[] = "browsers-ipod"; };
            if ( $this->is_android() ) { $classes[] = "browsers-android"; };
            if ( $this->is_blackberry() ) { $classes[] = "browsers-blackberry"; };
            if ( $this->is_opera_mobile() ) { $classes[] = "browsers-opera-mobile";}
            if ( $this->is_webos() ) { $classes[] = "browsers-webos";}
            if ( $this->is_symbian() ) { $classes[] = "browsers-symbian";}
            if ( $this->is_windows_mobile() ) { $classes[] = "browsers-windows-mobile"; }
            //if (is_lg()) { $classes[] = "lg"; }
            if ( $this->is_motorola()) { $classes[] = "browsers-motorola"; }
            //if (is_smartphone()) { $classes[] = "smartphone"; }
            //if (is_nokia()) { $classes[] = "nokia"; }
            if ( $this->is_samsung()) { $classes[] = "browsers-samsung"; }
            if ( $this->is_samsung_tablet()) { $classes[] = "browsers-samsung-tablet"; }
            if ( $this->is_sony_ericsson()) { $classes[] = "browsers-sony-ericsson"; }
            if ( $this->is_nintendo()) { $classes[] = "browsers-nintendo"; }

            // bonus
            if ( !$this->is_handheld()) { $classes[] = "browsers-desktop"; }

            if ($is_lynx) { $classes[] = "browsers-lynx"; }
            if ($is_gecko) { $classes[] = "browsers-gecko"; }
            #if ($is_opera) { $classes[] = "opera"; }
            #if ($is_NS4) { $classes[] = "ns4"; }
            #if ($is_safari) { $classes[] = "safari"; }
            #if ($is_chrome) { $classes[] = "chrome"; }
            #if ($is_IE) { $classes[] = "ie"; }

            // remove duplicates ##
            $classes = array_unique($classes); 
            
            return $classes; // return classes ##

        }
        
        
        /*
         * Add some useful comments in the footer for the admin to check
         * 
         * @since 0.1
         */
        public function comments() {
            
            // is the user logged in ? ##
            if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) { // admins only ##
            
                if ( is_array ( $this->comment_log ) && $this->comment_log[0] ) { // comments found ##

                    echo PHP_EOL."<!-- "; _e('Browsers Comments', 'q-browsers'); echo ": -->".PHP_EOL;

                    foreach ( $this->comment_log as $comment ) {

                        echo "<!-- {$comment} -->".PHP_EOL;

                    }

                }

            }

        }
        
        
    }
    
}
