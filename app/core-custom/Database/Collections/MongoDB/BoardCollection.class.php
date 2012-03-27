<?php
/*---------------------------------------------------------------------------
  BoardCollection								2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Database\Collections\MongoDB
  Class		  : BoardCollection
  -	Class containing methods to access domains in MongoDB
---------------------------------------------------------------------------*/
namespace Database\Collections\MongoDB;

class BoardCollection extends Collection implements \Database\Collections\BoardInterface
{
  const	FIELD_NAME            = 'Name';
  const	FIELD_MODERATORS      = 'Moderators';
  const	FIELD_ADMINISTRATORS  = 'Administrators';
  const FIELD_TITLE           = 'Title';
  const FIELD_DESCRIPTION     = 'Description';

  public function LoadByName(\Models\Board $board)
  {
    $data = $this->Collection->findOne(array(
      self::FIELD_NAME => $board->Name
    ));
    if($data)
    {
      self::fill($board, $data);
      return true;
    }
    else
    {
      return false;
    }
  }

  public function ListBy(\Models\Search $search)
  {
    $fields = array();
    $searchArray = array();

    if($search->Board)
    {
      $searchArray[] = array(self::FIELD_NAME => new \MongoRegex(str_replace(".", "\\.", "/.*".$search->Board."/")));
    }

	$this; //WAT WHY DOES THIS WORK?
    if(count($searchArray) > 1)
    {
      $searchArray = array('$and'=>$searchArray);
    }
    else if($searchArray)
    {
      $searchArray = $searchArray[0];
    }
	
    $data = $this->Collection->find($searchArray, $fields);

    if($search->SortField !== null)
      $data = $data->sort(array($search->SortField => $search->SortDirection));

    $data = $data->limit($search->Limit)->skip($search->Skip);

    $result = array('Count'=>0, 'Items'=>array());

    if($data)
    {
      $result['Count'] = $data->count();
      foreach($data as $board)
      {
        $aDomain = new \Models\Board();
        $this->fill($aDomain, $board);
        $result['Items'][] = $aDomain;
      }
    }

    return $result;
  }

  private static function BuildSearchForTree(\Models\Board $board)
  {
    $sub = $board->Name;
    $searchArray = array();

    while($sub != "")
    {
      $explosion = explode(".", $sub, 2);

      $searchArray[] = array(self::FIELD_NAME => $sub);

      if(count($explosion) > 1){
        $sub = array_pop($explosion);
      }else{
        $sub = "";
      }
    }

    if(count($searchArray) > 1)
      $searchArray = array('$or' => $searchArray);
    else if($searchArray)
      $searchArray = $searchArray[0];

    return $searchArray;
  }

  public function CheckModerator($user, \Models\Board $board)
  {
    $searchArray[] = self::BuildSearchForTree($board);

    $searchArray[] = array(self::FIELD_MODERATORS=>array('$all'=>array($user->Id)));

    if(count($searchArray) > 1)
      $searchArray = array('$and' =>$searchArray);
    else if($searchArray)
      $searchArray = $searchArray[0];

    $data = $this->Collection->find($searchArray);

    if($data->count() > 0)
      return true;
    else
      return false;
  }

  public function CheckAdministrator($user, \Models\Board $board)
  {
    $searchArray[] = self::BuildSearchForTree($board);

    $searchArray[] = array(self::FIELD_ADMINISTRATORS=>array('$all'=>array($user->Id)));

    if(count($searchArray) > 1)
      $searchArray = array('$and' =>$searchArray);
    else if($searchArray)
      $searchArray = $searchArray[0];

    $data = $this->Collection->find($searchArray);

    if($data->count() > 0)
      return true;
    else
      return false;
  }

  public function CheckAccess($user, \Models\Board $board)
  {
    $searchArray[] = self::BuildSearchForTree($board);
    $a = array(self::FIELD_WHITELIST=>array('$in'=> array($user->Id)));
    $b = array(self::FIELD_WHITELIST=>array('$size'=> 0));
    $c = array(self::FIELD_BLACKLIST=>array('$nin'=> array($user->Id)));
    $d = array(self::FIELD_BLACKLIST=>array('$size'=> 0));

    $searchArray[] = array('$or'=>array(array('$and'=>array($a, $c)),array('$and'=>array($b, $c)),array('$and'=>array($a, $d)),array('$and'=>array($b, $d))));

    if(count($searchArray) > 1)
      $searchArray = array('$and'=>$searchArray);
    else if($searchArray)
      $searchArray = $searchArray[0];

    $data = $this->Collection->find($searchArray);

    if($data->count() > 0)
      return true;
    else
      return false;
  }
}
?>
