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
		var_dump('Creating the collections_enhanced database'); die;
		$this->_installOptions();
	}

	/**
	 * Uninstalls any options that have been set.
	 */
	public function hookUninstall()
	{
		var_dump('Dropping the collections_enhanced database'); die;
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
