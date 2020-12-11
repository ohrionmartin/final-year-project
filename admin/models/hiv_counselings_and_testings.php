<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			11th December, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		hiv_counselings_and_testings.php
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

use Joomla\Utilities\ArrayHelper;

/**
 * Hiv_counselings_and_testings Model
 */
class Eclinic_portalModelHiv_counselings_and_testings extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
        {
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
				'a.access','access',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'a.patient','patient'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		// [Interpretation 21141] Check if the form was submitted
		$formSubmited = $app->input->post->get('form_submited');

		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		if ($formSubmited)
		{
			$access = $app->input->post->get('access');
			$this->setState('filter.access', $access);
		}

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		$this->setState('filter.created', $created);

		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$patient = $this->getUserStateFromRequest($this->context . '.filter.patient', 'filter_patient');
		if ($formSubmited)
		{
			$patient = $app->input->post->get('patient');
			$this->setState('filter.patient', $patient);
		}

		// List state information.
		parent::populateState($ordering, $direction);
	}
	
	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 */
	public function getItems()
	{
		// [Interpretation 21363] check in items
		$this->checkInNow();

		// load parent items
		$items = parent::getItems();

		// [Interpretation 22354] set selection value to a translatable value
		if (Eclinic_portalHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// [Interpretation 22368] convert counseling_type
				$item->counseling_type = $this->selectionTranslation($item->counseling_type, 'counseling_type');
				// [Interpretation 22368] convert last_test_date
				$item->last_test_date = $this->selectionTranslation($item->last_test_date, 'last_test_date');
				// [Interpretation 22368] convert prev_test_result
				$item->prev_test_result = $this->selectionTranslation($item->prev_test_result, 'prev_test_result');
				// [Interpretation 22368] convert test_result_one
				$item->test_result_one = $this->selectionTranslation($item->test_result_one, 'test_result_one');
				// [Interpretation 22368] convert test_result_two
				$item->test_result_two = $this->selectionTranslation($item->test_result_two, 'test_result_two');
				// [Interpretation 22368] convert final_test_result
				$item->final_test_result = $this->selectionTranslation($item->final_test_result, 'final_test_result');
				// [Interpretation 22368] convert eqa
				$item->eqa = $this->selectionTranslation($item->eqa, 'eqa');
			}
		}

        
		// return items
		return $items;
	}

	/**
	 * Method to convert selection values to translatable string.
	 *
	 * @return translatable string
	 */
	public function selectionTranslation($value,$name)
	{
		// [Interpretation 22408] Array of counseling_type language strings
		if ($name === 'counseling_type')
		{
			$counseling_typeArray = array(
				0 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_INDIVIDUAL',
				1 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_COUPLE',
				2 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_MINOR'
			);
			// [Interpretation 22445] Now check if value is found in this array
			if (isset($counseling_typeArray[$value]) && Eclinic_portalHelper::checkString($counseling_typeArray[$value]))
			{
				return $counseling_typeArray[$value];
			}
		}
		// [Interpretation 22408] Array of last_test_date language strings
		if ($name === 'last_test_date')
		{
			$last_test_dateArray = array(
				0 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_ONESIX_MONTHS',
				1 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_SEVENTWELVE_MONTHS',
				2 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING__YEAR',
				3 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NEVER'
			);
			// [Interpretation 22445] Now check if value is found in this array
			if (isset($last_test_dateArray[$value]) && Eclinic_portalHelper::checkString($last_test_dateArray[$value]))
			{
				return $last_test_dateArray[$value];
			}
		}
		// [Interpretation 22408] Array of prev_test_result language strings
		if ($name === 'prev_test_result')
		{
			$prev_test_resultArray = array(
				0 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NEGATIVE',
				1 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_POSITIVE',
				2 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_UNKNOWN',
				3 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NA'
			);
			// [Interpretation 22445] Now check if value is found in this array
			if (isset($prev_test_resultArray[$value]) && Eclinic_portalHelper::checkString($prev_test_resultArray[$value]))
			{
				return $prev_test_resultArray[$value];
			}
		}
		// [Interpretation 22408] Array of test_result_one language strings
		if ($name === 'test_result_one')
		{
			$test_result_oneArray = array(
				0 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_POSITIVE',
				1 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NEGATIVE',
				2 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_INCONCLUSIVE'
			);
			// [Interpretation 22445] Now check if value is found in this array
			if (isset($test_result_oneArray[$value]) && Eclinic_portalHelper::checkString($test_result_oneArray[$value]))
			{
				return $test_result_oneArray[$value];
			}
		}
		// [Interpretation 22408] Array of test_result_two language strings
		if ($name === 'test_result_two')
		{
			$test_result_twoArray = array(
				0 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_POSITIVE',
				1 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NEGATIVE',
				2 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_INCONCLUSIVE'
			);
			// [Interpretation 22445] Now check if value is found in this array
			if (isset($test_result_twoArray[$value]) && Eclinic_portalHelper::checkString($test_result_twoArray[$value]))
			{
				return $test_result_twoArray[$value];
			}
		}
		// [Interpretation 22408] Array of final_test_result language strings
		if ($name === 'final_test_result')
		{
			$final_test_resultArray = array(
				0 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NEGATIVE',
				1 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_POSITIVE',
				2 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_UNKNOWN',
				3 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NA'
			);
			// [Interpretation 22445] Now check if value is found in this array
			if (isset($final_test_resultArray[$value]) && Eclinic_portalHelper::checkString($final_test_resultArray[$value]))
			{
				return $final_test_resultArray[$value];
			}
		}
		// [Interpretation 22408] Array of eqa language strings
		if ($name === 'eqa')
		{
			$eqaArray = array(
				0 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_YES',
				1 => 'COM_ECLINIC_PORTAL_HIV_COUNSELING_AND_TESTING_NO'
			);
			// [Interpretation 22445] Now check if value is found in this array
			if (isset($eqaArray[$value]) && Eclinic_portalHelper::checkString($eqaArray[$value]))
			{
				return $eqaArray[$value];
			}
		}
		return $value;
	}
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// [Interpretation 15534] Get the user object.
		$user = JFactory::getUser();
		// [Interpretation 15536] Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// [Interpretation 15541] Select some fields
		$query->select('a.*');

		// [Interpretation 15551] From the eclinic_portal_item table
		$query->from($db->quoteName('#__eclinic_portal_hiv_counseling_and_testing', 'a'));

		// [Interpretation 15852] From the eclinic_portal_testing_reason table.
		$query->select($db->quoteName('g.name','testing_reason_name'));
		$query->join('LEFT', $db->quoteName('#__eclinic_portal_testing_reason', 'g') . ' ON (' . $db->quoteName('a.testing_reason') . ' = ' . $db->quoteName('g.id') . ')');

		// [Interpretation 15570] Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// [Interpretation 15590] Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		// [Interpretation 15604] Filter by access level.
		$_access = $this->getState('filter.access');
		if ($_access && is_numeric($_access))
		{
			$query->where('a.access = ' . (int) $_access);
		}
		elseif (Eclinic_portalHelper::checkArray($_access))
		{
			// [Interpretation 15619] Secure the array for the query
			$_access = ArrayHelper::toInteger($_access);
			// [Interpretation 15624] Filter by the Access Array.
			$query->where('a.access IN (' . implode(',', $_access) . ')');
		}
		// [Interpretation 15630] Implement View Level Access
		if (!$user->authorise('core.options', 'com_eclinic_portal'))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}
		// [Interpretation 15791] Filter by search.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search) . '%');
				$query->where('(a.patient LIKE '.$search.')');
			}
		}

		// [Interpretation 15921] Filter by Patient.
		$_patient = $this->getState('filter.patient');
		if (is_numeric($_patient))
		{
			if (is_float($_patient))
			{
				$query->where('a.patient = ' . (float) $_patient);
			}
			else
			{
				$query->where('a.patient = ' . (int) $_patient);
			}
		}
		elseif (Eclinic_portalHelper::checkString($_patient))
		{
			$query->where('a.patient = ' . $db->quote($db->escape($_patient)));
		}

		// [Interpretation 15738] Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'desc');
		if ($orderCol != '')
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Method to get list export data.
	 *
	 * @param   array  $pks  The ids of the items to get
	 * @param   JUser  $user  The user making the request
	 *
	 * @return mixed  An array of data items on success, false on failure.
	 */
	public function getExportData($pks, $user = null)
	{
		// [Interpretation 14988] setup the query
		if (($pks_size = Eclinic_portalHelper::checkArray($pks)) !== false || 'bulk' === $pks)
		{
			// [Interpretation 14995] Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// [Interpretation 15000] Get the user object if not set.
			if (!isset($user) || !Eclinic_portalHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			// [Interpretation 15008] Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// [Interpretation 15014] Select some fields
			$query->select('a.*');

			// [Interpretation 15018] From the eclinic_portal_hiv_counseling_and_testing table
			$query->from($db->quoteName('#__eclinic_portal_hiv_counseling_and_testing', 'a'));
			// [Interpretation 15025] The bulk export path
			if ('bulk' === $pks)
			{
				$query->where('a.id > 0');
			}
			// [Interpretation 15034] A large array of ID's will not work out well
			elseif ($pks_size > 500)
			{
				// [Interpretation 15039] Use lowest ID
				$query->where('a.id >= ' . (int) min($pks));
				// [Interpretation 15043] Use highest ID
				$query->where('a.id <= ' . (int) max($pks));
			}
			// [Interpretation 15049] The normal default path
			else
			{
				$query->where('a.id IN (' . implode(',',$pks) . ')');
			}
			// [Interpretation 15101] Implement View Level Access
			if (!$user->authorise('core.options', 'com_eclinic_portal'))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// [Interpretation 15142] Order the results by ordering
			$query->order('a.ordering  ASC');

			// [Interpretation 15148] Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// [Interpretation 21901] Set values to display correctly.
				if (Eclinic_portalHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						// [Interpretation 22043] unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// [Interpretation 22058] Add headers to items array.
				$headers = $this->getExImPortHeaders();
				if (Eclinic_portalHelper::checkObject($headers))
				{
					array_unshift($items,$headers);
				}
				return $items;
			}
		}
		return false;
	}

	/**
	* Method to get header.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getExImPortHeaders()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// get the columns
		$columns = $db->getTableColumns("#__eclinic_portal_hiv_counseling_and_testing");
		if (Eclinic_portalHelper::checkArray($columns))
		{
			// remove the headers you don't import/export.
			unset($columns['asset_id']);
			unset($columns['checked_out']);
			unset($columns['checked_out_time']);
			$headers = new stdClass();
			foreach ($columns as $column => $type)
			{
				$headers->{$column} = $column;
			}
			return $headers;
		}
		return false;
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * @return  string  A store id.
	 *
	 */
	protected function getStoreId($id = '')
	{
		// [Interpretation 20600] Compile the store id.
		$id .= ':' . $this->getState('filter.id');
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		// [Interpretation 20765] Check if the value is an array
		$_access = $this->getState('filter.access');
		if (Eclinic_portalHelper::checkArray($_access))
		{
			$id .= ':' . implode(':', $_access);
		}
		// [Interpretation 20780] Check if this is only an number or string
		elseif (is_numeric($_access)
		 || Eclinic_portalHelper::checkString($_access))
		{
			$id .= ':' . $_access;
		}
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		$id .= ':' . $this->getState('filter.patient');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to checkin all items left checked out longer then a set time.
	 *
	 * @return  a bool
	 *
	 */
	protected function checkInNow()
	{
		// [Interpretation 21381] Get set check in time
		$time = JComponentHelper::getParams('com_eclinic_portal')->get('check_in');

		if ($time)
		{

			// [Interpretation 21389] Get a db connection.
			$db = JFactory::getDbo();
			// [Interpretation 21392] reset query
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__eclinic_portal_hiv_counseling_and_testing'));
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				// [Interpretation 21403] Get Yesterdays date
				$date = JFactory::getDate()->modify($time)->toSql();
				// [Interpretation 21407] reset query
				$query = $db->getQuery(true);

				// [Interpretation 21411] Fields to update.
				$fields = array(
					$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',
					$db->quoteName('checked_out') . '=0'
				);

				// [Interpretation 21420] Conditions for which records should be updated.
				$conditions = array(
					$db->quoteName('checked_out') . '!=0', 
					$db->quoteName('checked_out_time') . '<\''.$date.'\''
				);

				// [Interpretation 21429] Check table
				$query->update($db->quoteName('#__eclinic_portal_hiv_counseling_and_testing'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
