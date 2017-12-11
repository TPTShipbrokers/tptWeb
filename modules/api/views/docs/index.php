<?php
/* @var $this yii\web\View */
//die(var_dump($data));

?>
<h1>Kurb API Documentation</h1>

<?php

foreach ($data as $desc => $url):
    ?>
    <div class="row well">
        <div class="col-md-4"><span><?= $desc ?></span></div>

        <div class="col-md-4"><span><a href="<?= $url['docs_url'] ?>" target="_blank"><?= $url['api_url'] ?></a></span>
        </div>

    </div>

<?php endforeach; ?>
<!--<code><?= __FILE__; ?></code>.-->
