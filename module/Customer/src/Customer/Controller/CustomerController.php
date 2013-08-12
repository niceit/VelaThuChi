<?php
namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Customer\Model\Customer;



class CustomerController extends AbstractActionController
{
    protected $CustomerTable;
    public function init(){
        $this->layout('adminLayout');
    }
    public function indexAction()
    {
        /*
        $this->layout('adminLayout');
        return new ViewModel(array(
            'customer_list' => $this->getCustomerTable()->fetchAll(),
        ));*/



        $paginator = $this->getCustomerTable()->fetchAll(true);
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int)$this->params()->fromQuery('page', 1));
        // set the number of items per page to 10
        $paginator->setItemCountPerPage(10);
        $this->layout('adminLayout');
        return new ViewModel(array(
            'customer_list' => $paginator
        ));
    }

    public function addAction()
    {

    }

    public function editAction()
    {


    }

    public function deleteAction()
    {

    }

    public function getCustomerTable()
    {
        if (!$this->CustomerTable) {
            $sm = $this->getServiceLocator();
            $this->CustomerTable = $sm->get('Customer\Model\CustomerTable');
        }
        return $this->CustomerTable;
    }
}