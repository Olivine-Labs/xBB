<?php
/*---------------------------------------------------------------------------
  Domain										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Models
  Class		  : Domain
---------------------------------------------------------------------------*/
namespace Models;

class Domain extends Model
{
  public		$Name   	        = null;
  public		$Administrators		= array();
  public		$Moderators	      = array();
  public    $Posts            = array();

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
