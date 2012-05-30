<?php

namespace Application\Service;

class Tracker
{
    protected $sessionMapper;

    public function getActiveSession($userId)
    {
        return $this->sessionMapper->findActiveByUserId($userId);
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
}
