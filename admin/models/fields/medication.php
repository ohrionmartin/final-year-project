<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			29th November, 2020
	@created		13th August, 2020
	@package		eHealth Portal
	@subpackage		medication.php
	@author			Oh Martin <https://vdm.io>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Medication Form Field class for the Ehealth_portal component
 */
class JFormFieldMedication extends JFormFieldList
{
	/**
	 * The medication field type.
	 *
	 * @var		string
	 */
	public $type = 'medication';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Get the databse object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.name'),array('id','medication_name')));
		$query->from($db->quoteName('#__ehealth_portal_medication', 'a'));
		$query->where($db->quoteName('a.published') . ' = 1');
		$query->order('a.name ASC');
		// Implement View Level Access (if set in table)
		if (!$user->authorise('core.options', 'com_ehealth_portal'))
		{
			$columns = $db->getTableColumns('#__ehealth_portal_medication');
			if(isset($columns['access']))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}
		}
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$options[] = JHtml::_('select.option', '', 'Select an option');
			foreach($items as $item)
			{
				$options[] = JHtml::_('select.option', $item->id, $item->medication_name);
			}
		}
		return $options;
	}
}
