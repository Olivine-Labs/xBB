<?php

final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    if(array_key_exists("subdomain", $this->_request))
    {
      $board = trim($this->_request["subdomain"]);
      $board = preg_replace('/\s+/', '-', $board);

      $this->redirect('http://'.$board.'.'.$_SERVER['HTTP_HOST'].'/');
    }
	$board = new \Models\Board();
	$lastPhrase = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);
	if ($lastPhrase != "" && strtolower($lastPhrase) != "save")
	{
		$board->Id = $lastPhrase;
		\Controllers\Boards::View($board);
	}
	$this->_context->Board = $board;

    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    $this->setTemplate('boards/settings');
  }
  
  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
