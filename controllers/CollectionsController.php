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

		if ($this->getRequest()->isPost())
		{
			$collection = $this->handleSettingsPost($collection, $this->getRequest()->getPost());
		}

		$this->view->collection = $collection;
		$this->view->themes = $this->getThemes();

		// Pull this from the DB...
		$this->view->settings = array(
			'slug' => "",
			'per_page' => 10,
			'theme' => ""
		);
	}

	/**
	 * Saves the posted data to the database.
	 *
	 * @param  Collection $collection The collection to update settings on.
	 * @param  array      $data       The posted data
	 * @return Collection             The modified collection object
	 */
	protected function handleSettingsPost($collection, array $data)
	{
		$collection->setPostData($data);

		if ($record->save(false))
		{
			$message = $this->_getEditSuccessMessage($collection);

			if ($message !== '') 
			{
				$this->_helper->flashMessenger($message, 'success');
			}

			$this->_redirectAfterEdit($collection);
		}
		else
		{
			$this->_helper->flashMessenger($collection->getErrors());
		}

		return $collection;
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
