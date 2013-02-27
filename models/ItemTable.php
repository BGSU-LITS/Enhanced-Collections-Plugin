<?php

class ItemTable extends Table_Item
{
	/**
	 * Finds the number of featured items from the given collection.
	 *
	 * @param  int  $id  The collection id
	 * @param  int  $num The number of featured items to find
	 * @return array         Result set
	 */
	public function findRandomFeatured($id, $limit = 5)
	{
		$params = array(
			'featured' => 1, 
			'sort_field' => 'random', 
			'hasImage' => true
		);

		$select = $this->getSelectForFindBy($params);
		if ($limit) {
			$this->applyPagination($select, $limit, null);
		}

		$select->where('items.collection_id = ?', $id);
		return $this->fetchObjects($select);
	}

	/**
	 * Finds the most recent items from a given collection.
	 *
	 * @param  int $id  The collection id
	 * @param  int $num The number of items to find
	 * @return array    Result set
	 */
	public function findRecentInCollection($id, $limit = 10)
	{
		$params = array(
			'sort_field' => 'added',
			'sort_dir' => 'd'
		);

		$select = $this->getSelectForFindBy($params);
		if ($limit) {
			$this->applyPagination($select, $limit, null);
		}

		$select->where('items.collection_id = ?', $id);
		return $this->fetchObjects($select);
	}

}
