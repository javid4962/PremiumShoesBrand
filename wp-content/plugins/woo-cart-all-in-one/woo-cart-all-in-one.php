<?php
/**
 * Plugin Name: Cart All In One For WooCommerce
 * Plugin URI: https://villatheme.com/extensions/woocommerce-cart-all-in-one/
 * Description: Cart All In One For WooCommerce helps your customers view cart effortlessly.
 * Author: VillaTheme
 * Author URI:https://villatheme.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version: 1.1.15
 * Text Domain: woo-cart-all-in-one
 * Domain Path: /languages
 * Copyright 2019-2024 VillaTheme.com. All rights reserved.
 * Requires Plugins: woocommerce
 * Requires PHP: 7.0
 * Requires at least: 5.0
 * Tested up to: 6.5
 * WC requires at least: 7.0
 * WC tested up to: 8.7
 */

if (!defined('ABSPATH')) {
    exit();
}
define( 'VI_WOO_CART_ALL_IN_ONE_VERSION', '1.1.15' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );


class WOO_CART_ALL_IN_ONE
{
    public function __construct()
    {
	    //compatible with 'High-Performance order storage (COT)'
	    add_action( 'before_woocommerce_init', array( $this, 'before_woocommerce_init' ) );
	    if ( is_plugin_active( 'woocommerce-cart-all-in-one/woocommerce-cart-all-in-one.php' ) ) {
		    return;
	    }
	    add_action( 'plugins_loaded', array( $this, 'init' ) );
	    define( 'VI_WOO_CART_ALL_IN_ONE_DIR',  plugin_dir_path( __FILE__ ) );
	    define( 'VI_WOO_CART_ALL_IN_ONE_INC', VI_WOO_CART_ALL_IN_ONE_DIR . "includes" . DIRECTORY_SEPARATOR );
    }
	public function init() {
		$include_dir = plugin_dir_path( __FILE__ ) . 'includes/';
		if ( ! class_exists( 'VillaTheme_Require_Environment' ) ) {
			include_once $include_dir . 'support.php';
		}

		$environment = new VillaTheme_Require_Environment( [
				'plugin_name'     => 'Cart All In One For WooCommerce',
				'php_version'     => '7.0',
				'wp_version'      => '5.0',
				'require_plugins' => [
					[
						'slug' => 'woocommerce',
					  'name' => 'WooCommerce',
						'required_version' => '7.0',
					]
				]
			]
		);

		if ( $environment->has_error() ) {
			return;
		}

		$init_file = VI_WOO_CART_ALL_IN_ONE_INC . "define.php";
		require_once $init_file;
	}

	public function before_woocommerce_init() {
		if ( class_exists( '\Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
}

new WOO_CART_ALL_IN_ONE();