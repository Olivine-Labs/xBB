<?php

final class RequestHandler extends \Router\SecureHandler
{
  public function AuthenticatedRequest()
  {
       $currentUser = $this->currentUser();
//    if(\Controllers\Boards::CheckAccess($currentUser, $board))
//    {
	  $topic = new \Models\Topic();
      
	  $boardId = $_REQUEST['boardId'];
	  $topic->Name = $_REQUEST['subject'];
	  $topic->Board = $boardId;

	  \Controllers\Topics::Add($topic);
	  
	  $post = new \Models\Post();
	  $post->Topic = $topic->Id;
      $post->Body  = $_REQUEST['body'];

      if(\Controllers\Posts::Add($post))
      {
        $this->redirect('/Topics/'.$topic->Id);
      }
	  else
	  {
		$this->_context->Error = "There was an error in saving your post."; 
	  }
    //}
  }

  public function AnonymousRequest()
  {
    $this->redirect('/Members/Login/');
  }
}
?>
