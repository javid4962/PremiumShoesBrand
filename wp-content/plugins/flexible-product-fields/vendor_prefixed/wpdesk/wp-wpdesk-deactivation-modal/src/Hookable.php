<?php

namespace VendorFPF\WPDesk\DeactivationModal;

interface Hookable
{
    /**
     * Init hooks (actions and filters).
     *
     * @return void
     */
    public function hooks();
}
