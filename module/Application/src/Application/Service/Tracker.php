<?php

namespace Application\Service;

use Application\Model\Session;
use Application\Model\SessionSplit;

class Tracker
{
    protected $sessionMapper;
    protected $sessionSplitMapper;

    public function findByUserId($userId)
    {
        return $this->sessionMapper->findByUserId($userId);
    }

    public function getActiveSession($userId)
    {
        return $this->sessionMapper->findActiveByUserId($userId);
    }

    public function isPaused(Session $session)
    {
        $splits = $this->sessionSplitMapper->findBySessionId($session->getSessionId());

        $sessionRunning = true;
        foreach ($splits as $s) {
            if ($s->getType() === 'pause') {
                $sessionRunning = false;
            } else {
                $sessionRunning = true;
            }
        }

        return !$sessionRunning;
    }

    public function startSession($userId)
    {
        $session = new Session;
        $session->setStart(time())
            ->setUserId($userId);

        $this->sessionMapper->persist($session);
        return true;
    }

    public function endSession(Session $session)
    {
        $session->setEnd(time());
        $this->sessionMapper->persist($session);
        return true;
    }

    public function calculateRuntime(Session $session)
    {
        $base = $session->getStart();
        $runtime = 0;
        $running = true;

        $splits = $this->sessionSplitMapper->findBySessionId($session->getSessionId());
        foreach ($splits as $s) {
            if ($s->getType() === 'pause') {
                $runtime += ($s->getSplitTime() - $base);
                $running = false;
            } else {
                $base = $s->getSplitTime();
                $running = true;
            }
        }

        if ($session->getEnd() == 0) {
            if ($running === true) {
                $runtime += (time() - $base);
            }
        } else {
            $runtime += ($session->getEnd() - $base);
        }

        return $runtime;
    }

    public function resumeSession(Session $session)
    {
        $split = new SessionSplit;
        $split->setSessionId($session->getSessionId())
            ->setType('resume')
            ->setSplitTime(time());

        $this->sessionSplitMapper->insert($split);
    }

    public function pauseSession(Session $session)
    {
        $split = new SessionSplit;
        $split->setSessionId($session->getSessionId())
            ->setType('pause')
            ->setSplitTime(time());

        $this->sessionSplitMapper->insert($split);
    }
 
    public function getSessionMapper()
    {
        return $this->sessionMapper;
    }
 
    public function setSessionMapper($sessionMapper)
    {
        $this->sessionMapper = $sessionMapper;
        return $this;
    }
 
    public function getSessionSplitMapper()
    {
        return $this->sessionSplitMapper;
    }
 
    public function setSessionSplitMapper($sessionSplitMapper)
    {
        $this->sessionSplitMapper = $sessionSplitMapper;
        return $this;
    }
}
