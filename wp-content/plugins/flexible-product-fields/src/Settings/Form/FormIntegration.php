<?php

namespace WPDesk\FPF\Free\Settings\Form;

use WPDesk\FPF\Free\Settings\Option\OptionIntegration;

/**
 * Initializes integration for form.
 */
class FormIntegration {

	/**
	 * Class object for field type.
	 *
	 * @var FormInterface
	 */
	private $form_object;

	/**
	 * Class constructor.
	 *
	 * @param FormInterface $form_object Class object of field type.
	 */
	public function __construct( FormInterface $form_object ) {
		$this->form_object = $form_object;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter(
			'flexible_product_fields/form_data_' . $this->form_object->get_form_type(),
			[ $this, 'get_form_data' ],
			10,
			2
		);
		add_filter(
			'flexible_product_fields/form_fields_' . $this->form_object->get_form_type(),
			[ $this, 'get_form_fields' ],
			10
		);
		add_action(
			'flexible_product_fields/save_form_data',
			[ $this->form_object, 'save_form_data' ],
			10
		);
	}

	/**
	 * Returns updated settings for form.
	 *
	 * @param array    $form_data Default settings of form.
	 * @param \WP_Post $post      .
	 *
	 * @return array Settings of form.
	 * @internal
	 */
	public function get_form_data( array $form_data, \WP_Post $post ): array {
		return $this->form_object->get_form_data( $form_data, $post );
	}

	/**
	 * Returns fields of settings for form.
	 *
	 * @return array Fields of form.
	 * @internal
	 */
	public function get_form_fields(): array {
		$options = [];
		foreach ( $this->form_object->get_options_list() as $option ) {
			$options[ $option->get_option_name() ] = ( new OptionIntegration( $option ) )->get_field_settings();
		}

		return array_values( $options );
	}

	/**
	 * Saves settings for form.
	 *
	 * @param \WP_Post $post .
	 *
	 * @return void
	 * @internal
	 */
	public function save_form_data( \WP_Post $post ) {
		$this->form_object->save_form_data( $post );
	}
}
