<?php

class ClientController extends Controller
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
            'ajaxOnly + updateEditable',/** @see CController::filterAjaxOnly */
            array('auth.filters.AuthFilter - updateEditable')/** @see AuthFilter */
        );
    }

    public function actions()
    {
        return array(
            'toggle' => array(
                'class'     => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'Client',
            )
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
     * @var int $id project id
     */
    public function actionCreate($id = 0)
    {
        $client = new Client;
        $order = new ClientOrder;
        $order->create_user_id = Yii::app()->user->getId();
        if ($id) {
            $client->project_id = intval($id);
        }

        $client->create_time = date('Y-m-d');
        $client->update_time = $client->create_time;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Client'], $_POST['ClientOrder'][0])) {
            $transaction = $client->getDbConnection()->beginTransaction();
            $client->attributes = $_POST['Client'];
            $order->attributes = $_POST['ClientOrder'][0];
            if ($client->save()) {
                $order->client_id = $client->primaryKey;
                if ($order->save()) {
                    $transaction->commit();
                    if (isset($_POST['exit'])) {
                        $this->redirect(array('admin', 'id' => $client->project_id));
                    } else {
                        $this->redirect(array('update', 'id' => $client->id));
                    }
                } else {
                    $transaction->rollback();
                }
            }
        }

        $this->render('create', array('client' => $client, 'order' => $order));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $client = $this->loadModel($id);
        $orders = ClientOrder::model()->findAllByAttributes(
            array('client_id' => $client->id),
            array('order' => 'id DESC')
        );
        $order = new ClientOrder;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Client'], $_POST['ClientOrder'])) {
            $client->attributes = $_POST['Client'];
            $valid = true;
            if (isset($_POST['ClientOrder'][0], $_POST['saveNewOrder']) && $_POST['saveNewOrder']) {//new ClientOrder
                $order->attributes = $_POST['ClientOrder'][0];
                $order->client_id  = $id;
                if (!$order->save()) {
                    $valid = false;
                }
            }
            if ($client->status == 0) {
                $orders['0']->setScenario('fail');
            }
            foreach ($orders as $_order) {
                /** @var $_order ClientOrder */
                if (isset($_POST['ClientOrder'][$_order->id])) {
                    $_order->attributes = $_POST['ClientOrder'][$_order->id];
                    if (!$_order->save()) {
                        $valid = false;
                    }
                }
            }
            if ($client->save()) {
                if (isset($_POST['exit']) && $valid) {
                    if (isset($_POST['call'])) {
                        $this->redirect(array('admin'));
                    } else {
                        $this->redirect(array('admin', 'id' => $client->project_id));
                    }
                } else if ($valid) {
                    $this->redirect(array('update', 'id' => $client->id));
                }
            }
        }

        $this->render('update', array('client' => $client, 'orders' => $orders, 'order' => $order));
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

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Client');
        $this->render('index', array('dataProvider' => $dataProvider));
    }

    /**
     * Manages all models.
     * @var integer $id Project Id
     */
    public function actionAdmin($id = null)
    {
        $model = new Client('search');
        if (Yii::app()->getRequest()->getParam('clearFilters')) {
            Yii::import('application.components.behaviors.EButtonColumnWithClearFilters');
            EButtonColumnWithClearFilters::clearFilters($this, $model);//where $this is the controller
        }
        //$model->unsetAttributes(); // clear any default values
        if (isset($id)) {
            $model->setRememberScenario('project' . $id);
            $model->project_id = intval($id);
        }
        /*if (isset($_GET['Client'])) {
            $model->attributes = $_GET['Client'];
        }*/

        $this->render('admin', array('model' => $model));
    }

    public function actionUpdateEditable()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Client');
        $es->onBeforeUpdate = function($event) {
            if (Yii::app()->user->getIsGuest()) {
                $event->sender->error(Yii::t('yii', 'Login Required'));
            }
            if (Yii::app()->getRequest()->getParam('name') == 'status' && Yii::app()->getRequest()->getParam('value') == 0) {
                $event->sender->error(Yii::t('CrmModule.client', 'Status {name} can be set only through a full editing indicating the reasons for refusal', array('{name}' => '0')));
            }
        };
        $es->update();
    }

    public function actionFlush()
    {
        Yii::app()->getCache()->flush();
        $this->redirect(isset(Yii::app()->getRequest()->urlReferrer) ? Yii::app()->getRequest()->getUrlReferrer() : '/');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @throws CHttpException
     * @return Client
     */
    public function loadModel($id)
    {
        $model = Client::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax']==='client-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
