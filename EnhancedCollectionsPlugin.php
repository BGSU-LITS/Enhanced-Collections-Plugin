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
	protected $_filters = array();

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

}
