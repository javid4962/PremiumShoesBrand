<?php
/**
 * Notice about plugin review.
 *
 * @var string $ajax_url    URL for Admin Ajax.
 * @var string $ajax_action Action for Admin Ajax.
 * @package Flexible Product Fields
 */

?>
<div class="notice notice-success is-dismissible"
	data-notice="fpf-admin-notice"
	data-notice-url="<?php echo esc_attr( $ajax_url ); ?>"
	data-notice-action="<?php echo esc_attr( $ajax_action ); ?>"
>
	<h2>
		<?php echo esc_html( __( 'Thanks for using the free version of Flexible Product Fields!', 'flexible-product-fields' ) ); ?>
	</h2>
	<p>
		<?php
		echo wp_kses_post(
			sprintf(
			/* translators: %1$s: dashicon, %2$s: break-line tag */
				__( 'We are glad that (with our little help %1$s) the shop is now better suited to the needs. We will be grateful for the rating and feedback. %2$sIt will take less than reading this and it will help us a lot!', 'flexible-product-fields' ),
				'<span class="dashicons dashicons-heart"></span>',
				'<br>'
			)
		);
		?>
	</p>
	<div>
		<a href="<?php echo esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-notice-review-button' ) ); ?>"
			target="_blank"
			class="button button-hero button-primary">
			<?php echo esc_html( __( 'Add review', 'flexible-product-fields' ) ); ?>
		</a>
		<button type="button"
			class="button button-hero" data-notice-button>
			<?php echo esc_html( __( 'I added review, do not show again', 'flexible-product-fields' ) ); ?>
		</button>
	</div>
</div>
