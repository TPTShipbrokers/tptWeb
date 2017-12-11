<?php
use yii\helpers\Url;

?>
<div id="status_form_wrap_<?= ($update && $update == true) ? 'update' : 'new' ?>">
    <div class="portlet light bg-inverse">
        <div class="portlet-title">
            <div class="caption red-sunglo">
                <span class="caption-subject font-red-sunglo bold  block pull-left"
                      style="padding: 5px 15px 5px 0; font-size: 16px"><b>Chartering Status</b></span>

            </div>

            <div class="clearfix"></div>
        </div>

        <div class="portlet-body form">
            <form action="<?= Url::toRoute('chartering/update_status/' . $chartering_id) ?>"
                  id="status_form_<?= ($update && $update == true) ? 'update' : 'new' ?>" method="post">
                <input type="hidden" name="action" value="<?= isset($update) && $update == true ? 'update' : 'new' ?>"/>
                <input type="hidden" name="chartering_status_id"
                       value="<?= isset($chartering_status_id) && $chartering_status_id ? $chartering_status_id : '' ?>"/>
                <input type="hidden" name="chartering_id"
                       value="<?= isset($chartering_id) && $chartering_id ? $chartering_id : '' ?>"/>
                <?php if (!$update && $update == false): ?>
                    <div class="form-group">
                        <label class="control-label col-md-4">Status
                            <span class="required"> * </span>
                        </label>
                        <div class="col-md-4">

                            <input type="hidden" name="typeahead_status_id" id="typeahead_status_id"
                                   value="<?= isset($status) && $status ? $status->status_id : '' ?>"/>

                            <input type="text" class="form-control" name="typeahead_status" id="typeahead_status"
                                   value="<?= isset($status) && $status ? $status->description : '' ?>"/>
                            <span class="help-block"> Start typing to choose existing status </span>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <label class="control-label">Date / Time</label>
                    <div>
                        <input class="form_datetime_status" data-format="yyyy-MM-dd hh:mm:ss" name="date"
                               value="<?= isset($date) && $date ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s') ?>"/>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn green set-btn"> Set</button>

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>

