<?php
namespace CustomShipping\Admin;

class ProductTab {
    public function __construct() {
        add_filter('woocommerce_product_data_tabs', [$this, 'addProductTab']);
        add_action('woocommerce_product_data_panels', [$this, 'addProductFields']);
        add_action('woocommerce_process_product_meta', [$this, 'saveProductFields']);
    }
    
    public function addProductTab($tabs) {
        $tabs['custom_shipping'] = [
            'label' => __('Custom Shipping', 'custom-shipping'),
            'target' => 'custom_shipping_cost',
            'class' => ['show_if_simple', 'show_if_variable'],
        ];
        return $tabs;
    }
    
    public function addProductFields() {
        require_once CUSTOM_SHIPPING_PLUGIN_PATH . 'templates/admin/product-tab.php';
    }
    
    public function saveProductFields($post_id) {
        $shipping_cost = isset($_POST['_custom_shipping_cost']) 
            ? sanitize_text_field($_POST['_custom_shipping_cost']) 
            : '';
        update_post_meta($post_id, '_custom_shipping_cost', $shipping_cost);
    }
}
