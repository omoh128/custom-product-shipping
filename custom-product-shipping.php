<?php
/**
 * Plugin Name: Custom Product Shipping
 * Description: Custom shipping costs for WooCommerce products
 * Version: 1.0.0
 * Author: Omomoh Agiogu
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

// Setup autoloading
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

define('CUSTOM_SHIPPING_PLUGIN_FILE', __FILE__);
define('CUSTOM_SHIPPING_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CUSTOM_SHIPPING_PLUGIN_URL', plugin_dir_url(__FILE__));

// Initialize plugin
function initCustomShipping() {
    return \CustomShipping\Plugin::getInstance();
}

add_action('plugins_loaded', 'initCustomShipping');