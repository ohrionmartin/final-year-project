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
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_PATIENT_LABEL', 'a.patient', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_BP_DIASTOLIC_ONE_LABEL', 'a.bp_diastolic_one', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_BP_SYSTOLIC_ONE_LABEL', 'a.bp_systolic_one', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_TEMP_ONE_LABEL', 'a.temp_one', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_WEIGHT_LABEL', 'a.weight', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_PULSE_LABEL', 'a.pulse', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_CHRONIC_MEDICATION_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_BP_DIASTOLIC_TWO_LABEL', 'a.bp_diastolic_two', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_BP_SYSTOLIC_TWO_LABEL', 'a.bp_systolic_two', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_TEMP_TWO_LABEL', 'a.temp_two', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_HEIGHT_LABEL', 'a.height', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_BMI_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_COMPLAINT_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_INVESTIGATIONS_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_NOTES_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_DIAGNOSIS_LABEL'); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_REFERRAL_LABEL', 'h.name', $this->listDirn, $this->listOrder); ?>
	</th>
	<th class="nowrap hidden-phone" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_REASON_LABEL'); ?>
	</th>
	<?php if ($this->canState): ?>
		<th width="10" class="nowrap center" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_STATUS', 'a.published', $this->listDirn, $this->listOrder); ?>
		</th>
	<?php else: ?>
		<th width="10" class="nowrap center" >
			<?php echo JText::_('COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_STATUS'); ?>
		</th>
	<?php endif; ?>
	<th width="5" class="nowrap center hidden-phone" >
			<?php echo JHtml::_('grid.sort', 'COM_ECLINIC_PORTAL_GENERAL_MEDICAL_CHECK_UP_ID', 'a.id', $this->listDirn, $this->listOrder); ?>
	</th>
</tr>