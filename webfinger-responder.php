<?php
/*
Plugin Name: Webfinger Responder
Description: Responds to /.well-known/webfinger requests with a Webfinger payload.
Author: Charles Gillham
Version: 1.0.0
*/

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('WEBFINGER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WEBFINGER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load required files
require_once WEBFINGER_PLUGIN_DIR . 'includes/class-webfinger.php';
require_once WEBFINGER_PLUGIN_DIR . 'admin/class-webfinger-admin.php';

// Initialize the plugin
function webfinger_init() {
    $plugin = new Webfinger();
    $plugin->init();
    
    if (is_admin()) {
        $admin = new Webfinger_Admin();
        $admin->init();
    }
}
add_action('plugins_loaded', 'webfinger_init');
