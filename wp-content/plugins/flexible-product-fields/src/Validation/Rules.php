<?php

namespace WPDesk\FPF\Free\Validation;

use WPDesk\FPF\Free\Validation\Rule\ColorHexRule;
use WPDesk\FPF\Free\Validation\Rule\DateFormatRule;
use WPDesk\FPF\Free\Validation\Rule\DatesExcludedRule;
use WPDesk\FPF\Free\Validation\Rule\DaysAfterRule;
use WPDesk\FPF\Free\Validation\Rule\DaysBeforeRule;
use WPDesk\FPF\Free\Validation\Rule\DaysLimitRule;
use WPDesk\FPF\Free\Validation\Rule\EmailAddressRule;
use WPDesk\FPF\Free\Validation\Rule\LengthRule;
use WPDesk\FPF\Free\Validation\Rule\OptionRule;
use WPDesk\FPF\Free\Validation\Rule\RequiredRule;
use WPDesk\FPF\Free\Validation\Rule\RuleIntegration;
use WPDesk\FPF\Free\Validation\Rule\SelectedMaximumRule;
use WPDesk\FPF\Free\Validation\Rule\SelectedMinimumRule;
use WPDesk\FPF\Free\Validation\Rule\TimeFormatRule;
use WPDesk\FPF\Free\Validation\Rule\TimeStepMinuteRule;
use WPDesk\FPF\Free\Validation\Rule\TodayMaxHourRule;
use WPDesk\FPF\Free\Validation\Rule\UrlAddressRule;
use WPDesk\FPF\Free\Validation\Rule\WeekDaysExcludedRule;

/**
 * Initializes integration of validation rules for fields.
 */
class Rules {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new RuleIntegration( new RequiredRule() ) )->hooks();
		( new RuleIntegration( new LengthRule() ) )->hooks();
		( new RuleIntegration( new OptionRule() ) )->hooks();
		( new RuleIntegration( new DateFormatRule() ) )->hooks();
		( new RuleIntegration( new DaysLimitRule() ) )->hooks();
		( new RuleIntegration( new DaysBeforeRule() ) )->hooks();
		( new RuleIntegration( new DaysAfterRule() ) )->hooks();
		( new RuleIntegration( new DatesExcludedRule() ) )->hooks();
		( new RuleIntegration( new WeekDaysExcludedRule() ) )->hooks();
		( new RuleIntegration( new TodayMaxHourRule() ) )->hooks();
		( new RuleIntegration( new EmailAddressRule() ) )->hooks();
		( new RuleIntegration( new UrlAddressRule() ) )->hooks();
		( new RuleIntegration( new ColorHexRule() ) )->hooks();
		( new RuleIntegration( new TimeFormatRule() ) )->hooks();
		( new RuleIntegration( new TimeStepMinuteRule() ) )->hooks();
		( new RuleIntegration( new SelectedMinimumRule() ) )->hooks();
		( new RuleIntegration( new SelectedMaximumRule() ) )->hooks();
	}
}
