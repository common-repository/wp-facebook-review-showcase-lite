<?php 
global $post;
$post_id = $post->ID;
$wpfrsl_api_settings = get_post_meta($post_id, 'wpfrsl_api_settings', true);
// parent::print_array($wpfrs_api_settings);
?>

<?php wp_nonce_field('wpfrsl-api-settings-nonce', 'wpfrsl_api_settings_nonce'); ?>

<div class="wpfrs-main-wrap" id="wpfrs-api-settings-wrap">

  <?php /* <div class="wpfrs-field-wrap" id="wpfrs_api_app_id_wrap" class="api_app_id_wrap">
    <label><?php _e('App Id', WPFRSL_TD); ?></label>
    <div class="wpfrs-inner-field-wrap">
      <input type="text" name="wpfrs_api_settings[app_id]" value="<?php (isset($wpfrs_api_settings['app_id']) && !empty($wpfrs_api_settings['app_id']))?esc_attr_e($wpfrs_api_settings['app_id']):"" ?>" id="wpfrs-app-id">
      <div class="wpfrs-tooltip-description">
        <?php _e('Enter the Facebook App ID of your newly created app. Create your new app if you havent created by clicking', WPFRSL_TD);?> <a href="https://developers.facebook.com/apps" target="_blank"><?php _e(' here', WPFRSL_TD);?></a>
      </div>
    </div>
  </div>

  <div class="wpfrs-field-wrap" id="wpfrs_api_app_secret_wrap">
    <label><?php _e('App Secret', WPFRSL_TD); ?></label>
    <div class="wpfrs-inner-field-wrap">
      <input type="text" name="wpfrs_api_settings[app_secret]" value="<?php (isset($wpfrs_api_settings['app_secret']) && !empty($wpfrs_api_settings['app_secret']))?esc_attr_e($wpfrs_api_settings['app_secret']):''; ?>" id="wpfrs-app-secret">
      <div class="wpfrs-tooltip-description">
        <?php _e('Enter the Facebook App Secret of your newly created app. Create your new app if you havent created by clicking', WPFRSL_TD);?> <a href="https://developers.facebook.com/apps" target="_blank"><?php _e(' here', WPFRSL_TD);?></a>
      </div>
    </div>
  </div>

  <div class="wpfrs_api_fb_login_wrap" style="display: none;">
    <div class="wpfrs-field-wrap">
      <!-- <input type="button" value="FB Login" onclick="loginwithfb()"> -->
      <button type="button" onclick="loginwithfb()">
        <?php _e('FB Login', WPFRSL_TD); ?>
      </button>
      <span id="wpfrs-ajax-login-loader" style="display: none;">
        <img src="<?php echo WPFRS_IMG_DIR .'ajax-loader.gif'; ?>">
      </span>
    </div>
  </div> */ ?>

  <style>
  .wpfrs-main-wrap .wpfrs-pages{
    width: 60%;
    
  }

  .wpfrs-main-wrap .wpfrs-pages .wpfrs-page
  {
    display: inline-block;
    width: 60%;
    margin-top: 5px;
  }

  .wpfrs-main-wrap .wpfrs-pages .wpfrs-page:hover
  {
    pointer: cusor;
    background-color: #eee;
  }

  .wpfrs-main-wrap .wpfrs-pages .wpfrs-page .wpfrs-page-photo 
  {
    float:left;
  }
  .wpfrs-main-wrap .wpfrs-pages .wpfrs-page .wpfrs-page-name 
  {
    width: 50%;
    float: left;
    margin-left: 5px;
  }
  </style>
    <div class="wpfrs-field-wrap">
      <label><?php _e('APP ID', WPFRSL_TD); ?></label>
      <div class='wpfrs-inner-field-wrap'>
        
        <input type="text" id="" name="wpfrsl_api_settings[app_id]" 
        value="<?php (isset($wpfrsl_api_settings['app_id']) && !empty($wpfrsl_api_settings['app_id']))?esc_attr_e($wpfrsl_api_settings['app_id']):''; ?>" class="wpfrs-page-name" placeholder="<?php _e('App ID', WPFRSL_TD); ?>"/>
      </div>
    </div>
    <div class="wpfrs-field-wrap">
      <label><?php _e('APP Secret', WPFRSL_TD); ?></label>
		 <div class='wpfrs-inner-field-wrap'>
      <input type="text" id="" name="wpfrsl_api_settings[app_secret]" value="<?php (isset($wpfrsl_api_settings['app_secret']) && !empty($wpfrsl_api_settings['app_secret']))?esc_attr_e($wpfrsl_api_settings['app_secret']):''; ?>" class="wpfrs-page-id" placeholder="<?php _e('APP Secret', WPFRSL_TD); ?>" />
		</div>
    </div>
    <div class="wpfrs-field-wrap">
      <label><?php _e('User Access Token', WPFRSL_TD); ?></label>
       <div class='wpfrs-inner-field-wrap'>
      <input type="text" id="" name="wpfrsl_api_settings[user_access_token]" value="<?php (isset($wpfrsl_api_settings['user_access_token']) && !empty($wpfrsl_api_settings['user_access_token']))?esc_attr_e($wpfrsl_api_settings['user_access_token']):''; ?>" class="wpfrs-page-token" placeholder="<?php _e('User Access Token', WPFRSL_TD); ?>" />
	</div>
    </div>
    <button type='button' id="wpfrsl_fb_get_pages">Get Pages</button>
    <div class="wpfrs-field-wrap">
      <select name="wpfrsl_api_settings[page_group_lists]" id="wpfrsl-graph-pages-select">
		  <?php $array=array();
		  if(isset($wpfrsl_api_settings['page_details']) && !empty($wpfrsl_api_settings['page_details'])) {
	$page_detail_arr = json_decode($wpfrsl_api_settings['page_details'], true);
	$page_detail_arr = $page_detail_arr['data'];
			  foreach ($page_detail_arr as $page_detail) {
					$array[$page_detail['id']] = $page_detail['name'];
			  }
			  foreach ($array as $id => $page_name){ ?>
				  <option value="<?php echo $id; ?>" <?php if($id == $wpfrsl_api_settings['page_group_lists']) echo "selected"; ?> ><?php echo $page_name; ?></option>
			  <?php
			}
} else { ?>
			  <option> No page list available.</option>
		  <?php } ?>
      </select>
