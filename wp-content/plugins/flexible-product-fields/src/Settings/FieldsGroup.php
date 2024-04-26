<?php

namespace WPDesk\FPF\Free\Settings;

use VendorFPF\WPDesk\PluginBuilder\Plugin\Hookable;
use VendorFPF\WPDesk\PluginBuilder\Plugin\HookablePluginDependant;
use VendorFPF\WPDesk\PluginBuilder\Plugin\PluginAccess;

/**
 * Supports list of setting options for field groups.
 */
class FieldsGroup implements Hookable, HookablePluginDependant {

	use PluginAccess;

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'flexible_product_fields_assign_to_options', [ $this, 'load_assign_to_options' ], 20 );
	}

	/**
	 * Returns list of available values for option "Assign this group to".
	 *
	 * @param array $options Default list of options.
	 *
	 * @return array Updated list of options.
	 */
	public function load_assign_to_options( array $options ): array {
		return [
			[
				'value'        => 'product',
				'label'        => __( 'Product', 'flexible-product-fields' ),
				'is_available' => true,
			],
			[
				'value'        => 'category',
				'label'        => __( 'Category', 'flexible-product-fields' ),
				'is_available' => $this->is_active_option( $options, 'category' ),
			],
			[
				'value'        => 'tag',
				'label'        => __( 'Tag', 'flexible-product-fields' ),
				'is_available' => $this->is_active_option( $options, 'tag' ),
			],
			[
				'value'        => 'all',
				'label'        => __( 'All products', 'flexible-product-fields' ),
				'is_available' => $this->is_active_option( $options, 'all' ),
			],
		];
	}

	/**
	 * Returns status of option.
	 *
	 * @param array  $options      Default list of options.
	 * @param string $option_value Default list of options.
	 *
	 * @return bool Status of option.
	 */
	private function is_active_option( array $options, string $option_value ): bool {
		foreach ( $options as $option ) {
			if ( $option['value'] === $option_value ) {
				return ( $option['is_available'] );
			}
		}
		return false;
	}
}
