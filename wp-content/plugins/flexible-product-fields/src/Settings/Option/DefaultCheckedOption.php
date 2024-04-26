<?php

namespace WPDesk\FPF\Free\Settings\Option;

use WPDesk\FPF\Free\Settings\Tab\GeneralTab;

/**
 * {@inheritdoc}
 */
class DefaultCheckedOption extends OptionAbstract {

	const FIELD_NAME = 'default_checked';

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
		return __( 'Checked by default', 'flexible-product-fields' );
	}
}
