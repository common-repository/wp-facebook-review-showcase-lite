<?php 
global $post;
$post_id = $post->ID;
$wpfrsl_cache_settings = get_post_meta($post_id, 'wpfrsl_cache_settings', true);
?>

<?php wp_nonce_field('wpfrsl-cache-settings-nonce', 'wpfrsl_cache_settings_nonce'); ?>

<div class="wpfrsl-main-wrap">
	<div class="wpfrsl-field-wrap">
		<label><?php _e('Enable Cache', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="checkbox" name="wpfrsl_cache_settings[enable_cache]" <?php isset($wpfrsl_cache_settings['enable_cache'])?checked($wpfrsl_cache_settings['enable_cache'], 'on'):NULL; ?>>
			<div class="wpfrsl-tooltip-description">
		      <?php _e('Dont check if you want to disable the caching of reviews and always want to fetch new reviews.', WPFRSL_TD); ?>
		    </div>
		</div>
	</div>

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Cache Period', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="number" name="wpfrsl_cache_settings[cache_period]" value="<?php (isset($wpfrsl_cache_settings['cache_period']) && !empty($wpfrsl_cache_settings['cache_period']))?esc_attr_e($wpfrsl_cache_settings['cache_period']):NULL; ?>" min="0">
			<div class="wpfrsl-tooltip-description">
	            <?php _e('Please enter the time in hours in which the facebook reviews should be updated. Default is 24 hours. The minimum cache period you can setup is 1 hour.', WPFRSL_TD); ?>
	       </div>
   		</div>
	</div>

	<div class="wpfrsl-cache-delete-btn">
		<a onclick="return confirm('Do you really want to clear cache ?')" href="<?php echo admin_url().'admin-post.php?action=delete_cache&_cache_del_wpnonce='.wp_create_nonce('wpfrsl_delete_cache').'&post_id='.$post_id; ?>" class="button wpfrsl-delete-cache">Clear cache</a>
	</div>
</div>