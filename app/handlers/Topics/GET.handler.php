<?php
final class RequestHandler extends \Router\AuthenticationHandler
{
  public function Request()
  {
	$topicId = \Common\GetLastPhrase($_SERVER['REQUEST_URI']);
    $this->addPartial('header', 'public/header');
    $this->addPartial('footer', 'public/footer');
	$this->addPartial("user", "public/user");
    if($topicId == "" || $topicId == "Topics")
    {
      $this->ListTopics();
    }
    else
    {
      $currentUser = $this->currentUser();

      if(!$currentUser->LoggedIn)
      {
        $this->redirect('/Members/Login/');
      }
	  
	  error_log(print_r($this->_context, true));
      $topic = new \Models\Topic();
      $topic->Id = $topicId;
	  if(!\Controllers\Topics::View($topic))
	  {
		$this->setHTTPStatusCode(404);
		exit();
	  }
		$topic->Views = $topic->Views + 1;
		\Controllers\Topics::Edit($topic);
	  	$search = new \Models\Search();
	    $search->Topic = $topicId;
		$posts = \Controllers\Posts::ListBy($search);
		$this->_context->PostCount = count($posts);
		$this->_context->Posts = $posts;
		$this->_context->Topic = $topic;

		$this->addPartial("viewTopic", "Topics/topic-template");
		$this->setTemplate('Topics/view');
		
    }
  }

  public function ListTopics()
  {

    if(!is_numeric($page = \Common\GetLastPhrase($_SERVER['REQUEST_URI'])))
      $page = 1;

    $search = new \Models\Search();
    $search->Limit = 10;
    $search->SortField = 'Name';
    $search->SortDirection = -1;
    $search->Skip = $search->Limit * ($page-1);

    $Topics = \Controllers\Topics::ListBy($search);

    $search = new \Models\Search();

    foreach($Topics['Items'] as &$Topic)
    {
      $search->Topic = $Topic->Name;
      $Topic->PostCount = \Controllers\Topics::CountBy($search);
    }

    $totalPages = 1;
    $totalPages = ceil($Topics['Count'] / $search->Limit);

    $this->_context->Topics = $Topics;
 

    $this->addPartial('header', 'public/header');
    $this->addPartial('footer', 'public/footer');
    //$this->addPartial('TopicPaging', 'Topics/Topic-paging');
    //$this->addPartial('viewTopic', 'Topics/Topic-template');

    //$this->setTemplate('Topics/list');
  }
}

  ?>
