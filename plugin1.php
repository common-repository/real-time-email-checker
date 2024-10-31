<?php
/*
Plugin Name: Email Checker's Email Verification Plugin
Plugin URI: https://www.emailchecker.io
Description: Prevent spam signups by bots and lost customers with an highly advanced email validation system in comment, user registration and contact forms using Email Checker's Email Verification Services.
Author: Email Checker
Version: 1.1
Author URI: https://www.emailchecker.io
*/

// Set up our WordPress Plugin
function ec_check_WP_ver()
{
    if (version_compare(get_bloginfo('version'), '3.1', '<')) {
        wp_die("You must update WordPress to use this plugin!");
    }

    if (get_option('ec_array') === false) {
        $options_array['ec_apikey'] = 'XXXXXXXX';
        $options_array['ec_version'] = '1';
        add_option('ec_array', $options_array);
    }
}

function plugin_init()
{
    add_filter('is_email', 'verify_email');
}

function verify_email($emailID)
{

    $options = get_option('ec_array');
    $key = $options['ec_apikey'];

    $url = 'https://cloud1.emailchecker.io/api/verify/?apiKey=' . $key . '&email=' . $emailID;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $response = curl_exec($ch);
    curl_close($ch);

// decode the json response
    $json = json_decode($response, true);

// easily access each string
    $status = $json['status'];
    $event = $json['event'];
    $details = $json['details'];

    if ($status == 'failed') {
        return FALSE;
    }

    if ($status != 'failed') {
        return TRUE;
    }


}


plugin_init();

register_activation_hook(__FILE__, 'ec_check_WP_ver');

// Include or Require any files
include('process.php');
include('display-options.inc.php');
include('menus.inc.php');

// Action & Filter Hooks
add_action('admin_menu', 'ec_add_admin_menu');
add_action('admin_post_ec_save_validator_option', 'process_ec_validator_options');

?>
