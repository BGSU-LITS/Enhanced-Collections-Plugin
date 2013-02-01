<?php

/**
 * Enhanced Collections Plugin
 *
 * @author    Dave Widmer <dwidmer@bgsu.edu>
 */
class EnhancedCollectionsPlugin extends Omeka_Plugin_AbstractPlugin
{
	/**
	 * @var string  The current version of the plugin
	 */
	protected $version = "0.1.0";

	/**
	 * @var array  All of the hooks used in this plugin
	 */
	protected $_hooks = array('install', 'uninstall', 'define_routes',
		'admin_collections_browse_each'
	);

	/**
	 * @var array  The filters used in this plugin.
	 */
	protected $_filters = array('public_theme_name', 'public_navigation_items');

	/**
	 * @var string  The name of the theme...
	 */
	private $theme_name = null;

	/**
	 * Installation hook.
	 */
	public function hookInstall()
	{
		$db = get_db();

		$sql = "CREATE TABLE IF NOT EXISTS `{$db->prefix}enhanced_collections` (
			`id` int(10) unsigned NOT NULL,
			`slug` varchar(255) NOT NULL,
			`theme` varchar(100) NOT NULL,
			`per_page` smallint(5) unsigned NOT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8";

		$db->query($sql);

		$per_page = get_option('per_page_public');

		$records = $db->getTable('Collection')->findAll();
		foreach ($records as $row)
		{
			$collection = new EnhancedCollection;
			$collection->setArray(array(
				'id' => $row->id,
				'slug' => "",
				'per_page' => $per_page,
				'theme' => ""
			));

			$collection->save();
		}

		$this->_installOptions();
	}

	/**
	 * Uninstalls any options that have been set.
	 */
	public function hookUninstall()
	{
		$db = get_db();
		$db->query("DROP TABLE IF EXISTS `{$db->prefix}enhanced_collections`");

		$this->_uninstallOptions();
	}

	/**
	 * Add in routes.ini
	 *
	 * @param  array $args  The route arguments
	 */
	public function hookDefineRoutes($args)
	{
		$router = $args['router'];

		$path = dirname(__FILE__).DIRECTORY_SEPARATOR.'routes.ini';
		$router->addConfig(new Zend_Config_Ini($path, 'routes'));
	}

	/**
	 * Add a settings link to the browse screen.
	 *
	 * @param array $args  An array holding the current collection object
	 */
	public function hookAdminCollectionsBrowseEach($args)
	{
		$collection = $args['collection'];

		if (is_allowed($collection, 'edit'))
		{
			echo link_to_collection(__("Settings"), array(), 'settings', $collection);
		}
	}

	/**
	 * Intercept the name of the public theme.
	 *
	 * @param  string $name The name of the current theme
	 * @return string       The name of the theme
	 */
	public function filterPublicThemeName($name)
	{
		if ($this->theme_name === null)
		{
			$id = $this->getCollectionId();
			if ($id !== null)
			{
				$db = get_db();
				$collection = $db->getTable('EnhancedCollection')->find($id);

				if ( $collection !== null && ! empty($collection->theme))
				{
					$this->theme_name = $collection->theme;
				}
			}

			if ($this->theme_name === null)
			{
				$this->theme_name = $name;
			}
		}

		return $this->theme_name;
	}

	/**
	 * Check for a collection and append it to the links.
	 *
	 * @param  array $links The current links
	 * @return array        Navigation links
	 */
	public function filterPublicNavigationItems($links)
	{
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$id = $request->getParam('collection');

		if ($id !== null)
		{
			for ($i = 0, $len = count($links); $i < $len; $i++)
			{
				$links[$i]['uri'] = $links[$i]['uri']."?".http_build_query(array('collection' => $id));
			}
		}

		return $links;
	}

	/**
	 * The id number of the current collection.
	 *
	 * @return int|null   The collection id number or null if this isn't a collection page.
	 */
	protected function getCollectionId()
	{
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		$id = null;

		if ($controller === 'collections' && $action === 'show')
		{
			$id = $request->getParam('id');
		}
		else if ($controller === 'items')
		{
			if (in_array($action, array('browse', 'tags', 'search')) === true)
			{
				$id = $request->getParam('collection');
			}
			else if ($action === 'show')
			{
				$id = $this->getCollectionIdFromItem($request->getParam('id'));
			}
		}

		return $id;
	}

	/**
	 * Find the id of the collection that the given item is apart of.
	 *
	 * @param  int $id   The item id
	 * @return int|null  The collection id or null
	 */
	protected function getCollectionIdFromItem($id)
	{
		$db = get_db();
		return $db->getTable('Item')->find($id)->collection_id;
	}

}
