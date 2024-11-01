<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!!' );
//require_once plugin_dir_path( dirname( __FILE__ ) ) . 'wppro_simple_html_dom.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'urlopen.php';
if ( !class_exists( 'WPFRS_API_Settings' ) ) {

    class WPFRSL_API_Settings extends WPFRSL_Library{

    static function get_api_fb_review($post_id, $page_id, $page_name, $review_limit) {

      $wpfrs_api_settings = get_post_meta($post_id, 'wpfrs_api_settings', true);
      $access_token = isset($wpfrs_api_settings['access_token'])?esc_attr($wpfrs_api_settings['access_token']):NULL;

      //Get Cache Settings From Post Meta
      $wpfrs_cache_settings = get_post_meta($post_id, 'wpfrs_cache_settings', true);
      $check_cache = (isset($wpfrs_cache_settings['enable_cache']) && !empty($wpfrs_cache_settings['enable_cache'])?'1':'0' );
      $cache_period = (isset($wpfrs_cache_settings['cache_period']) && !empty($wpfrs_cache_settings['cache_period']))?esc_attr($wpfrs_cache_settings['cache_period']):24;

      if( $check_cache == '1' )
      {
        $fb_transient = 'wpfrs_' .md5($page_id). 'fbreviews_'.md5($post_id); // set transient id
        $fb_transient_details = get_transient($fb_transient); // get transient data

        if($fb_transient_details === FALSE) // if transient is not set (cache Not Set)
        {
          $hour_in_seconds = 60*60;
          $review_fetch_response_json = self::api_review_fetch($page_id, $access_token, $review_limit);
          $review_fetch_arr = json_decode(json_encode($review_fetch_response_json), True);
          set_transient($fb_transient, $review_fetch_arr, $cache_period * $hour_in_seconds );
        }
        else // if transient is set (Cache Set)
        {
          $review_fetch_arr = $fb_transient_details;
        }
      }
      else
      {
        $review_fetch_response_json = self::api_review_fetch($page_id, $access_token, $review_limit);
        $review_fetch_arr = json_decode(json_encode($review_fetch_response_json), True);
      }

      return $review_fetch_arr;
    }

    public static function api_review_fetch($page_id, $access_token, $review_limit)
    {
      $api_url = 'https://graph.facebook.com/' . $page_id . "?access_token=" . $access_token . "&fields=ratings.limit(".$review_limit.")";
      $api_response = wpfrs_urlopen($api_url);
      
      $response_data = $api_response['data'];
      $response_json = wpfrs_json_decode($response_data);
      return $response_json;
    }

    /**
    ** For finding the total review count and Overall Average Rating of FB Page
    **/
    public function total_review_rating($page_id, $access_token)
    {
      // $api_url = 'https://graph.facebook.com/v3.1/' . $page_id . "/ratings?access_token=" . $access_token . "&limit=200&fields=reviewer{id,name,picture.width(120).height(120)},created_time,rating,recommendation_type,review_text,open_graph_story{id}"; //this works! and fetches all reviews
      $api_url = 'https://graph.facebook.com/v3.1/' . $page_id . "/ratings?access_token=" . $access_token . "&limit=700&fields=rating,recommendation_type";
      $api_response = wpfrs_urlopen($api_url);
      $response_data = $api_response['data'];
      $response_json = wpfrs_json_decode($response_data);
      return $response_json->data;
    }    

    static function get_val_from_api_url($url)
    {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache"
        ),
      ));

      $response = curl_exec($curl);
      $err = curl_error($curl);

      curl_close($curl);
      return json_decode($response, true);
    }

    static function apiGetProfilePic( $url_path ) {

      $curl = curl_init();
      $url = $url_path;
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
      ));
      $response = curl_exec($curl);
      curl_close($curl);
      $image = json_decode($response, true);
      if ($image['data']['url']) {
        return $image['data']['url'];
      } else {
        return '';
      }
    }

    public function wpfrsl_get_fbgraph_pages_action(){
      if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'apsp_backend_ajax_nonce')) {
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
      }
  }
	public static function get_rating($page_id,$page_access_token){
			$url = 'https://graph.facebook.com/v3.1/'.$page_id.'/ratings?access_token='.$page_access_token;
			$response=wp_remote_get($url);
		$response_array = json_decode($response['body'], true);
			return $response_array;
		}
}

   $GLOBALS[ 'wpfrs_api' ] =  new WPFRSL_API_Settings();
}
