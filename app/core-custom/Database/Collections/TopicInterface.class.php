<?php
/*---------------------------------------------------------------------------
  PostInterface								2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Database\Collections
  Class		: PostInterface
  -	Interface to PostInterface methods
---------------------------------------------------------------------------*/
namespace Database\Collections;

interface TopicInterface extends ModelInterface
{
  public function LoadByName(\Models\Topic $topic);
  public function ListBy(\Models\Search $search);
}
?>
