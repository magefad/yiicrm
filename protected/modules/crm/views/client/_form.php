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
);
Yii::app()->clientScript->registerCss('input', 'input,select,textarea{width: 100%}');
Yii::app()->clientScript->registerScript('scroll', '$("html, body").animate({scrollTop: $("#client-form").position().top-60}, "slow");', CClientScript::POS_READY);
echo $form->errorSummary($model);
if ($model->isNewRecord && !isset($_GET['id']) || !$_GET['id']) {
    echo $form->dropDownListRow($model, 'project_id', Project::model()->getList());
} else {
    echo $form->hiddenField($model, 'project_id');
}
?>
<div class="row-fluid">
    <div class="span2"><?php echo $form->textAreaRow($model, 'name_company'); ?></div>
    <div class="span3"><?php echo $form->textAreaRow($model, 'name_contact'); ?></div>
    <div class="span2"><?php echo $form->textAreaRow($model, 'phone'); ?></div>
    <div class="span2"><?php echo $form->textAreaRow($model, 'email'); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($model, 'time_zone'); ?></div>
    <div class="span1"><?php echo $form->textFieldRow($model, 'site'); ?></div>
    <div class="span1"><?php echo $form->dropDownListRow(
            $model,
            'cp',
            array('' => Yii::t('zii', 'Not set'), 1 => Yii::t('CrmModule.client', 'Есть'), 0 => Yii::t('CrmModule.client', 'Нет')),
            array('style' => 'width: 100%')
        ); ?></div>
</div>
<div class="row-fluid">
    <div class="span2"><?php echo $form->typeAheadRow($model, 'city', array('source' => array_values($model->getList('city')))); ?></div>
    <div class="span3"><?php echo $form->textFieldRow($model, 'address'); ?></div>
    <div class="span1"><?php echo $form->typeAheadRow($model, 'product', array('source' => array_values($model->getList('product')))); ?></div>
    <div class="span1"><?php echo $form->typeAheadRow($model, 'sponsor', array('source' => array_values($model->getList('sponsor')))); ?></div>
    <div class="span2"><?php echo $form->datepickerRow(
            $model,
            'next_time',
            array(
                'options' => array('format' => 'yyyy-mm-dd'),
                'events' => array('hide' => 'js:function(e){var c=$("#Client_next_time");if(c.val().length)c.val(c.val() + " ' . date('H:i:00') . '")}')
            )
        ); ?></div>
    <div class="span1"><?php echo $form->dropDownListRow($model, 'create_user_id', CHtml::listData(User::model()->cache(3600)->findAll(), 'id', 'username')); ?></div>
    <div class="span1"><?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?></div>
</div>
<div class="row-fluid">
    <div class="span4"><?php echo $form->textAreaRow($model, 'client_request', array('rows' => 6, 'cols' => 50)); ?></div>
    <div class="span4"><?php echo $form->textAreaRow($model, 'comment_history', array('rows' => 6, 'cols' => 50)); ?></div>
    <div class="span4"><?php echo $form->textAreaRow($model, 'comment_fail', array('rows' => 6, 'cols' => 50)); ?></div>
</div>
<div class="row-fluid">
    <div class="span4"><?php echo $form->textAreaRow($model, 'comment_review', array('rows' => 6)); ?></div>
    <div class="span4"><?php echo $form->textAreaRow($model, 'description_production', array('rows' => 6)); ?></div>
    <div class="span4"><?php echo $form->textAreaRow($model, 'photo', array('rows' => 2));
        echo $form->textFieldRow($model, 'contract_copy'); ?>
    </div>
</div>
<div class="form-actions">
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'label'      => $model->isNewRecord ? Yii::t('CrmModule.client', 'Create and continue') : Yii::t('CrmModule.client', 'Save and continue'),
        )
    ); ?>
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'exit'),
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('CrmModule.client', 'Create and exit') : Yii::t('CrmModule.client', 'Save and exit'),
        )
    ); ?>
</div>

<?php $this->endWidget(); ?>
