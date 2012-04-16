<?php
/*---------------------------------------------------------------------------
  Quote										2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Models
  Class		: Search
---------------------------------------------------------------------------*/
namespace Models;

class Search extends Model
{
  public	$SortField			  = null;
  public	$SortDirection		= 1;
  public	$Limit				    = 10;
  public	$Skip				      = 0;
  public  $Board           = null;
  public $Topic            = null;
  public  $PostedBy         = null;
  public  $PostedByName     = null;

  public function __construct()
  {
    parent::__construct();
  }
}
?>
