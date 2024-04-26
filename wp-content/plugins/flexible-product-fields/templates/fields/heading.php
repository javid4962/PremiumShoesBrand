<?php
/**
 * This template can be overridden by copying it to yourtheme/flexible-product-fields/fields/heading.php
 *
 * @var int             $field_group_id ID of post (post type - fpf_fields).
 * @var string          $key            Field ID.
 * @var string          $type           Field type.
 * @var mixed[]         $args           Custom attributes for field.
 * @var string          $class          CSS class name or space-separated list of classes.
 * @var string|string[] $value          Field value.
 *
 * @package Flexible Product Fields
 */

?>
<div class="fpf-field fpf-<?php echo esc_attr( $type ); ?>">
	<h2 class="<?php echo esc_attr( $class ); ?>" id="<?php echo esc_attr( $key ); ?>_field">
		<?php echo wp_kses_post( $args['label'] ); ?>
	</h2>
</div>
