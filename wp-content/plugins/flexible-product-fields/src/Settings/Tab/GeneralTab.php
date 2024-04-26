<?php

namespace WPDesk\FPF\Free\Settings\Tab;

/**
 * {@inheritdoc}
 */
class GeneralTab extends TabAbstract {

	const TAB_NAME = 'general';

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
		return __( 'General', 'flexible-product-fields' );
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_tab_icon(): string {
		return 'icon-cog';
	}
}
