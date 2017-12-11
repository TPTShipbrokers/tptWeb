<?php
use yii\helpers\Url;

?>

<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Dashboard
    <small>dashboard & statistics</small>
</h3>
<!-- END PAGE TITLE-->


<div class="admin-default-index">

    <!-- BEGIN DASHBOARD STATS 1-->


    <div class="row">
        <?php
        $items = $this->context->module->params["dashboard_items"];
        $icons = $this->context->module->params["menu_icons"];
        ?>

        <?php foreach ($items as $label => $url): ?>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat default">
                    <div class="visual">
                        <i class="<?= $icons[$label] ?>"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?= $data[$label] ?>">0</span>
                        </div>
                        <div class="desc"> <?= $label ?> </div>
                    </div>
                    <a class="more" href="<?= Url::toRoute($url) ?>"> View more
                        <i class="m-icon-swapright m-icon-white"></i>
                    </a>
                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <!-- END DASHBOARD STATS 1-->
</div>
