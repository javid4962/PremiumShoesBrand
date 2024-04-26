<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Days after" validation rule for fields.
 */
class DaysAfterRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_days_after'] ?? false ) ) {
			return true;
		}

		$days_after = $field_data['days_after'] ?? 0;
		if ( ! $days_after ) {
			return true;
		}

		$date_max = gmdate( 'Ymd', strtotime( sprintf( '%s +%s day', wp_date( 'Y-m-d H:i:s' ), $days_after ) ) );
		$dates    = ( $value ) ? explode( ',', $value ) : [];
		foreach ( $dates as $date ) {
			if ( gmdate( 'Ymd', strtotime( $date ) ) > $date_max ) {
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
			__( '%s has a date set too late.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
