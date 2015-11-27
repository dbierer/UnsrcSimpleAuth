<?php
namespace UnsrcSimpleAuth\Authentication;

use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AbstractAdapter;

class AuthAdapter extends AbstractAdapter
{
    
    protected $authConfig;      // comes from 'unsrc-simple-auth' key in config file
    protected $messages = array();
    
    /**
     * Defined by Zend\Authentication\Adapter\AdapterInterface
     *
     * @throws Exception\ExceptionInterface
     * @return AuthenticationResult
     */
    public function authenticate()
    {
        $code = Result::FAILURE;
        $this->messages = array();
        if (!isset($this->authConfig['credentials'])) {
            $code = Result::FAILURE_UNCATEGORIZED;
        } else {
            $code = Result::FAILURE_IDENTITY_NOT_FOUND;
            foreach ($this->authConfig['credentials'] as $identity => $info) {
                if (isset($this->authConfig['credentials'][$identity]) 
                    && $info['password'] === $this->getCredential()) {
                    $code = Result::SUCCESS;
                } else {
                    $code = Result::FAILURE_CREDENTIAL_INVALID;
                }
            }
            $this->messages[] = $this->authConfig['authentication-messages'][(string) $code];
        }
        return new Result($code, $this->getIdentity(), $this->messages);
    }

    /**
     * Sets Simple Auth config
     *
     * @param array $config = return value from ServiceLocator->get('Config')
     */
    public function setAuthConfig($config)
    {
        if (!isset($config['credentials'])) {
            throw new \Exception('Unable to locate the unsrc-simple-auth => credentials key. Check your config files!');
        }
        $this->authConfig = $config;
    }

    /**
     * Retrieves authentication failure messages
     *
     * @return array $messages
     */
    public function getMessages()
    {
        return $this->messages;
    }

}
