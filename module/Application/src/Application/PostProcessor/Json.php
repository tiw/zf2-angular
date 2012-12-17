<?php
namespace Application\PostProcessor;
use Zend\Json\Encoder;

class Json extends AbstractPostProcessor
{
    public function process()
    {
        $result = Encoder::encode($this->vars);
        $this->response->setContent($result);
        $headers = $this->response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/json');
        $this->response->setHeaders($headers);
    }
}
