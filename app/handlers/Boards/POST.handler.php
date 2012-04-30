<?php

final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();
	$board = new \Models\Board();
    $board->Name        = (array_key_exists('title', $this->_request))?$this->_request['title']:null;
    $board->Description  = (array_key_exists('description', $this->_request))?$this->_request['description']:null;

    \Controllers\Boards::Add($board);

    $this->redirect('/');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
