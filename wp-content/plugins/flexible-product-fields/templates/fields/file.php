<?php
/**
 * This template can be overridden by copying it to yourtheme/flexible-product-fields/fields/file.php
 *
 * @var int      $field_group_id    ID of post (post type - fpf_fields).
 * @var string   $key               Field ID.
 * @var string   $type              Field type.
 * @var mixed[]  $args              Custom attributes for field.
 * @var string   $class             CSS class name or space-separated list of classes.
 * @var int      $files_limit       .
 * @var string[] $allowed_mimes     .
 * @var string[] $value_filenames   .
 * @var string[] $value_request_ids .
 *
 * @package Flexible Product Fields
 */

use WPDesk\FPF\Pro\Field\File\RestRouteCreator;

?>
<div class="fpf-field fpf-<?php echo esc_attr( $type ); ?>">
	<p id="<?php echo esc_attr( $key ); ?>_field" class="form-row <?php echo esc_attr( $class ); ?>">
		<label><?php echo wp_kses_post( $args['label'] ); ?></label>
		<span class="fpf-file-items <?php echo esc_attr( $class ); ?>"
			data-api-url="<?php echo esc_url( RestRouteCreator::get_route_url() ); ?>"
			data-api-error-code="<?php echo esc_attr( RestRouteCreator::RESPONSE_ERROR_CODE ); ?>"
			data-api-error-message="<?php echo esc_attr( __( 'An unknown error has occurred. Try again.', 'flexible-product-fields' ) ); ?>"
			data-field-name="<?php echo esc_attr( $key ); ?>"
			data-group-id="<?php echo esc_attr( $field_group_id ); ?>">
			<?php for ( $index = 0; $index < $files_limit; $index++ ) : ?>
				<span class="fpf-file-item"
					data-index="<?php echo esc_attr( $index ); ?>"
					<?php echo ( $index > count( $value_filenames ) ) ? 'hidden' : ''; ?>>
					<span class="fpf-file-draggable">
						<input type="file"
							class="fpf-file-draggable-input"
							accept="<?php echo esc_attr( implode( ',', $allowed_mimes ) ); ?>">
						<span class="fpf-file-draggable-content">
							<span class="fpf-file-draggable-error" hidden></span>
							<span class="fpf-file-draggable-placeholder"
								 <?php echo ( $index < count( $value_filenames ) ) ? 'hidden' : ''; ?>>
								<?php echo esc_html__( 'Select File or Drag & Drop', 'flexible-product-fields' ); ?>
							</span>
							<span class="fpf-file-draggable-loading" hidden>
								<?php echo esc_html__( 'Uploading...', 'flexible-product-fields' ); ?>
							</span>
							<span class="fpf-file-draggable-preview"
								 <?php echo ( $index >= count( $value_filenames ) ) ? 'hidden' : ''; ?>>
								<?php echo esc_attr( $value_filenames[ $index ] ?? '' ); ?>
							</span>
						</span>
						<button type="button"
							class="button fpf-file-draggable-delete"
							 <?php echo ( $index >= count( $value_filenames ) ) ? 'hidden' : ''; ?>>
							<?php echo esc_html__( 'Delete', 'flexible-product-fields' ); ?>
						</button>
					</span>
					<input type="hidden"
						name="<?php echo esc_attr( $key ); ?>_file[]"
						value="<?php echo esc_attr( $value_filenames[ $index ] ?? '' ); ?>"
						class="fpf-file-draggable-filename">
					<input type="hidden"
						name="<?php echo esc_attr( $key ); ?>[]"
						value="<?php echo esc_attr( $value_request_ids[ $index ] ?? '' ); ?>"
						class="fpf-file-draggable-value fpf-input-field">
				</span>
			<?php endfor; ?>
		</span>
	</p>
</div>
