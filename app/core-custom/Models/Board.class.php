<?php
/*---------------------------------------------------------------------------
  Board										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Models
  Class		  : Board
---------------------------------------------------------------------------*/
namespace Models;

class Board extends Model
{
  public		$Name   	        = null;
  public		$Description   	        = null;
  public		$Moderators	      = array();
  public        $ParentBoard = null;
  public function __construct()
  {
    parent::__construct();
  }

  public function Verify()
  {
    $this->Name = trim($this->Name);
    if(
      ((strlen($this->Name)		      > 0)  || (!isset($this->Name)))
    )
    return true;

    return false;
  }
}
?>
