// File: src/API/RestController.php
<?php
namespace CustomShipping\API;

use WP_REST_Controller;
use WP_REST_Server;
use WP_Error;

class RestController extends WP_REST_Controller {
    protected $namespace = 'custom-shipping/v1';

    public function __construct() {
        add_action('rest_api_init', [$this, 'registerRoutes']);
    }

    public function registerRoutes() {
        register_rest_route(
            $this->namespace,
            '/shipping/product/(?P<id>\d+)',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'getProductShipping'],
                    'permission_callback' => [$this, 'checkReadPermission'],
                    'args' => [
                        'id' => [
                            'validate_callback' => function($param) {
                                return is_numeric($param);
                            }
                        ]
                    ]
                ],
                [
                    'methods' => WP_REST_Server::EDITABLE,
                    'callback' => [$this, 'updateProductShipping'],
                    'permission_callback' => [$this, 'checkUpdatePermission'],
                    'args' => [
                        'id' => [
                            'validate_callback' => function($param) {
                                return is_numeric($param);
                            }
                        ],
                        'shipping_cost' => [
                            'required' => true,
                            'type' => 'number',
                            'minimum' => 0
                        ]
                    ]
                ]
            ]
        );

        register_rest_route(
            $this->namespace,
            '/shipping/rules',
            [
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'getShippingRules'],
                    'permission_callback' => [$this, 'checkReadPermission']
                ]
            ]
        );
    }

    public function getProductShipping($request) {
        $product_id = $request['id'];
        $shipping_cost = get_post_meta($product_id, '_custom_shipping_cost', true);

        if (empty($shipping_cost)) {
            return new WP_Error(
                'no_shipping_cost',
                'No shipping cost set for this product',
                ['status' => 404]
            );
        }

        return [
            'product_id' => $product_id,
            'shipping_cost' => (float) $shipping_cost
        ];
    }

    public function updateProductShipping($request) {
        $product_id = $request['id'];
        $shipping_cost = $request['shipping_cost'];

        update_post_meta($product_id, '_custom_shipping_cost', $shipping_cost);

        return [
            'product_id' => $product_id,
            'shipping_cost' => (float) $shipping_cost,
            'message' => 'Shipping cost updated successfully'
        ];
    }

    public function getShippingRules() {
        global $wpdb;
        
        $rules = $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}custom_shipping_rules"
        );

        return [
            'rules' => $rules
        ];
    }

    public function checkReadPermission() {
        return current_user_can('read');
    }

    public function checkUpdatePermission() {
        return current_user_can('edit_shop_orders');
    }
}

