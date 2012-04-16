<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();

    $user = new \Models\User();
    $user->Id = $currentUser->Id;

    if(\Controllers\Users::GenerateToken($user))
    {
      $this->redirect('/Members/'.$currentUser->UserName);
    }

    $this->redirect('/Members/Settings/?error=1');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
