<?php if(isset($layout_type) && (($layout_type == 'list_type') || ($layout_type == 'grid_type')) ){ ?>

<?php 
    foreach($review_array as $wpfrsl_review_key => $wpfrsl_review)
    {
      $item_counter++;
?>
  <li class="wpfrsl-sp-review">
      <div class="wpfrsl-main-header-section wpfrsl-clearfix">
         <div class="wpfrsl-top-section-info wpfrsl-clearfix">
          <div class="wpfrsl-left-section">
            <?php if (isset($wpfrsl_review['created_time']) && $wpfrsl_review['created_time'] != '') { ?>
                <div class="wpfrsl-rated-time">
                  <?php 
                    $old_date_timestamp = strtotime($wpfrsl_review['created_time']);
                    $new_date = date('jS, F Y ', $old_date_timestamp);  
                    
                    _e($new_date . '  ' , WPFRSL_TD);
                  ?>
                </div>
            <?php } ?>
          </div>
          
          <div class="wpfrsl-right-section">
            <?php if (!isset($wpfrsl_settings['hide_ratings'])) { ?>
            <div class="wpfrsl-reviewer-star">
				<?php
					if($wpfrsl_review["recommendation_type"] == 'positive'){?>
						<img src="<?php echo WPFRSL_FRONTEND_IMG_DIR.'recommend_1.png' ?>">
				<?php }else { ?>
						<img src="<?php echo WPFRSL_FRONTEND_IMG_DIR.'dont_recommend_1.png' ?>">
					<?php } ?>
				
            </div>
            <?php } //User Rating ?>
          </div>
        </div>

        <?php 
        if (!isset($wpfrsl_settings['hide_description'])) 
        {
          $review_description = (isset($wpfrsl_review['review_text']) && $wpfrsl_review['review_text'] != '')?$wpfrsl_review['review_text']:'';
          if(isset($review_description) && !empty($review_description)) 
          {
        ?>
            <div class="wpfrsl-content-reviews-wrapper">
              <?php 
            
              if (strlen($review_description) >= $description_char_limit) { ?>
                  <div class="wpfrsl-small-description">
                      <?php echo strip_tags(substr($review_description, 0, $description_char_limit)) . '...'; ?>
                      <span class="wpfrsl-read-more wpfrsl-readtxt"><?php esc_attr_e($read_more_text, WPFRSL_TD); ?></span>
                  </div>

                  <div class="wpfrsl-full-description" style="display:none;">
                    <?php echo $review_description; ?>
					  <br>
                    <span class="wpfrsl-read-less wpfrsl-readtxt"><?php esc_attr_e($read_less_text, WPFRSL_TD); ?></span>
                  </div>
                  <?php 
                    }
                    else
                    {
                      esc_attr_e($review_description);
                    }  
                  ?>
            </div>
        <?php 
          }
        }
        ?>
      
      </div>
  </li>

<?php 
 

} 
?>


<?php }else if(isset($layout_type) && (($layout_type == 'slide_type') || ($layout_type == 'carousel') ) ){ ?>

<?php 
  foreach($review_array as $wpfrsl_review_key => $wpfrsl_review)
    {
      $item_counter++;
?>
  <li class="wpfrsl-sp-review">
      <div class="wpfrsl-main-header-section wpfrsl-clearfix">
		  <div class="wpfrsl-top-section-info wpfrsl-clearfix">
          <div class="wpfrsl-left-section">
            <?php if (isset($wpfrsl_review['created_time']) && $wpfrsl_review['created_time'] != '') { ?>
                <div class="wpfrsl-rated-time">
                  <?php 
                    $old_date_timestamp = strtotime($wpfrsl_review['created_time']);
                    $new_date = date('jS, F Y ', $old_date_timestamp);  
                    
                    _e($new_date . '  ' , WPFRSL_TD);
                  ?>
                </div>
            <?php } ?>
          </div>
          
          <div class="wpfrsl-right-section">
            <?php if (!isset($wpfrsl_settings['hide_ratings'])) { ?>
            <div class="wpfrsl-reviewer-star">
				<?php
					if($wpfrsl_review["recommendation_type"] == 'positive'){?>
						<img src="<?php echo WPFRSL_FRONTEND_IMG_DIR.'recommend_1.png' ?>">
				<?php }else { ?>
						<img src="<?php echo WPFRSL_FRONTEND_IMG_DIR.'dont_recommend_1.png' ?>">
				<?php } ?>
            </div>
            <?php } //User Rating ?>
          </div>
        </div>

        <?php 
        if (!isset($wpfrsl_settings['hide_description'])) 
        {
          $review_description = (isset($wpfrsl_review['review_text']) && $wpfrsl_review['review_text'] != '')?$wpfrsl_review['review_text']:'';

          if(isset($review_description) && !empty($review_description)) 
          {
        ?>
            <div class="wpfrsl-content-reviews-wrapper">
              <?php 
            
              if (strlen($review_description) >= $description_char_limit) { ?>
                  <div class="wpfrsl-small-description">
                      <?php echo strip_tags(substr($review_description, 0, $description_char_limit)) . '...'; ?>
                      <span class="wpfrsl-read-more wpfrsl-readtxt"><?php esc_attr_e($read_more_text, WPFRSL_TD); ?></span>
                  </div>

                  <div class="wpfrsl-full-description" style="display:none;">
                    <?php echo $review_description; ?>
					  <br>
                    <span class="wpfrsl-read-less wpfrsl-readtxt"><?php esc_attr_e($read_less_text, WPFRSL_TD); ?></span>
                  </div>
                  <?php 
                    }
                    else
                    {
                      esc_attr_e($review_description);
                    }  
                  ?>
            </div>
        <?php 
          }
        }
        ?>
      
      </div>
  </li>

<?php 
 } 
?>
<?php } ?>