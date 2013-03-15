<?php
/**
 * @var $form TBActiveForm
 * @var $this Controller
 * @var $model Client
 */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'type'   => 'inline',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )
); ?>
<?php echo $form->dropDownListRow($model, 'status', $model->statusMain->getList()); ?>
<?php $this->endWidget(); ?>
