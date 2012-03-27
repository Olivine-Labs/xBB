<?php

final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
      $search = new \Models\Search();
      $search->SortField = 'Name';
      $search->SortDirection = -1;
      $boards = \Controllers\Boards::ListBy($search);
	 // $boards = null
      //$currentUser = $this->currentUser();
	  //if (!is_object($boards))
	  //{
      //foreach($boards['Items'] as &$board)
      //{
      //  if(is_object($board))
       // {
       //   $board->HasBoardPermissions = false;

       //   if($currentUser->LoggedIn)
        //  {
        //    $board->HasBoardPermissions = ($this->_context->BoardAdmin || $this->_context->BoardModerator);
         // }
       // }
      //}
      //}
      //$this->_context->Boards = $boards;

      $this->addPartial("header", "public/header");
      $this->addPartial("footer", "public/footer");
      //$this->addPartial("viewQuote", "quotes/quote-template");

      //$partial = $this->_context->CurrentUser->LoggedIn ? "_instructions" : "_skipinstructions";
	  
      $this->setTemplate("public/index");
    }
}

?>
