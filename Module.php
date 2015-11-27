<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/SimpleAuth for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace UnsrcSimpleAuth;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\ServiceManager\ServiceLocatorAwareInterface;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                'unsrc-simple-auth-controller-login' => function ($cm) {
                    $sm = $cm->getServiceLocator();
                    $controller = new \UnsrcSimpleAuth\Controller\LoginController();
                    $controller->setAuthAdapter($sm->get('unsrc-simple-auth-adapter'));
                    $controller->setAuthService($sm->get('unsrc-simple-auth-service'));
                    $controller->setAuthForm($sm->get('unsrc-simple-auth-login-form'));
                    $controller->setAuthConfig($sm->get('unsrc-simple-auth-config'));
                    return $controller;
                },
            ],
        ];
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'unsrc-simple-auth-config' => function ($sm) {
                    return $sm->get('Config')['unsrc-simple-auth'];
                },
                'unsrc-simple-auth-adapter' => function ($sm) {
                    $adapter = new \UnsrcSimpleAuth\Authentication\AuthAdapter();
                    $adapter->setAuthConfig($sm->get('unsrc-simple-auth-config'));
                    return $adapter;
                },
                'unsrc-simple-auth-login-form' => function ($sm) {
                    $form = new \UnsrcSimpleAuth\Form\LoginForm();
                    $form->prepareElements($sm->get('unsrc-simple-auth-captcha-options'));
                    $form->setInputFilter($sm->get('unsrc-simple-auth-login-filter'));
                    return $form;
                },
            ],
        ];
    }
    
}
