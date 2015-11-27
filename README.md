#UNLIKELYSOURCE.COM SIMPLE AUTH MODULE
-------------------------------------
- Uses standard Zend\Authentication components
- Username and password are stored in the `unsrc-simple-auth-local.php` config file
- Configure a key `identity` in the config to store desired information

##CAPTCHA
- Uses Zend\Captcha\Image
- Need to create /public/captcha folder
- Make sure this folder is r/w for the PHP user
##Configuration
- Copy config/unsrc-simple-auth.local.php.dist to /config/autoload
- Make any changes required
##Usage
-- You can check to see if a user is logged in as follows:
  -- From a controller: if ($this->isLoggedIn()) { // OK }
  -- From inside a view template: if ($this->isLoggedIn()) { // OK }
-- Stored information
  -- Configure 'unsrc-simple-auth' => 'credentials' => XXX => 'identity' => [ info to be stored ]
  -- Anything under the `identity` key will be stored in the session container associated with authencation
  -- To get stored info back:
  
```
$identity = $this->getServiceLocator()->get('unsrc-simple-auth-service')->getIdentity();
```
