<?php

namespace WPDesk\FPF\Free\Field\Type;

use WPDesk\FPF\Free\Field\Types;
use WPDesk\FPF\Free\Settings\Option\CssOption;
use WPDesk\FPF\Free\Settings\Option\FieldLabelOption;
use WPDesk\FPF\Free\Settings\Option\FieldNameOption;
use WPDesk\FPF\Free\Settings\Option\FieldPriorityOption;
use WPDesk\FPF\Free\Settings\Option\FieldTypeOption;
use WPDesk\FPF\Free\Settings\Option\LogicAdvOption;
use WPDesk\FPF\Free\Settings\Tab\GeneralTab;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;

/**
 * Supports "Paragraph" field type.
 */
class ParagraphType extends TypeAbstract {

	const FIELD_TYPE = 'paragraph';

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
		return __( 'Paragraph', 'flexible-product-fields' );
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
		return 'icon-paragraph';
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
