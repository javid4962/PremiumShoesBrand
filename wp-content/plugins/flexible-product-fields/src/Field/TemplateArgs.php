<?php

namespace WPDesk\FPF\Free\Field;

use WPDesk\FPF\Free\Field\Type\MultiCheckboxType;
use WPDesk\FPF\Free\Field\Type\RadioColorsType;
use WPDesk\FPF\Free\Field\Type\RadioImagesType;
use WPDesk\FPF\Free\Field\Type\RadioType;
use WPDesk\FPF\Free\Field\Type\TypeInterface;
use WPDesk\FPF\Free\Settings\Option\DefaultOption;
use WPDesk\FPF\Free\Settings\Option\Hour12ClockOption;
use WPDesk\FPF\Free\Settings\Option\MinuteStepOption;

/**
 * Generates args of fields for fields generation.
 */
class TemplateArgs {

	/**
	 * Characters for date format used in plugin settings.
	 *
	 * @var string[]
	 */
	private static $date_format_settings = [ 'dd', 'd', 'mm', 'm', 'yy', 'y' ];

	/**
	 * Characters for date format used in JS.
	 *
	 * @var string[]
	 */
	private static $date_format_js = [ 'dd', 'd', 'mm', 'm', 'yyyy', 'yy' ];

	/**
	 * Characters for date format used in PHP.
	 *
	 * @var string[]
	 */
	private static $date_format_php = [ 'd', 'j', 'm', 'n', 'Y', 'y' ];

