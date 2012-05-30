<?php

namespace Application\Model;

use ZfcBase\Model\ModelAbstract;

class Session extends ModelAbstract
{
    protected $sessionId;
    protected $splitTime;
    protected $type;
 
    public function getSessionId()
    {
        return $this->sessionId;
    }
 
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
    }
 
    public function getSplitTime()
    {
        return $this->splitTime;
    }
 
    public function setSplitTime($splitTime)
    {
        $this->splitTime = $splitTime;
        return $this;
    }
 
    public function getType()
    {
        return $this->type;
    }
 
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
