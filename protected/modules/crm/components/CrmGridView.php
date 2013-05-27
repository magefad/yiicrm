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

    public $pager = array('class' => 'bootstrap.widgets.TbPager', 'maxButtonCount' => 25);

    public $htmlOptions = array('style' => 'font-size: 83%; padding-top: 1px;');

    public function init()
    {
        Yii::app()->getClientScript()
            ->registerScript('scroll', '$("html, body").animate({scrollTop: $("#projects-tab").position().top}, "fast");', CClientScript::POS_READY)
            ->registerCss('all', '
#projects-tab {
    margin-bottom: 0;
}
td a.editable {
    color: #333333;
    border-bottom: none;
}
table.items {
    min-width: 1200px;
}
table.items a.sort-link {
    font-size: 80%;
    line-height: 12px;
}
table.items tr td {
    word-wrap: break-word;
}
table.items tr td div.compact {
    width: 70px;
    max-height: 25px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
table.items tr.filters td.mini div.filter-container {
    padding-right: 0;
}
table.items tr.filters td.mini div.filter-container select {
    padding: 0;
    width: 19px !important;
}
table.items tr.filters td.selected select {
    border: 1px solid yellow;
}
table.items tr.opacity {
    opacity: 0.6;
    filter: alpha(opacity=60);
    -webkit-transition: opacity 0.15s linear;
     -moz-transition: opacity 0.15s linear;
       -o-transition: opacity 0.15s linear;
          transition: opacity 0.15s linear;
}
table.items tr.opacity:hover {
    opacity: 1;
    filter: alpha(opacity=100);
}
');
        parent::init();
    }
}
