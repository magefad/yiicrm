<?php if (!isset($_COOKIE['useTab'])):?>
<div class="alert alert-info fade in" id="alert-tab">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Ахтунг!</strong> Используйте клавишу <span class="label label-inverse">Tab ⇆</span> для перехода к следующему полю для заполнения
</div>
<?php
endif;
Yii::app()->getClientScript()->registerCoreScript('cookie')->registerScript('tab', '
$("#payment-form").keyup(function(e) {
    var code = e.keyCode || e.which;
    if (code == "9") {
        $("#alert-tab").alert("close");
        var date = new Date();
        date.setTime(date.getTime() + (60 * 60 * 1000));//60 minutes
        $.cookie("useTab", "1", { expires: date });
    }
 });
');
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
    ->registerCss('input', 'input,textarea{width: 100%}select{width:110%}.label-mini label{font-size: 11px;white-space: nowrap;}.input-mini input, .input-mini select{font-size: 96%}.select-mini select, .select-mini span{font-size: 82%; line-height: 14px;}')
    ->registerScript('scroll', '$("html, body").animate({scrollTop: $("#payment-form").position().top-58}, "fast");', CClientScript::POS_READY);
if ($payment->isNewRecord && isset($_GET['id'])) {
    $payment->projectId = intval($_GET['id']);
}
?>

<?php echo $form->errorSummary($payment); ?>
<div class="row-fluid">
    <div class="span2"><?php echo $form->dropDownListRow($payment, 'partner_id', CHtml::listData(CrmHelper::partners($payment->projectId), 'id', 'name')); ?></div>
    <div class="span1"><?php echo $form->dropDownListRow($payment, 'create_user_id', CHtml::listData(User::model()->cache(10800)->active()->findAll(), 'id', 'username'), array('empty' => Yii::t('zii', 'Not set'))); ?></div>
    <div class="span1">
        <label><?php echo Yii::t('CrmModule.payment', 'Client'); ?></label>
        <?php echo CHtml::link(
            '<i class="icon-user"></i> ' . @$payment->client->client_id,
            array('client/update', 'id' => $payment->client_id),
            array('class' => 'btn btn-mini', 'rel' => 'tooltip', 'title' => Yii::t('zii', 'View'), 'style' => 'height: 28px; line-height: 28px; width: 100%', 'target' => '_blank')
        ); ?>
    </div>
    <div class="span1 offset2"><?php if (isset($payment->client)) {echo $form->dropDownListRow(
            $payment,
            'order_id',
            CHtml::listData(
                $payment->client->orders,
                'id',
                'number',
                function ($order) {/** @var ClientOrder $order */
                    return Yii::app()->getDateFormatter()->formatDateTime($order->create_time, 'medium', null);
                }
            )
        );} ?></div>
    <div class="span3"><?php echo $form->textFieldRow($payment, 'name_company', array('autofocus' => 'autofocus')); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($payment, 'name_contact'); ?></div>
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
    <div class="span2 offset2"><?php if(isset($payment->client)) echo $form->textFieldRow($payment->client, 'city', array('disabled' => true)); ?></div>
    <div class="span2"><?php echo $form->datepickerRow($payment, 'create_time', array('disabled' => true, 'style' => 'font-size: 13px', 'options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($payment, 'update_time', array('disabled' => true)); ?></div>
</div>
<?php if (!$payment->isNewRecord): ?>
<hr />

<?php foreach ($payment->paymentMoneysPartner as $money):/** @var PaymentMoney $money */ ?>
<div class="row-fluid" id="money_<?php echo $money->id;?>">
    <div class="span1"><span class="label label-info" style="width: 62px; text-align: center; height: 25px; margin-top: 25px; line-height: 25px"><?php echo Yii::t('CrmModule.payment', 'Partner'); ?></span></div>
    <div class="span1 input-mini"><?php echo $form->datepickerRow($money, "[{$money->id}]date", array('options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($money, "[{$money->id}]amount"); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($money, "[{$money->id}]method", $money->statusMethod->getList()); ?></div>
    <div class="span1"><?php echo CHtml::ajaxButton(
            Yii::t('zii', 'Delete'),
            array('payment/deleteMoney', 'id' => $money->id),
            array('replace' => '#money_' . $money->id),
            array('class' => 'btn', 'style' => 'margin-top: 25px', 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))
        ); ?></div>
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
            array('class' => 'btn', 'confirm' => Yii::t('zii', 'Are you sure you want to delete this item?'))
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
<div class="form-actions" style="margin-bottom: 0; padding-bottom: 0;">
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
                ),
                array(
                    'label' => Yii::t('CrmModule.payment', 'Развернуть все оплаты клиента' . ' (' . (count(@$payment->client->payments))) . ') <i class="icon-arrow-down"></i>',
                    'type' => 'info',
                    'htmlOptions' => array('onclick' => 'jQuery("#payments").toggle()'),
                    'encodeLabel' => false,
                    'visible' => count(@$payment->client->payments) > 0
                )
            ),
        )
    );?>
