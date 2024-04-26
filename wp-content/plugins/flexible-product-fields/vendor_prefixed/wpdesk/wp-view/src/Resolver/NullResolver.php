<?php

namespace VendorFPF\WPDesk\View\Resolver;

use VendorFPF\WPDesk\View\Renderer\Renderer;
use VendorFPF\WPDesk\View\Resolver\Exception\CanNotResolve;
/**
 * This resolver never finds the file
 *
 * @package WPDesk\View\Resolver
 */
class NullResolver implements \VendorFPF\WPDesk\View\Resolver\Resolver
{
    public function resolve($name, \VendorFPF\WPDesk\View\Renderer\Renderer $renderer = null)
    {
        throw new \VendorFPF\WPDesk\View\Resolver\Exception\CanNotResolve("Null Cannot resolve");
    }
}
