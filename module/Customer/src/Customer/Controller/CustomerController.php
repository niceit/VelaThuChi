<?php
namespace Customer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Customer\Model\Customer;
use Customer\Form\CustomerForm;



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
        $this->layout('adminLayout');
        $form = new CustomerForm();
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $cus = new Customer();
            $form->setInputFilter($cus->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $cus->exchangeArray($form->getData());

                $this->getCustomerTable()->saveCustomer($cus);


                // Redirect to list of albums
                return $this->redirect()->toRoute('customer');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $this->layout('adminLayout');
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('customer', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $cus = $this->getCustomerTable()->getCustomer($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('customer', array(
                'action' => 'index'
            ));
        }

        $form  = new CustomerForm();
        $form->bind($cus);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($cus->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getCustomerTable()->saveCustomer($cus);

                // Redirect to list of albums
                return $this->redirect()->toRoute('customer');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );

    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('customer');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getCustomerTable()->deleteCustomer($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('customer');
        }

        return array(
            'id'    => $id,
            'customer' => $this->getCustomerTable()->getcustomer($id)
        );

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