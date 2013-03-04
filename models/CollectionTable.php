<?php

class CollectionTable extends Table_Collection
{
	/**
	 * Get a number of featured collections.
	 *
	 * @param  int  $num  The number of collections to find
	 * @return array      Result set
	 */
	public function findFeatured($limit)
	{
		$select = $this->getSelect()->where('collections.featured = 1')->order('added DESC')->limit($limit);
		return $this->fetchObjects($select);
	}

	/**
	 * Pull a random number of featured collections.
	 *
	 * @param  int  $num  The number of random collections to pull
	 * @return array      Result set
	 */
	public function findRandomFeaturedNum($limit)
	{
		$select = $this->getSelect()->where('collections.featured = 1')->order('RAND()')->limit($limit);
		return $this->fetchObjects($select);  
	}

}

