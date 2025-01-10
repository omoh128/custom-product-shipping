<?php
namespace CustomShipping;

class Plugin {

    
    private static $instance = null;
    
    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->initHooks();
        new Database\Migrations();
        new Admin\Settings();
        new API\RestController();
    }
    
    private function initHooks() {
        add_action('init', [$this, 'loadTextdomain']);
        new Admin\ProductTab();
        new Frontend\ShippingCalculator();
    }
    
    public function loadTextdomain() {
        load_plugin_textdomain(
            'custom-shipping',
            false,
            dirname(plugin_basename(CUSTOM_SHIPPING_PLUGIN_FILE)) . '/languages'
        );
    }
}
