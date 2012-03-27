<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");
    $this->addPartial("viewPost", "posts/post-template");

    $this->setTemplate('posts/save');

    $post = new \Models\Post();
    //$post->Id = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);

    if(\Controllers\Boards::View($post))
    {
      if($post->PostedBy == $this->currentUser()->Id)
      {
        $post->Body = $this->_request['body'];
        if(\Controllers\Boards::Edit($post))
        {
          $this->redirect('/Posts/'.$post->Id);
        }
        else
        {
          $this->setHTTPStatusCode(400);
          $this->redirect('/Posts/Save/'.$originalQuote->Id.'?error=true');
        }
      }
      else
      {
        $this->setHTTPStatusCode(401);
      }
    }

    $this->setHTTPStatusCode(404);
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
