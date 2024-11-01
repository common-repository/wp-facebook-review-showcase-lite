<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!!' );

if ( !class_exists( 'WPFRSL_Activation' ) ) 
{

    class WPFRSL_Activation extends WPFRSL_Library{

        /**
         * Executes all the tasks on plugin activation
         * 
         * @since 1.0.0
         */
        function __construct() {
            register_activation_hook( WPFRSL_PATH.'/wp-fb-review-showcase.php', array( $this, 'wpfrsl_activation' ) );
        }

        public function wpfrsl_activation() 
        {
            //Cr8 db to Insert 
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_name = $wpdb->prefix . 'wpfrsl_settings';
            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                id bigint(9) unsigned NOT NULL AUTO_INCREMENT,
                fb_settings longtext NOT NULL,
                PRIMARY KEY (id)
              ) $charset_collate;";

            require_once(ABSPATH.'wp-admin/includes/upgrade.php');
            dbDelta($sql);

            //Tab Animation (Animate.css)
            $wpfrsl_tab_animation_data = $this->wpfrsl_tab_animation_data();
            update_option('wpfrsl_tab_animation_data', $wpfrsl_tab_animation_data);
        }

        public function wpfrsl_tab_animation_data() {
            $wpfrsl_tab_animation_data = array(
                'fading_entrances' => array('fadeIn','fadeInLeft','fadeInRight','fadeInUp','fadeInDown'),
                'bouncing_entrances' => array('bounce','bounceInLeft','bounceInRight','bounceInUp','bounceInDown'),
                'flippers' => array('flip','flipInX','flipInY'),
                'lightspeed' => array('lightSpeedIn'),
                'sliding_entrances' => array('slideInUp','slideInDown','slideInLeft','slideInRight'),
                'zoom_entrances' => array('zoomIn','zoomInDown','zoomInLeft','zoomInRight','zoomInUp'),
                'attention_seekers' => array('flash','pulse'),
            );
            return $wpfrsl_tab_animation_data;
        }

    }

    new WPFRSL_Activation();
}
