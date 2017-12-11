<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PostOperationReport */

$this->title = 'Create Post Operation Report';
$this->params['breadcrumbs'][] = ['label' => 'Post Operation Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-operation-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
