<?php

?>
<?= $this->render('/modal-template', ['id' => 'edit-modal', 'title' => 'Edit Status Details', 'content_template' => 'statuses/edit-form']) ?>

<?= $this->render('/table-short', $data); ?>

<script src="<?= Yii::$app->request->baseUrl ?>/media/layouts/templates/table-short.js"
        type="text/javascript"></script>

<script>

    var tableShort = new TableShort();

    $(document).ready(function () {

        tableShort.init();

        toastr.options.closeDuration = 50;
    });


    function save(id, callback) {
        tableShort.save(id, "<?=$data['info']['index_url']?>", callback);
    }

    function update(id, callback) {
        tableShort.save(id, "<?=$data['info']['index_url']?>", callback);
    }

    var modalUpdateCallback = function () {
        $("#edit-modal").modal("hide");
        toastr.success('Details successfully updated.');
        setTimeout(function () {
            document.location = "<?=$data['info']['index_url']?>";
        }, 3000);
    }


    function openEditModal($name, $action) {
        $("#edit-name-field").val($name);;
        $("#edit-form").attr('action', $action);
        $("#edit-modal").modal("show");
    }


</script>