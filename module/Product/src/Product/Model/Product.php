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
     * The id of the product
     * @var type int
     */
    protected $categoryId;

    /**
     * The id of the author
     * @var type int
     */
    protected $authorId;

    /**
     * Display name
     * @var type string
     */
    protected $displayName;

    /**
     * the price of the product
     * @var type decimal
     */
    protected $price;

    /**
     * category name
     * @var type string
     */
    protected $categoryName;

    /**
     * Description of the product
     * @var type string
     */
    protected $description;

    protected $description2;

    protected $description3;

    public function setDescription3($description3)
    {
        $this->description3 = $description3;
    }

    public function getDescription3()
    {
        return $this->description3;
    }

    public function setDescription2($description2)
    {
        $this->description2 = $description2;
    }

    public function getDescription2()
    {
        return $this->description2;
    }
    /**
     * From which country
     * @var type string
     */
    protected $country;

    /**
     * in which kind of material
     * @var type string
     */
    protected $material;

    /**
     * when the product is added
     * @var type date
     */
    protected $createdAt;



    public function getCountry()
    {
        return $this->country;
    }
    public function setCountry($country)
    {
        $this->country = $country;
    }
    public function getMaterial()
    {
        return $this->material;
    }
    public function setMaterial($material)
    {
        $this->material = $material;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

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

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }

    public function getDisplayName()
    {
        return $this->displayName;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function readCategoryName()
    {
        return $this->categoryName;
    }

    public function writeCategoryName($name)
    {
        $this->categoryName = $name;
    }
}

?>
