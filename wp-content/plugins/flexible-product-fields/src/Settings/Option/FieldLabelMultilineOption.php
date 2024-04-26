<?php

namespace WPDesk\FPF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class FieldLabelMultilineOption extends FieldLabelOption {

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_TEXTAREA;
	}
}
