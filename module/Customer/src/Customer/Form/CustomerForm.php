<?php
namespace Customer\Form;

use Zend\Form\Form;

class CustomerForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('customers');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'customer_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Customer Name',
            ),
        ));
        $this->add(array(
            'name' => 'address',
            'type' => 'Text',
            'options' => array(
                'label' => 'Address',
            ),
        ));
        $this->add(array(
            'name' => 'customer_phone',
            'type' => 'Text',
            'options' => array(
                'label' => 'Customer Phone',
            ),
        ));
        $this->add(array(
            'name' => 'company_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Company Name'
            ),
        ));
        $this->add(array(
            'name' => 'tax_id',
            'type' => 'Text',
            'options' => array(
                'label' => 'Tax Id',
            ),
        ));
        $this->add(array(
            'name' => 'company_phone',
            'type' => 'Text',
            'options' => array(
                'label' => 'Company Phone',
            ),
        ));
        $this->add(array(
            'name' => 'company_fax',
            'type' => 'Text',
            'options' => array(
                'label' => 'Company Fax',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                'class'=>'btn btn-success',
            ),
        ));
    }
}