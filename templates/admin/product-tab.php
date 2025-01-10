<div id="custom_shipping_cost" class="panel woocommerce_options_panel">
    <?php
    woocommerce_wp_text_input([
        'id' => '_custom_shipping_cost',
        'label' => __('Custom Shipping Cost ($)', 'custom-shipping'),
        'desc_tip' => true,
        'description' => __('Enter the shipping cost for this product.', 'custom-shipping'),
        'type' => 'number',
        'custom_attributes' => [
            'step' => '0.01',
            'min' => '0'
        ]
    ]);
    ?>
</div>
