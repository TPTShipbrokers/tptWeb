<?php

namespace app\modules\api\controllers;

use Yii;
use yii\filters\VerbFilter;

/**
 * Class BasePositionsController
 *
 * @method allVessels
 *
 * @package app\modules\api\controllers
 */
class BasePositionsController extends DefaultController
{
    public $enableCsrfValidation = false;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],

                ],
            ],
        ];
    }

    /**
     * @param int|null $id
     */
    public function actionIndex($id = null)
    {
        $this->pkId = $id;
        $req = Yii::$app->api->processRequest($this->requestData);

        if (!$id) {
            $this->allVessels();
        } else {
            $this->{$req['action']}($req['object']);
        }
    }
}