<?php

class PaymentMoneyController extends Controller
{
    /**
     * @return array a list of filter configurations.
     */
    public function filters()
    {
        return array(
             'postOnly + delete',/** @see CController::filterPostOnly */
             'ajaxOnly + loadProjects',/** @see CController::filterAjaxOnly */
             array('auth.filters.AuthFilter')/** @see AuthFilter */
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

    public function actionAgent()
    {
        $payment = new Payment;
        $paymentMoney = new PaymentMoney;
        $paymentMoney->type = $paymentMoney::TYPE_AGENT;
        $paymentMoney->date = date('Y-m-d');

        if (isset($_POST['PaymentMoney'], $_POST['Payment']['partner_id'], $_POST['project_id'])) {
            $payment->attributes=$_POST['Payment'];
            $paymentMoney->attributes=$_POST['PaymentMoney'];
            if ($paymentMoney->amount > 10) {
                $payments = Yii::app()->db->createCommand()
                    ->select('p.*, c.client_id')
                    ->from('{{payment}} p')
                    ->leftJoin('{{payment_money}} pp', 'pp.payment_id=p.id')
                    ->leftJoin('{{client}} c', 'c.id=p.client_id')
                    //->where('pp.create_time IS NOT NULL')//old exported paymentMoneys from google docs
                    ->where('pp.type=:type', array(':type' => PaymentMoney::TYPE_PARTNER))
                    ->andWhere('p.partner_id=:id', array(':id' => intval($_POST['Payment']['partner_id'])))
                    ->andWhere('p.agent_comission_remain_now>0')
                    //->andWhere('c.project_id=:id', array(':id' => intval($_POST['project_id'])))
                    ->order('pp.date ASC')
                    ->group('pp.payment_id')
                    //->having('SUM(p.agent_comission_remain_now)<=:sum', array(':sum' => $paymentMoney->amount))
                    ->queryAll();
                $sum = 0;
                /** @var PaymentMoney[] $paymentMoneyNow */
                $paymentMoneyNow = array();
                foreach ($payments as $i => $_payment) {
                    $sum += $_payment['agent_comission_remain_now'];
                    $paymentMoneyNow[$i] = new PaymentMoney;
                    $paymentMoneyNow[$i]->setAttributes(
                        array(
                            'type'       => $paymentMoney->type,
                            'method'     => $paymentMoney->method,
                            'payment_id' => $_payment['id'],
                            'date'       => $paymentMoney->date,
                            'amount'     => $_payment['agent_comission_remain_now'],
                        )
                    );
                    $payments[$i]['passed'] = '<span class="label label-success">' . Yii::t("CrmModule.paymentMoney", "Full payment") . ' </span>';
                    if ($sum >= $paymentMoney->amount) {
                        $nowPay = $_payment['agent_comission_remain_now'] - ($sum - $paymentMoney->amount);
                        $paymentMoneyNow[$i]->setAttribute('amount', $nowPay);
                        $payments[$i]['passed'] = '<span class="label label-warning">' . Yii::t("CrmModule.paymentMoney", "Partial payment") . ': ' . $nowPay . '</span>';
                        break;
                    }
                }
                if (isset($_POST['payNow']) && $_POST['payNow']) {
                    $transaction = Yii::app()->db->beginTransaction();
                    $valid = true;
                    foreach ($paymentMoneyNow as $paymentNow) {
                        /** @var $paymentNow PaymentMoney */
                        if (!$paymentNow->save()) {
                            echo implode(', ', $paymentNow->errors);
                            $valid = false;
                        }
                    }
                    if ($valid) {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success', 'Оплаты успешно распределены в сделки!');
                        $this->redirect(array('agent'));
                    } else {
                        $transaction->rollback();
                    }
                }
            } else {
                $paymentMoney->addError('amount', 'Введите вносимую сумму Агенсктого вознаграждения');
            }
        }
        $this->render('agent', array('payment' => $payment, 'paymentMoney' => $paymentMoney, 'payments' => isset($payments) ? $payments : null));
    }

    public function actionLoadProjects()
    {
        Yii::import('crm.helpers.CrmHelper');
        $projects = CHtml::listData(CrmHelper::partners(Yii::app()->getRequest()->getPost('id')), 'id', 'name');
        echo CHtml::tag('option', array(), ' - ');
        foreach ($projects as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    /*public function actionCreate()
    {
        $model = new PaymentMoney;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PaymentMoney'])) {
            $model->attributes=$_POST['PaymentMoney'];
            if ($model->save()) {
                $this->redirect(array('view', 'id'=>$model->id));
            }
        }

        $this->render('create', array('model' => $model));
    }*/

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    /*public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PaymentMoney'])) {
            $model->attributes = $_POST['PaymentMoney'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array('model' => $model));
    }*/

    /**
     * Deletes a particular model.
     * We only allow deletion via POST request @see CController::filterPostOnly
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param int $id the ID of the model to be deleted
     * @throws CHttpException
     */
    /*public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }*/

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('PaymentMoney');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin($id = null)
    {
        $model = new PaymentMoney('search');
        if (Yii::app()->getRequest()->getParam('clearFilters')) {
            Yii::import('application.components.behaviors.EButtonColumnWithClearFilters');
            EButtonColumnWithClearFilters::clearFilters($this, $model);//where $this is the controller
        }
        //$model->unsetAttributes(); // clear any default values
        if ($id) {
            //$model->setRememberScenario('partner' . $id);
            $model->paymentPartnerId = $id;
        }
        //$model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentMoney'])) {
            $model->attributes = $_GET['PaymentMoney'];
        }
        $model->type = 1;//agent
        if ($id) {
        }

        $this->render('admin', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param int $id the ID of the model to be loaded
     * @throws CHttpException
     * @return PaymentMoney
     */
    public function loadModel($id)
    {
        $model = PaymentMoney::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax']==='payment-money-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
