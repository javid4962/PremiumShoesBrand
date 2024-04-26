<?php

namespace WPDesk\FPF\Free\Settings\Validation\Error;

/**
 * Interface for validation error of settings field.
 */
interface ValidationError {

	/**
	 * @return string
	 */
	public function get_message(): string;

	/**
	 * @return bool
	 */
	public function is_fatal_error(): bool;
}
