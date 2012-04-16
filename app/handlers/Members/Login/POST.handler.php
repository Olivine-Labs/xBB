<?php

final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
    $Success = false;
    $registered = false;

    $user = new \Models\User();

   
    $user->Email        = (array_key_exists('email', $this->_request))?$this->_request['email']:'';
    $user->Password     = (array_key_exists('password', $this->_request))?$this->_request['password']:'';
	
    $Success = \Controllers\Users::Login($user);

    $this->_context->Email= $user->Email;
    $this->_context->Error = 'Login failed.';


    if($Success)
    {
      $sub = "";
	  $this->setCurrentContextUser($user);
	  
      $domain = $sub.str_replace('auth.','',$_SERVER['HTTP_HOST']);

      $this->redirect("http://$domain");

    }

    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    $this->setTemplate('members/login-register');
  }
}
?>
