<?php

namespace Application\Model;

use ZfcBase\Model\ModelAbstract;

class Session extends ModelAbstract
{
    protected $sessionId;
    protected $userId;
    protected $start;
    protected $end;
 
    public function getSessionId()
    {
        return $this->sessionId;
    }
 
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }
 
    public function getUserId()
    {
        return $this->userId;
    }
 
    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }
 
    public function getStart()
    {
        return $this->start;
    }
 
    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }
 
    public function getEnd()
    {
        return $this->end;
    }
 
    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }
}
