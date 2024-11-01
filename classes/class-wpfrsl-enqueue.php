<?php defined('ABSPATH') or die('No script please!!');

if ( !class_exists('WPFRSL_Enqueue') ) 
{
    
  class WPFRSL_Enqueue extends WPFRSL_Library{

  	function __construct()
  	{
  		add_action('admin_enqueue_scripts', array($this, 'wpfrsl_register_backend_assets'));
      add_action( 'wp_enqueue_scripts', array($this, 'wpfrsl_register_frontend_assets') );
  	}

    public function wpfrsl_register_backend_assets()
    {
      wp_enqueue_script('wpfrsl-admin-js', WPFRSL_BACKEND_JS_DIR. 'admin-script.js', array('jquery'), WPFRSL_VERSION);
      wp_enqueue_style( 'wpfrsl-admin-css', WPFRSL_BACKEND_CSS_DIR. 'admin-style.css', '', WPFRSL_VERSION );
      wp_enqueue_style( 'wpfrsl-fontawesome-style', WPFRSL_FRONTEND_CSS_DIR.'font-awesome/font-awesome.min.css', false, WPFRSL_VERSION );

      wp_enqueue_script('wpfrs-admin-wpac', WPFRSL_BACKEND_JS_DIR. 'wpac.js', array('jquery'), WPFRSL_VERSION);
      wp_enqueue_script('wpfrs-admin-wpactime', WPFRSL_BACKEND_JS_DIR. 'wpac-time.js', array('jquery'), WPFRSL_VERSION);

      $backend_js_obj = array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'ajax_nonce' => wp_create_nonce('wpfrsl_backend_ajax_nonce'),
          'page_number_loader'=> WPFRSL_PATH . 'assets/img/ajax-loader.gif'
      );
      wp_localize_script('wpfrsl-admin-js', 'wpfrsl_backend_js_obj', $backend_js_obj);
    }

    public function wpfrsl_register_frontend_assets()
    {
      wp_enqueue_style( 'wpfrsl-frontend-css', WPFRSL_FRONTEND_CSS_DIR. 'frontend-style.css', false, WPFRSL_VERSION );
      wp_enqueue_style( 'wpfrsl-fontawesome-style', WPFRSL_FRONTEND_CSS_DIR.'font-awesome/font-awesome.min.css', false, WPFRSL_VERSION );
      wp_enqueue_style( 'wpfrsl-elegant-icons-style', WPFRSL_FRONTEND_CSS_DIR.'elegant-icons/elegant-icons.css', false, WPFRSL_VERSION );
      wp_enqueue_style( 'wpfrsl-flaticons-star-style', WPFRSL_FRONTEND_CSS_DIR.'flat-star-icon/flaticon.css', false, WPFRSL_VERSION );
      wp_enqueue_style( 'wpfrsl-bxslider-style', WPFRSL_FRONTEND_CSS_DIR.'jquery.bxslider.css', false, WPFRSL_VERSION );
      wp_enqueue_script('wpfrsl-bxslider-script', WPFRSL_FRONTEND_JS_DIR.'jquery.bxslider.js',array('jquery'), WPFRSL_VERSION);
      wp_enqueue_style( 'wpfrsl-animate-style', WPFRSL_FRONTEND_CSS_DIR .'animate.css', WPFRSL_VERSION );
      wp_enqueue_script('wpfrsl-wow-animation', WPFRSL_FRONTEND_JS_DIR.'wow.js',array('jquery'), WPFRSL_VERSION);
      wp_enqueue_script( 'wpfrsl-frontend-js', WPFRSL_FRONTEND_JS_DIR.'frontend-script.js', array('jquery'), WPFRSL_VERSION );
      wp_enqueue_style('wpfrsl-google-font-poppins', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700', false, WPFRSL_VERSION);
      wp_enqueue_style('wpfrsl-google-font-rubik', 'https://fonts.googleapis.com/css?family=Rubik:300,400,500,700', false, WPFRSL_VERSION);
      wp_enqueue_style('wpfrsl-google-font-open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700', false, WPFRSL_VERSION);
      wp_enqueue_style('wpfrsl-google-font-lato', 'https://fonts.googleapis.com/css?family=Lato:300,400,700', false, WPFRSL_VERSION);
      wp_enqueue_style('wpfrsl-google-font-oxygen', 'https://fonts.googleapis.com/css?family=Oxygen:300,400,700', false, WPFRSL_VERSION);
      wp_enqueue_style('wpfrsl-google-font-source-sans', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700', false, WPFRSL_VERSION);
      wp_enqueue_style('wpfrsl-google-font-merriweather', 'https://fonts.googleapis.com/css?family=Merriweather:300,400,500,600,700', false, WPFRSL_VERSION);


      $frontend_js_obj = array(
          'ajax_url' => admin_url('admin-ajax.php'),
          'ajax_nonce' => wp_create_nonce('wpfrsl_frontend_ajax_nonce'),
          'page_number_loader'=> WPFRSL_PATH . 'assets/img/ajax-loader.gif'
      );
      wp_localize_script('wpfrsl-frontend-js', 'wpfrsl_frontend_js_obj', $frontend_js_obj);
    }
  	
  }

  new WPFRSL_Enqueue();

}