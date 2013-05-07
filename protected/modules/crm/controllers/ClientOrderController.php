<?php

class ClientOrderController extends Controller
{
    /**
     * @return array a list of filter configurations.
     */
    public function filters()
    {
        return array(
            'ajaxOnly + updateEditable',/** @see CController::filterAjaxOnly */
            array('auth.filters.AuthFilter - updateEditable')/** @see AuthFilter */
        );
    }

    public function actionUpdateEditable()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('ClientOrder');
        $es->onBeforeUpdate = function($event) {
            if (Yii::app()->user->getIsGuest()) {
                $event->sender->error(Yii::t('yii', 'Login Required'));
            }
        };
        $es->update();
    }
}
