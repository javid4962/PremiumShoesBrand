<?php

namespace WPDesk\FPF\Free\Settings\Option;

use WPDesk\FPF\Free\Settings\Tab\GeneralTab;

/**
 * {@inheritdoc}
 */
class OptionsCheckboxOption extends OptionAbstract {

	const FIELD_NAME = 'options';

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
		return GeneralTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_REPEATER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_readonly(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Options', 'flexible-product-fields' );
	}

	/**
	 * Returns label of option row (for Repeater field).
	 *
	 * @return string Option row label.
	 */
	public function get_option_row_label(): string {
		/* translators: %s row index */
		return __( 'Option #%s', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return [
			[
				OptionsValueOption::FIELD_NAME   => '',
				OptionsLabelOption::FIELD_NAME   => '',
				DefaultCheckedOption::FIELD_NAME => '',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			OptionsValueOption::FIELD_NAME   => new OptionsValueOption(),
			OptionsLabelOption::FIELD_NAME   => new OptionsLabelOption(),
			DefaultCheckedOption::FIELD_NAME => new DefaultCheckedOption(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_refresh_trigger(): bool {
		return true;
	}
}
