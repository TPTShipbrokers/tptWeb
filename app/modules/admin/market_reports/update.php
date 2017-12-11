<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Newsletter */

$this->title = 'Update Newsletter: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Newsletters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->newsletter_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="newsletter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
