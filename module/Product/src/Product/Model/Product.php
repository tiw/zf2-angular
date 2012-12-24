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


    /**
     * publishAt 
     * 
     * @var date
     */
    protected $publishAt;

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

    /**
     * getPublishAt 
     * 
     * @return string
     */
    public function getPublishAt()
    {
        return $this->publishAt;
    }

    /**
     * setPublishAt 
     * 
     * @param string $publishAt publish at
     *
     * @return Product\Model\Product
     */
    public function setPublishAt($publishAt)
    {
        $publishAt = date("Y-m-d", strtotime($publishAt));
        $this->publishAt = $publishAt;
        return $this;
    }
}

?>
