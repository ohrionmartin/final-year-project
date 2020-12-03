<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			3rd December, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		default_head.php
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

?>
<tr>
	<?php if ($this->canEdit&& $this->canState): ?>
		<th width="1%" class="nowrap center hidden-phone">
			<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'ordering', $this->listDirn, $this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
		</th>
		<th width="20" class="nowrap center">
			<?php echo JHtml::_('grid.checkall'); ?>
		</th>
	<?php else: ?>
		<th width="20" class="nowrap center hidden-phone">
			&#9662;
		</th>
		<th width="20" class="nowrap center">
			&#9632;
		</th>
	<?php endif; ?>
	<th class="nowrap" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_TUBERCULOSIS_PATIENT_LABEL', 'a.patient', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_RECURRING_NIGHT_SWEATS_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_TB_FEVER_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_PERSISTENT_COUGH_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_BLOOD_STREAKED_SPUTUM_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_UNUSUAL_TIREDNESS_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_PAIN_IN_CHEST_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_SHORTNESS_OF_BREATH_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_DIAGNOSED_WITH_DISEASE_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_TB_EXPOSED_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_TB_TREATMENT_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_DATE_OF_TREATMENT_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_TREATING_DHC_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_SPUTUM_COLLECTION_ONE_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_TB_REASON_ONE_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_SPUTUM_RESULT_ONE_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_REFERRED_SECOND_SPUTUM_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_TB_REASON_TWO_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_SPUTUM_RESULT_TWO_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_WEIGHT_LOSS_WDIETING_LABEL'); ?>
	</th>
	<?php if ($this->canState): ?>
		<th width="10" class="nowrap center" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_TUBERCULOSIS_STATUS', 'a.published', $this->listDirn, $this->listOrder); ?>
		</th>
	<?php else: ?>
		<th width="10" class="nowrap center" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_TUBERCULOSIS_STATUS'); ?>
		</th>
	<?php endif; ?>
	<th width="5" class="nowrap center hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_TUBERCULOSIS_ID', 'a.id', $this->listDirn, $this->listOrder); ?>
	</th>
</tr>