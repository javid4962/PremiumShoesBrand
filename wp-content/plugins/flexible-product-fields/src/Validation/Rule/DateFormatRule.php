<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Field\TemplateArgs;

/**
 * Supports "Date format" validation rule for fields.
 */
class DateFormatRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_date_format'] ?? false ) ) {
			return true;
		}

		$date_format = $field_data['date_format'] ?? '';
		if ( ! $date_format ) {
			return true;
		}

		$date_format = TemplateArgs::convert_date_format_for_php( $date_format );
		$dates       = ( $value ) ? explode( ',', $value ) : [];
		foreach ( $dates as $date ) {
			if ( gmdate( $date_format, strtotime( $date ) ) !== $date ) {
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
			__( '%s has an invalid date format.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
