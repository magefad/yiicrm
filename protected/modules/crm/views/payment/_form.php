
<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model Payment
 */
Yii::import('crm.helpers.CrmHelper');
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'payment-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => array('class' => 'well')
    )
);
Yii::app()->getClientScript()
    ->registerCss('input', 'input,textarea{width: 100%}select{width:110%}.label-mini label{font-size: 11px;white-space: nowrap;}.input-mini input{font-size: 96%}')
    ->registerScript('scroll', '$("html, body").animate({scrollTop: $("#payment-form").position().top-58}, "fast");', CClientScript::POS_READY);
?>

<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">
    <div class="span2"><?php echo $form->dropDownListRow($model, 'partner_id', CHtml::listData(CrmHelper::partners($model->project_id), 'id', 'name')); ?></div>
    <div class="span4"><?php echo $form->textFieldRow($model, 'name_company'); ?></div>
    <div class="span4"><?php echo $form->textFieldRow($model, 'name_contact'); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($model, 'city', array('disabled' => true)); ?></div>
</div>
<div class="row-fluid">
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'payment_amount'); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'payment', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'payment_remain', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'agent_comission_percent', array('disabled' => true)); ?></div>
    <div class="span6 offset2"><?php echo $form->textFieldRow($model, 'comments'); ?></div>
</div>
<div class="row-fluid">
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'agent_comission_amount'); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'agent_comission_received', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'agent_comission_remain_amount', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($model, 'agent_comission_remain_now', array('disabled' => true)); ?></div>
    <div class="span1 offset2">
        <label><?php echo Yii::t('CrmModule.payment', 'Client'); ?></label>
        <?php echo CHtml::link(
            $model->client->client_id,
            array('client/update', 'id' => $model->client_id),
            array('class' => 'btn btn-mini', 'rel' => 'tooltip', 'title' => Yii::t('zii', 'View'), 'style' => 'height: 28px; line-height: 28px; width: 100%', 'target' => '_blank')
        ); ?>
    </div>
    <div class="span1"><?php echo $form->dropDownListRow($model, 'create_user_id', CHtml::listData(User::model()->cache(10800)->findAll(), 'id', 'username'), array('empty' => Yii::t('zii', 'Not set'))); ?></div>
    <div class="span2"><?php echo $form->datepickerRow($model, 'create_time', array('style' => 'font-size: 13px', 'options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($model, 'update_time', array('disabled' => true)); ?></div>
</div>
<hr />
<div class="row-fluid">
    <div class="span1"><span class="label pull-right" style="width: 62px; text-align: center; height: 25px; margin-top: 25px; line-height: 25px"><?php echo Yii::t('CrmModule.payment', 'Partner'); ?></span></div>
<?php foreach ($model->paymentMoneysPartner as $money): ?>
    <div class="span1"><?php echo $form->datepickerRow($money, "[{$money->id}]date"); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($money, "[{$money->id}]amount"); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($money, "[{$money->id}]method", $money->statusMethod->getList()); ?></div>
<?php endforeach; ?>
</div>
<div class="row-fluid">
    <div class="span1"><span class="label pull-right" style="width: 62px; text-align: center; height: 25px; margin-top: 25px; line-height: 25px"><?php echo Yii::t('CrmModule.payment', 'Reward'); ?></span></div>
<?php foreach ($model->paymentMoneysAgent as $money): ?>
    <div class="span1"><?php echo $form->datepickerRow($money, "[{$money->id}]date"); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($money, "[{$money->id}]amount"); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($money, "[{$money->id}]method", $money->statusMethod->getList()); ?></div>
<?php endforeach; ?>
</div>
<hr />
<div class="row-fluid">
<?php $money = new PaymentMoney(); ?>
    <div class="span1"><span class="label pull-right" style="width: 62px; text-align: center; height: 25px; margin-top: 25px; line-height: 25px"><?php echo Yii::t('CrmModule.payment', 'Create'); ?></span></div>
    <div class="span1"><?php echo $form->datepickerRow($money, 'date'); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($money, 'amount'); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($money, 'type', $money->statusType->getList()); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($money, 'method', $money->statusMethod->getList()); ?></div>
</div>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CrmModule.payment', 'Create') : Yii::t('CrmModule.payment', 'Save'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
