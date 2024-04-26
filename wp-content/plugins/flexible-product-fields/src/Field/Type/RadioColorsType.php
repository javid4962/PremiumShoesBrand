<?php

namespace WPDesk\FPF\Free\Field\Type;

use WPDesk\FPF\Free\Field\Types;
use WPDesk\FPF\Free\Settings\Option\CssOption;
use WPDesk\FPF\Free\Settings\Option\DefaultOption;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldPriorityOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\LogicAdvOption;
use WPDesk\FPF\Free\Settings\Option\OptionsColorOption;
use WPDesk\FPF\Free\Settings\Option\OptionsOption;
use WPDesk\FPF\Free\Settings\Option\OptionsValueOption;
use WPDesk\FPF\Free\Settings\Option\OptionsWithColorOption;
use WPDesk\FPF\Free\Settings\Option\PreviewLabelOption;
use WPDesk\FPF\Free\Settings\Option\PreviewWidthOption;
use WPDesk\FPF\Free\Settings\Option\PricingAdvOption;
use WPDesk\FPF\Free\Settings\Option\RequiredOption;
use WPDesk\FPF\Free\Settings\Option\TooltipOption;
use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Free\Settings\Tab\GeneralTab;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;

/**
 * Supports "Radio with colors" field type.
 */
class RadioColorsType extends TypeAbstract {

	const FIELD_TYPE = 'radio-colors';

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type(): string {
		return self::FIELD_TYPE;
	}

	/**
	 * Returns value of field type used in HTML.
	 *
	 * @return string Field type.
	 */
	public function get_raw_field_type(): string {
		return RadioType::FIELD_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_label(): string {
		return __( 'Radio with colors', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_group(): string {
		return Types::FIELD_GROUP_OPTION;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_icon(): string {
		return 'icon-palette';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [
			GeneralTab::TAB_NAME  => [
				FieldPriorityOption::FIELD_NAME    => new FieldPriorityOption(),
				FieldTypeOption::FIELD_NAME        => new FieldTypeOption(),
				FieldLabelOption::FIELD_NAME       => new FieldLabelOption(),
				RequiredOption::FIELD_NAME         => new RequiredOption(),
				CssOption::FIELD_NAME              => new CssOption(),
				TooltipOption::FIELD_NAME          => new TooltipOption(),
				OptionsWithColorOption::FIELD_NAME => new OptionsWithColorOption(),
				DefaultOption::FIELD_NAME          => new DefaultOption(),
				FieldNameOption::FIELD_NAME        => new FieldNameOption(),
			],
			AdvancedTab::TAB_NAME => [
				PreviewWidthOption::FIELD_NAME => new PreviewWidthOption(),
				PreviewLabelOption::FIELD_NAME => new PreviewLabelOption(),
			],
			PricingTab::TAB_NAME  => [
				PricingAdvOption::FIELD_NAME => new PricingAdvOption(),
			],
			LogicTab::TAB_NAME    => [
				LogicAdvOption::FIELD_NAME => new LogicAdvOption(),
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_template_vars( array $field_data ): array {
		$template_vars = parent::get_field_template_vars( $field_data );

		$color_values = [];
		foreach ( $field_data[ OptionsOption::FIELD_NAME ] as $option ) {
			$color_values[ $option[ OptionsValueOption::FIELD_NAME ] ] = $option[ OptionsColorOption::FIELD_NAME ];
		}

		$template_vars['color_values']       = $color_values;
		$template_vars['preview_width']      = $field_data[ PreviewWidthOption::FIELD_NAME ] ?? 0;
		$template_vars['preview_show_label'] = ! ( $field_data[ PreviewLabelOption::FIELD_NAME ] ?? false );

		return $template_vars;
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_available(): bool {
		return true;
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
	public function has_options(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_price_info_in_options(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_logic_info(): bool {
		return true;
	}
}
