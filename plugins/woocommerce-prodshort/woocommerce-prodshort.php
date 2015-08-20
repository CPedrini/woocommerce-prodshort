<?php

 /*
    Plugin Name: WooCommerce Product Shortlinks Importer
    Plugin URI: https://www.ciropedrini.com.ar/
    Description: CSV import utility for WooCommerce which imports custom fields for specifics SKU's
    Version: 1
    Author: Ciro Pedrini
    Author URI: https://www.ciropedrini.com.ar/
    Text Domain: woocommerce-prodshort
    Domain Path: /languages/
*/

    class WooCommerce_ProdShor_Importer {
        
        public function __construct() {
            add_action('admin_menu', array('WooCommerce_ProdShor_Importer', 'admin_menu'));
            add_action('wp_ajax_woocommerce-prodshort-ajax', array('WooCommerce_ProdShor_Importer', 'render_ajax_action'));
        }

        public function admin_menu() {
            add_management_page( 'Woo ProdShort Importer', 'Woo ProdShort Importer', 'manage_options', 'woocommerce-prodshort', array('WooCommerce_ProdShor_Importer', 'render_admin_action'));
        }
        
        public function render_admin_action() {
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'upload';
            require_once(plugin_dir_path(__FILE__).'woocommerce-prodshort-common.php');
            require_once(plugin_dir_path(__FILE__)."woocommerce-prodshort-{$action}.php");
        }
        
        public function render_ajax_action() {
            require_once(plugin_dir_path(__FILE__)."woocommerce-prodshort-ajax.php");
            die(); // this is required to return a proper result
        }
    }
    
    $woocommerce_prodshor_importer = new WooCommerce_ProdShor_Importer();
