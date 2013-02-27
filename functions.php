<?php
/**
 * Gets the value for the given $_GET variable.
 *
 * @param  string $name The name of the $_GET variable.
 * @return string       The value or an empty string
 */
function input_get_value($name)
{
	return isset($_GET[$name]) ? $_GET[$name] : "";
}

/**
 * Get a passed in number of random featured collection.
 *
 * @param  int $num  The number of collections to get
 * @package Omeka\Function\View\Body
 * @uses Collection::findRandomFeatured()
 * @return Collection
 */
function get_random_featured_collections($num = 1)
{
	$table = new CollectionTable('Collection', get_db());
	return $table->findRandomFeaturedNum($num);
}

/**
 * Get random featured items from the collection
 * 
 * @package Omeka\Function\View\Body
 * @uses get_records()
 * @param int     $id  The collection id to search in
 * @param integer $num The maximum number of recent items to return
 * @param boolean|null $hasImage
 * @return array|Item
 */
function get_random_featured_items_in_collection($id, $num = 5)
{
	$table = new ItemTable('Item', get_db());
	return $table->findRandomFeatured($id, $num);
}

/**
 * Return HTML for random featured items.
 *
 * @package Omeka\Function\View\Body
 * @uses get_random_featured_items()
 * @param int $id      The collection id
 * @param int $count   The number of items to feature
 * @return string
 */
function random_featured_items_in_collection($id, $count = 5)
{
	return get_view()->partial(
		'items/random-featured.php',
		array('items' => get_random_featured_items_in_collection($id, $count), 'count' => $count)
	);
}

/**
 * Get the most recently added items in a given collection.
 *
 * @package Omeka\Function\View\Body
 * @uses Table_Item::findBy()
 * @param int     $id  The collection id
 * @param integer $num The maximum number of recent items to return
 * @return array
 */
function get_recent_items_in_collection($id, $num = 10)
{
	$table = new ItemTable('Item', get_db());
	return $table->findRecentInCollection($id, $num);
}
