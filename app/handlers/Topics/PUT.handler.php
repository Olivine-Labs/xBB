<?php

final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $currentUser = $this->currentUser();

    $Topic = new \Models\Domain();
    $Topic->Id  = (array_key_exists('Id', $this->_request))?$this->_request['Id']:null;

    if(!\Controllers\Topics::View($Topic) || !\Controllers\Topics::CheckAdministrator($currentUser, $Topic))
    {
      $this->setHTTPStatusCode(401);
      $this->redirect('/Topics/'.$Topic->Name);
    }

    $Topic->Title        = (array_key_exists('title', $this->_request))?$this->_request['title']:null;
    $Topic->Description  = (array_key_exists('description', $this->_request))?$this->_request['description']:null;
    $Topic->CSSOverride  = (array_key_exists('cssoverride', $this->_request))?$this->_request['cssoverride']:null;

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

    $Topic->Administrators = $adminIds;
    $Topic->Moderators = $modIds;

    \Controllers\Topics::Edit($Topic); 
    $this->redirect('/Topics/'.$Topic->Name.'?success=true');
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
