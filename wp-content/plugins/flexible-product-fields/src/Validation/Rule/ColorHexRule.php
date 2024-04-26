<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Field\Type\ColorType;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;

/**
 * Supports "Color HEX" validation rule for fields.
 */
class ColorHexRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( $field_type[ FieldTypeOption::FIELD_NAME ] !== ColorType::FIELD_TYPE ) {
			return true;
		}

		return ( ( $value === '' ) || preg_match( '/^#[a-zA-Z0-9]{6}$/', $value ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %1$s: field label */
			__( 'The value provided is not valid for the %1$s field.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
