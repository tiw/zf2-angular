<?php
namespace Tiddr\Mapper;
use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

/**
 * User: wangting
 * Date: 12-11-29
 * Time: 上午11:56
 * copyright 2012 tiddr.de
 */
class Base extends AbstractDbMapper
{

    public function fetchAll($select = null)
    {
        if (null === $select) {
            $select = $this->getSelect();
        }
        $resultSet = new HydratingResultSet($this->getHydrator(), $this->getEntityPrototype());
        $dbSelect = new DbSelect($select, $this->getDbAdapter(), $resultSet);
        return new Paginator($dbSelect);
    }

    public function findById($id)
    {
        $select = $this->getSelect()->where(array('id' => $id));
        return $this->select($select)->current();
    }

    public function insert($entity, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setId($result->getGeneratedValue());
        return $entity;
    }

    public function update($entity, $where = null, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'id = ' . $entity->getId();
        }
        parent::update($entity, $where, $tableName, $hydrator);
    }

    public function deleteById($id, $tableName = null)
    {
        $where = 'id = ' . $id;
        parent::delete($where, $tableName);
    }
}
