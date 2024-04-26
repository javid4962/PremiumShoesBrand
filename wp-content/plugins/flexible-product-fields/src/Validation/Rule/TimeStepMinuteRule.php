<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Settings\Option\MinuteStepOption;

/**
 * Supports "Time step minute" validation rule for fields.
 */
class TimeStepMinuteRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		$minute_step = $field_data[ MinuteStepOption::FIELD_NAME ] ?? null;
		if ( ! $minute_step || ( $minute_step <= 1 ) || ( $value === '' ) ) {
			return true;
		}

		preg_match( '/^(?:[0-9]{2}):([0-9]{2})/', $value, $matches );
		if ( ! $matches ) {
			return true;
		}

		return ( $matches[1] % $field_data[ MinuteStepOption::FIELD_NAME ] === 0 );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %1$s: field label, %2$s: minute step value */
			__( '%1$s is not within the time interval of %2$s minutes.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>',
			$field_data[ MinuteStepOption::FIELD_NAME ]
		);
	}
}
