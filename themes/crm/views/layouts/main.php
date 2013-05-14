<!DOCTYPE html>
<html lang="<?php echo Yii::app()->getLanguage(); ?>">
<head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<?php
/** @var $this Controller */
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'type'        => 'inverse',
        'fixed'       => false,
        'brand'       => CHtml::encode(Yii::app()->name),
        'brandUrl'    => '/',
        'htmlOptions' => array('style' => 'margin-bottom: 0'),
        'items'       => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => array('label' => 'Позвонить', 'url' => '/crm/client/admin/?Client[next_time]=' . date('Y-m-d') . '&Client_page=1')
            ),
            array(
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'items'       => array(
                    array(
                        'label'   => 'Управление',
                        'visible' => Yii::app()->user->checkAccess('Admin'),
                        'items'   => array(
                            array('label' => 'Права доступа', 'url' => array('/auth')),
                            array('label' => 'Пользователи', 'url' => array('/user/default/admin'))
                        )
                    ),
                    array(
                        'label'   => 'Войти',
                        'url'     => array('/user/account/login'),
                        'visible' => Yii::app()->user->isGuest
                    ),
                    array(
                        'label'       => 'Выйти',
                        'url'         => array('/user/account/logout'),
                        'visible'     => !Yii::app()->user->isGuest,
                        'htmlOptions' => array('class' => 'btn')
                    ),
                )
            )
        )
    )
);
?>
<?php if ((Yii::app()->user->checkAccess('Admin') || Yii::app()->user->checkAccess('Editor')) && $this->menu): ?>
<div class="menu-admin well">
<?php
$this->beginWidget('bootstrap.widgets.TbMenu', array('type' => 'list', 'items' => $this->menu));
$this->endWidget();
?>
</div>
<?php endif ?>
<div class="container-fluid">
<?php if (isset($this->breadcrumbs)) {
    $this->widget(
        'bootstrap.widgets.TbBreadcrumbs',
        array(
            'links'     => $this->breadcrumbs,
            'separator' => ' / ',
            'homeLink'  => CHtml::link('Главная', Yii::app()->getHomeUrl()),
        )
    );
}
$this->widget('bootstrap.widgets.TbAlert');
echo $content;
?>
</div>
<footer class="footer">
    <div class="container">
<?php #$this->widget('ext.performance.widgets.statistic');?>
    </div>
</footer>
</body>
</html>
