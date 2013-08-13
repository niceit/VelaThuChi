<?php
/**
 * Created by PhpStorm.
 * User: TriSatria
 * Date: 8/9/13
 * Time: 5:16 PM
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Employee\Controller\Employee' => 'Employee\Controller\EmployeeController'
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'customer' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/Employee[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Employee\Controller\Employee',
                        'action'     => 'index',
                    ),
                ),
            ),

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'customer' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'adminLayout' => __DIR__.'/../view/templates/admin-main/layout.phtml'
        )
    ),
);