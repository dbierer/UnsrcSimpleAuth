<?php
namespace UnsrcSimpleAuth\Plugin;

use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\Form\View\Helper\AbstractHelper;

class GetIdentityViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;
	public function __invoke()
	{
        $authService = $this->getServiceLocator()
                    ->getServiceLocator()
                    ->get('unsrc-simple-auth-service');
        if ($authService->hasIdentity()) {
            return $authService->getIdentity();
        } else {
            return NULL;
        }
	}
}
