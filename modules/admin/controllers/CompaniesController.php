<?php

namespace app\modules\admin\controllers;

use app\models\AppUser;
use app\models\Chartering;
use app\models\CharteringCompany;
use app\models\Company;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;


class CompaniesController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'column2';

    public function beforeAction($action)
    {
        if (\Yii::$app->getModule('admin')->user->isGuest) {
            $this->redirect(Url::toRoute('login/'));
        }

        if (!parent::beforeAction($action)) return false;

        return true;
    }

    public function actionIndex()
    {

        $data = [
            'rows' => Company::format(Company::find()->all(), ['update_url' => true, 'delete_url' => true]),
            'attributes' => ['Name' => 'company_name', 'Assigned ' => ['template' => '/companies/company-relations-cell']],
            'info' => Company::info(),
            'title' => 'Companies',
            'edit_field' => 'company_name'
        ];

        if (!\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['data' => $data]);
        } else {
            $this->redirect(Url::toRoute('login/'));
        }

    }


    public function actionCreate()
    {
        $model = new Company;

        $post = Yii::$app->request->post();

        if (isset($post['Company'])) {

            $model->attributes = $post['Company'];

            $image = UploadedFile::getInstance($model, 'profile_picture');

            if ($model->validate()) {

                if ($image) {
                    $imageName = uniqid();
                    $model->profile_picture = 'uploads/images/' . $imageName . '.' . $image->extension;
                    $image->saveAs('uploads/images/' . $imageName . '.' . $image->extension);
                }
                $model->save();

                return $this->redirect(Yii::$app->request->baseUrl . '/admin/companies');
                //Yii::$app->api->_sendResponse(200,['company_id' => $model->company_id, 'company_name' => $model->company_name], true);

            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($model->getErrors())], false);
            }

        }
    }

    public function actionUpdate($id)
    {
        $model = Company::findOne($id);
        $post = Yii::$app->request->post();

        //var_dump($post['Company']);exit();

        if (isset($post['Company'])) {

            if ($model != null) {

                $model->attributes = $post['Company'];

                $image = UploadedFile::getInstance($model, 'profile_picture');

                if ($model->validate()) {

                    if ($image) {
                        $imageName = uniqid();
                        $model->profile_picture = 'uploads/images/' . $imageName . '.' . $image->extension;
                        $image->saveAs('uploads/images/' . $imageName . '.' . $image->extension);
                    }
                    $model->save();

                    return $this->redirect(Yii::$app->request->baseUrl . '/admin/companies');
                    //Yii::$app->api->_sendResponse(200);

                } else {
                    Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => array_values($model->getErrors())], false);
                }


            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Ship with supplied id does not exist.'], false);

            }

        }

    }

    public function actionDelete($id)
    {

        $post = Yii::$app->request->post();

        $model = Company::findOne($id);

        if ($model != null) {

            if ($model->delete()) {
                Yii::$app->api->_sendResponse(200);
            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($model->getErrors())], false);
            }


        } else {

            Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Ship with supplied id does not exist.'], false);

        }
    }

    public function actionChartering($id)
    {

        $model = Company::findOne($id);
        Yii::$app->utils->checkExistence($model);

        $rows = Chartering::format($model->getChartering()->all(), ['title' => true], false);
        $all = Chartering::format(Chartering::find()->where('not exists (select * from CharteringCompany where chartering_id=Chartering.chartering_id and company_id=:company_id)', [':company_id' => $id])->all(), ['title' => true], false);

        return $this->renderPartial('company-relations-list', [
            'rows' => $rows,
            'all' => $all,
            'assign_url' => Url::toRoute('companies/assign_chartering/' . $id),
            'name' => 'Chartering[]',
            'multiple' => true,
            'remove_url' => 'companies/relation_remove/' . $id,
            'pk' => 'chartering_id',
            'text' => 'title'

        ]);
    }

    public function actionUsers($id)
    {

        $model = Company::findOne($id);
        Yii::$app->utils->checkExistence($model);
        $rows = AppUser::format(AppUser::find()->where(['company_id' => $id])->all(), ['full_name' => true], false);
        $all = AppUser::format(AppUser::find()->where(['role' => 'client'])->andWhere('(company_id <> :company_id or company_id is null)', [':company_id' => $id])->all(), ['full_name' => true], false);


        return $this->renderPartial('company-relations-list', [
            'rows' => $rows,
            'all' => $all,
            'assign_url' => Url::toRoute('companies/assign_user/' . $id),
            'name' => 'User',
            'multiple' => false,
            'remove_url' => 'companies/relation_remove/' . $id,
            'pk' => 'user_id',
            'text' => 'full_name'
        ]);
    }

    public function actionRelation_remove($id)
    {

        $post = Yii::$app->request->post();
        $pk = $post['pk'];
        $rel_id = $post['id'];

        if ($pk == 'user_id') {
            $model = AppUser::find()->where(['company_id' => $id, 'user_id' => $rel_id])->one();
            Yii::$app->utils->checkExistence($model);

            $model->company_id = null;
            $model->trySave();
        }

        if ($pk == 'chartering_id') {
            $model = CharteringCompany::find()->where(['company_id' => $id, 'chartering_id' => $rel_id])->one();
            Yii::$app->utils->checkExistence($model);
            $model->tryDelete();
        }


    }

    public function actionAssign_chartering($id)
    {
        $model = Company::findOne($id);
        Yii::$app->utils->checkExistence($model);

        $post = Yii::$app->request->post();

        if (isset($post['Chartering'])) {

            foreach ($post['Chartering'] as $chartering_id) {
                $chartering = new CharteringCompany;
                $chartering->company_id = $id;
                $chartering->chartering_id = $chartering_id;
                $res = $chartering->trySave(true);

                if ($res['result'] != 'success') {
                    return Yii::$app->api->_sendResponse(200, $res['data'], false);
                }
            }

            return Yii::$app->api->_sendResponse(200);
        }
    }

    public function actionAssign_user($id)
    {
        $model = Company::findOne($id);
        Yii::$app->utils->checkExistence($model);

        $post = Yii::$app->request->post();

        if (isset($post['User'])) {
            $user = AppUser::findOne($post['User']);
            Yii::$app->utils->checkExistence($user);
            $user->company_id = $id;
            $user->trySave();


        }
    }


}
