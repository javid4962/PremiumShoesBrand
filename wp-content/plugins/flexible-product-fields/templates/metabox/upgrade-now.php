<?php
/**
 * Upgrade now metabox output.
 */
?>
<?php if ( ! $is_native_box ) : ?>
<div class="stuffbox" id="fpf_upgrade_now"><h3 class="hndle"><?php esc_html_e( 'Flexible Product Fields PRO', 'flexible-product-fields' ); ?></h3>
	<div class="inside">
		<?php endif; ?>
		<ul>
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Conditional logic for fields', 'flexible-product-fields' ); ?></li>
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Add price to fields', 'flexible-product-fields' ); ?></li>
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'New field: Date', 'flexible-product-fields' ); ?></li>
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'New field: File Upload', 'flexible-product-fields' ); ?></li>
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Assign field groups to all products', 'flexible-product-fields' ); ?></li>
			<li><span class="dashicons dashicons-yes"></span><?php esc_html_e( 'Assign field groups to categories', 'flexible-product-fields' ); ?></li>
		</ul>
		<p><a class="button button-primary" target="blank" href="<?php echo esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-widget-upgrade-button' ) ); ?>"><?php esc_html_e( 'Upgrade now →', 'flexible-product-fields' ); ?></a></p>
		<?php if ( ! $is_native_box ) : ?>
	</div>
</div>
<?php endif; ?>
