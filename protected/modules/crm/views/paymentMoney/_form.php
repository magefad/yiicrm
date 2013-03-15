
<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model PaymentMoney
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'payment-money-form',
        'enableAjaxValidation' => false,
    )
); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'type', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'payment_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'date', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'amount', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'create_user_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'update_user_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span5')); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CrmModule.paymentMoney', 'Create') : Yii::t('CrmModule.paymentMoney', 'Save'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
