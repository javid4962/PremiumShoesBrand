<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Interface of validation rule for fields.
 */
interface RuleInterface {

	/**
	 * Checks if the field value is correct.
	 *
	 * @param array $field_data Field settings.
	 * @param array $field_type Config for field data.
	 * @param mixed $value      Value of field.
	 *
	 * @return bool Status of field value.
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool;

	/**
	 * Returns error message for validation rule.
	 *
	 * @param array $field_data Field settings.
	 *
	 * @return string Error message.
	 */
	public function get_error_message( array $field_data ): string;
}
