
<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $payment Payment
 * @var $paymentMoney PaymentMoney
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
    ->registerCss('input', 'input,textarea{width: 100%}select{width:110%}.label-mini label{font-size: 11px;white-space: nowrap;}.input-mini input, .input-mini select{font-size: 96%}')
    ->registerScript('scroll', '$("html, body").animate({scrollTop: $("#payment-form").position().top-58}, "fast");', CClientScript::POS_READY);
if ($payment->isNewRecord && isset($_GET['id'])) {
    $payment->projectId = intval($_GET['id']);
}
?>

<?php echo $form->errorSummary($payment); ?>
<div class="row-fluid">
    <div class="span2"><?php echo $form->dropDownListRow($payment, 'partner_id', CHtml::listData(CrmHelper::partners($payment->projectId), 'id', 'name')); ?></div>
    <div class="span4"><?php echo $form->textFieldRow($payment, 'name_company'); ?></div>
    <div class="span4"><?php echo $form->textFieldRow($payment, 'name_contact'); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($payment, 'city', array('disabled' => true)); ?></div>
</div>
<div class="row-fluid">
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'payment_amount'); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'payment', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'payment_remain', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'agent_comission_percent', array('disabled' => true)); ?></div>
    <div class="span6 offset2"><?php echo $form->textFieldRow($payment, 'comments'); ?></div>
</div>
<div class="row-fluid">
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'agent_comission_amount'); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'agent_comission_received', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'agent_comission_remain_amount', array('disabled' => true)); ?></div>
    <div class="span1 label-mini"><?php echo $form->textFieldRow($payment, 'agent_comission_remain_now', array('disabled' => true)); ?></div>
    <div class="span1 offset2">
        <label><?php echo Yii::t('CrmModule.payment', 'Client'); ?></label>
        <?php echo CHtml::link(
            $payment->client->client_id,
            array('client/update', 'id' => $payment->client_id),
            array('class' => 'btn btn-mini', 'rel' => 'tooltip', 'title' => Yii::t('zii', 'View'), 'style' => 'height: 28px; line-height: 28px; width: 100%', 'target' => '_blank')
        ); ?>
    </div>
    <div class="span1"><?php echo $form->dropDownListRow($payment, 'create_user_id', CHtml::listData(User::model()->cache(10800)->findAll(), 'id', 'username'), array('empty' => Yii::t('zii', 'Not set'))); ?></div>
    <div class="span2"><?php echo $form->datepickerRow($payment, 'create_time', array('style' => 'font-size: 13px', 'options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($payment, 'update_time', array('disabled' => true)); ?></div>
</div>
<?php if (!$payment->isNewRecord): ?>
<hr />

<?php foreach ($payment->paymentMoneysPartner as $money): ?>
<div class="row-fluid">
    <div class="span1"><span class="label label-info" style="width: 62px; text-align: center; height: 25px; margin-top: 25px; line-height: 25px"><?php echo Yii::t('CrmModule.payment', 'Partner'); ?></span></div>
    <div class="span1 input-mini"><?php echo $form->datepickerRow($money, "[{$money->id}]date", array('options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($money, "[{$money->id}]amount"); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($money, "[{$money->id}]method", $money->statusMethod->getList()); ?></div>
    <div class="span1" style="margin-top: 25px;"><?php echo CHtml::link(Yii::t('zii', 'Delete'), '#', array('class' => 'btn')); ?></div>
</div>
<?php endforeach; ?>
<?php foreach ($payment->paymentMoneysAgent as $money): ?>
<div class="row-fluid" id="money_<?php echo $money->id;?>">
    <div class="span1"><span class="label label-success" style="width: 62px; text-align: center; height: 25px; line-height: 25px"><?php echo Yii::t('CrmModule.payment', 'Reward'); ?></span></div>
    <!--<div class="span1"><?php //echo $form->datepickerRow($money, "[{$money->id}]date", array('options' => array('format' => 'yyyy-mm-dd'))); ?></div>-->
    <div class="span1 input-mini"><?php $form->widget(
            'bootstrap.widgets.TbDatePicker', array('model' => $money, 'attribute' => "[{$money->id}]date",
            'options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span1"><?php echo $form->textField($money, "[{$money->id}]amount"); ?></div>
    <div class="span2"><?php echo $form->dropDownList($money, "[{$money->id}]method", $money->statusMethod->getList()); ?></div>
    <div class="span1"><?php echo CHtml::ajaxButton(
            Yii::t('zii', 'Delete'),
            array('payment/deleteMoney', 'id' => $money->id),
            array('replace' => '#money_' . $money->id),
            array('class' => 'btn')
        ); ?></div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<hr />
<div class="row-fluid">
    <div class="span1"><span class="label pull-right" style="width: 62px; text-align: center; height: 25px; margin-top: 25px; line-height: 25px"><?php echo Yii::t('CrmModule.payment', 'Create'); ?></span></div>
    <div class="span1"><?php echo $form->datepickerRow($paymentMoney, '[0]date', array('options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($paymentMoney, '[0]amount'); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($paymentMoney, '[0]method', $paymentMoney->statusMethod->getList()); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($paymentMoney, '[0]type', $paymentMoney->statusType->getList()); ?></div>
</div>
<div class="form-actions">
    <?php $this->widget(
        'bootstrap.widgets.TbButtonGroup',
        array(
            'buttons' => array(
                array(
                    'buttonType' => 'submit',
                    'type'       => 'success',
                    'label'      => $payment->isNewRecord ? Yii::t('CrmModule.payment', 'Create and continue') : Yii::t('CrmModule.payment', 'Save and continue')
                ),
                array(
                    'buttonType'  => 'submit',
                    'htmlOptions' => array('name' => 'exit'),
                    'type'        => 'primary',
                    'label'       => $payment->isNewRecord ? Yii::t('CrmModule.payment', 'Create and exit') : Yii::t('CrmModule.payment', 'Save and exit')
                ),
                array(
                    'label'       => Yii::t('CrmModule.payment', 'Back'),
                    'htmlOptions' => array('onclick' => 'parent.history.back()')
                )
            ),
        )
    );?>
</div>

<?php $this->endWidget(); ?>
