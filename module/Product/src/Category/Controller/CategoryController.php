<?php
namespace Category\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Category\Model\Category;

/**
 * Description of CategoryController
 *
 * @author wangting
 */
class CategoryController extends AbstractActionController
{
    protected $categoryMapper;

    public function getCategoryMapper()
    {
        if (!$this->categoryMapper) {
            $sm = $this->getServiceLocator();
            $this->categoryMapper = $sm->get('Category\Model\Mapper\Category');
        }
        return $this->categoryMapper;
    }

    public function indexAction()
    {
        $categories = $this->getCategoryMapper()->fetchAll();
        $categories->setCurrentPageNumber($this->params()->fromRoute('page'));
        return array('categories' => $categories);
    }

    public function addAction()
    {
        $form = $this->getServiceLocator()->get('CategoryForm');
        $translator = $this->getServiceLocator()->get('translator');
        $form->get('submit')->setValue($translator->translate('Add', 'category'));

        $request = $this->getRequest();

        if ($request->isPost()) {
            $category = new Category();
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $category  = $form->getData();
                $mapper = $this->getCategoryMapper();
                $mapper->insert($category);
                return $this->redirect()->toRoute('category');

            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('category', array(
                'action' => 'add'
            ));
        }
        $category = $this->getCategoryMapper()->findById($id);
        $form = $this->getServiceLocator()->get('CategoryForm');
        $form->bind($category);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getCategoryMapper()->update($form->getData());
                return $this->redirect()->toRoute('category');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('category');
        }
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $this->getCategoryMapper()->deleteById($id);
            }
            return $this->redirect()->toRoute('category');
        }
        return array(
            'id' => $id,
            'category' => $this->getCategoryMapper()->findById($id),
        );
    }
}

?>
