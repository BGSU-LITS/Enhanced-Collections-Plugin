<?php

/**
 * The Enhanced Collection model
 *
 * @package  Enhanced Collection
 * @author   Dave Widmer <dwidmer@bgsu.edu>
 */
class EnhancedCollection extends Omeka_Record_AbstractRecord
{
	/**
	 * @var string
	 */
	public $slug;

	/**
	 * @var int     The number of records to display per page
	 */
	public $per_page;

	/**
	 * @var string  The name of the theme to display
	 */
	public $theme;
}
