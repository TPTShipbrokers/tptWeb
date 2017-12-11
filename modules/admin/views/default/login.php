<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<!-- BEGIN LOGIN FORM -->

<h3 class="form-title">Login to your account</h3>
<div class="alert alert-danger display-hide">
    <button class="close" data-close="alert"></button>
    <span> Enter any username and password. </span>
</div>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal']
]); ?>


<?= $form->field($model, 'email', ['template' => "<label class=\"control-label visible-ie8 visible-ie9\">Email</label><div class=\"input-icon\"><i class=\"fa fa-user\"></i>{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
])->label(false)->textInput(['placeholder' => 'Email', 'class' => 'form-control placeholder-no-fix']) ?>

<?= $form->field($model, 'password', [
    'template' => "<label class=\"control-label visible-ie8 visible-ie9\">Password</label><div class=\"input-icon\"><i class=\"fa fa-lock\"></i>{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
])->label(false)->passwordInput(['placeholder' => 'Password', 'class' => 'form-control placeholder-no-fix']) ?>

<div class="form-actions">
    <?= $form->field($model, 'rememberMe', ['template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>"])->checkbox() ?>
    <?= Html::submitButton('Login <i class="m-icon-swapright m-icon-white"></i>', ['class' => 'btn green pull-right', 'name' => 'login-button']) ?>
</div>


<div class="forget-password">
    <h4>Forgot your password ?</h4>
    <p> no worries, click
        <a href="javascript:" id="forget-password"> here </a> to reset your password. </p>
</div>

<?php ActiveForm::end(); ?>
<!-- END LOGIN FORM -->
<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="forget-form" action="<?= Url::toRoute('reset_password_request') ?>" method="post">
    <h3>Forget Password ?</h3>
    <p> Enter your e-mail address below to reset your password. </p>
    <div class="form-group">
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email"
                   name="email"/></div>
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn red btn-outline">Back</button>
        <button type="submit" class="btn green pull-right"> Submit</button>
    </div>

    <!-- END FORGOT PASSWORD FORM -->