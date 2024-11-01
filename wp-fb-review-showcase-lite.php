<?php defined('ABSPATH') or die('No script please!');
/*
  Plugin Name: Social Review
  Plugin URI:  https://accesspressthemes.com/wordpress-plugins/wp-fb-review-showcase-lite/
  Description: Showcase Your Facebook Page Reviews anywhere using shortcode as well as widgets.
  Version:     1.0.9
  Author:      AccessPress Themes
  Author URI:  http://accesspressthemes.com
  License:     GPLv2 or later
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
  Domain Path: /languages
  Text Domain: wp-fb-review-showcase-lite
 */
include( plugin_dir_path(__FILE__) . '/classes/class-wpfrsl-library.php'); 
include('Facebook/autoload.php'); 

/**
 * Main Class
 */
if (!class_exists('WPFRSL_Class')) 
{

  class WPFRSL_Class extends WPFRSL_Library{

    function __construct() 
    {
      // error_reporting(E_ERROR | E_WARNING | E_NOTICE | E_STRICT);

      $this->define_constants();
      
      add_action( 'plugins_loaded',array( $this, 'wpfrsl_text_domain' ));

      $this->includes();

      add_action('admin_post_wpfrsl_settings_save', array($this, 'wpfrsl_settings_save'));
    }

    public function define_constants()
    {
      defined('WPFRSL_VERSION') or define('WPFRSL_VERSION', '1.0.9'); //plugin version

      defined('WPFRSL_TITLE') or define('WPFRSL_TITLE', 'Access Keys Facebook Reviews'); //plugin version

      defined('WPFRSL_TD') or define('WPFRSL_TD', 'wpfrsl-review'); //plugin's text domain

      defined('WPFRSL_CSS_PREFIX') or define('WPFRSL_CSS_PREFIX', 'wpfrsl-'); //plugin's text domain

      defined('WPFRSL_IMG_DIR') or define('WPFRSL_IMG_DIR', plugin_dir_url(__FILE__) .'assets/img/');

      defined('WPFRSL_BACKEND_IMG_DIR') or define('WPFRSL_BACKEND_IMG_DIR', plugin_dir_url(__FILE__) .'assets/backend/images/'); 

      defined('WPFRSL_FRONTEND_IMG_DIR') or define('WPFRSL_FRONTEND_IMG_DIR', plugin_dir_url(__FILE__) . 'assets/frontend/images/'); 

      defined('WPFRSL_BACKEND_JS_DIR') or define('WPFRSL_BACKEND_JS_DIR', plugin_dir_url(__FILE__) . 'assets/backend/js/');  

      defined('WPFRSL_FRONTEND_JS_DIR') or define('WPFRSL_FRONTEND_JS_DIR', plugin_dir_url(__FILE__) . 'assets/frontend/js/');  

      defined('WPFRSL_BACKEND_CSS_DIR') or define('WPFRSL_BACKEND_CSS_DIR', plugin_dir_url(__FILE__) . 'assets/backend/css/'); 

      defined('WPFRSL_FRONTEND_CSS_DIR') or define('WPFRSL_FRONTEND_CSS_DIR', plugin_dir_url(__FILE__) . 'assets/frontend/css/'); 

      defined('WPFRSL_PATH') or define('WPFRSL_PATH', plugin_dir_path(__FILE__));

      defined('WPFRSL_URL') or define('WPFRSL_URL', plugin_dir_url(__FILE__)); 
    }

    public function includes()
    {
      include(WPFRSL_PATH . '/classes/class-wpfrsl-enqueue.php');  
      include(WPFRSL_PATH . '/classes/class-wpfrsl-activation.php');
      include(WPFRSL_PATH . '/classes/class-wpfrsl-register-postypes.php');
      include(WPFRSL_PATH . '/classes/class-wpfrsl-shortcodes.php');
      include(WPFRSL_PATH . '/classes/class-register-widget.php');
      include(WPFRSL_PATH . '/classes/class-wpfrsl-model.php'); 
      include(WPFRSL_PATH . '/classes/class-wpfrsl-api-settings.php');
    }


    public function wpfrsl_text_domain()
    {
      load_plugin_textdomain( 'wpfrsl-review', False, plugin_dir_url( __FILE__ ).'languages' );
    }  

  }

  $wpfrsl_object = new WPFRSL_Class();
}