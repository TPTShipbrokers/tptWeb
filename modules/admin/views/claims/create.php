<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Claims */

$this->title = 'Create Claims';
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="claims-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
