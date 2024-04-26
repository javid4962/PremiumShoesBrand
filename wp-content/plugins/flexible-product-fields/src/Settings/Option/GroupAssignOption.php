<?php

namespace WPDesk\FPF\Free\Settings\Option;

use WPDesk\FPF\Free\Settings\Validation\Error\GroupAssignProError;

/**
 * {@inheritdoc}
 */
class GroupAssignOption extends OptionAbstract {

	const FIELD_NAME = 'assign_to';

	const OPTION_ASSIGN_TO_PRODUCT  = 'product';
	const OPTION_ASSIGN_TO_CATEGORY = 'category';
	const OPTION_ASSIGN_TO_TAG      = 'tag';
	const OPTION_ASSIGN_TO_ALL      = 'all';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_SELECT;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Assign to', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_validation_rules(): array {
		return [
			'^(' . self::OPTION_ASSIGN_TO_PRODUCT . ')$' => new GroupAssignProError(),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		return [
			self::OPTION_ASSIGN_TO_PRODUCT  => __( 'Product', 'flexible-product-fields' ),
			self::OPTION_ASSIGN_TO_CATEGORY => __( 'Category', 'flexible-product-fields' ),
			self::OPTION_ASSIGN_TO_TAG      => __( 'Tag', 'flexible-product-fields' ),
			self::OPTION_ASSIGN_TO_ALL      => __( 'All products', 'flexible-product-fields' ),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return self::OPTION_ASSIGN_TO_PRODUCT;
	}

	public function get_disabled_values(): array {
		if ( is_flexible_products_fields_pro_active() ) {
			return [];
		}

		return [ self::OPTION_ASSIGN_TO_CATEGORY, self::OPTION_ASSIGN_TO_TAG, self::OPTION_ASSIGN_TO_ALL ];
	}
}
