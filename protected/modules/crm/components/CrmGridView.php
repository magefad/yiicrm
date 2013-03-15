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
    public $type = 'striped condensed';

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

    public $hoverIntent = false;

    public function init()
    {
        parent::init();
        if ($this->hoverIntent) {
            $assets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('crm.assets'));
            Yii::app()->clientScript->registerScriptFile($assets . '/jquery.hoverIntent.minified.js');
            $config = CJavaScript::encode(array('over' => 'makeTall', 'timeOut' => 500, 'out' => 'makeShort'));
            $script = <<<JS
jQuery("table.items tr").hoverIntent({
    sensitivity: 3, // number = sensitivity threshold (must be 1 or higher)
    interval: 200, // number = milliseconds for onMouseOver polling interval
    timeout: 500, // number = milliseconds delay before onMouseOut
    over:function(){
        $(this).find('div.compact').removeClass('compact');
    },
    out: function(){
        $(this).find('div').addClass('compact');
    }
});
JS;

            Yii::app()->clientScript->registerScript('hoverIntent', $script);
        }
    }

}
