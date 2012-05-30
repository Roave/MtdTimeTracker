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
        $userId = $this->userService->getAuthService()->getIdentity();
        $openSession = $this->trackerService->getActiveSession($userId);

        if (!$openSession) {
            return array(
                'open'      => false,
                'runtime'   => '00:00:00',
                'session'   => null,
                'paused'    => false,
            );
        }

        $timeDisplay = $this->runtimeToString($this->trackerService->calculateRuntime($openSession));

        if ($this->trackerService->isPaused($openSession)) {
            return array(
                'open'      => false,
                'session'   => $openSession,
                'runtime'   => $timeDisplay,
                'paused'    => true
            );
        }

        return array(
            'open'      => true,
            'paused'    => false,
            'session'   => $openSession,
            'runtime'   => $timeDisplay
        );
    }

    public function sessionsAction()
    {
        $userId = $this->userService->getAuthService()->getIdentity();
        $sessions = $this->trackerService->findByUserId($userId);

        $all = array();
        foreach ($sessions as $s) {
            $all[] = array(
                'session' => $s,
                'runtime' => $this->runtimeToString($this->trackerService->calculateRuntime($s))
            );
        }

        return array(
            'sessions' => $all
        );
    }

    public function splitAction()
    {
        $userId = $this->userService->getAuthService()->getIdentity();
        $openSession = $this->trackerService->getActiveSession($userId);

        $get = $this->request()->query();
        if ($get['type'] === 'resume') {
            $this->trackerService->resumeSession($openSession);
        } else if ($get['type'] === 'pause') {
            $this->trackerService->pauseSession($openSession);
        }

        return $this->redirect()->toUrl('/');
    }

    public function startAction()
    {
        $userId = $this->userService->getAuthService()->getIdentity();
        $this->trackerService->startSession($userId);
        return $this->redirect()->toUrl('time');
    }

    public function stopAction()
    {
        $userId = $this->userService->getAuthService()->getIdentity();
        $openSession = $this->trackerService->getActiveSession($userId);

        $this->trackerService->endSession($openSession);
        return $this->redirect()->toUrl('time');
    }

    protected function runtimeToString($time)
    {
        $hours = $minutes = $seconds = 0;

        if ($time >= 3600) {
            $hours = floor($time / 3600);
            $time -= $hours * 3600;
        }

        if ($time >= 60) {
            $minutes = floor($time / 60);
            $time -= $minutes * 60;
        }

        $seconds = $time;

        return $this->zeropad($hours) . ':' . $this->zeropad($minutes) . ':' . $this->zeropad($seconds);
    }

    protected function zeropad($num)
    {
        if (strlen($num) === 1) {
            return '0' . $num;
        } else {
            return $num;
        }
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