	/**
	 * Returns args for field based on field settings.
	 *
	 * @param array         $settings      Field settings.
	 * @param TypeInterface $type_object   .
	 * @param array         $field         Field settings.
	 * @param object        $product_price Class to handle pricing.
	 * @param \WC_Product   $product       Product Class.
	 *
	 * @return array Field args.
	 */
	public function parse_field_args( array $settings, TypeInterface $type_object, array $field, $product_price, \WC_Product $product ): array {
		$args = [
			'type'              => $type_object->get_raw_field_type(),
			'label'             => $field['title'],
			'placeholder'       => '',
			'input_class'       => [
				'fpf-input-field',
			],
			'custom_attributes' => [],
			'fpf_atts'          => [],
			'default'           => $field[ DefaultOption::FIELD_NAME ] ?? '',
		];

		if ( $settings['has_tooltip'] && ( $tooltip = ( $field['tooltip'] ?? '' ) ) ) {
			$args['label'] = sprintf(
				'<span class="fpf-field-tooltip" title="%1$s">%2$s <span class="fpf-field-tooltip-icon"></span></span>',
				esc_attr( $tooltip ),
				$args['label']
			);
		}
		if ( $settings['has_required'] && isset( $field['required'] ) && ( $field['required'] == '1' ) ) {
			$args['label'] .= sprintf(
				' <abbr class="required" title="%s">*</abbr>',
				__( 'Required field', 'flexible-product-fields' )
			);
		}

		if ( $settings['has_max_length'] && ( $max_length = ( $field['max_length'] ?? '' ) ) ) {
			$args['custom_attributes']['maxlength'] = $max_length;
		}
		if ( $settings['has_placeholder'] && ( ( $placeholder = ( $field['placeholder'] ?? '' ) ) || ( $placeholder !== '' ) ) ) {
			$args['placeholder'] = $placeholder;
		}
		if ( $settings['has_value_min'] && ( ( $value_min = ( $field['value_min'] ?? '' ) ) || ( $value_min !== '' ) ) ) {
			$args['custom_attributes']['min'] = $value_min;
		}
		if ( $settings['has_value_max'] && ( ( $value_max = ( $field['value_max'] ?? '' ) ) || ( $value_max !== '' ) ) ) {
			$args['custom_attributes']['max'] = $value_max;
		}
		if ( $settings['has_value_step'] && ( $value_step = ( $field['value_step'] ?? '' ) ) ) {
			$args['custom_attributes']['step'] = $value_step;
		}
		if ( $settings['has_options'] && ( $options = ( $field['options'] ?? [] ) ) && is_array( $options ) ) {
			$args['options'] = [];
			if ( $settings['has_placeholder'] && ( ( $placeholder = ( $field['placeholder'] ?? '' ) ) || ( $placeholder !== '' ) ) ) {
				$args['placeholder'] = '';
				$args['options'][''] = $placeholder;
			}

			foreach ( $options as $option ) {
				$args['options'][ $option['value'] ] = $option['label'];
			}
		}

		$date_format     = $field['date_format'] ?? 'dd.mm.yy';
		$date_format_php = $this->convert_date_format_for_php( $date_format );
		if ( $settings['has_date_format'] ) {
			$args['custom_attributes']['date_format']      = $date_format;
			$args['custom_attributes']['data-date-format'] = $this->convert_date_format_for_js( $date_format );
		}
		if ( $settings['has_days_before'] ) {
			$days_before = $field['days_before'] ?? '';

			$args['custom_attributes']['days_before']   = ( $days_before == '0' ) ? '00' : $days_before;
			$args['custom_attributes']['data-date-min'] = apply_filters(
				'flexible_product_fields/field_args/date_min',
				( $days_before !== '' )
					? gmdate(
					$date_format_php,
					strtotime( sprintf( '%s -%s day', wp_date( 'Y-m-d H:i:s' ), $days_before ) )
				)
					: null,
				$field,
				$date_format_php
			);
		}
		if ( $settings['has_days_after'] ) {
			$days_after = $field['days_after'] ?? '';

			$args['custom_attributes']['days_after']    = ( $days_after == '0' ) ? '00' : $days_after;
			$args['custom_attributes']['data-date-max'] = apply_filters(
				'flexible_product_fields/field_args/date_max',
				( $days_after !== '' )
					? gmdate(
					$date_format_php,
					strtotime( sprintf( '%s +%s day', wp_date( 'Y-m-d H:i:s' ), $days_after ) )
				)
					: null,
				$field,
				$date_format_php
			);
		}
		if ( $settings['has_dates_excluded'] ) {
			$dates = array_filter( explode( ',', $field['dates_excluded'] ?? '' ) );
			foreach ( $dates as $date_index => $date ) {
				$dates[ $date_index ] = gmdate( $date_format_php, strtotime( $date ) );
			}
			if ( $settings['has_today_max_hour'] && ( $max_hour = ( $field['today_max_hour'] ?? '' ) )
				&& ( wp_date( 'H:i' ) > gmdate( 'H:i', strtotime( $max_hour ) ) ) ) {
				$dates[] = gmdate( $date_format_php, strtotime( wp_date( 'Y-m-d' ) ) );
			}

			$dates                                            = apply_filters( 'flexible_product_fields/field_args/dates_excluded', $dates, $field, $date_format_php );
			$args['custom_attributes']['data-dates-disabled'] = implode( ',', $dates );
		}
		if ( $settings['has_today_max_hour'] ) {
			$args['custom_attributes']['data-today-max-hour'] = $field['today_max_hour'] ?? '';
		}
		if ( $settings['has_days_excluded'] ) {
			$args['custom_attributes']['data-days-disabled'] = implode( ',', $field['days_excluded'] ?? [] );
		}
		if ( $settings['has_week_start'] ) {
			$args['custom_attributes']['data-week-start'] = $field['week_start'] ?? '';
		}
		if ( $settings['has_max_dates'] ) {
			$args['custom_attributes']['data-max-dates'] = $field['max_dates'] ?? '';
		}
		if ( $field[ MinuteStepOption::FIELD_NAME ] ?? false ) {
			$args['custom_attributes']['data-minute-step'] = $field[ MinuteStepOption::FIELD_NAME ];
		}
		if ( $field[ Hour12ClockOption::FIELD_NAME ] ?? false ) {
			$args['custom_attributes']['data-hour-12'] = 1;
		}

		if ( $settings['has_price'] && ( $price_value = ( $field['price'] ?? '' ) ) ) {
			$price_type    = $field['price_type'] ?? 'fixed';
			$price_raw     = $this->get_raw_price_for_label( $price_type, $price_value, $product_price, $product );
			$args['label'] .= sprintf(
				' <span id="%1$s_price">%2$s</span>',
				$field['id'],
				sprintf(
					apply_filters( 'flexible_product_fields/field_args/label_price', '(%s)', $price_raw, $field ),
					$this->get_price_for_label( $price_type, $price_value, $product_price, $product )
				)
			);
		}

		if ( $settings['has_price_in_options'] && ( $args['options'] ?? [] ) ) {
			$price_values = $field['price_values'] ?? [];

			foreach ( $args['options'] as $option_value => $option_label ) {
				$option_data = $this->get_option_data( $field['options'], $option_value );
				$price_type  = $price_values[ $option_value ]['price_type'] ?? ( $option_data['price_type'] ?? '' );
				$price_value = $price_values[ $option_value ]['price'] ?? ( $option_data['price'] ?? '' );
				if ( ! $option_data || ! $price_type || ! $price_value ) {
					continue;
				}

				$price_raw   = $this->get_raw_price_for_label( $price_type, $price_value, $product_price, $product );
				$price_label = $this->get_price_for_label( $price_type, $price_value, $product_price, $product );

				if ( in_array(
					$field['type'],
					[ RadioType::FIELD_TYPE, MultiCheckboxType::FIELD_TYPE, RadioImagesType::FIELD_TYPE, RadioColorsType::FIELD_TYPE ]
				) ) {
					$args['options'][ $option_value ] .= sprintf(
						' <span id="%1$s_%2$s_price">%3$s</span>',
						$field['id'],
						$option_value,
						sprintf(
							apply_filters( 'flexible_product_fields/field_args/label_price', '(%s)', $price_raw, $field ),
							$price_label
						)
					);
				} else {
					$args['options'][ $option_value ] .= sprintf(
						' %1$s',
						sprintf(
							apply_filters( 'flexible_product_fields/field_args/label_price', '(%s)', $price_raw, $field ),
							$price_label
						)
					);
				}
			}
		}

		return $type_object->get_field_args( $args );
	}

