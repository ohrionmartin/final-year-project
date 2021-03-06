<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			11th December, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		generalmedicalcheckupsfilterpatient.php
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
 * Generalmedicalcheckupsfilterpatient Form Field class for the Eclinic_portal component
 */
class JFormFieldGeneralmedicalcheckupsfilterpatient extends JFormFieldList
{
	/**
	 * The generalmedicalcheckupsfilterpatient field type.
	 *
	 * @var		string
	 */
	public $type = 'generalmedicalcheckupsfilterpatient';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// [Interpretation 17944] Get a db connection.
		$db = JFactory::getDbo();

		// [Interpretation 17949] Create a new query object.
		$query = $db->getQuery(true);

		// [Interpretation 17985] Select the text.
		$query->select($db->quoteName('patient'));
		$query->from($db->quoteName('#__eclinic_portal_general_medical_check_up'));
		$query->order($db->quoteName('patient') . ' ASC');

		// [Interpretation 17996] Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_ECLINIC_PORTAL_FILTER_SELECT_PATIENT') . ' -');

		if ($results)
		{
			$results = array_unique($results);
			foreach ($results as $patient)
			{
				// [Interpretation 18062] Now add the patient and its text to the options array
				$_filter[] = JHtml::_('select.option', $patient, JFactory::getUser($patient)->name);
			}
		}
		return $_filter;
	}
}
