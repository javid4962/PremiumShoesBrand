<?php

namespace VendorFPF\WPDesk\DeactivationModal\Model;

use VendorFPF\WPDesk\DeactivationModal\Exception\DuplicatedFormValueKeyException;
/**
 * It manages the list of additional information sent in the request reporting plugin deactivation.
 */
class FormValues
{
    /**
     * @var FormValue[]
     */
    private $values = [];
    /**
     * @param FormValue $new_value .
     *
     * @throws DuplicatedFormValueKeyException
     */
    public function set_value(\VendorFPF\WPDesk\DeactivationModal\Model\FormValue $new_value) : self
    {
        foreach ($this->values as $value) {
            if ($value->get_key() === $new_value->get_key()) {
                throw new \VendorFPF\WPDesk\DeactivationModal\Exception\DuplicatedFormValueKeyException($new_value->get_key());
            }
        }
        $this->values[] = $new_value;
        return $this;
    }
    /**
     * @return FormValue[]
     */
    public function get_values() : array
    {
        return $this->values;
    }
}
