<?php

namespace WPDesk\FPF\Free\Field\Type;

/**
 * Initializes integration of field types.
 */
class TypeIntegration {

	/**
	 * Class object for field type.
	 *
	 * @var TypeInterface
	 */
	private $type_object;

	/**
	 * Class constructor.
	 *
	 * @param TypeInterface $type_object Class object of field type.
	 */
	public function __construct( TypeInterface $type_object ) {
		$this->type_object = $type_object;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'flexible_product_fields_field_types', [ $this, 'add_field_type' ], 0 );
		add_filter( 'flexible_product_fields_field_types', [ $this, 'update_field_type_settings' ], 100 );
	}

	/**
	 * Adds new field type with settings of field type.
	 *
	 * @param array $types List of field types.
	 *
	 * @return array Updated list of field types.
	 *
	 * @internal
	 */
	public function add_field_type( array $types ): array {
		$type           = $this->type_object->get_field_type();
		$types[ $type ] = $this->get_field_type_settings();
		return $types;
	}

	/**
	 * Updates settings for field type to preserve backward compatibility for used filter.
	 *
	 * @param array $types List of field types.
	 *
	 * @return array Updated list of field types.
	 *
	 * @internal
	 */
	public function update_field_type_settings( array $types ): array {
		$type          = $this->type_object->get_field_type();
		$type_settings = $this->get_field_type_settings();
		if ( ! isset( $types[ $type ] ) ) {
			return $types;
		}

		foreach ( $type_settings as $option_key => $option_value ) {
			if ( isset( $types[ $type ][ $option_key ] ) ) {
				continue;
			}
			$types[ $type ][ $option_key ] = $option_value;
		}
		return $types;
	}

	/**
	 * Returns list of settings for field type.
	 *
	 * @return array Settings of field type.
	 */
	private function get_field_type_settings(): array {
		return [
			'type'          => $this->type_object->get_field_type(),
			'field_group'   => $this->type_object->get_field_group(),
			'template_file' => $this->type_object->get_template_file(),
			'label'         => $this->type_object->get_field_type_label(),
			'icon'          => $this->type_object->get_field_type_icon(),
			'is_available'  => $this->type_object->is_available(),
			'options'       => array_values( $this->type_object->get_options() ),

			'value'                          => $this->type_object->get_field_type(),
			'has_required'                   => $this->type_object->has_required(),
			'has_max_length'                 => $this->type_object->has_max_length(),
			'has_placeholder'                => $this->type_object->has_placeholder(),
			'has_value'                      => $this->type_object->has_value(),
			'has_css_class'                  => $this->type_object->has_css_class(),
			'has_tooltip'                    => $this->type_object->has_tooltip(),
			'has_value_min'                  => $this->type_object->has_value_min(),
			'has_value_max'                  => $this->type_object->has_value_max(),
			'has_value_step'                 => $this->type_object->has_value_step(),
			'has_options'                    => $this->type_object->has_options(),
			'has_date_format'                => $this->type_object->has_date_format(),
			'has_days_before'                => $this->type_object->has_days_before(),
			'has_days_after'                 => $this->type_object->has_days_after(),
			'has_dates_excluded'             => $this->type_object->has_dates_excluded(),
			'has_days_excluded'              => $this->type_object->has_days_excluded(),
			'has_week_start'                 => $this->type_object->has_week_start(),
			'has_max_dates'                  => $this->type_object->has_max_dates(),
			'has_today_max_hour'             => $this->type_object->has_today_max_hour(),
			'has_price'                      => $this->type_object->has_price(),
			'price_not_available'            => $this->type_object->has_price_info(),
			'has_price_in_options'           => $this->type_object->has_price_in_options(),
			'price_not_available_in_options' => $this->type_object->has_price_info_in_options(),
			'has_logic'                      => $this->type_object->has_logic(),
			'logic_not_available'            => $this->type_object->has_logic_info(),
			'type_object'                    => $this->type_object,
		];
	}
}
