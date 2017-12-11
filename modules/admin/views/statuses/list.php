<?php
use yii\helpers\Url;

?>
<ul class="feeds op_stat">
    <?php foreach ($statuses as $op_state): ?>
        <li id="status<?= $op_state->chartering_status_id ?>">

            <div class="row">
                <div class="col-md-1">
                    <div class="label label-sm label-<?= $op_state->status_id == $status_id ? "danger" : "success" ?>">

                        <i class="fa fa-<?= $op_state->status_id == $status_id ? "check" : "bell-o" ?>"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="desc">

                        <?= $op_state->status->description ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="date"> <?= date('d M, Y H:i', strtotime($op_state->datetime)) ?> </div>
                </div>
                <?php if (isset($update) && $update): ?>
                    <div class="col-md-1">
                        <a class="btn btn-circle btn-icon-only default update-status-btn"
                           data-id="<?= $op_state->chartering_status_id ?>">
                            <i class="icon-wrench" data-toggle="tooltip" data-placement="top"
                               title="Update chartering status details"></i>
                        </a>
                    </div>
                <?php endif; ?>
                <?php if (isset($delete) && $delete): ?>
                    <div class="col-md-1">
                        <a class="btn btn-circle btn-icon-only red confirmation-delete" href="javascript:"
                           data-original-title="Are you sure you want to delete chartering status permanently?"
                           data-idprefix="#status" data-id="<?= $op_state->chartering_status_id ?>"
                           data-message="Chartering status deleted."
                           data-errormessage="An error ocurred while tryng to delete operation status."
                           data-url="<?= Url::toRoute("chartering/update_status/" . $op_state->chartering_status_id) ?>"
                           data-placement="bottom">
                            <i class="icon-trash" data-toggle="tooltip" data-placement="top"
                               title="Delete chartering status"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </li>
    <?php endforeach; ?>

</ul>