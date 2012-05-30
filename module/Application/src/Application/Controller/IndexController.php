<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    protected $userService;
    protected $aclService;
    protected $trackerService;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function timeAction()
    {
        $userId = $this->userService->getAuthService()->getIdentity();
        $openSession = $this->trackerService->getActiveSession($userId);
        return array(
            'session' => $openSession
        );
    }

    public function getAclService()
    {
        return $this->aclService;
    }

    public function setAclService($aclService)
    {
        $this->aclService = $aclService;
        return $this;
    }
 
    public function getUserService()
    {
        return $this->userService;
    }
 
    public function setUserService($userService)
    {
        $this->userService = $userService;
        return $this;
    }
 
    public function getTrackerService()
    {
        return $this->trackerService;
    }
 
    public function setTrackerService($trackerService)
    {
        $this->trackerService = $trackerService;
        return $this;
    }
}
