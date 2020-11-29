<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			29th November, 2020
	@created		13th August, 2020
	@package		eHealth Portal
	@subpackage		antenatal_cares.php
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
 * Antenatal_cares Controller
 */
class Ehealth_portalControllerAntenatal_cares extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_EHEALTH_PORTAL_ANTENATAL_CARES';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Antenatal_care', $prefix = 'Ehealth_portalModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// [Interpretation 14744] Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// [Interpretation 14748] check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('antenatal_care.export', 'com_ehealth_portal') && $user->authorise('core.export', 'com_ehealth_portal'))
		{
			// [Interpretation 14757] Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// [Interpretation 14763] Sanitize the input
			ArrayHelper::toInteger($pks);
			// [Interpretation 14766] Get the model
			$model = $this->getModel('Antenatal_cares');
			// [Interpretation 14771] get the data to export
			$data = $model->getExportData($pks);
			if (Ehealth_portalHelper::checkArray($data))
			{
				// [Interpretation 14779] now set the data to the spreadsheet
				$date = JFactory::getDate();
				Ehealth_portalHelper::xls($data,'Antenatal_cares_'.$date->format('jS_F_Y'),'Antenatal cares exported ('.$date->format('jS F, Y').')','antenatal cares');
			}
		}
		// [Interpretation 14792] Redirect to the list screen with error.
		$message = JText::_('COM_EHEALTH_PORTAL_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_ehealth_portal&view=antenatal_cares', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// [Interpretation 14807] Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// [Interpretation 14811] check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('antenatal_care.import', 'com_ehealth_portal') && $user->authorise('core.import', 'com_ehealth_portal'))
		{
			// [Interpretation 14820] Get the import model
			$model = $this->getModel('Antenatal_cares');
			// [Interpretation 14825] get the headers to import
			$headers = $model->getExImPortHeaders();
			if (Ehealth_portalHelper::checkObject($headers))
			{
				// [Interpretation 14833] Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('antenatal_care_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'antenatal_cares');
				$session->set('dataType_VDM_IMPORTINTO', 'antenatal_care');
				// [Interpretation 14844] Redirect to import view.
				$message = JText::_('COM_EHEALTH_PORTAL_IMPORT_SELECT_FILE_FOR_ANTENATAL_CARES');
				$this->setRedirect(JRoute::_('index.php?option=com_ehealth_portal&view=import', false), $message);
				return;
			}
		}
		// [Interpretation 14875] Redirect to the list screen with error.
		$message = JText::_('COM_EHEALTH_PORTAL_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_ehealth_portal&view=antenatal_cares', false), $message, 'error');
		return;
	}
}
