<?php defined('ABSPATH') or die('No Script');

$wpfrsl_settings = array();
$wpfrsl_settings['fb'] = stripslashes_deep( $this->sanitize_array( $_POST['fb'] ) );
$wpfrsl_settings = maybe_serialize( $wpfrsl_settings );

global $wpdb;
$table_name = $wpdb->prefix. 'wpfrsl_settings';

$data = array(
			'fb_settings' => $wpfrsl_settings,
			);

$status = $wpdb->insert( $table_name, $data, array('%s') );

if($status)
{
	echo "success";exit();
	wp_redirect(admin_url().'admin.php?page=wpfrsl-main&message=1');
}
else
{
	echo "Sorry";exit();
	wp_redirect(admin_url().'admin.php?page=wpfrsl-main&message=0');
}