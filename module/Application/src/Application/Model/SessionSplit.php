<?php

namespace Application\Model;

use ZfcBase\Model\ModelAbstract;

class SessionSplit extends ModelAbstract
{
    protected $session_id;
    protected $split_time;
    protected $type;
 
    public function getSessionId()
    {
        return $this->session_id;
    }
 
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
        return $this;
    }
 
    public function getSplitTime()
    {
        return $this->split_time;
    }
 
    public function setSplitTime($split_time)
    {
        $this->split_time = $split_time;
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
