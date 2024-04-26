<?php
/**
 * This template can be overridden by copying it to yourtheme/flexible-product-fields/fields/text.php
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
	<?php
	$args['class'] = explode( ' ', $class );
	woocommerce_form_field( $key, $args, $value );
	?>
</div>
