<?php if ($showStart): ?>
    <?= Form::open($formOptions) ?>
<?php endif; ?>

	<div class="row">
		@if($model->isPicture())
			<div class="col-xs-4">
				<label class="control-label">{{ trans('admin.file.label.preview') }}</label>
				<div>
					<img src="{{ route('picture', ['edit', $model->name]) }}" />				
				</div>
			</div>
			<div class="col-xs-8">
				<?php if ($showFields): ?>
				    <?php foreach ($fields as $field): ?>
				    	<?php if( ! in_array($field->getName(), $exclude) ) { ?>
				        	<?= $field->render() ?>
						<?php } ?>
				    <?php endforeach; ?>
				<?php endif; ?>
	        </div>
		@else
			<div class="col-xs-12">
				<?php if ($showFields): ?>
				    <?php foreach ($fields as $field): ?>
				    	<?php if( ! in_array($field->getName(), $exclude) ) { ?>
				        	<?= $field->render() ?>
						<?php } ?>
				    <?php endforeach; ?>
				<?php endif; ?>
	        </div>
		@endif
  	</div>

<?php if ($showEnd): ?>
    <?= Form::close() ?>
<?php endif; ?>
