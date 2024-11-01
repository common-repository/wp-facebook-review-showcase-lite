<?php defined('ABSPATH') or die('No script kiddies please!!');
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'wppro_simple_html_dom.php';
if ( !class_exists('WPFRSL_Admin') ) 
{
  class WPFRSL_Admin extends WPFRSL_Library{    
      
    function __construct() 
    {
      add_action('init', array($this, 'wpfrsl_register_post_type')); //register custom post type

      add_action('admin_menu' , array($this, 'wpfrsl_add_plugin_menu'));
      add_filter( 'admin_footer_text', array( $this, 'wpfrsl_admin_footer_text' ) );
      add_filter( 'plugin_row_meta', array( $this, 'wpfrsl_plugin_row_meta' ), 10, 2 );
      add_action( 'admin_init', array( $this, 'wpfrsl_redirect_to_site' ), 1 );
      add_action('admin_post_wpfrsl_save_settings', array($this, 'wpfrsl_general_save_settings'));

      add_action('add_meta_boxes', array($this, 'wpfrsl_api_settings'));
      add_action('save_post', array($this, 'wpfrsl_save_api_settings'));

      add_action('add_meta_boxes', array($this, 'wpfrsl_review_settings') );
      add_action('save_post', array($this, 'wpfrsl_save_review_settings') );

      add_action('add_meta_boxes', array($this, 'wpfrsl_badge_settings'));
      add_action('save_post', array($this, 'wpfrsl_save_badge_settings'));

      add_action( 'add_meta_boxes', array($this, 'wpfrsl_display_settings') );
      add_action('save_post', array($this, 'save_wpfrsl_display_settings'));

      add_action( 'add_meta_boxes', array($this, 'wpfrsl_cache_settings') );
      add_action('save_post', array($this, 'save_wpfrsl_cache_settings'));

      /* add shortcode usages metabox on custum post page */
      add_action('add_meta_boxes', array($this, 'wpfrsl_shortcode_usage_metabox')); 

      add_action( 'add_meta_boxes', array( $this, 'wpfrsl_upgrade_pro' ) ); //upgrade to pro metabox

      /* To add the Custom Column on Custom Post */
      add_filter('manage_wpfrslreviews_posts_columns', array($this,'wpfrsl_columns_head')); 
      add_action('manage_wpfrslreviews_posts_custom_column', array($this,'wpfrsl_columns_content'), 10, 2); 

      add_action('wp_ajax_login_with_fb',array($this,'login_with_fb'));

      add_action('load-post-new.php',array($this,'wpfrsl_remove_preview_btn'));
      add_filter('post_row_actions', array($this, 'wpfrsl_remove_row_actions'), 10, 1);

      add_action('admin_post_delete_cache', array( $this, 'delete_cache' ));

      /* Download FB reviews on Page Select */
      add_action('wp_ajax_wpfrsl_ajax_download_review', array($this, 'wpfrsl_review_download'));  

      add_filter('preview_post_link', array($this,  'wpfrsl_change_post_link'), 10, 2);
      add_filter('post_type_link', array($this,  'wpfrsl_change_link'), 10, 2);
      add_action( 'template_redirect', array($this, 'wpfrsl_preview_redirect') );
      add_action('widgets_init', array($this, 'wpfrsl_widget_register')); //create review widgets
      add_action('admin_notices', array( $this, 'wpfrsl_admin_notices' ));
      add_action( 'current_screen', array($this,'wpfrsl_remove_add_new') );

      add_action('wp_ajax_asap_get_fbgraph_pages_action', array($this, 'asap_get_fbgraph_pages_action'));
      add_action('wp_ajax_nopriv_asap_get_fbgraph_pages_action', array($this, 'asap_get_fbgraph_pages_action'));
    }

    function wpfrsl_remove_add_new()
    {
      //Get user id
      $current_user = wp_get_current_user();
      $user_id = $current_user->ID;

      //Get number of posts authored by user
      $args = array('post_type' =>'wpfrslreviews', 'author'=>$user_id, 'fields'=>'ids');
      $count = count(get_posts($args));

      //Conditionally remove link:
      if($count == 1)
      {
        $screen = get_current_screen();
        if($screen->post_type == 'wpfrslreviews')
        {
          /*echo <style type="text/css"> .wp-admin #wpbody-content .wrap a.page-title-action { display:none; } </style> */
		}
        $page = remove_submenu_page( 'edit.php?post_type=wpfrslreviews', 'post-new.php?post_type=wpfrslreviews' );
      }
    }

    public function delete_cache()
    {
      if ( current_user_can('manage_options') ) {
        if ( isset($_GET[ '_cache_del_wpnonce' ]) && wp_verify_nonce($_GET[ '_cache_del_wpnonce' ], 'wpfrsl_delete_cache') ) {
            
          $wpfrsl_api_settings = get_post_meta($_GET['post_id'], 'wpfrsl_api_settings', true);
          $app_id = (isset($wpfrsl_api_settings['app_id']) && !empty($wpfrsl_api_settings['app_id']))?$wpfrsl_api_settings['app_id']:'';
          if(isset($app_id) && !empty($app_id)) 
          {
            $fb_transient = 'fb_' . md5($app_id); // set transient id  
            $fb_cache =  get_transient($fb_transient);
            $delete_status = delete_transient($fb_transient);
            if($delete_status) {                 
              wp_redirect(admin_url().'post.php?post=' . $_GET['post_id']. '&action=edit&message=wpfrsl_cache_message');
            }
            else if($fb_cache == NULL) {
              wp_redirect(admin_url().'post.php?post='. $_GET['post_id']  .'&action=edit&message=wpfrsl_no_delete_cache');
            }
          }  
        }
      }
    }

    public function wpfrsl_admin_notices()
    {
      if ( isset($_GET['message']) && ($_GET['message'] == 'wpfrsl_cache_message')) {
        echo '<div class="notice notice-success is-dismissible"><p>Cache Deleted Successfully</p></div>';
      }
      else if ( isset($_GET['message']) && ($_GET['message'] == 'wpfrsl_no_delete_cache')){
        echo '<div class="notice notice-error is-dismissible"><p>Failed to delete cache</p></div>';
      }

    }

    public function wpfrsl_widget_register() 
    {
      register_widget('WPFRSL_Widget');
    }

    /* Remove Preview Button from add-post screen */
    public function wpfrsl_remove_preview_btn()
    {
      if (isset($_GET['post_type']) && ($_GET['post_type'] == 'wpfrslreviews')) {
        add_action('admin_head', function() {
              echo '<style>
                     #post-preview
                      {
                        display:none !important;
                        visibility: hidden;              
                      } 
                    </style>';
        });

        //Get user id
        $current_user = wp_get_current_user();
        $user_id = $current_user->ID;

        //Get number of posts authored by user
        $args = array('post_type' =>'wpfrslreviews', 'author'=>$user_id, 'fields'=>'ids');
        $count = count(get_posts($args));

        //Conditionally remove link:
        if($count == 1)
        {
          wp_redirect(admin_url('edit.php') . '?post_type=wpfrslreviews');
        }
      }
    }

    public function wpfrsl_preview_redirect()
    {
      if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'wpfrsl_nonce' ) ) 
      {
        if ( isset( $_GET[ 'review_preview' ], $_GET[ 'reviewid' ] ) && $_GET[ 'review_preview' ] && is_user_logged_in() ) 
        {
          include(WPFRSL_PATH . 'includes/frontend/wpfrsl-preview.php');
          die();
        }
      }
    }

    /*
     * Change the default “preview” button for egpreviews posttype edit page
     */
    public function wpfrsl_change_post_link($preview_link)
    {
      if ( get_post_type() == 'wpfrslreviews' ) 
      {
        $post_status = get_post_status();
        if ( $post_status != 'auto-draft' ) 
        {
          $post_id = get_the_ID();
          $nonce = wp_create_nonce('wpfrsl_nonce');
          $link = site_url( '?review_preview=true&_wpnonce='.$nonce.'&reviewid=' . $post_id );
          return $link;
        }
        else{
          return $preview_link;
        }
      }
    }

    /* Change the link of the preview in edit page */
    public function wpfrsl_change_link($post_url,$post) 
    {
      if(get_post_type() == 'wpfrslreviews') {
        $nonce = wp_create_nonce('wpfrsl_nonce');
        return site_url( '?review_preview=true&_wpnonce='.$nonce.'&reviewid=' . $post->ID );
      }
      else {
        return $post_url;
      }
    }

    /* For Hiding Quick Edit Button Edit settings lists page */
    function wpfrsl_remove_row_actions($actions) 
    {
      // choose the post type where you want to hide the button
      if (get_post_type() == 'wpfrslreviews') { 
        unset($actions['inline hide-if-no-js']); // hides quickedit
        unset( $actions['trash'] );
      }
      return $actions;
    }

    /*
     *Function To register Post Type
     */
    public function wpfrsl_register_post_type()
    {
      load_plugin_textdomain(WPFRSL_TD, false, basename(dirname(__FILE__)) . '/languages/');
      $labels = array(
          'name'               => _x( 'Social Review', 'post type general name', WPFRSL_TD ),
          'singular_name'      => _x( 'Social Review', 'post type singular name', WPFRSL_TD ),
          'menu_name'          => _x( 'Social Review', 'admin menu', WPFRSL_TD ),
          'name_admin_bar'     => _x( 'Social Review', 'add new on admin bar', WPFRSL_TD ),
          'add_new'            => _x( 'Add New', 'Social Review', WPFRSL_TD ),
          'add_new_item'       => __( 'Add New Social Review', WPFRSL_TD ),
          'new_item'           => __( 'New Reviews', WPFRSL_TD ),
          'edit_item'          => __( 'Edit Reviews', WPFRSL_TD ),
          'view_item'          => __( 'View Reviews', WPFRSL_TD ),
          'all_items'          => __( 'All Reviews', WPFRSL_TD ),
          'search_items'       => __( 'Search Reviews', WPFRSL_TD ),
          'parent_item_colon'  => __( 'Parent Reviews:', WPFRSL_TD ),
          'not_found'          => __( 'No Reviews found.', WPFRSL_TD ),
          'not_found_in_trash' => __( 'No Reviews found in Trash.', WPFRSL_TD )
      );

      $args = array(
          'labels'             => $labels,
          'description'        => __( 'Description.', WPFRSL_TD ),
          'public'             => false,
          'publicly_queryable' => true,
          'show_ui'            => true,
          'show_in_menu'       => true,
          'menu_icon'          => 'dashicons-slides',
          'query_var'          => true,
          'rewrite'            => array( 'slug' => 'wpfrslreviews' ),
          'capability_type'    => 'post',
          'has_archive'        => true,
          'hierarchical'       => false,
          'menu_position'      => null,
          'supports'           => array( 'title')
      );
      register_post_type('wpfrslreviews', $args);
    }

    /*
    * Add Plugin Menu Page for API Credential Settings
    */
    public function wpfrsl_add_plugin_menu()
    {
      add_submenu_page('edit.php?post_type=wpfrslreviews', __('Help', WPFRSL_TD), __('Help', WPFRSL_TD), 'manage_options', 'wpfrsl-configuration-settings', array($this, 'wpfrsl_help_callback'));
      add_submenu_page('edit.php?post_type=wpfrslreviews', __('Documentation', WPFRSL_TD), __('Documentation', WPFRSL_TD), 'manage_options', 'wpfrsl-documentation', array($this, 'wpfrsl_documentation'));
      add_submenu_page('edit.php?post_type=wpfrslreviews', __('Check Premium Version', WPFRSL_TD), __('Check Premium Version', WPFRSL_TD), 'manage_options', 'wpfrsl-premium-ver', array($this, 'wpfrsl_premium_version'));
    }

    public function wpfrsl_help_callback() 
    {
      include(WPFRSL_PATH.'includes/backend/pages/wpfrsl-config-settings.php');
    }
    public function wpfrsl_admin_footer_text($text) 
    {
      global $post;
      if ( is_admin() && isset( $_GET['post'] ) && ! empty( $_GET['post'] )){
        if ( $post -> post_type == 'wpfrslreviews' ) {
            $link = 'https://wordpress.org/support/plugin/wp-facebook-review-showcase-lite/reviews/#new-post';
            $pro_link = 'https://accesspressthemes.com/wordpress-plugins/wp-fb-review-showcase/';
            $text = 'Enjoyed Social Review? <a href="' . $link . '" target="_blank">Please leave us a ★★★★★ rating</a> We really appreciate your support! | Try premium version of <a href="' . $pro_link . '" target="_blank">WP Facebook Review Showcase</a> - more features, more power!';
            return $text;
        } else {
            return $text;
        }
      }
    }

    function wpfrsl_plugin_row_meta( $links, $file )
    {
      if ( strpos( $file, 'wp-fb-review-showcase-lite.php' ) !== false ) {
        $new_links = array(
          'demo' => '<a href="http://demo.accesspressthemes.com/wordpress-plugins/wp-fb-review-showcase-lite/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span>Live Demo</a>',
          'doc' => '<a href="https://accesspressthemes.com/documentation/wp-fb-review-showcase-lite/" target="_blank"><span class="dashicons dashicons-media-document"></span>Documentation</a>',
          'support' => '<a href="http://accesspressthemes.com/support" target="_blank"><span class="dashicons dashicons-admin-users"></span>Support</a>',
          'pro' => '<a href="https://accesspressthemes.com/wordpress-plugins/wp-fb-review-showcase/" target="_blank"><span class="dashicons dashicons-cart"></span>Premium version</a>'
        );

        $links = array_merge( $links, $new_links );
      }
      return $links;
    }

    function wpfrsl_redirect_to_site()
    {
      if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'wpfrsl-documentation' ) {
        wp_redirect( 'https://accesspressthemes.com/documentation/wp-fb-review-showcase-lite/' );
        exit();
      }
      if ( isset( $_GET[ 'page' ] ) && $_GET[ 'page' ] == 'wpfrsl-premium-ver' ) {
        wp_redirect( 'https://accesspressthemes.com/wordpress-plugins/wp-fb-review-showcase/' );
        exit();
      }
    }

    /*
     * Function To Save The General Settings(Api Settings Page)
     */
    public function wpfrsl_general_save_settings()
    {
      if (!empty($_POST) && isset($_POST['wpfrsl_nonce_setup']) && wp_verify_nonce($_POST['wpfrsl_nonce_setup'], 'wpfrsl-nonce')) 
      {
        if(isset($_POST['wpfrsl_settings_submit']))
        {
          $_POST = array_map( 'stripslashes_deep', $_POST );
          $pages = get_option( 'wpfrsl_general_settings' );
          $wpfrsl_general_settings = $this->sanitize_array($_POST['wpfrsl_general_settings']); //sanitizing post array data
          $wpfrsl_general_settings['pages'] = ($this->sanitize_array($pages['pages'])); 
          update_option('wpfrsl_general_settings', $wpfrsl_general_settings);
          wp_redirect(admin_url('edit.php?post_type=wpfrslreviews&page=wpfrsl-configuration-settings&message=1'));
          exit();
        }
      }
    }

    public function wpfrsl_api_settings()
    {
      add_meta_box('wpfrsl_api_settings', __('Social Review API Settings', WPFRSL_TD), array($this, 'wpfrsl_api_settings_callback'), 'wpfrslreviews', 'normal', 'high');
    }

    public function wpfrsl_api_settings_callback()
    {
      wp_nonce_field(basename(__FILE__), 'wpfrsl_api_settings_nonce');
      include WPFRSL_PATH . 'includes/backend/post_type_metabox/wpfrsl-api-settings.php';
    }

    public function wpfrsl_save_api_settings($post_id)
    {
      if(isset($_POST['wpfrsl_api_settings_nonce']) && wp_verify_nonce($_POST['wpfrsl_api_settings_nonce'], 'wpfrsl-api-settings-nonce'))
      {
        $wpfrsl_api_settings = parent::sanitize_array($_POST['wpfrsl_api_settings']);
        update_post_meta($post_id, 'wpfrsl_api_settings', $wpfrsl_api_settings);
      }
      return;
    }
    
    /*
    * Add Metabox For Social Review Settings in the POST TYPE
    */
    public function wpfrsl_review_settings()
    {
      add_meta_box('wpfrsl_review_settings', __('Social Review Settings', WPFRSL_TD), array($this, 'wpfrsl_fb_review_settings'),'wpfrslreviews','normal','high');
    }

    /*
    * Callback function for Social Review Metabox
    */
    public function wpfrsl_fb_review_settings()
    {
      // Add nonce for security and authentication.
      wp_nonce_field(basename(__FILE__), 'wpfrsl_review_settings_nonce');
      include WPFRSL_PATH .'includes/backend/post_type_metabox/wpfrsl-review-settings.php';
    }

    /*
    * Function to save the social review settings from the metabox
    */
    public function wpfrsl_save_review_settings($post_id)
    {
      if (isset($_POST['wpfrsl_review_settings_nonce']) && wp_verify_nonce( $_POST['wpfrsl_review_settings_nonce'], 'wpfrsl-review-settings-nonce' ) ) 
      {
        $wpfrsl_settings = parent::sanitize_array($_POST['wpfrsl_settings']);
        update_post_meta($post_id, 'wpfrsl_settings', $wpfrsl_settings);
      }
     
      return;

      $is_autosave = wp_is_post_autosave($post_id);
      $is_revision = wp_is_post_revision($post_id);
      $is_valid_nonce = ( isset($_POST['wpfrsl_review_settings_nonce']) && wp_verify_nonce($_POST['wpfrsl_review_settings_nonce'], basename(__FILE__)) ) ? 'true' : 'false';
      // Exits script depending on save status
      if ($is_autosave || $is_revision || !$is_valid_nonce) 
      {
        return;
      }
    }

    public function wpfrsl_badge_settings()
    {
      add_meta_box('wpfrsl_badge_settings', __('Badge_settings', WPFRSL_TD), array($this, 'wpfrsl_badge_settings_callback'), 'wpfrslreviews', 'normal', 'high');
    }

    public function wpfrsl_badge_settings_callback()
    {
      wp_nonce_field(basename(__FILE__), 'wpfrsl_badge_settings');
      include WPFRSL_PATH . 'includes/backend/post_type_metabox/wpfrsl-badge-settings.php';
    }

    public function wpfrsl_save_badge_settings($post_id)
    {
      if(isset($_POST['wpfrsl_badge_settings_nonce']) && wp_verify_nonce($_POST['wpfrsl_badge_settings_nonce'], 'wpfrsl-badge-settings-nonce'))
      {
        $wpfrsl_badge_settings = parent::sanitize_array($_POST['wpfrsl_badge_settings']);
        update_post_meta($post_id, 'wpfrsl_badge_settings', $wpfrsl_badge_settings);
      }
      return;
    }

    /*
    * Add Metabox For Social Review Display Settings in the POST TYPE
    */
    public function wpfrsl_display_settings()
    {
      add_meta_box('wpfrsl_display_settings', __('Display Settings', WPFRSL_TD), array($this, 'wpfrsl_display_settings_callback'),'wpfrslreviews','normal','high');
    }

    /*
    * Callback function for Social Review Display Settings Metabox
    */
    public function wpfrsl_display_settings_callback()
    {
      // Add nonce for security and authentication.
      wp_nonce_field(basename(__FILE__), 'wpfrsl_display_settings_nonce');
      include WPFRSL_PATH .'includes/backend/post_type_metabox/wpfrsl-display-settings.php';
    }

    /*
     *Function to save the social review display settings from metabox
     */
    public function save_wpfrsl_display_settings($post_id)
    {
      if(isset($_POST['wpfrsl_display_settings_nonce']) && wp_verify_nonce( $_POST['wpfrsl_display_settings_nonce'], 'wpfrsl-display-settings-nonce') )
      {
        $wpfrsl_display_settings = parent::sanitize_array($_POST['wpfrsl_display_settings']);
        update_post_meta($post_id, 'wpfrsl_display_settings', $wpfrsl_display_settings);
      }
      return;
    }

    /*
    * Add Metabox For Social Review Cache Settings
    */
    public function wpfrsl_cache_settings()
    {
      add_meta_box('wpfrsl_cache_settings', __('Cache Settings', WPFRSL_TD), array($this, 'wpfrsl_cache_settings_callback'),'wpfrslreviews','side','low');
    }

    /*
    * Callback function for Social Review Cache Settings Metabox
    */
    public function wpfrsl_cache_settings_callback()
    {
      // Add nonce for security and authentication.
      wp_nonce_field(basename(__FILE__), 'wpfrsl_cache_settings_nonce');
      include WPFRSL_PATH .'includes/backend/post_type_metabox/wpfrsl-cache-settings.php';
    }

    /*
     *Function to save the social review cache settings from metabox
     */
    public function save_wpfrsl_cache_settings($post_id)
    {
      if(isset($_POST['wpfrsl_cache_settings_nonce']) && wp_verify_nonce( $_POST['wpfrsl_cache_settings_nonce'], 'wpfrsl-cache-settings-nonce') )
      {
        $wpfrsl_cache_settings = parent::sanitize_array($_POST['wpfrsl_cache_settings']);
        update_post_meta($post_id, 'wpfrsl_cache_settings', $wpfrsl_cache_settings);
      }
      return;
    }

    public function wpfrsl_credentials()
    {
      $wpfrsl_general_settings = get_option( 'wpfrsl_general_settings', false );
      $app_id = esc_attr($wpfrsl_general_settings['fb_credentials']['app_id']);
      $app_secret = esc_attr($wpfrsl_general_settings['fb_credentials']['app_secret']);
      
      if(isset($app_id) && isset($app_secret))
        return true;
      else
        return false;
    }

    public function fb_sdk()
    {
      $wpfrsl_general_settings = get_option( 'wpfrsl_general_settings' );
      if(isset($_POST['app_id']) && isset($_POST['app_secret']))
      {
        $fb = new \Facebook\Facebook([
          'app_id' => esc_attr($_POST['app_id']),
          'app_secret' => esc_attr($_POST['app_secret']),
          'default_graph_version' => 'v2.11',
        ]);
        return $fb;
      }
    }

    public function login_with_fb()
    {
      $fb = $this->fb_sdk();
      //$helper = $fb->getJavaScriptHelper();

      //Get The Access Token Of the Facebook User
      try {
          // $accessToken = $helper->getAccessToken();
        $accessToken = $_POST['authResponse']['accessToken'];
      } catch (Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
      }

      if (!isset($accessToken)) {
          echo 'No cookie set or no OAuth data could be obtained from cookie.';
          exit;
      }

      $fb_accessToken = $accessToken;
      $oAuth2Client = $fb->getOAuth2Client();

      //Get Long Lived Access Token From Short Lived Access Token
      try {
          $longLiveAccessToken = $oAuth2Client->getLongLivedAccessToken($fb_accessToken);
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
          echo "Error getting long-lived access token: " . $e->getMessage() . "\n\n";
          exit;
      }      

      //Get All The Pages Registered from The User
      try {
          $fb_pages = $fb->get('/me/accounts',$longLiveAccessToken);
      } catch (Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
      }
      $fb_pages = $fb_pages->getDecodedBody();

      // If there are no Pages registered by the user
      if (! $fb_pages['data']) 
      {
        echo "You have no pages!";
        exit;
      }

      // Get only the id, page name and Access token into the new Array for storing in option table
      $pages = array();
      foreach($fb_pages['data'] as $item) 
      { 
        $pages['pages'][$item['id']] = array(
                    'access_token' => $item['access_token'],
                    'name' => $item['name'],
                    'id'=>$item['id'],
                    );
      }
      //echo "<h1>item</h1>";parent::print_array($pages);

      //$this->scrapefb('2058209704412668','RedSkull');

      //Get All The reviews(ratings) inside the Page Named "RedSkull"
      // try {
      //     $fb_reviews = $fb->get('/2058209704412668/ratings',$pages['pages']['2058209704412668']['access_token']);
      // } catch (Facebook\Exceptions\FacebookResponseException $e) {
      //     echo 'Graph returned an error: ' . $e->getMessage();
      //     exit;
      // } catch (Facebook\Exceptions\FacebookSDKException $e) {
      //     echo 'Facebook SDK returned an error: ' . $e->getMessage();
      //     exit;
      // }
      //echo "<h1> The Reviews </h1>"; parent::print_array($fb_reviews);

      

      // try {
      //   // Returns a `Facebook\FacebookResponse` object
      //   $response = $fb->get(
      //     '/'.$pages['pages']['RedSkull']['id'].'/ratings',
      //     $pages['pages']['RedSkull']['access_token']
      //   );
      // } catch(Facebook\Exceptions\FacebookResponseException $e) {
      //     echo 'Graph returned an error: ' . $e->getMessage();
      //     exit;
      //   } catch(Facebook\Exceptions\FacebookSDKException $e) {
      //     echo 'Facebook SDK returned an error: ' . $e->getMessage();
      //     exit;
      //   }
      // $graphNode = $response->getGraphNode();
      // echo "<br><h1> Review </h1>";parent::print_array($graphNode);
    


      // $wpfrsl_general_settings = get_option( 'wpfrsl_general_settings' );
      // if(isset($wpfrsl_general_settings) && !empty($wpfrsl_general_settings))
      // {
      //   $new_settings = array();
      //   if(isset($wpfrsl_general_settings['fb_credentials']) || (isset($wpfrsl_settings['cache_settings'])) )
      //   {
      //     $new_settings['fb_credentials'] = $wpfrsl_general_settings['fb_credentials']; 
      //     $new_settings['cache_settings'] = $wpfrsl_general_settings['cache_settings'];
      //     $new_settings['pages'] = $pages['pages'];
      //   }
      //   else
      //     $new_settings['pages'] = $pages['pages']; 
      // }
      // else
      // {
      //   $new_settings['pages'] = $pages['pages']; 
      // }
      // echo "<h1>New Settings</h1>";parent::print_array($new_settings);

      // $update_status = update_option('wpfrsl_general_settings',$new_settings);

      include WPFRSL_PATH . 'includes/backend/ajax/pages_lists.php';
      die();
    }

    public function scrapefb($page_id, $page_name)
    {
      $currenturlmore = "https://www.facebook.com/".$page_id."/reviews/";
      $this->download_fb_backup_perurl($currenturlmore, $page_id, $page_name);
    }

    public function download_fb_backup_perurl($currenturl, $pageid, $pagename)
    {
      ini_set('memory_limit','256M');
      global $wpdb;
      $table_name = $wpdb->prefix . 'wpfb_reviews';
      
      $reviews = [];
      $n=1;
      $urlvalue = $currenturl; // https://www.facebook.com/pagename/reviews

                
      $response = wp_remote_get( $urlvalue );
      if ( is_array( $response ) ) {
        $header = $response['headers']; // array of http header lines
        $fileurlcontents = $response['body']; // use the content
      }
        
      //need to trim the string down by removing all script tags
      $dom = new DOMDocument();
      libxml_use_internal_errors(true); 
      $dom->loadHTML('<?xml encoding="utf-8" ?>' . $fileurlcontents);
      libxml_use_internal_errors(false);
      $script = $dom->getElementsByTagName('script');
      $remove = [];
      foreach($script as $item)
      {
        $remove[] = $item;
      }
      foreach ($remove as $item)
      {
        $item->parentNode->removeChild($item); 
      }
      $htmlstripped = $dom->saveHTML();
      
      $html = str_get_html($htmlstripped);


      $pagename = $pagename;
      $pageid = $pageid;

      //find total and average number here and end break loop early if total number less than 50. review-count
      
      if($html->find('meta[itemprop=ratingValue]',0)){
        $avgrating = $html->find('meta[itemprop=ratingValue]',0)->content;
        $avgrating = (float)$avgrating;
      }
      if($html->find('meta[itemprop=ratingCount]',0)){
        $totalreviews = $html->find('meta[itemprop=ratingCount]',0)->content;
        $totalreviews = intval($totalreviews);
      }
        
      $i = 0;
      for ($x = 0; $x <= 10; $x++) {
        
        if($html->find('div.userContentWrapper',$x))
        {
          $review = $html->find('div.userContentWrapper',$x);
        
          $user_name='';
          $userimage='';
          $rating='';
          $datesubmitted='';
          $rtext='';
          // Find user_name
          if($review->find('span.profileLink', 0)){
            $user_name = $review->find('span.profileLink', 0)->plaintext;
            $user_name = sanitize_text_field($user_name);
            $user_name = addslashes($user_name);
          }
          if($user_name=='') {
            if($review->find('a.profileLink', 0)) {
              $user_name = $review->find('a.profileLink', 0)->plaintext;
              $user_name = sanitize_text_field($user_name);
              $user_name = $user_name;
              $user_name_slash = addslashes($user_name);
            }
          }
          if(mb_detect_encoding($user_name) != 'UTF-8') { $user_name = utf8_encode($user_name); }
                    
          // Find userimage
          if($review->find('img', 0)){
            $userimage = $review->find('img', 0)->src;
          }
          
          // find rating
          if($review->find('i._51mq', 0)){
            $rating = $review->find('i._51mq', 0)->plaintext;
            $rating = intval($rating);
          }
          
          //first method find the uttimstamp $results->getAttribute("data-name");
          $uttimstamp='';
          if($review->find('abbr._5ptz', 0)->getAttribute("data-utime")){
            $uttimstamp = $review->find('abbr._5ptz', 0)->getAttribute("data-utime");
          }

          // find date
          if($review->find('span.timestampContent', 0)){
            $datesubmitted = $review->find('span.timestampContent', 0)->plaintext;
            $datesubmitted = strstr($datesubmitted, ' at ', true) ?: $datesubmitted;
            //fix for hrs ago hrs
            if (strpos($datesubmitted, 'hrs') !== false) {
              $datesubmitted = date('Y-m-d');
            }
          }
          //backup date method
          $utdate='';
          if($review->find('abbr._5ptz', 0)){
            $utdate = $review->find('abbr._5ptz', 0)->title;
          }

          // find text
          $rtext ='';
          if($review->find('div.userContent', 0)){
            $rtext = $review->find('div.userContent', 0)->plaintext;
            $rtext = sanitize_text_field($rtext);
            $rtext = addslashes($rtext);
            //remove See More
            $rtext =str_replace("See More","",$rtext);
            $rtext =str_replace("&#65533;","",$rtext);
          }

          if(mb_detect_encoding($rtext) != 'UTF-8') { $rtext = utf8_encode($rtext); }
          
        
            $review_length = substr_count($rtext, ' ');
            
            $pos = strpos($userimage, 'default_avatars');
            if (is_numeric($uttimstamp)) {
              $timestamput = $uttimstamp;
            } else {
              if($datesubmitted!=''){
                $timestamput = strtotime($datesubmitted);
              } else {
                $timestamput = strtotime($utdate);
              }
            }
            $timestamp = date("Y-m-d H:i:s", $timestamput);
            
            //check to see if in database already
            //check to see if row is in db already
            $reviewindb = 'no';
            $reviewindb2 = 'no';

            if( $reviewindb == 'no' && $reviewindb2 == 'no')
            {
              $reviews[] = [
                  'reviewer_name' => trim($user_name),
                  'reviewer_id' => '',
                  'pageid' => trim($pageid),
                  'pagename' => trim($pagename),
                  'userpic' => $userimage,
                  'rating' => $rating,
                  'created_time' => $timestamp,
                  'created_time_stamp' => $timestamput,
                  'review_text' => trim(stripslashes_deep($rtext)),
                  'hide' => '',
                  'review_length' => $review_length,
                  'type' => 'Facebook'
              ];
            }
            $review_length ='';
          
          $i++;
        }
      }
      return $reviews;
    }

    /*
     * Add Shortcode Metabox Sidebar
     */
    public function wpfrsl_shortcode_usage_metabox()
    {
      add_meta_box('wpfrsl_shortcode_usage_section', __('Social Review Shortcode Usage', WPFRSL_TD), array($this, 'wpfrsl_shortcode_usage_option_callback'), 'wpfrslreviews', 'side', 'default');
    }

    public function wpfrsl_shortcode_usage_option_callback( $post )
    {
        wp_nonce_field(basename(__FILE__), 'wpfrsl_shortcode_usage_option_nonce');
        include(WPFRSL_PATH.'includes/backend/post_type_metabox/wpfrsl-usages-meta.php'); 
    }

    /*
    *To add the Custom Column Head Title on Custom Post
    */
    public function wpfrsl_columns_head($defaults)
    {
      $defaults['shortcodes'] = __('Shortcodes', WPFRSL_TD);
      $defaults['template'] = __('Template Include', WPFRSL_TD);
      unset($defaults['date']);   // remove it from the columns list
      $defaults['date'] = __('Date', WPFRSL_TD);
      return $defaults;
    }

    /**
    **  To Add Custom Column Content of Custom head for Custom Post Type
    **/
    public function wpfrsl_columns_content($column, $post_ID)
    {
      if ($column == 'shortcodes') 
      {
        $id = $post_ID;
        ?>
        <textarea class="wpfrsl-shortcode-display-value" style="resize: none;" rows="2" cols="40" readonly="readonly">[wpfrsl_reviews id="<?php echo $id; ?>"]</textarea>
        <span class="wpfrsl-copied-info" style="display: none;"><?php _e('Shortcode copied to your clipboard.', WPFRSL_TD); ?></span>
      <?php
      }
      if ($column == 'template') {
        $id = $post_ID;
        ?>
        <textarea class="wpfrsl-shortcode-display-value2" style="resize: none;" rows="2" cols="45" readonly="readonly">&lt;?php echo do_shortcode("[wpfrsl_reviews id='<?php echo $id; ?>']"); ?&gt;</textarea>
        <span class="wpfrsl-copied-info2" style="display: none;"><?php _e('Shortcode copied to your clipboard.', WPFRSL_TD); ?></span>
          <?php
      }
    }

    /* Download FB Page Review On Page Select From Backend API Settings Metabox  */
    public function wpfrsl_review_download()
    {
      if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'wpfrsl_backend_ajax_nonce')) 
      {
        $fb_page_id = esc_attr($_POST['fb_page_id']);
        $fb_page_name = esc_attr($_POST['fb_page_name']);
        $currenturlmore = "https://www.facebook.com/".$fb_page_id."/reviews/";
        $reviews = $this->download_fb_backup_perurl($currenturlmore, $page_id, $page_name);
        if (!empty($reviews)) {
          echo $reviews = trim(maybe_serialize($reviews));
        }
        else{
          echo "empty";
        }
        die();
      }
    }

    function wpfrsl_upgrade_pro()
    {
      add_meta_box( 'wpfrsl_upgrade_pro', __( 'Upgrade to Pro Version', WPFRSL_TD ), array( $this, 'wpfrsl_upgrade_action' ), 'wpfrslreviews', 'side', 'low' );
    }

    function wpfrsl_upgrade_action( $post )
    {
      include(WPFRSL_PATH . 'includes/backend/post_type_metabox/wpfrsl-upgrade.php');
    }

    public function asap_get_fbgraph_pages_action(){
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'wpfrsl_backend_ajax_nonce')) {
                $g_appid = sanitize_text_field($_POST['fgraph_appid']);
                $g_appsecret = sanitize_text_field($_POST['fgraph_appsecret']);
                $g_usertoken = sanitize_text_field($_POST['fgraph_usertoken']);
                $ext_token_url = "https://graph.facebook.com/v12.0/oauth/access_token?grant_type=fb_exchange_token&client_id=".$g_appid."&client_secret=".$g_appsecret."&fb_exchange_token=".$g_usertoken;
                $ext_token_request = wp_remote_get($ext_token_url);
                if( is_wp_error( $ext_token_request ) ) {
                    $ext_token_response = wp_remote_retrieve_body($ext_token_request);
                    wp_send_json_error($ext_token_response);
                }
                $ext_token_response = wp_remote_retrieve_body($ext_token_request);
        $ext_token_array = json_decode($ext_token_response, true);
                $ext_token = $ext_token_array['access_token'];
        $me_url = "https://graph.facebook.com/v12.0/me/?access_token=".$ext_token;
        $me_request = wp_remote_get($me_url);
                if( is_wp_error( $me_request ) ) {
                    $me_response = wp_remote_retrieve_body($me_request);
                    wp_send_json_error($me_response);
                }
                $me_response = wp_remote_retrieve_body($me_request);
        $me_array = json_decode($me_response, true);
                $user_id = $me_array['id'];
        $accounts_url = "https://graph.facebook.com/v12.0/".$user_id."/accounts/?access_token=".$ext_token;
        $accounts_request = wp_remote_get($accounts_url);
                if( is_wp_error( $accounts_request ) ) {
                    $accounts_response = wp_remote_retrieve_body($accounts_request);
                    wp_send_json_error($accounts_response);
                }
                $accounts_response = wp_remote_retrieve_body($accounts_request);
        wp_send_json_success($accounts_response);
        
            //         if ($fb_response != false) {
            //             $asap_fb_sess_data = get_option('asap_fb_sess_data');
            //             $c_user_data = (isset($asap_fb_sess_data[$c_user]) && $asap_fb_sess_data[$c_user] != '') ? $asap_fb_sess_data[$c_user] : array();
            //             if (!empty($c_user_data)) {
            //                 $response = array(
            //                     'type' => 'success',
            //                     'result' => $c_user_data,
            //                     'message' => __('Your account added successfully.', ASAP_TD)
            //                 );
            //             } else {
            //                 $response = array(
            //                     'type' => 'error',
            //                     'message' => __('No Data Found.', ASAP_TD)
            //                 );
            //             }
            //         } else {
            //             $response = array(
            //                 'type' => 'error',
            //                 'message' => __('Invalid Cookie c_user and c_xs data added.', ASAP_TD)
            //             );
            //         }
            //     } else {
            //         $response = array(
            //             'type' => 'error',
            //             'message' => __('Please provide your Valid App ID, App Secret and User Token value.', ASAP_TD)
            //         );
            //     }
            //     wp_send_json($response);
            //     exit;
            }
        }  
	
  }
        
  new WPFRSL_Admin;
}