<?php
final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    $this->setTemplate('topics/save');

    $currentUser = $this->currentUser();
	$board = new \Models\Board();
	$board->Id = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);
    $this->_context->Topic = new \Models\Topic();
	$this->_context->Board = $board;
    \Controllers\Topics::View($this->_context->Topic);

    if(array_key_exists("error", $_GET))
    {
      $this->_context->Error = "There was an error in saving your post."; 
    }

    if($this->_context->Topic->Id != 0)// && $this->_context->Topic->PostedBy != $currentUser->Id)
    {
      $this->redirect('/Topics/'.$this->_context->Topic->Id);
    }
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
