<?php 
global $post;
$post_id = $post->ID;
$wpfrsl_badge_settings = get_post_meta($post_id, 'wpfrsl_badge_settings', true);
wp_nonce_field('wpfrsl-badge-settings-nonce', 'wpfrsl_badge_settings_nonce'); 
?>

<div class="wpfrsl-main-wrapper">
	<div class="wpfrsl-field-wrap">
		<label><?php _e('Enable Badge', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="checkbox" name="wpfrsl_badge_settings[enable_badge]" <?php isset($wpfrsl_badge_settings['enable_badge'])?checked($wpfrsl_badge_settings['enable_badge'], 'on'):''; ?>>
		</div>
	</div>

	<div class="wpfrsl-main-wrapper">
		<div class="wpfrsl-field-wrap">
			<label><?php _e('Hide Average Rating', WPFRSL_TD); ?></label>
			<div class="wpfrsl-inner-field-wrap">
				<input type="checkbox" name="wpfrsl_badge_settings[hide_average_rating]" <?php isset($wpfrsl_badge_settings['hide_average_rating'])?checked($wpfrsl_badge_settings['hide_average_rating'], 'on'):''; ?>>
			</div>
		</div>
	</div>

	<?php
    	$img_url = WPFRSL_BACKEND_IMG_DIR . "/badge_templates/badge-template-1.PNG"; 
    
		if((isset($wpfrsl_badge_settings['badge_template']) && !empty($wpfrsl_badge_settings['badge_template'])))
		{
		  $img_url = WPFRSL_BACKEND_IMG_DIR . "/badge_templates/". $wpfrsl_badge_settings['badge_template'] .'.PNG'; 
		}
    
    ?>

	<div class="wpfrsl-field-wrap wpfrsl-badge-temp">
		<label><?php _e('Badge Template', WPFRSL_TD); ?></label>
		<div class="wpfrsl-badge-temp-outer-wrap">
			<div class="wpfrsl-inner-field-wrap">
			<select name="wpfrsl_badge_settings[badge_template]" id="wpfrsl-badge-template-select">
				<option disabled><?php _e('Select Badge Template', WPFRSL_TD); ?></option>
				<option value="badge-template-1" <?php (isset($wpfrsl_badge_settings['badge_template']) && !empty($wpfrsl_badge_settings['badge_template']))?selected($wpfrsl_badge_settings['badge_template'], 'badge-template-1'):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'badge_templates/badge-template-1.PNG'; ?>"><?php _e('Flamingo', WPFRSL_TD ); ?></option>
				<option value="badge-template-2" <?php (isset($wpfrsl_badge_settings['badge_template']) && !empty($wpfrsl_badge_settings['badge_template']))?selected($wpfrsl_badge_settings['badge_template'], 'badge-template-2'):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'badge_templates/badge-template-2.PNG'; ?>"><?php _e('Fire Bush', WPFRSL_TD ); ?></option>
				<option value="badge-template-3" <?php (isset($wpfrsl_badge_settings['badge_template']) && !empty($wpfrsl_badge_settings['badge_template']))?selected($wpfrsl_badge_settings['badge_template'], 'badge-template-3'):NULL; ?> data-img="<?php echo esc_attr(WPFRSL_BACKEND_IMG_DIR) . 'badge_templates/badge-template-3.PNG'; ?>"><?php _e('Cinnabar', WPFRSL_TD ); ?></option>		
			</select>

			<div class="wpfrsl-badge-image-preview">
		      <div class="wpfrsl-badge-template-image">
		        <img src="<?php echo esc_url($img_url); ?>" alt="badge template image">
		      </div>
		    </div>
			</div>
		</div>
	</div>
</div>