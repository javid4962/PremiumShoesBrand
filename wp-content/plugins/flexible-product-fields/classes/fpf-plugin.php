<?php
/**
 * Plugin.
 *
 * @package Flexible Product Fields
 */

use WPDesk\FPF\Free\Plugin as PluginFree;
use VendorFPF\WPDesk\View\Renderer\Renderer;
use VendorFPF\WPDesk\View\Resolver\DirResolver;
use VendorFPF\WPDesk\View\Renderer\SimplePhpRenderer;
use WPDesk\FPF\Free\Marketing\SupportPage;

/**
 * Plugin.
 */
class Flexible_Product_Fields_Plugin extends VendorFPF\WPDesk\PluginBuilder\Plugin\AbstractPlugin implements VendorFPF\WPDesk\PluginBuilder\Plugin\HookableCollection {

	use VendorFPF\WPDesk\PluginBuilder\Plugin\HookableParent;
	use VendorFPF\WPDesk\PluginBuilder\Plugin\TemplateLoad;

	/**
	 * Scripts version string.
	 *
	 * @var string
	 */
	private $scripts_version = FLEXIBLE_PRODUCT_FIELDS_VERSION . '.69';

	/**
	 * FPF product fields.
	 *
	 * @var FPF_Product_Fields
	 */
	private $fpf_product_fields;

	/**
	 * FPF Product.
	 *
	 * @var FPF_Product
	 */
	private $fpf_product;

	/**
	 * FPF Product Price.
	 *
	 * @var FPF_Product_Price
	 */
	private $fpf_product_price;

	/**
	 * FPF Cart.
	 *
	 * @var FPF_Cart
	 */
	private $fpf_cart;

	/**
	 * FPF post type.
	 *
	 * @var FPF_Post_Type
	 */
	private $fpf_post_type;

	/**
	 * Instance of new version main class of plugin.
	 *
	 * @var PluginFree
	 */
	private $plugin_free;

	/**
	 * @var Renderer
	 */
	private $renderer;

	/**
	 * Flexible_Invoices_Reports_Plugin constructor.
	 *
	 * @param VendorFPF\WPDesk_Plugin_Info $plugin_info Plugin info.
	 */
	public function __construct( VendorFPF\WPDesk_Plugin_Info $plugin_info ) {
		$this->plugin_info = $plugin_info;
		parent::__construct( $this->plugin_info );
		$this->renderer = new SimplePhpRenderer( new DirResolver( dirname( __DIR__ ) . '/templates' ) );
		$this->plugin_free = new PluginFree( $plugin_info, $this, $this->renderer );
	}

	/**
	 * Init base variables for plugin
	 */
	public function init_base_variables() {
		$this->plugin_url       = $this->plugin_info->get_plugin_url();
		$this->plugin_path      = $this->plugin_info->get_plugin_dir();
		$this->template_path    = $this->plugin_info->get_text_domain();
		$this->plugin_namespace = $this->plugin_info->get_text_domain();
		$this->template_path    = $this->plugin_info->get_text_domain();
	}

