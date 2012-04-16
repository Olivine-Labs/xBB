<?php

final class RequestHandler extends \Router\Handler
{
  public function Request()
  {
    $user = new \Models\User();
    $user->Email        = $this->_request['email'];
    $user->UserName     = $this->_request['username'];
    $user->Password     = $this->_request['password'];

    if(\Controllers\Users::Register($user))
    {
      $this->redirect("/Members/".$user->UserName);
    }

    $this->redirect('/Members/Register/?error=true');
  }
}
?>
