<?php

namespace WPDesk\FPF\Free\Settings\Option;

use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;

/**
 * {@inheritdoc}
 */
class MinuteStepOption extends OptionAbstract {

	const FIELD_NAME = 'minute_step';

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
		return __( 'Step minute', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_input_atts(): array {
		return [
			'min'  => '1',
			'max'  => '60',
			'step' => '1',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return '1';
	}

	/**
	 * {@inheritdoc}
	 */
	public function sanitize_option_value( $field_value ) {
		return str_replace( ',', '.', $field_value );
	}
}
