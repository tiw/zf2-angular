<?php

namespace Product\Controller;

use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfiguration;
use Zend\Mvc\Application;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Product\Model\Mapper\Product;

/**
 * ProductControllerTest 
 * 
 * @uses PHPUnit
 * @uses _Framework_TestCase
 * @category
 * @package 
 * @version $id$
 * @copyright 2012 ec3s
 * @author Ting Wang <ting.wang@ec3s.com> 
 * @license Copyright (c) 2012 ec3s
 */
class ProductControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * setUp 
     * 
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->pc = new ProductController();
        $this->request = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'product'));
        $this->event = new MvcEvent();
        $this->event->setRouteMatch($this->routeMatch);
        $this->pc->setEvent($this->event);

    }

    public function testGetList()
    {
        $p1 =  new \Product\Model\Product();
        $p1->setName('name1');
        $p2 =  new \Product\Model\Product();
        $p2->setName('name2');
        $paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter(array(
            $p1, $p2
        )));
        $pm = $this->getMock('\Product\Model\Mapper\Product');
        $pm->expects($this->any())
            ->method('fetchAll')
            ->will($this->returnValue($paginator));
        $this->pc->setProductMapper($pm);
        $result = $this->pc->getList();
        $this->assertEquals(2, count($result));
    }

    public function testGet()
    {
        $p = new \Product\Model\Product();
        $p->setName('name1');
        $p->setPrice(2);

        $pm = $this->getMock('\Product\Model\Mapper\Product');
        $pm->expects($this->any())
            ->method('findById')
            ->will($this->returnValue($p));
        $this->pc->setProductMapper($pm);
        $result = $this->pc->get(1);
        $this->assertTrue(is_array($result));
        $this->assertEquals('name1', $result['name']);
        $this->assertEquals('2', $result['price']);
    }

    public function testCreate()
    {

        $p = new \Product\Model\Product();
        $p->setName('name1');
        $p->setPrice(2);
        $p->setId(1);
        $pm = $this->getMock('\Product\Model\Mapper\Product');
        $pm->expects($this->any())
            ->method('insert')
            ->will($this->returnValue($p));
        $this->pc->setProductMapper($pm);
        $data = new \stdClass;
        $data->name = 'name2';
        $data->price = 2;
        $result = $this->pc->create($data);
        $this->assertEquals(1, $result['id']);
        $this->assertEquals('name1', $result['name']);
        $this->assertEquals('2', $result['price']);
    }

    public function testDelete()
    {
        $pm = $this->getMock('\Product\Model\Mapper\Product');
        $pm->expects($this->any())
            ->method('delete')
            ->will($this->returnValue(''));
        $this->pc->setProductMapper($pm);
        $id = 3;
        $result = $this->pc->delete($id);
    }

    public function testUpdate()
    {
        $p = new \Product\Model\Product();
        $p->setName('name1');
        $p->setPrice(2);
        $p->setId(1);
        $pm = $this->getMock('\Product\Model\Mapper\Product');
        $pm->expects($this->any())
            ->method('update')
            ->will($this->returnValue($p));
        $pm->expects($this->any())
            ->method('findById')
            ->will($this->returnValue($p));
        $this->pc->setProductMapper($pm);
        $data = new \stdClass;
        $data->name = 'name2';
        $data->price = 3;
        $data->id = 1;
        $result = $this->pc->update($data->id, $data);
        $this->assertEquals(1, $result['id']);
        $this->assertEquals('name2', $result['name']);
        $this->assertEquals('3', $result['price']);
        
    }
}
