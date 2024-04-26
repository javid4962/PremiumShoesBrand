<?php

namespace VendorFPF\WPDesk\DeactivationModal\Service;

use VendorFPF\WPDesk\DeactivationModal\Hookable;
use VendorFPF\WPDesk\DeactivationModal\Modal;
use VendorFPF\WPDesk\DeactivationModal\Model\FormOptions;
use VendorFPF\WPDesk\DeactivationModal\Model\FormTemplate;
use VendorFPF\WPDesk\DeactivationModal\Model\FormValues;
/**
 * Prints the deactivation modal template on the plugin list page.
 */
class TemplateGeneratorService implements \VendorFPF\WPDesk\DeactivationModal\Hookable
{
    /**
     * @var string
     */
    private $plugin_slug;
    /**
     * @var FormTemplate
     */
    private $form_template;
    /**
     * @var FormOptions
     */
    private $form_options;
    /**
     * @var FormValues
     */
    private $form_values;
    public function __construct(string $plugin_slug, \VendorFPF\WPDesk\DeactivationModal\Model\FormTemplate $form_template, \VendorFPF\WPDesk\DeactivationModal\Model\FormOptions $form_options, \VendorFPF\WPDesk\DeactivationModal\Model\FormValues $form_values)
    {
        $this->plugin_slug = $plugin_slug;
        $this->form_template = $form_template;
        $this->form_options = $form_options;
        $this->form_values = $form_values;
    }
    /**
     * {@inheritdoc}
     */
    public function hooks()
    {
        \add_action('admin_print_footer_scripts-plugins.php', [$this, 'load_template'], 0);
    }
    public function load_template()
    {
        $params = ['api_url' => \VendorFPF\WPDesk\DeactivationModal\Service\RequestSenderService::generate_ajax_url($this->plugin_slug), 'plugin_slug' => $this->plugin_slug, 'field_name_reason' => \VendorFPF\WPDesk\DeactivationModal\Service\RequestSenderService::FORM_FIELD_REASON, 'field_name_message' => \VendorFPF\WPDesk\DeactivationModal\Service\RequestSenderService::FORM_FIELD_MESSAGE, 'form_template' => $this->form_template, 'form_options' => $this->form_options, 'form_values' => $this->form_values];
        \extract($params);
        // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
        require_once \VendorFPF\WPDesk\DeactivationModal\Modal::MODAL_TEMPLATE_PATH;
    }
}
