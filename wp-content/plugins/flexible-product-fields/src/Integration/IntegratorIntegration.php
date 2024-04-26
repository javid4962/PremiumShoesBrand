<?php

namespace WPDesk\FPF\Free\Integration;

use VendorFPF\WPDesk\PluginBuilder\Plugin\Hookable;
use VendorFPF\WPDesk\PluginBuilder\Plugin\HookablePluginDependant;
use VendorFPF\WPDesk\PluginBuilder\Plugin\PluginAccess;

/**
 * .
 */
class IntegratorIntegration implements Hookable, HookablePluginDependant {

	use PluginAccess;

	/**
	 * Instance of old version main class of plugin.
	 *
	 * @var \Flexible_Product_Fields_Plugin
	 */
	private $plugin_old;

	/**
	 * Class constructor.
	 *
	 * @param \Flexible_Product_Fields_Plugin $plugin_old Main plugin.
	 */
	public function __construct( \Flexible_Product_Fields_Plugin $plugin_old ) {
		$this->plugin_old = $plugin_old;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'init', [ $this, 'set_hook_for_integration' ], 0 );
	}

	/**
	 * Initializes integration for 3rd party plugins.
	 *
	 * @internal
	 */
	public function set_hook_for_integration() {
		do_action(
			'flexible_product_fields/init',
			( new Integrator() )
		);
	}
}
