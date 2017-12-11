<?php
use yii\helpers\Url;

?>
<?= $this->render('/modal-template', ['id' => 'edit-modal', 'title' => 'Edit Company Details', 'content_template' => 'companies/edit-form']) ?>
<?= $this->render('/modal-template', ['id' => 'chartering-modal', 'title' => 'Assigned Chartering', 'content_template' => 'companies/company-relations-list', 'content_data' => ['rows' => [], 'remove_url' => Url::toRoute('companies/relation_remove'), 'pk' => 'chartering_id']]) ?>
<?= $this->render('/modal-template', ['id' => 'users-modal', 'title' => 'Assigned Users', 'content_template' => 'companies/company-relations-list', 'content_data' => ['rows' => [], 'remove_url' => Url::toRoute('companies/relation_remove'), 'pk' => 'user_id']]) ?>

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

        var modalSaveCallback = function () {
            toastr.success('Successfully assigned.');
            $(".modal").modal("hide");
            return false;
        }

        var modalUpdateCallback = function () {
            $("#edit-modal").modal("hide");
            toastr.success('Details successfully updated.');
            setTimeout(function () {
                document.location = "<?=$data['info']['index_url']?>";
            }, 3000);
        }


        function openEditModal($name, $action, $photo_url) {
            $("#edit-name-field").val($name)
            $("#edit-form").attr('action', $action);

            if ($photo_url === undefined)
                $("#edit-form .fileinput-new img").prop("src", "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image")
            else
                $("#edit-form .fileinput-new img").prop("src", "/tpt/" + $photo_url)

            $("#edit-modal").modal("show");
        }

        function openCharteringModal($action) {
            $.post($action, {}, function (data) {
                $('#chartering-modal #assigned-relations').html(data);
                $("#chartering-modal").modal("show");
            });
        }

        function openUsersModal($action) {
            $.post($action, {}, function (data) {
                $('#users-modal #assigned-relations').html(data);
                $("#users-modal").modal("show");
            });
        }

        function removeRelation($action, $pk, $id) {
            $.post($action, {'pk': $pk, 'id': $id}, function (data) {
                if (data.result == 'success') {
                    toastr.success('Relation is removed.');
                } else {
                    toastr.error(data.data.error_description);
                }

            });
        }
    </script>

<?= $this->render('/table-short', $data); ?>