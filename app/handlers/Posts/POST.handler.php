<?php
final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
    $board = new \Models\Board();
    //$board->Name = \Common\GetSubDomain();
    $currentUser = $this->currentUser();
    if(\Controllers\Boards::CheckAccess($currentUser, $board))
    {
      $post = new \Models\post();
      $post->Body  = $_REQUEST['body'];

      if(\Controllers\Posts::Add($post))
      {
        $this->redirect('/Posts/'.$post->Id);
      }
	  else
	  {
		$this->_context->Error = "There was an error in saving your quote."; 
	  }
    }
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
