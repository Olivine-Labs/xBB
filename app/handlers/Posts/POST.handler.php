<?php
final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {	
    $currentUser = $this->currentUser();
//    if(\Controllers\Boards::CheckAccess($currentUser, $board))
//    {
	  $topic = new \Models\Topic();
	  $topic->Id = $_REQUEST['topicId'];
	  
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
