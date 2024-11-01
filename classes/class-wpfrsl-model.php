<?php defined('ABSPATH') or die('No script kiddies please!!');

if ( !class_exists('WPFRSL_MODEL') ) 
{
    class WPFRSL_MODEL {
        
        var $wpfrsl_wpdb;
        /**
         * Assigns global $wpdb to wpfrsl_wpdb
         *
         * @global object $wpdb
         *
         * @since 1.0.0
         */
        function __construct() {
            global $wpdb;
            $this->WPFRSL_wpdb = $wpdb;
        }
        
        
        /**
         * Fetches specific and all reviews
         *
         * @return array $gpr_results
         *
         * @since 1.0.0
         */
        function get_all_reviews($post_type) {
            $wpfrsl_results = array();
            $wpfrsl_results = $this->wpfrsl_wpdb->get_results( $this->wpfrsl_wpdb->prepare( "SELECT ID, fb_settings FROM {$this->wpfrsl_wpdb->posts} WHERE post_type = %s and post_status = 'publish'", $post_type ), ARRAY_A );
           return $wpfrsl_results;
        }

    }
    $GLOBALS[ 'wpfrsl_wpdb' ] = new WPFRSL_MODEL;
}