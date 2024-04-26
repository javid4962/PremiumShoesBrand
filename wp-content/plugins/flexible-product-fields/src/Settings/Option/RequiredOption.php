<?php

namespace WPDesk\FPF\Free\Settings\Option;

use WPDesk\FPF\Free\Settings\Tab\GeneralTab;

/**
 * {@inheritdoc}
 */
class RequiredOption extends OptionAbstract {

	const FIELD_NAME = 'required';

	/**
	 * {@inheritdoc}
	 */
	public function get_option_name(): string {
		return self::FIELD_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_tab(): string {
		return GeneralTab::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_type(): string {
		return self::FIELD_TYPE_CHECKBOX;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_option_label(): string {
		return __( 'Required field', 'flexible-product-fields' );
	}
}
