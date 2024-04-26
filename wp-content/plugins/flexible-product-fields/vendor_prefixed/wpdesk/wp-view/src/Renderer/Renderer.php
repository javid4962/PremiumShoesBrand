<?php

namespace VendorFPF\WPDesk\View\Renderer;

use VendorFPF\WPDesk\View\Resolver\Resolver;
/**
 * Can render templates
 */
interface Renderer
{
    /**
     * Set the resolver used to map a template name to a resource the renderer may consume.
     *
     * @param  Resolver $resolver
     */
    public function set_resolver(\VendorFPF\WPDesk\View\Resolver\Resolver $resolver);
    /**
     * @param string $template
     * @param array $params
     *
     * @return string
     */
    public function render($template, array $params = null);
    /**
     * @param string $template
     * @param array $params
     */
    public function output_render($template, array $params = null);
}
