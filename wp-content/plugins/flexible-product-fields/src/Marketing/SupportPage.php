<?php

namespace WPDesk\FPF\Free\Marketing;

use VendorFPF\WPDesk\View\Renderer\Renderer;
use VendorFPF\WPDesk\PluginBuilder\Plugin\Hookable;
use VendorFPF\WPDesk\Library\Marketing\Boxes\Assets;
use VendorFPF\WPDesk\Library\Marketing\Boxes\MarketingBoxes;

/**
 * Page with support and marketing content.
 */
class SupportPage implements Hookable {

	/**
	 * @var Renderer
	 */
	private $renderer;

	/**
	 * @var \Flexible_Product_Fields_Plugin
	 */
	private $plugin_old;

	/**
	 * Scripts version string.
	 *
	 * @var string
	 */
	private $scripts_version = FLEXIBLE_PRODUCT_FIELDS_VERSION . '.01';

	public const PAGE_SLUG = 'fpf_support';
	public const SCREEN_ID = 'fpf_fields_page_fpf_support';

	public function __construct( Renderer $renderer, \Flexible_Product_Fields_Plugin $plugin_old ) {
		$this->renderer   = $renderer;
		$this->plugin_old = $plugin_old;
	}

	public function hooks(): void {
		add_action( 'admin_menu', [ $this, 'add_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_page_assets' ] );
	}

	/**
	 * @return void
	 */
	public function add_page(): void {
		add_submenu_page(
			'edit.php?post_type=fpf_fields',
			__( 'Start Here', 'flexible-product-fields' ),
			__( 'Start Here', 'flexible-product-fields' ),
			'manage_options',
			self::PAGE_SLUG,
			[ $this, 'render_page' ]
		);
	}

	/**
	 * @return void
	 */
	public function render_page(): void {
		$local = \get_locale();
		if ( $local === 'en_US' ) {
			$local = 'en';
		}
		$plugin_slug = is_flexible_products_fields_pro_active() ? 'flexible-product-fields-pro' : 'flexible-product-fields';

		$this->renderer->output_render( // phpcs:ignore
			'marketing-page',
			[
				'boxes' => new MarketingBoxes( $plugin_slug, $local ), // phpcs:ignore
			]
		);
	}

	/**
	 * Adds non native (created with JS) metaboxes.
	 *
	 * @return void
	 */
	public function load_page_assets(): void {
		if ( ! $this->is_fpf_listing_page() && ! $this->is_support_page() ) {
			return;
		}

		if ( $this->is_support_page() ) {
			Assets::enqueue_assets();
			Assets::enqueue_owl_assets();
		}

		\wp_enqueue_script(
			'non-cpt-boxes',
			\trailingslashit( $this->plugin_old->get_plugin_assets_url() ) . 'js/non-cpt-boxes.js',
			[ 'jquery' ],
			$this->scripts_version,
			true
		);

		\wp_localize_script(
			'non-cpt-boxes',
			'nonCptBoxes',
			[
				'upgrade_now_content' => $this->renderer->render(
					'metabox/upgrade-now',
					[
						'is_native_box' => false,
					]
				),
				'start_here_content'  => $this->renderer->render(
					'metabox/start-here',
					[
						'is_native_box' => false,
					]
				),
				'is_pro_active'       => is_flexible_products_fields_pro_active(),
			]
		);
	}

	/**
	 * Is it support page.
	 *
	 * @return boolean
	 */
	private function is_support_page(): bool {
		if ( ! isset( $_GET['page'] ) || $_GET['page'] !== self::PAGE_SLUG ) {
			return false;
		}

		return true;
	}

	/**
	 * Is it FPF custom post type listing page.
	 *
	 * @return boolean
	 */
	private function is_fpf_listing_page(): bool {
		global $post_type;
		if ( 'fpf_fields' !== $post_type ) {
			return false;
		}

		return true;
	}
}
