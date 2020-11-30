<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th November, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		paymenttype.php
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
 * Paymenttype Form Field class for the Eclinic_portal component
 */
class JFormFieldPaymenttype extends JFormFieldList
{
	/**
	 * The paymenttype field type.
	 *
	 * @var		string
	 */
	public $type = 'paymenttype';

	/**
	 * Override to add new button
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   3.2
	 */
	protected function getInput()
	{
		// [Fields 5375] see if we should add buttons
		$set_button = $this->getAttribute('button');
		// [Fields 5379] get html
		$html = parent::getInput();
		// [Fields 5382] if true set button
		if ($set_button === 'true')
		{
			$button = array();
			$script = array();
			$button_code_name = $this->getAttribute('name');
			// [Fields 5390] get the input from url
			$app = JFactory::getApplication();
			$jinput = $app->input;
			// [Fields 5394] get the view name & id
			$values = $jinput->getArray(array(
				'id' => 'int',
				'view' => 'word'
			));
			// [Fields 5401] check if new item
			$ref = '';
			$refJ = '';
			if (!is_null($values['id']) && strlen($values['view']))
			{
				// [Fields 5410] only load referral if not new item.
				$ref = '&amp;ref=' . $values['view'] . '&amp;refid=' . $values['id'];
				$refJ = '&ref=' . $values['view'] . '&refid=' . $values['id'];
				// [Fields 5416] get the return value.
				$_uri = (string) JUri::getInstance();
				$_return = urlencode(base64_encode($_uri));
				// [Fields 5422] load return value.
				$ref .= '&amp;return=' . $_return;
				$refJ .= '&return=' . $_return;
			}
			// [Fields 5455] get button label
			$button_label = trim($button_code_name);
			$button_label = preg_replace('/_+/', ' ', $button_label);
			$button_label = preg_replace('/\s+/', ' ', $button_label);
			$button_label = preg_replace("/[^A-Za-z ]/", '', $button_label);
			$button_label = ucfirst(strtolower($button_label));
			// [Fields 5467] get user object
			$user = JFactory::getUser();
			// [Fields 5470] only add if user allowed to create payment_type
			if ($user->authorise('core.create', 'com_eclinic_portal') && $app->isAdmin()) // TODO for now only in admin area.
			{
				// [Fields 5494] build Create button
				$button[] = '<a id="'.$button_code_name.'Create" class="btn btn-small btn-success hasTooltip" title="'.JText::sprintf('COM_ECLINIC_PORTAL_CREATE_NEW_S', $button_label).'" style="border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;"
					href="index.php?option=com_eclinic_portal&amp;view=payment_type&amp;layout=edit'.$ref.'" >
					<span class="icon-new icon-white"></span></a>';
			}
			// [Fields 5506] only add if user allowed to edit payment_type
			if ($user->authorise('core.edit', 'com_eclinic_portal') && $app->isAdmin()) // TODO for now only in admin area.
			{
				// [Fields 5530] build edit button
				$button[] = '<a id="'.$button_code_name.'Edit" class="btn btn-small hasTooltip" title="'.JText::sprintf('COM_ECLINIC_PORTAL_EDIT_S', $button_label).'" style="display: none; padding: 4px 4px 4px 7px;" href="#" >
					<span class="icon-edit"></span></a>';
				// [Fields 5538] build script
				$script[] = "
					jQuery(document).ready(function() {
						jQuery('#adminForm').on('change', '#jform_".$button_code_name."',function (e) {
							e.preventDefault();
							var ".$button_code_name."Value = jQuery('#jform_".$button_code_name."').val();
							".$button_code_name."Button(".$button_code_name."Value);
						});
						var ".$button_code_name."Value = jQuery('#jform_".$button_code_name."').val();
						".$button_code_name."Button(".$button_code_name."Value);
					});
					function ".$button_code_name."Button(value) {
						if (value > 0) {
							// hide the create button
							jQuery('#".$button_code_name."Create').hide();
							// show edit button
							jQuery('#".$button_code_name."Edit').show();
							var url = 'index.php?option=com_eclinic_portal&view=payment_types&task=payment_type.edit&id='+value+'".$refJ."';
							jQuery('#".$button_code_name."Edit').attr('href', url);
						} else {
							// show the create button
							jQuery('#".$button_code_name."Create').show();
							// hide edit button
							jQuery('#".$button_code_name."Edit').hide();
						}
					}";
			}
			// [Fields 5581] check if button was created for payment_type field.
			if (is_array($button) && count($button) > 0)
			{
				// [Fields 5587] Load the needed script.
				$document = JFactory::getDocument();
				$document->addScriptDeclaration(implode(' ',$script));
				// [Fields 5593] return the button attached to input field.
				return '<div class="input-append">' .$html . implode('',$button).'</div>';
			}
		}
		return $html;
	}

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Get the databse object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.name'),array('id','payment_type_name')));
		$query->from($db->quoteName('#__eclinic_portal_payment_type', 'a'));
		$query->where($db->quoteName('a.published') . ' = 1');
		$query->order('a.name ASC');
		// Implement View Level Access (if set in table)
		if (!$user->authorise('core.options', 'com_eclinic_portal'))
		{
			$columns = $db->getTableColumns('#__eclinic_portal_payment_type');
			if(isset($columns['access']))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}
		}
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$options[] = JHtml::_('select.option', '', 'Select an option');
			foreach($items as $item)
			{
				$options[] = JHtml::_('select.option', $item->id, $item->payment_type_name);
			}
		}
		return $options;
	}
}
