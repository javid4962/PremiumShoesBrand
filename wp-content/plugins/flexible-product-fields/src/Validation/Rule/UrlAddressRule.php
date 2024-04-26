<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Field\Type\UrlType;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;

/**
 * Supports "URL address" validation rule for fields.
 */
class UrlAddressRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ( $field_type[ FieldTypeOption::FIELD_NAME ] !== UrlType::FIELD_TYPE )
			|| ( $value === '' ) ) {
			return true;
		}

		$url_path     = parse_url( $value, PHP_URL_PATH );
		$encoded_path = array_map( 'urlencode', explode( '/', $url_path ) );
		$encoded_url  = str_replace( $url_path, implode( '/', $encoded_path ), $value );

		return ( filter_var( $encoded_url, FILTER_VALIDATE_URL ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %1$s: field label */
			__( 'The URL address provided is not valid for the %1$s field.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
