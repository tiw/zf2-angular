<?php

namespace Product\Model\Mapper;

use Tiddr\Mapper\Base;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Description of Product
 *
 * @author wangting
 */
class Product extends Base
{

    protected $tableName = 'product';

    public function fetchAll()
    {
        $select = $this->getSelect();
        $select->join(array('c' => 'category'), 'category_id = c.id', array('category_name' => 'name'));
        return parent::fetchAll($select);
    }

    public function getProductByFilter($filterName, $filterValue)
    {
        $select = $this->getSelect()->where(array($filterName => $filterValue));
        return $this->select($select);
    }

    public function getProductByBetweenFilter($filterName, $minValue, $maxValue)
    {
        $where = new \Zend\Db\Sql\Where();
        $where->between($filterName, $minValue, $maxValue);
        $select = $this->getSelect()->where($where);
        return $this->select($select);
    }

}

?>
