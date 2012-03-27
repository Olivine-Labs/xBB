<?php
/*---------------------------------------------------------------------------
  Boards										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Controllers
  Class		  :Boards
---------------------------------------------------------------------------*/
namespace Controllers;

class Boards
{ 
  public static function View(\Models\Board $board)
  {
    $database       = \Database\Controller::getInstance();

    if($board->Id)
      return $database->Boards->Load($board);

    if($board->Name)
      return $database->Boards->LoadByName($board);
  }
  
  public static function ListBy(\Models\Search $search)
  {
    return \Database\Controller::getInstance()->Boards->ListBy($search);
  }

  public static function Delete(\Models\Board $board)
  {
    return \Database\Controller::getInstance()->Boards->Remove($board);
  }

  public static function Add(\Models\Board $board)
  {
    $session = \Classes\SessionHandler::getSession();
    if(array_key_exists(\Models\Session::FIELD_USER, $session->Data))
    {
      $database = \Database\Controller::getInstance();
      if(!$database->Boards->LoadByName($board))
      {
        $user = $session->Data[\Models\Session::FIELD_USER];
        $board->Administrators[] = $user['Id'];
        return $database->Boards->Save($board);
      }
    } 
    return false;
  }

  public static function Edit(\Models\Board $board)
  {
    if($board->Verify())
    {
      return \Database\Controller::getInstance()->Boards->Save($board);
    }
    return false;
  }

  public static function CheckAdministrator($user, \Models\Board $board)
  {
    return \Database\Controller::getInstance()->Boards->CheckAdministrator($user, $board);
  }

  public static function CheckModerator($user, \Models\Board $board)
  {
    return \Database\Controller::getInstance()->Boards->CheckModerator($user, $board);
  }

  public static function CheckAccess($user, \Models\Board $board)
  {
    return \Database\Controller::getInstance()->Boards->CheckAccess($user, $board);
  }
}
?>
