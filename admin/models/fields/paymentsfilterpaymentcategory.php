<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			11th December, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		paymentsfilterpaymentcategory.php
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
 * Paymentsfilterpaymentcategory Form Field class for the Eclinic_portal component
 */
class JFormFieldPaymentsfilterpaymentcategory extends JFormFieldList
{
	/**
	 * The paymentsfilterpaymentcategory field type.
	 *
	 * @var		string
	 */
	public $type = 'paymentsfilterpaymentcategory';

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
		$query->select($db->quoteName('payment_category'));
		$query->from($db->quoteName('#__eclinic_portal_payment'));
		$query->order($db->quoteName('payment_category') . ' ASC');

		// [Interpretation 17996] Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();
		$_filter = array();
		$_filter[] = JHtml::_('select.option', '', '- ' . JText::_('COM_ECLINIC_PORTAL_FILTER_SELECT_PAYMENT_CATEGORY') . ' -');

		if ($results)
		{
			// [Interpretation 18025] get paymentsmodel
			$model = Eclinic_portalHelper::getModel('payments');
			$results = array_unique($results);
			foreach ($results as $payment_category)
			{
				// [Interpretation 18045] Translate the payment_category selection
				$text = $model->selectionTranslation($payment_category,'payment_category');
				// [Interpretation 18052] Now add the payment_category and its text to the options array
				$_filter[] = JHtml::_('select.option', $payment_category, JText::_($text));
			}
		}
		return $_filter;
	}
}
