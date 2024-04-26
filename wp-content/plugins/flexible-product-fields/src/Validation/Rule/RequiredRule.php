<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Required" validation rule for fields.
 */
class RequiredRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_required'] ?? false ) || ! ( $field_data['required'] ?? false ) ) {
			return true;
		}

		return ( ( $value !== null ) && ! in_array( $value, [ '', [ '' ] ] ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %s: field label */
			__( '%s is required field.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
