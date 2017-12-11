<?php
/*

Parameters:
id - modal id
title - modal title
content_template - Template for modal body
content_data - Data form modal content template

*/
?>
<!--  MODAL -->
<div class="modal fade" id="<?= $id ?>">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <!-- BEGIN PAGE TITLE-->
                <h3 class="page-title modal-title"> <?= $title ?>
                    <?php if (isset($subtitle)): ?>
                        <small><?= $subtitle ?></small>
                    <?php endif; ?>
                </h3>
                <!-- END PAGE TITLE-->
            </div>
            <div class="modal-body">

                <?= $this->render($content_template, isset($content_data) ? $content_data : []); ?>

            </div>
        </div>
    </div>
</div>