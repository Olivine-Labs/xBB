<?php
/*---------------------------------------------------------------------------
  BoardInterface								2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Database\Collections
  Class		  : BoardInterface
  -	Interface to BoardInterface methods
---------------------------------------------------------------------------*/
namespace Database\Collections;

interface BoardInterface extends ModelInterface
{
  public function LoadByName(\Models\Board $board);
  public function ListBy(\Models\Search $search);
  public function CheckModerator($user, \Models\Board $board);
  public function CheckAdministrator($user, \Models\Board $board);
  public function CheckAccess($user, \Models\Board $board);
}
?>
