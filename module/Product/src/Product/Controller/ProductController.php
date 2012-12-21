<?php

namespace Product\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Product\Model\Image;
use Product\Model\Mapper\ProductHydrator;

/**
 * Description of ProductController
 *
 * @author wangting
 */
class ProductController extends AbstractRestfulController
{

    protected $productMapper;
    protected $productImageMapper;

    protected function info($message)
    {
        $this->getEventManager()->trigger('info', $this, array('message' => $message));
    }

    protected function getProductHydrate()
    {
        return new ProductHydrator();
    }

    public function getList()
    {
        $products = $this->getProductMapper()->fetchAll();
        $products->setCurrentPageNumber(1);
        $productHydrate = new ProductHydrator();
        foreach($products as $product) {
            $productArray[] = $productHydrate->extract($product);
        }
        return $productArray;
    }

    /**
     * Return single resource
     *
     * @param mixed $id
     * @return mixed
     */
    public function get($id)
    {
        if (!$id) {
            throw new \Exception('no id found');
        }
        $product = $this->getProductMapper()->findById($id);
        return $this->getProductHydrate()->extract($product);
    }

    /**
     * Create a new resource
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $product = new \Product\Model\Product();
        $product->setName($data->name);
        $product->setPrice($data->price);
        $mapper = $this->getProductMapper();
        $product = $mapper->insert($product);
        return $this->getProductHydrate()->extract($product);
    }

    /**
     * Update an existing resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        if (!$id) {
            throw new \Exception('id not found');
        }
        $product = $this->getProductMapper()->findById($id);

        $product->setName($data->name);
        $product->setPrice($data->price);
        $this->getProductMapper()->update($product);
        return $this->getProductHydrate()->extract($product);
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        if (!$id) {
            throw new \Exception('id not found');
        }
        $this->getProductMapper()->deleteById($id);
    }


    public function setProductMapper($productMapper)
    {
        $this->productMapper = $productMapper;
        return $this;
    }
    public function getProductMapper()
    {
        if (!$this->productMapper) {
            $sm = $this->getServiceLocator();
            $this->productMapper = $sm->get('Product\Model\Mapper\Product');
        }
        return $this->productMapper;
    }

    public function getProductImageMapper()
    {
        if (!$this->productImageMapper) {
            $sm = $this->getServiceLocator();
            $this->productImageMapper = $sm->get('Product\Model\Mapper\Image');
        }
        return $this->productImageMapper;
    }

}

?>
