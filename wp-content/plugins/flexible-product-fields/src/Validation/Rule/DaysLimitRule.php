<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Selected days limit" validation rule for fields.
 */
class DaysLimitRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_max_dates'] ?? false ) ) {
			return true;
		}

		$days_limit = $field_data['max_dates'] ?? 0;
		if ( ! $days_limit ) {
			return true;
		}

		$dates = ( $value ) ? explode( ',', $value ) : [];
		return ( count( $dates ) <= $days_limit );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %s: field label */
			__( '%s has too many dates.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
