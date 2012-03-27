<?php
final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
    $boardName = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);

    if($boardName == "" || $boardName == "Boards")
    {
      $this->ListBoards();
    }
    else
    {
      $currentUser = $this->currentUser();

      if(!$currentUser->LoggedIn)
      {
        $this->redirect('/Members/Login/');
      }

      $board = new \Models\Domain();
      $board->Name = $boardName;

      if(\Controllers\Domains::View($board) && !\Controllers\Domains::CheckAdministrator($currentUser, $board))
      {
        $this->setHTTPStatusCode(401);
        $this->redirect('/');
      }
      else
      {
        $this->ViewBoardSettings($board);
      }
    }
  }
    public function ViewBoardSettings($board)
  {
    $this->_context->Board = $board;

    $administratorEmails = array();
    $moderatorEmails = array();
    $whiteListEmails = array();
    $blackListEmails = array();

    foreach($board->Administrators as $adminId)
    {
      if($adminId != $this->_context->CurrentUser->Id)
      {
        $user = new \Models\User();
        $user->Id = $adminId;

        if(\Controllers\Users::View($user))
        {
          $administratorEmails[] = array("Email" => $user->Email);
        }
      }
    }

    foreach($board->Moderators as $modId)
    {
      $user = new \Models\User();
      $user->Id = $modId;

      if(\Controllers\Users::View($user))
      {
        $moderatorEmails[] = array("Emails" => $user->Email);
      }
    }

    foreach($board->WhiteList as $whiteListId)
    {
      $user = new \Models\User();
      $user->Id = $whiteListId;

      if(\Controllers\Users::View($user))
      {
        $whiteListEmails[] = array("Emails" => $user->Email);
      }
    }

    foreach($board->BlackList as $blackListId)
    {
      $user = new \Models\User();
      $user->Id = $blackListId;

      if(\Controllers\Users::View($user))
      {
        $blackListEmails[] = array("Emails" => $user->Email);
      }
    }

    $this->_context->Board->AdministratorEmails = $administratorEmails;
    $this->_context->Board->ModeratorEmails = $moderatorEmails;
    $this->_context->Board->WhiteListEmails = $whiteListEmails;
    $this->_context->Board->BlackListEmails = $blackListEmails;


    $this->addPartial('header', 'public/header');
    $this->addPartial('footer', 'public/footer');

    $this->setTemplate('boards/settings');
  }

  public function ListBoards()
  {

    if(!is_numeric($page = \Common\GetLastPhrase($_SERVER['REQUEST_URI'])))
      $page = 1;

    $search = new \Models\Search();
    $search->Limit = 10;
    $search->SortField = 'Name';
    $search->SortDirection = -1;
    $search->Skip = $search->Limit * ($page-1);

    $boards = \Controllers\Boards::ListBy($search);

    $search = new \Models\Search();

    foreach($boards['Items'] as &$board)
    {
      $search->Board = $board->Name;
      $board->PostCount = \Controllers\Boards::CountBy($search);
    }

    $totalPages = 1;
    $totalPages = ceil($boards['Count'] / $search->Limit);

    $this->_context->Boards = $boards;
 

    $this->addPartial('header', 'public/header');
    $this->addPartial('footer', 'public/footer');
    //$this->addPartial('boardPaging', 'boards/board-paging');
    //$this->addPartial('viewBoard', 'boards/board-template');

    //$this->setTemplate('boards/list');
  }
}

  ?>
