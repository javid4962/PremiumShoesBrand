<?php

namespace WPDesk\FPF\Free\Settings\Validation\Error;

/**
 * {@inheritdoc}
 */
class FieldRequiredError implements ValidationError {

	/**
	 * {@inheritdoc}
	 */
	public function get_message(): string {
		return __( 'This field is required.', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_fatal_error(): bool {
		return true;
	}
}
