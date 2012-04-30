<?php
/*---------------------------------------------------------------------------
  Users										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Models
  Class		  : Users
---------------------------------------------------------------------------*/
namespace Models;

class User extends Model
{
  public		$UserName	  = null;
  public		$Password		= null;
  public		$Email			= null;
  public    $Profile    = null;
  public    $Token      = null;
  public    $UserId      = null;
  public    $IsAdmin = null;

  public function __construct()
  {
    parent::__construct();
    $this->Profile = new Profile();
  }

  public function Verify()
  {
    if(
      ((strlen($this->UserName) > 0) || (!isset($this->UserName))) &&
      ((strlen($this->Password)	> 0) || (!isset($this->Password))) &&
      ((strlen($this->Email)		> 0) || (!isset($this->Email)))
    )
    return true;
    return false;
  }
}