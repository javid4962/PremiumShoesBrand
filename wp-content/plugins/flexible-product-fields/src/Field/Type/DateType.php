<?php

namespace WPDesk\FPF\Free\Field\Type;

use WPDesk\FPF\Free\Field\Types;

/**
 * Supports "Date" field type.
 */
class DateType extends TypeAbstract {

	const FIELD_TYPE = 'fpfdate';

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type(): string {
		return self::FIELD_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_template_file(): string {
		return 'date';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_label(): string {
		return __( 'Date', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_group(): string {
		return Types::FIELD_GROUP_PICKER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_icon(): string {
		return 'icon-calendar-alt';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [];
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_required(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_placeholder(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_css_class(): bool {
		return true;
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
	public function has_date_format(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_days_before(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_days_after(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_dates_excluded(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_days_excluded(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_week_start(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_max_dates(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_today_max_hour(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_price_info(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_logic_info(): bool {
		return true;
	}
}
