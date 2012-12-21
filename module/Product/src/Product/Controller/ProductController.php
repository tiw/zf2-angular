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

    public function getList()
    {
        $products = $this->getProductMapper()->fetchAll();
        $products->setCurrentPageNumber(1);
        $this->info(get_class($products));
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
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product', array(
                    'action' => 'add',
                ));
        }
        $product = $this->getProductMapper()->findById($id);
        $productHydrate = new ProductHydrator();
        return $productHydrate->extract($product);
    }

    /**
     * Create a new resource
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {
        $message = 'creating new product';
        $this->getEventManager()->trigger('info', $this, array('message' => $message));

        $form = $this->getServiceLocator()->get('ProductForm');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData(array(
                'name' => $data->name, 'price' => $data->price,
            ));
            if ($form->isValid()) {
                $mapper = $this->getProductMapper();
                $product = $mapper->insert($form->getData());
                foreach (range(1, 3) as $index) {
                    $this->_saveFile($index, $product->getId());
                }
                $productHydrate = new ProductHydrator();
                return $productHydrate->extract($product);
            } else {
                throw new \Exception('form not valid'. print_r($form->getMessages(), true));
            }
        } else {
            throw new \Exception('can not save');
        }
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

    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id)
    {

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

    public function indexAction()
    {
        $products = $this->getProductMapper()->fetchAll();
        //var_dump($this->params()->fromRoute('page'));
        $products->setCurrentPageNumber($this->params()->fromRoute('page'));
        return array('products' => $products);
    }

    public function addAction()
    {
        $form = $this->getServiceLocator()->get('ProductForm');
        $form->get('submit')->setValue('Add');
        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {
                $mapper = $this->getProductMapper();
                $product = $mapper->insert($form->getData());
                foreach (range(1, 3) as $index) {
                    $this->_saveFile($index, $product->getId());
                }
                return $this->redirect()->toRoute('product');
            }
        }
        return array('form' => $form);
    }

    /**
     * @todo: use it
     * @param type $index
     * @param type $productId
     */
    private function _saveFile($index, $productId)
    {
        $imageName = 'image' . $index;
        if ($_FILES[$imageName]['error'] == 0) {
            $suffix = array_pop(explode('.', $_FILES[$imageName]['name']));
            $generatedImageName = 'product' . $productId . '_' . $index . '.' . $suffix;
            $singleProductImageName = 'product' . $productId . '_' . $index . '_sp.' . $suffix;
            $listProductImageName = 'product' . $productId . '_' . $index . '_ls.' . $suffix;
            $thumbProductImageName = 'product' . $productId . '_' . $index . '_th.' . $suffix;

            $imageDir = __DIR__ . '/../../../../../public/product_images/';


            $uploadName = $imageDir . $generatedImageName;
            $imagePath = "/product_images/" . $generatedImageName;
            if ($_FILES['image' . $index]['size'] == 0) {
                return;
            }
            $result = move_uploaded_file($_FILES['image' . $index]['tmp_name'], $uploadName);
            // resize the images

            SmartResizer::resize($imageDir, $generatedImageName, $generatedImageName, 937, 703);
            SmartResizer::resize($imageDir, $generatedImageName, $singleProductImageName, 300, 225);
            SmartResizer::resize($imageDir, $generatedImageName, $listProductImageName, 194, 146);
            SmartResizer::resize($imageDir, $generatedImageName, $thumbProductImageName, 100, 75);

            if ($result) {
                $image = new Image();
                $image->setName('image' . $index);
                $image->setProductId($productId);
                $image->setImagePath($imagePath);
                $image->setSequence($index);
                $this->getProductImageMapper()->insert($image);
            }
        }
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product', array(
                    'action' => 'add',
                ));
        }
        $product = $this->getProductMapper()->findById($id);
        $form = $this->getServiceLocator()->get('ProductForm');
        $form->bind($product);
        $form->get('submit')->setValue('Edit');
        $form->remove('image1');
        $form->remove('image2');
        $form->remove('image3');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getProductMapper()->update($form->getData());
                return $this->redirect()->toRoute('product');
            }
        }
        $images = $this->getProductImageMapper()->findByProduct($id);
        return array('id' => $id, 'form' => $form, 'images' => $images);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('product');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $this->getProductMapper()->deleteById($id);
            }
            return $this->redirect()->toRoute('product');
        }
        return array('id' => $id, 'product' => $this->getProductMapper()->findById($id));
    }

}

?>
