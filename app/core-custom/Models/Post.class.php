<?php
/*---------------------------------------------------------------------------
  Quote										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Models
  Class		: Quote
---------------------------------------------------------------------------*/
namespace Models;

class Post extends Model
{
  public	$PostedBy			= null;
  public	$PostedOn			= null;
  public	$PostedByName	= null;
  public	$Body				  = null;
  public  $Topic       = null;

  public function __construct()
  {
    parent::__construct();
    $this->PostedOn = time();
  }

  public static function CleanString($string)
  {
    return preg_replace("!\\b\\w{1,2}\\b!", "", str_replace('-', '', preg_replace("/[^a-z0-9\s-]/", " ", strtolower($string))));
  }

  public function Verify()
  {
    $this->Body = trim($this->Body);

    if(
      ((strlen($this->Body)		      > 0)  || (!isset($this->Body))) &&
      ((strlen($this->PostedOn)	    > 0)  || (!isset($this->PostedOn))) &&
      ((strlen($this->PostedByName)	> 0)  || (!isset($this->PostedByName))) &&
      ((strlen($this->PostedBy)		  > 0)  || (!isset($this->PostedBy)))
    ){
      return true;
    }

    return false;
  }

  public function FormattedPostedOn()
  {
    return date('c', $this->PostedOn);
  }
  
    public function ReadablePostedOn()
  {
    return date('F jS Y g:i A', $this->PostedOn);
  }
}
?>