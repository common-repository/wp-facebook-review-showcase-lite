<?php 
global $post;
$post_id = $post->ID;
$wpfrsl_settings = get_post_meta( $post_id, 'wpfrsl_settings', true );
?>

<?php wp_nonce_field('wpfrsl-review-settings-nonce', 'wpfrsl_review_settings_nonce'); ?>

<div class="wpfrsl-main-wrapper">

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Total no of Reviews',WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="number" name="wpfrsl_settings[review_limit]" value="<?php echo (isset($wpfrsl_settings['review_limit']) && !empty($wpfrsl_settings['review_limit']))?esc_attr($wpfrsl_settings['review_limit']):''; ?>" min="0" placeholder="Total Number of Reviews">
		</div>
	</div>
	<div class="wpfrsl-field-wrap">
		<label><?php _e('Hide Ratings', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="checkbox" name="wpfrsl_settings[hide_ratings]" value="1" <?php (isset($wpfrsl_settings['hide_ratings']) && !empty($wpfrsl_settings['hide_ratings']))?checked($wpfrsl_settings['hide_ratings'], '1'):''; ?>>
		</div>
	</div>

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Hide Description', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="checkbox" name="wpfrsl_settings[hide_description]" value="1" <?php (isset($wpfrsl_settings['hide_description']) && !empty($wpfrsl_settings['hide_description']))?checked($wpfrsl_settings['hide_ratings']):''; ?>>
		</div>
	</div>

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Description Character Limit', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="number" name="wpfrsl_settings[description_char_limit]" value="<?php (isset($wpfrsl_settings['description_char_limit']) && !empty($wpfrsl_settings['description_char_limit']))?esc_attr_e($wpfrsl_settings['description_char_limit']):NULL; ?>" min="0" placeholder="Description Character Limit">

			<div class="wpfrsl-tooltip-description">
	            <?php _e('Please fill character to be displayed at first. Default Value is set to 300 if left empty.', WPFRSL_TD); ?>
	       </div>
   		</div>
	</div>

	<div class="wpfrsl-field-wrap">
		<label><?php  _e('Read More Text', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="text" name="wpfrsl_settings[read_more_text]" value="<?php (isset($wpfrsl_settings['read_more_text']) && !empty($wpfrsl_settings['read_more_text']))?esc_attr_e($wpfrsl_settings['read_more_text']):NULL; ?>" placeholder="Read More Text">
			<div class="wpfrsl-tooltip-description">
	            <?php _e('Display text such as Read More , View More after set limit for user rating description.', WPFRSL_TD); ?>
	        </div>
   		</div>
	</div>

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Read Less Text', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<input type="text" name="wpfrsl_settings[read_less_text]" value="<?php (isset($wpfrsl_settings['read_less_text']) && !empty($wpfrsl_settings['read_less_text']))?esc_attr_e($wpfrsl_settings['read_less_text']):NULL; ?>" placeholder="Read Less Text">
			<div class="wpfrsl-tooltip-description">
	            <?php _e('Display text such as Read More , View More after set limit for user rating description.', WPFRSL_TD); ?>
	       	</div>
       	</div>
	</div>

	<div class="wpfrsl-field-wrap">
		<label><?php _e('Display order', WPFRSL_TD); ?></label>
		<div class="wpfrsl-inner-field-wrap">
			<select name="wpfrsl_settings[display_order]">
				<option value="" disabled="disabled"><?php _e('Select Display Order', WPFRSL_TD); ?></option>
				<option value="asc" <?php (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order']))?selected($wpfrsl_settings['display_order'], 'asc'):NULL; ?>><?php _e('Ascending', WPFRSL_TD); ?></option>
				<option value="desc" <?php (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order']))?selected($wpfrsl_settings['display_order'], 'desc'):NULL; ?>><?php _e('Descending', WPFRSL_TD); ?></option>
				<option value="highest_rating" <?php (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order']))?selected($wpfrsl_settings['display_order'], 'highest_rating'):NULL; ?>><?php _e('Highest rating', WPFRSL_TD); ?></option>
				<option value="lowest_rating" <?php (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order']))?selected($wpfrsl_settings['display_order'], 'lowest_rating'):NULL; ?>><?php _e('Lowest rating', WPFRSL_TD); ?></option>
				<option value="longest_text_review" <?php (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order']))?selected($wpfrsl_settings['display_order'], 'longest_text_review'):NULL; ?>><?php _e('Longest Text review', WPFRSL_TD); ?></option>
				<option value="shortest_text_review" <?php (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order']))?selected($wpfrsl_settings['display_order'], 'shortest_text_review'):NULL; ?>><?php _e('Shortest Text Review', WPFRSL_TD); ?></option>
			</select>
		</div>
	</div>
</div>