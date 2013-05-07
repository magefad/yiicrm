<?php
Yii::import('bootstrap.widgets.TbExtendedGridView');
/** @property CActiveDataProvider $dataProvider */
class CrmGridView extends TbExtendedGridView
{
    /**
     * @var string|array the table type.
     * Valid values are 'striped', 'bordered', ' condensed' and/or 'hover'.
     *
     */
    public $type = 'striped condensed bordered';

    /**
     * @var boolean whether to leverage the {@link https://developer.mozilla.org/en/DOM/window.history DOM history object}.  Set this property to true
     * to persist state of grid across page revisits.  Note, there are two limitations for this feature:
     * <ul>
     *    <li>this feature is only compatible with browsers that support HTML5.</li>
     *    <li>expect unexpected functionality (e.g. multiple ajax calls) if there is more than one grid/list on a single page with enableHistory turned on.</li>
     * </ul>
     * @since 1.1.11
     */
    public $enableHistory = true;

    /**
     * @var bool $fixedHeader if set to true will keep the header fixed  position
     */
    public $fixedHeader = true;

    public $template = '{pager}{items}{pager}{summary}';

    public $htmlOptions = array('style' => 'font-size: 83%; padding-top: 1px;');

    public function init()
    {
        Yii::app()->clientScript->registerScript('scroll', '$("html, body").animate({scrollTop: $("#projects-tab").position().top}, "fast");', CClientScript::POS_READY);
        parent::init();
    }
}
