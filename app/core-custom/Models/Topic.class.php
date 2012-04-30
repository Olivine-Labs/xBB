<?php
/*---------------------------------------------------------------------------
  Topic										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Models
  Class		: Topic
---------------------------------------------------------------------------*/
namespace Models;

class Topic extends Model
{

  public  $Board	   = null;
  public  $Name   	   = null;
  public $Views = null;

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