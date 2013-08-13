<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $payment Payment
 * @var $paymentMoney PaymentMoney
 * @var $payments array()
 */
Yii::import('crm.helpers.CrmHelper');
Yii::import('crm.components.CrmGridView');
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'payment-money-form',
        'enableAjaxValidation' => false,
        'type'                 => 'inline',
        'htmlOptions'          => array('class' => 'well')
    )
);
echo $form->errorSummary($paymentMoney);
echo CHtml::hiddenField('payNow', '0');
echo CHtml::dropDownList(
            'project_id',
            @$_POST['project_id'],
            CHtml::listData(CrmHelper::projects(), 'id', 'name'),
            array(
                'empty' => ' - ' . Yii::t('CrmModule.payment', 'Project') . ' - ',
                'style' => 'width: 110px',
                'ajax'  => array(
                    'type'   => 'POST',
                    'url'    => $this->createUrl('loadProjects'),
                    'update' => '#Payment_partner_id',
                    'data'   => array('id' => 'js:this.value')
                )
            )
        ); ?>
<?php echo $form->dropDownList(
    $payment,
    'partner_id',
    isset($_POST['project_id']) ? CHtml::listData(CrmHelper::partners(intval($_POST['project_id'])), 'id', 'name') : array(),
    array('empty' => 'Сначала выберите проект', 'style' => 'margin-right:20px')
); ?>
<?php echo $form->datepickerRow($paymentMoney, 'date', array('style' => 'width: 80px; margin-left: 5px', 'options' => array('format' => 'yyyy-mm-dd'))); ?>
<?php echo $form->textFieldRow($paymentMoney, 'amount', array('class' => 'span1')); ?>
<?php echo $form->dropDownList($paymentMoney, "method", $paymentMoney->statusMethod->getList(), array('style' => 'width: 105px')); ?>
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => Yii::t('zii', 'View') . ' ' . strtolower(Yii::t('CrmModule.paymentMoney', 'Not paid transactions')),
        )
    ); ?>

<?php $this->endWidget();
if ($payments) {
    Yii::app()->clientScript->registerScript('scroll', '$("html, body").animate({scrollTop: $("#payments").position().top-58}, "fast");', CClientScript::POS_READY);
    $this->widget('bootstrap.widgets.TbGridView', array(
            'id' => 'payments',
            'type' => 'striped condensed bordered',
            'dataProvider' => new CArrayDataProvider($payments),
            'template' => "{items}",
            'htmlOptions' => array('class' => 'pull-left', 'style' => 'font-size: 80%; padding-top: 1px;'),
            'columns' => array(
                array(
                    'name'  => 'name_company',
                    'header' => Payment::model()->getAttributeLabel('name_company'),
                    'visible' => '!empty($data->name_company)',
                ),
                array(
                    'name'  => 'name_contact',
                    'header' => Payment::model()->getAttributeLabel('name_contact'),
                    'visible' => '!empty($data->name_company)'
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
                    'header' => Yii::t('CrmModule.paymentMoney', 'Payment'),
                    'value' => 'isset($data["passed"]) ? $data["passed"] : \'<span class="label">&nbsp; - &nbsp;</span>\'',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center')
                ),
                array(
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                    'template' => '{update}',
                    'updateButtonUrl' => 'Yii::app()->createUrl("/crm/payment/update", array("id"=>$data["id"]))',
                ),
            ),
        ));
    $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('CrmModule.paymentMoney', 'Pay') . ' ' . Yii::t('CrmModule.paymentMoney', 'Not paid transactions') . ' <i class="icon icon-ok inverse"></i>',
            'type' => 'success',
            'encodeLabel' => false,
            'htmlOptions' => array('onclick' => '$("#payNow").val(1);$("#payment-money-form").submit();return true;', 'style' => 'margin-bottom: 10px')
        ));
}

