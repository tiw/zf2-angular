<?php

namespace Product\Model\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;

class Image extends AbstractDbMapper
{
    protected $tableName = 'product_image';

    public function insert($entity, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setId($result->getGeneratedValue());
        return $entity;
    }

    public function findById($id)
    {
        return $this->select($this->getSelect()->where(array('id' => $id)))->current();
    }

    public function findByProduct($productId)
    {
        $select = $this->getSelect();
        $select->where(array('product_id' => $productId));
        return $this->select($select);
    }

    public function update($entity, $where=null, $tableName = null, \Zend\Stdlib\Hydrator\HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'id = ' . $entity->getId();
        }
        return parent::update($entity, $where, $tableName, $hydrator);
    }

    public function getAllFirstImage()
    {
        $select = $this->getSelect()->where(array('sequence' => 1));
        return $this->select($select);
    }

    public function getFirstImage($productId)
    {
        return $this->select($this->getSelect()->where(array('sequence' => 1, 'product_id' => $productId)))->current();
    }
}
