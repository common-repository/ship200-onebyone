<?php
error_reporting(0);

global $wpdb;
global $woocommerce;

$settings = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM ". $wpdb->prefix . "ship200onebyone WHERE shipid = %d", 1) );

$secret_key_one = $settings->ship200key;
$order_status_import_one = $settings->orderstatustracking;
$tracking = $settings->tracking;

if ($secret_key_one == "") {
    echo "The Secret Key was never setup. Please refer to read_me file";
    exit;
}
if ($order_status_import_one == "") {
    echo "Please Select Order Status From Admin for Order Import";
    exit;
}
if ($tracking == "no") {
    echo "Post back is disabled";
    exit;
}

#Extra security

// Check that request is coming from Ship200 Server
$allowed_servers = file_get_contents('http://www.ship200.com/instructions/allowed_servers.txt');
if(!$allowed_servers) $allowed_servers = '173.192.194.99,173.192.194.98,108.58.55.190,45.33.71.107,45.33.73.63,45.33.89.56,45.33.85.63,97.107.136.135,45.79.162.158,45.79.136.18,45.79.130.178,173.220.12.130,2600:3c03::f03c:91ff:fe98:b9a6,2600:3c03::f03c:91ff:fe18:9304,2600:3c03::f03c:91ff:fe18:a8b8,2600:3c03::f03c:91ff:fe18:a8ab,2600:3c03::f03c:91ff:fe18:a8bc,2600:3c03::f03c:91ff:fe3b:4d12,2600:3c03::f03c:91ff:fe67:8ae5';

$server = false;
if(strpos($allowed_servers, getClientIp()) !== false) $server = true;

// Check that request is coming from Ship200 Server
if (!$server) {
    echo 'Invalid Server ('. getClientIp() . ')';
    exit;
}

if ($_REQUEST['update_tracking'] != "" && $_GET['id'] == $secret_key_one && $server == 1) {
    $comment = sanitize_text_field($_POST['carrier']) . " tracking# : " . sanitize_text_field($_POST['tracking']);
    $order_id = (int) sanitize_text_field($_REQUEST['keyForUpdate']);

    $order = new WC_Order($order_id);

    $order->update_status(sanitize_text_field($order_status_import_one));
    $order->add_order_note($comment);
    echo "Tracking Inserted";
    exit;
} else {
    // Not valid request //////
    echo "Error: 1094";
    exit;
}

function getClientIp() {
    $ipAddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipAddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipAddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipAddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipAddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipAddress = getenv('REMOTE_ADDR');
    else
        $ipAddress = 'UNKNOWN';
    return $ipAddress;
}