<?php

namespace WPDesk\FPF\Free\Field\Type;

use WPDesk\FPF\Free\Field\Types;
use WPDesk\FPF\Free\Settings\Option\CssOption;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldPriorityOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\ImageOption;
use WPDesk\FPF\Free\Settings\Option\ImageWidthOption;
use WPDesk\FPF\Free\Settings\Option\LogicAdvOption;
use WPDesk\FPF\Free\Settings\Tab\GeneralTab;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;

/**
 * Supports "Image" field type.
 */
class ImageType extends TypeAbstract {

	const FIELD_TYPE = 'image';

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type(): string {
		return self::FIELD_TYPE;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_label(): string {
		return __( 'Image', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_group(): string {
		return Types::FIELD_GROUP_OTHER;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_type_icon(): string {
		return 'icon-image';
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_options_objects(): array {
		return [
			GeneralTab::TAB_NAME => [
				FieldPriorityOption::FIELD_NAME => new FieldPriorityOption(),
				FieldTypeOption::FIELD_NAME     => new FieldTypeOption(),
				FieldLabelOption::FIELD_NAME    => new FieldLabelOption(),
				ImageOption::FIELD_NAME         => new ImageOption(),
				ImageWidthOption::FIELD_NAME    => new ImageWidthOption(),
				CssOption::FIELD_NAME           => new CssOption(),
				FieldNameOption::FIELD_NAME     => new FieldNameOption(),
			],
			LogicTab::TAB_NAME   => [
				LogicAdvOption::FIELD_NAME => new LogicAdvOption(),
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_field_template_vars( array $field_data ): array {
		$template_vars = parent::get_field_template_vars( $field_data );

		$template_vars['image_id']    = $field_data[ ImageOption::FIELD_NAME ];
		$template_vars['image_alt']   = $field_data[ FieldLabelOption::FIELD_NAME ];
		$template_vars['image_width'] = $field_data[ ImageWidthOption::FIELD_NAME ] ?? '';

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
	public function has_css_class(): bool {
		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function has_logic_info(): bool {
		return true;
	}
}
