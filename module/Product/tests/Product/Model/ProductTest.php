<?php
namespace Product\Model;

use PHPUnit_Framework_TestCase;

class ProductTest extends PHPUnit_Framework_TestCase
{
    protected $product;

    protected function setUp()
    {
        $this->product = new Product;
    }

    public function testSetter()
    {
        $this->product->setName('test');
        $this->assertEquals('test', $this->product->getName());
    }
}
