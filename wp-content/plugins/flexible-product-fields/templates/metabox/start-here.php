<?php
/**
 * Start here metabox output.
 */
?>
<?php if ( ! $is_native_box ) : ?>
<div class="stuffbox" id="fpf_docs"><h3 class="hndle"><?php esc_html_e( 'Start here', 'flexible-product-fields' ); ?></h3>
	<div class="inside">
		<?php endif; ?>
		<ul>
			<li><a href="<?php echo esc_url( admin_url( 'admin.php?page=fpf_support' ) ); ?>"><?php esc_html_e( 'How does this plugin work?', 'flexible-product-fields' ); ?></a></li>
			<li><a href="<?php echo esc_url( apply_filters( 'flexible_product_fields/short_url', '#', 'fpf-settings-docs-groups-list' ) ); ?>" target="_blank"><?php esc_html_e( 'Plugin documentation', 'flexible-product-fields' ); ?> &rarr;</a></li>
		</ul>
		<?php if ( ! $is_native_box ) : ?>
	</div>
</div>
<?php endif; ?>
