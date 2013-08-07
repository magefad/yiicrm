<?php if (!isset($_COOKIE['useTab'])):?>
<div class="alert alert-info fade in" id="alert-tab">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Ахтунг!</strong> Используйте клавишу <span class="label label-inverse">Tab ⇆</span> для перехода к следующему полю для заполнения
</div>
<?php
endif;
Yii::app()->getClientScript()->registerCoreScript('cookie')->registerScript('tab', '
$("#client-form").keyup(function(e) {
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
 * @var $client Client
 * @var $orders ClientOrder[]
 * @var $order ClientOrder new Order
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'client-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => array('class' => 'well')
    )
);
Yii::app()->getClientScript()
    ->registerCss('input', 'input,textarea{width: 100%}select{width:125%}.label-mini label{font-size: 96%;white-space: nowrap}.label-mini input{font-size: 96%}.select-mini select, .select-mini span{font-size: 82%; line-height: 14px;}')
    ->registerScript('scroll', '$("html, body").animate({scrollTop: $("#client-form").position().top-115}, "fast");', CClientScript::POS_READY);
echo $form->errorSummary($client);
echo $form->errorSummary(isset($order) ? $order : $orders);
/*if ($client->isNewRecord && !isset($_GET['id']) || !$_GET['id']) {
    echo $form->dropDownListRow($client, 'project_id', Project::model()->getList(), array('class' => 'span3'));
} else {
    echo $form->hiddenField($client, 'project_id');
}*/
if (isset($_GET['call'])) {
    echo CHtml::hiddenField('call');
}
?>
<div class="row-fluid">
    <div class="span3"><?php echo $form->textAreaRow($client, 'name_company', array('autofocus' => 'autofocus')); ?></div>
    <div class="span3"><?php echo $form->textAreaRow($client, 'name_contact'); ?></div>
    <div class="span2"><?php echo $form->textAreaRow($client, 'phone'); ?></div>
    <div class="span2"><?php echo $form->textAreaRow($client, 'email'); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($client, 'time_zone'); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($client, 'site'); ?></div>
</div>
<div class="row-fluid">
    <div class="span1 select-mini"><?php echo $form->dropDownListRow($client, 'project_id', Project::model()->getList());?></div>
    <div class="span2"><?php echo $form->typeAheadRow($client, 'city', array('source' => array_values($client->getList('city')))); ?></div>
    <div class="span3"><?php echo $form->textFieldRow($client, 'address'); ?></div>
    <div class="span1 label-mini"><?php echo $form->datepickerRow($client, 'create_time', array('options' => array('format' => 'yyyy-mm-dd'))); ?></div>
    <div class="span1 label-mini select-mini"><?php echo $form->dropDownListRow($client, 'call_source', $client->statusSource->getList(), array('empty' => Yii::t('zii', 'Not set'))); ?></div>
    <div class="span2"><?php echo $form->datepickerRow($client, 'next_time',
            array(
                'options' => array('format' => 'yyyy-mm-dd'),
                //'events' => array('hide' => 'js:function(e){var c=$("#Client_next_time");if(c.val().length)c.val(c.val() + " ' . date('H:i:00') . '")}')
            )
        ); ?></div>
    <div class="span1 select-mini"><?php echo $form->dropDownListRow($client, 'status', $client->statusMain->getList(), array('empty' => Yii::t('zii', 'Not set'))); ?></div>
    <div class="span1 select-mini"><?php echo $form->dropDownListRow($client, 'cp', array('' => Yii::t('zii', 'Not set'), 1 => Yii::t('CrmModule.client', 'Есть'), 0 => Yii::t('CrmModule.client', 'Нет'))); ?></div>
</div>
<?php
$tabs[0] = array(
    'id'      => 'TabNewOrder',
    'label'   => '<i class="icon-plus"></i>',
    'content' => $this->renderPartial('_formOrder', array('order' => isset($order) ? $order : new ClientOrder()), true),
);
if (isset($orders)) {
    foreach ($orders as $_order) {
        $tabs[] = array(
            'label' => $_order->number . ' - ' . Yii::app()->getLocale()->getDateFormatter()->formatDateTime($_order->create_time, 'long', null),
            'content' => $this->renderPartial('_formOrder', array('order' => $_order), true)
        );
    }
    $tabs[$order->hasErrors() ? 0 : 1]['active'] = true;
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
        'bootstrap.widgets.TbButtonGroup',
        array(
            'buttons' => array(
                array(
                    'buttonType' => 'submit',
                    'type'       => 'success',
                    'label'      => $client->isNewRecord ? Yii::t('CrmModule.client', 'Create and continue') : Yii::t('CrmModule.client', 'Save and continue')
                ),
                array(
                    'buttonType'  => 'submit',
                    'htmlOptions' => array('name' => 'exit'),
                    'type'        => 'primary',
                    'label'       => $client->isNewRecord ? Yii::t('CrmModule.client', 'Create and exit') : Yii::t('CrmModule.client', 'Save and exit')
                ),
                array(
                    'label'       => Yii::t('CrmModule.client', 'Back'),
                    'htmlOptions' => array('onclick' => 'parent.history.back()')
                )
            ),
        )
    );?>
</div>

<?php $this->endWidget(); ?>
