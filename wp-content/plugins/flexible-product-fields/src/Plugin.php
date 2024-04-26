<?php

namespace WPDesk\FPF\Free;

use VendorFPF\WPDesk\PluginBuilder\Plugin\AbstractPlugin;
use VendorFPF\WPDesk\PluginBuilder\Plugin\HookableCollection;
use VendorFPF\WPDesk\PluginBuilder\Plugin\HookableParent;
use VendorFPF\WPDesk\View\Renderer\Renderer;
use VendorFPF\WPDesk_Plugin_Info;
use WPDesk\FPF\Free\Admin;
use WPDesk\FPF\Free\Field;
use WPDesk\FPF\Free\Helpers;
use WPDesk\FPF\Free\Integration;
use WPDesk\FPF\Free\Product;
use WPDesk\FPF\Free\Settings;
use WPDesk\FPF\Free\Tracker;
use WPDesk\FPF\Free\Validation;

/**
 * Main plugin class. The most important flow decisions are made here.
 */
class Plugin extends AbstractPlugin implements HookableCollection {

	use HookableParent;

	/**
	 * Scripts version.
	 *
	 * @var string
	 */
	private $script_version = '1';

	/**
	 * Instance of old version main class of plugin.
	 *
	 * @var \Flexible_Product_Fields_Plugin
	 */
	private $plugin_old;

	/**
	 * Renderer.
	 *
	 * @var Renderer
	 */
	private $renderer;

	/**
	 * Plugin constructor.
	 *
	 * @param WPDesk_Plugin_Info              $plugin_info Plugin info.
	 * @param \Flexible_Product_Fields_Plugin $plugin_old  Main plugin.
	 */
	public function __construct( WPDesk_Plugin_Info $plugin_info, \Flexible_Product_Fields_Plugin $plugin_old, Renderer $renderer ) {
		parent::__construct( $plugin_info );

		$this->plugin_url       = $this->plugin_info->get_plugin_url();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();
		$this->script_version   = $plugin_info->get_version();
		$this->plugin_old       = $plugin_old;
		$this->renderer         = $renderer;
	}

	/**
	 * Initializes plugin external state.
	 *
	 * The plugin internal state is initialized in the constructor and the plugin should be internally consistent after
	 * creation. The external state includes hooks execution, communication with other plugins, integration with WC
	 * etc.
	 *
	 * @return void
	 */
	public function init() {
		( new \VendorFPF\WPDesk\Dashboard\DashboardWidget() )->hooks();

		$this->add_hookable( new Service\ShortLinksGenerator() );

		$this->add_hookable( new Notice\NoticeIntegration( new Notice\ReviewNotice( $this ) ) );
		$this->add_hookable( new Notice\NoticeIntegration( new Notice\FlexibleWishlistReview( $this ) ) );

		$this->add_hookable( new Product\FieldsConfig() );
		$this->add_hookable( new Settings\FieldsGroup() );
		$this->add_hookable( new Settings\Page( $this->renderer ) );
		$this->add_hookable( new Marketing\SupportPage( $this->renderer, $this->plugin_old ) );

		$this->add_hookable( new Integration\IntegratorIntegration( $this->plugin_old ) );
		$this->add_hookable( new Tracker\DeactivationTracker( $this->plugin_info ) );

		( new Settings\Forms() )->init();
		( new Settings\Routes() )->init();
		( new Settings\Tabs() )->init();
		( new Field\Types() )->init();
		( new Validation\Rules() )->init();
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		$this->hooks_on_hookable_objects();
	}

	/**
	 * Get script version.
	 *
	 * @return string .
	 */
	public function get_script_version() {
		return $this->script_version;
	}
}
