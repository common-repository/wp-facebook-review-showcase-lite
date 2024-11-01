<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="wpfrsl-settings-main-wrapper">
       <div class="wpfrsl-container wpfrsl-how-to-use-page">
           <div class="row">
               <?php _e('<h3>How to Use</h3>', WPFRSL_TD); ?>
            <div class="wpfrsl_main_wrapper clearfix">
               <?php _e('<h5>For detailed documentation, please visit here. <a href="https://accesspressthemes.com/documentation/wp-fb-review-showcase-lite/" target="_blank">VIEW DOC</a></h5>', WPFRSL_TD); ?>
                <p><?php _e('     
                 <b>Social Review </b>is one of the best wordpress free plugin to showcase Facebook page reviews.', WPFRSL_TD); ?>
                </p>
                <p><?php _e('
                A most powerful reviews display platform with 10 pre available beautifully designed templates layout for page reviews with user rating and 10 pre available badge layout with header as ribbon for displaying page information.
                    Display your page reviews to attract more reviews for local business. If you have multiple page, then you can simply create multiple page reviews and showcase it on specific page or post using shortcode.', WPFRSL_TD); ?>
                </p>
                <p><?php _e('Effortlessly show Facebook Page Reviews on your WordPress site utilizing an intense and instinctive widget. Incredible for restaurants, blogs, retail locations, franchisees, land firms, lodgings, hotels and hospitality, and about any business with a site and reviews on Facebook page.
                 This plugin is useful since you can display your facebook page information with 
                 positive reviews on websites which simply further enhance your online credibility.', WPFRSL_TD); ?>
                </p>

                <p><?php _e('There are basically 2 Main Plugin Settings which are described below more briefly.', WPFRSL_TD); ?></p>

                  <div class="wpfrsl-content-section">
                        <h4 class="wpfrsl-content-title"><?php _e('Plugin Main Settings', WPFRSL_TD); ?></h4>
                        
                        <?php _e('<h5>API Settings</h5>', WPFRSL_TD); ?>
                        <p><?php _e('In API Settings, after installation of our plugin, first of all, you have to create API Key to display facebook page to create specific page reviews. Please fill API key on this API Settings input field. To get API key simply follow details steps: ', WPFRSL_TD); ?>
                        </p>
                          <strong>
                              <?php esc_html_e('To obtain Facebook App ID and App Secret', WPFRSL_TD); ?>
                          </strong>>
                                                      
                          <ul> 
                                <li><?php _e('Login to your Facebook account and then navigate to ', WPFRSL_TD); ?><a target="_blank" href="https://developers.facebook.com/apps/"><?php echo esc_html('Facebook Developers Page', WPFRSL_TD); ?></a><?php esc_html_e(' and click “Create App” in the top right menu.', WPFRSL_TD); ?><?php esc_html_e('App should be Business type Facebook App.', WPFRSL_TD); ?><br></li>   
                                <li><?php esc_html_e('Fill the App details and set the App Purpose to \'Yourself or your own business\'.', WPFRSL_TD); ?></li>
                                <li><?php esc_html_e('After creating the App you can find App ID and App Secret in App Dashboard >> Settings >> Basic.', WPFRSL_TD); ?></li>
                            </ul>
                                  <strong>
                                    <?php esc_html_e('To obtain the User Access Token for the App that you just created', WPFRSL_TD); ?>
                                  </strong>
                            <ul>
                                <li><?php esc_html_e('Click on the link below to go to Facebook\'s Graph API Explorer.', WPFRSL_TD); ?><br><a target="_blank" href="https://developers.facebook.com/tools/explorer/"><?php echo esc_html('https://developers.facebook.com/tools/explorer/', WPFRSL_TD); ?></a></li>
                                <li><?php esc_html_e('Select the App that you just created and then select required permissions. The required permissions for publishing content to your facebook page are pages_show_list, pages_read_engagement, pages,pages_read_user_content.', WPFRSL_TD); ?></li>
                                <li><?php esc_html_e('Select the type of token that you want to generate. In this case you need User Access Token.', WPFRSL_TD); ?></li>
                                <li><?php esc_html_e('After selecting the App, the required permissions and the required access token you can click on ', WPFRSL_TD); ?><strong><?php esc_html_e('Generate Access Token', WPFRSL_TD); ?></strong><?php esc_html_e(' to generate the required access token.', WPFRSL_TD); ?></li>                 
                            </ul>
                        

                        <?php _e('<h5>Cache Settings</h5>', WPFRSL_TD); ?>
                        <p><?php _e('The plugin has inbuilt caching method to prevent the frequent API calls due to which site won’t get slow.So in this tab you can set up the cache period on how often the latest reviiews should be fetched from API.
                        Fill the time in hours in which the google places reviews should be updated. Default is 24 hours. The minimum cache period you can setup is 1 hour.', WPFRSL_TD); ?></p>


                        <?php _e('<h5>All Facebook Page Reviews</h5>', WPFRSL_TD); ?>
                        <p><?php _e('
                            Create multiple facebook page reviews and set its specific data separately.
                            Settings Steps to create facebook page reviews:
                            There is mainly 6 main settings to create facebook page review.', WPFRSL_TD); ?>
                        </p>
                        <div class="second-info">
                        <?php _e('<h5>1. Social Review API Settings</h5>', WPFRSL_TD); ?>
                        <p><?php _e(' In order to display facebook page here you must need to add APP ID and App Secret key on API Key Settings first. Then, click on login and then a pop up will appear where you will be asked the permission to use your information, click on Allow.After that, all your facebook account pages will be listed out. Now, select the page you want to retrieve the page review from. ', WPFRSL_TD); ?>
                        </p>
                        
                        <?php _e('<h5>2.Social Review Settings</h5>', WPFRSL_TD); ?>
                        <p><?php _e('This is the main configuration settings for reviews display.', WPFRSL_TD); ?>
                        </p>
                         <ul>
                            <li><?php _e('Total Number of Reviews: Set total number of user reviews options.', WPFRSL_TD); ?></li>
                            <li><?php _e("Hide Rating: In order to hide all user reviewer's image, enable this button.", WPFRSL_TD); ?></li>
                            <li><?php _e("Hide Description: Enable this checkbox to hide reviewer's description.", WPFRSL_TD); ?></li>
                            <li><?php _e('Description Limit: Set description limit to display at first and show read more and read less button.', WPFRSL_TD); ?></li>
                            <li><?php _e('Read More Text: Display text such as Read More , View More after set limit for user rating description.', WPFRSL_TD); ?></li>
                            <li><?php _e('Read Less Text: Display text such as Read More , View More after set limit for user rating description.', WPFRSL_TD); ?></li>
                            <li><?php _e('Display Order: Option to display the reviews in order: Rating, review text size, ascending and descending.', WPFRSL_TD); ?></li>
                        </ul>
                        
                        <h5><?php _e('3. Badge Settings', WPFRSL_TD); ?></h5>
                        <p><?php _e('This is configuration settings for badge display.', WPFRSL_TD); ?>
                        </p>
                         <ul>
                            <li><?php _e('Show Badge: Enable this button in order to display badge as header with page information.', WPFRSL_TD); ?></li>
                            <li><?php _e('Hide Average Rating: In order to hide average rating on badge, enable this button.', WPFRSL_TD); ?></li>
                            <li><?php _e('Badge Template: Choose any one template among 3 pre available badge templates. Below shown with template preview images.', WPFRSL_TD); ?></li>
                        </ul>
                        
                        <?php _e('<h5>4. Display Settings</h5>', WPFRSL_TD); ?>
                        <p><?php _e('This is configuration settings for all user reviews display according to total number of reviews display.', WPFRSL_TD); ?>
                        </p>
                         <ul>
                            <li><?php _e('Show Reviews: Enable this button in order to display user reviews with its details.', WPFRSL_TD); ?></li>
                            <li><?php _e('Choose Template: Choose any one template among 3 pre available reviews templates. Below shown with template preview images.', WPFRSL_TD); ?></li>
                            <li><?php _e('Layout Type: Choose layout type as slider, carousel, grid or list type. On choosing slider type, set options mode display as horizontal, vertical or fade type, review slider speed, pause in ms, show pager as dot or pagination type, autoplay and show controls as arrow or text type with custom design options. On choosing carousel type, displays the additional settings for min slide to display on carousel, max no of slide to display, slide width and slide margin. ', WPFRSL_TD); ?></li>
                        </ul>
                        </div>
                        
                        <?php _e('<h5>Shortcode Settings</h5>', WPFRSL_TD); ?>
                        <p><?php _e('You can get shortcode of specific facebook page from its edit page > Social Review Shortcode Usage metabox shown on left section or else you can get shortcode on main review lists for specific
                            google places reviews. For more details go to "Shortcode Usage" Tab.', WPFRSL_TD); ?>
                        </p>
                         
                </div>
                
             
            </div>
          </div>

       </div>

</div>