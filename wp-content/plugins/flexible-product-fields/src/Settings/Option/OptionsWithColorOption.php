<?php

namespace WPDesk\FPF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class OptionsWithColorOption extends OptionsOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return [
			[
				OptionsValueOption::FIELD_NAME => '',
				OptionsLabelOption::FIELD_NAME => '',
				OptionsColorOption::FIELD_NAME => '',
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_children(): array {
		return [
			OptionsValueOption::FIELD_NAME => new OptionsValueOption(),
			OptionsLabelOption::FIELD_NAME => new OptionsLabelOption(),
			OptionsColorOption::FIELD_NAME => new OptionsColorOption(),
		];
	}
}
