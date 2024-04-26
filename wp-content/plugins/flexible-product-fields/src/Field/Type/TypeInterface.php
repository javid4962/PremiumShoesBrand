<?php

namespace WPDesk\FPF\Free\Field\Type;

use WPDesk\FPF\Free\Settings\Option\OptionInterface;

/**
 * Interface of field type.
 */
interface TypeInterface {

	/**
	 * Returns value of field type.
	 *
	 * @return string
	 */
	public function get_field_type(): string;

	/**
	 * Returns filename of field template.
	 *
	 * @return string
	 */
	public function get_template_file(): string;

	/**
	 * Returns value of field type used in HTML.
	 *
	 * @return string
	 */
	public function get_raw_field_type(): string;

	/**
	 * Returns updated args of field.
	 *
	 * @param array $args Original field args.
	 *
	 * @return array
	 */
	public function get_field_args( array $args ): array;

	/**
	 * Returns values used as variables in field template.
	 *
	 * @param array $field_data Field settings.
	 *
	 * @return array
	 */
	public function get_field_template_vars( array $field_data ): array;

	/**
	 * Returns value of field.
	 *
	 * @param string $field_id   Field ID.
	 * @param bool   $is_request Whether to use POST or REQUEST values.
	 *
	 * @return mixed
	 */
	public function get_field_value( string $field_id, bool $is_request );

	/**
	 * Returns label of field type.
	 *
	 * @return string
	 */
	public function get_field_type_label(): string;

	/**
	 * Returns key of field group.
	 *
	 * @return string
	 */
	public function get_field_group(): string;

	/**
	 * Returns field icon as CSS Class supported by Icomoon.
	 *
	 * @return string
	 */
	public function get_field_type_icon(): string;

	/**
	 * Returns whether field type is available for plugin version.
	 *
	 * @return bool
	 */
	public function is_available(): bool;

	/**
	 * Returns list of options for field settings.
	 *
	 * @return OptionInterface[]
	 */
	public function get_options(): array;

	/**
	 * Returns list of options objects for field settings.
	 *
	 * @return OptionInterface[][]
	 */
	public function get_options_objects(): array;

	/**
	 * Returns whether option "Character Limit" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_required(): bool;

	/**
	 * Returns whether option "Character Limit" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_max_length(): bool;

	/**
	 * Returns whether option "Placeholder" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_placeholder(): bool;

	/**
	 * Returns whether option "Value" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_value(): bool;

	/**
	 * Returns whether option "CSS Class" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_css_class(): bool;

	/**
	 * Returns whether option "Tooltip" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_tooltip(): bool;

	/**
	 * Returns whether option "Min value" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_value_min(): bool;

	/**
	 * Returns whether option "Max value" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_value_max(): bool;

	/**
	 * Returns whether option "Step value" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_value_step(): bool;

	/**
	 * Returns whether option "Options" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_options(): bool;

	/**
	 * Returns whether option "Date format" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_date_format(): bool;

	/**
	 * Returns whether option "Days before" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_days_before(): bool;

	/**
	 * Returns whether option "Days after" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_days_after(): bool;

	/**
	 * Returns whether option "Excluded dates" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_dates_excluded(): bool;

	/**
	 * Returns whether option "Excluded days of week" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_days_excluded(): bool;

	/**
	 * Returns whether option "First day of week" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_week_start(): bool;

	/**
	 * Returns whether option "Max number of dates" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_max_dates(): bool;

	/**
	 * Returns whether option "Time of day closing" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_today_max_hour(): bool;

	/**
	 * Returns whether option "Price" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_price(): bool;

	/**
	 * Returns whether information about option "Price" is visible in field settings.
	 *
	 * @return bool
	 */
	public function has_price_info(): bool;

	/**
	 * Returns whether option "Price" for options is available for field settings.
	 *
	 * @return bool
	 */
	public function has_price_in_options(): bool;

	/**
	 * Returns whether information about option "Price" for options is visible in field settings.
	 *
	 * @return bool
	 */
	public function has_price_info_in_options(): bool;

	/**
	 * Returns whether option "Conditional logic" is available for field settings.
	 *
	 * @return bool
	 */
	public function has_logic(): bool;

	/**
	 * Returns whether information about option "Conditional logic" is visible in field settings.
	 *
	 * @return bool
	 */
	public function has_logic_info(): bool;
}
