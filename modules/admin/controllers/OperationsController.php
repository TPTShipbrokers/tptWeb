<?php

namespace app\modules\admin\controllers;

use app\models\AppUser;
use app\models\Location;
use app\models\Operation;
use app\models\OperationState;
use app\models\Ship;
use app\models\State;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;


class OperationsController extends Controller
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

    public function actionIndex($filter = null)
    {
        $cond = $filter == 'ongoing' ? ['end_time' => null] : ($filter == 'past' ? 'end_time is not null' : '');


        $data = [
            'operations' => Operation::format(Operation::find()->where($cond)->all(), ['invoice' => true, 'statuses' => true, 'user' => true, 'report' => true]),
            'clients' => AppUser::find()->where(['role' => 'client'])->all(),
            'ships' => Ship::find()->all(),
            'ongoing' => Operation::format(Operation::find()->where(['end_time' => null])->all(), ['invoice' => true, 'statuses' => true, 'user' => true, 'report' => true]),
            'past' => Operation::format(Operation::find()->where('end_time is not null')->all(), ['invoice' => true, 'statuses' => true, 'user' => true, 'report' => true])
        ];

        if (!\Yii::$app->getModule('admin')->user->isGuest) {
            return $this->render('index', ['data' => $data]);
        } else {
            $this->redirect(Url::toRoute('login/'));
        }

    }

    public function actionCreate()
    {
        $model = new Operation;

        $post = Yii::$app->request->post();

        if ($post) {

            //  die(var_dump($post));

            /*

            {
            ["discharging_ship_id"]=> string(1) "2"
            ["discharging_ship"]=> string(11) "MT Alpine X"

            ["receiving_ship_id"]=> string(1) "4"
            ["receiving_ship"]=> string(14) "MT Mountin Oak"
            ["location_id"]=> string(1) "1"
            ["typeahead_locations"]=> string(13) "Offshore Lome"
            ["longitude"]=> string(9) "-0.148643"
            ["latitude"]=> string(9) "51.516729"
            ["typeahead_client_id"]=> string(1) "1"
            ["typeahead_clients"]=> string(17) "Jovana Stefanovic"
            ["reference_id"]=> string(4) "#ddd" }
            */

            $operation = new Operation;

            $operation->reference_id = $post['reference_id'];

            $discharging_ship_id = $post['discharging_ship_id'];
            $receiving_ship_id = $post['receiving_ship_id'];

            $discharging_exists = Ship::findOne($discharging_ship_id);

            if ($discharging_exists && $discharging_exists->name == $post['discharging_ship']) {
                $operation->discharging_ship_id = $discharging_ship_id;
            } else {
                $ship = new Ship;
                $ship->name = $post['discharging_ship'];

                $ship->save();

                $operation->discharging_ship_id = $ship->ship_id;
            }

            $receiving_exists = Ship::findOne($receiving_ship_id);

            if ($receiving_exists && $receiving_exists->name == $post['receiving_ship']) {
                $operation->receiving_ship_id = $receiving_ship_id;
            } else {
                $ship = new Ship;
                $ship->name = $post['receiving_ship'];

                $ship->save();

                $operation->receiving_ship_id = $ship->ship_id;
            }

            $location_id = $post['location_id'];

            $location_exists = Location::findOne($location_id);

            if ($location_exists && $location_exists->title == $post['typeahead_locations']) {
                $operation->location_id = $location_id;
            } else {
                $location = new Location;

                $location->title = $post['typeahead_locations'];

                $location->longitude = $post['longitude'];
                $location->latitude = $post['latitude'];

                $location->save();

                $operation->location_id = $location->location_id;
            }

            $client_id = $post['client_id'];
            $client_exists = AppUser::find()->where(['user_id' => $client_id, 'role' => 'client'])->one();

            if ($client_exists) {
                $operation->user_id = $client_id;
            } else {
                return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Client is not specified.'], false);
            }

            if ($operation->validate()) {
                $operation->save();
                return Yii::$app->api->_sendResponse(200);
            } else {
                return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => array_values($operation->getErrors())], false);
            }

        } else {
            return $this->render('create', ['model' => $model, 'ships' => Ship::find()->all(), 'locations' => Location::find()->all(), 'clients' => AppUser::find()->where(['role' => 'client'])->all(), "user" => new AppUser]);
        }
    }

    public function actionUpdate($id)
    {
        $model = Operation::findOne($id);

        $post = Yii::$app->request->post();

        if ($post) {

            //  die(var_dump($post));

            /*

            {
            ["discharging_ship_id"]=> string(1) "2"
            ["discharging_ship"]=> string(11) "MT Alpine X"

            ["receiving_ship_id"]=> string(1) "4"
            ["receiving_ship"]=> string(14) "MT Mountin Oak"
            ["location_id"]=> string(1) "1"
            ["typeahead_locations"]=> string(13) "Offshore Lome"
            ["longitude"]=> string(9) "-0.148643"
            ["latitude"]=> string(9) "51.516729"
            ["typeahead_client_id"]=> string(1) "1"
            ["typeahead_clients"]=> string(17) "Jovana Stefanovic"
            ["reference_id"]=> string(4) "#ddd" }
            */

            // $operation = new Operation;

            $model->reference_id = $post['reference_id'];

            $discharging_ship_id = $post['discharging_ship_id'];
            $receiving_ship_id = $post['receiving_ship_id'];

            $discharging_exists = Ship::findOne($discharging_ship_id);

            if ($discharging_exists && $discharging_exists->name == $post['discharging_ship']) {
                $model->discharging_ship_id = $discharging_ship_id;
            } else {
                $ship = new Ship;
                $ship->name = $post['discharging_ship'];

                $ship->save();

                $model->discharging_ship_id = $ship->ship_id;
            }

            $receiving_exists = Ship::findOne($receiving_ship_id);

            if ($receiving_exists && $receiving_exists->name == $post['receiving_ship']) {
                $model->receiving_ship_id = $receiving_ship_id;
            } else {
                $ship = new Ship;
                $ship->name = $post['receiving_ship'];

                $ship->save();

                $model->receiving_ship_id = $ship->ship_id;
            }

            $location_id = $post['location_id'];

            $location_exists = Location::findOne($location_id);

            if ($location_exists && $location_exists->title == $post['typeahead_locations']) {
                $model->location_id = $location_id;
            } else {
                $location = new Location;

                $location->title = $post['typeahead_locations'];

                $location->longitude = $post['longitude'];
                $location->latitude = $post['latitude'];

                $location->save();

                $model->location_id = $location->location_id;
            }

            $client_id = $post['client_id'];
            $client_exists = AppUser::find()->where(['user_id' => $client_id, 'role' => 'client'])->one();

            if ($client_exists) {
                $model->user_id = $client_id;
            } else {
                return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'Client is not specified.'], false);
            }

            if ($model->validate()) {
                $model->save();
                return Yii::$app->api->_sendResponse(200);
            } else {
                return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => array_values($model->getErrors())], false);
            }

        } else {
            return $this->render('update', ['model' => $model, 'ships' => Ship::find()->all(), 'locations' => Location::find()->all(), "states" => State::find()->all(), 'clients' => AppUser::find()->where(['role' => 'client'])->all(), "user" => new AppUser]);
        }

    }

    public function actionUpdate_state($id)
    {

        $post = Yii::$app->request->post();
        $operation = Operation::findOne($id);
        Yii::$app->utils->checkExistence($operation);

        if (!empty($post)) {
            $action = isset($post['action']) ? $post['action'] : false;


            if ($action == 'delete') {

                $operation_state_id = $post['operation_state_id'];
                $state = OperationState::find()->where(['operation_state_id' => $operation_state_id, 'operation_id' => $id])->one();

                if ($state) {

                    if ($state->state->final == 1) {


                        $operation->end_time = null;


                    }

                    $state->delete();

                    $old_state = OperationState::find()->where(['operation_id' => $id])->orderby('operation_state_id desc')->one();

                    if ($old_state) {
                        $operation->status_id = $old_state->state_id;
                    } else {
                        $operation->status_id = $old_state->state_id;
                    }

                    if ($operation->validate()) {
                        $operation->save();
                    } else {
                        return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($operation->getErrors())], false);
                    }


                } else {
                    return Yii::$app->api->_sendResponse(200, ['error' => 'Invalid operation.', 'error_description' => 'Operation State with specified id not found.'], false);
                }

                return Yii::$app->api->_sendResponse(200);

            } else {


                $state_id = $post['typeahead_state_id'];
                $description = $post['typeahead_state'];

                $state_exists = State::findOne($state_id);

                if ($operation->push_notification == 1 && $operation->user) {
                    //Yii::$app->api->send_push_notification('Operation ' . $operation->reference_id . ' state changed.', [$operation->user->email]);
                }


                if ($state_exists && $state_exists->description == $description) {
                    $operation_state = new OperationState;
                    $operation_state->state_id = $state_id;
                    $operation_state->operation_id = $id;
                    $operation_state->time = date('Y-m-d H:i:s');
                    // description and prefix and suffix missing

                    if ($operation_state->validate()) {
                        $operation_state->save();


                        if ($state_exists->final == 1) {

                            $operation->end_time = date('Y-m-d H:i:s');


                        }

                        $operation->status_id = $state_id;

                        if ($operation->validate()) {
                            $operation->save();
                        } else {
                            return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred while trying to update operation.', 'error_description' => array_values($operation->getErrors())], false);
                        }

                        return Yii::$app->api->_sendResponse(200);
                    } else {
                        return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred  while trying to update operation state.', 'error_description' => array_values($operation_state->getErrors())], false);
                    }
                } else {

                    $new_state = new State;
                    $new_state->description = $description;

                    if ($new_state->validate()) {
                        $new_state->save();

                    } else {
                        return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => array_values($new_state->getErrors())], false);
                    }

                    $operation_state = new OperationState;
                    $operation_state->state_id = $new_state->state_id;
                    $operation_state->operation_id = $id;
                    $operation_state->time = date('Y-m-d H:i:s');
                    // description and prefix and suffix missing

                    if ($operation_state->validate()) {
                        $operation_state->save();
                    } else {
                        return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => array_values($operation_state->getErrors())], false);
                    }

                    $operation->status_id = $new_state->state_id;

                    if ($operation->validate()) {
                        $operation->save();
                    } else {
                        return Yii::$app->api->_sendResponse(200, ['error' => 'An error occurred.', 'error_description' => array_values($operation->getErrors())], false);
                    }

                    return Yii::$app->api->_sendResponse(200);
                }

            }


        }

    }

    public function actionView($id)
    {
        $model = Operation::findOne($id);
        return $this->render('view', ['model' => $model, 'locations' => Location::find()->all(), "states" => State::find()->all()]);
    }

    public function actionDelete()
    {
        $post = Yii::$app->request->post();

        $model = Operation::findOne($post['operation_id']);

        if ($model != null) {

            if ($model->delete()) {
                Yii::$app->api->_sendResponse(200);
            } else {
                Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Operation', 'error_description' => array_values($model->getErrors())], false);
            }


        } else {

            Yii::$app->api->_sendResponse(200, ['error' => 'Invalid Data', 'error_description' => 'User with supplied id does not exist.'], false);

        }
    }


}
