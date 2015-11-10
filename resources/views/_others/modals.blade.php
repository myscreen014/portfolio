
<!-- Modals use for administration
================================================== -->


<!-- Modal Default -->
<div class="modal " id="modal-default" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"><i class="fa fa-spinner fa-spin"></i></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.global.action.close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal files uploading -->
<div class="modal " id="modal-files-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('admin.files.title.upload') }}</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="button-cancel-upload" data-dismiss="modal">{{ trans('admin.global.action.close') }}</button>
                <button type="button" class="btn btn-success" id="button-start-upload">{{ trans('admin.files.action.upload') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal loading -->
<div class="modal " id="modal-loading">
	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h4 class="modal-title">Chargement...</h4>
      		</div>
      		<div class="modal-body">
        		<div class="progress">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    </div>
                </div>
      		</div>
    	</div>
  	</div>
</div>
