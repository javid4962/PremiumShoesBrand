<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Settings\Option\SelectedMinOption;

/**
 * Supports "Minimum of selected values" validation rule for fields.
 */
class SelectedMinimumRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		$values_min = $field_data[ SelectedMinOption::FIELD_NAME ] ?? null;
		if ( ! $values_min || ! $value ) {
			return true;
		}

		return ( count( $value ) >= $values_min );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %1$s: field label, %2$s: minimum of values */
			__( 'The number of selected options for the %1$s is field less than required %2$s.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>',
			$field_data[ SelectedMinOption::FIELD_NAME ]
		);
	}
}
