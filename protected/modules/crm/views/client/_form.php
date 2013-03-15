<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model Client
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'client-form',
        #'type' => 'horizontal',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => 'well')
    )
); ?>

<?php echo $form->errorSummary($model); ?>
<?php
if ($model->isNewRecord && !isset($_GET['id']) || !$_GET['id']) {
    echo $form->dropDownListRow($model, 'project_id', Project::model()->getList());
} else {
    echo $form->hiddenField($model, 'project_id');
}
?>
<div class="row-fluid">
    <div class="span2"><?php echo $form->textFieldRow($model, 'name_company', array('style' => 'width: 100%')); ?></div>
    <div class="span3"><?php echo $form->textFieldRow($model, 'name_contact', array('style' => 'width: 100%')); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($model, 'phone', array('style' => 'width: 100%')); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($model, 'time_zone', array('style' => 'width: 90%')); ?></div>
    <div class="span2"><?php echo $form->textFieldRow($model, 'email', array('style' => 'width: 100%')); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($model, 'site', array('style' => 'width: 100%')); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($model, 'cp', array('style' => 'width: 100%')); ?></div>
</div>
<div class="row-fluid">
    <div class="span2"><?php echo $form->select2Row($model, 'city', array('style' => 'width: 100%', 'data' => $model->getList('city'))); ?></div>
    <div class="span3"><?php echo $form->textFieldRow($model, 'address', array('style' => 'width: 100%')); ?></div>
    <div class="span2"><?php echo $form->select2Row($model, 'sponsor', array('style' => 'width: 100%', 'data' => $model->getList('sponsor'))); ?></div>
    <div class="span2"><?php echo $form->select2Row($model, 'product', array('style' => 'width: 100%', 'data' => $model->getList('product'))); ?></div>
    <div class="span1"><?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList(), array('style' => 'width: 100%')); ?></div>
    <div class="span2"><?php echo $form->datepickerRow(
        $model,
        'next_time',
        array(
            'style'   => 'width: 100%',
            'options' => array(
                'format'             => 'yyyy-mm-dd',
                'weekStart'          => 1,
                'daysOfWeekDisabled' => '6,0',
            ),
            'events' => array('changeDate' => 'js:function(e){$("#Client_next_time").val($("#Client_next_time").val() + " ' . date('H:i:00') . '")}')
        )
    ); ?></div>
</div>
<div class="row-fluid">
    <div class="span4"><?php echo $form->redactorRow($model,'client_request', array('rows' => 6, 'cols' => 50, 'style' => 'width: 100%')); ?></div>
    <div class="span4"><?php echo $form->redactorRow($model,'comment_history', array('rows' => 6, 'cols' => 50, 'style' => 'width: 100%')); ?></div>
    <div class="span4"><?php echo $form->redactorRow($model,'comment_fail', array('rows' => 6, 'cols' => 50, 'style' => 'width: 100%')); ?></div>
</div>
<div class="row-fluid">
    <div class="span4"><?php echo $form->redactorRow($model,'comment_review', array('rows' => 6, 'cols' => 50, 'style' => 'width: 100%')); ?></div>
    <div class="span4"><?php echo $form->redactorRow($model,'description_production', array('rows' => 6, 'cols' => 50, 'style' => 'width: 100%')); ?></div>
    <div class="span4"><?php echo $form->redactorRow($model,'photo', array('rows' => 6, 'cols' => 50, 'style' => 'width: 100%')); ?></div>
</div>
<div class="row-fluid">
    <div class="span2"><?php echo $form->select2Row($model, 'driver', array('style' => 'width: 100%', 'data' => $model->getList('driver'))); ?></div>
    <div class="span2"><?php echo $form->select2Row($model, 'link_type', array('style' => 'width: 100%', 'data' => $model->getList('link_type'))); ?></div>
    <div class="span4"><?php echo $form->textFieldRow($model, 'contract_copy', array('style' => 'width: 98%')); ?></div>
</div>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CrmModule.client', 'Create') : Yii::t('CrmModule.client', 'Save'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
