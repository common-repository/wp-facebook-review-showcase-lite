<?php
defined('ABSPATH') or die("No script kiddies please!");
?>

<div class="wpfrsl-settings-main-wrapper wpfrsl-wrapper">
    <div class="wpfrsl-header" style="background-color: black;">
        <?php include_once('panel-head.php'); ?>
    </div>

    <div class="wpfrsl-container wpfrsl-tab-container">
        <div class="row">
            <div class="wpfrsl_mainwrapper clearfix">
                <div class="wpfrsl_second-wrapper"> 
                    <ul class="wpfrsl-nav-tabs wpfrsl-tabs-left"> 
                        <li class="tab-link current">
                            <a class="tab_settings" data-tab="howtouse" data-toggle="tab">
                                <span class="dashicons dashicons-info"></span>
                                <?php _e('How To Use', WPFRSL_TD); ?>
                            </a>
                        </li>
                         <li class="tab-link">
                            <a class="tab_settings" data-tab="shortcode_usage" data-toggle="tab">
                                <span class="dashicons dashicons-format-aside"></span>
                                <?php _e('Shortcode Usage', WPFRSL_TD); ?>
                            </a>
                        </li>
                        <li class="tab-link">
                            <a class="tab_settings" data-tab="aboutus" data-toggle="tab">
                                <span class="dashicons dashicons-businessman"></span>
                                <?php _e('About Us', WPFRSL_TD); ?>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="wpfrsl-content-wrapper">
                    <div class="wpfrsl-tab-pane">
                        <div class="wpfrsl-tab-content" id="howtouse" >
                            <?php include_once('wpfrsl-howtouse.php'); ?>               
                        </div>
                       <div class="wpfrsl-tab-content" id="shortcode_usage" style="display: none;">
                            <?php include_once('wpfrsl-shortcode-usage.php'); ?>               
                        </div>

                        <div class="wpfrsl-tab-content" id="aboutus" style="display: none;">
                            <?php include_once('wpfrsl-about.php'); ?>            
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>








