<?php

namespace WPDesk\FPF\Free\Settings;

use WPDesk\FPF\Free\Settings\Tab\AdvancedTab;
use WPDesk\FPF\Free\Settings\Tab\GeneralTab;
use WPDesk\FPF\Free\Settings\Tab\LogicTab;
use WPDesk\FPF\Free\Settings\Tab\PricingTab;
use WPDesk\FPF\Free\Settings\Tab\TabIntegration;

/**
 * Supports management for settings tabs of field.
 */
class Tabs {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new TabIntegration( new GeneralTab() ) )->hooks();
		( new TabIntegration( new AdvancedTab() ) )->hooks();
		( new TabIntegration( new LogicTab() ) )->hooks();
		( new TabIntegration( new PricingTab() ) )->hooks();
	}
}
