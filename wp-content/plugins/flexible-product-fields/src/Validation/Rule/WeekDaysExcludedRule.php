<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Excluded days of week" validation rule for fields.
 */
class WeekDaysExcludedRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_days_excluded'] ?? false ) ) {
			return true;
		}

		$days_excluded = $field_data['days_excluded'] ?? [];
		if ( ! $days_excluded ) {
			return true;
		}

		$dates = ( $value ) ? explode( ',', $value ) : [];
		foreach ( $dates as $date ) {
			if ( in_array( gmdate( 'w', strtotime( $date ) ), $days_excluded, false ) ) {
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
			__( '%s has a date with an excluded day of the week.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
