<?php

namespace WPDesk\FPF\Free\Validation\Rule;

use WPDesk\FPF\Free\Field\Type\EmailType;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;

/**
 * Supports "E-mail address" validation rule for fields.
 */
class EmailAddressRule implements RuleInterface {

	/**
	 * {@inheritdoc}
	 */
	public function validate_value( array $field_data, array $field_type, $value ): bool {
		if ( ( $field_type[ FieldTypeOption::FIELD_NAME ] !== EmailType::FIELD_TYPE )
			|| ( $value === '' ) ) {
			return true;
		}

		return filter_var( $value, FILTER_VALIDATE_EMAIL );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_error_message( array $field_data ): string {
		return sprintf(
		/* translators: %1$s: field label */
			__( 'The e-mail address provided is not valid for the %1$s field.', 'flexible-product-fields' ),
			'<strong>' . $field_data['title'] . '</strong>'
		);
	}
}
