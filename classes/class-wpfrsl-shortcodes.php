<?php defined('ABSPATH') or die('No script kiddies please!!');
if (!class_exists('WPFRSL_Shortcode')) {

    /**
     * Frontend Review Shortcode
     */
    class WPFRSL_Shortcode extends WPFRSL_Library {

        function __construct() {
            add_shortcode('wpfrsl_reviews', array($this, 'wpfrsl_shortcode_generator'));

            /* For comment pagination */
            add_action('wp_ajax_wpfrsl_review_pagination_ajax_action', array($this, 'review_pagination')); // Ajax hook
            add_action('wp_ajax_nopriv_wpfrsl_review_pagination_ajax_action', array($this, 'review_pagination'));
        }

        /*
         * Generating shortcode with post id
         */
        function wpfrsl_shortcode_generator($atts) 
        {
            $wpfrslreviews = '';
            $args = array(
                'post_type' => 'wpfrslreviews',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'p' => $atts['id']
            );
            foreach ($atts as $key => $val) {
                $$key = $val;
            }
            $wpfrsl_reviews = new WP_Query($args);
            ob_start();
            if ($wpfrsl_reviews->have_posts()) :
                include( WPFRSL_PATH . 'includes/frontend/wpfrsl-shortcode.php' );
                $wpfrslreviews = ob_get_contents();
            endif;
            wp_reset_query();
            ob_end_clean();
            return $wpfrslreviews;
        }

        public static function total_review_count($page_review) 
        {
            $review_count = count($page_review);
            return $review_count;
        }

        function review_pagination() 
        {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'wpfrsl_frontend_ajax_nonce')) 
            {
                $page_number = sanitize_text_field($_POST['page_number']);
                $post_id = sanitize_text_field($_POST['post_id']);
                $total_page = sanitize_text_field( $_POST['total_page'] );
                $wpfrsl_template = sanitize_text_field( $_POST['template'] );
                $badge_template = sanitize_text_field( $_POST['badge_template'] );
                $layout_type = sanitize_text_field($_POST['layout_type']);

                //Get The Page Id From The wpfrsl_api_settings
                $wpfrsl_api_settings = get_post_meta($post_id, 'wpfrsl_api_settings', true);
                $fb_page_id_name = (isset($wpfrsl_api_settings['facebook_id_name']) && !empty($wpfrsl_api_settings['facebook_id_name']))?esc_attr($wpfrsl_api_settings['facebook_id_name']):'';
                if(isset($fb_page_id_name) && !empty($fb_page_id_name))
                {
                    $page_id_name_explode = explode("_",$fb_page_id_name);
                    $fb_page_id = $page_id_name_explode[0];
                    $page_name = $page_id_name_explode[1];   
                }

                //get the wpfrsl_settings saved from metabox
                $wpfrsl_settings = get_post_meta( $post_id, 'wpfrsl_settings', true);
                $review_limit = (isset($wpfrsl_settings['total_no_reviews']) && !empty($wpfrsl_settings['total_no_reviews']))?esc_attr($wpfrsl_settings['total_no_reviews']):'';
                $fb_scraping_reviews = WPFRSL_API_Settings::get_fb_review($fb_page_id, $page_name, $post_id);
                if(!isset($fb_scraping_reviews) || empty($fb_scraping_reviews))
                {
                    $fb_scraping_reviews = maybe_unserialize($wpfrsl_api_settings['downloaded_reviews']);
                }

                $display_order = (isset($wpfrsl_settings['display_order']) && !empty($wpfrsl_settings['display_order'])?esc_attr($wpfrsl_settings['display_order']):'asc');
                $show_five_star_only = (isset($wpfrsl_settings['show_five_star_only']) && ($wpfrsl_settings['show_five_star_only'] == 'on'))?'on':'off';
                $read_more_text = (isset($wpfrsl_settings['read_more_text']) && !empty($wpfrsl_settings['read_more_text']))?esc_attr($wpfrsl_settings['read_more_text']):'Read More';
                $read_less_text = (isset($wpfrsl_settings['read_less_text']) && !empty($wpfrsl_settings['read_less_text']))?esc_attr($wpfrsl_settings['read_less_text']):'Read Less';
                $description_char_limit = (isset($wpfrsl_settings['description_char_limit']) && !empty($wpfrsl_settings['description_char_limit']))?esc_attr($wpfrsl_settings['description_char_limit']):NULL;

                $random_num = rand(111111111, 999999999);

                if(isset($display_order) && !empty($display_order))
                {
                    $page_review = array();
                    $page_review = self::wpfrsl_display_order($fb_scraping_reviews, $display_order, $show_five_star_only);
                }
                else
                {
                    $page_review = array();
                    $page_review = self::wpfrsl_display_order($fb_scraping_reviews, $display_order, $show_five_star_only);
                }
                
                //get the wpfrsl_display_settings from the metabox
                $wpfrsl_display_settings = get_post_meta( $post_id, 'wpfrsl_display_settings', true);
                $review_per_page = ( isset($wpfrsl_display_settings['review_per_page']) && !empty($wpfrsl_display_settings['review_per_page']) )?esc_attr($wpfrsl_display_settings['review_per_page']):2;
                $enable_review_animation = isset($wpfrsl_display_settings['enable_review_animation']) ? "true" : "false";
                $ranimationtype = (isset($wpfrsl_display_settings['review_animation_type']) && $wpfrsl_display_settings['review_animation_type'] != '') ? esc_attr($wpfrsl_display_settings['review_animation_type']) : '';
                $pagination_type = isset($wpfrsl_display_settings['pagination_type'])?esc_attr($wpfrsl_display_settings['pagination_type']):'';

                if($enable_review_animation == 'true')
                {
                    if(isset($ranimationtype) && $ranimationtype != '')
                    {
                        $review_animation_type = 'wow animated '.$ranimationtype;
                    }
                    else{
                        $review_animation_type = '';
                    }
                }

                
                /* Get The badge Settings from The Meta Box */
                $wpfrsl_badge_settings = get_post_meta($post_id, 'wpfrsl_badge_settings', true);
                $show_badge = isset($wpfrsl_badge_settings['enable_badge'])?'1':'0';
                $hide_average_rating = isset($wpfrsl_badge_settings['hide_average_rating']) ? 'true' : 'false';
                $enable_badge_animation = isset($wpfrsl_badge_settings['enable_badge_animation']) ? "true" : "false";
                $banimation_type = (isset($wpfrsl_badge_settings['badge_animation_type']) && !empty($wpfrsl_badge_settings['badge_animation_type']))? esc_attr($wpfrsl_badge_settings['badge_animation_type']) : '';
                if(isset($enable_badge_animation) && ($enable_badge_animation == 'true'))
                {
                    if(isset($banimation_type) && !empty($banimation_type))
                    {
                        $badge_animation_type = 'wow animated '.$banimation_type;
                    }
                    else
                    {
                        $badge_animation_type = '';
                    }
                }

                //For overall average rating
                $ratings_array = array(); 
                $rating_sum = 0;
                $i = 0;
                foreach($page_review as $array_key => $review_value)
                {
                    $rating_array[$i] = $review_value['rating'];
                    $rating_sum = $rating_sum + $rating_array[$i];
                    $i++;
                }
                $total_review_count = self::total_review_count($page_review);
                $overall_average_rating = round($rating_sum / $total_review_count, 1);

                $offset = ($page_number - 1) * $review_per_page;
                $review_array = array_slice($page_review, $offset, $review_per_page);
               
                $item_counter = 0;

                if(isset($show_badge) && $show_badge == '1' && $pagination_type == 'page_number')
                {
                    if(isset($badge_template) && !empty($badge_template))
                    {
                    ?>
                    <!--Display Business Badge Details START  ☆--> 
                    <div class="wpfrsl-business-badge wpfrsl-business-header wpfrsl-<?php echo esc_attr($badge_template); ?>">
                      <div class="wpfrsl-business-badge-inner-wrap <?php echo $badge_animation_type;?>" <?php if(!empty($badge_animation_type)) echo 'data-wow-duration="2s" data-wow-delay="0.2s"'; else echo '';?>> 
                    <?php
                        include WPFRSL_PATH . 'includes/frontend/badge_templates/'.$badge_template.'.php';
                    ?>
                      </div>
                    </div>
                    <!--Display Business Badge Details END--> 
                    <?php    
                    }

                    if(isset($wpfrsl_template))
                    {
                    ?>
                    <div class="wpfrsl-all-reviews-wrapper <?php echo $review_animation_type;?> wpfrsl-<?php echo $wpfrsl_template; ?>" <?php if(isset($review_animation_type) && !empty($review_animation_type)) echo 'data-wow-duration="2s" data-wow-delay="0.4s"'; else echo '';?>>   
                    <?php
                        if($layout_type == 'list_type')
                            $layout_type_class = 'wpfrsl-list-type';
                        else if($layout_type == 'grid_type')
                            $layout_type_class = 'wpfrsl-grid-type';
                        else if($layout_type == 'slide_type')
                            $layout_type_class = 'wpfrsl-slider-type';
                        else if($layout_type == 'carousel')
                            $layout_type_class = 'wpfrsl-carousel-type';

                        if(isset($layout_type) && (($layout_type == 'list_type') || ($layout_type == 'grid_type')) )
                        {
                        ?>
                            <ul class="wpfrsl-show-reviews-wrap <?php echo $layout_type_class; ?> wpfrsl-clearfix">
                        <?php
                            include WPFRSL_PATH.'includes/frontend/templates/'.$wpfrsl_template.'.php';
                        ?>
                            </ul>
                        <?php    
                        }
                        
                    ?>
                    </div>
                    <?php    
                    }
                }
                else if(isset($show_badge) && $show_badge == '1' && $pagination_type == 'load_more')
                {
                    if($layout_type == 'list_type')
                        $layout_type_class = 'wpfrsl-list-type';
                    else if($layout_type == 'grid_type')
                        $layout_type_class = 'wpfrsl-grid-type';
                    else if($layout_type == 'slide_type')
                        $layout_type_class = 'wpfrsl-slider-type';
                    else if($layout_type == 'carousel')
                        $layout_type_class = 'wpfrsl-carousel-type';

                    if(isset($layout_type) && (($layout_type == 'list_type') || ($layout_type == 'grid_type')) )
                    {
                        include WPFRSL_PATH.'includes/frontend/templates/'.$wpfrsl_template.'.php'; 
                    }
                }
                die();
            }
        }

        public function wpfrsl_display_order($page_review, $display_order)
        {
            $review = array();
            // echo "kakak";parent::print_array($page_review);            

            if($display_order == 'desc')
            {
                $review = ($page_review);
            }
            else if($display_order == 'asc')
            {
                $arr_count = count($page_review);
                $j=$arr_count;
                for($i=0; $i<$arr_count; $i++)
                {
                    $j--;
                    $review[$i] = $page_review[$j];
                }                
            }
            else if($display_order == 'highest_rating')
            {
                usort($page_review, array($this, 'wpfrsl_highest_rating'));
                $review = $page_review;
            }
            else if($display_order == 'lowest_rating')
            {
                usort($page_review, function($a, $b) {
                  if ($a == $b) {
                    return 0;
                  }
                  return ($a < $b) ? -1 : 1;
                });
                $review = $page_review;
            }
            else if($display_order == 'longest_text_review')
            {
                usort($page_review, array($this, 'wpfrsl_longest_text')); 
                $review = $page_review;
            }
            else if($display_order == 'shortest_text_review')
            {
                usort($page_review, array($this, 'wpfrsl_shortest_text'));
                $review = $page_review;
            }
            return $review;

        }

        public function wpfrsl_longest_text($a, $b)
        {
            return strlen($b['review_text']) - strlen($a['review_text']);
        }

        public function wpfrsl_shortest_text($a , $b)
        {
            return strlen($a['review_text']) - strlen($b['review_text']);
        }

        function wpfrsl_highest_rating($a, $b) 
        {
            if ($a == $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        }

        function wpfrsl_time_ago($timestamp)
        {         
          $time_ago        = strtotime($timestamp);
          $current_time    = time();
          $time_difference = $current_time - $time_ago;
          $seconds         = $time_difference;
          
          $minutes = round($seconds / 60); // value 60 is seconds  
          $hours   = round($seconds / 3600); //value 3600 is 60 minutes * 60 sec  
          $days    = round($seconds / 86400); //86400 = 24 * 60 * 60;  
          $weeks   = round($seconds / 604800); // 7*24*60*60;  
          $months  = round($seconds / 2629440); //((365+365+365+365+366)/5/12)*24*60*60  
          $years   = round($seconds / 31553280); //(365+365+365+365+366)/5 * 24 * 60 * 60
                        
          if ($seconds <= 60){

            return "Just Now";

          } else if ($minutes <= 60){

            if ($minutes == 1){

              return "one minute ago";

            } else {

              return "$minutes minutes ago";

            }

          } else if ($hours <= 24){

            if ($hours == 1){

              return "an hour ago";

            } else {

              return "$hours hrs ago";

            }

          } else if ($days <= 7){

            if ($days == 1){

              return "yesterday";

            } else {

              return "$days days ago";

            }

          } else if ($weeks <= 4.3){

            if ($weeks == 1){

              return "a week ago";

            } else {

              return "$weeks weeks ago";

            }

          } else if ($months <= 12){

            if ($months == 1){

              return "a month ago";

            } else {

              return "$months months ago";

            }

          } else {
            
            if ($years == 1){

              return "one year ago";

            } else {

              return "$years years ago";

            }
          }
        }

    }

    new WPFRSL_Shortcode();
}