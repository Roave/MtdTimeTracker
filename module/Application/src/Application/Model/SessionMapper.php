<?php

namespace Application\Model;

use ZfcBase\Mapper\DbMapperAbstract,
    Zend\Db\Sql\Select,
    Zend\Db\Sql\Where;

class SessionMapper extends DbMapperAbstract
{
    protected $tableName = 'mtdtt_session';

    public function findByUserId($userId)
    {
        $rowset = $this->getTableGateway()->select(array('user_id' => $userId));
        return Session::fromArraySet($rowset->toArray());
    }

    public function findActiveByUserId($userId)
    {
        $where = new Where;
        $where->isNull('end')->AND->equalTo('user_id', $userId);

        $sql = new Select;
        $sql->from($this->tableName)
            ->where($where)
            ->order('start DESC');

        $rowset = $this->getTableGateway()->selectWith($sql);
        $row = $rowset->current();

        return Session::fromArray((array) $row);
    }
}
