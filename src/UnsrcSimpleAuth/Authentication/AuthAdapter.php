<?php
namespace UnsrcSimpleAuth\Authentication;

use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Session\Container;

class AuthAdapter extends AbstractAdapter implements ServiceLocatorAwareInterface
{
    
    const BAD_USERNAME = 'Unable to confirm this username';
    const BAD_PASSWORD = 'Unable to confirm this password';
    
    protected $authConfig;      // comes from 'unsrc-simple-auth' key in config file
    
    /**
     * Sets Simple Auth config
     *
     * @param array $config = return value from ServiceLocator->get('Config')
     */
    public function setAuthConfig($config)
    {
        if (!isset($config['unsrc-simple-auth']['credentials'])) {
            throw new \Exception('Unable to locate the unsrc-simple-auth => credentials key. Check your config files!');
        }
        $this->authConfig = $config;
    }

    /**
     * Defined by Zend\Authentication\Adapter\AdapterInterface
     *
     * @throws Exception\ExceptionInterface
     * @return AuthenticationResult
     */
    public function authenticate()
    {
        $code     = Result::FAILURE;
        $messages = array();
        if (isset($this->authConfig['credentials'][$this->getIdentity()])) {
            if ($this->authConfig['credentials'][$this->getIdentity()]['password'] === $this->getCredential()) {
                $code = Result::SUCCESS;
            } else {
                $code = Result::FAILURE_CREDENTIAL_INVALID;
                $messages[] = self::BAD_PASSWORD;
            }
        } else {
            $code = Result::FAILURE_IDENTITY_NOT_FOUND;
            $messages[] = self::BAD_USERNAME;
        }
        return new Result($code, $this->getIdentity(), $messages);
    }
}
