<?php

use app\models\AppUser;
use app\models\Claims;
use app\models\Company;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Chartering */

$this->title = 'Create Chartering';
$this->params['breadcrumbs'][] = ['label' => 'Chartering', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chartering-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?= $this->render('_form', [
            'model' => $model,
            'vessels' => $vessels,
            'statuses' => $statuses,
            'all_clients' => $all_clients,
            'all_companies' => $all_companies,
            'clients' => [],
            'companies' => [],
            'all_team' => $all_team,
            'broker' => null
        ]) ?>
        <div class="clearfix"></div>
    </div>


    <?= $this->render('/modal-template', ['id' => 'newClientModal', 'title' => 'User Details', 'subtitle' => 'create account', 'content_template' => 'users/user_form', 'content_data' => ['user' => new AppUser, 'role' => 'client']]); ?>
    <?= $this->render('/modal-template', ['id' => 'newBrokerModal', 'title' => 'User Details', 'subtitle' => 'create account', 'content_template' => 'users/user_form', 'content_data' => ['user' => new AppUser, 'role' => 'team']]); ?>
    <?= $this->render('/modal-template', ['id' => 'newCompanyModal', 'title' => 'New Company', 'subtitle' => 'create account', 'content_template' => 'companies/create-form', 'content_data' => ['model' => new Company]]); ?>


    <?= $this->render('/modal-template', ['id' => 'newStatusModal', 'title' => 'Change status', 'subtitle' => 'set operation status', 'content_template' => 'statuses/status_form', 'content_data' => ['chartering_id' => $model->chartering_id, 'date' => null, 'status' => null, 'update' => false]]); ?>
    <?= $this->render('/modal-template', ['id' => 'updateStatusModal', 'title' => 'Update status details', 'subtitle' => ' operation status', 'content_template' => 'statuses/status_form', 'content_data' => ['chartering_id' => $model->chartering_id, 'date' => null, 'status' => null, 'update' => true]]); ?>
    <?= $this->render('/modal-template', ['id' => 'newClaimModal', 'title' => 'Add new claim for chartering', 'subtitle' => ' chartering claims', 'content_template' => 'claims/_form', 'content_data' => ['model' => new Claims, 'chartering_id' => $model->chartering_id]]); ?>
    <?= $this->render('/modal-template', ['id' => 'updateClaimModal', 'title' => 'Update claim for chartering', 'subtitle' => ' chartering claims', 'content_template' => 'claims/_form', 'content_data' => ['model' => null, 'chartering_id' => $model->chartering_id]]); ?>


</div>
