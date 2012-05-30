<?php

namespace Application\Model;

use ZfcBase\Mapper\DbMapperAbstract,
    Zend\Db\Sql\Select,
    Zend\Db\Sql\Where,
    ArrayObject;

class SessionSplitMapper extends DbMapperAbstract
{
    protected $tableName = 'mtdtt_session_split';

    public function insert(SessionSplit $split)
    {
        $data = new ArrayObject($this->toScalarValueArray($split));
        return $this->getTableGateway()->insert((array) $data);
    }

    public function findBySessionId($sessionId)
    {
        $rowset = $this->getTableGateway()->select(array('session_id' => $sessionId));
        return SessionSplit::fromArraySet($rowset->toArray());
    }
}
