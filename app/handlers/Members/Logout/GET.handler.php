<?php

final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    \Controllers\Users::Logout();

    $ref = $_SERVER['HTTP_REFERER'];
    $this->redirect($ref);
  }

  public function AnonymousRequest()
  {
    $ref = $_SERVER['HTTP_REFERER'];
    $this->redirect($ref);
  }
}
?>
