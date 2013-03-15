
<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model ProjectPartner
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                   => 'project-partner-form',
        'enableAjaxValidation' => false,
    )
); ?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'project_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name_short', array('class' => 'span5')); ?>
<div class="form-actions">
    <?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CrmModule.projectPartner', 'Create') : Yii::t('CrmModule.projectPartner', 'Save'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
