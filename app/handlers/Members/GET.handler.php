<?php

final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");
	$this->addPartial("user", "public/user");

    $userId = urldecode(\Common\GetLastPhrase($_SERVER['REQUEST_URI']));

    $currentUser = $this->currentUser();

    if($userId == "")
    {
      $username = $currentUser->UserName;

      if($username == "")
      {
        $this->redirect("/Members/Login/");
      }
  
    }

    $user = new \Models\User();
    $user->Id = $userId;

    if(\Controllers\Users::View($user))
    {
      if($user->UserName == $currentUser->UserName)
      {
        $this->_context->IsMe = true;
        $this->setCurrentContextUser($user);
      }
		
	  $search = new \Models\Search();
      $search->Limit = 20;
      $search->SortField = 'PostedOn';
      $search->SortDirection = -1;
      $search->PostedBy = $user->Id;

      $posts = \Controllers\Posts::ListBy($search);
	  
	  $this->_context->Posts = $posts;
	  
      $this->_context->MemberUserName = $user->UserName;
     
      $this->_context->UserId = $user->UserId;

      $this->setTemplate('members/view');
	  $this->addPartial("viewPosts", "topics/topic-template");
    }
  }
}
?>
