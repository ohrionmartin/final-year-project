<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			3rd December, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		controller.php
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
 * General Controller of Eclinic_portal component
 */
class Eclinic_portalController extends JControllerLegacy
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 * Recognized key values include 'name', 'default_task', 'model_path', and
	 * 'view_path' (this list is not meant to be comprehensive).
	 *
	 * @since   3.0
	 */
	public function __construct($config = array())
	{
		// set the default view
		$config['default_view'] = 'eclinic_portal';

		parent::__construct($config);
	}

	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		$view   = $this->input->getCmd('view', 'eclinic_portal');
		$data	= $this->getViewRelation($view);
		$layout	= $this->input->get('layout', null, 'WORD');
		$id    	= $this->input->getInt('id');

		// Check for edit form.
		if(Eclinic_portalHelper::checkArray($data))
		{
			if ($data['edit'] && $layout == 'edit' && !$this->checkEditId('com_eclinic_portal.edit.'.$data['view'], $id))
			{
				// Somehow the person just went to the form - we don't allow that.
				$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
				$this->setMessage($this->getError(), 'error');
				// check if item was opend from other then its own list view
				$ref 	= $this->input->getCmd('ref', 0);
				$refid 	= $this->input->getInt('refid', 0);
				// set redirect
				if ($refid > 0 && Eclinic_portalHelper::checkString($ref))
				{
					// redirect to item of ref
					$this->setRedirect(JRoute::_('index.php?option=com_eclinic_portal&view='.(string)$ref.'&layout=edit&id='.(int)$refid, false));
				}
				elseif (Eclinic_portalHelper::checkString($ref))
				{

					// redirect to ref
					$this->setRedirect(JRoute::_('index.php?option=com_eclinic_portal&view='.(string)$ref, false));
				}
				else
				{
					// normal redirect back to the list view
					$this->setRedirect(JRoute::_('index.php?option=com_eclinic_portal&view='.$data['views'], false));
				}

				return false;
			}
		}

		return parent::display($cachable, $urlparams);
	}

	protected function getViewRelation($view)
	{
		// check the we have a value
		if (Eclinic_portalHelper::checkString($view))
		{
			// the view relationships
			$views = array(
				'payment' => 'payments',
				'general_medical_check_up' => 'general_medical_check_ups',
				'antenatal_care' => 'antenatal_cares',
				'immunisation' => 'immunisations',
				'vmmc' => 'vmmcs',
				'prostate_and_testicular_cancer' => 'prostate_and_testicular_cancers',
				'tuberculosis' => 'tuberculoses',
				'hiv_counseling_and_testing' => 'hiv_counselings_and_testings',
				'family_planning' => 'family_plannings',
				'cervical_cancer' => 'cervical_cancers',
				'breast_cancer' => 'breast_cancers',
				'test' => 'tests',
				'testing_reason' => 'testing_reasons',
				'counseling_type' => 'counseling_types',
				'group_health_education_topic' => 'group_health_education_topics',
				'individual_health_education_topic' => 'individual_health_education_topics',
				'individual_health_education' => 'individual_health_educations',
				'group_health_education' => 'group_health_educations',
				'foetal_engagement' => 'foetal_engagements',
				'administration_part' => 'administration_parts',
				'planning_type' => 'planning_types',
				'immunisation_type' => 'immunisation_types',
				'foetal_lie' => 'foetal_lies',
				'foetal_presentation' => 'foetal_presentations',
				'nonpay_reason' => 'nonpay_reasons',
				'immunisation_vaccine_type' => 'immunisation_vaccine_types',
				'payment_amount' => 'payment_amounts',
				'diagnosis_type' => 'diagnosis_types',
				'payment_type' => 'payment_types',
				'medication' => 'medications',
				'site' => 'sites',
				'referral' => 'referrals',
				'clinic' => 'clinics'
					);
			// check if this is a list view
			if (in_array($view, $views))
			{
				// this is a list view
				return array('edit' => false, 'view' => array_search($view,$views), 'views' => $view);
			}
			// check if it is an edit view
			elseif (array_key_exists($view, $views))
			{
				// this is a edit view
				return array('edit' => true, 'view' => $view, 'views' => $views[$view]);
			}
		}
		return false;
	}
}
