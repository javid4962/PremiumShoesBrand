<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Days before" validation rule for fields.
 */
class DaysBeforeRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_days_before'] ?? false ) ) {
			return true;
		}

		$days_before = $field_data['days_before'] ?? 0;
		if ( ! $days_before ) {
			return true;
		}

		$date_min = gmdate( 'Ymd', strtotime( sprintf( '%s -%s day', wp_date( 'Y-m-d H:i:s' ), $days_before ) ) );
		$dates    = ( $value ) ? explode( ',', $value ) : [];
		foreach ( $dates as $date ) {
			if ( gmdate( 'Ymd', strtotime( $date ) ) < $date_min ) {
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
			__( '%s has a date set too early.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
