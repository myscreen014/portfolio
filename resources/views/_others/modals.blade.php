
<!-- Modals use for administration
================================================== -->

<!-- Modal loading -->
<div class="modal " id="admin-modal-loading">
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

<!-- Modal formFile -->
<div class="modal " id="modal-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ trans('admin.files.title.edit') }}</h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.global.action.close') }}</button>
                <button type="button" id="modal-edit-submit" class="btn btn-primary">{{ trans('admin.global.action.save') }}</button>
            </div>
        </div>
    </div>
</div>