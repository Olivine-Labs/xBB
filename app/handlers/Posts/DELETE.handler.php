<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $post = new \Models\Post();
    $post->Id = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);

    $currentUser = $this->currentUser();

    if(\Controllers\Posts::View($post))
    {
      if($post->PostedBy == $currentUser->Id || $this->_context->BoardAdmin || $this->_context->BoardModerator)
      {
        \Controllers\Posts::Delete($post);
      }
      else
      {
        throw new \Exception('Access Denied');
      }
    }
    $ref = 'http://'.$_SERVER['HTTP_HOST'];
    if(array_key_exists('HTTP_REFERER', $_SERVER))
    {
      $ref = $_SERVER['HTTP_REFERER'];
    }
    $this->redirect($ref);
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
