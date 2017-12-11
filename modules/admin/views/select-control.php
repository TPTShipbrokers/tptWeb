<?php
/*
Parameters:

rows - options array
name - name for select control
multiple - true/false, wheter is a multiple choice or not
value - attribute name for option value
text - attribute name for option text

*/


?>

<select name="<?= $name ?>" class="form-control" <?= $multiple ? "multiple" : "" ?>>

    <?php foreach ($rows as $row): ?>

        <option value="<?= $row[$value] ?>" <?= isset($selected) && ($selected === $row[$value] || (is_array($selected) && in_array($row[$value], $selected))) ? "selected" : "" ?>><?= $row[$text] ?></option>

    <?php endforeach; ?>

</select>
