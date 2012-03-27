<?php
/*---------------------------------------------------------------------------
  PostInterface								2011 Olivine Labs
-----------------------------------------------------------------------------
  Namespace	: Database\Collections
  Class		: PostInterface
  -	Interface to PostInterface methods
---------------------------------------------------------------------------*/
namespace Database\Collections;

interface PostInterface extends ModelInterface
{
  public function ListBy(\Models\Search $search);
  public function CountBy(\Models\Search $search);
}
?>
