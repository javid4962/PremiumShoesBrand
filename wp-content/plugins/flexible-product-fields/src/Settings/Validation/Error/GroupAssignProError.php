<?php

namespace WPDesk\FPF\Free\Settings\Validation\Error;

/**
 * {@inheritdoc}
 */
class GroupAssignProError implements ValidationError {

	/**
	 * {@inheritdoc}
	 */
	public function get_message(): string {
		$url_upgrade = esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-option-group-assign' ) );
		return sprintf(
		/* translators: %1$s: anchor opening tag, %2$s: anchor closing tag */
			__( 'This option is available in the PRO version. %1$sUpgrade to PRO%2$s', 'flexible-product-fields' ),
			'<a href="' . $url_upgrade . '" target="_blank" class="fpfArrowLink">',
			'</a>'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function is_fatal_error(): bool {
		return false;
	}
}
