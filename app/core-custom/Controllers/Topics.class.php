<?php
/*---------------------------------------------------------------------------
  Topics										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Controllers
  Class		  :Topics
---------------------------------------------------------------------------*/
namespace Controllers;

class Topics
{ 
  public static function View(\Models\Topic $Topic)
  {
    $database       = \Database\Controller::getInstance();

    if($Topic->Id)
      return $database->Topics->Load($Topic);

    if($Topic->Name)
      return $database->Topics->LoadByName($Topic);
  }
  
  public static function ListBy(\Models\Search $search)
  {
    return \Database\Controller::getInstance()->Topics->ListBy($search);
  }

  public static function Delete(\Models\Topic $Topic)
  {
    return \Database\Controller::getInstance()->Topics->Remove($Topic);
  }

  public static function Add(\Models\Topic $Topic)
  {
    $session = \Classes\SessionHandler::getSession();
    //if(array_key_exists(\Models\Session::FIELD_USER, $session->Data))
    //{
      $database = \Database\Controller::getInstance();
      if(!$database->Topics->LoadByName($Topic))
      {
        //$user = $session->Data[\Models\Session::FIELD_USER];
        //$Topic->Administrators[] = $user['Id'];
        return $database->Topics->Save($Topic);
      }
    //} 
    return false;
  }

  public static function Edit(\Models\Topic $Topic)
  {
    if($Topic->Verify())
    {
      return \Database\Controller::getInstance()->Topics->Save($Topic);
    }
    return false;
  }

  public static function CheckAccess($user, \Models\Topic $Topic)
  {
    return \Database\Controller::getInstance()->Topics->CheckAccess($user, $Topic);
  }
}
?>
