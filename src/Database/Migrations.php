<?php
namespace CustomShipping\Database;

class Migrations {
    private $version = '1.0.0';
    private $option_name = 'custom_shipping_db_version';

    public function __construct() {
        add_action('plugins_loaded', [$this, 'checkVersion']);
    }

    public function checkVersion() {
        if (get_option($this->option_name) !== $this->version) {
            $this->runMigrations();
        }
    }

    private function runMigrations() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        
        // Create custom shipping rules table
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}custom_shipping_rules (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            rule_name varchar(255) NOT NULL,
            conditions longtext NOT NULL,
            shipping_cost decimal(10,2) NOT NULL,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        update_option($this->option_name, $this->version);
    }
}