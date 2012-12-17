<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractRestfulController
{
    public function getList()
    {
        return array(1, 2, 3);
    }

    /**
     * Return single resource
     *
     * @param mixed $id
     * @return mixed
     */
    public function get($id)
    {
        return array('name' => 'ting', 'age' => 35, 'id' => $id);
    }

    /**
     * Create a new resource
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {

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
}
