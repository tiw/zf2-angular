<?php
namespace Product\Model;
/*
 *
 */

/**
 * Description of Product
 *
 * @author wangting
 */
class Product
{
    /**
     * product id
     * @var type int
     */
    protected $id;

    /**
     * product name
     * @var type string
     */
    protected $name;
    /**
     * the price of the product
     * @var type decimal
     */
    protected $price;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }
}

?>
