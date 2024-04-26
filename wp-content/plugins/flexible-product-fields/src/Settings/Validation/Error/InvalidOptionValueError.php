<?php

namespace WPDesk\FPF\Free\Settings\Validation\Error;

/**
 * {@inheritdoc}
 */
class InvalidOptionValueError implements ValidationError {

	/**
	 * {@inheritdoc}
	 */
	public function get_message(): string {
		return __( 'Allowed characters: letters, numbers and underscore.', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_fatal_error(): bool {
		return true;
	}
}
