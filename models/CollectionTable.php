<?php

class CollectionTable extends Table_Collection
{
	/**
	 * Pull a random number of featured collections.
	 *
	 * @param  int  $num   The number of random collections to pull
	 * @return 
	 */
	public function findRandomFeaturedNum($limit)
	{
		$select = $this->getSelect()->where('collections.featured = 1')->order('RAND()')->limit($limit);
		return $this->fetchObjects($select);  
	}

}

