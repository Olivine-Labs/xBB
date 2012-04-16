<?php
/*---------------------------------------------------------------------------
  Posts										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Controllers
  Class		  : Posts
---------------------------------------------------------------------------*/
namespace Controllers;

class Posts
{ 
  public static function View(\Models\Post $post)
  {
    $database       = \Database\Controller::getInstance();
    return $database->Posts->Load($post);
  }
  
  public static function ListBy(\Models\Search $search)
  {
    return \Database\Controller::getInstance()->Posts->ListBy($search);
  }
  
  public static function Add(\Models\Post $post)
  {
    $session = \Classes\SessionHandler::getSession();
    //if(array_key_exists(\Models\Session::FIELD_USER, $session->Data))
    //{
      $database = \Database\Controller::getInstance();

      $post->PostedOn = time();
      //$post->PostedBy = $session->Data[\Models\Session::FIELD_USER]['Id'];
      //$post->PostedByName = $session->Data[\Models\Session::FIELD_USER]['UserName'];

	  if($post->Verify())
      {
        return $database->Posts->Save($post);
      }
    //} 

    return false;
  }

  public static function Edit(\Models\Post $post)
  {
    $tempPost = new \Models\Post();
    $tempPost->Id      = $post->Id;

    $session = \Classes\SessionHandler::getSession();
    if(array_key_exists(\Models\Session::FIELD_USER, $session->Data))
    {
      $database = \Database\Controller::getInstance();
      if($database->Posts->Load($tempPost))
      {
        $boardName = \Common\GetBoard();
        $board = new \Models\Board();
        $board->Name = $boardName;

        $user = new \Models\User();
        $user->Id = $session->Data[\Models\Session::FIELD_USER]['Id'];

        if($tempPost->PostedBy == $session->Data[\Models\Session::FIELD_USER]['Id'] || \Controllers\Domains::CheckModerator($user, $domain) || \Controllers\Domains::CheckAdministrator($user, $domain))
        {
          if($post->Verify())
          {
            return $database->Posts->Save($post);
          }
        }
      }
    }

    return false;
  }

  public static function Delete(\Models\Post $post)
  {
    $database = \Database\Controller::getInstance();
    return $database->Posts->Remove($post);
  }
  }
?>
