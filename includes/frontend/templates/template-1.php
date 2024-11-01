<?php 
    foreach($review_array as $wpfrs_review_key => $wpfrs_review)
    {
      $item_counter++;

      if( (isset($hide_negative_recommendations) && ($hide_negative_recommendations=='hide') && !isset($wpfrs_review['rating']) && ($wpfrs_review['recommendation_type'] == 'negative')) || (empty($wpfrs_review['review_text'])) )
      {
        continue;
      }
?>
  <li class="wpfrsl-sp-review">
      <div class="wpfrsl-main-header-section wpfrsl-clearfix">
		  <div class="wpfrsl-quote-wrap">
		 <img src="<?php echo WPFRSL_FRONTEND_IMG_DIR.'quote1.png'?>">
		  </div>
      	<?php if(!isset($wpfrs_review['rating']) && ($wpfrs_review['recommendation_type'] == 'positive') ){ ?>
          <div class="wpfrsl-recommendation-wrap">
			
            <img src="<?php echo WPFRSL_FRONTEND_IMG_DIR.'recommend_1.png' ?>">
            <span class="wpfrsl-recommend-text"><?php esc_attr_e('recommends', WPFRSL_TD); ?></span>
          </div>
        <?php }else if(!isset($wpfrs_review['rating']) && ($wpfrs_review['recommendation_type'] == 'negative') ){ ?>
          <div class="wpfrsl-dont-recommend-wrap">
            <img src="<?php echo WPFRSL_FRONTEND_IMG_DIR.'dont_recommend_1.png' ?>">
            <span class="wpfrsl-dont-recommend-text"><?php esc_attr_e("doesn't recommend", WPFRSL_TD); ?></span>
          </div>
        <?php  
        } 
        else{
          if (!isset($wpfrs_settings['hide_ratings'])) { ?>
          <div class="wpfrsl-reviewer-star">
          	  <span><?php _e($wpfrs_review['rating'], WPFRSL_TD); ?></span>
              <input type="hidden" id="wpfrsl-reviewer-ratingnum" value="<?php esc_attr_e($wpfrs_review['rating']); ?>"/>
              <?php
                $rating3 = $wpfrs_review['rating'];
                $whole3 = floor($wpfrs_review['rating']);      // 1
                $fraction3 = $rating3 - $whole3; // .25
                $next3 = $whole3 + 1;
                $fraction_percent3 = round($fraction3, 1) * 100;
                for ($k = 1; $k <= 5; $k++) 
                {
                  $full3 = ($k <= $whole3) ? 'full' : '';
                  $half3 = ($fraction3 != '' && $k == $next3) ? 'half wpfrs-fraction-' . $fraction_percent3 : '';
                  if($full3 == '' && $half3 == '')
                  {
                    $new_class3 = "empty";
                  }
                  else
                  {
                    $new_class3 = $full3 . $half3;
                  }
              ?>
                  <span class="wpfrsl-star-icon <?php echo $new_class3; ?>">
                    <i class="fa fa-star-o"></i>
                  </span>
                  
                  <?php 
                  if ($half3 != '') 
                  { 
                  ?>
                    <style type="text/css">
                        .wpfrs-reviewer-star .half.wpfrs-fraction-<?php echo $fraction_percent; ?>:before {
                            width:<?php echo $fraction_percent3; ?>%;
                        }
                    </style>
              	<?php
                  }
                }//for ends
              	?>
          </div>
        <?php } }//User Rating ?>

        <?php 
        if (!isset($wpfrs_settings['hide_description'])) 
        {
          $review_description = (isset($wpfrs_review['review_text']) && $wpfrs_review['review_text'] != '')?$wpfrs_review['review_text']:'';
			if(isset($review_description) && !empty($review_description)) 
          {
        ?>
            <div class="wpfrsl-content-reviews-wrapper">
              <?php 
            
              if (strlen($review_description) >= $description_char_limit) { ?>
                  <div class="wpfrsl-small-description">
                      <?php echo strip_tags(mb_substr($review_description, 0, $description_char_limit)) . '...'; ?>
                      <span class="wpfrsl-read-more wpfrs-readtxt"><?php esc_attr_e($read_more_text, WPFRSL_TD); ?></span>
                  </div>

                  <div class="wpfrsl-full-description" style="display:none;">
                    <?php echo $review_description; ?>
					  <br>
                    <span class="wpfrsl-read-less wpfrs-readtxt"><?php esc_attr_e($read_less_text, WPFRSL_TD); ?></span>
                  </div>
                  <?php 
                    }
                    else
                    {
                      echo $review_description;
                    }  
                  ?>
            </div>
        <?php 
          }
        }
        ?>

       <div class="wpfrsl-info-section ">
          <?php if (isset($wpfrs_review['reviewer']['name']) && $wpfrs_review['reviewer']['name'] != '') { ?>
	       	  <div class="wpfrsl-reviewer-name">
	              <a href="https://www.facebook.com/<?php echo $page_id; ?>/reviews" target="_blank" title="View this profile.">
	                  <span><?php esc_attr_e($wpfrs_review['reviewer']['name']); ?></span>
	              </a>
	          </div> 
          <?php } ?>
	          

	          <div class="wpfrsl-rated-time">
	            <?php 
	              $old_date_timestamp = strtotime($wpfrs_review['created_time']);
	              $new_date = date('F jS Y', $old_date_timestamp);  
	              
	              _e($new_date . '  ' , WPFRSL_TD);
	            ?>
	          </div>  
       </div>

      </div>
  </li>

<?php 
 

} 
?>