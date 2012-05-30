<?php

namespace Application\Model;

use ZfcBase\Model\ModelAbstract;

class Session extends ModelAbstract
{
    protected $session_id;
    protected $user_id;
    protected $start;
    protected $end;
 
    public function getSessionId()
    {
        return $this->session_id;
    }
 
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
        return $this;
    }
 
    public function getUserId()
    {
        return $this->user_id;
    }
 
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
