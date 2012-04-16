<?php
final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
    $board = new \Models\Board();
    //if(\Controllers\Boards::CheckAccess($this->currentUser(), $board))
    //{
      $postId = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);

      if($postId == "Posts") $postId = ""; //TODO: Get Board Id and all posts

      if($postId == "")
      {
        $this->ListPosts();
      }
      else
      {
        $this->ViewPost($postId);
      }
	  
    //}
    //else
    //{
    //  $this->setHTTPStatusCode(401);
   // }
  }

  function ListPosts()
  {
    $board = new \Models\Board();
    $board->Name = \Common\GetSubDomain();

    if(!\Controllers\Boards::View($board))
    {
      $this->setHTTPStatusCode(404);
      $this->redirect('/Boards/'.$board->Name);
    }

    $this->addPartial('header', 'public/header');
    $this->addPartial('footer', 'public/footer');

    $this->addPartial('viewPost', 'posts/post-template');
    $this->setTemplate('posts/list');

    $page = 1;

    if(array_key_exists('page', $this->_request) && is_numeric($page = $this->_request['page']))
      $page = $this->_request['page'];

    $keywords = '';

    if(array_key_exists('keywords', $this->_request))
    {
      $keywords = \Models\Quote::CleanString($this->_request['keywords']);
    }

    $order = '';

    if(array_key_exists('order', $this->_request))
    {
      $order = \Models\Quote::CleanString($this->_request['order']);
    }

    $search = new \Models\Search();
    $search->Limit = 10;
    $search->SortField = 'PostedOn';

    //$search->Domain = \Common\GetSubDomain();
    $search->SortDirection = -1;
    $search->Skip = $search->Limit * ($page-1);


    $posts = \Controllers\Boards::ListBy($search);

    $currentUser = $this->currentUser();


    foreach($posts['Items'] as &$post)
    {
      if(is_object($post))
      {
        $post->IsMyBoard = false;
        $post->HasBoardPermissions = false;

        if($currentUser->LoggedIn)
        {
          $myVote = 0;

          
          $post->IsMyQuote = ($currentUser->Id == $post->PostedBy);
          $post->HasBoardPermissions = ($this->_context->BoardAdmin || $this->_context->BoardModerator);
        }
      }
    }

    $totalPages = 1;
    $totalPages = ceil($posts['Count'] / $search->Limit);

    $this->_context->TotalPages = $totalPages;
    $this->_context->Posts = $posts;
  }

  function ViewPost($postId)
  {
    $this->_context->Post = new \Models\Post();
    $this->_context->Post->Id = $postId;


    $this->addPartial("header", "public/header");
    $this->addPartial("footer", "public/footer");

    if(!\Controllers\Posts::View($this->_context->Posts))
    {
      $this->setHTTPStatusCode(404);
      exit();
    }

    $this->addPartial("viewPosts", "Posts/posts-template");
    $this->setTemplate('posts/view');

    $currentUser = $this->currentUser();

    $this->_context->Post->IsMyQPosts = ($currentUser->Id == $this->_context->Post->PostedBy);
    $this->_context->Post->HasBoardPermissions = ($this->_context->BoardAdmin || $this->_context->BoardModerator);
  }
}
?>
