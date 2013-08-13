<?php
namespace Project;
use Project\Model\Project;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Project\Model\ProjectTable;


class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array( __DIR__ . '/autoload_classmap.php', ),
            'Zend\Loader\StandardAutoloader' => array( 'namespaces' => array( __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__, ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    // Add this method:
    /// Kết nối tới CSDL của model
    ///1. khai báo bản nào cần truy xuất tới
    /**
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Customer\Model\CustomerTable' =>  function($sm) {
                    $tableGateway = $sm->get('vela_customerTableGateway');
                    $table = new CustomerTable($tableGateway);


                    return $table;
                },
                'vela_customerTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Customer());
                    return new TableGateway('vela_customers', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }**/

    // Add this method:
    /// Kết nối tới CSDL của model
    ///1. khai báo bản nào cần truy xuất tới
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Project\Model\ProjectTable' =>  function($sm) {
                    $tableGateway = $sm->get('vela_projectTableGateway');
                    $table = new ProjectTable($tableGateway);


                    return $table;
                },
                'vela_projectTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Project());
                    return new TableGateway('vela_projects', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}