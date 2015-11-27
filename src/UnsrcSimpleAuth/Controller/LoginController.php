<?php
namespace UnsrcSimpleAuth\Controller;

use UnsrcSimpleAuth\Model\User;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class LoginController extends AbstractActionController
{

    protected $authConfig;
    protected $authForm;
    protected $authAdapter;
    protected $authService;
    
    public function loginAction()
    {
    	if ($this->getRequest()->isPost()) {
    		$this->authForm->setData($this->params()->fromPost());
    		if ($this->authForm->isValid()) {
                $data = $this->authForm->getData();
    			$this->authAdapter->setIdentity($data['who']);
    			$this->authAdapter->setCredential($data['what']);
                $result = $this->authAdapter->authenticate();
                if ($result->isValid()) {
                    if (!isset($this->authConfig['credentials'][$this->authAdapter->getIdentity()])) {
                        return $this->redirect()->toRoute($this->authConfig['redirect']);
                    }
                    $storage = $this->authService->getStorage();
                    $storage->write($this->authConfig['credentials'][$this->authAdapter->getIdentity()]['identity']);
                    return $this->redirect()->toRoute($this->authConfig['redirect']);
                }
    		}
    	}
    	$viewModel = new ViewModel(array('form' => $this->authForm));
    	$viewModel->setTemplate('unsrc-simple-auth/login/login');
        return $viewModel;
    }
    
    public function logoutAction()
    {
        $this->authService->clearIdentity();
        return $this->redirect()->toRoute($this->authConfig['redirect']);
    }
    
    public function setAuthForm($form)
    {
        $this->authForm = $form;
    }
    
    public function setAuthAdapter($adapter)
    {
        $this->authAdapter = $adapter;
    }
    
    public function setAuthService($service)
    {
        $this->authService = $service;
    }
    
    public function setAuthConfig($config)
    {
        $this->authConfig = $config;
    }
    
}
