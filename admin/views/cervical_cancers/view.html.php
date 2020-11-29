<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			29th November, 2020
	@created		13th August, 2020
	@package		eHealth Portal
	@subpackage		view.html.php
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

/**
 * Ehealth_portal View class for the Cervical_cancers
 */
class Ehealth_portalViewCervical_cancers extends JViewLegacy
{
	/**
	 * Cervical_cancers view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			Ehealth_portalHelper::addSubmenu('cervical_cancers');
		}

		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();
		// [Interpretation 5103] Add the list ordering clause.
		$this->listOrder = $this->escape($this->state->get('list.ordering', 'a.id'));
		$this->listDirn = $this->escape($this->state->get('list.direction', 'asc'));
		$this->saveOrder = $this->listOrder == 'ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = Ehealth_portalHelper::getActions('cervical_cancer');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
		$this->canBatch = $this->canDo->get('core.batch');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			// load the batch html
			if ($this->canCreate && $this->canEdit && $this->canState)
			{
				$this->batchDisplay = JHtmlBatch_::render();
			}
		}
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_EHEALTH_PORTAL_CERVICAL_CANCERS'), 'heart-2');
		JHtmlSidebar::setAction('index.php?option=com_ehealth_portal&view=cervical_cancers');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('cervical_cancer.add');
		}

		// Only load if there are items
		if (Ehealth_portalHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('cervical_cancer.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('cervical_cancers.publish');
				JToolBarHelper::unpublishList('cervical_cancers.unpublish');
				JToolBarHelper::archiveList('cervical_cancers.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('cervical_cancers.checkin');
				}
			}

			// Add a batch button
			if ($this->canBatch && $this->canCreate && $this->canEdit && $this->canState)
			{
				// Get the toolbar object instance
				$bar = JToolBar::getInstance('toolbar');
				// set the batch button name
				$title = JText::_('JTOOLBAR_BATCH');
				// Instantiate a new JLayoutFile instance and render the batch button
				$layout = new JLayoutFile('joomla.toolbar.batch');
				// add the button to the page
				$dhtml = $layout->render(array('title' => $title));
				$bar->appendButton('Custom', $dhtml, 'batch');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				JToolbarHelper::deleteList('', 'cervical_cancers.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('cervical_cancers.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('cervical_cancer.export'))
			{
				JToolBarHelper::custom('cervical_cancers.exportData', 'download', '', 'COM_EHEALTH_PORTAL_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('cervical_cancer.import'))
		{
			JToolBarHelper::custom('cervical_cancers.importData', 'upload', '', 'COM_EHEALTH_PORTAL_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = Ehealth_portalHelper::getHelpUrl('cervical_cancers');
		if (Ehealth_portalHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_EHEALTH_PORTAL_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_ehealth_portal');
		}

		if ($this->canState)
		{
			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);
			// only load if batch allowed
			if ($this->canBatch)
			{
				JHtmlBatch_::addListSelection(
					JText::_('COM_EHEALTH_PORTAL_KEEP_ORIGINAL_STATE'),
					'batch[published]',
					JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
				);
			}
		}

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'),
			'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);

		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
				JText::_('COM_EHEALTH_PORTAL_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// [Interpretation 17612] Set Patient Selection
		$this->patientOptions = $this->getThePatientSelections();
		// [Interpretation 17617] We do some sanitation for Patient filter
		if (Ehealth_portalHelper::checkArray($this->patientOptions) &&
			isset($this->patientOptions[0]->value) &&
			!Ehealth_portalHelper::checkString($this->patientOptions[0]->value))
		{
			unset($this->patientOptions[0]);
		}
		// [Interpretation 17633] Only load Patient filter if it has values
		if (Ehealth_portalHelper::checkArray($this->patientOptions))
		{
			// [Interpretation 17641] Patient Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_EHEALTH_PORTAL_CERVICAL_CANCER_PATIENT_LABEL').' -',
				'filter_patient',
				JHtml::_('select.options', $this->patientOptions, 'value', 'text', $this->state->get('filter.patient'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// [Interpretation 17659] Patient Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_EHEALTH_PORTAL_CERVICAL_CANCER_PATIENT_LABEL').' -',
					'batch[patient]',
					JHtml::_('select.options', $this->patientOptions, 'value', 'text')
				);
			}
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_('COM_EHEALTH_PORTAL_CERVICAL_CANCERS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_ehealth_portal/assets/css/cervical_cancers.css", (Ehealth_portalHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 50)
		{
			// use the helper htmlEscape method instead and shorten the string
			return Ehealth_portalHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return Ehealth_portalHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
			'ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.patient' => JText::_('COM_EHEALTH_PORTAL_CERVICAL_CANCER_PATIENT_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getThePatientSelections()
	{
		// [Interpretation 17304] Get a db connection.
		$db = JFactory::getDbo();

		// [Interpretation 17308] Create a new query object.
		$query = $db->getQuery(true);

		// [Interpretation 17344] Select the text.
		$query->select($db->quoteName('patient'));
		$query->from($db->quoteName('#__ehealth_portal_cervical_cancer'));
		$query->order($db->quoteName('patient') . ' ASC');

		// [Interpretation 17355] Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $patient)
			{
				// [Interpretation 17407] Now add the patient and its text to the options array
				$_filter[] = JHtml::_('select.option', $patient, JFactory::getUser($patient)->name);
			}
			return $_filter;
		}
		return false;
	}
}
