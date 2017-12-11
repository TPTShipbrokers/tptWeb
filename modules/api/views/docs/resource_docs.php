<?php
/* @var $this yii\web\View */
//die(var_dump($data));

?>
<h1><?= $name ?></h1>

<?php
$br = 0;
foreach ($data as $req => $desc) {

    $br++;
    ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            <a role="button" data-toggle="collapse" href="#collapseExample<?= $br ?>" aria-expanded="false"
               aria-controls="collapseExample">
                <h1><b><?= $req ?></b></h1>
            </a>

        </div>
        <div class="panel-body collapse" id="collapseExample<?= $br ?>">

            <?php
            foreach ($desc as $type => $props) {
                if ($type != "examples") {
                    ?>


                    <div class="well">

                        <h2><b><?= ucfirst($type) ?></b></h2>


                        <?php foreach ($props as $key => $prop) { ?>


                            <div class="row padtb10 panel-body">

                                <?php if (($key == "Parameters" || $key == "Error Parameters") && is_array($prop)) { ?>

                                    <div class="col-md-2"><b><?= $key ?></b></div>

                                    <div class="col-md-10">

                                        <div class="well">
                                            <?php foreach ($prop as $k => $v) { ?>
                                                <div class="row padtb5">
                                                    <div class="col-md-2"><b><?= $k ?></b></div>

                                                    <?php Yii::$app->api->displayFormat($v); ?>
                                                    <div class="clearfix"></div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                <?php } else if ($prop) { ?>
                                    <div class="col-md-3"><b><?= $key ?></b></div>
                                    <div class="col-md-9">
                <span class='<?= $key == "Method" ? "label label-danger" : ($key == "Url" ? "label label-warning" : "") ?>'>
                    <?= $prop ?>
                </span>
                                    </div>

                                <?php } ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>
                    </div>


                <?php } else { ?>
                    <div class="well">
                        <h2><b><?= ucfirst($type) ?></b></h2>

                        <?php foreach ($props as $key => $prop) { ?>

                            <div class="row padtb10">
                                <div class="col-md-2"><b><?= $key ?></b></div>

                                <div class="col-md-10">
                                    <pre><?php Yii::$app->api->displayFormat($prop); ?></pre>
                                </div>

                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>
                    </div>


                <?php }
            } ?>
        </div>
    </div>


<?php } ?>
<!--<code><?= __FILE__; ?></code>.-->
