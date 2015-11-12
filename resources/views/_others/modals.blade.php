
<!-- Modals use for administration
================================================== -->


<!-- Modal Default -->
<div class="modal fade modal-default mother" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"><div class="text-center"><i class="fa fa-spinner fa-spin"></i></div></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('admin.global.action.close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal files uploading -->
<div class="modal modal-files-upload mother" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('admin.files.title.upload') }}</h4>
            </div>
            <div class="modal-body">
                <table class="table table-upload">
                    <thead>
                        <tr>
                            <th class="upload-index">#</th>
                            <th class="upload-name">{{ trans('admin.files.field.name') }}</th>
                            <th class="upload-progress"></th>
                            <th class="upload-status"></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"  disabled="disabled" data-dismiss="modal">{{ trans('admin.global.action.close') }}</button>
                <button type="button" class="btn btn-success"  id="action-upload">{{ trans('admin.files.action.upload') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal loading -->
<div class="modal modal-loading mother" tabindex="-1" role="dialog">
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
