<?php defined('ABSPATH') or die('No script please!');

$post_id = $atts['id'];

//Get The Page Id From The wpfrsl_api_settings
$wpfrsl_api_settings = get_post_meta($post_id, 'wpfrsl_api_settings', true);
$page_details = isset($wpfrsl_api_settings['page_details'])?$wpfrsl_api_settings['page_details']:NULL;
$page_id = isset($wpfrsl_api_settings['page_group_lists'])?$wpfrsl_api_settings['page_group_lists']:NULL;
$wpfrsl_page_id_token_arr=array();
		  if(isset($page_details) && !empty($page_details)) {
	$page_detail_arr = json_decode($wpfrsl_api_settings['page_details'], true);
	$page_detail_arr = $page_detail_arr['data'];
			  foreach ($page_detail_arr as $page_detail) {
					$wpfrsl_page_id_token_arr[$page_detail['id']]['name'] = $page_detail['name'];
				  $wpfrsl_page_id_token_arr[$page_detail['id']]['access_token'] = $page_detail['access_token'];
			  }
		  }
// print_r($wpfrsl_page_id_token_arr);
$required_access_token = $wpfrsl_page_id_token_arr[$page_id]['access_token'];
$page_name = $wpfrsl_page_id_token_arr[$page_detail['id']]['name'];
$fb_page_reviews = WPFRSL_API_Settings::get_rating($page_id, $required_access_token);
$app_id = isset($wpfrsl_api_settings['app_id'])?esc_attr($wpfrsl_api_settings['app_id']):NULL;
$app_secret = isset($wpfrsl_api_settings['app_secret'])?esc_attr($wpfrsl_api_settings['app_secret']):NULL;
$fb_page_id_name = (isset($wpfrsl_api_settings['facebook_id_name']) && !empty($wpfrsl_api_settings['facebook_id_name']))?esc_attr($wpfrsl_api_settings['facebook_id_name']):'';
// $all_pages = maybe_unserialize(str_replace('/quote', '"', $wpfrsl_api_settings['all_pages']));
if(isset($fb_page_id_name) && !empty($fb_page_id_name))
{
	$page_id_name_explode = explode("_",$fb_page_id_name);
	$fb_page_id = $page_id_name_explode[0];
	$fb_page_name = $page_id_name_explode[1];	
}

//get the wpfrsl_settings saved from metabox
$wpfrsl_settings = get_post_meta( $post_id, 'wpfrsl_settings', true);

// foreach($all_pages['pages'] as $page_k => $page_val)
// {
//   if($page_val['id'] === $fb_page_id)
//   {
//     $page_name = $page_val['name'];
//     break;
//   }
// }
$reviewlimit = (isset($wpfrsl_settings['review_limit']) && !empty($wpfrsl_settings['review_limit']))?esc_attr($wpfrsl_settings['review_limit']):'';
if( isset($atts['number_reviews']) && !empty($atts['number_reviews']) )
{
	$review_limit = $atts['number_reviews'];
}
else
{
	$review_limit = $reviewlimit;
}
$page_review = $fb_page_reviews['data'];
$fb_scraping_reviews = $fb_page_reviews['data'];

