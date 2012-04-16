<?php
/*---------------------------------------------------------------------------
  TopicCollection								2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Database\Collections\MongoDB
  Class		  : TopicCollection
  -	Class containing methods to access domains in MongoDB
---------------------------------------------------------------------------*/
namespace Database\Collections\MongoDB;

class TopicCollection extends Collection implements \Database\Collections\TopicInterface
{
  const	FIELD_NAME            = 'Name';
  const BOARD = 'Board';

  public function LoadByName(\Models\Topic $topic)
  {
    $data = $this->Collection->findOne(array(
      self::FIELD_NAME => $topic->Name
    ));
    if($data)
    {
      self::fill($topic, $data);
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
      $searchArray[] = array(self::BOARD => new \MongoRegex(str_replace(".", "\\.", "/.*".$search->Board."/")));
    }

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
      foreach($data as $topic)
      {
        $aDomain = new \Models\Topic();
        $this->fill($aDomain, $topic);
        $result['Items'][] = $aDomain;
      }
    }

    return $result;
  }
}
?>
