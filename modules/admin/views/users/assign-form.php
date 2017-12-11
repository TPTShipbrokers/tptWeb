<?php if (empty($all)): ?>
    <?= $this->render('/notification', ['message' => 'No available records to assign.', 'class' => 'danger']); ?>
<?php else: ?>

    <form class="form" action="<?= $action ?>" id="<?= $id ?>">
        <div class="form-group">
            <?= $this->render('/select-control', ['name' => $name, 'rows' => $all, 'value' => $value, 'text' => $text, 'multiple' => false, 'selected' => isset($selected) ? $selected : false]) ?>

        </div>
        <?php if ($id == "user_assign_chartering"): ?>
            <?= $this->render('/select-control',
                [
                    'name' => 'Status',
                    'rows' => [

                        ['status' => 'active', 'label' => 'Active'],
                        ['status' => 'read', 'label' => 'Read'],
                        ['status' => 'scheduled', 'label' => 'Scheduled']
                    ],
                    'value' => 'status',
                    'text' => 'label',
                    'multiple' => false,
                    'selected' => false
                ]) ?>


        <?php endif; ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>

<?php endif; ?>