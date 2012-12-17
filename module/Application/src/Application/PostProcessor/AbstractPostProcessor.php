<?php

namespace Application\PostProcessor;

abstract class AbstractPostProcessor
{
    protected $vars = null;

    protected $response = null;

    public function __construct(\Zend\Http\Response $response, $vars = null)
    {
        $this->vars = $vars;
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }

    abstract public function process();
}
