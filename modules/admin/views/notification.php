<?php
/* Notification template

Parameters:

- class - alert class (success, danger, warning, info, default, primary)
- message - alert message


*/
?>
<h3>Error </h3>

<div class="alert alert-<?= $class ?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>

    <?php if (!is_array($message)): ?>
        <?= $message; ?>
    <?php else: ?>
        <?php foreach ($message as $mess): ?>
            <?php if (!is_array($mess)): ?>
                <?= $mess; ?>
            <?php else: ?>
                <?php foreach ($mess as $m): ?>
                    <?= $m; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <br>
        <?php endforeach; ?>
    <?php endif; ?>
</div>