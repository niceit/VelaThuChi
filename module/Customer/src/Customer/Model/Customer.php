<?php
/**
 * Created by PhpStorm.
 * User: TriSatria
 * Date: 8/12/13
 * Time: 3:29 PM
 */
namespace Customer\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;

use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class Customer{
    protected $_adapter;
    public $id;
    public $customer_name;
    public $address;
    public $customer_phone;
    public $company_name;
    public $tax_id;
    public $company_phone;
    public $company_fax;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->customer_name = (!empty($data['customer_name'])) ? $data['customer_name'] : null;
        $this->customer_phone  = (!empty($data['customer_phone'])) ? $data['customer_phone'] : null;
        $this->company_name = (!empty($data['company_name'])) ? $data['company_name'] : null;
        $this->tax_id  = (!empty($data['tax_id'])) ? $data['tax_id'] : null;
        $this->company_fax  = (!empty($data['company_fax'])) ? $data['company_fax'] : null;
        $this->company_phone  = (!empty($data['company_phone'])) ? $data['company_phone'] : null;
        $this->address  = (!empty($data['address'])) ? $data['address'] : null;
    }
}