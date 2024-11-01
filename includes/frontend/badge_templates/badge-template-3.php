<?php 
defined('ABSPATH') or die("No script kiddies please!"); 
?>

<div class="wpfrsl-business-wrapper">       
   
  <div class="wpfrsl-avatar-wrap">
    <?php if (isset($page_id) && !empty($page_id)) { ?>
      <div class="wpfrsl-business-avatar">
        <a class="wpfrsl-avatar-img-wrap" href="https://www.facebook.com/<?php echo $page_id; ?>/reviews" target="_blank">
            <img src="https://graph.facebook.com/<?php echo $page_id; ?>/picture?type=large&width=100&height=100">
        </a>
      </div>
    <?php } ?>

    <div class="wpfrsl-ribbon">
      <span class="fa fa-facebook"></span>
      <span class="fa fa-star"></span>
    </div>
  </div>

  <div class="wpfrsl-badge-info-box">
    <?php if (isset($page_name) && !empty($page_name)) { ?>
      <div class="wpfrsl-header-title">
        <h2>
          <a href="https://www.facebook.com/<?php echo $page_id; ?>/reviews" target="_blank" style="text-decoration:none;"><?php echo esc_attr($page_name); ?></a>
        </h2>
      </div>
    <?php } ?>
    
    <?php if( isset($hide_average_rating) && $hide_average_rating == 'false'){ ?>
    <div class="wpfrsl-ratings-wrap">

      <?php if (isset($overall_average_rating) && !empty($overall_average_rating)) { ?>
          <div class="wpfrsl-average-star-num">
                <span><?php echo $overall_average_rating; ?></span>
          </div>
      <?php } ?>

      <div class="wpfrsl-star-rating">
        <?php
        $rating = $overall_average_rating;
        $whole = floor($overall_average_rating);      // 1
        $fraction = $rating - $whole; // .25
        $next = $whole + 1;
        $fraction_percent = round($fraction, 1) * 100;
        for ($n = 1; $n <= 5; $n++) {
            $full = ($n <= $whole) ? 'full' : '';
            $half = ($fraction != '' && $n == $next) ? 'half wpfrsl-fraction-' . $fraction_percent : '';
            if($full == '' && $half == ''){
              $new_class = "empty";
            }else{
              $new_class = $full . $half;
            }
            ?>
            
            <span class="wpfrsl-star-icon <?php echo $new_class; ?>">
                <i class="fa fa-star-o"></i>
            </span>
            <?php if ($half != '') { ?>
                <style type="text/css">
                  .wpfrsl-star-rating .half.wpfrsl-fraction-<?php echo $fraction_percent; ?>:after 
                  {
                      width:<?php echo $fraction_percent; ?>%;
                  }
                </style>
                <?php
            }
        }
        ?>
      </div>
      
    </div>
    <?php } /* Hide Average Rating */ ?>

    <div class="wpfrsl-review-count">
      <h3><?php esc_attr_e('From '.$total_review_count .' Reviews', WPFRSL_TD); ?></h3>
    </div>
  </div>
     
</div>
