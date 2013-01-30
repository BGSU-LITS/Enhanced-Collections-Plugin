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
	public function editAction()
	{
		var_dump('editing holmes!'); die;
	}
}
