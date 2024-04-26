<?php

declare (strict_types=1);
/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace VendorFPF\Monolog\Handler;

use VendorFPF\Monolog\Logger;
use VendorFPF\Monolog\Formatter\NormalizerFormatter;
use VendorFPF\Monolog\Formatter\FormatterInterface;
use VendorFPF\Doctrine\CouchDB\CouchDBClient;
/**
 * CouchDB handler for Doctrine CouchDB ODM
 *
 * @author Markus Bachmann <markus.bachmann@bachi.biz>
 */
class DoctrineCouchDBHandler extends \VendorFPF\Monolog\Handler\AbstractProcessingHandler
{
    /** @var CouchDBClient */
    private $client;
    public function __construct(\VendorFPF\Doctrine\CouchDB\CouchDBClient $client, $level = \VendorFPF\Monolog\Logger::DEBUG, bool $bubble = \true)
    {
        $this->client = $client;
        parent::__construct($level, $bubble);
    }
    /**
     * {@inheritDoc}
     */
    protected function write(array $record) : void
    {
        $this->client->postDocument($record['formatted']);
    }
    protected function getDefaultFormatter() : \VendorFPF\Monolog\Formatter\FormatterInterface
    {
        return new \VendorFPF\Monolog\Formatter\NormalizerFormatter();
    }
}
