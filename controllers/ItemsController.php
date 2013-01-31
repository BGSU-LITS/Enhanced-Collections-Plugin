<?php

require_once CONTROLLER_DIR.'/ItemsController.php';

/**
 * Taking control of the page!!
 *
 * @author  Dave Widmer <dave@davewidmer.net>
 */
class EnhancedCollections_ItemsController extends ItemsController
{
	/**
	 * Retrieve the number of items to display on any given browse page.
	 * This can be modified as a query parameter provided that a user is
	 * actually logged in.
	 *
	 * @return integer
	 */
	public function _getBrowseRecordsPerPage()
	{
		//Retrieve the number from the options table
		$options = $this->getFrontController()->getParam('bootstrap')->getResource('Options');

		if (is_admin_theme())
		{
			$perPage = (int) $options['per_page_admin'];
		}
		else
		{
			$id = $this->getRequest()->getParam('collection');
			if ($id !== null)
			{
				$collection = $this->_helper->db->getTable('EnhancedCollection')->find($id);
				if ($collection !== null)
				{
					$perPage = $collection->per_page;
				}
			}
			else
			{
				$perPage = (int) $options['per_page_public'];
			}
		}

		// If users are allowed to modify the # of items displayed per page,
		// then they can pass the 'per_page' query parameter to change that.
		if ($this->_helper->acl->isAllowed('modifyPerPage', 'Items') && ($queryPerPage = $this->getRequest()->get('per_page')))
		{
			$perPage = $queryPerPage;
		}

		if ($perPage < 1)
		{
			$perPage = null;
		}

		return $perPage;
	}
}
