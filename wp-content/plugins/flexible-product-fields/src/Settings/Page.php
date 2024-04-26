<?php
// phpcs:ignoreFile


namespace WPDesk\FPF\Free\Settings;

use VendorFPF\WPDesk\PluginBuilder\Plugin\Hookable;
use VendorFPF\WPDesk\PluginBuilder\Plugin\HookablePluginDependant;
use VendorFPF\WPDesk\PluginBuilder\Plugin\PluginAccess;
use VendorFPF\WPDesk\View\Renderer\SimplePhpRenderer;
use WPDesk\FPF\Free\Field\Types;
use WPDesk\FPF\Free\Marketing\SupportPage;
use WPDesk\FPF\Free\Settings\Form\GroupFieldsForm;
use WPDesk\FPF\Free\Settings\Form\GroupSettingsForm;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\OptionsLabelOption;
use WPDesk\FPF\Free\Settings\Option\OptionsOption;
use WPDesk\FPF\Free\Settings\Option\OptionsValueOption;

/**
 * .
 */
class Page implements Hookable, HookablePluginDependant {

	use PluginAccess;

	const ADMIN_SCREEN_GROUPS     = 'fpf_fields';
	const ADMIN_SCREEN_GROUP_EDIT = 'edit-fpf_fields';
	const POST_TYPE               = 'fpf_fields';
	const FIELD_NONCE_NAME        = 'fpf_nonce';
	const NONCE_SUBMIT_VALUE      = 'fpf-save';

	/**
	 * @var SimplePhpRenderer
	 */
	private $renderer;

	public function __construct( SimplePhpRenderer $renderer ) {
		$this->renderer = $renderer;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_action( 'edit_form_advanced', [ $this, 'show_settings_template' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'load_assets_for_settings_page' ] );
		add_action( 'save_post_' . self::POST_TYPE, [ $this, 'save_settings' ], 10, 2 );
	}

	/**
	 * @param \WP_Post $post Post object.
	 *
	 * @return void
	 */
	public function show_settings_template( \WP_Post $post ) {
		if ( $post->post_type !== self::POST_TYPE ) {
			return;
		}

		echo $this->renderer->render( // phpcs:ignore
			'views/admin-page',
			[
				'field_name_nonce'    => self::FIELD_NONCE_NAME,
				'field_name_fields'   => GroupFieldsForm::FORM_FIELD_NAME,
				'field_name_settings' => GroupSettingsForm::FORM_FIELD_NAME,
				'nonce_submit'        => wp_create_nonce( self::NONCE_SUBMIT_VALUE ),
				'settings'            => [
					'rest_api_url'  => get_rest_url( null, 'flexible-product-fields/v1' ),
					'header_nonce'  => wp_create_nonce( 'wp_rest' ),
					'i18n'          => $this->load_translations(),
					'form_fields'   => [
						'form_index'     => $post->ID,
						'option_fields'  => apply_filters( 'flexible_product_fields_field_types', [] ),
						'option_values'  => array_values( apply_filters( 'flexible_product_fields/form_data_fields', [], $post ) ),
						'settings_tabs'  => apply_filters( 'flexible_product_fields/field_settings_tabs', [] ),
						'field_group'    => [
							[
								'name'  => Types::FIELD_GROUP_TEXT,
								'label' => __( 'Text Fields', 'flexible-product-fields' ),
							],
							[
								'name'  => Types::FIELD_GROUP_OPTION,
								'label' => __( 'Option Fields', 'flexible-product-fields' ),
							],
							[
								'name'  => Types::FIELD_GROUP_PICKER,
								'label' => __( 'Picker Fields', 'flexible-product-fields' ),
							],
							[
								'name'  => Types::FIELD_GROUP_OTHER,
								'label' => __( 'Other Fields', 'flexible-product-fields' ),
							],
						],
						'logic_settings' => apply_filters(
							'flexible_product_fields/admin_logic_settings',
							[
								'endpoints'        => [
									'field'     => null,
									'condition' => null,
									'value'     => null,
								],
								'option_names'     => [
									'field_name'      => FieldNameOption::FIELD_NAME,
									'field_label'     => FieldLabelOption::FIELD_NAME,
									'field_type'      => FieldTypeOption::FIELD_NAME,
									'field_options'   => OptionsOption::FIELD_NAME,
									'option_value'    => OptionsValueOption::FIELD_NAME,
									'option_label'    => OptionsLabelOption::FIELD_NAME,
									'logic_field'     => null,
									'logic_condition' => null,
									'logic_value'     => null,
								],
								'field_conditions' => [],
							]
						),
					],
					'form_settings' => [
						'form_index'    => null,
						'option_fields' => apply_filters( 'flexible_product_fields/form_fields_settings', [] ),
						'option_values' => apply_filters( 'flexible_product_fields/form_data_settings', [], $post ),
						'settings_tabs' => [],
					],
				],
			]
		);
	}

