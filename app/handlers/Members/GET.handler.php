<?php

final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {


    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    $username = urldecode(\Common\GetLastPhrase($_SERVER['REQUEST_URI']));

    $currentUser = $this->currentUser();

    if($username == "")
    {
      $username = $currentUser->UserName;

      if($username == "")
      {
        $this->redirect("/Members/Login/");
      }
      else
      {
        $this->redirect('/Members/'.$username);
      }
    }

    $user = new \Models\User();
    $user->UserName = "$username";

    if(\Controllers\Users::View($user))
    {

      if($user->UserName == $currentUser->UserName)
      {
        $this->_context->IsMe = true;
        $this->setCurrentContextUser($user);
      }

      $this->_context->MemberUserName = $username;
      $this->_context->Token = $user->Token;
      $this->_context->UserId = $user->UserId;

      $this->setTemplate('members/view');
    }
  }
}
?>
