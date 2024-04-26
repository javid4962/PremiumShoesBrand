<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Max length" validation rule for fields.
 */
class LengthRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_max_length'] ?? false ) || ! ( $field_data['max_length'] ?? false ) ) {
			return true;
		}

		return ( mb_strlen( $value ) <= intval( $field_data['max_length'] ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %1$s: field label, %2$s: limit of chars */
			__( 'Exceeded maximum number of characters for the %1$s field. (max: %2$s)', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>',
			$field_data['max_length']
		);
	}
}
