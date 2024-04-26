<?php

namespace WPDesk\FPF\Free\Product;

use VendorFPF\WPDesk\PluginBuilder\Plugin\Hookable;
use VendorFPF\WPDesk\PluginBuilder\Plugin\HookablePluginDependant;
use VendorFPF\WPDesk\PluginBuilder\Plugin\PluginAccess;
use VendorFPF\WPDesk\View\Renderer\SimplePhpRenderer;
use VendorFPF\WPDesk\View\Resolver\DirResolver;

/**
 * Supports feature "Save product config" for Administrator.
 */
class FieldsConfig implements Hookable, HookablePluginDependant {

	use PluginAccess;

	/**
	 * Class object for template rendering.
	 *
	 * @var SimplePhpRenderer
	 */
	private $renderer;

	public function __construct() {
		$this->set_renderer();
	}

	/**
	 * Init class for template rendering.
	 */
	private function set_renderer() {
		$this->renderer = new SimplePhpRenderer( new DirResolver( dirname( dirname( __DIR__ ) ) . '/templates' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'woocommerce_before_add_to_cart_button', [ $this, 'show_save_config_button' ], 20 );
	}

	/**
	 * Displays button for generating URL with product config.
	 *
	 * @internal
	 */
	public function show_save_config_button() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		echo $this->renderer->render( 'config/button-save' ); // phpcs:ignore
	}
}
