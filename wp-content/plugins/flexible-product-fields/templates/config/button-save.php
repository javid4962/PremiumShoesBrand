<?php
/**
 * Save config button template.
 *
 * This template can be overridden by copying it to yourtheme/flexible-product-fields/config/button-save.php
 *
 * @author  WP Desk
 * @package Flexible Product Fields/Templates
 * @version 1.0.0
 */

?>
<div class="fpf-fields-config-wrapper">
	<p>
		<?php
		echo wp_kses_post(
			sprintf(
			/* translators: %1$s: link opening tag, %2$s: link closing tag */
				__( 'This button is visible to the Store Admin and no one else. More information about generating a link to a predefined product configuration can be found in %1$s[the documentation]%2$s.', 'flexible-product-fields' ),
				'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-product-button-config' ) ) . '" target="_blank">',
				'</a>'
			)
		);
		?>
	</p>
	<button type="button" class="fpf-fields-config">
		<?php echo esc_html( __( 'Save product config', 'flexible-product-fields' ) ); ?>
	</button>
</div>
