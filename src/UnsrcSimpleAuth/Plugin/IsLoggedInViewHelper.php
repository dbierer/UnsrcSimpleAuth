<?php
namespace UnsrcSimpleAuth\Plugin;

use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Form\View\Helper\AbstractHelper;

class IsLoggedInViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
	public function __invoke()
	{
        return $this->getServiceLocator()
                    ->getServiceLocator()
                    ->get('unsrc-simple-auth-service')
                    ->hasIdentity();
	}
}
