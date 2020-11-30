<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th November, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		general_medical_check_ups.php
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
 * General_medical_check_ups Controller
 */
class Eclinic_portalControllerGeneral_medical_check_ups extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UPS';

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
	public function getModel($name = 'General_medical_check_up', $prefix = 'Eclinic_portalModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// [Interpretation 14744] Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// [Interpretation 14748] check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('general_medical_check_up.export', 'com_eclinic_portal') && $user->authorise('core.export', 'com_eclinic_portal'))
		{
			// [Interpretation 14757] Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// [Interpretation 14763] Sanitize the input
			ArrayHelper::toInteger($pks);
			// [Interpretation 14766] Get the model
			$model = $this->getModel('General_medical_check_ups');
			// [Interpretation 14771] get the data to export
			$data = $model->getExportData($pks);
			if (Eclinic_portalHelper::checkArray($data))
			{
				// [Interpretation 14779] now set the data to the spreadsheet
				$date = JFactory::getDate();
				Eclinic_portalHelper::xls($data,'General_medical_check_ups_'.$date->format('jS_F_Y'),'General medical check ups exported ('.$date->format('jS F, Y').')','general medical check ups');
			}
		}
		// [Interpretation 14792] Redirect to the list screen with error.
		$message = JText::_('COM_ECLINIC_PORTAL_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_eclinic_portal&view=general_medical_check_ups', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// [Interpretation 14807] Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// [Interpretation 14811] check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('general_medical_check_up.import', 'com_eclinic_portal') && $user->authorise('core.import', 'com_eclinic_portal'))
		{
			// [Interpretation 14820] Get the import model
			$model = $this->getModel('General_medical_check_ups');
			// [Interpretation 14825] get the headers to import
			$headers = $model->getExImPortHeaders();
			if (Eclinic_portalHelper::checkObject($headers))
			{
				// [Interpretation 14833] Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('general_medical_check_up_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'general_medical_check_ups');
				$session->set('dataType_VDM_IMPORTINTO', 'general_medical_check_up');
				// [Interpretation 14844] Redirect to import view.
				$message = JText::_('COM_ECLINIC_PORTAL_IMPORT_SELECT_FILE_FOR_GENERAL_MEDICAL_CHECK_UPS');
				$this->setRedirect(JRoute::_('index.php?option=com_eclinic_portal&view=import', false), $message);
				return;
			}
		}
		// [Interpretation 14875] Redirect to the list screen with error.
		$message = JText::_('COM_ECLINIC_PORTAL_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_eclinic_portal&view=general_medical_check_ups', false), $message, 'error');
		return;
	}
}
