<?php
/**
 * Template of plugin admin page.
 *
 * @var array  $settings            Data for window.reactInit variable.
 * @var string $field_name_nonce    .
 * @var string $field_name_fields   .
 * @var string $field_name_settings .
 * @var string $nonce_submit        .
 * @package Flexible Product Fields
 */

?>

<input type="hidden" name="<?php echo esc_attr( $field_name_nonce ); ?>" value="<?php echo esc_attr( $nonce_submit ); ?>">
<input type="hidden" name="<?php echo esc_attr( $field_name_fields ); ?>">
<input type="hidden" name="<?php echo esc_attr( $field_name_settings ); ?>">

<div class="fpfSettings">
	<div id="fpf-settings"></div>
	<ul class="fpfSettings__columns">
		<li class="fpfSettings__column">
			<div class="fpfSettings__footer">
				<?php
				echo wp_kses_post(
					sprintf(
					/* translators: %$1s: love icon, %$2s: anchor opening tag, %$3s: anchor closing tag, %$4s: anchor opening tag, %$5s: anchor closing tag */
						__( 'Created with %1$s by %2$sWP Desk%3$s - if you like FPF %4$srate us%5$s', 'flexible-product-fields' ),
						'<span class="fpfSettings__footerIcon fpfSettings__footerIcon--heart"></span>',
						'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-footer-wpdesk-link' ) ) . '" target="_blank">',
						'</a>',
						'<a href="' . esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-footer-review-link' ) ) . '" target="_blank">',
						'<span class="fpfSettings__footerIcon fpfSettings__footerIcon--star"></span>
								<span class="fpfSettings__footerIcon fpfSettings__footerIcon--star"></span>
								<span class="fpfSettings__footerIcon fpfSettings__footerIcon--star"></span>
								<span class="fpfSettings__footerIcon fpfSettings__footerIcon--star"></span>
								<span class="fpfSettings__footerIcon fpfSettings__footerIcon--star"></span>
							</a>'
					)
				);
				?>
			</div>
		</li>
	</ul>
</div>

<script>
	window.reactInit = <?php echo json_encode( $settings ); ?>;
</script>
