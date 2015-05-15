<?php
/*
Plugin Name: CX: Able Services
Plugin URI: http://www.ablewild.com
Description: This plugin allows you to include header or footer code for external services such as webfonts or analytics. This plugin is only licenced for the use of customers of Clark CX Ltd.
Version: 2.0
Author: Pete Clark
Author URI: http://www.ablewild.com/
*/

/*************************************
* global variables
*************************************/

$cx_services_plugin_name = 'Contact Details';

// Retrieve our plugin's settings from the options table
$cx_services_options = get_option('cx_services_settings');


/*************************************
* includes
*************************************/

include('inc/adminpage.php'); // This is the plugin options page

/*************************************
* settings link
*************************************/

function cx_services_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=cx-services-admin">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'cx_services_settings_link' );

/*************************************
* Add code to header
*************************************/

function cx_services_header() {
    $cx_services = get_option( 'cx_services' );
	if (isset($cx_services['cx_webfonts_embed'])) {
		$user_webfonts = $cx_services['cx_webfonts_embed'];
	} else {
		$user_webfonts = '';
	}
	echo $user_webfonts;
}

// Add hook for front-end <head></head>
add_action('wp_head', 'cx_services_header');

?>