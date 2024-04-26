<?php

namespace WPDesk\FPF\Free\Settings\Option;

use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;

/**
 * {@inheritdoc}
 */
class SelectedMaxOption extends OptionAbstract {

	const FIELD_NAME = 'selected_max';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_tab(): string {
		return AdvancedTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_NUMBER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Maximum number of selected values', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_input_atts(): array {
		return [
			'min'  => '1',
			'step' => '1',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function sanitize_option_value( $field_value ) {
		if ( $field_value === '' ) {
			return '';
		}
		return intval( $field_value );
	}
}
