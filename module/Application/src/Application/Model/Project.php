<?php

namespace Application\Model;

use ZfcBase\Model\ModelAbstract;

class Session extends ModelAbstract
{
    protected $projectId;
    protected $userId;
    protected $name;
 
    public function getProjectId()
    {
        return $this->projectId;
    }
 
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
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
 
    public function getName()
    {
        return $this->name;
    }
 
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
