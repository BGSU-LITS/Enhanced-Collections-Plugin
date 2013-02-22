<?php

/** Why aren't Omeka controllers autoloaded?? */
require_once CONTROLLER_DIR.'/CollectionsController.php';

/**
 * Taking control of the page!!
 *
 * @author  Dave Widmer <dave@davewidmer.net>
 */
class EnhancedCollections_CollectionsController extends CollectionsController
{
	public function settingsAction()
	{
		$collection = $this->_helper->db->findById();
		$enhanced = $this->_helper->db->getTable('EnhancedCollection')->find($collection->id);

		if ($this->getRequest()->isPost())
		{
			$enhanced = $this->handleSettingsPost($enhanced, $this->getRequest()->getPost(), $collection);
		}

		$this->view->collection = $collection;
		$this->view->themes = $this->getThemes();

		$this->view->settings = $enhanced ? $enhanced->toArray() : $this->getDefaults();
	}

	/**
	 * Gets theme defaults.
	 *
	 * @return array
	 */
	public function getDefaults()
	{
		return array(
			'slug' => "",
			'per_page' => get_option('per_page_public'),
			'theme' => ""
		);
	}

	/**
	 * Saves the posted data to the database.
	 *
	 * @param  EnhancedCollection $enhanced   The enhanced collection to update settings on.
	 * @param  array              $data       The posted data
	 * @param  Collection         $collection The collection object for messages
	 * @return EnhancedCollection             The modified collection object
	 */
	protected function handleSettingsPost($enhanced, array $data, $collection)
	{
		unset($data['submit']);
		$enhanced->setPostData($data);

		if ($enhanced->save(false))
		{
			$message = $this->_getEditSuccessMessage($collection);

			if ($message !== '') 
			{
				$this->_helper->flashMessenger($message, 'success');
			}

			$this->_helper->redirector->gotoRoute(array(
				'controller' => 'collections',
				'action' => 'index'
			), 'default');
		}
		else
		{
			$this->_helper->flashMessenger($enhanced->getErrors());
		}

		return $enhanced;
	}

	/**
	 * Gets an array of the available themes
	 *
	 * @return  array
	 */
	protected function getThemes()
	{
		$themes = array('' => "Current Public Theme");

		foreach (Theme::getAllThemes() as $name => $theme)
		{
			$themes[$name] = $theme->title;
		}

		return $themes;
	}
}
