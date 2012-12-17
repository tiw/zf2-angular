<?php

namespace Product\Model;

class Image
{

    protected $id;
    protected $productId;
    protected $imagePath;
    protected $name;
    protected $sequence;
    protected $description;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }

    public function readThumbImagePath()
    {
        return str_replace('.', '_th.', $this->getImagePath());
    }

    public function readSingleProductImage()
    {
        return str_replace('.', '_sp.', $this->getImagePath());
    }

    /**
     * product image in the product list
     */
    public function readListProductImage()
    {
        return str_replace('.', '_ls.', $this->getImagePath());
    }

    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSequence()
    {
        return $this->sequence;
    }

    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

}
