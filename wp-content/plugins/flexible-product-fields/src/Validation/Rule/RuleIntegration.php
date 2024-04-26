<?php

namespace WPDesk\FPF\Free\Validation\Rule;

/**
 * Initializes integration of validation rule.
 */
class RuleIntegration {

	/**
	 * Class object for validation rule.
	 *
	 * @var RuleInterface
	 */
	private $rule_object;

	/**
	 * Class constructor.
	 *
	 * @param RuleInterface $rule_object Class object of validation rule.
	 */
	public function __construct( RuleInterface $rule_object ) {
		$this->rule_object = $rule_object;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hooks() {
		add_filter( 'flexible_product_fields/validate_field', [ $this, 'validate_field' ], 10, 3 );
	}

	/**
	 * Validates field value.
	 *
	 * @param array $field_data Field settings.
	 * @param mixed $value      Value of field.
	 * @param array $field_type Config for field data.
	 *
	 * @throws \Exception .
	 *
	 * @internal
	 */
	public function validate_field( array $field_data, $value, array $field_type ) {
		if ( $this->rule_object->validate_value( $field_data, $field_type, $value ) ) {
			return;
		}

		throw new \Exception( $this->rule_object->get_error_message( $field_data ) );
	}
}
