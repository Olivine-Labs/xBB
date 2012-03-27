<?php

final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();

    $board = new \Models\Domain();
    $board->Id  = (array_key_exists('Id', $this->_request))?$this->_request['Id']:null;

    if(!\Controllers\Boards::View($board) || !\Controllers\Boards::CheckAdministrator($currentUser, $board))
    {
      $this->setHTTPStatusCode(401);
      $this->redirect('/Boards/'.$board->Name);
    }

    $board->Title        = (array_key_exists('title', $this->_request))?$this->_request['title']:null;
    $board->Description  = (array_key_exists('description', $this->_request))?$this->_request['description']:null;
    $board->CSSOverride  = (array_key_exists('cssoverride', $this->_request))?$this->_request['cssoverride']:null;

    $adminIds = array($currentUser->Id);
    $modIds = array();
    $whiteListIds = array();
    $blackListIds = array();

    $user = new \Models\User();

    foreach($this->_request["admins"] as $email)
    {
      if($email != $currentUser->Email && trim($email) != "")
      {
        $user->Email = $email;

        if(\Controllers\Users::View($user) && !in_array($user->Id, $adminIds))
        {
          $adminIds[] = $user->Id;
        }
      }
    }

    foreach($this->_request["mods"] as $email)
    {
      if($email != $currentUser->Email && trim($email) != "")
      {
        $user->Email = $email;

        if(\Controllers\Users::View($user) && !in_array($user->Id, $modIds))
        {
          $modIds[] = $user->Id;
        }
      }
    }

    $board->Administrators = $adminIds;
    $board->Moderators = $modIds;

    \Controllers\Boards::Edit($board); 
    $this->redirect('/Boards/'.$board->Name.'?success=true');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
