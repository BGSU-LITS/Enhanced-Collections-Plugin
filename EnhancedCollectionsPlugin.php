<?php

/**
 * Enhanced Collections Plugin
 *
 * @author    Dave Widmer <dwidmer@bgsu.edu>
 */
class EnhancedCollectionsPlugin extends Omeka_Plugin_AbstractPlugin
{
	/**
	 * @var array  All of the hooks used in this plugin
	 */
	protected $_hooks = array('install', 'config', 'config_form', 'uninstall',
		'define_routes');

	/**
	 * @var array  The filters used in this plugin.
	 */
	protected $_filters = array();

	/**
	 * Installation hook.
	 */
	public function hookInstall()
	{
		$this->_installOptions();
	}

	/**
	 * Uninstalls any options that have been set.
	 */
	public function hookUninstall()
	{
		$this->_uninstallOptions();
	}

	/**
	 * Set the options from the Config form.
	 */
	public function hookConfig()
	{
		foreach (array_keys($this->_options) as $key)
		{
			set_option($key, trim($_POST[$key]));
		}
	}

	/**
	 * Displays the configuration form.
	 */
	public function hookConfigForm()
	{
		require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'views'. DIRECTORY_SEPARATOR . 'config_form.php';
	}

	/**
	 * Add some routes to the flow to override the default user actions.
	 *
	 * @param  array $args  The route arguments
	 * @return [type] [description]
	 */
	public function hookDefineRoutes($args)
	{

	}

}
