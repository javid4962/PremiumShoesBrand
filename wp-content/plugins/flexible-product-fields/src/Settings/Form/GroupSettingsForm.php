<?php

namespace WPDesk\FPF\Free\Settings\Form;

use WPDesk\FPF\Free\Settings\Option\GroupAdvOption;
use WPDesk\FPF\Free\Settings\Option\GroupAssignOption;
use WPDesk\FPF\Free\Settings\Option\GroupProductsOption;
use WPDesk\FPF\Free\Settings\Option\GroupSectionOption;

/**
 * {@inheritdoc}
 */
class GroupSettingsForm implements FormInterface {

	const FORM_TYPE       = 'settings';
	const FORM_FIELD_NAME = 'fpf_settings';

	/**
	 * {@inheritdoc}
	 */
	public function get_form_type(): string {
		return self::FORM_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_posted_data(): array {
		return json_decode( stripslashes( $_POST[ self::FORM_FIELD_NAME ] ), true ) ?: [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_form_data( array $form_data, \WP_Post $post ): array {
		$section_fields = [
			GroupSectionOption::FIELD_NAME  => get_post_meta( $post->ID, '_' . GroupSectionOption::FIELD_NAME, true ) ?: '',
			GroupAssignOption::FIELD_NAME   => get_post_meta( $post->ID, '_' . GroupAssignOption::FIELD_NAME, true ) ?: '',
			GroupProductsOption::FIELD_NAME => get_post_meta( $post->ID, '_' . GroupProductsOption::FIELD_NAME, false ) ?: [],
		];

		$option_objects = $this->get_options_list();
		foreach ( $option_objects as $field_option ) {
			$form_data = $field_option->update_field_data( $form_data, $section_fields );
		}

		return $form_data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_form_data( \WP_Post $post ) {
		$values           = $this->get_posted_data();
		$settings_options = $this->parse_posted_values( $values );

		update_post_meta( $post->ID, '_' . GroupSectionOption::FIELD_NAME, $settings_options[ GroupSectionOption::FIELD_NAME ] );
		update_post_meta( $post->ID, '_' . GroupAssignOption::FIELD_NAME, $settings_options[ GroupAssignOption::FIELD_NAME ] );

		delete_post_meta( $post->ID, '_' . GroupProductsOption::FIELD_NAME );
		foreach ( $settings_options[ GroupProductsOption::FIELD_NAME ] as $product_id ) {
			add_post_meta( $post->ID, '_' . GroupProductsOption::FIELD_NAME, $product_id );
		}
	}

	protected function parse_posted_values( array $values ): array {
		$new_values     = [];
		$option_objects = $this->get_options_list();
		foreach ( $option_objects as $field_option ) {
			$new_values = $field_option->save_field_data( $new_values, $values );
		}

		return $new_values;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_list(): array {
		return [
			new GroupSectionOption(),
			new GroupAssignOption(),
			new GroupProductsOption(),
			new GroupAdvOption(),
		];
	}
}
