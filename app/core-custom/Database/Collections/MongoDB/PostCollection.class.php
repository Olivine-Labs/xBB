<?php
/*---------------------------------------------------------------------------
  PostCollection								2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Database\Collections\MongoDB
  Class		: PostCollection
  -	Class containing methods to access Quotes in MongoDB
---------------------------------------------------------------------------*/
namespace Database\Collections\MongoDB;

class PostCollection extends Collection implements \Database\Collections\PostInterface
{
  const FIELD_POSTEDBY      = 'PostedBy';
  const FIELD_POSTEDON      = 'PostedOn';
  const FIELD_POSTEDBYNAME  = 'PostedByName';
  const FIELD_BODY          = 'Body';
  const FIELD_TOPIC        = 'Topic';

  protected function toArray(\Models\Model $model)
  {
    $result = parent::toArray($model);
    $result[self::FIELD_POSTEDON] = new \MongoDate($result[self::FIELD_POSTEDON]);
    return $result;
  }

  public function ListBy(\Models\Search $search)
  {
    $fields = array();
    $searchArray = array();
	
    if($search->PostedBy)
    {
      $searchArray[] = array(self::FIELD_POSTEDBY => $search->PostedBy);
    }

    if($search->PostedByName)
    {
      $searchArray[] = array(self::FIELD_POSTEDBYNAME => $search->PostedByName);
    }
	
    if($search->Topic)
    {
      $searchArray[] = array(self::FIELD_TOPIC => new \MongoRegex(str_replace(".", "\\.", "/.*".$search->Topic."/")));
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
      foreach($data as $post)
      {
        $aQuote = new \Models\Post();
        $this->fill($aQuote, $post);
        $result['Items'][] = $aQuote;
      }
    }

    return $result;
  }

  public function CountBy(\Models\Search $search)
  {
    $fields = array();
    $searchArray = array();

    if($search->Keywords)
    {
      foreach($search->Keywords AS &$Keyword)
      {
        $Keyword = new \MongoRegex('/'.$Keyword.'/i');
      }
      $searchArray[] = array(self::FIELD_KEYWORDS => array('$all' => $search->Keywords));
    }

    if($search->PostedBy)
    {
      $searchArray[] = array(self::FIELD_POSTEDBY => $search->PostedBy);
    }

    if($search->PostedByName)
    {
      $searchArray[] = array(self::FIELD_POSTEDBYNAME => $search->PostedByName);
    }

    if($search->Domain)
    {
      $searchArray[] = array(self::FIELD_DOMAIN => $search->Domain);
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

    return $data->count();
  }
}
?>
