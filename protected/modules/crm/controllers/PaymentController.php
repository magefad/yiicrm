<?php

class PaymentController extends Controller
{
    /**
     * @var string the name of the default action. Defaults to 'admin'.
     */
    public $defaultAction = 'admin';

    /**
     * @return array a list of filter configurations.
     */
    public function filters()
    {
        return array(
            'postOnly + delete',/** @see CController::filterPostOnly */
            'ajaxOnly + updateEditable, deleteMoney',/** @see CController::filterAjaxOnly */
            array('auth.filters.AuthFilter - updateEditable')/** @see AuthFilter */
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id = 0)
    {
        $payment = new Payment;
        $paymentMoney = new PaymentMoney;
        if ($id) {
            $payment->projectId = intval($id);
        }
        if (isset($_GET['client_id'])) {
            if (Client::model()->findByPk(intval($_GET['client_id'])) !== null) {
                $payment->client_id = $_GET['client_id'];
            }
        }
        $payment->create_user_id = Yii::app()->user->getId();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Payment'], $_POST['PaymentMoney'][0])) {
            $transaction = $payment->getDbConnection()->beginTransaction();
            $payment->attributes = $_POST['Payment'];
            $paymentMoney->attributes = $_POST['PaymentMoney'][0];
            if ($payment->save()) {
                $paymentMoney->payment_id = $payment->getPrimaryKey();
                if ($paymentMoney->save()) {
                    $transaction->commit();
                    if (isset($_POST['exit'])) {
                        $this->redirect(array('admin', 'id' => $payment->partner->project_id));
                    } else {
                        $this->redirect(array('update', 'id' => $payment->id));
                    }
                } else {
                    $transaction->rollback();
                }
            } else {
                $payment->getErrors();
            }
        }

        $this->render('create', array('payment' => $payment, 'paymentMoney' => $paymentMoney));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        //$payment = $this->loadModel($id);
        /** @var Payment $payment */
        $payment = Payment::model()->with('client')->findByPk($id);
        if ($payment===null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $paymentMoneys = PaymentMoney::model()->findAllByAttributes(
            array('payment_id' => $payment->id),
            array('order' => 'id DESC')
        );
        $paymentMoney = new PaymentMoney();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Payment'])) {
            $payment->attributes = $_POST['Payment'];
            $valid = true;
            if (isset($_POST['PaymentMoney'][0]) && intval($_POST['PaymentMoney'][0]['amount'])) {//new PaymentMoney
                $paymentMoney->attributes = $_POST['PaymentMoney'][0];
                $paymentMoney->payment_id  = $id;
                if (!$paymentMoney->save()) {
                    $valid = false;
                }
            }
            foreach ($paymentMoneys as $_paymentMoney) {
                /** @var $_paymentMoney PaymentMoney */
                if (isset($_POST['PaymentMoney'][$_paymentMoney->id])) {
                    $_paymentMoney->attributes = $_POST['PaymentMoney'][$_paymentMoney->id];
                    if (!$_paymentMoney->save()) {
                        $valid = false;
                    }
                }
            }
            if ($payment->save() && $valid) {
                if (isset($_POST['exit'])) {
                    $this->redirect(array('admin', 'id' => $payment->partner->project_id));
                } else {
                    $this->redirect(array('update', 'id' => $payment->id));
                }
            }
        }
        $this->render('update', array('payment' => $payment, 'paymentMoney' => $paymentMoney));
    }

    /**
     * Deletes a particular model.
     * We only allow deletion via POST request @see CController::filterPostOnly
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param int $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionDeleteMoney($id)
    {
        if (PaymentMoney::model()->deleteByPk($id) ) {
            echo 'Ok';
        } else {
            echo 'Error';
        }
        Yii::app()->end();
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Payment');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     * @var integer $id Project Id
     */
    public function actionAdmin($id = null)
    {
        $model = new Payment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Payment'])) {
            $model->attributes = $_GET['Payment'];
        }
        if ($id) {
            $model->projectId = $id;
        }

        $this->render('admin', array('model' => $model));
    }

    public function actionUpdateEditable()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Payment');
        $es->onBeforeUpdate = function($event) {
            if (Yii::app()->user->getIsGuest()) {
                $event->sender->error(Yii::t('yii', 'Login Required'));
            }
        };
        $es->update();
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param int $id the ID of the model to be loaded
     * @throws CHttpException
     * @return Payment
     */
    public function loadModel($id)
    {
        $model = Payment::model()->findByPk($id);
        if ($model===null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax']==='payment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
