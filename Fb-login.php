<?php
/*
Plugin Name: Facebook Login Plugin
Description: Integration of Facebook login functionality into WordPress using shortcode.
Version: 1.0
Company: CodeWooInsider
Author: Urooj
Author URI: https://code-woo-insider.free.nf/
*/

// Ensure this file isn't accessed directly
defined('ABSPATH') or die();

// Include Facebook PHP SDK
require_once 'Facebook/autoload.php';

// Start session
session_start();

$FBObject = new \Facebook\Facebook([
    'app_id' => ' YOUR_APP_ID', // Replace with your actual app id
    'app_secret' => 'YOUR_APP_SECRET', // Replace with your actual app secret
    'default_graph_version' => 'v20.0'
]);
$handler = $FBObject->getRedirectLoginHelper();

// Enqueue necessary styles
function fb_login_plugin_scripts() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css');
}
add_action('wp_enqueue_scripts', 'fb_login_plugin_scripts');

// Shortcode function to display Facebook login button
function fb_login_shortcode() {
    if (!is_user_logged_in()) {
        if (!get_option('users_can_register')) {
            return 'The registrations are closed!';
        } else {
            global $handler;
            $link = admin_url('admin-ajax.php?action=fb_login_callback');
            $permissions = ['email']; // Optional permissions
            $loginUrl = $handler->getLoginUrl($link, $permissions);
            return '<a href="' . $loginUrl . '" class="btn btn-primary">Login With Facebook</a>';
        }
    } else {
        $current_user = wp_get_current_user();
        return 'Hi ' . $current_user->first_name . '! - <a href="' . wp_logout_url(home_url()) . '">Log Out</a>';
    }
}
add_shortcode('fb_login_button', 'fb_login_shortcode');

// Handle Facebook login request
function fb_login_callback() {
    global $handler, $FBObject;

    try {
        $accessToken = $handler->getAccessToken();
    } catch (\Facebook\Exceptions\FacebookResponseException $e) {
        echo "Response Exception: " . $e->getMessage();
        exit();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo "SDK Exception: " . $e->getMessage();
        exit();
    }

    if (!$accessToken) {
        wp_redirect(home_url());
        exit;
    }

    $oAuth2Client = $FBObject->getOAuth2Client();
    if (!$accessToken->isLongLived()) {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    }

    try {
        $response = $FBObject->get("/me?fields=id,first_name,last_name,email,picture.type(large)", $accessToken);
        $userData = $response->getGraphNode()->asArray();
    } catch (\Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }

    $user_email = $userData['email'];
    if (!email_exists($user_email)) {
        $bytes = openssl_random_pseudo_bytes(2);
        $password = md5(bin2hex($bytes));
        $user_login = strtolower($userData['first_name'] . $userData['last_name']);

        $new_user_id = wp_insert_user([
            'user_login'    => $user_login,
            'user_pass'     => $password,
            'user_email'    => $user_email,
            'first_name'    => $userData['first_name'],
            'last_name'     => $userData['last_name'],
            'user_registered' => date('Y-m-d H:i:s'),
            'role'          => 'subscriber'
        ]);

        if ($new_user_id) {
            wp_new_user_notification($new_user_id);
            wp_set_current_user($new_user_id);
            wp_set_auth_cookie($new_user_id, true);
            wp_redirect(home_url());
            exit();
        }
    } else {
        $user = get_user_by('email', $user_email);
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true);
        wp_redirect(home_url());
        exit();
    }
}
add_action('wp_ajax_fb_login_callback', 'fb_login_callback');
add_action('wp_ajax_nopriv_fb_login_callback', 'fb_login_callback');

// Redirect users to home page after they log out
add_action('wp_logout', function() {
    wp_redirect(home_url());
    exit();
});

// Admin notice for the plugin
function fb_login_plugin_admin_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p>Thank you for using the Facebook Login Plugin by <a href="https://code-woo-insider.free.nf/" target="_blank">CodeWooInsider</a>.</p>
    </div>
    <?php
}
add_action('admin_notices', 'fb_login_plugin_admin_notice');

// Display admin notice on plugin activation
function fb_login_plugin_activation_hook() {
    set_transient('fb_login_plugin_activation_notice', true, 5);
}
register_activation_hook(__FILE__, 'fb_login_plugin_activation_hook');

// Show the activation notice
function fb_login_plugin_show_activation_notice() {
    if (get_transient('fb_login_plugin_activation_notice')) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p>Thank you for activating the Facebook Login Plugin by <a href="https://code-woo-insider.free.nf/" target="_blank">CodeWooInsider</a>.</p>
        </div>
        <?php
        delete_transient('fb_login_plugin_activation_notice');
    }
}
add_action('admin_notices', 'fb_login_plugin_show_activation_notice');
?>
