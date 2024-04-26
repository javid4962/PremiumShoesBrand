<?php

namespace WPDesk\FPF\Free\Settings;

use WPDesk\FPF\Free\Settings\Form\FormIntegration;
use WPDesk\FPF\Free\Settings\Form\GroupFieldsForm;
use WPDesk\FPF\Free\Settings\Form\GroupSettingsForm;

/**
 * Supports management for forms.
 */
class Forms {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new FormIntegration( new GroupFieldsForm() ) )->hooks();
		( new FormIntegration( new GroupSettingsForm() ) )->hooks();
	}
}
