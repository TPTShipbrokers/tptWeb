<?php

?>
<?php if (isset($alert)): ?>
    <div class="alert alert-<?= $alert['type'] ?>" role="alert"><?= $alert['message'] ?></div>

<?php endif; ?>
<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="forget" action="<?= $url ?>" method="post">
    <h3>Forget Password ?</h3>
    <p> Enter your new password below to reset your password. </p>
    <div class="form-group">
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" name="password"/></div>
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn red btn-outline">Back</button>
        <button type="submit" class="btn green pull-right"> Submit</button>
    </div>
</form>

<!-- END FORGOT PASSWORD FORM -->