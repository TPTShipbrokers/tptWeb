<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models;



/* @var $this yii\web\View */
/* @var $model app\models\AppUser */
/* @var $form ActiveForm */
?>
<h3>Password reset </h3>
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
    
    if(isset($success) && $success){
        echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
   
    } else {
?>
   
    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group field-appuser-password required">
        <label class="control-label" for="appuser-old-password">Old Password</label>
        <input type="password" id="appuser-password" class="form-control" name="AppUser[old_password]" required>

    </div>   
        <?= $form->field($model, 'password')->passwordInput()->label('New Password') ?>
    
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
    
    <?php } ?> 

</div><!-- user_create -->
