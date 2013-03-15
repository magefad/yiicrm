<?php

/**
 * @var $this Controller
 * @var $model ProjectPartner
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.projectPartner', 'Project Partners') => array('admin'),
	Yii::t('CrmModule.projectPartner', 'Manage'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('project-partner-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php echo CHtml::link(Yii::t('CrmModule.projectPartner', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'CrmGridView',
    array(
        'id'                    => 'project-partner-grid',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'rowCssClassExpression' => '',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            //'project_id',
            array('name' => 'projectSearch', 'value' => '$data->project->name'),
            'name',
            'name_short',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
