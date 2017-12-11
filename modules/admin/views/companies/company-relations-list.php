<?php
use yii\helpers\Url;

?>
<div id="assigned-relations">

    <?php if (isset($all)): ?>
        <div class="form-group">
            <a class="accordion-toggle collapsed btn red btn-sm" data-toggle="collapse" data-parent="#accordion1"
               href="#accordion_assign" aria-expanded="false">
                <i class="fa fa-plus"></i> Assign new
            </a>
        </div>
        <div id="accordion_assign" class="panel-collapse collapse" aria-expanded="false">

            <div class="well ">
                <?= $this->render('assign-form', ['all' => $all, 'assign_url' => $assign_url, 'multiple' => $multiple, 'pk' => $pk, 'name' => $name, 'text' => $text]) ?>

            </div>
        </div>
    <?php endif; ?>

    <table>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>
                <td>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                onclick="removeRelation('<?= Url::toRoute($remove_url) ?>','<?= $pk ?>', <?= $row[$pk] ?>)">
                            <span aria-hidden="true">&times;</span></button>
                        <?= $row[$text] ?>
                    </div>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
</div>