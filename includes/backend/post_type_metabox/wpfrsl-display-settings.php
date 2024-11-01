<?php 
global $post;
$post_id = $post->ID;
$wpfrsl_display_settings = get_post_meta( $post_id, 'wpfrsl_display_settings', true );
?>

<?php wp_nonce_field('wpfrsl-display-settings-nonce', 'wpfrsl_display_settings_nonce'); ?>

<div class="wpfrsl-main-wrapper">

  <h3><?php _e('Review Display Settings', WPFRSL_TD); ?></h3>

  <div class="wpfrsl-field-wrap" id="wpfrsl-pages-list-wrap"></div>

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Show Review'); ?></label>
    <div class="wpfrsl-inner-field-wrap">
		  <input type="checkbox" name="wpfrsl_display_settings[show_reviews]" <?php isset($wpfrsl_display_settings['show_reviews'])?checked($wpfrsl_display_settings['show_reviews'], 'on'):NULL; ?>>
    </div>
	</div>

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Layout Type', WPFRSL_TD); ?></label>
    <div class="wpfrsl-inner-field-wrap">
  		<select name="wpfrsl_display_settings[layout_type]" class="wpfrsl-layout-type">
  			<option disabled>Select Layout Type</option>
        <option value="list_type" <?php isset($wpfrsl_display_settings['layout_type'])?(selected( $wpfrsl_display_settings['layout_type'], 'list_type' )):selected('list_type', 'list_type'); ?> ><?php _e('List Type', WPFRSL_TD); ?></option>
        <option value="slide_type" <?php isset($wpfrsl_display_settings['layout_type'])?(selected( $wpfrsl_display_settings['layout_type'], 'slide_type' )):''; ?>><?php _e('Slider Type', WPFRSL_TD); ?></option>
  		</select>
    </div>
	</div>

  <div class="wpfrsl-field-wrap wpfrsl-template-section">
    <label><?php _e('Template', WPFRSL_TD); ?></label>

    <?php
    $img_url = WPFRSL_BACKEND_IMG_DIR . "/list_template/template-1.PNG"; 
    if(isset($wpfrsl_display_settings['layout_type']) && ($wpfrsl_display_settings['layout_type'] == 'list_type'))
    {
      $img_url = WPFRSL_BACKEND_IMG_DIR . "/list_template/template-1.PNG"; 
      if((isset($wpfrsl_display_settings['list_template']) && !empty($wpfrsl_display_settings['list_template'])))
      {
        $img_url = WPFRSL_BACKEND_IMG_DIR . "/list_template/". $wpfrsl_display_settings['list_template'] .'.PNG'; 
      }
    }
    else if(isset($wpfrsl_display_settings['layout_type']) && ($wpfrsl_display_settings['layout_type'] == 'slide_type'))
    {
      $img_url = WPFRSL_BACKEND_IMG_DIR . "/slider_template/template-1.PNG"; 
      if((isset($wpfrsl_display_settings['slide_template']) && !empty($wpfrsl_display_settings['slide_template'])))
      {
        $img_url = WPFRSL_BACKEND_IMG_DIR . "/slider_template/". $wpfrsl_display_settings['slide_template'] .'.PNG'; 
      }
    }
    ?>
    
    <div class="wpfrsl-inner-field-wrap">
    <div class="wpfrsl-template-outer-wrap">
      <div style="<?php echo (isset($wpfrsl_display_settings['layout_type']) && ($wpfrsl_display_settings['layout_type'] == 'list_type'))?'display: block;':'display: none;'; ?>" id="list_type_template_select" class="template_select">
       
        <select name="wpfrsl_display_settings[list_template]" id="wpfrsl-list-template-select">
          <option disabled>Select Template</option>
          <option value="template-1" <?php (isset($wpfrsl_display_settings['list_template']) && !empty($wpfrsl_display_settings['list_template']))?selected( $wpfrsl_display_settings['list_template'], 'template-1' ):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'list_template/template-1.PNG'; ?>"><?php _e('Flamingo', WPFRSL_TD); ?></option>
          <option value="template-2" <?php (isset($wpfrsl_display_settings['list_template']) && !empty($wpfrsl_display_settings['list_template']))?selected( $wpfrsl_display_settings['list_template'], 'template-2' ):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'list_template/template-2.PNG'; ?>"><?php _e('Fire Bush', WPFRSL_TD); ?></option>
          <option value="template-3" <?php (isset($wpfrsl_display_settings['list_template']) && !empty($wpfrsl_display_settings['list_template']))?selected( $wpfrsl_display_settings['list_template'], 'template-3' ):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'list_template/template-3.PNG'; ?>"><?php _e('Cinnabar', WPFRSL_TD); ?></option>
        </select>
        
      </div>

      <div style="<?php echo (isset($wpfrsl_display_settings['layout_type']) && ($wpfrsl_display_settings['layout_type'] == 'slide_type'))?'display: block;':'display: none;'; ?>" id="slider_type_template_select" class="template_select">
       
        <select name="wpfrsl_display_settings[slide_template]" id="wpfrsl-slide-template-select">
          <option disabled>Select Template</option>
          <option value="template-1" <?php (isset($wpfrsl_display_settings['slide_template']) && !empty($wpfrsl_display_settings['slide_template']))?selected( $wpfrsl_display_settings['slide_template'], 'template-1' ):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'slider_template/template-1.PNG'; ?>"><?php _e('Flamingo', WPFRSL_TD); ?></option>
          <option value="template-2" <?php (isset($wpfrsl_display_settings['slide_template']) && !empty($wpfrsl_display_settings['slide_template']))?selected( $wpfrsl_display_settings['slide_template'], 'template-2' ):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'slider_template/template-2.PNG'; ?>"><?php _e('Fire Bush', WPFRSL_TD); ?></option>
          <option value="template-3" <?php (isset($wpfrsl_display_settings['slide_template']) && !empty($wpfrsl_display_settings['slide_template']))?selected( $wpfrsl_display_settings['slide_template'], 'template-3' ):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'slider_template/template-3.PNG'; ?>"><?php _e('Cinnabar', WPFRSL_TD); ?></option>
        </select>
       
      </div>

      <div class="wpfrsl-image-preview-wrap">
        <div class="wpfrsl-template-image">
          <img src="<?php echo esc_url($img_url); ?>" alt="template image">
        </div>
      </div>
    </div>
    </div> <!-- wpfrsl-inner-field-wrap ends -->
  </div>

</div>