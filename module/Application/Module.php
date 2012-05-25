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
            'dispatchable/Application\\Controller\\IndexController' => array(
                'index' => null,
            ),
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
                // Allow all permissions on the 'index' resource
                'allow/index/all' => array(
                    array('admin'), 'index'
                ),
                // Allow all roles the 'view' privilege on the 'index' resource
                'allow/index/view' => array(
                    array(), 'index', 'view',
                ),
                // Allow the 'admin' role the 'edit' privilege on the 'index' 
                // resource
                'allow/index/edit' => array(
                    array('admin'), 'index', 'edit'
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
