<?php if (empty($all)): ?>
    <?= $this->render('/notification', ['message' => 'No available records to assign.', 'class' => 'danger']); ?>
<?php else: ?>
    <form id="assign_form" action="<?= $assign_url ?>" method="post">
        <div class="form-group">
            <?= $this->render('/select-control', ['name' => $name, 'rows' => $all, 'value' => $pk, 'text' => $text, 'multiple' => $multiple]) ?>

        </div>
        <div class="form-group">
            <button type="button" class="btn btn-success" onclick="save('#assign_form',modalSaveCallback)">Save</button>
            <button type="button" class="btn btn-default collapsed accordion-toggle " data-toggle="collapse"
                    data-parent="#accordion1" href="#accordion_assign" aria-expanded="false">Cancel
            </button>
        </div>
    </form>
<?php endif; ?>