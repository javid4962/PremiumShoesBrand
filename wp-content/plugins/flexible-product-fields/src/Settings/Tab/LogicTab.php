<?php

namespace WPDesk\FPF\Free\Settings\Tab;

/**
 * {@inheritdoc}
 */
class LogicTab extends TabAbstract {

	const TAB_NAME = 'conditional-logic';

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_name(): string {
		return self::TAB_NAME;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_label(): string {
		return __( 'Conditional Logic', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_icon(): string {
		return 'icon-magic';
	}
}
