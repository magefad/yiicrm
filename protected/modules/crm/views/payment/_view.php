<?php
/** @var $data Payment */
?>
<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('partner_id')); ?>:</b>
	<?php echo CHtml::encode($data->partner_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_company')); ?>:</b>
	<?php echo CHtml::encode($data->name_company); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_contact')); ?>:</b>
	<?php echo CHtml::encode($data->name_contact); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clientCity')); ?>:</b>
	<?php echo CHtml::encode($data->clientCity); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('comments')); ?>:</b>
	<?php echo CHtml::encode($data->comments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_amount')); ?>:</b>
	<?php echo CHtml::encode($data->payment_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment')); ?>:</b>
	<?php echo CHtml::encode($data->payment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment_remain')); ?>:</b>
	<?php echo CHtml::encode($data->payment_remain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_comission_percent')); ?>:</b>
	<?php echo CHtml::encode($data->agent_comission_percent); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_comission_amount')); ?>:</b>
	<?php echo CHtml::encode($data->agent_comission_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_comission_received')); ?>:</b>
	<?php echo CHtml::encode($data->agent_comission_received); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_comission_remain_amount')); ?>:</b>
	<?php echo CHtml::encode($data->agent_comission_remain_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agent_comission_remain_now')); ?>:</b>
	<?php echo CHtml::encode($data->agent_comission_remain_now); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->create_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
	<?php echo CHtml::encode($data->update_user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo CHtml::encode($data->update_time); ?>
	<br />

	*/ ?>

</div>