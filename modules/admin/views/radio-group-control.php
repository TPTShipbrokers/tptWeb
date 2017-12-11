<?php
/* Radio Group template

Parameters:

 <?= $this->render('/radio-group-control', ['model' => $model, 'attribute' => 'role', 'label' => 'Role', 'name' => 'AppUser[role]', 
 'values' => ['Admin' => 'admin', 'Client' => 'client', 'Team' => 'team']])?>

- model - Model
- attribute - Model attribute
- label - Control label
- name - Control Name
- values - [Label => value]

*/

?>


<div class="form-group form-md-radios form-horizontal">
    <label class="col-md-2 pad0"><?= $label ?></label>
    <div class="md-radio-inline col-md-10">
        <?php foreach ($values as $text => $value): ?>
            <div class="md-radio">

                <input type="radio" id="radio<?= $value ?>" name="<?= $name ?>" class="md-radiobtn"
                       value="<?= $value ?>" <?= $model->{$attribute} == $value ? 'checked' : '' ?>>
                <label for="radio<?= $value ?>">
                    <span></span>
                    <span class="check"></span>
                    <span class="box"></span>
                    <?= $text ?> </label>
            </div>
        <?php endforeach; ?>


    </div>
</div>