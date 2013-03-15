<?php
/** @var $data Client */
?>
<div class="view">

    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('project_id')); ?>:</b>
	<?php echo CHtml::encode($data->project_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_id')); ?>:</b>
	<?php echo CHtml::encode($data->client_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('manager')); ?>:</b>
	<?php echo CHtml::encode($data->manager); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_company')); ?>:</b>
	<?php echo CHtml::encode($data->name_company); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_contact')); ?>:</b>
	<?php echo CHtml::encode($data->name_contact); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('time_zone')); ?>:</b>
	<?php echo CHtml::encode($data->time_zone); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site')); ?>:</b>
	<?php echo CHtml::encode($data->site); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('driver')); ?>:</b>
	<?php echo CHtml::encode($data->driver); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product')); ?>:</b>
	<?php echo CHtml::encode($data->product); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('client_request')); ?>:</b>
	<?php echo CHtml::encode($data->client_request); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_type')); ?>:</b>
	<?php echo CHtml::encode($data->link_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sponsor')); ?>:</b>
	<?php echo CHtml::encode($data->sponsor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cp')); ?>:</b>
	<?php echo CHtml::encode($data->cp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_history')); ?>:</b>
	<?php echo CHtml::encode($data->comment_history); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_fail')); ?>:</b>
	<?php echo CHtml::encode($data->comment_fail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contract_copy')); ?>:</b>
	<?php echo CHtml::encode($data->contract_copy); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment_review')); ?>:</b>
	<?php echo CHtml::encode($data->comment_review); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('photo')); ?>:</b>
	<?php echo CHtml::encode($data->photo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description_production')); ?>:</b>
	<?php echo CHtml::encode($data->description_production); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('next_time')); ?>:</b>
	<?php echo CHtml::encode($data->next_time); ?>
	<br />

	*/ ?>

</div>