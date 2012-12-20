<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController',
            MvcEvent::EVENT_DISPATCH, array($this, 'postProcess'), -100
        );
        $sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR,
            array($this, 'errorProcess'), 999
        );

        $log = $e->getApplication()->getServiceManager()->get('Log');
        $sharedEvents->attach('*', 'info', function($e) use ($log) {
            $message = $e->getParam('message', 'No message provided');
            $target = $e->getTarget();
            if (is_object($target)) {
                $target = get_class($target);
            }
            $message = sprintf('%s: %s', $target, $message);
            $log->info($message);
        });
    }

    public function postProcess(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $formatter = $routeMatch->getParam('formatter', false);

        $di = $e->getTarget()->getServiceLocator()->get('di');

        if ($formatter !== false) {
            if ($e->getResult() instanceof \Zend\View\Model\ViewModel) {
                if (is_array($e->getResult()->getVariables())) {
                    $vars = $e->getResult()->getVariables();
                } else {
                    $vars = null;
                }
            } else {
                $vars = $e->getResult();
            }

            $postProcessor = $di->get($formatter . '-pp', array(
                'response' => $e->getResponse(),
                'vars' => $vars,
            ));
            $postProcessor->process();

            return $postProcessor->getResponse();
        }
        return null;
    }


    public function errorProcess(MvcEvent $e)
    {
        $di = $e->getApplication()->getServiceManager()->get('di');
        $eventParams = $e->getParams();

        $configuration = $e->getApplication()->getConfig();

        $vars = array();
        if (isset($eventParams['exception'])) {
            $exception = $eventParams['exception'];

            if ($configuration['errors']['show_exceptions']['message']) {
                $vars['error-message'] = $exception->getMessage();
            }

            if ($configuration['errors']['show_exceptions']['trace']) {
                $vars['error-trace'] = $exception->getTrace();
            }
        }

        if (empty($vars)) {
            $vars['error'] = 'Something went wrong';
        }

        $postProcessor = $di->get(
            $configuration['errors']['post_processor'],
            array('vars' => $vars, 'response' => $e->getResponse())
        );

        $postProcessor->process();

        if (
            $eventParams['error'] === \Zend\Mvc\Application::ERROR_CONTROLLER_NOT_FOUND ||
            $eventParams['error'] === \Zend\Mvc\Application::ERROR_ROUTER_NO_MATCH
        ) {
            $e->getResponse()->setStatusCode(\Zend\Http\PhpEnvironment\Response::STATUS_CODE_501);
        } else {
            $e->getResponse()->setStatusCode(\Zend\Http\PhpEnvironment\Response::STATUS_CODE_500);
        }
        $e->stopPropagation();

        return $postProcessor->getResponse();
    }



    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
