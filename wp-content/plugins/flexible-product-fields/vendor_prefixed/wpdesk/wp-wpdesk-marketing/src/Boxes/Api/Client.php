<?php

/**
 * Simple API client for fetch marketing boxes.
 */
namespace VendorFPF\WPDesk\Library\Marketing\Boxes\Api;

use VendorFPF\WPDesk\Library\Marketing\Boxes\MarketingBoxes;
/**
 * HTTP Client for fetching data for support boxes.
 *
 * @package WPDesk\Library\Marketing
 */
class Client
{
    const URL = 'https://marketing.wpdesk.org/json/' . \VendorFPF\WPDesk\Library\Marketing\Boxes\MarketingBoxes::VERSION . '/boxes/';
    /** @var string */
    private $plugin_slug;
    public function __construct(string $plugin_slug)
    {
        $this->plugin_slug = $plugin_slug;
    }
    /**
     * @param string $endpoint
     */
    private function get_api_url($endpoint) : string
    {
        return self::URL . \trailingslashit($this->plugin_slug) . $endpoint . '.json';
    }
    /**'
     *
     * @param array $args
     *
     * @return array
     */
    private function get_http_options(array $args) : array
    {
        return \wp_parse_args($args, ['redirection' => 0, 'sslverify' => \false, 'headers' => ['Content-Type' => 'application/json']]);
    }
    /**
     * @return array
     */
    public function send_request($endpoint, $args = []) : array
    {
        $options = $this->get_http_options($args);
        $response = \wp_remote_get($this->get_api_url($endpoint), $options);
        if (\is_wp_error($response) || !\is_array($response)) {
            return [];
        }
        $json = \json_decode(\wp_remote_retrieve_body($response), \true);
        if (!\is_array($json)) {
            return [];
        }
        return $json;
    }
}
