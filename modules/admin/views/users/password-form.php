<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/**
 * @var \app\models\AppUser $model
 */
?>

<?php $form = ActiveForm::begin([
    'method' => 'post',
    'action' => ['users/update/' . $model->user_id],
    'options' => ["enctype" => "multipart/form-data", 'id' => 'update-form-2']

]); ?>

    <div class="form-group">
        <label class="control-label">New Password</label>
        <input type="password" class="form-control" name="AppUser[password]"/></div>
    <div class="form-group">
        <label class="control-label">Re-type New Password</label>
        <input type="password" class="form-control" name="re-password"/></div>
    <div class="margin-top-10">
        <button onClick="updatePasswordSubmit();" class="btn green"> Change Password</button>
        <a href="<?= Url::toRoute('users/view/' . $model->user_id) ?>" class="btn default"> Cancel </a>
    </div>


<?php ActiveForm::end(); ?>