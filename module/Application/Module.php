<?php

namespace Application;

use Zend\ModuleManager\ModuleManager,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\ModuleManager\Feature\ConfigProviderInterface,
    Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
    ServiceProviderInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface
{
    public function init(ModuleManager $moduleManager)
    {
        $moduleManager->events()->attach('ZfcUserAcl.loadAclResources', array($this, 'loadAclResources'));
        $moduleManager->events()->attach('ZfcUserAcl.loadAclRules', array($this, 'loadAclRules'));
    }

    public function loadAclResources()
    {
        return array(
            'dispatchable/index' => null,
            'dispatchable/zfcuser' => null,
        );
    }

    /**
     * Zend\Acl is deny-by-default, so for the most part, all you really need 
     * are allow rules. However, there may be some occasions where one role 
     * inherits from another, but should not be allowed a permission that its 
     * parent has. This is the case for deny rules.
     */
    public function loadAclRules()
    {
        return array(
            'allow' => array(
                // Controller: index, action: index
                // Allow all roles
                'allow/dispatchable/index/all' => array(
                    array(), 'dispatchable/index', array('index')
                ),
                // Controller: index, action: time
                // Allow user and admin
                'allow/dispatchable/index/authenticated' => array(
                    array('user', 'admin'), 'dispatchable/index', array('time')
                ),
                'allow/dispatchable/zfcuser' => array(
                    array(), 'dispatchable/zfcuser'
                ),
            ),
            'deny' => array(
            ),
        );
    }

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'Application\Controller\IndexController' => function ($sm) {
                    $controller = new Application\Controller\IndexController;
                    $controller->setTrackerService($sm->get('Application\Service\Tracker'));
                    $controller->setUserService($sm->get('ZfcUser\Service\User'));
                    $controller->setAclService($sm->get('ZfcAcl\Service\Acl'));
                    return $controller;
                },
                'Application\Service\Tracker' => function ($sm) {
                    $service = new Service\Tracker;
                    $service->setSessionMapper($sm->get('Application\Model\SessionMapper'));
                    return $service;
                },
                'Application\Model\SessionMapper' => function($sm) {
                    $adapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $tg = new \Zend\Db\TableGateway\TableGateway('mtdtt_session', $adapter);
                    return new Model\SessionMapper($tg);
                },
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
