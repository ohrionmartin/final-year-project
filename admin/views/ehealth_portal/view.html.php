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
 * Ehealth_portal View class
 */
class Ehealth_portalViewEhealth_portal extends JViewLegacy
{
	/**
	 * View display method
	 * @return void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->icons			= $this->get('Icons');
		$this->contributors		= Ehealth_portalHelper::getContributors();
		
		// get the manifest details of the component
		$this->manifest = Ehealth_portalHelper::manifest();
		
		// Set the toolbar
		$this->addToolBar();
		
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
		$canDo = Ehealth_portalHelper::getActions('ehealth_portal');
		JToolBarHelper::title(JText::_('COM_EHEALTH_PORTAL_DASHBOARD'), 'grid-2');

		// set help url for this view if found
		$help_url = Ehealth_portalHelper::getHelpUrl('ehealth_portal');
		if (Ehealth_portalHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_EHEALTH_PORTAL_HELP_MANAGER', false, $help_url);
		}

		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_ehealth_portal');
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		
		// add dashboard style sheets
		$document->addStyleSheet(JURI::root() . "administrator/components/com_ehealth_portal/assets/css/dashboard.css");
		
		// set page title
		$document->setTitle(JText::_('COM_EHEALTH_PORTAL_DASHBOARD'));
		
		// add manifest to page JavaScript
		$document->addScriptDeclaration("var manifest = jQuery.parseJSON('" . json_encode($this->manifest) . "');", "text/javascript");
	}
}
