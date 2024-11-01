<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div  class="wpfrsl-shortcode-usage-wrapper">
    <ul>
        <li rel="tab-1" class="selected">
            <p class="description">
                <?php _e('Copy ',WPFRSL_TD);?>&amp;<?php _e(' paste the shortcode directly into any WordPress post or page.',WPFRSL_TD);?>
                </p>
             <h4><?php _e('Shortcode', WPFRSL_TD);?></h4>
             <input type='text' class='wpfrsl-shortcode-wrap' readonly='' value='[wpfrsl_reviews id="<?php echo esc_attr($post->ID); ?>"]' style='width: 100%;' onclick='select()' />
            <span class="wpfrsl-copied-info" style="display: none;"><?php _e('Shortcode copied to your clipboard.', WPFRSL_TD); ?></span>
        </li>
        <li rel="tab-2">
            <h4><?php _e('Template Include', WPFRSL_TD);?></h4>
            <p class="description"><?php _e('Copy ', WPFRSL_TD);?>&amp;<?php _e(' paste this code into a template file to include the Facebook Page Reviews within your theme to display this specific page review.',WPFRSL_TD);?></p>
            
             <textarea cols="37" rows="3" class='wpfrsl-shortcode-wrap2' readonly='readonly'>&lt;?php echo do_shortcode("[wpfrsl_reviews id=<?php echo $post->ID; ?>]")?&gt;</textarea>
             <span class="wpfrsl-copied-info2" style="display: none;"><?php _e('Shortcode copied to your clipboard.', WPFRSL_TD); ?></span>
        </li>
    </ul>
</div>
