<?php

namespace WPDesk\FPF\Free\Settings\Option;

/**
 * {@inheritdoc}
 */
class GroupSectionOption extends OptionAbstract {

	const FIELD_NAME            = 'section';
	const SECTION_BEFORE_BUTTON = 'woocommerce_before_add_to_cart_button';
	const SECTION_AFTER_BUTTON  = 'woocommerce_after_add_to_cart_button';

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
		return __( 'Section', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_values(): array {
		return [
			self::SECTION_BEFORE_BUTTON => __( 'Before add to cart button', 'flexible-product-fields' ),
			self::SECTION_AFTER_BUTTON  => __( 'After add to cart button', 'flexible-product-fields' ),
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_default_value() {
		return self::SECTION_BEFORE_BUTTON;
	}
}
