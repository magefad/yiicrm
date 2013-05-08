<?php
/**
 * @var $form TbActiveForm
 * @var $this Controller
 * @var $model Client
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
<?php echo $form->textFieldRow($model, 'client_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'manager', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name_company', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'name_contact', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'time_zone', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'phone', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'email', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'site', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'city', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'address', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'driver', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'product', array('class' => 'span5')); ?>
<?php echo $form->textAreaRow($model,'client_request', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'link_type', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'sponsor', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'status', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'cp', array('class' => 'span5')); ?>
<?php echo $form->textAreaRow($model,'comment_history', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textAreaRow($model,'comment_fail', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'contract_copy', array('class' => 'span5')); ?>
<?php echo $form->textAreaRow($model,'comment_review', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textAreaRow($model,'photo', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textAreaRow($model,'description_production', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>
<?php echo $form->textFieldRow($model, 'create_user_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'update_user_id', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span5')); ?>
<?php echo $form->textFieldRow($model, 'next_time', array('class' => 'span5')); ?>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => Yii::t('CrmModule.client', 'Search'),
    )
); ?>
</div>

<?php $this->endWidget(); ?>
