<?php

namespace VendorFPF\WPDesk\Composer\Codeception;

use VendorFPF\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests;
use VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb;
use VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests;
use VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTestsWithCoverage;
use VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests;
use VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception;
use VendorFPF\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests;
use VendorFPF\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests;
use VendorFPF\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTestsWithCoverage;
/**
 * Links plugin commands handlers to composer.
 */
class CommandProvider implements \VendorFPF\Composer\Plugin\Capability\CommandProvider
{
    public function getCommands()
    {
        return [new \VendorFPF\WPDesk\Composer\Codeception\Commands\CreateCodeceptionTests(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\RunCodeceptionTests(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTests(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\RunLocalCodeceptionTestsWithCoverage(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareCodeceptionDb(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareWordpressForCodeception(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTests(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareLocalCodeceptionTestsWithCoverage(), new \VendorFPF\WPDesk\Composer\Codeception\Commands\PrepareParallelCodeceptionTests()];
    }
}
