<?php

namespace WPDesk\FPF\Free\Settings\Form;

use WPDesk\FPF\Free\Settings\Option\OptionInterface;

/**
 * Interface for form settings.
 */
interface FormInterface {

	/**
	 * Returns type of form.
	 *
	 * @return string Type of form.
	 */
	public function get_form_type(): string;

	/**
	 * Returns basic settings for form.
	 *
	 * @param array    $form_data Default settings of form.
	 * @param \WP_Post $post      .
	 *
	 * @return array Settings of form.
	 */
	public function get_form_data( array $form_data, \WP_Post $post ): array;

	/**
	 * .
	 */
	public function get_posted_data(): array;

	/**
	 * Saves settings for form.
	 *
	 * @param \WP_Post $post .
	 */
	public function save_form_data( \WP_Post $post );

	/**
	 * Returns list of option objects.
	 *
	 * @return OptionInterface[] List of options.
	 */
	public function get_options_list(): array;
}
