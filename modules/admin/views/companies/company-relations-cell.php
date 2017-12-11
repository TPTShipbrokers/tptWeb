<?php
use yii\helpers\Url;

?>
<td>
    <a href="javascript:"
       onclick="openCharteringModal('<?= Url::toRoute('companies/chartering/' . $model['company_id']) ?>')"
       class=" btn btn-default"> View assigned chartering </a>
    <a href="javascript:" onclick="openUsersModal('<?= Url::toRoute('companies/users/' . $model['company_id']) ?>')"
       class=" btn btn-default"> View assigned users </a>
</td>
