<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $client Client
 * @var $orders ClientOrder[]
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'client-form',
        #'type' => 'horizontal',
        'enableAjaxValidation' => false,
        'htmlOptions'          => array('class' => 'well')
    )
);
Yii::app()->clientScript->registerCss('input', 'input,select,textarea{width: 100%}');
Yii::app()->clientScript->registerScript('scroll', '$("html, body").animate({scrollTop: $("#client-form").position().top-60}, "fast");', CClientScript::POS_READY);
echo $form->errorSummary($client);
echo $form->errorSummary(isset($order) ? $order : $orders);
if ($client->isNewRecord && !isset($_GET['id']) || !$_GET['id']) {
    echo $form->dropDownListRow($client, 'project_id', Project::model()->getList());
} else {
    echo $form->hiddenField($client, 'project_id');
}
?>
<div class="row-fluid">
    <div class="span3"><?php echo $form->textAreaRow($client, 'name_company'); ?></div>
    <div class="span3"><?php echo $form->textAreaRow($client, 'name_contact'); ?></div>
    <div class="span2"><?php echo $form->textAreaRow($client, 'phone'); ?></div>
    <div class="span2"><?php echo $form->textAreaRow($client, 'email'); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($client, 'time_zone'); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($client, 'site'); ?></div>
</div>
<div class="row-fluid">
    <div class="span3"><?php echo $form->typeAheadRow($client, 'city', array('source' => array_values($client->getList('city')))); ?></div>
    <div class="span3"><?php echo $form->textFieldRow($client, 'address'); ?></div>
    <div class="span2"><?php echo $form->datepickerRow($client, 'next_time',
            array(
                'options' => array('format' => 'yyyy-mm-dd'),
                //'events' => array('hide' => 'js:function(e){var c=$("#Client_next_time");if(c.val().length)c.val(c.val() + " ' . date('H:i:00') . '")}')
            )
        ); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($client, 'status', $client->statusMain->getList()); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($client, 'cp', array('' => Yii::t('zii', 'Not set'), 1 => Yii::t('CrmModule.client', 'Есть'), 0 => Yii::t('CrmModule.client', 'Нет'))); ?></div>
</div>
<?php
$tabs[0] = array(
    'id'      => 'TabNewOrder',
    'label'   => '<i class="icon-plus"></i>',
    'content' => $this->renderPartial('_formOrder', array('order' => isset($order) ? $order : new ClientOrder()), true),
);
if (isset($orders)) {
    $i = count($orders)+1;
    foreach ($orders as $order) {
        $tabs[] = array(
            'label' => (--$i) . ' - ' . Yii::app()->locale->getDateFormatter()->formatDateTime($order->create_time, 'long', null),
            'content' => $this->renderPartial('_formOrder', array('order' => $order), true)
        );
    }
    $tabs[1]['active'] = true;
} else {
    $tabs[0]['active'] = true;
}
$this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type'        => 'pills',
        'tabs'        => $tabs,
        'encodeLabel' => false,
    )
);
?>
<div class="form-actions">
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'label'      => $client->isNewRecord ? Yii::t('CrmModule.client', 'Create and continue') : Yii::t('CrmModule.client', 'Save and continue'),
        )
    ); ?>
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'exit'),
            'type'       => 'primary',
            'label'      => $client->isNewRecord ? Yii::t('CrmModule.client', 'Create and exit') : Yii::t('CrmModule.client', 'Save and exit'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
