<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Supports "Time of day closing" validation rule for fields.
 */
class TodayMaxHourRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ! ( $field_type['has_today_max_hour'] ?? false ) ) {
			return true;
		}

		$max_hour = $field_data['today_max_hour'] ?? '';
		if ( ! $max_hour || ( wp_date( 'H:i' ) <= gmdate( 'H:i', strtotime( $max_hour ) ) ) ) {
			return true;
		}

		$date_today = wp_date( 'Ymd' );
		$dates      = ( $value ) ? explode( ',', $value ) : [];
		foreach ( $dates as $date ) {
			if ( gmdate( 'Ymd', strtotime( $date ) ) === $date_today ) {
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
			__( '%s has a current date that is no longer available.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
