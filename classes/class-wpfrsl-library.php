<?php defined('ABSPATH') or die('No script please!!');

if ( !class_exists('WPFRSL_Library') ) 
{
    
  class WPFRSL_Library {

    /**
    * Prints array in pre format
    *
    * @since 1.0.0
    *
    * @param array $array
    */
    function print_array($array) {
        echo "<pre>";
        print_r($array);
        echo "</pre>";
    }


    /**
     * Sanitizes Multi-Dimensional Array
     * @param array $array
     * @param array $sanitize_rule
     * @return array
     *
     * @since 1.0.0
     */
    static function sanitize_array($array = array(), $sanitize_rule = array()) 
    {
      if (!is_array($array) || count($array) == 0) 
      {
          return array();
      }

      foreach ($array as $k => $v) {
          if (!is_array($v)) {
              $default_sanitize_rule = (is_numeric($k)) ? 'html' : 'text';
              $sanitize_type = isset($sanitize_rule[$k]) ? $sanitize_rule[$k] : $default_sanitize_rule;
              $array[$k] = self:: sanitize_value($v, $sanitize_type);
          }

          if (is_array($v)) {
              $array[$k] = self:: sanitize_array($v, $sanitize_rule);
          }
      }

      return $array;
    }

    /**
     * Sanitizes Value
     *
     * @param type $value
     * @param type $sanitize_type
     * @return string
     *
     * @since 1.0.0
     */
    static function sanitize_value($value = '', $sanitize_type = 'html') 
    {
      switch ($sanitize_type) 
      {
          case 'text':
              $allowed_html = wp_kses_allowed_html('post');
              // var_dump($allowed_html);
              return wp_kses($value, $allowed_html);
              break;
          default:
              return sanitize_text_field($value);
              break;
      }
    }

  }
}