<?php
final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    $this->setTemplate('posts/save');

    //$currentUser = $this->currentUser();

    $this->_context->Post = new \Models\Post();
    $this->_context->topicId = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);
    \Controllers\Posts::View($this->_context->Post);

    if(array_key_exists("error", $_GET))
    {
      $this->_context->Error = "There was an error in saving your Post."; 
    }

    if($this->_context->Post->Id != 0)// && $this->_context->Post->PostedBy != $currentUser->Id)
    {
      $this->redirect('/Posts/'.$this->_context->Post->Id);
    }
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