	/**
	 * Converts date format to JS date format.
	 *
	 * @param string $date_format Original date format.
	 *
	 * @return string Updated date format.
	 */
	public static function convert_date_format_for_js( string $date_format ): string {
		return self::convert_date_format( $date_format, self::$date_format_settings, self::$date_format_js );
	}

	/**
	 * Converts date format to PHP date format.
	 *
	 * @param string $date_format Original date format.
	 *
	 * @return string Updated date format.
	 */
	public static function convert_date_format_for_php( string $date_format ): string {
		return self::convert_date_format( $date_format, self::$date_format_settings, self::$date_format_php );
	}

	/**
	 * Converts date format to different date format.
	 *
	 * @param string $date_format      Original date format.
	 * @param array  $old_format_parts Characters of new date format.
	 * @param array  $new_format_parts Characters of new date format.
	 *
	 * @return string Updated date format.
	 */
	private static function convert_date_format( string $date_format, array $old_format_parts, array $new_format_parts ): string {
		preg_match_all( '/([a-zA-Z]+)/', $date_format, $matches );
		if ( ! $format_parts = ( $matches[0] ?? [] ) ) {
			return $date_format;
		}

		foreach ( $format_parts as $format_part ) {
			$index = array_search( $format_part, $old_format_parts );
			if ( $index !== false ) {
				$date_format = str_replace(
					$old_format_parts[ $index ],
					$new_format_parts[ $index ],
					$date_format
				);
			}
		}
		return $date_format;
	}

	/**
	 * Returns selected option from options list.
	 *
	 * @param array  $options      Field settings.
	 * @param string $option_value Option value.
	 *
	 * @return array|null Data of option, if exists.
	 */
	private function get_option_data( array $options, string $option_value ) {
		foreach ( $options as $option ) {
			if ( $option['value'] == $option_value ) {
				return $option;
			}
		}
		return null;
	}

	/**
	 * Returns raw price value for field label.
	 *
	 * @param string      $price_type    Type of price (fixed, percent).
	 * @param mixed       $price_value   Value of price.
	 * @param object      $product_price Class to handle pricing.
	 * @param \WC_Product $product       Product Class.
	 *
	 * @return float Price value.
	 */
	private function get_raw_price_for_label( string $price_type, $price_value, $product_price, \WC_Product $product ): float {
		return $product_price->calculate_price( floatval( $price_value ), $price_type, $product );
	}

	/**
	 * Returns price value for field label.
	 *
	 * @param string      $price_type    Type of price (fixed, percent).
	 * @param mixed       $price_value   Value of price.
	 * @param object      $product_price Class to handle pricing.
	 * @param \WC_Product $product       Product Class.
	 *
	 * @return string Formatted price value.
	 */
	private function get_price_for_label( string $price_type, $price_value, $product_price, \WC_Product $product ): string {
		$price_raw     = $this->get_raw_price_for_label( $price_type, $price_value, $product_price, $product );
		$price_display = $product_price->prepare_price_to_display( $product, $price_raw );
		return $product_price->wc_price( $price_display );
	}
}
