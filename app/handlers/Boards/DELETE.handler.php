<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $board = new \Models\Domain();
    $board->Id = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);

    $currentUser = $this->currentUser();

    if(\Controllers\Boards::View($board))
    {
      if(\Controllers\Boards::CheckAdministrator($currentUser, $board))
      {
        \Controllers\Boards::Delete($board);
        $ref = 'http://'.$_SERVER['HTTP_HOST'];
        if(array_key_exists('HTTP_REFERER', $_SERVER))
        {
          $ref = $_SERVER['HTTP_REFERER'];
        }
        $this->redirect($ref);
      }
      else
      {
        $this->addPartial('header', 'public/header');
        $this->addPartial('footer', 'public/footer');
        $this->setTemplate('errors/401');
      }
    }
    else
    {
      $this->addPartial('header', 'public/header');
      $this->addPartial('footer', 'public/footer');
      $this->setTemplate('errors/404');
    }
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
