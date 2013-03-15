<?php
$this->breadcrumbs = array(
    Yii::t('CrmModule.projectPartner', 'Project Partners') => array('admin'),
);

?>

<h1>Project Partners</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_view',
)); ?>
