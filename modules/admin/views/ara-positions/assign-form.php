<!-- COMPANY -->
<div class="update-pane" id="<?= $id ?>">
    <h3 class="block"><?= $title ?></h3> <!-- Assign company for operation -->
    <div class="hide-print pull-left">
        <a data-toggle="modal" data-target="<?= $modal_id ?>" class=" btn red btn-sm"><i class="fa fa-plus"></i> Add
            New <?= $label ?></a> <!-- #newCompanyModal -->
    </div>

    <div class="form-group">
        <label class="control-label col-md-2"><?= $label ?> <!--Company -->
            <span class="required"> * </span>
        </label>
        <div class="col-md-4">
            <?php if (empty($all)): ?>
                <?= $this->render('/notification', ['message' => 'No available records to assign.', 'class' => 'danger']); ?>
            <?php else: ?>


                <?= $this->render('/select-control',
                    [
                        'name' => $name, //'Clients[]', 
                        'rows' => $all,
                        'value' => $value, //user_id / company_id
                        'text' => $text,  // full_name / company_name
                        'multiple' => $multiple,
                        'selected' => $selected,
                    ]) ?>

            <?php endif; ?>
        </div>
        <?php if ($label == 'Client'): ?>
            <div class="col-md-4">
                <label> Scheduled?
                    <input type="checkbox" onclick="$('#scheduled-date').toggle()" value="0" name="scheduled"/>

                </label>
                <div id="scheduled-date" style="display:none">
                    <div class="form-group">
                        <label class="control-label">Date / Time</label>
                        <div>
                            <input class="form_datetime_status" data-format="yyyy-MM-dd hh:mm:ss" name="scheduled_date"
                                   value="<?= isset($date) && $date ? date('Y-m-d H:i:s', strtotime($date)) : date('Y-m-d H:i:s') ?>"/>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
    </div>


</div>