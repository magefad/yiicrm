<?php
/**
 * @var $form TbActiveForm
 * @var $order ClientOrder
 */
if (!isset($form)) {
    Yii::import('bootstrap.widgets.TbActiveForm', true);
    $form = new TbActiveForm();
}
$id = $order->id;
if ($order->isNewRecord) {
    echo CHtml::hiddenField('saveNewOrder', 0, array('id' => 'saveNewOrder'));
    $id = 0;
    Yii::app()->clientScript->registerScript('newOrder', '
    jQuery("#TabNewOrder input[type=text], #TabNewOrder textarea").change(function() {
        jQuery("#saveNewOrder").val(1);
    });
    ');
}
?>
<div class="row-fluid">
    <div class="span4"><?php echo $form->textAreaRow($order, "[$id]client_request", array('rows' => 6)); ?></div>
    <div class="span4"><?php echo $form->textAreaRow($order, "[$id]comment_history", array('rows' => 6)); ?></div>
    <div class="span1"><?php echo $form->dropDownListRow($order, "[$id]create_user_id", CHtml::listData(User::model()->cache(10800)->findAll(), 'id', 'username'), array('empty' => Yii::t('zii', 'Not set'))); ?></div>
    <div class="span1"><?php echo $form->dropDownListRow($order, "[$id]photo", array(Yii::t('CrmModule.client', 'Нет'), Yii::t('CrmModule.client', 'Есть')), array('empty' => Yii::t('zii', 'Not set'))); ?></div>
    <div class="span2"><?php echo $form->dropDownListRow($order, "[$id]contract_copy", array('' => Yii::t('zii', 'Not set'), 1 => Yii::t('CrmModule.client', 'Есть'), 0 => Yii::t('CrmModule.client', 'Нет'))); ?></div>
    <div class="span2"><?php echo $form->typeAheadRow($order, "[$id]product", array('source' => array_values($order->getList('product')))); ?></div>
    <div class="span2"><?php echo $form->typeAheadRow($order, "[$id]sponsor", array('source' => array_values($order->getList('sponsor'))), array('style' => 'width: 93%')); ?></div>
</div>
<div class="row-fluid">
    <div class="span4"><?php echo $form->textAreaRow($order, "[$id]comment_review", array('rows' => 6)); ?></div>
    <div class="span4"><?php echo $form->textAreaRow($order, "[$id]comment_fail", array('rows' => 6)); ?></div>
    <div class="span4"><?php echo $form->textAreaRow($order, "[$id]description_production", array('rows' => 6, 'style' => 'width: 96%')); ?></div>
</div>