<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Option" validation rule for fields.
 */
class OptionRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_options'] ?? false ) ) {
			return true;
		}

		$options = $field_data['options'] ?? [];
		if ( ! $options || ! $value ) {
			return true;
		}

		$option_keys = array_column( $options, 'value' );
		foreach ( (array) $value as $value_key ) {
			if ( ! in_array( $value_key, $option_keys ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %s: field label */
			__( '%s has invalid value.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
