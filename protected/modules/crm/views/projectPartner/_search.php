<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model ProjectPartner
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>

<?php echo $form->textFieldRow($model, 'id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'project_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name_short', array('class' => 'span5')); ?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('CrmModule.projectPartner', 'Search'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
