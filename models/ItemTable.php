<?php

class ItemTable extends Table_Item
{
	/**
	 * Finds the number of featured items from the given collection.
	 *
	 * @param  int  $id  The collection id
	 * @param  int  $num The number of featured items to find
	 * @return           Result set
	 */
	public function findRandomFeatured($id, $limit = 5, $page = null)
	{
		$params = array(
			'featured' => 1, 
			'sort_field' => 'random', 
			'hasImage' => true
		);

		$select = $this->getSelectForFindBy($params);
		if ($limit) {
			$this->applyPagination($select, $limit, $page);
		}

		$select->where('items.collection_id = ?', $id);
		return $this->fetchObjects($select);
	}

}
