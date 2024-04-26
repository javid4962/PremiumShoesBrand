<?php

namespace WPDesk\FPF\Free\Settings;

use WPDesk\FPF\Free\Settings\Route\FieldsConditionRoute;
use WPDesk\FPF\Free\Settings\Route\FieldsFieldRoute;
use WPDesk\FPF\Free\Settings\Route\FieldsValueRoute;
use WPDesk\FPF\Free\Settings\Route\ProductsCatsRoute;
use WPDesk\FPF\Free\Settings\Route\ProductsRoute;
use WPDesk\FPF\Free\Settings\Route\ProductsTagsRoute;
use WPDesk\FPF\Free\Settings\Route\RouteIntegration;

/**
 * Supports management for REST API routes.
 */
class Routes {

	/**
	 * Initializes actions for class.
	 *
	 * @return void
	 */
	public function init() {
		( new RouteIntegration( new ProductsRoute() ) )->hooks();
	}
}
