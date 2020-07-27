<div class="modal inmodal" id="gridview-viewaction" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?=  backend\vendors\Common::translateText('CLOSE_BTN_TEXT')?></span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJs(
   "$(document).ready(function () {
        $('#search-grid-pjax a[title=\"View\"]').on('click', function (e) {
            e.preventDefault();
            obj = $(this);
            $.get(obj.attr('href'), {}, function (data) {
                $('#gridview-viewaction .modal-body').html($(data).find('.detail-view'));
                $('#gridview-viewaction .modal-title').html($(data).find('.page-heading h2'));
                $('#gridview-viewaction').modal('show');
            });
        });
    });"
);
?>