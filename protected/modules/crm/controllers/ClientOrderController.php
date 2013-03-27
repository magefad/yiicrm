<?php

class ClientOrderController extends Controller
{
    public function actionUpdateEditable()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('ClientOrder');
        $es->update();
    }
}
