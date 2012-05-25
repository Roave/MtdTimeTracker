<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
    protected $userService;
    protected $aclService;

    public function indexAction()
    {
        $priv = $this->request()->query()->get('privilege') ?: null;
        if ($this->getAclService()->isAllowed('index', $priv)) {        
            return new ViewModel();
        } else {
            throw new \Exception('NOT ALLOWED BITCH');
        }
    }

    public function getAclService()
    {
        return $this->getServiceLocator()->get('ZfcAcl\Service\Acl');
    }
}
