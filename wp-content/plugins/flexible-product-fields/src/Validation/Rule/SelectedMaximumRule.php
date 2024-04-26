<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Settings\Option\SelectedMaxOption;

/**
 * Supports "Maximum of selected values" validation rule for fields.
 */
class SelectedMaximumRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		$values_max = $field_data[ SelectedMaxOption::FIELD_NAME ] ?? null;
		if ( ! $values_max || ! $value ) {
			return true;
		}

		return ( count( $value ) <= $values_max );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %1$s: field label, %2$s: minimum of values */
			__( 'The number of selected options for the %1$s is field greater than allowed %2$s.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>',
			$field_data[ SelectedMaxOption::FIELD_NAME ]
		);
	}
}
