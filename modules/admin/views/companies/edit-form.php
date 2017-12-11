<?php

?>
<form class="margin-bottom-40" role="form" action="" method="post" enctype="multipart/form-data" id="edit-form">

    <div class="form-group form-md-line-input has-success">
        <input type="text" class="form-control" id="edit-name-field" name="Company[company_name]">
        <div class="form-control-focus"></div>
        <label class="control-label" for="appuser-first_name">Company name</label>
    </div>

    <div class="form-group">
        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                <?php /*if(!$model->profile_picture):*/ ?>
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                <?php /*else: ?>
                    <img src="<?=Yii::$app->request->baseUrl?>/<?=$model->profile_picture?>" alt="" />
                <?php endif;*/ ?>
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail"
                 style="max-width: 200px; max-height: 150px;"></div>

            <div>
                <span class="btn default btn-file">
                    <span class="fileinput-new"> Select image </span>
                    <span class="fileinput-exists"> Change </span>
                    <div class="form-group field-company-profile_picture">

                        <input type="hidden" name="Company[profile_picture]" value=""><input type="file"
                                                                                             id="company-profile_picture"
                                                                                             name="Company[profile_picture]">

                        <p class="help-block help-block-error"></p>
                    </div> </span>
                <a href="javascript:" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-danger">Save</button>
    <?php /*<button type="button" class="btn btn-danger" onClick="update('#edit-form', modalUpdateCallback)">Save</button>*/ ?>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</form>