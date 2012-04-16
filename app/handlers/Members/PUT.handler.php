<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();
    $user = new \Models\User();
    $user->Id = $currentUser->Id;

    \Controllers\Users::View($user);

    if(array_key_exists('password', $this->_request) && trim($this->_request['password']) != "")
    {
      $user->Password = \Common\hash(trim($this->_request['password']));
    }

    if(array_key_exists('username', $this->_request) && trim($this->_request['username']) != "")
    {
      $user->UserName = trim($this->_request['username']);
    }

    if(array_key_exists('email', $this->_request) && trim($this->_request['email']) != "")
    {
      $user->Email = trim($this->_request['email']);
    }

    if(\Controllers\Users::Edit($user))
    {
      $this->setCurrentContextUser($user);
      $this->redirect('/Members/Settings/?success=true');
    }

    $this->redirect('/Members/Settings/?error=1');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
