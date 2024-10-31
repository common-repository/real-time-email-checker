<?php


function process_ec_validator_options()
{
    if (!current_user_can('manage_options')) {
        wp_die('You are not allowed to be on this page.');
    }
    // Check that nonce field
    check_admin_referer('ec_verify');

    $options = get_option('ec_array');

    if (isset($_POST['api_key'])) {
        $options['ec_apikey'] = sanitize_text_field($_POST['api_key']);
    }

    update_option('ec_array', $options);


    $optionsc = get_option('ec_array');
    $key = $optionsc['ec_apikey'];

    $url = 'https://cloud1.emailchecker.io/api/verify/?apiKey=' . $key . '&email=check123@gmail.com';
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

    if ($status == 'error') {
        wp_redirect(admin_url('options-general.php?page=real-time-email-checker/menus.inc.php_display_contents&m=0'));
        exit;
    } else {
        wp_redirect(admin_url('options-general.php?page=real-time-email-checker/menus.inc.php_display_contents&m=1'));
        exit;
    }

}

?>