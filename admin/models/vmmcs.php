<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th November, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		vmmcs.php
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
 * Vmmcs Model
 */
class Eclinic_portalModelVmmcs extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
        {
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
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
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}
		$patient = $this->getUserStateFromRequest($this->context . '.filter.patient', 'filter_patient');
		$this->setState('filter.patient', $patient);
        
		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);
        
		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);
        
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
        
		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		$this->setState('filter.created', $created);

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
		// [Interpretation 20178] check in items
		$this->checkInNow();

		// load parent items
		$items = parent::getItems();

		// [Interpretation 21022] set selection value to a translatable value
		if (Eclinic_portalHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// [Interpretation 21036] convert are_you_circumcised
				$item->are_you_circumcised = $this->selectionTranslation($item->are_you_circumcised, 'are_you_circumcised');
				// [Interpretation 21036] convert info_ben_vmcc
				$item->info_ben_vmcc = $this->selectionTranslation($item->info_ben_vmcc, 'info_ben_vmcc');
				// [Interpretation 21036] convert interested_in_vmmc
				$item->interested_in_vmmc = $this->selectionTranslation($item->interested_in_vmmc, 'interested_in_vmmc');
				// [Interpretation 21036] convert vmmc_gender
				$item->vmmc_gender = $this->selectionTranslation($item->vmmc_gender, 'vmmc_gender');
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
		// [Interpretation 21076] Array of are_you_circumcised language strings
		if ($name === 'are_you_circumcised')
		{
			$are_you_circumcisedArray = array(
				0 => 'COM_ECLINIC_PORTAL_VMMC_YES',
				1 => 'COM_ECLINIC_PORTAL_VMMC_NO'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($are_you_circumcisedArray[$value]) && Eclinic_portalHelper::checkString($are_you_circumcisedArray[$value]))
			{
				return $are_you_circumcisedArray[$value];
			}
		}
		// [Interpretation 21076] Array of info_ben_vmcc language strings
		if ($name === 'info_ben_vmcc')
		{
			$info_ben_vmccArray = array(
				0 => 'COM_ECLINIC_PORTAL_VMMC_YES',
				1 => 'COM_ECLINIC_PORTAL_VMMC_NO'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($info_ben_vmccArray[$value]) && Eclinic_portalHelper::checkString($info_ben_vmccArray[$value]))
			{
				return $info_ben_vmccArray[$value];
			}
		}
		// [Interpretation 21076] Array of interested_in_vmmc language strings
		if ($name === 'interested_in_vmmc')
		{
			$interested_in_vmmcArray = array(
				0 => 'COM_ECLINIC_PORTAL_VMMC_YES',
				1 => 'COM_ECLINIC_PORTAL_VMMC_NO'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($interested_in_vmmcArray[$value]) && Eclinic_portalHelper::checkString($interested_in_vmmcArray[$value]))
			{
				return $interested_in_vmmcArray[$value];
			}
		}
		// [Interpretation 21076] Array of vmmc_gender language strings
		if ($name === 'vmmc_gender')
		{
			$vmmc_genderArray = array(
				0 => 'COM_ECLINIC_PORTAL_VMMC_MALE',
				1 => 'COM_ECLINIC_PORTAL_VMMC_FEMALE'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($vmmc_genderArray[$value]) && Eclinic_portalHelper::checkString($vmmc_genderArray[$value]))
			{
				return $vmmc_genderArray[$value];
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
		// [Interpretation 15042] Get the user object.
		$user = JFactory::getUser();
		// [Interpretation 15044] Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// [Interpretation 15049] Select some fields
		$query->select('a.*');

		// [Interpretation 15059] From the eclinic_portal_item table
		$query->from($db->quoteName('#__eclinic_portal_vmmc', 'a'));

		// [Interpretation 15078] Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// [Interpretation 15098] Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		// [Interpretation 15104] Filter by access level.
		if ($access = $this->getState('filter.access'))
		{
			$query->where('a.access = ' . (int) $access);
		}
		// [Interpretation 15112] Implement View Level Access
		if (!$user->authorise('core.options', 'com_eclinic_portal'))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}
		// [Interpretation 15322] Filter by search.
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

		// [Interpretation 15454] Filter by Patient.
		if ($patient = $this->getState('filter.patient'))
		{
			$query->where('a.patient = ' . $db->quote($db->escape($patient)));
		}

		// [Interpretation 15220] Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'asc');
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
		// [Interpretation 14499] setup the query
		if (($pks_size = Eclinic_portalHelper::checkArray($pks)) !== false || 'bulk' === $pks)
		{
			// [Interpretation 14505] Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// [Interpretation 14510] Get the user object if not set.
			if (!isset($user) || !Eclinic_portalHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			// [Interpretation 14518] Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// [Interpretation 14524] Select some fields
			$query->select('a.*');

			// [Interpretation 14528] From the eclinic_portal_vmmc table
			$query->from($db->quoteName('#__eclinic_portal_vmmc', 'a'));
			// [Interpretation 14535] The bulk export path
			if ('bulk' === $pks)
			{
				$query->where('a.id > 0');
			}
			// [Interpretation 14544] A large array of ID's will not work out well
			elseif ($pks_size > 500)
			{
				// [Interpretation 14549] Use lowest ID
				$query->where('a.id >= ' . (int) min($pks));
				// [Interpretation 14553] Use highest ID
				$query->where('a.id <= ' . (int) max($pks));
			}
			// [Interpretation 14559] The normal default path
			else
			{
				$query->where('a.id IN (' . implode(',',$pks) . ')');
			}
			// [Interpretation 14611] Implement View Level Access
			if (!$user->authorise('core.options', 'com_eclinic_portal'))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// [Interpretation 14652] Order the results by ordering
			$query->order('a.ordering  ASC');

			// [Interpretation 14658] Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// [Interpretation 20714] Set values to display correctly.
				if (Eclinic_portalHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						// [Interpretation 20856] unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// [Interpretation 20871] Add headers to items array.
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
		$columns = $db->getTableColumns("#__eclinic_portal_vmmc");
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
		// [Interpretation 19559] Compile the store id.
		$id .= ':' . $this->getState('filter.id');
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
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
		// [Interpretation 20196] Get set check in time
		$time = JComponentHelper::getParams('com_eclinic_portal')->get('check_in');

		if ($time)
		{

			// [Interpretation 20204] Get a db connection.
			$db = JFactory::getDbo();
			// [Interpretation 20207] reset query
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__eclinic_portal_vmmc'));
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				// [Interpretation 20218] Get Yesterdays date
				$date = JFactory::getDate()->modify($time)->toSql();
				// [Interpretation 20222] reset query
				$query = $db->getQuery(true);

				// [Interpretation 20226] Fields to update.
				$fields = array(
					$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',
					$db->quoteName('checked_out') . '=0'
				);

				// [Interpretation 20235] Conditions for which records should be updated.
				$conditions = array(
					$db->quoteName('checked_out') . '!=0', 
					$db->quoteName('checked_out_time') . '<\''.$date.'\''
				);

				// [Interpretation 20244] Check table
				$query->update($db->quoteName('#__eclinic_portal_vmmc'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
