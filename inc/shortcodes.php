<?php
/*************************************
* Shortcodes
*************************************/

function cx_sc_services_webfonts($atts, $content = null) {
	extract(shortcode_atts(array(
		"link" => 'true',
		"linktext" => 'false'
	), $atts));
	
	$cx_services = get_option( 'cx_services' );
	if (isset($cx_services['cx_webfonts_embed'])) {
		$user_webfonts = $cx_services['cx_webfonts_embed'];
	} else {
		$user_webfonts = '#';
	}
	
	if ( ($link == 'true') && ($linktext != 'false') ) {
		$email = '<a href="mailto:' . $user_webfonts . '">' . $linktext . '</a>';
	} elseif ($link == 'true') {
		$email = '<a href="mailto:' . $user_webfonts . '">' . $user_webfonts . '</a>';
	} else {
		$email = $user_webfonts;
	}
	
	return $email;  
}

add_shortcode('contact-email', 'cx_sc_services_webfonts');
add_shortcode('contact-address', 'cx_sc_services_address');
add_shortcode('contact-postcode', 'cx_sc_services_address_pc');
add_shortcode('contact-phone', 'cx_sc_services_phone');

add_shortcode('social-twitter', 'cx_sc_services_twitter');
add_shortcode('social-facebook', 'cx_sc_services_facebook');
add_shortcode('social-gplus', 'cx_sc_services_gplus');

/*************************************
* Shortcodes Part 2: Add button to Tiny MCE
*************************************/

function register_button_cx_services( $buttons ) {
   array_push( $buttons, "deets_webfonts", "deets_phone", "deets_address", "deets_tw", "deets_fb", "deets_gplus" );
   return $buttons;
}

function add_plugin_cx_services( $plugin_array ) {
	$plugin_array['deets_webfonts'] = plugins_url('/js/services.js',__file__);
	$plugin_array['deets_phone'] = plugins_url('/js/services.js',__file__);
	$plugin_array['deets_address'] = plugins_url('/js/services.js',__file__);
   $plugin_array['deets_tw'] = plugins_url('/js/services.js',__file__);
   $plugin_array['deets_fb'] = plugins_url('/js/services.js',__file__);
   $plugin_array['deets_gplus'] = plugins_url('/js/services.js',__file__);
   return $plugin_array;
}

function cx_services_button() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'add_plugin_cx_services' );
      add_filter( 'mce_buttons_2', 'register_button_cx_services' );
   }

}

add_action('init', 'cx_services_button');

?>