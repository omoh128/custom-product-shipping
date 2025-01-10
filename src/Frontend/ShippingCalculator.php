<?php

namespace CustomShipping\Frontend;

class ShippingCalculator {
    public function __construct() {
        add_action('woocommerce_cart_calculate_fees', [$this, 'calculateShipping']);
        add_action('woocommerce_review_order_before_shipping', [$this, 'displayNotice']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
    }
    
    public function calculateShipping($cart) {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        $total_shipping = $this->calculateTotalShipping($cart);
        
        if ($total_shipping > 0) {
            $cart->add_fee(
                __('Product Shipping', 'custom-shipping'),
                $total_shipping
            );
        }
    }
    
    private function calculateTotalShipping($cart) {
        $total = 0;
        foreach ($cart->get_cart() as $item) {
            $shipping_cost = get_post_meta($item['product_id'], '_custom_shipping_cost', true);
            if (!empty($shipping_cost)) {
                $total += floatval($shipping_cost) * $item['quantity'];
            }
        }
        return $total;
    }
    
    public function displayNotice() {
        $shipping_items = $this->getShippingItems();
        if (!empty($shipping_items)) {
            require CUSTOM_SHIPPING_PLUGIN_PATH . 'templates/frontend/shipping-notice.php';
        }
    }
    
    private function getShippingItems() {
        $items = [];
        foreach (WC()->cart->get_cart() as $item) {
            $shipping_cost = get_post_meta($item['product_id'], '_custom_shipping_cost', true);
            if (!empty($shipping_cost)) {
                $product = wc_get_product($item['product_id']);
                $items[] = [
                    'name' => $product->get_name(),
                    'cost' => number_format(floatval($shipping_cost), 2)
                ];
            }
        }
        return $items;
    }
    
    public function enqueueAssets() {
        wp_enqueue_style(
            'custom-shipping',
            CUSTOM_SHIPPING_PLUGIN_URL . 'assets/css/custom-shipping.css',
            [],
            '1.0.0'
        );
    }
}