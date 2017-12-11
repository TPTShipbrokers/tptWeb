<?php

namespace app\modules\admin\controllers;

use app\models\Newsletter;
use app\models\NewsletterSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url as Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


/**
 * Market_reportsController implements the CRUD actions for Newsletter model.
 */
class Market_reportsController extends Controller
{

    public $layout = 'column2';
    public $enableCsrfValidation = false;

    /**
     * @param \yii\base\Action $action
     * @return bool|\yii\web\Response
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->redirect(Url::toRoute('login/'));
        }

        if (!parent::beforeAction($action)) return false;

        return true;
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Newsletter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsletterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Newsletter model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Newsletter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Newsletter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Newsletter::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Newsletter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Newsletter();

        $post = Yii::$app->request->post();


        if ($post) {
            //     die(var_dump($post));

            $file = UploadedFile::getInstance($model, 'file');

            $model->date = $post['Newsletter']['date'];
            $model->title = $post['Newsletter']['title'];


            if ($file) {
                $uid = uniqid();
                $model->file = 'uploads/documents/' . $uid . Yii::$app->utils->sanitize($file->baseName, true) . '.' . $file->extension;
                $file->saveAs('uploads/documents/' . $uid . Yii::$app->utils->sanitize($file->baseName, true) . '.' . $file->extension);
            }

            $res = $model->trySave(true);

            if ($res['result'] != 'success') {
                return $this->render('/notification', ['class' => 'danger', 'message' => $res['data']['error_description']]);
            } else {

                return $this->redirect(['view', 'id' => $model->newsletter_id]);
            }


        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Newsletter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();

        if ($post) {

            $file = UploadedFile::getInstance($model, 'file');

            $model->date = $post['Newsletter']['date'];
            $model->title = $post['Newsletter']['title'];


            if ($file) {
                $uid = uniqid();
                $model->file = 'uploads/documents/' . $uid . $file->baseName . '.' . $file->extension;
                $file->saveAs('uploads/documents/' . $uid . $file->baseName . '.' . $file->extension);
            }

            $res = $model->trySave(true);

            if ($res['result'] != 'success') {
                $this->render('/notification', ['class' => 'danger', 'message' => $res['data']['error_description']]);
            } else {
                return $this->redirect(['view', 'id' => $model->newsletter_id]);
            }


        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Newsletter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = Newsletter::findOne($id);
        Yii::$app->utils->checkExistence($model);

        if ($model->file && file_exists($model->file)) {
            unlink($model->file);
        }

        $model->tryDelete();
    }
}
