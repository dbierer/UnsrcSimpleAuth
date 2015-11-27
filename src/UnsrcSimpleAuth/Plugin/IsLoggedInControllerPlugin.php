<?php
namespace UnsrcSimpleAuth\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class IsLoggedInControllerPlugin extends AbstractPlugin
{
	public function __invoke()
	{
        return $this->getController()
                    ->getServiceLocator()
                    ->get('unsrc-simple-auth-service')
                    ->hasIdentity();        
	}
}
