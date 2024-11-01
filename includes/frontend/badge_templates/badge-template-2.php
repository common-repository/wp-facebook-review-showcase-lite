<?php 
defined('ABSPATH') or die("No script kiddies please!"); 
?>

<div class="wpfrsl-business-wrapper wpfrs-clearfix">  

  <div class="wpfrsl-ribbon-box">
    <h3>
      <?php esc_attr_e('Facebook Rating', WPFRSL_TD); ?>
    </h3>
  </div>     
   
  <div class="wpfrsl-mid-avatar-section">
    <?php if (isset($page_id) && !empty($page_id)) { ?>
      <div class="wpfrsl-business-avatar">
        <a class="wpfrsl-avatar-img-wrap" href="https://www.facebook.com/<?php echo $page_id; ?>/reviews" target="_blank">
            <img src="https://graph.facebook.com/<?php echo $page_id; ?>/picture?type=large&width=100&height=100">
        </a>
      </div>
    <?php } ?>

    <?php if (isset($page_name) && !empty($page_name)) { ?>
      <div class="wpfrsl-header-title">
        <h2>
          <a href="https://www.facebook.com/<?php echo $page_id; ?>/reviews" target="_blank" style="text-decoration:none;"><?php echo esc_attr($page_name); ?></a>
        </h2>
      </div>
    <?php } ?>
  </div>  

  <div class="wpfrsl-right-rating-section">
    <div class="wpfrsl-star">
      <span class="fa fa-star"></span>
    </div>

    <?php if( isset($hide_average_rating) && $hide_average_rating == 'false'){ ?>
    <div class="wpfrsl-ratings-wrap">

      <?php if (isset($overall_average_rating) && !empty($overall_average_rating)) { ?>
          <div class="wpfrsl-average-star-num">
                <span><?php echo $overall_average_rating; ?></span>
          </div>
      <?php } ?>

    </div>
    <?php } /* Hide Average Rating */ ?>

    <div class="wpfrsl-review-count">
      <?php esc_attr_e('average rating from ', WPFRSL_TD); ?><strong><?php esc_attr_e($total_review_count); ?></strong>
    </div>
  </div>

     
</div>