	/**
	 * Returns list of translations used by JS code.
	 *
	 * @return array Translations values.
	 */
	private function load_translations(): array {
		return [
			'form_fields'              => __( 'Fields', 'flexible-product-fields' ),
			'form_add_field'           => __( 'Add new field', 'flexible-product-fields' ),
			'form_settings'            => __( 'Settings', 'flexible-product-fields' ),
			'button_add_field'         => __( 'Add Field', 'flexible-product-fields' ),
			'button_add_row'           => __( 'Add New', 'flexible-product-fields' ),
			'button_save'              => __( 'Save Changes', 'flexible-product-fields' ),
			'button_reset'             => __( 'Reset Section Settings', 'flexible-product-fields' ),
			'button_read_more'         => __( 'Read more', 'flexible-product-fields' ),
			'button_yes'               => __( 'Yes', 'flexible-product-fields' ),
			'button_no'                => __( 'No', 'flexible-product-fields' ),
			'button_upload_image'      => __( 'Upload image', 'flexible-product-fields' ),
			'button_select_color'      => __( 'Select color', 'flexible-product-fields' ),
			'field_type'               => __( 'Field Type', 'flexible-product-fields' ),
			'field_label'              => __( 'Label', 'flexible-product-fields' ),
			'field_name'               => __( 'Name', 'flexible-product-fields' ),
			'validation_required'      => __( 'This field is required.', 'flexible-product-fields' ),
			'validation_max_length'    => __( 'This value is too long.', 'flexible-product-fields' ),
			'validation_slug'          => __( 'Field name should contains only lowercase letters, numbers and underscore sign.', 'flexible-product-fields' ),
			'select_placeholder'       => __( 'Select...', 'flexible-product-fields' ),
			'select_async_placeholder' => __( 'Start typing to search...', 'flexible-product-fields' ),
			'select_loading'           => __( 'Loading...', 'flexible-product-fields' ),
			'select_empty'             => __( 'No options.', 'flexible-product-fields' ),
			'alert_field_unavailable'  => sprintf(
			/* translators: %1$s: break line, %2$s: anchor opening tag, %3$s: anchor closing tag */
				__( 'This field is available in the PRO version.%1$s %2$sUpgrade to PRO%3$s', 'flexible-product-fields' ),
				'<br>',
				'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-field-type-upgrade' ) ) . '" target="_blank" class="fpfArrowLink">',
				'</a>'
			),
			'alert_remove_field'       => __( 'Are you sure you want to delete this field? Deleting a field will remove it from all orders.', 'flexible-product-fields' ),
			'alert_no_fields'          => sprintf(
			/* translators: %1$s: break-line tag, %2$s: anchor opening tag, %3$s: anchor closing tag */
				__( 'Add fields using the settings at the bottom. Then it will be possible to edit the fields. %1$sRead more in the %2$splugin documentation%3$s', 'flexible-product-fields' ),
				'<br>',
				'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-no-fields' ) ) . '" target="_blank" style="color: #27a349; font-weight: bold;">',
				' →</a>'
			),
			'settings_group_docs'       => sprintf(
				/* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
				__( 'Read more in the %1$splugin documentation%2$s', 'flexible-product-fields' ),
				'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-option-group-notice' ) ) . '" target="_blank" style="color: #27a349; font-weight: bold;">',
				' →</a>'
			),
			'alert_field_added'        => __( 'The field has been added!', 'flexible-product-fields' ),
		];
	}

	/**
	 * Initiates loading of assets needed to operate admin page.
	 *
	 * @internal
	 */
	public function load_assets_for_settings_page() {
		global $current_screen;
		if ( ! $current_screen
			|| ! in_array( $current_screen->id, [ self::ADMIN_SCREEN_GROUPS, self::ADMIN_SCREEN_GROUP_EDIT, SupportPage::SCREEN_ID ] ) ) {
			return;
		}

		$this->load_styles_for_page();
		$this->load_scripts_for_page();
	}

	/**
	 * Enqueues styles in WordPress Admin Dashboard.
	 */
	private function load_styles_for_page() {
		$is_debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );

		wp_register_style(
			'fpf-admin',
			trailingslashit( $this->plugin->get_plugin_assets_url() ) . 'css/new-admin.css',
			[],
			( $is_debug ) ? time() : $this->plugin->get_script_version()
		);
		wp_enqueue_style( 'fpf-admin' );
	}

	/**
	 * Enqueues scripts in WordPress Admin Dashboard.
	 */
	private function load_scripts_for_page() {
		$is_debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG );

		wp_register_script(
			'fpf-admin',
			trailingslashit( $this->plugin->get_plugin_assets_url() ) . 'js/new-admin.js',
			[],
			( $is_debug ) ? time() : $this->plugin->get_script_version(),
			true
		);
		wp_enqueue_media();
		wp_enqueue_script( 'fpf-admin' );
	}

	/**
	 * @internal
	 */
	public function save_settings( int $post_id, \WP_Post $post ) {
		if ( ! isset( $_POST[ self::FIELD_NONCE_NAME ] )
			|| ! wp_verify_nonce( $_POST[ self::FIELD_NONCE_NAME ], self::NONCE_SUBMIT_VALUE ) ) {
			return;
		}

		remove_action( 'save_post_' . self::POST_TYPE, [ $this, 'save_settings' ] );
		do_action( 'flexible_product_fields/save_form_data', $post );
	}
}
