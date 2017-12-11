<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vessel */

$this->title = 'Create Vessel';
$this->params['breadcrumbs'][] = ['label' => 'Vessels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vessel-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
