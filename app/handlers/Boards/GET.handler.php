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
	
	$this->_context->Breadcrumbs = array("href"=>"/Boards/" . $this->_context->Board->Id , "text" => $this->_context->Board->Name);
	
	$search = new \Models\Search();
    $search->Board = $boardId;
	$topics = \Controllers\Topics::ListBy($search);
	
	$this->_context->Topics = $topics;
	$count = 0;
	$firstFive = array();
	foreach($topics["Items"] as &$topic)
	{
		$search = new \Models\Search();
		$search->Topic = $topic->Id;
		$posts = \Controllers\Posts::ListBy($search);
		if ($posts["Count"] > 0)
		{
			$firstPost = $posts["Items"][0];
			$topic->PostCount = $posts["Count"];
			$topic->PostBeginning = substr($firstPost->Body, 0, 65);
			if(strlen($firstPost->Body) > 65)
			{
				$topic->PostBeginning = $topic->PostBeginning . " ...";
			}
			$topic->LastPostDate = $posts["Items"][$topic->PostCount - 1]->ReadablePostedOn();
			$topic->Post = $firstPost;
			if ($count < 5)
			{
				$firstFive[] = $topic;
			}
		}
		else
		{
			$topic->PostCount = 0;
		}
		$count++;
	}
	$this->_context->FirstFive = $firstFive;
    $this->addPartial("viewBoard", "Boards/Board-template");
    $this->setTemplate('Boards/view');
    //$this->_context->Board->HasBoardPermissions = \Controllers\Domains::CheckModerator($currentUser, $domain);
  }
}

  ?>
