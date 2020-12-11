<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				Vast Development Method 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.4
	@build			11th December, 2020
	@created		13th August, 2020
	@package		eClinic Portal
	@subpackage		default_body.php
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

$edit = "index.php?option=com_eclinic_portal&view=tuberculoses&task=tuberculosis.edit";

?>
<?php foreach ($this->items as $i => $item): ?>
	<?php
		$canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
		$userChkOut = JFactory::getUser($item->checked_out);
		$canDo = Eclinic_portalHelper::getActions('tuberculosis',$item,'tuberculoses');
	?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="order nowrap center hidden-phone">
		<?php if ($canDo->get('core.edit.state')): ?>
			<?php
				$iconClass = '';
				if (!$this->saveOrder)
				{
					$iconClass = ' inactive tip-top" hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
				}
			?>
			<span class="sortable-handler<?php echo $iconClass; ?>">
				<i class="icon-menu"></i>
			</span>
			<?php if ($this->saveOrder) : ?>
				<input type="text" style="display:none" name="order[]" size="5"
				value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
			<?php endif; ?>
		<?php else: ?>
			&#8942;
		<?php endif; ?>
		</td>
		<td class="nowrap center">
		<?php if ($canDo->get('core.edit')): ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo JHtml::_('grid.id', $i, $item->id); ?>
					<?php else: ?>
						&#9633;
					<?php endif; ?>
				<?php else: ?>
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				<?php endif; ?>
		<?php else: ?>
			&#9633;
		<?php endif; ?>
		</td>
		<td class="nowrap">
			<div class="name">
				<?php if ($this->user->authorise('core.edit', 'com_users')): ?>
					<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->patient ?>"><?php echo JFactory::getUser((int)$item->patient)->name; ?></a>
				<?php else: ?>
					<?php echo JFactory::getUser((int)$item->patient)->name; ?>
				<?php endif; ?>
			</div>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->recurring_night_sweats); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->tb_fever); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->persistent_cough); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->blood_streaked_sputum); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->unusual_tiredness); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->pain_in_chest); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->shortness_of_breath); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->diagnosed_with_disease); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->tb_exposed); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->tb_treatment); ?>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->date_of_treatment); ?>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->treating_dhc); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->sputum_collection_one); ?>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->tb_reason_one); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->sputum_result_one); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->referred_second_sputum); ?>
		</td>
		<td class="hidden-phone">
			<?php echo $this->escape($item->tb_reason_two); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->sputum_result_two); ?>
		</td>
		<td class="hidden-phone">
			<?php echo JText::_($item->weight_loss_wdieting); ?>
		</td>
		<td class="center">
		<?php if ($canDo->get('core.edit.state')) : ?>
				<?php if ($item->checked_out) : ?>
					<?php if ($canCheckin) : ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'tuberculoses.', true, 'cb'); ?>
					<?php else: ?>
						<?php echo JHtml::_('jgrid.published', $item->published, $i, 'tuberculoses.', false, 'cb'); ?>
					<?php endif; ?>
				<?php else: ?>
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'tuberculoses.', true, 'cb'); ?>
				<?php endif; ?>
		<?php else: ?>
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'tuberculoses.', false, 'cb'); ?>
		<?php endif; ?>
		</td>
		<td class="nowrap center hidden-phone">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>