<?php
Yii::import('bootstrap.widgets.TbEditableColumn');
class PopoverColumn extends TbEditableColumn
{
    private $_isScriptRendered = false;
    public $icon = 'comment';

    /**
     * Renders the data cell content.
     * This method evaluates {@link value} or {@link name} and renders the result.
     * @param integer $row the row number (zero-based)
     * @param mixed $data the data associated with the row
     */
    protected function renderDataCellContent($row, $data)
    {
        $options = CMap::mergeArray($this->editable, array(
                'model'     => $data,
                'attribute' => $this->name,
                'parentid'  => $this->grid->id,
            ));

        //if value defined for column --> use it as element text
        if(strlen($this->value)) {
            ob_start();
            $this->parentRenderDataCellContent($row, $data);
            $text = ob_get_clean();
            $options['text'] = $text;
            $options['encode'] = false;
        }

        /** @var $widget TbEditableField */
        $widget = $this->grid->controller->createWidget('TbEditableField', $options);

        //if editable not applied --> render original text
        if(!$widget->apply) {

            if(isset($text)) {
                echo $text;
            } else {
                $this->parentRenderDataCellContent($row, $data);
            }
            return;
        }

        //manually make selector non unique to match all cells in column
        $selector = get_class($widget->model) . '_' . $widget->attribute;
        $widget->htmlOptions['rel'] = $selector;

        //can't call run() as it registers clientScript
        echo CHtml::openTag('div', array('class' => 'compact'));
        $widget->renderLink();
        echo CHtml::closeTag('div');

        //manually render client script (one for all cells in column)
        if (!$this->_isScriptRendered) {
            $script = $widget->registerClientScript();
            //use parent() as grid is totally replaced by new content
            Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->grid->id . $selector.'-event', '
                $("#'.$this->grid->id.'").parent().on("ajaxUpdate.yiiGridView", "#'.$this->grid->id.'", function() {'.$script.'});
            ');
            $this->_isScriptRendered = true;
        }
    }

    private function parentRenderDataCellContent($row,$data)
    {
        if($this->value!==null)
            $value=$this->evaluateExpression($this->value,array('data'=>$data,'row'=>$row));
        elseif($this->name!==null)
            $value=CHtml::value($data,$this->name);
        echo $value===null ? $this->grid->nullDisplay : $this->grid->getFormatter()->format($value,$this->type);
    }
}
