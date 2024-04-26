<?php

namespace WPDesk\FPF\Free\Settings\Form;

use WPDesk\FPF\Free\Field\FieldData;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;

/**
 * {@inheritdoc}
 */
class GroupFieldsForm implements FormInterface {

	const FORM_TYPE          = 'fields';
	const FORM_FIELD_NAME    = 'fpf_fields';
	const SETTINGS_POST_META = '_fields';

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
		$section_fields = get_post_meta( $post->ID, self::SETTINGS_POST_META, true ) ?: [];
		if ( ! $section_fields ) {
			return $form_data;
		}

		foreach ( $section_fields as $field_name => $field_data ) {
			$new_field_data = FieldData::get_field_data( $field_data );
			if ( ! $new_field_data ) {
				continue;
			}
			$form_data[ $field_name ] = $new_field_data;
		}
		return $form_data;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_form_data( \WP_Post $post ) {
		$values        = $this->get_posted_data();
		$posted_fields = [];
		foreach ( $values as $field ) {
			$posted_fields[ $field[ FieldNameOption::FIELD_NAME ] ] = $field;
		}

		$section_fields = [];
		foreach ( $posted_fields as $field_data ) {
			$new_field_data = FieldData::get_field_data( $field_data, false );
			if ( ! $new_field_data ) {
				continue;
			}
			$section_fields[] = $new_field_data;
		}

		update_post_meta( $post->ID, self::SETTINGS_POST_META, $section_fields );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_list(): array {
		return [];
	}
}
