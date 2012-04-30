<?php

final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
      $search = new \Models\Search();
      $search->SortField = 'Name';
      $search->SortDirection = 1;
      $boards = \Controllers\Boards::ListBy($search);
	  $currentUser = $this->currentUser();
	  
	  if (is_array($boards) && count($boards) > 0)
	  {
		$this->_context->Boards = $boards;
      }
	  $this->addPartial("header", "public/header");
      $this->addPartial("footer", "public/footer");
	  $this->addPartial("user", "public/user");
      $this->setTemplate("public/index");
    }


  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
