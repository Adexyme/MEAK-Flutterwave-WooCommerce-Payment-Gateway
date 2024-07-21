<?php
/*
Plugin Name: Meak-Flutterwave-Gateway
Description: A Flutterwave payment gateway for WooCommerce by MEAK.
Version: 1.0.0
Author: Emmanuel Adegoke Akintoye 
Author URI: kintoye.com.ng
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain: Meak-Flutterwave-Gateway
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('plugins_loaded', 'meak_flutterwave_woocommerce_plugin', 0);

/**
 * Summary of meak_flutterwave_woocommerce_plugin
 * @return void
 */
function meak_flutterwave_woocommerce_plugin()
{
    if (!class_exists('WC_Payment_Gateway'))
        return; // if the WC payment gateway class 

    include (plugin_dir_path(__FILE__) . '/includes/class-gateway.php');
}


add_filter('woocommerce_payment_gateways', 'add_meak_flutterwave_gateway');

/**
 * Summary of add_meak_flutterwave_gateway
 * @param mixed $gateways
 * @return mixed
 */
function add_meak_flutterwave_gateway($gateways)
{
    $gateways[] = 'Meak_Flutterwave_Gateway';
    return $gateways;
}

/**
 * Custom function to declare compatibility with cart_checkout_blocks feature 
 */
/**
 * Summary of declare_meak_flutterwave_cart_checkout_blocks_compatibility
 * @return void
 */
function declare_meak_flutterwave_cart_checkout_blocks_compatibility()
{
    // Check if the required class exists
    if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
        // Declare compatibility for 'cart_checkout_blocks'
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('cart_checkout_blocks', __FILE__, true);
    }
}
// Hook the custom function to the 'before_woocommerce_init' action
add_action('before_woocommerce_init', 'declare_meak_flutterwave_cart_checkout_blocks_compatibility');

// Hook the custom function to the 'woocommerce_blocks_loaded' action
add_action('woocommerce_blocks_loaded', 'meak_flutterwave_register_order_approval_payment_method_type');

/**
 * Custom function to register a payment method type

 */

/**
 * Summary of meak_flutterwave_register_order_approval_payment_method_type
 * @return void
 */
function meak_flutterwave_register_order_approval_payment_method_type()
{
    // Check if the required class exists
    if (!class_exists('Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType')) {
        return;
    }

    // Include the custom Blocks Checkout class
    require_once plugin_dir_path(__FILE__) . '/includes/block/class-block.php';

    // Hook the registration function to the 'woocommerce_blocks_payment_method_type_registration' action
    add_action(
        'woocommerce_blocks_payment_method_type_registration',
        function (Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry) {
            // Register an instance of Meak_Flutterwave_Gateway_Blocks
            $payment_method_registry->register(new Meak_Flutterwave_Gateway_Blocks);
        }
    );
}