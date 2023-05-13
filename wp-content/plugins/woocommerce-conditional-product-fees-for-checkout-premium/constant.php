<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * define constant variabes
 * define admin side constant
 *
 * @param null
 *
 * @author Multidots
 * @since  1.0.0
 */
// define constant for plugin slug
if( ! defined( 'CONDITIOANAL_FEE_PRO_PLUGIN_NAME' ) ){
	define( 'CONDITIOANAL_FEE_PRO_PLUGIN_NAME', 'WooCommerce Extra Fees Plugin' );
}
if ( ! defined( 'WCPFC_PRO_PLUGIN_VERSION' ) ) {
	define( 'WCPFC_PRO_PLUGIN_VERSION', '3.9.2.1' );
}
if ( ! defined( 'WCPFC_PRO_PLUGIN_URL' ) ) {
	define( 'WCPFC_PRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'WCPFC_PLUGIN_DIR' ) ) {
	define( 'WCPFC_PLUGIN_DIR', dirname( __FILE__ ) );
}
if ( ! defined( 'WCPFC_PRO_PLUGIN_DIR_PATH' ) ) {
	define( 'WCPFC_PRO_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'WCPFC_PRO_SLUG' ) ) {
	define( 'WCPFC_PRO_SLUG', 'woocommerce-conditional-product-fees-for-checkout' );
}
if ( !defined( 'WCPFC_PRO_PREMIUM_VERSION' ) ) {
    
    if ( wcpffc_fs()->is__premium_only() ) {
        if ( wcpffc_fs()->can_use_premium_code() ) {
            define( 'WCPFC_PRO_PREMIUM_VERSION', 'Premium Version ' );
        } else {
            define( 'WCPFC_PRO_PREMIUM_VERSION', 'Free Version ' );
        }
    } else {
        if ( !defined( 'WCPFC_PRO_PREMIUM_VERSION' ) ) {
            define( 'WCPFC_PRO_PREMIUM_VERSION', 'Free Version ' );
        }
    }
}
if ( !defined( 'WCPFC_PRO_PLUGIN_NAME' ) ) {
    define( 'WCPFC_PRO_PLUGIN_NAME', 'WooCommerce Extra Fees Plugin' );
}
if ( !defined( 'WCPFC_PRO_PLUGIN_BASENAME' ) ) {
    define( 'WCPFC_PRO_PLUGIN_BASENAME', $basepath );
}