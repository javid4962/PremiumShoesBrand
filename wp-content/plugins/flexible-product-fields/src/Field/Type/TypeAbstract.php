<?php

namespace WPDesk\FPF\Free\Field\Type;

use WPDesk\FPF\Free\Settings\Option\CssOption;
use WPDesk\FPF\Free\Settings\Option\OptionIntegration;

/**
 * Abstract class of field type.
 */
abstract class TypeAbstract implements TypeInterface {

	/**
	 * {@inheritdoc}
	 */
	public function get_raw_field_type(): string {
		return $this->get_field_type();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_template_file(): string {
		return $this->get_field_type();
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options(): array {
		$options = [];
		foreach ( $this->get_options_objects() as $option_objects ) {
			foreach ( $option_objects as $option_object ) {
				$options[] = ( new OptionIntegration( $option_object ) )->get_field_settings();
			}
		}
		return $options;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_args( array $args ): array {
		return $args;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_template_vars( array $field_data ): array {
		$class_value = ( $this->has_css_class() )
			? trim( $field_data[ CssOption::FIELD_NAME ] ?? '' )
			: '';
		if ( $this->has_required() && ( ( $field_data['required'] ?? '' ) == '1' ) ) {
			$class_value .= ' fpf-required';
		}

		return [
			'field_group_id' => $field_data['_group_id'],
			'key'            => $field_data['id'],
			'type'           => $this->get_field_type(),
			'class'          => trim( $class_value ),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_value( string $field_id, bool $is_request = false ) {
		$form_data = ( $is_request ) ? $_REQUEST : $_POST; // phpcs:ignore
		if ( ! isset( $form_data[ $field_id ] ) ) {
			return null;
		}

		$posted_value = wp_unslash( $form_data[ $field_id ] );
		return sanitize_text_field( $posted_value );
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_required(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_max_length(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_placeholder(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_value(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_css_class(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_tooltip(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_value_min(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_value_max(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_value_step(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_options(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_date_format(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_days_before(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_days_after(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_dates_excluded(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_days_excluded(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_week_start(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_max_dates(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_today_max_hour(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_price(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_price_info(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_price_in_options(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_price_info_in_options(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_logic(): bool {
		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_logic_info(): bool {
		return false;
	}
}
