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
             array('auth.filters.AuthFilter')/** @see AuthFilter */
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
        $model = new Client;
        if ($id) {
            $model->project_id = intval($id);
        }
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Client'])) {
            $model->attributes=$_POST['Client'];
            if ($model->save()) {
                //$this->redirect(array('view', 'id'=>$model->id));
                if (isset($_POST['exit'])) {
                    $this->redirect(array('admin', 'id' => $model->project_id));
                } else {
                    $this->redirect(array('update', 'id' => $model->id));
                }
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Client'])) {
            $model->attributes = $_POST['Client'];
            if ($model->save()) {
                if (isset($_POST['exit'])) {
                    $this->redirect(array('admin', 'id' => $model->project_id));
                } else {
                    $this->redirect(array('update', 'id' => $model->id));
                }
            }
        }

        $this->render('update', array('model' => $model));
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
        $model->unsetAttributes(); // clear any default values
        if (isset($id)) {
            $model->project_id = intval($id);
        }
        if (isset($_GET['Client'])) {
            $model->attributes = $_GET['Client'];
        }

        $this->render('admin', array('model' => $model));
    }

    public function actionUpdateEditable()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Client');
        $es->update();
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
