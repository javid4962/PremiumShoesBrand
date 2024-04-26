<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Excluded dates" validation rule for fields.
 */
class DatesExcludedRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_dates_excluded'] ?? false ) ) {
			return true;
		}

		$dates_excluded = $field_data['dates_excluded'] ?? '';
		if ( ! $dates_excluded ) {
			return true;
		}

		$dates_excluded = explode( ',', $dates_excluded );
		$excluded_dates = [];
		foreach ( $dates_excluded as $date ) {
			$excluded_dates[] = gmdate( 'Y-m-d', strtotime( $date ) );
		}

		$dates = ( $value ) ? explode( ',', $value ) : [];
		foreach ( $dates as $date ) {
			if ( in_array( gmdate( 'Y-m-d', strtotime( $date ) ), $excluded_dates, true ) ) {
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
			__( '%s has an excluded date.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
