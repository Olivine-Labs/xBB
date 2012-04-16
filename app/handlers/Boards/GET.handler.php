<?php
final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
    $this->addPartial('header', 'public/header');
    $this->addPartial('footer', 'public/footer');
	$this->addPartial("user", "public/user");
	
	$boardId = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);
	
      if($boardId == "Boards") $boardId = "";

      if($boardId == "")
      {
        $this->ListBoards();
      }
      else
      {
        $this->ViewBoard($boardId);
      }
	}
	
  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
  function ViewBoard($boardId)
  {
    $this->_context->Board = new \Models\Board();
    $this->_context->Board->Id = $boardId;
   
    if(!\Controllers\Boards::View($this->_context->Board))
    {
      $this->setHTTPStatusCode(404);
      exit();
    }
	$search = new \Models\Search();
    $search->Board = $boardId;
	$topics = \Controllers\Topics::ListBy($search);

		$this->_context->Topics = $topics;

    $this->addPartial("viewBoard", "Boards/Board-template");
    $this->setTemplate('Boards/view');

    //$currentUser = $this->currentUser();
    //$this->_context->Board->HasBoardPermissions = \Controllers\Domains::CheckModerator($currentUser, $domain);
  }
}

  ?>
