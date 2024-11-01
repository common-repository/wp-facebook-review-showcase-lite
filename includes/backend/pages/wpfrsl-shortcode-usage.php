<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="wpfrsl-settings-main-wrapper">
       <div class="wpfrsl-container wpfrsl-shortcode-usage-page wpfrsl-how-to-use-page">
         <div class="row">
              <h3><?php _e('Shortcode Usage', WPFRSL_TD);?></h3>
                <div class="wpfrsl_main_wrapper clearfix">
                     <?php _e('<h5>Shortcode Parameters</h5>', WPFRSL_TD); ?>
                        <?php _e('<p>You can get shortcode of specific facebook page review from its edit page > Facebook Review Shortcode Usage metabox shown on right section or else you can get shortcode on main review lists for specific facebook page reviews.
                        You can use shortcode for the display of the specific page reviews in the contents. Optionally You can enter the id of specific page from our plugin "Social Review" post type. The reviews will be displayed in the order with specified id parameter and its layout options.
                        Example 1: [wpfrsl_reviews id=’4’]
                        </p>', WPFRSL_TD); ?>
                       <?php _e('<p>Available shortcode parameters:</p>', WPFRSL_TD); ?>
                        <ul>
                            <li><?php _e('<strong>id</strong> : This parameter is specific attribute for specific page reviews.', WPFRSL_TD); ?>
                             <p>[wpfrsl_reviews id="79"]</p>
                            </li>
                            <li><?php _e("<strong>review_template</strong> : Our plugin contains altogether 2 pre designed template layouts. You can pass reviews template layout using shortcode by using review_template='template-1' or review_template='template-2' and so on as parameter on shortcode.", WPFRSL_TD); ?>
                             <p>e.g., [wpfrsl_reviews id="79" review_template="template-2"]</p>
                            </li>
                            <li><?php _e('<strong>badge_template</strong> : You can even change template of badge parameter as badge_template="template2" to display different badge template beside specified default template for specific locations using shortcode.', WPFRSL_TD); ?>
                              <p>e.g.,[wpfrsl_reviews id="79" badge_template="badge-template-2"]</p>
                            </li>
                            <li><?php _e('<strong>show_badge</strong> : You can even change enable or disable badge display on frontend by passing parameter as show_badge="1" to display badge and show_badge="0" to hide badge as business information using shortcode.', WPFRSL_TD); ?>
                            <p>e.g.,[wpfrsl_reviews id="79" review_template="template-2" badge_template="badge-template-2" show_badge="0"] to hide badge.</p>
                            </li>
                            <li><?php _e('<strong>show_review</strong> : You can even change enable or disable to show or hide reviews parameter as show_review="1" to display reviews and show_review="0" to hide it using shortcode.', WPFRSL_TD); ?>
                             <p>e.g.,[wpfrsl_reviews id="79" show_review="0"] to hide reviews.</p>
                             </li>
                            <li><?php _e('<strong>number_reviews</strong> : You can display number of reviews as per you wish by adding number_reviews on shortcode parameter but upto 3 reviews only.', WPFRSL_TD); ?>
                            <p>e.g.,[wpfrsl_reviews id="79" number_reviews="2"]  to show upto 2 reviews.</p>
                            </li>
                      
                          </ul>
                          <h5><?php _e('Example 1.1: Show Reviews with template 2 and show badge with badge template 1 and display 2 number of reviews:', WPFRSL_TD); ?>
                           <p>[wpfrsl_reviews id="79" review_template="template-2" badge_template="badge-template-1" number_reviews="2"]</p>
                          </h5>
                          

                          <h5><?php _e('Example 1.2: Show Reviews with template 2 and show badge with template 1:', WPFRSL_TD); ?>
                          <p>[wpfrsl_reviews id="79" review_template="template-2" badge_template="badge-template-1"]</p>
                          </h5>
                </div>
         </div>
       </div>
</div>