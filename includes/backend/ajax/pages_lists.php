<?php  defined('ABSPATH') or die('no script'); ?>

<div class="wpfrsl-field-wrap" >
	<label><?php _e('Select page', WPFRSL_TD); ?></label>
	<select name="wpfrsl_api_settings[facebook_id_name]" id="wpfrsl_fbpage_select">
		<option><?php _e('Select Page', WPFRSL_TD); ?></option>
		<?php foreach($pages['pages'] as $pages_k => $page_val){ ?>
			<option value="<?php echo $page_val['id'] .'_'.$page_val['name']; ?>" <?php (isset($wpfrsl_api_settings['facebook_id_name']) && !empty($wpfrsl_api_settings['facebook_id_name']))?(selected($wpfrsl_api_settings['facebook_id_name'], $page_val['id'])):''; ?>>
				<?php esc_attr_e($page_val['name']); ?>
			</option>
		<?php } ?>
	</select>
	<span id="wpfrsl-ajax-download-loader" style="display: none;">
		<img src="<?php echo esc_attr(WPFRSL_IMG_DIR) .'ajax-loader.gif'; ?>">
	</span>
</div>

<div class="wpfrsl-field-wrap" id="wpfrsl-download-review-response"></div>

<?php $all_pages = str_replace('"', '/quote', maybe_serialize($pages)); ?>
<div class="wpfrsl-field-wrap">
	<input type="hidden" name="wpfrsl_api_settings[all_pages]" value="<?php echo $all_pages; ?>">
</div>
