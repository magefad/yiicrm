<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model Payment
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, '__ID', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'client_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'partner_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name_company', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name_contact', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'city', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'comments', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'payment_amount', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'payment', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'payment_remain', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'calculation_percent', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'agent_comission_percent', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'agent_comission_amount', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'agent_comission_received', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'agent_comission_remain_amount', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'agent_comission_remain_now', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'error', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'create_user_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'update_user_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span5')); ?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('CrmModule.payment', 'Search'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
