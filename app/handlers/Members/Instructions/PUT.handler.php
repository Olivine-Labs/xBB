<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();
    $user = new \Models\User();
    $user->Id = $currentUser->Id;

    \Controllers\Users::View($user);

    $user->Profile->SkipInstructions = true;

    if(\Controllers\Users::Edit($user))
    {
      $this->setCurrentContextUser($user);
      if(array_key_exists('HTTP_REFERER', $_SERVER))
      {
        $this->redirect($_SERVER['HTTP_REFERER']);
      }
      else
      {
        $this->redirect('/Members/Settings/?success=true');
      }
    }

    $this->redirect('/Members/Settings/?error=1');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
