<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model app\models\AppUser */
/* @var $form ActiveForm */
?>

<div class="user_create">
    
    <?php 
    if(isset($errors)){
     
       if(is_string($errors)){
           echo '<div class="alert alert-danger" role="alert">'.$errors.'</div>';
       } else {
           echo '<div class="alert alert-danger" role="alert">';
           foreach($errors as $key=>$value){
               echo  $value[0] . "<br>";
           }
           echo '</div>';
       }

    } 
?>
   
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput()->hint('Please enter your name') ?>
        <?= $form->field($model, 'email')->input('email') ?>
        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'role')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'postcode') ?>
        <?= $form->field($model, 'telephone') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user_create -->
