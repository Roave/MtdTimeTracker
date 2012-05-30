<?php

namespace Application\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Controller\IndexController;

class ControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sm)
    {
        $userService = $sm->get('zfcuser_user_service');
        $aclService = $sm->get('ZfcAcl\Service\Acl');
        $trackerService = $sm->get('Application\Service\Tracker');

        $controller = new IndexController();
        $controller->setUserService($userService);
        $controller->setAclService($aclService);
        $controller->setTrackerService($trackerService);
        $controller->setServiceLocator($sm);
        return $controller;
    }
}
