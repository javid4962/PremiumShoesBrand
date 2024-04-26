<?php
/**
 * This template can be overridden by copying it to yourtheme/flexible-product-fields/fields/image.php
 *
 * @var int             $field_group_id ID of post (post type - fpf_fields).
 * @var string          $key            Field ID.
 * @var string          $type           Field type.
 * @var mixed[]         $args           Custom attributes for field.
 * @var string          $class          CSS class name or space-separated list of classes.
 * @var string|string[] $value          Field value.
 * @var int             $image_id       ID of attachment.
 * @var int             $image_width    Width in pixels.
 * @var string          $image_alt      Title of attachment.
 *
 * @package Flexible Product Fields
 */

?>
<div class="fpf-field fpf-<?php echo esc_attr( $type ); ?>">
	<div class="<?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $key ); ?>_field">
		<?php
		echo wp_get_attachment_image(
			$image_id,
			[ $image_width, $image_width ],
			false,
			[
				'alt' => esc_attr( $image_alt ),
			]
		);
		?>
	</div>
</div>
