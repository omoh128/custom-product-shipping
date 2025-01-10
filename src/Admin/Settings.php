<?php
namespace CustomShipping\Admin;

class Settings {
    private $option_group = 'custom_shipping_options';
    private $option_name = 'custom_shipping_settings';

    public function __construct() {
        add_action('admin_menu', [$this, 'addSettingsPage']);
        add_action('admin_init', [$this, 'initSettings']);
    }

    public function addSettingsPage() {
        add_submenu_page(
            'woocommerce',
            __('Custom Shipping Settings', 'custom-shipping'),
            __('Custom Shipping', 'custom-shipping'),
            'manage_woocommerce',
            'custom-shipping-settings',
            [$this, 'renderSettingsPage']
        );
    }

    public function initSettings() {
        register_setting(
            $this->option_group,
            $this->option_name,
            [$this, 'sanitizeSettings']
        );

        add_settings_section(
            'general_settings',
            __('General Settings', 'custom-shipping'),
            [$this, 'renderSettingsSection'],
            'custom-shipping-settings'
        );

        add_settings_field(
            'default_shipping',
            __('Default Shipping Cost', 'custom-shipping'),
            [$this, 'renderDefaultShippingField'],
            'custom-shipping-settings',
            'general_settings'
        );

        add_settings_field(
            'free_shipping_threshold',
            __('Free Shipping Threshold', 'custom-shipping'),
            [$this, 'renderFreeShippingField'],
            'custom-shipping-settings',
            'general_settings'
        );
    }

    public function renderSettingsPage() {
        require_once CUSTOM_SHIPPING_PLUGIN_PATH . 'templates/admin/settings-page.php';
    }

    public function renderSettingsSection() {
        echo '<p>' . esc_html__('Configure global settings for custom shipping costs.', 'custom-shipping') . '</p>';
    }

    public function renderDefaultShippingField() {
        $options = get_option($this->option_name);
        $value = isset($options['default_shipping']) ? $options['default_shipping'] : '';
        ?>
        <input type="number" 
               name="<?php echo esc_attr("{$this->option_name}[default_shipping]"); ?>"
               value="<?php echo esc_attr($value); ?>"
               step="0.01"
               min="0" />
        <?php
    }

    public function renderFreeShippingField() {
        $options = get_option($this->option_name);
        $value = isset($options['free_shipping_threshold']) ? $options['free_shipping_threshold'] : '';
        ?>
        <input type="number" 
               name="<?php echo esc_attr("{$this->option_name}[free_shipping_threshold]"); ?>"
               value="<?php echo esc_attr($value); ?>"
               step="0.01"
               min="0" />
        <?php
    }

    public function sanitizeSettings($input) {
        $sanitized = [];
        
        if (isset($input['default_shipping'])) {
            $sanitized['default_shipping'] = floatval($input['default_shipping']);
        }
        
        if (isset($input['free_shipping_threshold'])) {
            $sanitized['free_shipping_threshold'] = floatval($input['free_shipping_threshold']);
        }
        
        return $sanitized;
    }
}






