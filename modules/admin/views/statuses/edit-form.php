<form class="form-inline margin-bottom-40" role="form" action="" method="post" enctype="multipart/form-data"
      id="edit-form">
    <div class="form-group form-md-line-input has-success">
        <input type="text" class="form-control" id="edit-name-field" name="Status[description]">
        <div class="form-control-focus"></div>
    </div>


    <button type="button" class="btn btn-danger" onClick="update('#edit-form', modalUpdateCallback)">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</form>