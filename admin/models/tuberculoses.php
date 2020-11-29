<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			29th November, 2020
	@created		13th August, 2020
	@package		eHealth Portal
	@subpackage		tuberculoses.php
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
 * Tuberculoses Model
 */
class Ehealth_portalModelTuberculoses extends JModelList
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
		if (Ehealth_portalHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// [Interpretation 21036] convert recurring_night_sweats
				$item->recurring_night_sweats = $this->selectionTranslation($item->recurring_night_sweats, 'recurring_night_sweats');
				// [Interpretation 21036] convert tb_fever
				$item->tb_fever = $this->selectionTranslation($item->tb_fever, 'tb_fever');
				// [Interpretation 21036] convert persistent_cough
				$item->persistent_cough = $this->selectionTranslation($item->persistent_cough, 'persistent_cough');
				// [Interpretation 21036] convert blood_streaked_sputum
				$item->blood_streaked_sputum = $this->selectionTranslation($item->blood_streaked_sputum, 'blood_streaked_sputum');
				// [Interpretation 21036] convert unusual_tiredness
				$item->unusual_tiredness = $this->selectionTranslation($item->unusual_tiredness, 'unusual_tiredness');
				// [Interpretation 21036] convert pain_in_chest
				$item->pain_in_chest = $this->selectionTranslation($item->pain_in_chest, 'pain_in_chest');
				// [Interpretation 21036] convert shortness_of_breath
				$item->shortness_of_breath = $this->selectionTranslation($item->shortness_of_breath, 'shortness_of_breath');
				// [Interpretation 21036] convert diagnosed_with_disease
				$item->diagnosed_with_disease = $this->selectionTranslation($item->diagnosed_with_disease, 'diagnosed_with_disease');
				// [Interpretation 21036] convert tb_exposed
				$item->tb_exposed = $this->selectionTranslation($item->tb_exposed, 'tb_exposed');
				// [Interpretation 21036] convert tb_treatment
				$item->tb_treatment = $this->selectionTranslation($item->tb_treatment, 'tb_treatment');
				// [Interpretation 21036] convert sputum_collection_one
				$item->sputum_collection_one = $this->selectionTranslation($item->sputum_collection_one, 'sputum_collection_one');
				// [Interpretation 21036] convert sputum_result_one
				$item->sputum_result_one = $this->selectionTranslation($item->sputum_result_one, 'sputum_result_one');
				// [Interpretation 21036] convert referred_second_sputum
				$item->referred_second_sputum = $this->selectionTranslation($item->referred_second_sputum, 'referred_second_sputum');
				// [Interpretation 21036] convert sputum_result_two
				$item->sputum_result_two = $this->selectionTranslation($item->sputum_result_two, 'sputum_result_two');
				// [Interpretation 21036] convert weight_loss_wdieting
				$item->weight_loss_wdieting = $this->selectionTranslation($item->weight_loss_wdieting, 'weight_loss_wdieting');
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
		// [Interpretation 21076] Array of recurring_night_sweats language strings
		if ($name === 'recurring_night_sweats')
		{
			$recurring_night_sweatsArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($recurring_night_sweatsArray[$value]) && Ehealth_portalHelper::checkString($recurring_night_sweatsArray[$value]))
			{
				return $recurring_night_sweatsArray[$value];
			}
		}
		// [Interpretation 21076] Array of tb_fever language strings
		if ($name === 'tb_fever')
		{
			$tb_feverArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($tb_feverArray[$value]) && Ehealth_portalHelper::checkString($tb_feverArray[$value]))
			{
				return $tb_feverArray[$value];
			}
		}
		// [Interpretation 21076] Array of persistent_cough language strings
		if ($name === 'persistent_cough')
		{
			$persistent_coughArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($persistent_coughArray[$value]) && Ehealth_portalHelper::checkString($persistent_coughArray[$value]))
			{
				return $persistent_coughArray[$value];
			}
		}
		// [Interpretation 21076] Array of blood_streaked_sputum language strings
		if ($name === 'blood_streaked_sputum')
		{
			$blood_streaked_sputumArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($blood_streaked_sputumArray[$value]) && Ehealth_portalHelper::checkString($blood_streaked_sputumArray[$value]))
			{
				return $blood_streaked_sputumArray[$value];
			}
		}
		// [Interpretation 21076] Array of unusual_tiredness language strings
		if ($name === 'unusual_tiredness')
		{
			$unusual_tirednessArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($unusual_tirednessArray[$value]) && Ehealth_portalHelper::checkString($unusual_tirednessArray[$value]))
			{
				return $unusual_tirednessArray[$value];
			}
		}
		// [Interpretation 21076] Array of pain_in_chest language strings
		if ($name === 'pain_in_chest')
		{
			$pain_in_chestArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($pain_in_chestArray[$value]) && Ehealth_portalHelper::checkString($pain_in_chestArray[$value]))
			{
				return $pain_in_chestArray[$value];
			}
		}
		// [Interpretation 21076] Array of shortness_of_breath language strings
		if ($name === 'shortness_of_breath')
		{
			$shortness_of_breathArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($shortness_of_breathArray[$value]) && Ehealth_portalHelper::checkString($shortness_of_breathArray[$value]))
			{
				return $shortness_of_breathArray[$value];
			}
		}
		// [Interpretation 21076] Array of diagnosed_with_disease language strings
		if ($name === 'diagnosed_with_disease')
		{
			$diagnosed_with_diseaseArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($diagnosed_with_diseaseArray[$value]) && Ehealth_portalHelper::checkString($diagnosed_with_diseaseArray[$value]))
			{
				return $diagnosed_with_diseaseArray[$value];
			}
		}
		// [Interpretation 21076] Array of tb_exposed language strings
		if ($name === 'tb_exposed')
		{
			$tb_exposedArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($tb_exposedArray[$value]) && Ehealth_portalHelper::checkString($tb_exposedArray[$value]))
			{
				return $tb_exposedArray[$value];
			}
		}
		// [Interpretation 21076] Array of tb_treatment language strings
		if ($name === 'tb_treatment')
		{
			$tb_treatmentArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($tb_treatmentArray[$value]) && Ehealth_portalHelper::checkString($tb_treatmentArray[$value]))
			{
				return $tb_treatmentArray[$value];
			}
		}
		// [Interpretation 21076] Array of sputum_collection_one language strings
		if ($name === 'sputum_collection_one')
		{
			$sputum_collection_oneArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($sputum_collection_oneArray[$value]) && Ehealth_portalHelper::checkString($sputum_collection_oneArray[$value]))
			{
				return $sputum_collection_oneArray[$value];
			}
		}
		// [Interpretation 21076] Array of sputum_result_one language strings
		if ($name === 'sputum_result_one')
		{
			$sputum_result_oneArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_POSITIVE',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NEGATIVE',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_INCONCLUSIVE'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($sputum_result_oneArray[$value]) && Ehealth_portalHelper::checkString($sputum_result_oneArray[$value]))
			{
				return $sputum_result_oneArray[$value];
			}
		}
		// [Interpretation 21076] Array of referred_second_sputum language strings
		if ($name === 'referred_second_sputum')
		{
			$referred_second_sputumArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($referred_second_sputumArray[$value]) && Ehealth_portalHelper::checkString($referred_second_sputumArray[$value]))
			{
				return $referred_second_sputumArray[$value];
			}
		}
		// [Interpretation 21076] Array of sputum_result_two language strings
		if ($name === 'sputum_result_two')
		{
			$sputum_result_twoArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_POSITIVE',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NEGATIVE',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_INCONCLUSIVE'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($sputum_result_twoArray[$value]) && Ehealth_portalHelper::checkString($sputum_result_twoArray[$value]))
			{
				return $sputum_result_twoArray[$value];
			}
		}
		// [Interpretation 21076] Array of weight_loss_wdieting language strings
		if ($name === 'weight_loss_wdieting')
		{
			$weight_loss_wdietingArray = array(
				0 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_YES',
				1 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_NO',
				2 => 'COM_EHEALTH_PORTAL_TUBERCULOSIS_UNCERTAIN'
			);
			// [Interpretation 21113] Now check if value is found in this array
			if (isset($weight_loss_wdietingArray[$value]) && Ehealth_portalHelper::checkString($weight_loss_wdietingArray[$value]))
			{
				return $weight_loss_wdietingArray[$value];
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

		// [Interpretation 15059] From the ehealth_portal_item table
		$query->from($db->quoteName('#__ehealth_portal_tuberculosis', 'a'));

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
		if (!$user->authorise('core.options', 'com_ehealth_portal'))
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
		if (($pks_size = Ehealth_portalHelper::checkArray($pks)) !== false || 'bulk' === $pks)
		{
			// [Interpretation 14505] Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// [Interpretation 14510] Get the user object if not set.
			if (!isset($user) || !Ehealth_portalHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			// [Interpretation 14518] Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// [Interpretation 14524] Select some fields
			$query->select('a.*');

			// [Interpretation 14528] From the ehealth_portal_tuberculosis table
			$query->from($db->quoteName('#__ehealth_portal_tuberculosis', 'a'));
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
			if (!$user->authorise('core.options', 'com_ehealth_portal'))
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
				if (Ehealth_portalHelper::checkArray($items))
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
				if (Ehealth_portalHelper::checkObject($headers))
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
		$columns = $db->getTableColumns("#__ehealth_portal_tuberculosis");
		if (Ehealth_portalHelper::checkArray($columns))
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
		$time = JComponentHelper::getParams('com_ehealth_portal')->get('check_in');

		if ($time)
		{

			// [Interpretation 20204] Get a db connection.
			$db = JFactory::getDbo();
			// [Interpretation 20207] reset query
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__ehealth_portal_tuberculosis'));
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
				$query->update($db->quoteName('#__ehealth_portal_tuberculosis'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
