<?php

final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();

    $board = new \Models\Domain();
    $board->Name = \Common\GetSubDomain();

    $board->Title        = (array_key_exists('title', $this->_request))?$this->_request['title']:null;
    $board->Description  = (array_key_exists('description', $this->_request))?$this->_request['description']:null;

    \Controllers\Boards::Add($board);

    $this->redirect('/Quotes/');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
