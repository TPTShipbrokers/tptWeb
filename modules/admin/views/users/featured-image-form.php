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
    'options' => ["enctype" => "multipart/form-data", 'id' => 'update-form-3']

]);

?>

    <div class="form-group">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                <?php if (!$model->profile_picture): ?>
                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                <?php else: ?>
                    <img src="<?= Yii::$app->request->baseUrl ?>/<?= $model->profile_picture ?>" alt=""/>
                <?php endif; ?>
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail"
                 style="max-width: 200px; max-height: 150px;"></div>

            <div>
                <span class="btn default btn-file">
                    <span class="fileinput-new"> Select image </span>
                    <span class="fileinput-exists"> Change </span>
                    <?= $form->field($model, 'profile_picture')->fileInput()->label(false) ?> </span>
                <a href="javascript:" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>

    </div>
    <div class="margin-top-10">
        <button type="submit" class="btn green"> Submit</button>
        <a href="<?= Url::toRoute('users/view/' . $model->user_id) ?>" class="btn default"> Cancel </a>
    </div>
<?php ActiveForm::end(); ?>