	/**
	 * Enqueue front scripts.
	 */
	public function wp_enqueue_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'fpf_front', trailingslashit( $this->get_plugin_assets_url() ) . 'css/front' . $suffix . '.css', array(), $this->scripts_version );
		wp_enqueue_style( 'fpf_front' );

		if ( is_singular( 'product' ) ) {
			wp_enqueue_style( 'fpf_new_front', trailingslashit( $this->get_plugin_assets_url() ) . 'css/new-front.css', [], $this->scripts_version );
			wp_enqueue_script( 'fpf_new_front', trailingslashit( $this->get_plugin_assets_url() ) . 'js/new-front.js', [], $this->scripts_version, true );

			wp_register_script( 'accounting', WC()->plugin_url() . '/assets/js/accounting/accounting' . $suffix . '.js', array( 'jquery' ), $this->scripts_version );
			wp_enqueue_script( 'fpf_product', trailingslashit( $this->get_plugin_assets_url() ) . 'js/fpf_product' . $suffix . '.js', array(
				'jquery',
				'accounting',
			), $this->scripts_version );

			if ( ! function_exists( 'get_woocommerce_price_format' ) ) {
				$currency_pos = get_option( 'woocommerce_currency_pos' );
				switch ( $currency_pos ) {
					case 'left':
						$format = '%1$s%2$s';
						break;
					case 'right':
						$format = '%2$s%1$s';
						break;
					case 'left_space':
						$format = '%1$s&nbsp;%2$s';
						break;
					case 'right_space':
						$format = '%2$s&nbsp;%1$s';
						break;
				}

				$currency_format = esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), $format ) );
			} else {
				$currency_format = esc_attr( str_replace( array( '%1$s', '%2$s' ), array(
					'%s',
					'%v',
				), get_woocommerce_price_format() ) );
			}
			$product = wc_get_product( get_the_ID() );
			wp_localize_script( 'fpf_product', 'fpf_product',
				array(
					'total'                        => __( 'Total', 'flexible-product-fields' ),
					'currency_format_num_decimals' => absint( get_option( 'woocommerce_price_num_decimals' ) ),
					'currency_format_symbol'       => get_woocommerce_currency_symbol(),
					'currency_format_decimal_sep'  => esc_attr( stripslashes( get_option( 'woocommerce_price_decimal_sep' ) ) ),
					'currency_format_thousand_sep' => esc_attr( stripslashes( get_option( 'woocommerce_price_thousand_sep' ) ) ),
					'currency_format'              => $currency_format,
					'fields_rules'                 => $this->fpf_product->get_logic_rules_for_product( $product ),
				)
			);
		}
	}

	/**
	 * Load dependencies.
	 */
	private function load_dependencies() {
		require_once $this->plugin_path . '/inc/wpdesk-woo27-functions.php';

		new WPDesk_Flexible_Product_Fields_Tracker();
		$this->fpf_product_price  = new FPF_Product_Price();
		$this->fpf_product_fields = new FPF_Product_Fields( $this );
		$this->fpf_product        = new FPF_Product( $this, $this->fpf_product_fields, $this->fpf_product_price );
		$this->fpf_cart           = new FPF_Cart( $this, $this->fpf_product_fields, $this->fpf_product, $this->fpf_product_price );
		$this->fpf_post_type      = new FPF_Post_Type( $this, $this->fpf_product_fields, $this->renderer );
		$this->add_hookable( new FPF_Add_To_Cart_Filters( $this->fpf_product ) );

		new FPF_Order( $this );
	}

	/**
	 * Init.
	 */
	public function init() {
		$this->init_base_variables();
		$this->load_dependencies();
		$this->plugin_free->init();
		$this->hooks();
	}

	/**
	 * Hooks.
	 */
	public function hooks() {
		$this->plugin_free->hooks();
		parent::hooks();
		add_action( 'init', array( $this, 'init_polylang' ) );
		add_action( 'admin_init', array( $this, 'init_wpml' ) );
		$this->hooks_on_hookable_objects();
	}

	/**
	 * Init Polylang actions.
	 */
	public function init_polylang() {
		if ( function_exists( 'pll_register_string' ) ) {
			$this->fpf_product_fields->init_polylang();
		}
	}

	/**
	 * Init WPML actions.
	 */
	public function init_wpml() {
		if ( function_exists( 'icl_register_string' ) ) {
			$this->fpf_product_fields->init_wpml();
		}
	}

	/**
	 * Add links to plugin on plugins page.
	 *
	 * @param array $links Links array.
	 *
	 * @return array
	 */
	public function links_filter( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'edit.php?post_type=fpf_fields' ) . '">' . __( 'Settings', 'flexible-product-fields' ) . '</a>',
			'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-row-action-docs' ) ) . '" target="_blank">' . __( 'Docs', 'flexible-product-fields' ) . '</a>',
		);

		if ( ! wpdesk_is_plugin_active( 'flexible-product-fields-pro/flexible-product-fields-pro.php' ) ) {
			$plugin_links[] = '<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-row-action-upgrade' ) ) . '" target="_blank" style="color:#FF9743;font-weight:bold;">' . __( 'Upgrade to PRO &rarr;', 'flexible-product-fields' ) . '</a>';
			$start_here = '<a href="' . admin_url( 'admin.php?page=' . SupportPage::PAGE_SLUG ) . '" style="font-weight: bold;color: #007050">' . esc_html__( 'Start here', 'flexible-checkout-fields' ) . '</a>';
			array_unshift( $plugin_links, $start_here );
		}

		$plugin_links[] = $links['deactivate'];

		return $plugin_links;
	}


}


