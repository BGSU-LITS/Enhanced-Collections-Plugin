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

	/**
	 * Template method for defining record validation rules.
	 */
	protected function _validate()
	{
		$errors = array();

		if ($this->per_page === "")
		{
			$errors[] = __('Please enter the number of results per page');
		}

		if ( ! Zend_Validate::is($this->per_page, 'Digits'))
		{
			$errors[] = __('Results per page must be a number');
		}

		if ( ! Zend_Validate::is($this->per_page, 'GreaterThan', array('min' => 0)))
		{
			$errors[] = __('You must display at least 1 result per page');
		}

		if ( ! empty($errors))
		{
			$this->addError('results_per_page', join("\n", $errors));
		}
	}
}