</div>
<?php $this->endWidget(); ?>
<?php if (count(@$payment->client->payments) > 0) {
    //echo Yii::t('CrmModule.payment', 'остальные оплаты клиента'), 'javascript:jQuery("#payments").toggle("fast");', array('class' => 'btn'));
    $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'payments',
            'type' => 'striped condensed bordered',
            'dataProvider' => new CArrayDataProvider($payment->client->payments),
            'template' => "{items}",
            'htmlOptions' => array('style' => 'font-size: 80%; padding-top: 1px;display:none'),
            'columns' => array(
                array(
                    'header' => Yii::t('CrmModule.payment', 'Order'),
                    'name'        => 'order_id',
                    'value'       => '$data->order_id ? "<span rel=\"tooltip\" title=\"" . $data->clientOrder->create_time . "\">" . $data->clientOrder->number . "</span>"  : " - "',
                    'type'        => 'raw',
                    'htmlOptions' => array('style' => 'width: 20px'),
                ),
                array(
                    'name'   => 'partner.name',
                    'header' => Yii::t('CrmModule.payment', 'Partner'),
                ),
                array(
                    'name'  => 'name_company',
                    'header' => Payment::model()->getAttributeLabel('name_company'),
                    'visible' => '!empty($data->name_company)'
                ),
                array(
                    'name'  => 'name_contact',
                    'header' => Payment::model()->getAttributeLabel('name_contact'),
                    'visible' => '!empty($data->name_company)'
                ),
                array(
                    'name'     => 'client.city',
                    'header' => Payment::model()->getAttributeLabel('city'),
                ),
                array(
                    'name'     => 'comments',
                    'header' => Payment::model()->getAttributeLabel('comments'),
                ),
                array(
                    'name'     => 'payment_amount',
                    'header' => Payment::model()->getAttributeLabel('payment_amount'),
                ),
                array(
                    'name'     => 'paymentMoneyPartner.date',
                    'header'   => Yii::t('CrmModule.paymentMoney', 'Date') . ' ' . Yii::t('CrmModule.payment', 'Partner'),
                    'type'    => 'date',
                ),
                array(
                    'name'        => 'payment',
                    'header' => Payment::model()->getAttributeLabel('payment'),
                    'htmlOptions' => array('style' => 'background-color: WhiteSmoke;')
                ),
                array(
                    'name'        => 'payment_remain',
                    'header' => Payment::model()->getAttributeLabel('payment_remain'),
                    'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
                ),
                array(
                    'name'     => 'paymentMoneyAgent.date',
                    'header'   => Yii::t('CrmModule.paymentMoney', 'Date') . ' ' . Yii::t('CrmModule.payment', 'Reward'),
                    'type'     => 'date',
                ),
                array(
                    'name'     => 'agent_comission_amount',
                    'header' => Payment::model()->getAttributeLabel('agent_comission_amount'),
                    'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
                ),
                array(
                    'name'        => 'agent_comission_received',
                    'header' => Payment::model()->getAttributeLabel('agent_comission_received'),
                    'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
                ),
                array(
                    'name' => 'agent_comission_remain_amount',
                    'header' => Payment::model()->getAttributeLabel('agent_comission_remain_amount'),
                ),
                array(
                    'name'        => 'agent_comission_remain_now',
                    'header' => Payment::model()->getAttributeLabel('agent_comission_remain_now'),
                    'htmlOptions' => array('style' => 'background-color: WhiteSmoke')
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template' => '{update} {delete}'
                ),
            ),
        ));
}
?>