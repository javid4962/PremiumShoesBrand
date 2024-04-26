<?php
/**
 * This template can be overridden by copying it to yourtheme/flexible-product-fields/fields/radio-colors.php
 *
 * @var int             $field_group_id     ID of post (post type - fpf_fields).
 * @var string          $key                Field ID.
 * @var string          $type               Field type.
 * @var mixed[]         $args               Custom attributes for field.
 * @var string          $class              CSS class name or space-separated list of classes.
 * @var string[]        $color_values       .
 * @var int             $preview_width      .
 * @var bool            $preview_show_label .
 * @var string|string[] $value              Field value.
 *
 * @package Flexible Product Fields
 */

$value = ( ( $value === null ) && ( ( $args['default'] ?? '' ) !== '' ) ) ? $args['default'] : $value;

?>
<div class="fpf-field fpf-<?php echo esc_attr( $type ); ?>">
	<p class="form-row <?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $key ); ?>_field">
		<label><?php echo wp_kses_post( $args['label'] ); ?></label>
		<span class="woocommerce-input-wrapper">
			<?php foreach ( $args['options'] as $option_value => $option_label ) : ?>
				<input type="radio" class="input-radio fpf-input-field"
					value="<?php echo esc_html( $option_value ); ?>"
					name="<?php echo esc_attr( $key ); ?>"
					id="<?php echo esc_attr( $key . '_' . $option_value ); ?>"
					<?php echo ( $option_value == $value ) ? 'checked' : ''; ?>
				>
				<label for="<?php echo esc_attr( $key . '_' . $option_value ); ?>"
					title="<?php echo ( ! $preview_show_label ) ? esc_attr( strip_tags( $option_label ) ) : ''; ?>"
					style="<?php echo ( $preview_width ) ? esc_attr( "width: {$preview_width}px;" ) : ''; ?>">
					<span class="fpf-radio-preview"
						style="background-color: <?php echo esc_attr( $color_values[ $option_value ] ); ?>"></span>
					<?php if ( $preview_show_label ) : ?>
						<span><?php echo wp_kses_post( $option_label ); ?></span>
					<?php endif; ?>
				</label>
			<?php endforeach; ?>
		</span>
	</p>
</div>
