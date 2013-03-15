<?php

/**
 * @var $this Controller
 * @var $model Project
 */
$this->breadcrumbs = array(
	Yii::t('CrmModule.project', 'Projects') => array('admin'),
	Yii::t('CrmModule.project', 'Manage'),
);

Yii::app()->clientScript->registerScript(
    'search',
    "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('project-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<?php echo CHtml::link(Yii::t('CrmModule.project', 'Search'), '#', array('class' => 'search-button btn btn-small')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget(
    'CrmGridView',
    array(
        'id'                    => 'project-grid',
        'dataProvider'          => $model->search(),
        'filter'                => $model,
        'rowCssClassExpression' => '',
        'columns'               => array(
            array(
                'name'        => 'id',
                'htmlOptions' => array('style' => 'width:20px'),
            ),
            'name',
            'name_short',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