$display_order = (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order'])?esc_attr($wpfrsl_settings['display_order']):'asc');
$read_more_text = (isset($wpfrsl_settings['read_more_text']) && !empty($wpfrsl_settings['read_more_text']))?esc_attr($wpfrsl_settings['read_more_text']):'Read More';
$read_less_text = (isset($wpfrsl_settings['read_less_text']) && !empty($wpfrsl_settings['read_less_text']))?esc_attr($wpfrsl_settings['read_less_text']):'Read Less';
$description_char_limit = (isset($wpfrsl_settings['description_char_limit']) && !empty($wpfrsl_settings['description_char_limit']))?esc_attr($wpfrsl_settings['description_char_limit']):300;

$random_num = rand(111111111, 999999999);

if(isset($display_order) && !empty($display_order))
{
	$page_review = array();
	$page_review = self::wpfrsl_display_order($fb_scraping_reviews, $display_order);
}
else{
	$page_review = array();	
	$page_review = self::wpfrsl_display_order($fb_scraping_reviews, $display_order);
}

/*  Limit the number of fetched reviews if the review limit is set  */
if(isset($review_limit) && !empty($review_limit) && ($review_limit > 0) )
{
	$page_review = array_slice($page_review, 0, intval(intval($review_limit)));
}

//get the wpfrsl_display_settings from the metabox
$wpfrsl_display_settings = get_post_meta( $post_id, 'wpfrsl_display_settings', true);
$showreviews = isset($wpfrsl_display_settings['show_reviews'])?'true':'false'; 
if(isset($atts['show_reviews']))
{
	if($atts['show_reviews'] == 1)
	{
		$show_reviews = "true";
	}
  	else
  	{
    	$show_reviews = "false";
  	}
}
else
{
	$show_reviews = $showreviews;
}

$layouttype = (isset($wpfrsl_display_settings['layout_type']) && !empty($wpfrsl_display_settings['layout_type']))?esc_attr($wpfrsl_display_settings['layout_type']):'list_type';
if(isset($atts['layout_type']) && !empty($atts['layout_type']) ){
  $layout_type = $atts['layout_type'];
}else{
 $layout_type = $layouttype;
}

if((isset($layout_type) && $layout_type == 'list_type') && isset($wpfrsl_display_settings['list_template']) && !empty($wpfrsl_display_settings['list_template']))
{
	$review_template = esc_attr($wpfrsl_display_settings['list_template']);
}
else if((isset($layout_type) && $layout_type == 'slide_type') && isset($wpfrsl_display_settings['slide_template']) && !empty($wpfrsl_display_settings['slide_template']))
{
	$review_template = esc_attr($wpfrsl_display_settings['slide_template']);
}
else 
{
	$review_template = 'template-1';
}
if(isset($atts['review_template']) && !empty($atts['review_template']))
{
   $wpfrsl_template = $atts['review_template'];
}else{
    $wpfrsl_template = $review_template;
}

/* Get The badge Settings from The Meta Box */
$wpfrsl_badge_settings = get_post_meta($post_id, 'wpfrsl_badge_settings', true);
$showbadge = isset($wpfrsl_badge_settings['enable_badge'])?'1':'0';
if(isset($atts['show_badge']))
{	
	if($atts['show_badge'] == 1) {
		$show_badge = 1;
	}
	else {
		$show_badge = 0;
	}
}else {
	$show_badge = $showbadge;
}
$hide_average_rating = isset($wpfrsl_badge_settings['hide_average_rating']) ? 'true' : 'false'; 
$badgetemplate = (isset($wpfrsl_badge_settings['badge_template']) && !empty($wpfrsl_badge_settings['badge_template']))?esc_attr($wpfrsl_badge_settings['badge_template']):NULL;
if(isset($atts['badge_template']) && !empty($atts['badge_template']))
{
	$badge_template = $atts['badge_template'];
} else{
	$badge_template = $badgetemplate;
}

/* Overall rating of The Page */
$ratings_array = array(); 
$rating_sum = 0;
$i = 0;
// foreach($fb_scraping_reviews as $array_key => $review_value)
// {
// 	$rating_array[$i] = $review_value['rating'];
// 	$rating_sum = $rating_sum + $rating_array[$i];
// 	$i++;
// }
// $total_review_count = self::total_review_count($fb_scraping_reviews);
// $overall_average_rating = round($rating_sum / $total_review_count, 1);
// $total_review_count = $fb_scraping_reviews[0]['total_review'];
$total_review_count = count($page_review);
// $overall_average_rating = $fb_scraping_reviews[0]['average_rating'];
$pos_review_count = 0;
foreach($page_review as $single_review){
	if ($single_review['recommendation_type'] == 'positive' )
		$pos_review_count++;
}
if($total_review_count!=0 && $pos_review_count!=0){
	$overall_average_rating = round(($pos_review_count/$total_review_count)*5,1);
}else{
	$overall_average_rating=0;
}


?>
<div class="wpfrsl-wrap">
	<div class="wpfrsl-main-wrap">
		
		<?php 
			if($layout_type == 'list_type')
			{
				$review_array = $page_review;
				$item_counter = 0;
			}
			else if($layout_type == 'slide_type')
			{
				$item_counter = 0;
				$review_array = $page_review;
			}

			/* Display Badge Template */
			if(isset($show_badge) && $show_badge == '1')
			{
				if(isset($badge_template) && !empty($badge_template))
				{

				?>
				<!--Display Business Badge Details START  ☆ --> 
				<div class="wpfrsl-business-badge wpfrsl-business-header wpfrsl-<?php echo esc_attr($badge_template); ?>">
				  <div class="wpfrsl-business-badge-inner-wrap"> 
				<?php
					include WPFRSL_PATH . 'includes/frontend/badge_templates/'.$badge_template.'.php';
				?>
				  </div>
				</div>
				<!--Display Business Badge Details END--> 
				<?php	
				}
			}

			if(isset($show_reviews) && ($show_reviews == 'true')) {
			/* Display Selected Template */
			if(isset($wpfrsl_template))
			{
			?>
			<?php 

				if($layout_type == 'list_type'){
					$layout_type_class = 'wpfrsl-list-type';
				}
				else if($layout_type == 'slide_type')
				{
					$layout_type_class = 'wpfrsl-slider-type';
				}
				
				if(isset($layout_type) && (($layout_type == 'list_type') || ($layout_type == 'grid_type')) )
                {
                ?>
                <div class="wpfrsl-all-reviews-wrapper wpfrsl-<?php echo $wpfrsl_template; ?>"> 
                    <ul class="wpfrsl-show-reviews-wrap <?php echo $layout_type_class; ?> wpfrsl-clearfix">
                <?php
                    include WPFRSL_PATH.'includes/frontend/templates/'.$wpfrsl_template.'.php';
                ?>
                    </ul>
                </div>
                <?php    
                }
                else if(isset($layout_type) && ($layout_type == 'slide_type')  )
                {
                ?>
                <div class="wpfrsl-all-reviews-wrapper wpfrsl-<?php echo $wpfrsl_template; ?>"> 
                    <ul  
                      id="wpfrsl-reviews-<?php echo $random_num; ?>" 
                      class="wpfrsl-show-reviews-wrap <?php echo $layout_type_class; ?> wpfrsl-clearfix" 
                    >
                <?php
                    include WPFRSL_PATH.'includes/frontend/templates/'.$wpfrsl_template.'.php';
                ?>
                    </ul>
                </div>
                <?php
                }	 
			}	
		?>
	</div>

<?php } // Show Review?>
</div>