<!-- 		<br>
		<span>Notes: Your page are shown here.</span> -->
    </div>
	<textarea style="display:none;" id="wpfrsl-graph-pages-all-json" name="wpfrsl_api_settings[page_details]"><?php echo($wpfrsl_api_settings['page_details']) ?></textarea>
</div>


<script>
  loginwithfb = function(e) 
    { 
      jQuery('body').find('#wpfrs-ajax-login-loader').show();
      jQuery('body').find('#wpfrs-selected-page-settings').remove();
      var app_id = jQuery('body').find('#wpfrs-app-id').val();
      var app_secret = jQuery('body').find('#wpfrs-app-secret').val();
      fbAsyncInit();
        FB.login(function(response) 
        {
            if (response.authResponse) 
            {
            // alert('You are logged in &amp; cookie set!');return false;
              var url = window.location.href;
              //window.location.replace(url+"&logged_in=true");
              jQuery.post(
                ajaxurl,
                {
                  'action'       : 'login_with_fb',
                  'authResponse' : response.authResponse,
                  'app_id'       : app_id,
                  'app_secret'   : app_secret
                },
                function(response){
                  //var clear_response = response.slice(0,-1);
                  // alert(response);
                  jQuery('body').find('#wpfrs-ajax-login-loader').hide();
                  jQuery('body').find('div#ajax_response').append(response);
                  jQuery('body').find('div#respo').replaceWith(response);
                }

              );
            }
            else{
                //alert('User cancelled login or did not fully authorize.');return false;
                var url = window.location.href;
                window.location = url.replace('logged_in=true','logged_in=false');
            }
        }, {scope: 'pages_show_list'});
      return false;
    };
      
    fbAsyncInit = function() 
    {
        FB.init({
              appId: jQuery('body').find('#wpfrs-app-id').val(),
              channelUrl : '//localhost/sudae/wp-admin/edit.php?post_type=wpfrsreviews',
              autoLogAppEvents : true,
        status           : true,
        cookie           : true,
        oauth            : true,
        xfbml            : true,
        version          : 'v2.12',
          });
    };

    (function(d, s, id)
    {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>