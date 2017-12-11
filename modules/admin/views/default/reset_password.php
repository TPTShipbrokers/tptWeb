<?php
use yii\helpers\Url;

?>
<?php if (isset($alert)): ?>
    <div class="alert alert-<?= $alert['type'] ?>" role="alert"><?= $alert['message'] ?></div>

<?php endif; ?>
<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="forget" action="<?= Url::toRoute('reset_password_request') ?>" method="post">
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
</form>

<!-- END FORGOT PASSWORD FORM -->