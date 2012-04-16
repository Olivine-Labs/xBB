<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $Topic = new \Models\Topic();
    $Topic->Id = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);

    $currentUser = $this->currentUser();

    if(\Controllers\Topics::View($Topic))
    {
      if(\Controllers\Topics::CheckAdministrator($currentUser, $Topic))
      {
        \Controllers\Topics::Delete($Topic);
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
