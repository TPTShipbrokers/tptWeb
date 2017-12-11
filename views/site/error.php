<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;


?>
 <div class="row">
    <div class="col-md-12 page-404">
        <div class="number font-red" style="top:0 "> <?=$exception->statusCode?> </div>
        <div class="details">
            <h3>Oops! </h3>
            <p> <?=$exception->getMessage()?> </p>
         
            <p>
                <a href="/<?=Yii::$app->request->baseUrl?>" class="btn red btn-outline"> Return home </a>
            </p>
                
        </div>
    </div>
</div>

