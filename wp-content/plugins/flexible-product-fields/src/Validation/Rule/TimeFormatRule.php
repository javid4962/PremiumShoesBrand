<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Field\Type\TimeType;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\Hour12ClockOption;

/**
 * Supports "Time format" validation rule for fields.
 */
class TimeFormatRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ( $field_type[ FieldTypeOption::FIELD_NAME ] !== TimeType::FIELD_TYPE )
			|| ( $value === '' ) ) {
			return true;
		}

		$date_timestamp = strtotime( date( 'Y-m-d' ) . ' ' . $value );
		$valid_format   = ( $field_data[ Hour12ClockOption::FIELD_NAME ] ) ? 'h:i A' : 'H:i';

		return ( date( $valid_format, $date_timestamp ) === $value );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %s: field label */
			__( '%s has an invalid time format.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
