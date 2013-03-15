<?php
$this->breadcrumbs = array(
    Yii::t('CrmModule.project', 'Projects') => array('admin'),
);

?>

<h1>Projects</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>
